<?php
//include_once 'HTML/Table.php';
if ($_REQUEST['id']) {
	$sheet = new Sheet($roster->GetPerson($_REQUEST['id']));
}

function title() {
	global $sheet;

	if (isset($sheet)) {
		$person = $sheet->GetPerson();
		return 'Administration :: Edit Character Sheet :: ' . $person->GetName();
	}
	else {
		return 'Administration :: Edit Character Sheets';
	}
}

function auth($person) {
	global $auth_data, $pleb, $roster, $sheet;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	if (isset($sheet)) {
		$s_pleb = $sheet->GetPerson();
		if ($s_pleb->GetID() != $person->GetID() && !$auth_data['cs']) {
			return false;
		}
		else {
			return true;
		}
	}
	else {
		return $auth_data['cs'];
	}
}

function output() {
	global $auth_data, $pleb, $page, $sheet, $sheet_db, $roster;

	roster_header();

	if (isset($sheet)) {
		$s_pleb = $sheet->GetPerson();
		$self_edit = ($s_pleb->GetID() == $pleb->GetID() && !$auth_data['cs']);
		$show_pending = ($sheet->GetStatus() != 'ok' && !$self_edit);
	}

	if ($self_edit && $sheet->GetStatus() != 'ok') {
		echo 'You cannot edit your Character Sheet when changes are awaiting approval by the Adjunct.';
		admin_footer($auth_data);
		return;
	}

	if ($_REQUEST['submit'] == 'Reject Changes') {
		if ($sheet->GetStatus() == 'new') {
			$sheet->MarkOK(false);
			mysql_query('UPDATE cs_sheets SET time=0 WHERE id=' . $_REQUEST['id'], $sheet_db);
		}
		else {
			$sheet->MarkOK(false);
		}
		echo 'Changes rejected.';
	}
	elseif (isset($_REQUEST['submit'])) {
		$error = false;

		// We have to update the highest position first, since otherwise
		// the generic bonus points will be wrong. Oops. Thanks to CB
		// for pointing that out.
		$gen_bp_avail = 0;
		switch ($_REQUEST['fields'][56]) {
			case 5:
				$gen_bp_avail = 5;
				break;
			case 6:
				$gen_bp_avail = 4;
				break;
			case 7:
				$gen_bp_avail = 3;
				break;
			case 8:
				$gen_bp_avail = 2;
				break;
			case 9:
				$gen_bp_avail = 1;
		}

		// Check bonus points first.
		$a_bonus[2] = $sheet->GetBonusPoints(2);
		$a_bonus[3] = $sheet->GetBonusPoints(3);
		$a_bonus[4] = $sheet->GetBonusPoints(4);
		$a_bonus[5] = $sheet->GetBonusPoints(5);
		$a_bonus[6] = $sheet->GetBonusPoints(6);
		$a_bonus[7] = $sheet->GetBonusPoints(7);
		$a_bonus[-1] = $sheet->GetBonusPoints(-1);

    /* Debug 

    $debug = new HTML_Table();

    $debug->addRow(array('Check Point',
                         'Field Class',
                         'Points to remove',
                         'Generic Points',
                         'Class 2',
                         'Class 3',
                         'Class 4',
                         'Class 5',
                         'Class 6',
                         'Class 7',
                         'Class -1'),
                    null,
                    'TH');

    $debug->addRow(array('Start of Processing',
                         '',
                         '',
                         $gen_bp_avail,
                         $a_bonus[2],
                         $a_bonus[3],
                         $a_bonus[4],
                         $a_bonus[5],
                         $a_bonus[6],
                         $a_bonus[7],
                         $a_bonus[-1]));

     Debug */
		foreach ($_REQUEST['bonus'] as $fid=>$points) {
			$result = mysql_query('SELECT * FROM cs_fields WHERE id=' . $fid, $sheet_db);
			$class = new SheetClass(mysql_result($result, 0, 'class'));
			if ($a_bonus[$class->GetID()] >= $points) {
				$a_bonus[$class->GetID()] -= $points;
			}
			elseif (($class->GetID() >= 4 && $class->GetID() <= 6)
              && ($a_bonus[-1] + $gen_bp_avail + $a_bonus[$class->getID()]) 
                    >= $points) {
        if ($a_bonus[$class->getID()] < $points) {
          $points -= $a_bonus[$class->getID()];
          $a_bonus[$class->getID()] = 0;
          if ($a_bonus[-1] < $points) {
            $points -= $a_bonus[-1];
            $a_bonus[-1] = 0;
            $gen_bp_avail -= $points;
          } else {
            $a_bonus[-1] -= $points;
          }
        } else {
          $a_bonus[$class->getID()] -= $points;
        }
			}
			elseif ($class->GetID() != 3) {
        $points -= $a_bonus[$class->getID()];
        $a_bonus[$class->getID()] = 0;
				$gen_bp_avail -= $points;
			}
			else {
				echo 'You have tried to use bonus points in a category you don\'t have any spare bonus points in.';
				$error = true;
			}
      
/*      $debug->addRow(array('Processed Field #'.$fid,
                           $class->getID(),
                           $points,
                           $gen_bp_avail,
                           $a_bonus[2],
                           $a_bonus[3],
                           $a_bonus[4],
                           $a_bonus[5],
                           $a_bonus[6],
                           $a_bonus[7],
                           $a_bonus[-1]));*/

		}
		if ($gen_bp_avail < 0) {
			echo 'You have used ' . abs($gen_bp_avail) . ' more bonus point' . ($gen_bp_avail != -1 ? 's' : '') . ' than you have available.';
			$error = true;
		}
//    print $debug->toHtml();

		// Some nasty checking code will follow. Basically, we iterate
		// through the various fields, doing special-case checking as
		// we go. There's a *lot* of special-case checking.
		$class_totals = array();
		$fields = $sheet->GetFields();
		foreach ($fields as $id=>$field) {
			// This is the first, checking pass only.
			$class = $field->GetClass();
			if ($class->GetID() == 1 || $class->GetID() >= 8) {
				// These are all textual and require no
				// checking.
			}
			elseif ($class->GetLimit() > 0) {
				// These are numeric classes with in-built
				// limits.
				$class_totals[$class->GetID()] += $_REQUEST['fields'][$id];
				if ($class_totals[$class->GetID()] > $class->GetLimit()) {
					echo 'You have used more points in the ' . $class->GetName() . ' class than you are permitted to.<br>';
					$error = true;
				}
				if (($_REQUEST['fields'][$id] + $_REQUEST['bonus'][$id]) > $field->GetLimit()) {
					echo 'You have used more points in the ' . $field->GetName() . ' field than you are permitted to.<br>';
					$error = true;
				}
			}
			else {
				// These are abilities classes. We'll simply
				// add up the class totals for now, and will do
				// the checking after this pass, since we need
				// to know the totals in order to check.
				$class_totals[$class->GetID()] += $_REQUEST['fields'][$id];
				if ((($_REQUEST['fields'][$id] + $_REQUEST['bonus'][$id]) > $field->GetLimit()) || $_REQUEST['fields'][$id] > 3) {
					echo 'You have used more points in the ' . $field->GetName() . ' field than you are permitted to.<br>';
					$error = true;
				}
			}
		}

		// Now we'll check the totals in the abilities classes.
		$thirteen = false;
		$nine = false;
		$five = false;
		foreach ($class_totals as $cid=>$points) {
			$class = new SheetClass($cid);
			if ($cid >= 4 && $cid <= 6) {
				if ($points <= 5) {
					if ($five == false) {
						$five = true;
					}
					elseif ($nine == false) {
						$nine = true;
					}
					else {
						$thirteen = true;
					}
				}
				elseif ($points <= 9) {
					if ($nine == false) {
						$nine = true;
					}
					elseif ($thirteen == false) {
						$thirteen = true;
					}
					else {
						echo 'You have too many points in the ' . $class->GetName() . ' class.<br>';
						$error = true;
					}
				}
				elseif ($points <= 13) {
					if ($thirteen == true) {
						echo 'You have too many points in the ' . $class->GetName() . ' class.<br>';
						$error = true;
					}
					else {
						$thirteen = true;
					}
				}
				else {
					echo 'You have too many points in the ' . $class->GetName() . ' class.<br>';
					$error = true;
				}
			}
		}

		// OK, if there's no errors, let's commit this to the database.
		if ($error == false) {
			foreach ($fields as $id=>$field) {
				if ($field->GetType() == 'text') {
					$field->ChangeText($_REQUEST['fields'][$id]);
				}
				elseif ($field->GetType() == 'dropdown') {
					$field->ChangeOption($_REQUEST['fields'][$id]);
				}
				else {
					$field->ChangePoints($_REQUEST['fields'][$id], $_REQUEST['bonus'][$id]);
				}
			}

			if ($self_edit) {
				if ($sheet->GetLastUpdate() == 0) {
					$sheet->MarkNew();
				}
				else {
					$sheet->MarkChanged();
				}
			}
			else {
				$sheet->MarkOK(true);
			}
			echo 'Changes saved succesfully.';
		}
	}
	elseif ($_REQUEST['purchase']) {
		$xp = $sheet->GetUnusedXP();
		$cost = array('-1'=>400, 7=>500, 2=>2250, 3=>2500);
		if ($cost[$_REQUEST['purchase']] > $xp || !in_array($_REQUEST['purchase'], array_keys($cost))) {
			echo 'You do not have sufficient XP to purchase a point in that class.';
		}
		else {
			$sheet->PurchaseBonusPoint($_REQUEST['purchase'], $cost[$_REQUEST['purchase']]);
			echo 'Bonus point purchased.';
		}
	}
	elseif (isset($sheet)) {
		echo '<b>Note</b>: Before creating a character sheet, you should read the guide to creating a CS at <a href="http://adjunct.thebhg.org/">the Office of the Overseer</a>. If you make a mistake or ask a question that is covered in the guide, we reserve the right to point, laugh, and generally be completely unhelpful.<br><br>Have a nice day.';

		hr();
		
		$xp = $sheet->GetUnusedXP();
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->table->StartRow();
		$form->table->AddHeader('Experience Points', 2);
		$form->table->EndRow();
		$form->table->AddRow('Available', number_format($xp));
		if ($xp >= 400) {
			$form->StartSelect('Purchase', 'purchase');
			$form->AddOption('-1', 'One point in Abilities (400 XP)');
			if ($xp >= 500) {
				$form->AddOption(7, 'One point in History (500 XP)');
				if ($xp >= 2250) {
					$form->AddOption(2, 'One point in Physical Attributes (2250 XP)');
					if ($xp >= 2500) {
						$form->AddOption(3, 'One point in Mental Attributes (2500 XP)');
					}
				}
			}
			$form->EndSelect();
			$form->AddSubmitButton('', 'Purchase Bonus Point');
		}
		$form->EndForm();

		hr();

		$gen_avail = $sheet->GetBonusPoints(0);
		$abil_avail = $sheet->GetBonusPoints(-1);

		$table = new Table();
		$table->StartRow();
		$table->AddHeader('Bonus Points');
		$table->AddHeader('Total');
		$table->AddHeader('Available');
		$table->EndRow();
		$result = mysql_query('SELECT SUM(cs_bonus_points.points) AS total FROM cs_bonus_points, cs_classes, cs_fields WHERE cs_classes.id=cs_fields.class AND cs_bonus_points.field=cs_fields.id AND cs_classes.id=2 AND cs_bonus_points.person=' . $_REQUEST['id'], $sheet_db);
		$used = $sheet->GetBonusPoints(2) - mysql_result($result, 0, 'total');
		if ($used < 0) {
			$gen_avail += $used;
			$used = 0;
		}
		$table->AddRow('Physical Attributes', $sheet->GetBonusPoints(2), $used);
		$result = mysql_query('SELECT SUM(cs_bonus_points.points) AS total FROM cs_bonus_points, cs_classes, cs_fields WHERE cs_classes.id=cs_fields.class AND cs_bonus_points.field=cs_fields.id AND cs_classes.id=3 AND cs_bonus_points.person=' . $_REQUEST['id'], $sheet_db);
		$used = $sheet->GetBonusPoints(3) - mysql_result($result, 0, 'total');
		$table->AddRow('Mental Attributes', $sheet->GetBonusPoints(3), $used);
		$result = mysql_query('SELECT SUM(cs_bonus_points.points) AS total FROM cs_bonus_points, cs_classes, cs_fields WHERE cs_classes.id=cs_fields.class AND cs_bonus_points.field=cs_fields.id AND cs_classes.id=4 AND cs_bonus_points.person=' . $_REQUEST['id'], $sheet_db);
		$used = $sheet->GetBonusPoints(4) - mysql_result($result, 0, 'total');
		if ($used < 0) {
			if (abs($used) <= $abil_avail) {
				$abil_avail += $used;
			}
			else {
				$used += $abil_avail;
				$abil_avail = 0;
				$gen_avail += $used;
			}
			$used = 0;
		}
		$table->AddRow('Talents', $sheet->GetBonusPoints(4), $used);
		$result = mysql_query('SELECT SUM(cs_bonus_points.points) AS total FROM cs_bonus_points, cs_classes, cs_fields WHERE cs_classes.id=cs_fields.class AND cs_bonus_points.field=cs_fields.id AND cs_classes.id=5 AND cs_bonus_points.person=' . $_REQUEST['id'], $sheet_db);
		$used = $sheet->GetBonusPoints(5) - mysql_result($result, 0, 'total');
		if ($used < 0) {
			if (abs($used) <= $abil_avail) {
				$abil_avail += $used;
			}
			else {
				$used += $abil_avail;
				$abil_avail = 0;
				$gen_avail += $used;
			}
			$used = 0;
		}
		$table->AddRow('Skills', $sheet->GetBonusPoints(5), $used);
		$result = mysql_query('SELECT SUM(cs_bonus_points.points) AS total FROM cs_bonus_points, cs_classes, cs_fields WHERE cs_classes.id=cs_fields.class AND cs_bonus_points.field=cs_fields.id AND cs_classes.id=6 AND cs_bonus_points.person=' . $_REQUEST['id'], $sheet_db);
		$used = $sheet->GetBonusPoints(6) - mysql_result($result, 0, 'total');
		if ($used < 0) {
			if (abs($used) <= $abil_avail) {
				$abil_avail += $used;
			}
			else {
				$used += $abil_avail;
				$abil_avail = 0;
				$gen_avail += $used;
			}
			$used = 0;
		}
		$table->AddRow('Knowledges', $sheet->GetBonusPoints(6), $used);
		$table->AddRow('General Abilities', $sheet->GetBonusPoints(-1), $abil_avail);
		$result = mysql_query('SELECT SUM(cs_bonus_points.points) AS total FROM cs_bonus_points, cs_classes, cs_fields WHERE cs_classes.id=cs_fields.class AND cs_bonus_points.field=cs_fields.id AND cs_classes.id=7 AND cs_bonus_points.person=' . $_REQUEST['id'], $sheet_db);
		$used = $sheet->GetBonusPoints(7) - mysql_result($result, 0, 'total');
		if ($used < 0) {
			$gen_avail += $used;
			$used = 0;
		}
		$table->AddRow('History', $sheet->GetBonusPoints(7), $used);
		$table->AddRow('Generic', $sheet->GetBonusPoints(0), $gen_avail);
		$table->EndTable();
		
		hr();
		
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$fields = $sheet->GetFields();
		$last_class = 0;
		foreach ($fields as $fid=>$field) {
			$class = $field->GetClass();
			if ($last_class != $class->GetID()) {
				$last_class = $class->GetID();
				$form->table->StartRow();
				$str = $class->GetName();
				if ($class->GetLimit()) {
					$str .= ' (Limit: ' . $class->GetLimit() . ' points)';
				}
				if ($class->GetHelp()) {
					$str .= ' <a href="' . internal_link('cs_class_help', array('id'=>$class->GetID())) . '">(Help)</a>';
				}
				$form->table->AddHeader($str, $show_pending ? 5 : 4);
				$form->table->EndRow();
				$form->table->StartRow();
				$form->table->AddHeader('Field');
				$form->table->AddHeader('Limit');
				if ($show_pending) {
					$form->table->AddHeader('Current Value');
				}
				$form->table->AddHeader('Points');
				$form->table->AddHeader('Bonus Points');
				$form->table->EndRow();
			}
			$form->table->StartRow();
			$name = $field->GetName();
			if ($field->GetHelp()) {
				$name .= ' <a href="' . internal_link('cs_field_help', array('id'=>$field->GetID())) . '">(Help)</a>';
			}
			$background = false;
			if ($show_pending) {
				$pending_result = mysql_query('SELECT * FROM cs_pending_fields WHERE person=' . $_REQUEST['id'] . ' AND field=' . $fid, $sheet_db);
				$prow = mysql_fetch_array($pending_result);
				if ($field->GetRealValue() != $prow['value'] || $field->GetBonusPoints() != $prow['bonus']) {
					$background = '#3fff3f';
				}
			}
			if ($field->GetType() == 'int') {
				$form->table->AddCell($name, 1, 1, -1, $background);
				$form->table->AddCell($field->GetLimit());
				if ($show_pending) {
					$form->table->AddCell($field->GetValue());
					$form->table->AddCell('<input type="text" name="fields[' . $fid . ']" size=3 value="' . $prow['value'] . '">');
					$form->table->AddCell('<input type="text" name="bonus[' . $fid . ']" size=3 value="' . $prow['bonus'] . '">');
				}
				else {
					$form->table->AddCell('<input type="text" name="fields[' . $fid . ']" size=3 value="' . $field->GetRealValue() . '">');
					$form->table->AddCell('<input type="text" name="bonus[' . $fid . ']" size=3 value="' . $field->GetBonusPoints() . '">');
				}
			}
			elseif ($field->GetType() == 'text') {
				$form->table->AddCell($name, 2, 1, -1, $background);
				if ($show_pending) {
					$form->table->AddCell($field->GetValue());
					$form->table->AddCell('<textarea name="fields[' . $fid . ']" rows=5 cols=60>' . html_escape(stripslashes($prow['value'])) . '</textarea>', 2);
				}
				else {
					$form->table->AddCell('<textarea name="fields[' . $fid . ']" rows=5 cols=60>' . html_escape($field->GetValue()) . '</textarea>', 2);
				}
			}
			else {
				$form->table->AddCell($name, 2, 1, -1, $background);
				$str = '<select name="fields[' . $fid . ']" size=1>';
				$options = $field->GetOptions();
				foreach ($options as $id=>$option) {
					$str .= '<option value="' . $id . '"';
					if ($show_pending) {
						if ($id == $prow['value']) {
							$str .= ' selected';
						}
					}
					else {
						if ($id == (int) $field->GetRealValue()) {
							$str .= ' selected';
						}
					}
					$str .= '>' . html_escape($option) . '</option>';
				}
				$str .= '</select>';
				if ($show_pending) {
					$form->table->AddCell($field->GetValue());
				}
				$form->table->AddCell($str, 2);
			}
			$form->table->EndRow();
		}
		$form->table->StartRow();
		$form->table->AddCell('<div style="text-align: right"><input type="reset">' . ($show_pending ? '&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Reject Changes">' : '') . '&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Save Character Sheet"></div>', $show_pending ? 5 : 4);
		$form->table->EndRow();

		$form->EndForm();
	}
	else {
		$table = new Table();
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Last Update');
		$table->AddHeader('Status');
		$table->AddHeader('&nbsp;');
		$table->EndRow();
		$result = mysql_query('SELECT person, status, time FROM cs_sheets WHERE time>0 ORDER BY status DESC, time DESC', $sheet_db);
		while ($row = mysql_fetch_array($result)) {
			$author = $roster->GetPerson($row['person']);
			$table->AddRow('<a href="' . internal_link('hunter', array('id'=>$row['person'])) . '">' . $author->GetName() . '</a>', '<a href="' . internal_link('character_sheet', array('id'=>$row['person'])) . '">' . date('j F Y', $row['time']) . '</a>', ucwords($row['status']), '<a href="' . internal_link($page, array('id'=>$row['person'])) . '">Edit</a>');
		}
		$table->EndTable();
	}
	
	admin_footer($auth_data);
}
?>

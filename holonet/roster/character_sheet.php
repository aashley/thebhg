<?php
$sheet = new Sheet($roster->GetPerson($_REQUEST['id']));

function title() {
	global $sheet;
	
	$pleb = $sheet->GetPerson();
	return 'Character Sheet :: ' . $pleb->GetName();
}

function output() {
	global $sheet, $roster, $sheet_db;
	
	roster_header();

	if ($sheet->GetLastUpdate() && $sheet->GetStatus() != 'new') {
		if ($sheet->GetStatus() == 'changed') {
			echo 'Changes have been made to this character sheet, but are awaiting Adjunct approval.';
			hr();
		}
	
		$table = new Table();
		
		$last_class = 0;
		foreach ($sheet->GetFields() as $field) {
			$class = $field->GetClass();
			if ($last_class != $class->GetID()) {
				if ($last_class == 8 || $last_class == 9) {
					$table->StartRow();
					if ($last_class == 8) {
						$table->AddCell('Merits');
					}
					else {
						$table->AddCell('Flaws');
					}
					if ($pending) {
						$table->AddCell(implode('<br>', $pending), 2);
						unset($pending);
					}
					else {
						$table->AddCell('None', 2);
					}
					$table->EndRow();
				}
				$last_class = $class->GetID();
				$table->StartRow();
				$table->AddHeader($class->GetName() . ($class->GetHelp() ? ' <a href="' . internal_link('cs_class_help', array('id'=>$class->GetID())) . '">(Help)</a>' : ''), 3);
				$table->EndRow();
				if ($class->GetID() == 1) {
					$pleb = $sheet->GetPerson();
					$div = $pleb->GetDivision();
					$pos = $pleb->GetPosition();
					$table->StartRow();
					$table->AddCell('Name');
					$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$pleb->GetID())) . '">' . $pleb->GetName() . '</a>', 2);
					$table->EndRow();
					
					$table->StartRow();
					$table->AddCell('Division');
					$table->AddCell('<a href="' . internal_link('division', array('id'=>$div->GetID())) . '">' . $div->GetName() . '</a>', 2);
					$table->EndRow();
					
					$table->StartRow();
					$table->AddCell('Position');
					$table->AddCell('<a href="' . internal_link('position', array('id'=>$pos->GetID())) . '">' . $pos->GetName() . '</a>', 2);
					$table->EndRow();
				}
			}
			if ($class->GetID() == 8 || $class->GetID() == 9) {
				if ($field->GetRealValue()) {
					$pending[] = $field->GetValue();
				}
			}
			else {
				if ($field->GetType() == 'int') {
					$str = str_repeat('<img src="roster/images/X.png" alt="X" height=20 width=20>', $field->GetRealValue());
					$str .= str_repeat('<img src="roster/images/bonus.png" alt="*" height=20 width=20>', $field->GetBonusPoints());
					$str .= str_repeat('<img src="roster/images/0.png" alt="0" height=20 width=20>', $field->GetLimit() - $field->GetRealValue() - $field->GetBonusPoints());
					$table->StartRow();
					$table->AddCell($field->GetName() . ($field->GetHelp() ? ' <a href="' . internal_link('cs_field_help', array('id'=>$field->GetID())) . '">(Help)</a>' : ''));
					$table->AddCell($str, 2);
					$table->EndRow();
				}
				else {
					$table->StartRow();
					$table->AddCell($field->GetName() . ($field->GetHelp() ? ' <a href="' . internal_link('cs_field_help', array('id'=>$field->GetID())) . '">(Help)</a>' : ''));
					$table->AddCell(nl2br(html_escape($field->GetValue())), 2);
					$table->EndRow();
				}
			}
		}

		$table->StartRow();
		$table->AddHeader('Experience Points', 3);
		$table->EndRow();
		$table->StartRow();
		$table->AddCell('Available');
		$table->AddCell($sheet->GetUnusedXP(), 2);
		$table->EndRow();
		
		$gen_avail = $sheet->GetBonusPoints(0);
		$abil_avail = $sheet->GetBonusPoints(-1);

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

		$table = new Table();
		$table->StartRow();
		$table->AddHeader('Legend', 2);
		$table->EndRow();
		$table->AddRow('<img src="roster/images/X.png" alt="X" height=20 width=20>', 'Normal point');
		$table->AddRow('<img src="roster/images/bonus.png" alt="*" height=20 width=20>', 'Bonus point');
		$table->AddRow('<img src="roster/images/0.png" alt="0" height=20 width=20>', 'No point');
		$table->EndTable();
	}
	elseif ($sheet->GetStatus() == 'new') {
		echo 'This person\'s character sheet has yet to be approved by the Adjunct.';
	}
	else {
		echo 'This person does not have a character sheet.';
	}

	roster_footer();
}

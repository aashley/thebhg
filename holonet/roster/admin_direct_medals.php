<?php
// Set the number of displayed fields here.
$fields = 10;

function next_medal($person, $group) {
	global $mb;

	$mg = $mb->GetMedalGroup($group);
	if ($mg->GetDisplayType() != 0) {
		echo 'Numeric medal, leaving immediately.<br>';
		$medals = $mg->GetMedals();
		return $medals[0];
	}
	
	$medals = $person->GetMedals();
	if (count($medals)) {
		$orders = array();
		$group_medals = $mg->GetMedals();
		foreach ($group_medals as $medal) {
			$orders[$medal->GetOrder()] = 0;
		}
		foreach ($medals as $am) {
			$medal = $am->GetMedal();
			$mgroup = $medal->GetGroup();
			if ($mgroup->GetID() == $group) {
				$orders[$medal->GetOrder()]++;
			}
		}
		ksort($orders);
		$last = 0;
		foreach ($orders as $key=>$o) {
			if ($o < $last) {
				$order = $key;
				break;
			}
			$last = $o;
		}
		if (empty($order)) {
			$order = min(array_keys($orders));
		}
		
		$medals = $mg->GetMedals();
		foreach ($medals as $medal) {
			if ($medal->GetOrder() == $order) {
				return $medal;
			}
		}
		return $medals[0];
	}
	else {
		$medals = $mg->GetMedals();
		return $medals[0];
	}
}

function title() {
	return 'Administration :: Directly Award Medals';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['underlord'];
}

function output() {
	global $auth_data, $pleb, $roster, $page, $mb, $fields, $prefix, $module;

	$pos = $pleb->GetPosition();
	$div = $pleb->GetDivision();

	roster_header();

	if ($_REQUEST['submit']) {
		for ($i = 0; $i < $fields; $i++) {
			$byperson = "byperson$i";
			$person = "person$i";
			$medal = "medal$i";
			$reason = "reason$i";
			if ($_REQUEST[$person] <= 0 || empty($_REQUEST[$medal]) || $_REQUEST[$medal] == 0) {
				continue;
			}

			if ($_REQUEST[$byperson] == -1)
				$awarder = $pleb;
			else
				$awarder = $roster->GetPerson($_REQUEST[$byperson]);

			$awardee = $roster->GetPerson($_REQUEST[$person]);
			$next = next_medal($awardee, $_REQUEST[$medal]);
			if ($mb->AwardMedal($awardee, $awarder, $next, $_REQUEST[$reason]))
				printf('%s awarded to %s by %s.<br />', $next->GetName(), htmlspecialchars($awardee->GetName()), htmlspecialchars($awarder->GetName()));
			else
				printf('Error awarding %s to %s.<br />', $next->GetName(), htmlspecialchars($awardee->GetName()));
		}
	}

	$mb_cat = $mb->GetMedalCategories();
	foreach ($mb_cat as $cat) {
		$mb_gp = $cat->GetMedalGroups();
		foreach ($mb_gp as $group) {
			$medals[$group->GetID()] = ('<option value="' . $group->GetID() . '">' . $group->GetName() . '</option>');
		}
	}

	$kabals_result = $roster->GetDivisions();
	$kabals = array();
	foreach ($kabals_result as $kabal) {
			if ($kabal->GetID() != 9 && $kabal->GetID() != 16) {
		$kabals[$kabal->GetName()] = "<option value=\"" . $kabal->GetID() . "\">" . $kabal->GetName() . "</option>\n";
			}
	}
	$kabals = implode('', $kabals);
	?>
	<script language="JavaScript1.1" type="text/javascript">
	<!--
	function person(id, name) {
		this.id = id;
		this.name = name;
	}

	<?php
	reset($kabals_result);
	$commindex = 0;
	foreach ($kabals_result as $kabal) {
		if ($kabal->GetID() == 16) {
			continue;
		}
		echo 'roster' . $kabal->GetID() . " = new Array();\n";
		$plebs = $kabal->GetMembers('name');
		if (is_array($plebs)) {
			$plebindex = 0;
		foreach ($plebs as $pleb) {
			$div_peeps[$pleb->GetName().':'.$plebindex] = 'roster' . (($kabal->GetID() == 9) ? '10' : $kabal->GetID()) . '[' . (($kabal->GetID() == 9 || $kabal->GetID() == 10) ? $commindex++ : $plebindex++) . '] = new person(' . $pleb->GetID() . ', \'' . str_replace("'", "\\'", shorten_string($pleb->GetName(), 40)) . "');\n";
		}
//			ksort($div_peeps);
		echo implode('', $div_peeps);
		unset($div_peeps);
		}
	}
	?>

	function swap_kabal(frm, kabal, person, id) {
		var kabal_list = eval("frm." + kabal + id);
		var person_list = eval("frm." + person + id);
		var kabal = kabal_list.options[kabal_list.options.selectedIndex].value;
		if (kabal > 0) {
			var kabal_array = eval("roster" + kabal);
			var new_length = kabal_array.length;
			person_list.options.length = new_length;
			for (i = 0; i < new_length; i++) {
				person_list.options[i] = new Option(kabal_array[i].name, kabal_array[i].id, false, false);
			}
		}
		else {
			person_list.options.length = 1;
			person_list.options[0] = new Option("N/A", -1, false, false);
		}
	}

	// -->
	</script>
	<noscript>
	This page requires JavaScript to function properly.
	</noscript>
	<form name="award" method="post" action="<?=$PHP_SELF?>">
	<input type="hidden" name="module" value="<?=$module?>">
	<input type="hidden" name="page" value="<?=$page?>">
	<?php
	$table = new Table('', true);
	for ($i = 0; $i < $fields; $i++) {
		$table->StartRow();
		$table->AddCell('&nbsp;');
		$table->AddCell("<select name=\"kabal$i\" onChange=\"swap_kabal(this.form, 'kabal', 'person', $i)\"><option value=\"-1\">N/A</option>$kabals</select>");
		$cell = "<select name=\"person$i\">";
		$cell .= "<option value=\"-1\">N/A</option>";
		$cell .= '</select>';
		$table->AddCell($cell);
		$table->AddCell("<select name=\"medal$i\" size=1>" . implode("\n", $medals) . "</select>");
		$table->AddCell("for <input name=\"reason$i\" type=\"text\" size=20>");
		$table->EndRow();

		$table->StartRow();
		$table->AddCell('Awarded By:');
		$table->AddCell("<select name=\"bykabal$i\" onChange=\"swap_kabal(this.form, 'bykabal', 'byperson', $i)\"><option value=\"-1\">N/A</option>$kabals</select>");
		$cell = "<select name=\"byperson$i\">";
		$cell .= "<option value=\"-1\">N/A</option>";
		$cell .= '</select>';
		$table->AddCell($cell);
		$table->AddCell("&nbsp;", 2);
		$table->EndRow();

		$table->StartRow();
		$table->AddCell('&nbsp;', 5);
		$table->EndRow();
	}
	$table->EndTable();
	?>
	<input type="submit" value="Award Medals" class="button" name="submit">&nbsp;<input type="reset" class="button">
	</form>
	<?php

	admin_footer($auth_data);
}
?>

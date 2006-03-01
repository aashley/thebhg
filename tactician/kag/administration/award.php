<?php
include_once('header.php');

page_header('Award KAG Credits/Medals');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		// Transfer any current Badges to Pins.
		mysql_query('UPDATE mb_awarded_medals SET medal=' . $medal_groups['pos'] . ' WHERE medal=' . $medal_groups['bos'], $roster->roster_db);

		$kag =& $ka->GetKAG($_REQUEST['kag']);
		$awards = array();
		foreach ($kag->GetEvents() as $event) {
			$signups =& $event->GetSignups();
			if ($signups) {
				foreach ($event->GetSignups() as $signup) {
					$pleb =& $signup->GetPerson();
					if (empty($awards[$pleb->GetID()])) {
						$awards[$pleb->GetID()] = array('ms'=>0, 'credits'=>0, 'person'=>&$pleb, 'kabal'=>$signup->GetKabal());
					}
					$awards[$pleb->GetID()]['credits'] += $signup->GetCredits();
					if ($signup->GetState() == 1 && $signup->GetRank() == 1) {
						$awards[$pleb->GetID()]['ms']++;

						// Award the MS.
						$mb->AwardMedal($pleb, $judicator, next_medal($mb, $pleb, $medal_groups['ms']), 'first place in ' . $event->GetName() . ' in KAG ' . roman($_REQUEST['kag']), 0);
					}
				}
			}
		}

		// Work out which kabal won the BoS.
		$kabals = $kag->GetKabalTotals();
		$winner = key($kabals);
		
		// Output the results.
		$table = new Table('', true);
		$table->StartRow();
		$table->AddCell('All credits and medals have been awarded.', 5);
		$table->EndRow();
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Kabal');
		$table->AddHeader('Credits');
		$table->AddHeader('Master\'s Shields');
		$table->AddHeader('Badge of Supremacy?');
		$table->EndRow();
		foreach ($awards as $award) {
			$table->StartRow();
			$table->AddCell($award['person']->GetName());
			$table->AddCell($award['kabal']->GetName());
			$table->AddCell('<div style="text-align: right">' . number_format($award['credits']) . '</div>');
			$table->AddCell($award['ms']);
			$table->AddCell($winner == $award['kabal']->GetID() ? 'Yes' : 'No');
			$table->EndRow();

			if ($winner == $award['kabal']->GetID()) {
				// Award the Badge.
				$mb->AwardMedal($award['person'], $judicator, 5, $award['kabal']->GetName() . ' coming first in KAG ' . roman($_REQUEST['kag']));
				echo $mb->Error();
			}

			// Award the credits.
			$person =& $roster->GetPerson($award['person']->GetID());
			$person->AddCredits($award['credits'], 'participation in KAG ' . roman($_REQUEST['kag']));
		}
		$table->EndTable();
	}
	else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->StartSelect('KAG:', 'kag');
		foreach (array_reverse($ka->GetKAGs()) as $kag) {
			$form->AddOption($kag->GetID(), roman($kag->GetID()));
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Award Credits/Medals');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>

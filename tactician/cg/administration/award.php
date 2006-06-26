<?php
include_once('header.php');

page_header('Award CG Credits/Medals');

if ($level == 3) {
	if ($_REQUEST['submit']) {
		$cg =& $ka->GetCG($_REQUEST['cg']);
		$awards = array();
		foreach ($cg->GetEvents() as $event) {
			if ($event->isTeam())
				continue;
			$signups =& $event->GetSignups();
			if ($signups) {
				foreach ($event->GetSignups() as $signup) {
					$pleb =& $signup->GetPerson();
					if (empty($awards[$pleb->GetID()])) {
						$awards[$pleb->GetID()] = array('ms'=>0, 'credits'=>0, 'person'=>&$pleb, 'cadre'=>$signup->GetCadre());
					}
					$awards[$pleb->GetID()]['credits'] += $signup->GetCredits();
					if ($signup->GetState() == 1 && $signup->GetRank() == 1) {
						$awards[$pleb->GetID()]['ms']++;

						// Award the MS.
						$mb->AwardMedal($pleb, $judicator, next_medal($mb, $pleb, $medal_groups['ms']), 'first place in ' . $event->GetName() . ' in CG ' . roman($_REQUEST['cg']), 0);
					}
				}
			}
		}

		// Work out which cadre won the CB.
		$cadres = $cg->GetCadreTotals();
		$winner = key($cadres);
		
		// Output the results.
		$table = new Table('', true);
		$table->StartRow();
		$table->AddCell('All credits and medals have been awarded.', 5);
		$table->EndRow();
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Cadre');
		$table->AddHeader('Credits');
		$table->AddHeader('Master\'s Shields');
		$table->AddHeader('Cadre Blade?');
		$table->EndRow();

		//CB object
		$cb_obj = $mb->GetMedal(17);
		foreach ($awards as $award) {
			$table->StartRow();
			$table->AddCell($award['person']->GetName());
			$table->AddCell($award['cadre']->GetName());
			$table->AddCell('<div style="text-align: right">' . number_format($award['credits']) . '</div>');
			$table->AddCell($award['ms']);
			$table->AddCell($winner == $award['cadre']->GetID() ? 'Yes' : 'No');
			$table->EndRow();

			if ($winner == $award['cadre']->GetID()) {
				// Award the CB.
				$mb->AwardMedal($award['person'], $judicator, next_medal($mb, $award['person'], $medal_groups['cb']), $award['cadre']->GetName() . ' coming first in CG ' . roman($_REQUEST['cg']), 0);
				echo $mb->Error();
			}

			// Award the credits.
			$person =& $roster->GetPerson($award['person']->GetID());
			$person->AddCredits($award['credits'], 'participation in CG ' . roman($_REQUEST['cg']));
		}
		$table->EndTable();
	}
	else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->StartSelect('CG:', 'cg');
		foreach (array_reverse($ka->GetCGs()) as $cg) {
			$form->AddOption($cg->GetID(), roman($cg->GetID()));
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

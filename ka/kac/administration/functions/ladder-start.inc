<?php

function output(){
	global $ka;
	
	if ($_REQUEST['submit']){
		$ladder = new Ladder($_REQUEST['kac']);
		if (!$ladder->RoundBrackets()){
			if ($ladder->SetOpeningKabals()){
				echo 'Kabals have been imported into the KAC Mainframe.';
			} else {
				echo $ladder->Error();
			}
		} else {
			echo 'Hooray! There are brackets already done for this KAC.';
		}
		hr();
	} else {	
		$form = new Form($_SERVER['PHP_SELF']);
		
		$form->AddSectionTitle('Select Season to Import Kabal Data');
		
		$form->StartSelect('Select KAC', 'kac');
		foreach ($ka->GetSeasons() as $type){
			$form->AddOption($type->GetSeasonID(), 'Season '.roman($type->GetID()));
		}
		$form->EndSelect();
		
		$form->AddSubmitButton('submit', 'Import Kabal Data');
		$form->EndForm();

	}
	
	
}

?>
<?php

function output(){
	global $ka, $mb, $reward_blurb;
	
	if ($_REQUEST['delete']){
		
		if (isset($_REQUEST['award'])){
			
			$award = new Awards($_REQUEST['award']);
			
			if ($award->DeleteHandler($_REQUEST['del_flag'])){
				echo 'Award successfully '.strtolower($_REQUEST['del_flag']).'d.';
			} else {
				echo $award->Error();
			}
			
		} else {
			echo 'Error passing the required award field';
		}
		
	} elseif ($_REQUEST['submit']){
		
		if (isset($_REQUEST['award'])){
			
			$award = new Awards($_REQUEST['award']);
		
			$edits = Array('point_high'=>$_REQUEST['point_high'], 'point_low'=>$_REQUEST['point_low'], 'default_points'=>$_REQUEST['default_points'],
						'points'=>$_REQUEST['points'], 'correct'=>$_REQUEST['correct'], 'credits'=>$_REQUEST['credits'], 'medal'=>$_REQUEST['medal']);
			
			$edit_errors = 0;
											
			foreach ($edits as $table=>$value){
				if (!$award->SetPiece($table, $value)){
					$edit_errors++;
				}
			}
			
			if ($edit_errors){
				echo $edit_errors.' errors were made when trying to complete the Edit. Please tell a Coder as soon as possible.';
				echo '<br /><br />'.$award->Error();
			} else {
				echo 'Award Type edited successfully.';
			}
			
		} else {
			echo 'Error passing the required event award';
		}
		
	} elseif ($_REQUEST['next']){
	
		if (isset($_REQUEST['award'])){
			$award = new Awards($_REQUEST['award']);
			
			$form = new Form($_SERVER['PHP_SELF']);
			
			$form->AddSectionTitle('Award Delete Management');
			
			if ($award->Deleted('CHECK')){
				$prefix = 'This award is currently listed as <b>ACTIVE</b>';
				$button = 'Delete';
				$form->AddHidden('del_flag', 'DELETE');
			} else {
				$prefix = 'This award was <b>DELETED</b> on '.$award->Deleted('HUMAN');
				$button = 'Undelete';
				$form->AddHidden('del_flag', 'UNDELETE');
			}
			
			$form->AddHidden('award', $_REQUEST['award']);
			
			$form->table->AddRow($prefix);
			$form->table->AddRow('<input type="submit" value="'.$button.' This Award" name="delete">');
			$form->EndForm();
			
			hr();
			
			$form = new Form($_SERVER['PHP_SELF']);
			
			$form->AddSectionTitle('Edit Award Superstructure');
			
			$form->AddTextBox('High Point', 'point_high', $award->GetHigh(), 5);
			$form->AddTextBox('Low Point', 'point_low', $award->GetLow(), 5);
			$form->AddCheckBox('Use Default Points?', 'default_points', 1, $award->UsesDefault());
			$form->AddCheckBox('Must be Correct?', 'correct', 1, $award->IsCorrect());
			$form->AddTextBox('Points (Used only if not Default)', 'points', $award->GetPoints(), 5);
			$form->AddTextBox('Credits (No commas)', 'credits', $award->GetCredits('SYSTEM'));
			
			$medal_obj = $award->GetMedal();
			if ($medal_obj){
				$medalid = $medal_obj->GetID();
			}				
			
			$form->StartSelect('Use Medal:', 'medal', $medalid);
			$form->AddOption(0, 'No');
			$mb_cat = $mb->GetMedalCategories();
			foreach ($mb_cat as $cat) {
				$mb_gp = $cat->GetMedalGroups();
				foreach ($mb_gp as $group) {
					$form->AddOption($group->GetID(), $group->GetName());
				}
			}
			$form->EndSelect();
				
			$form->AddHidden('award', $_REQUEST['award']);
			
			$form->AddSubmitButton('submit', 'Make Modifications');
			$form->EndForm();
			
			
			echo "
	Notes:
	<ul>
		<li><b>High Point</b>: This is the max rank which the reward is for. During a search, the system will look for to see if the number is less than or equal to this number.</li>
		<li><b>Low Point</b>: This is the min rank which the reward is for. During a search, the system will look for to see if the number is greater than or equal to this number.</li>
		<li><b>Use Default Points?</b>: If this is checked, the reward will automatically create the rank using the Maximum/Minimum entered for the KAC itself.</li>
		<li><b>Must Be Correct?</b>: Check only if the position must be correct in searching for the award type.</li>
		<li><b>Points</b>: If you have elected not to use default points, you must enter the number of points rewarded for this award.</li>
		<li><b>Credits</b>: The amount of credits for this award type.</li>
		<li><b>Use Medal</b>: Select what medal is to be awarded for this type. Leave No if no medal is to be awarded.</li>
	</ul>
	Example of an award:
	";
	
		$table = new Table();
	$table->AddRow('Field', 'Value');
	
	$table->AddRow('High Point', 1);
	$table->AddRow('Low Point', 1);
	$table->AddRow('Use Default', 'Yes');
	$table->AddRow('Must be Correct', 'No');
	$table->AddRow('Points', 0);
	$table->AddRow('Credits', '100,000');
	$table->AddRow('Medal', 'No');
	
	$table->EndTable();
	
	echo "
	Above is an example of an award type, this one being for First Place. It is for first because the high and low are the same (both 1).
	<br />When the database is searched for the first place finisher (whose rank is 1), it will look through the awards for where the:<br />
	High Point <= 1 <b>AND</b> Low Point >= 1<br />
	This meets the condition. Because it is not correct, the first place finisher could have an incorrect answer, and it would not matter.
	<br />Use Default is also checked, meaning the points awarded will be determined by the max for the KAC (normally 11) minus the rank (which is 1).
	<br />The credits are 100,000 ICs, so the person who gets first place would get 100,000.
	<p>Another example would be:
	";
	
	$table = new Table();
	$table->AddRow('Field', 'Value');
	
	$table->AddRow('High Point', 10);
	$table->AddRow('Low Point', 4);
	$table->AddRow('Use Default', 'Yes');
	$table->AddRow('Must be Correct', 'No');
	$table->AddRow('Points', 0);
	$table->AddRow('Credits', '30,000');
	$table->AddRow('Medal', 'No');
	
	$table->EndTable();
		
	echo "
	This is the points for the 4-10 finishers in the KAC. Works just like the above.
	";
	
	$table = new Table();
	$table->AddRow('Field', 'Value');
	
	$table->AddRow('High Point', -1);
	$table->AddRow('Low Point', -1);
	$table->AddRow('Use Default', 'No');
	$table->AddRow('Must be Correct', 'Yes');
	$table->AddRow('Points', 1);
	$table->AddRow('Credits', '30,000');
	$table->AddRow('Medal', 'No');
	
	$table->EndTable();
	
	echo "
	This is the award for those who are NOT in the top 10. The system references these people by the -1. 
	<br />If they are correct, but not one of the top finishers in their Kabal, they get this award.
	<p>That is essentially the awarding system. If you do not understand it, please do not play with it. You can always eMail Ric for help.
	";
	
	$person = new Person(2650);
	echo '<a href="mailto:'.$person->GetEmail().'">'.$person->GetEmail().'</a>';
			
		} else {
			echo 'Award required.';
		}
	
	} else {
	
		$form = new Form($_SERVER['PHP_SELF']);
		
		$form->AddSectionTitle('Select Award to Edit');
		
		$form->StartSelect('Select Award', 'award');
		foreach ($ka->AllAwards() as $type){
			$corr = 'No';
			if ($type->IsCorrect()){
				$corr = 'Yes';
			}
			$form->AddOption($type->GetID(), 'High: '.$type->GetHigh().' | Low: '.$type->GetLow().' | Correct: '.$corr);
		}
		$form->EndSelect();
		
		$form->AddSubmitButton('next', 'Continue to Edit >>');
		$form->EndForm();
		
	}
	
}

?>
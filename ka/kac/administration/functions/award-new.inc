<?php

function output(){
	global $ka, $mb, $reward_blurb;
	
	if ($_REQUEST['submit']){
		if ($ka->NewAward($_REQUEST['point_high'], $_REQUEST['point_low'], $_REQUEST['default_points'], $_REQUEST['points'], $_REQUEST['correct'], 
			$_REQUEST['credits'], $_REQUEST['medal'])){
			echo 'New Award added successfully.';
		} else {
			echo $ka->Error();
		}
		hr();
	}
	
	$form = new Form($PHP_SELF);
	
	$form->AddSectionTitle('Enter Award Stats');
	
	$form->AddTextBox('High Point', 'point_high', '', 5);
	$form->AddTextBox('Low Point', 'point_low', '', 5);
	$form->AddCheckBox('Use Default Points?', 'default_points', 1, true);
	$form->AddCheckBox('Must be Correct?', 'correct', 1, true);
	$form->AddTextBox('Points (Used only if not Default)', 'points', '', 5);
	$form->AddTextBox('Credits (No commas)', 'credits');
	
	$form->StartSelect('Use Medal:', 'medal');
	$form->AddOption(0, 'No');
	$mb_cat = $mb->GetMedalCategories();
	foreach ($mb_cat as $cat) {
		$mb_gp = $cat->GetMedalGroups();
		foreach ($mb_gp as $group) {
			$form->AddOption($group->GetID(), $group->GetName());
		}
	}
	$form->EndSelect();
	
	$form->AddSubmitButton('submit', 'Add New Event Type');
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
}

?>
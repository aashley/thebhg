<?php
include_once('header.php');

$event =& $ka->GetEvent($_REQUEST['id']);
$kag =& $event->GetKAG();

if ($event->IsTimed()){
	$type = $event->GetTypes();
	$name = $type->GetName();
} else {
	$name = $event->GetName();
}

page_header('KAG ' . roman($kag->GetID()) . ' :: ' . $name);
add_menu(array('KAG ' . roman($kag->GetID())=>'kag/kag.php?id=' . $kag->GetID()));

$table = new Table('', true);
$table->StartRow();
$table->AddHeader('Rank');
$table->AddHeader('Name');
$table->AddHeader('Kabal');
$table->AddHeader('Points');
$table->AddHeader('Credits');
$table->EndRow();

function printer($signup, $table){
	global $kag;
	$person =& $signup->GetPerson();
	$kabal =& $signup->GetKabal();

	$table->StartRow();
	$table->AddCell($signup->GetRank());
	$table->AddCell('<a href="hunter.php?kag=' . $kag->GetID() . '&amp;id=' . $person->GetID() . '">' . $person->GetName() . '</a>');
	$table->AddCell('<a href="kabal.php?kag=' . $kag->GetID() . '&amp;kabal=' . $kabal->GetID() . '">' . $kabal->GetName() . '</a>');
	$table->AddCell('<div style="text-align: right">' . number_format($signup->GetPoints()) . '</div>');
	$table->AddCell('<div style="text-align: right">' . number_format($signup->GetCredits()) . '</div>');
	$table->EndRow();
}

$signups =& $event->GetRankSignups();
ksort($signups);
if ($signups) {
	$sups = array();
	foreach ($signups as $data) {
		foreach ($data as $signup){
			if ($signup->GetRank()){
				printer($signup, $table);
			}
		}
	}
	if (is_array($signups[0])){
		foreach ($signups[0] as $signup){
			printer($signup, $table);
		}
	}
		
}

$table->EndTable();

if ($event->IsTimed() && time() >= $event->GetEnd()){
	$type = $event->GetTypes();
		
	$table = new Table('', true);
	
	$content = $event->GetContent();
	$answers = $content['answers'];
	$questions = $content['questions'];
	$total_answers = count($answers);
	$total_questions = count($questions);
	$signups =& $event->GetSignups();
	
	$table->startRow();
	$table->addHeader($type->GetName() . 'Results', 2);
	$table->endRow();
	
	if ($type->HasImage()){
		$table->StartRow();
		$table->AddCell('<center><center><img src="/kag/event_images/'.$type->GetAbbr(). '-'. $kag->GetID() . '-' 
						. $event->GetID() . '.jpg">', 2);
		$table->EndRow();
		for ($i = 1; $i <= $total_answers; $i++) {
			$table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($answers[$i]));
		}
	} else {
		if ($total_questions == $total_answers){
			for ($i = 1; $i <= $total_answers; $i++) {
				$table->AddRow('Hunt Question '.$i.'/'.$total_questions, stripslashes($questions[$i]));
		        $table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($answers[$i]));
	        }
	    } else {
	        for ($i = 1; $i <= $total_questions; $i++) {
				$table->AddRow('Hunt Question '.$i.'/'.$total_questions, stripslashes($questions[$i]));
	        }
	        for ($i = 1; $i <= $total_answers; $i++) {
		        $table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($answers[$i]));
	        }
	    }
	}
	$table->EndTable();
	
	$table = new Table('Hunter Results', true);
	foreach ($signups as $sub){			
		$hunter = $sub->GetPerson();
		$kabal = $sub->GetKabal();
		$sub_answers = $sub->GetContent();
		
		$total_answers = count($sub_answers);
		
		$table->startRow();
		$table->addHeader($hunter->GetName().' for '.$kabal->GetName(), 2);
		$table->endRow();
		
		for ($i = 1; $i <= $total_answers; $i++) {
	        $table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($sub_answers[$i]));
        }
	}
	
	$table->EndTable();
}
	

page_footer();
?>

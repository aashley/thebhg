<?php
include_once('header.php');

$event =& $ka->GetEvent($_REQUEST['id']);
$cg =& $event->GetCG();
page_header('CG ' . roman($cg->GetID()) . ' :: ' . $event->GetName());
add_menu(array('CG ' . roman($cg->GetID())=>'cg/cg.php?id=' . $cg->GetID()));

$table = new Table('', true);
$table->StartRow();
if (!$event->isTeam()){
	$table->AddHeader('Name');
}
$table->AddHeader('Cadre');
$table->AddHeader('Points');
$table->AddHeader(($event->isTeam() ? 'Team ' : '').'Credits');
$table->EndRow();

$signups =& $event->GetSignups();
if ($signups) {
	$sups = array();
	foreach ($signups as $signup) {
		$person =& $signup->GetPerson();
		$cadre =& $signup->GetCadre();

		if ($person->getID() != $cadre->getLEader()->getID() && $event->isTeam())
			continue;
		
		$table->StartRow();
		if (!$event->isTeam()){
			$table->AddCell('<a href="hunter.php?cg=' . $cg->GetID() . '&amp;id=' . $person->GetID() . '">' . $person->GetName() . '</a>');
		}
		$table->AddCell('<a href="cadre.php?cg=' . $cg->GetID() . '&amp;cadre=' . $cadre->GetID() . '">' . $cadre->GetName() . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($signup->GetPoints()) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($signup->GetCredits()) . '</div>');
		$table->EndRow();
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
		$table->AddCell('<center><center><img src="/cg/event_images/'.$type->GetAbbr(). '-'. $cg->GetID() . '-' 
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
	$dnp = array();
	$table = new Table('Hunter Results', true);
	foreach ($signups as $sub){			
		$hunter = $sub->GetPerson();
		$kabal = $sub->GetKabal();
		$sub_answers = $sub->GetContent();
		
		$total_answers = count($sub_answers);
		
		if ($sub->GetSubmitted() > 0){
		
			$table->startRow();
			$table->addHeader($hunter->GetName().' for '.$kabal->GetName().' ['.date('l dS \of F Y h:i:s A', $sub->GetSubmitted()).']', 2);
			$table->endRow();
		
			for ($i = 1; $i <= $total_answers; $i++) {
		        $table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($sub_answers[$i]));
	        }
	        
        } else {
	        
	        $dnp[] = $sub;
	        
        }
	}
	
	$table->EndTable();
	
	hr();
	
	$table->EndTable();
	$table = new Table('DNP', true);
	foreach ($dnp as $sub){			
		$hunter = $sub->GetPerson();
		$kabal = $sub->GetKabal();
		$table->addRow($hunter->GetName().' for '.$kabal->GetName());
	}
	
	$table->EndTable();
}

page_footer();
?>

<?php

$poll = new Poll($_REQUEST['poll']);

function auth($person) {
    global $hunter, $roster, $auth_data;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    return ($div->GetID() != 0 && $div->GetID() != 16);
}

function title() {
	global $poll, $hunter;
    $title = 'AMS Tracking Network :: Arena Polling Centre :: ';
    if (is_object($poll){
	    if (!$poll->IsDeleted() || !rp_staff($hunter) || !$poll->CanSubmit($hunter) || !$poll->DidVote($hunter)){
	    	$title .= 'View Poll';
    	} else {
	    	$title .= 'Read Error';
    	}
    } else {
	    $title .= 'View Polls';
    }
    return $title;
}

function output() {
    global $arena, $hunter, $roster, $poll, $page;

    arena_header();

    if (is_object($poll)){
	    if ($poll->IsDeleted() || !rp_staff($hunter) || !$poll->CanSubmit($hunter) || !$poll->DidVote($hunter)){
		    echo 'Invalid polling number';
	    } else {
		    if ($poll->GetStarts() <= time() && $poll->GetEnds() >= time()){
			    echo 'Voting information';
		    } else {
		 		echo 'Polling Information';
	 		}
	    }
    } else {
	    $polls = $arena->OpenPolls($hunter);
	    
	    if (count($polls)){
		    $table = new Table('', true);
		    $form->StartRow();
		    $form->AddHeader('Polls to Submit For', 2);
		    $form->EndRow();
		    $table->StartRow();
		    $table->AddCell('Poll Question');
		    $table->AddCell('Ends In');
		    $table->EndRow();
		    
		    foreach ($polls as $poll){
			    $table->AddRow('<a href="'.internal_link($page, array('poll'=>$poll->GetID())).'">'.$poll->GetQuestion().'</a>', $poll->GetEnd());
		    }
		    
		    $table->EndTable();
	    }
	    
	    $polls = $arena->ReadPolls();
	    
	    if (count($polls)){
		    $table = new Table('', true);
		    $form->StartRow();
		    $form->AddHeader('Arena Polls', 2);
		    $form->EndRow();
		    $table->StartRow();
		    $table->AddCell('Poll Question');
		    $table->AddCell('Start Date');
		    $table->AddCell('End Date');
		    $table->EndRow();
		    
		    foreach ($polls as $poll){
			    $table->AddRow('<a href="'.internal_link($page, array('poll'=>$poll->GetID())).'">'.$poll->GetQuestion().'</a>', $poll->GetEnd());
		    }
		    
		    $table->EndTable();
	    }
    }

    arena_footer();

}
?>

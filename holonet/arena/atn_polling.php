<?php

$poll = new Poll($_REQUEST['poll']);

if (!$poll->GetID()){
	$poll = false;
}

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
    if (is_object($poll)){
	    if (rp_staff($hunter) || (!$poll->IsDeleted() && $poll->CanView($hunter))){
		    if ($poll->CanSubmit($hunter, 1)){
			    $title .= 'Submit for Poll';
		    } else {
	    		$title .= 'View Poll';
    		}
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

    if ($_REQUEST['submit']){
	    if ($poll->CanSubmit($hunter)){
		    if (is_array($_REQUEST['votes'])){
			    foreach ($_REQUEST['votes'] as $vote){
				    $vote = new Option($vote);
				    echo $vote->Vote($hunter->GetID()).'<br />';
			    }
		    } else {
			    $vote = new Option($_REQUEST['votes']);
				echo $vote->Vote($hunter->GetID());
			}
		}
		hr();
	}
	
    if (is_object($poll)){
	    if (rp_staff($hunter) || (!$poll->IsDeleted() && $poll->CanView($hunter))){
		    if ($poll->CanSubmit($hunter, 1)){
			    $form = new Form($page);
			    $form->table->StartRow();
			    $form->table->AddHeader($poll->GetQuestion(), 3);
			    $form->table->EndRow();
			    $votes = $poll->GetVotes();
			    $form->table->AddRow('&nbsp', 'Question', 'Stats');
			    foreach ($poll->GetOptions() as $option){
				    $per = $votes[$option->GetID()];
				    if ($votes['total']){
					    $perce = $per/$votes['total'];
					    $percent = $perce*100;
					    $percent = round($percent, 0);
				    } else {
					    $percent = 0;
				    }
				    if ($poll->GetMultiple()){
					    $put = '<input type="checkbox" name="votes[]" value="'.$option->GetID().'">';
				    } else {
					    $put = '<input type="radio" name="votes" value="'.$option->GetID().'">';
				    }
					$form->table->AddRow($put, $option->GetQuestion(), $percent.'%');
			    }
			    $form->AddHidden('poll', $_REQUEST['poll']);
			    $form->table->StartRow();
			    $form->table->AddCell('<input type="submit" value="Vote!" name="submit">', 3);
			    $form->table->EndRow();
			    $form->EndForm();
		    } else {
	    		$poll->WriteResults();
    		}
	    } else {
		    echo 'Invalid polling number';
	    }
    } else {
	    $polls = $arena->OpenPolls($hunter);
	    
	    if (count($polls)){
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Polls to Submit For', 2);
		    $table->EndRow();
		    $table->StartRow();
		    $table->AddCell('Poll Question');
		    $table->AddCell('Ends In');
		    $table->EndRow();
		    
		    foreach ($polls as $poll){
			    $table->AddRow('<a href="'.internal_link($page, array('poll'=>$poll->GetID())).'">'.$poll->GetQuestion().'</a>', $poll->GetEnd());
		    }
		    
		    $table->EndTable();
	    }
	    
	    $polls = $arena->ReadPolls($hunter);
	    
	    print_r($polls);
	    
	    if (count($polls)){
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Arena Polls', 2);
		    $table->EndRow();
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

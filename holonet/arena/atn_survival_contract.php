<?php
if (isset($_REQUEST['id'])){
	$atn = $arena->SurvivalContract($_REQUEST['id']);
}

function title() {
    global $atn;
    
    $return = 'AMS Tracking Network :: Survival Mission :: Mission Archive';
    
    if (is_object($atn)){
	    $return .= ' :: Mission ' . $atn->GetContractID();
    }

    return $return;
}

function output() {
    global $atn, $arena;

    arena_header();

    if (is_object($atn)){
	    $hunter = $atn->GetHunter();
	    $npc = $atn->GetNPC();
	    $type = $atn->GetType();
	    $grade = $atn->GetGrade();
	
	    $table = new Table('', true);
	    $table->StartRow();
	    $table->AddHeader('Mission Details', 2);
	    $table->EndRow();
	    $table->AddRow('ID Number:', $atn->GetLink());
	
	    if ($hunter){
	        $table->AddRow('Issued To:', '<a href="' . internal_link('atn_general', array('id'=>$hunter->GetID())) . '">' . $hunter->GetName() . '</a>');
	    } else {
	        $table->AddRow('Unissued Mission:', 'Failed Mission [ <a href="' . internal_link('acn_survival_dco', array('id'=>$atn->GetID())) . '">Request</a> ]');
	    }
	
	    $table->AddRow('Target:', $npc->GetName());
	    $table->AddRow('Type:', '<a href="' . internal_link('atn_survival_type', array('id'=>$type->GetID())) . '">' . $type->GetName() . '</a>');
	    $table->AddRow('Status:', $atn->GetCompleted());
	    $table->EndTable();
	
	    if ($atn->GetComplete()){
	
	        hr();
	
	        $table = new Table('', true);
	        $table->StartRow();
	        $table->AddHeader('Mission Results', 2);
	        $table->EndRow();
	        $table->AddRow('Grade:', '<a href="' . internal_link('atn_survival_grade', array('id'=>$grade->GetID())) . '">' . $grade->GetName() . '</a>');
	        $table->AddRow('Credits:', number_format($atn->GetCredits()).' Imperial Credits');
	        $table->AddRow('Experience Points:', number_format($atn->GetXP()));
	        $table->EndTable();
	
	    }
	    
	    $dcos = $atn->GetDCOs();
	    
	    if (count($dcos)){
		    hr();
		    
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Failed Attempts', 2);
		    $table->EndRow();
		    $table->StartRow();
		    $table->AddHeader('Hunter');
		    $table->AddHeader('Date');
		    $table->EndRow();
		    
		    foreach ($dcos as $data){
			    $table->AddRow($data['writedate'], '<a href="' . internal_link('atn_general', array('id'=>$data['hunter']->GetID())) . '">' . $data['hunter']->GetName() . '</a>');
		    }
		    
		    $table->EndTable();
	    }
	    
	    $ret = $atn->GetRetires();
	    
	    if (count($ret)){
		    hr();
		    
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Retiring Hunters', 2);
		    $table->EndRow();
		    $table->StartRow();
		    $table->AddHeader('Hunter');
		    $table->AddHeader('Date');
		    $table->EndRow();
		    
		    foreach ($ret as $data){
			    $table->AddRow($data['writedate'], '<a href="' . internal_link('atn_general', array('id'=>$data['hunter']->GetID())) . '">' . $data['hunter']->GetName() . '</a>');
		    }
		    
		    $table->EndTable();
	    }
	
	    hr();
	
	    $table = new Table('', true);
	    $table->StartRow();
	    $table->AddHeader('Creature Target');
	    $table->EndRow();
	    $table->AddRow($npc->WriteSheet());
	    $table->EndTable();
    }

    arena_footer();
}
?>
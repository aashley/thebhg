<?php
if (isset($_REQUEST['id'])){
	$atn = $arena->Contract($_REQUEST['id']);
}

function title() {
    global $atn;
    
    $return = 'AMS Tracking Network :: Solo Mission :: Contract Archive';
    
    if (is_object($atn)){
	    $return = ' :: Contract ' . $atn->GetContractID();
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
	    $table->AddHeader('Contract Details', 2);
	    $table->EndRow();
	    $table->AddRow('ID Number:', $atn->GetLink());
	
	    if ($hunter){
	        $table->AddRow('Issued To:', '<a href="' . internal_link('atn_general', array('id'=>$hunter->GetID())) . '">' . $hunter->GetName() . '</a>');
	    } else {
	        $table->AddRow('Unissued Contract:', 'Dead Contract [ <a href="' . internal_link('acn_solo_dco', array('id'=>$atn->GetID())) . '">Request</a> ]');
	    }
	
	    $table->AddRow('Target:', $npc->GetName());
	    $table->AddRow('Type:', '<a href="' . internal_link('atn_solo_type', array('id'=>$type->GetID())) . '">' . $type->GetName() . '</a>');
	    $table->AddRow('Status:', $atn->GetCompleted());
	    $table->EndTable();
	
	    if ($atn->GetComplete()){
	
	        hr();
	
	        $table = new Table('', true);
	        $table->StartRow();
	        $table->AddHeader('Contract Results', 2);
	        $table->EndRow();
	        $table->AddRow('Grade:', '<a href="' . internal_link('atn_solo_grade', array('id'=>$grade->GetID())) . '">' . $grade->GetName() . '</a>');
	        $table->AddRow('Credits:', number_format($atn->GetCredits()).' Imperial Credits');
	        $table->AddRow('Experience Points:', number_format($atn->GetXP()));
	        $table->EndTable();
	
	    }
	
	    hr();
	
	    $table = new Table('', true);
	    $table->StartRow();
	    $table->AddHeader('Non Player Character');
	    $table->EndRow();
	    $table->AddRow($npc->BuildSheet());
	    $table->EndTable();
    }

    arena_footer();
}
?>
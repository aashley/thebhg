<?php
if (isset($_REQUEST['id'])){
	$atn = $arena->LW_Contract($_REQUEST['id']);
}

function title() {
    global $atn;

    $return = 'AMS Tracking Network :: Lone Wolf Mission :: Contract Archive';
    
    if (is_object($atn)){
	    $return .= ' :: Contract ' . $atn->GetContractID();
    }
    
    return $return;
}

function output() {
    global $atn, $arena;

    arena_header();

    if (is_object($atn)){
	    $hunter = $atn->GetHunter();
	    $npc = $atn->GetNPC();
	    $grade = $atn->GetGrade();
	
	    $table = new Table('', true);
	    $table->StartRow();
	    $table->AddHeader('Lone Wolf Contract Details', 2);
	    $table->EndRow();
	    $table->AddRow('ID Number:', $atn->GetLink());
	
	    if ($hunter){
	        $table->AddRow('Issued To:', '<a href="' . internal_link('atn_general', array('id'=>$hunter->GetID())) . '">' . $hunter->GetName() . '</a>');
	    } else {
	        $table->AddRow('Unissued Contract:', 'Dead Contract [ <a href="' . internal_link('acn_lw_dco', array('id'=>$atn->GetID())) . '">Request</a> ]');
	    }
	
	    $table->AddRow('Target A:', $npc->GetName1());
	    $table->AddRow('Target B:', $npc->GetName2());
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
	    $table->AddHeader('Non Player Characters');
	    $table->EndRow();
	    $table->AddRow($npc->BuildSheet1());
	    $table->AddRow($npc->BuildSheet2());
	    $table->EndTable();
    }

    arena_footer();
}
?>
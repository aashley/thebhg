<?php
if (isset($_REQUEST['id'])){
	$hunter = new Person($_REQUEST['id']);
}

function title() {
    global $hunter;

    $return = 'AMS Tracking Network :: Bastion Challenge :: History';
    
    if (is_object($hunter)){
	    $return .= ' :: ' . $hunter->GetName();
    }
    
    return $return;
}

function output() {
    global $arena, $hunter, $sheet, $roster;

    arena_header();

    echo '<a href="'.internal_link('atn_general', array('id'=>$hunter->GetID())).'">Back to '.$hunter->GetName().'\'s General Tracking</a>';
    
    hr();
    
    if (is_object($hunter)){
    	$bast = $arena->BastionPlayer($hunter->GetID());
    	if (is_array($bast)){
	    	$total = 0;
	    	$table = new Table('', true);
	    	$table->StartRow();
	    	$table->AddHeader('Season');
	    	$table->AddHeader('Points');
	    	$table->AddHeader('Kabal');
	    	$table->EndRow();
	    	
	    	foreach ($bast as $season=>$data){
		    	$table->AddRow('<a target="bastion" href="http://overseer.thebhg.org/index.php?area=challenge&page=season&season='.$season.'">'.$season.'</a>', 
		    		number_format($data['total']), '<a target="bastion" href="http://overseer.thebhg.org/index.php?area=challenge&page=kabal&season='.$season.'&kabal='.$data['kabal']->GetID().'">'.$data['kabal']->GetName().'</a>');
		    	$total += $data['total'];
	    	}
	    	$table->StartRow();
	    	$table->AddCell('<div align="right">Total Points </div>', 2);
	    	$table->AddCell($total);
	    	$table->EndRow();
	    	
	    	$table->EndTable();	
    	} else {
	    	echo 'This hunter has never been a Bastion Challenge Kabal Representative.';
    	}  	
	}
    
    arena_footer();
}
?>
<?php
if (isset($_REQUEST['id'])){
	$atn = new RunOn($_REQUEST['id']);
}

function title() {
    global $atn;

    $return = 'AMS Tracking Network :: Run-Ons :: Run-On Archive';
    
    if (is_object($atn)){
	    $return .= ' :: ' . $atn->GetName();
    }
    
    return $return;
}

function output() {
    global $atn, $arena;

    arena_header();

    if (is_object($atn)){
	    
	    if ($atn->GetDeleted()){
	
	        echo "This run-on is marked as deleted and thus has no stats.";
	
	    } else {
	
	        echo '<a name="stats"></a>';
	        $table = new Table('', true);
	        $table->StartRow();
	        $table->AddHeader('Run-On Profile', 2);
	        $table->EndRow();
	        $table->AddRow('ID Number:', $atn->GetID());
	        $table->AddRow('Name:', $atn->GetName());
	        $table->AddRow('Start:', $atn->GetStart());
	        $table->AddRow('End:', $atn->GetEnd());
	
	        $table->EndTable();
	
	        hr();
	
	        if ($atn->GetGraded()){
	
	            $fighters = $atn->GetHunters();
	
	            echo '<a name="outcome"></a>';
                $table = new Table();
                $table->StartRow();
                $table->AddHeader('Hunter');
                $table->AddHeader('Credits');
                $table->AddHeader('Experience Points');
                $table->AddHeader('&nbsp;');
                $table->EndRow();
	            
	            foreach($fighters as $value){
		            $first = ($value->IsWinner() ? 'Hunter\'s Cross' : '');
		            $table->AddRow('<a href="'.internal_link('atn_general', array('id'=>$value->GetID())).'">'.$value->GetName().'</a>',
		            		number_format($value->GetCredits()), number_format($value->GetXP()), $first);	                
	            }
	            
	            $table->EndTable();
	
	        }
	
	    }
	    
    }

    arena_footer();
}
?>
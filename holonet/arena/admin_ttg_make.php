<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: Edit Signups';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $module;
    
    arena_header();

    $ttg = new TTG();
    
	$queue = $ttg->AllPending();
	
	if (isset($_REQUEST['submit'])) {
		$challenge = new Challenge($_REQUEST['id']);
		
		if (isset($_REQUEST['bhg_id_1'])){
			if ($challenge->ThrowDown($_REQUEST['bhg_id_1'])){
				echo "Challenge added.";
			} else {
				echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 25';
			}
		}
		
		if (isset($_REQUEST['bhg_id_2'])){
			if ($challenge->ThrowDown($_REQUEST['bhg_id_2'])){
				echo "Challenge added.";
			} else {
				echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 25';
			}
		}
		
		if (isset($_REQUEST['bhg_id_3'])){
			if ($challenge->ThrowDown($_REQUEST['bhg_id_3'])){
				echo "Challenge added.";
			} else {
				echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 25';
			}
		}
		
	} else {
	   
	    if (count($queue)){
			    
		    echo "To remove a challenger, click on their name.";
		    
		    hr();
		    
	        $table = new Table();
	        
	        $table->StartRow();
	        $table->AddHeader('All Twilight Gauntlet Challenges', 6);
	        $table->EndRow();
	        
	        $table->StartRow();
	        $table->AddHeader('Challenger');
	        $table->AddHeader('Status');
	        $table->AddHeader('Challenger 1');
	        $table->AddHeader('Challenger 2');
	        $table->AddHeader('Challenger 3');
	        $table->AddHeader('&nbsp;');
	        $table->EndRow();
	        
	        foreach ($queue as $value) {
		        $person = $value->GetChallenger();
	            $table->StartRow();
	            $table->AddCell($person->GetName());
	            $table->AddCell($value->GetStatus());
	            echo "<FORM METHOD='post' ACTION=".$_SERVER['PHP_SELF']."><INPUT TYPE='HIDDEN' NAME='page' VALUE=$page />"
	            	."<INPUT TYPE='HIDDEN' NAME='module' VALUE=$module /><INPUT TYPE='HIDDEN' NAME='id' VALUE=".$value->GetID()." />";
	            
	            $submit = '<INPUT TYPE="submit" name="submit" VALUE="Declare Change" />';
	            foreach ($value->Opponents() as $id=>$person){
		            $match = $value->GetMatch($id);
		            if ($person == 0){
			            $add = '<SELECT size="1" name="bhg_id_'.$id.'">';
			            $add .= "<OPTION value=0></OPTION>";
			            foreach ($ttg->GetMembers() as $pleb) {
				            $add .= '<OPTION value="'.$pleb->GetID().'">'.$pleb->GetName().'</OPTION>';
				        }
			            $add .= "</SELECT>";
		            } elseif ($match->GetID()){
		            	$add = "Match Started";
	            	} else {
			            $pleb = new Person($person);
			            $add = '<a href="' . internal_link('admin_ttg_remove', array('id'=>$value->GetID(), 'bhg_id'=>$pleb->GetID())) 
			            		. '">' . $pleb->GetName() . '</a>';
		            }
		            
		            $table->AddCell($add);
	            }
	            
	            $table->AddCell($submit);
	            echo "</FORM>";
	            $table->EndRow();
	            
	        }
	        
	        $table->EndTable();	
	        	
	    
	    } else {
	        
	        echo "No editable challenges in the queue.";
	        
	    }
	    
    }

    admin_footer($auth_data);
}
?>
<?php
function title() {
    return 'Administration :: Tempestuous Group :: Edit Signups';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['tempy_mod'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $module;
    
    arena_header();

    $tempy = new Tempy();
    
	$queue = $tempy->AllPending();
	
	if (isset($_REQUEST['submit'])){
		$petition = new Petition($_REQUEST['id']);
		
		if (isset($_REQUEST['bhg_id_1'])){
			if (!in_array($_REQUEST['bhg_id_1'], $petition->Jurors())){
				
				if ($petition->SignUp($_REQUEST['bhg_id_1'])){
					echo "Juror added.";
				} else {
					echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 39';
				}
				
			} else {
				
				echo "This person already marked as a juror.";
				
			}
			echo '<br />';
		}
		
		if (isset($_REQUEST['bhg_id_2'])){
			if (!in_array($_REQUEST['bhg_id_2'], $petition->Jurors())){
				
				if ($petition->SignUp($_REQUEST['bhg_id_2'])){
					echo "Juror added.";
				} else {
					echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 39';
				}
				
			} else {
				
				echo "This person already marked as a juror.";
				
			}
			echo '<br />';
		}
		
		if (isset($_REQUEST['bhg_id_3'])){
			if (!in_array($_REQUEST['bhg_id_3'], $petition->Jurors())){
				
				if ($petition->SignUp($_REQUEST['bhg_id_3'])){
					echo "Juror added.";
				} else {
					echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 39';
				}
				
			} else {
				
				echo "This person already marked as a juror.";
				
			}
			echo '<br />';
		}
		
		if (isset($_REQUEST['bhg_id_4'])){
			if (!in_array($_REQUEST['bhg_id_4'], $petition->Jurors())){
				
				if ($petition->SignUp($_REQUEST['bhg_id_4'])){
					echo "Juror added.";
				} else {
					echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 39';
				}
				
			} else {
				
				echo "This person already marked as a juror.";
				
			}
			echo '<br />';
		}
		
	} else {
	   
	    if (count($queue)){
			    
		    echo "To remove a challenger, click on their name. <b>Only add one Juror at a time to allow the system to process the changes.</b>";
		    
		    hr();
		    
	        $table = new Table();
	        
	        $table->StartRow();
	        $table->AddHeader('Tempestuous Applications', 6);
	        $table->EndRow();
	        
	        $table->StartRow();
	        $table->AddHeader('Applicant');
	        $table->AddHeader('Juror 1');
	        $table->AddHeader('Juror 2');
	        $table->AddHeader('Juror 3');
	        $table->AddHeader('Juror 4');
	        $table->AddHeader('&nbsp;');
	        $table->EndRow();
	        
	        foreach ($queue as $value) {
		        $person = $value->GetApplicant();
	            $table->StartRow();
	            $table->AddCell($person->GetName());
	            echo "<FORM METHOD='post' ACTION=".$_SERVER['PHP_SELF']."><INPUT TYPE='HIDDEN' NAME='page' VALUE=$page />"
	            	."<INPUT TYPE='HIDDEN' NAME='module' VALUE=$module /><INPUT TYPE='HIDDEN' NAME='id' VALUE=".$value->GetID()." />";
	            
	            $submit = '<INPUT TYPE="submit" name="submit" VALUE="Go" />';
	            foreach ($value->Jurors() as $id=>$person){
		            if ($person == 0){
			            $add = '<SELECT size="1" name="bhg_id_'.$id.'">';
			            $add .= "<OPTION value=0></OPTION>";
			            foreach ($tempy->Members() as $pid) {
				            $pleb = new Person($pid);
				            $add .= '<OPTION value="'.$pleb->GetID().'">'.$pleb->GetName().'</OPTION>';
				        }
			            $add .= "</SELECT>";
		            } else {
			            $pleb = new Person($person);
			            $add = '<a href="' . internal_link('admin_tempy_remove', array('id'=>$value->GetID(), 'bhg_id'=>$pleb->GetID())) 
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
	        
	        echo "No editable applications.";
	        
	    }
	    
    }

    admin_footer($auth_data);
}
?>
<?php
function title() {
    return 'Administration :: Solo Mission :: Approve Contract';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['solo'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;
    
    arena_header();

    $solo = new Solo();

	if (isset($_REQUEST['submit'])) {
		
		$control = new SoloControl();
		
		$errors = 0;
		
		if (is_array($_REQUEST['approve'])){
			foreach ($_REQUEST['approve'] as $id=>$bhg_id) {
				if (!$control->New_Contract($bhg_id, $_REQUEST['contract'][$id])){
					$errors++;
				}
			}
		}
			
		if (is_array($_REQUEST['deny'])){
			foreach ($_REQUEST['deny'] as $id=>$bhg_id) {
				if (!$control->Deny($bhg_id, $_REQUEST['contract'][$id])){
					$errors++;
				}
			}
		}
		
		if ($errors){
			NEC(156);
		} else {
			echo 'Contracts processed.';
		}
    }
    else {
	    if (count($solo->NeedApproval())){
	        $form = new Form($page);
	        $form->table->StartRow();
	        $form->table->AddHeader('Approve Requested Contracts', 4);
	        $form->table->EndRow();
	        $form->table->AddRow('Requester', 'Difficulty', 'Approve', 'Deny');
	        $i = 1;
	        foreach ($solo->NeedApproval() as $value) {
		        $person = new Person($value['bhg_id']);
		        $type = new SoloType($value['type']);
		        $form->AddHidden('contract['.$i.']', $type->GetID());
		        $form->table->AddRow('<a href="'.internal_link('atn_general', array('id'=>$person->GetID())).'">'.$person->GetName().'</a>', 
		        	$type->GetName(), '<input type="checkbox" name="approve['.$i.']" value="'.$value['bhg_id'].'">', 
		        	'<input type="checkbox" name="deny['.$i.']" value="'.$value['bhg_id'].'">');
		        $i++;
	        }
	        $form->table->StartRow();
	        $form->table->AddCell('<input type="submit" name="submit" value="Process">', 4);
	        $form->table->EndRow();
	        $form->EndForm();
        } else {
	        echo 'No Pending Contracts';
        }
    }

    admin_footer($auth_data);
}
?>
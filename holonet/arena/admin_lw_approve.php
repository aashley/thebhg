<?php
function title() {
    return 'Administration :: Lone Wolf Mission :: Approve Contract';
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

    $solo = new LW_Solo();
    if (isset($_REQUEST['submit'])) {
		
		$control = new SoloControl();
		
		$errors = 0;
		
		foreach ($_REQUEST['approve'] as $bhg_id) {
			if (!$control->New_Contract($bhg_id)){
				$errors++;
			}
		}
		
		foreach ($_REQUEST['deny'] as $bhg_id) {
			if (!$control->Deny($bhg_id)){
				$errors++;
			}
		}
		
		if ($errors){
			echo 'Errors occured during processing';
		} else {
			echo 'Contract\'s posted.';
		}
    }
    else {
	    if (count($solo->NeedApproval())){
	        $form = new Form($page);
	        $form->AddSectionTitle('Approve Requested Contracts');
	        $form->table->AddRow('Requester', 'Difficulty', 'Approve', 'Deny');
	        $i = 1;
	        foreach ($solo->NeedApproval() as $value) {
		        $person = new Person($value['bhg_id']);
		        $form->table->AddRow($person->GetName(), $type->GetName(), '<input type="checkbox" name="approve['.$i.']" value="'.$value['bhg_id'].'">', 
		        	'<input type="checkbox" name="deny['.$i.']" value="'.$value['bhg_id'].'">');
		        $i++;
	        }
	        $form->AddHidden('submit', 1);
	        $form->EndForm();
        } else {
	        echo 'No Pending Contracts';
        }
    }

    admin_footer($auth_data);
}
?>
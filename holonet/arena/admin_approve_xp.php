<?php
function title() {
    return 'Administration :: General :: Approve CH XP';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();
    
    $kabalch = $hunter->GetDivision();
    
    if (isset($_REQUEST['submit'])){
	    
	    $error = false;
	    
	    for ($i = 1; $i <= $_REQUEST['total']; $i++) {
      
			$person = "person$i";
      		$reason = "reason$i";
			$xp = "xp$i";
			$deny = "deny$i";
			
			if ($_REQUEST[$person] > 0 && !$_REQUEST[$deny]){
				$character = new Character($_REQUEST[$person]);
	            if (!$character->XPEvent($_REQUEST[$xp], $_REQUEST[$reason])){
		            $error = true;
	            }
            }
			
		}
		
		if ($error){
			NEC(169);
		} else {
			echo 'Experience points added.';
			$arena->RemovePendingXP();
		}
		
		hr();
	    
    }

    print_r($arena->GetPendingXP());
    
    if (count($arena->GetPendingXP())){
    
		$form = new Form($page);
		
		$form->table->StartRow();
		$form->table->AddHeader('Awarded By');
		$form->table->AddHeader('Kabal');
		$form->table->AddHeader('Hunter');	
		$form->table->AddHeader('XP');
		$form->table->AddHeader('Reason');
		$form->table->AddHeader('Deny');
		$form->table->EndRow();
	  	$i = 0;
		foreach ($arena->GetPendingXP() as $kabal=>$infa) {
			foreach ($infa as $info){
	    		$i++;
		    	$form->table->StartRow();
		      
				$form->table->AddCell($info['by']->GetName());
				$form->table->AddCell($kabal);
				$form->table->AddCell($info['bhg_id']->GetName());    
				$form->AddHidden('person'.$i, $info['bhg_id']->GetID());
				$form->table->AddCell("<input type='text' name='xp".$i."' value='".$info['xp']."'>");
				$form->table->AddCell($info['reason']);
				$form->AddHidden('reason'.$i, $info['reason']);
				$form->table->AddCell('<input type="checkbox" name="deny'.$i.'" value=1>');
		    
				$form->table->EndRow();
			}
		}
		$form->AddHidden('total', $i);
		
	    $form->table->StartRow();
		$form->table->AddCell('<input type="submit" name="submit" value="Approve Experience Points" size="50">', 6);
		$form->table->EndRow();
	    $form->EndForm();
    } else {
	    echo 'No CH XP to award.';
    }
    
    admin_footer($auth_data);
}
?>
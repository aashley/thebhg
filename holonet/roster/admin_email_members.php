<?php
function title() {
	return 'Administration :: E-Mail Members';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return ($auth_data['commission'] || $auth_data['chief'] || $auth_data['warden']);
}

function output() {
	global $auth_data, $pleb, $roster, $page;

	$div = $pleb->GetDivision();

	roster_header();
	
	if (empty($_REQUEST['submit'])) {
		$form = new Form($page);
		$form->StartSelect('Division/Group:', 'group', $div->GetID());
		$form->AddOption('all', 'All Members');
		$form->AddOption('allactive', 'All Active Members');
		$form->AddOption('commish', 'Entire Commission');
		$form->AddOption('commchief', 'Commission, Chiefs, Wardens, CRAs');
		$cats = $roster->GetDivisionCategories();
		foreach ($cats as $cat) {
			$divs = $cat->GetDivisions();
			foreach ($divs as $div) {
				$form->AddOption($div->GetID(), $div->GetName());
			}
		}
    $cadres = $roster->GetCadres();
    if ($cadres !== false) {
      $form->AddOption('cadre-leaders', 'Cadre Leaders');
      $form->AddOption('cadre-all', 'All Cadre Members');
      foreach ($cadres as $cadre) {
        $form->AddOption('cadre-'.$cadre->GetID(), $cadre->GetName());
      }
    }
	  $form->EndSelect();
		$form->AddTextBox('Subject:', 'subject', '', 40);
  	$form->AddTextArea('Message:', 'message', '', 15, 72);
	  $form->AddSubmitButton('', 'Send E-Mail');
		$form->EndForm();
	}
	else {
		$send = array();
    if (substr($_REQUEST['group'], 0, 6) == 'cadre-') {

      $cadres = $roster->GetCadres();

      if ($_REQUEST['group'] == 'cadre-leaders') {

        foreach ($cadres as $cadre) {

          $leader = $cadre->GetLeader();

          $leader->SendEmail($pleb->GetName() . ' <' . $pleb->GetEmail() . '>', $_REQUEST['subject'], $_REQUEST['message']);

        }

      } else  {

        foreach ($cadres as $cadre) {

          if (   $_REQUEST['group'] == 'cadre-all'
              || (   is_numeric(substr($_REQUEST['group'], 6))
                  && substr($_REQUEST['group'], 6) == $cadre->GetID())) {

            $members = $cadre->GetMembers();

            foreach ($members as $member) {

				  		$member->SendEmail($pleb->GetName() . ' <' . $pleb->GetEmail() . '>', $_REQUEST['subject'], $_REQUEST['message']);
              
            }

          }

        }

      }

    } else {
  		$cats = $roster->GetDivisionCategories();
	  	foreach ($cats as $cat) {
		  	$divs = $cat->GetDivisions();
			  foreach ($divs as $div) {
        
				  if (   $_REQUEST['group'] == 'all' 
              || (   $_REQUEST['allactive'] 
                  && $div->GetID() != 16 
                  && $div->GetID() != 12) 
              || (   $_REQUEST['group'] == 'commish' 
                  && (   $div->GetID() == 9 
                      || $div->GetID() == 10)) 
              || $_REQUEST['group'] == 'commchief' 
              || (   is_numeric($_REQUEST['group']) 
                  && $div->GetID() == $_REQUEST['group'])) {
          
  					if ($_REQUEST['group'] == 'commchief') {
            
	  					if ($div->GetID() == 9 || $div->GetID() == 10) {
              
		  					$members = $div->GetMembers();
              
			  				foreach ($members as $member) {
                
				  				$member->SendEmail($pleb->GetName() . ' <' . $pleb->GetEmail() . '>', $_REQUEST['subject'], $_REQUEST['message']);
                
					  		}
              
						  	unset($members);
              
  						}
	  					elseif ($div->IsKabal()) {
		  					$kabal = new Kabal($div->GetID());
			  				$chief = $kabal->GetChief();
				  			$chief->SendEmail($pleb->GetName() . ' <' . $pleb->GetEmail() . '>', $_REQUEST['subject'], $_REQUEST['message']);
					  		$cra = $kabal->GetCRA();
						  	$cra->SendEmail($pleb->GetName() . ' <' . $pleb->GetEmail() . '>', $_REQUEST['subject'], $_REQUEST['message']);
							  unset($chief, $cra, $kabal);
  						}
	  					elseif ($div->IsWing()) {
		  					$wing = new Wing($div->GetID());
			  				$warden = $wing->GetWarden();
				  			$warden->SendEmail($pleb->GetName() . ' <' . $pleb->GetEmail() . '>', $_REQUEST['subject'], $_REQUEST['message']);
					  		unset($warden, $wing);
						  }
            
  					}
	  				else {
		  				$members = $div->GetMembers();
			  			foreach ($members as $member) {
				  			$member->SendEmail($pleb->GetName() . ' <' . $pleb->GetEmail() . '>', $_REQUEST['subject'], $_REQUEST['message']);
					  	}
            
						  unset($members);
            
  					}
	  			}
		  	}
			  unset($divs);
  		}
	  	unset($categories);
    }
		echo 'E-mail sent.';
	}
	
	admin_footer($auth_data);
}
?>

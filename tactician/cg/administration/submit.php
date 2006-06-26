<?php
include_once('header.php');

page_header('Submit For Event');

if ($level <= 3) {
	
	$events = array();

		if (is_array($ka->GetOpenCGs())){
			foreach ($ka->GetOpenCGs() as $CG){
				if (is_array($CG->GetHunterSignups($user->GetID()))){
					foreach ($CG->GetHunterSignups($user->GetID()) as $signup){
						if (!$signup->GetSubmitted()){
							$cadre = $signup->GetCadre();
							$event = $signup->GetEvent();
							if ($event->IsTimed()){
								if ($event->GetStart() < time() && $event->GetEnd() > time()){
									$events[] = $event;
								}
							}
						}
					}
				}
			}
		}
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>

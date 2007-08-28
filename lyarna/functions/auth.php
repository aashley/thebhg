<?php
  include_once ('roster.inc');
  $is_authorised = false;

  $valid_ids = array(2650); //Grav
  $valid_positions = array(3); // Tactician

  $rpac = array(1656, 118);
  
  $person = new Login_HTTP();
  if (in_array($person->GetID(), $valid_ids) || in_array($person->GetPosition()->GetID(), $valid_positions) || in_array($person->GetID(), $rpac)) {
	  $is_authorised = true;
  } else {
	  echo '<span style="color: red">No Authority</span>';
	  exit;
  }
?>

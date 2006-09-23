<?php
  include_once ('roster.inc');
  $is_authorised = false;

  $valid_ids = array(484, 1187, 2650); // NW, Slag, Grav.
  $valid_positions = array(4, 7); // Specialist, Marshal.

  $person = new Login_HTTP();
  if (in_array($person->GetID(), $valid_ids) || in_array($person->GetPosition()->GetID(), $valid_positions)) {
	  $is_authorised = true;
  } else {
	  echo '<span style="color: red">No Authority</span>';
	  exit;
  }
?>

<?php
  include_once ('roster.inc');
  $is_authorised = false;

  $person = new Login_HTTP();
  if ((($person->GetID() == 1187) || ($person->GetID() == 2650) || (($person->GetPosition()->GetID() == 4)))) {
	  $is_authorised = true;
  } else {
	  echo '<span style="color: red">No Authority</span>';
	  exit;
  }
?>
<?php
  include_once ('roster.inc');
  $is_authorised = FALSE;
  
  function auth_error() {
    Header("WWW-Authenticate: Basic realm=\"Lyarna System\"");
    Header("HTTP/1.0 401 Unauthorized");
    include("../header.php");
    echo "<p>You do not have permission to access this feature. Please go away.</p>";
    include("../footer.php");
  }

  function authenticate($id, $password) {
    ini_set('include_path', ini_get('include_path').':/home/thebhg/public_html/include');
    
    $hunter = new login($id, $password);
    $position_obj = $hunter->GetPosition();
    $position = $position_obj->GetID();
    $division_obj = $hunter->GetDivision();
    $division = $division_obj->getID();
    if (($hunter->IsValid()) && (($id == 484) || ($id == 2650) || (($position == 6) && ($division == 10)) || ($id == 2649))) {
      return True;
    } else {
      return False;
    }
  }

  $person = new Login_HTTP();
  if(($person->IsValid()) && (($person->GetID() == 484) || ($person->GetID() == 2650) || (($person->GetPosition()->GetID() == 6) && ($person->GetDivision()->GetID() == 10)) || ($person->GetID() == 2649))) {
	  $is_authorised = TRUE;
  } else {
	  auth_error();
	  exit;
  }
?>

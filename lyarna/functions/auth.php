<?php

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
    include_once ('roster.inc');
    $hunter = new login($id, $password);
    $position_obj = $hunter->GetPosition();
    $position = $position_obj->GetID();
    $division_obj = $hunter->GetDivision();
    $division = $division_obj->getID();
    if (($hunter->IsValid()) && (($id == 484) || ($division == 10))) {
      return True;
    } else {
      return False;
    }
  }

  if (!isset($PHP_AUTH_USER)) { // Unauthorised

    auth_error();
    exit;

  } elseif (authenticate($PHP_AUTH_USER, $PHP_AUTH_PW)) { // Authorised

    $is_authorised = TRUE;

  } else { // Unauthorised

    auth_error();
    exit;

  }

?>

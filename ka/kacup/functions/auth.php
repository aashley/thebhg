<?php

  include($path_to_base.'functions/roster.php');
  $is_authorised = FALSE;

  function auth_error() {
    global $path_to_base;
    Header("WWW-Authenticate: Basic realm=\"Lyarna System\"");
    Header("HTTP/1.0 401 Unauthorized");
    include($path_to_base."header.php");
    echo "<p>You do not have permission to access this feature. Please go away.</p>";
    include($path_to_base."footer.php");
  }

  function authenticate($id, $password) {
    global $auth_level;
    $hunter = new Login($id, $password);
    if ($hunter->IsValid()) {
      $position_obj = $hunter->GetPosition();
      $position = $position_obj->GetID();
      $division_obj = $hunter->GetDivision();
      $division = $division_obj->GetID();
      if (($id == 484) || ($id == 45) || (($position == 8) && ($division == 9))) { // JUD, PR, Me: Admins
$auth_level = 3;
        return 3;
      } elseif ((($position == 11) || ($position == 12)) && $division_obj->IsKabal()) { // CHs, CRAs: Supervisors
$auth_level = 2;
        return 2;
      } elseif ($division_obj->IsKabal()) { // Kabal Members: Plebs
$auth_level = 1;
        return 1;
      } else {
        return False;
      }
    } else {
      return False;
    }
  }

  if (!isset($PHP_AUTH_USER)) { // Unauthorised

    auth_error();
    exit;

  } else {

    $auth_level = authenticate($PHP_AUTH_USER, $PHP_AUTH_PW);

    if ($auth_level) { // Valid BHGer

      if ((!isset($min_rank)) || (isset($min_rank) && $auth_level >= $min_rank)){ // High enough rank

        $is_authorised = TRUE;
        $id = $PHP_AUTH_USER;

      } else { // Unauthorised

        auth_error();
        exit;

      }

    }

  }

?>

<?php

/**
 * Display the Citadel ChangeLog
 *
 * @access public
 * @return void
 */
function ChangeLog($crumbTrail, $path) {

  page_header($GLOBALS['site']['title'].' :: ChangeLog',
      '',
      $crumbTrail);

  print '<h1>Citadel ChangeLog</h1>'
    .'<pre>';

  $changelog = file_get_contents('ChangeLog', true);

  print htmlspecialchars($changelog);

  print '</pre>';

  page_footer();

}

?>

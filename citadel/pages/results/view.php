<?php

/**
 * Citadel :: Results :: View Result
 *
 * View a specific result
 *
 * @access public
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package Citadel
 * @version $Revision: 1.1 $
 */

/**
 * Generate the View
 *
 * @access public
 * @param array CrumbTrail from earlier pages
 * @param array path info from below this page
 * @return void
 */
function Results_View($crumbTrail, $path) {
  global $citadel;

  $path = explode('/', $path);

  switch ($path[2]) {

    case 'detailed':
      include_once 'pages/results/view/detailed.php';
      Results_View_Detailed($crumbTrail, $path[1]);
      break;

    default:
      include_once 'pages/results/view/normal.php';
      Results_View_Normal($crumbTrail, $path[1]);
      break;

  }

}

?>

<?php

/**
 * Citadel Web Interface :: Not Found
 *
 * Page to display when the requested page is invalid or can not be found
 *
 * @access public
 * @author Adam Ashley <aashley@optimiser.com>
 * @package Citadel
 * @version $Revision: 1.1 $
 */

/**
 * Render Not Found Page
 *
 * @access public
 * @param array Crumb Trail from higher pages
 * @return void
 */
function NotFound($crumbTrail) {

  if (DEBUG) {

    RegisterDebug('Called NotFound()');

  }

  $crumbTrail += array(gettext('Not Found') => $_SERVER['PATH_INFO']);

  page_header($GLOBALS['site']['title'].' :: '.gettext('Page Not Found'),
              '',
              $crumbTrail);

  print '<p>'.gettext('The page you requested does not exist within this Web '
    .'Interface.').'</p>';

  page_footer();

}

?>

<?php

/**
 * Citadel Web Interface :: Result Account Management
 *
 * The Result Account Management section of the Citadel Interface
 *
 * @access public
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package Citadel
 * @version $Revision: 1.1 $
 */

// {{{ Results()

/**
 * The decision function for the result tree
 *
 * This function takes the path and sends you to the correct page
 *
 * @access public
 * @param array The Crumb Trail from higher pages
 * @param string The directories under this one in the URL
 * @return void
 */
function Results($crumbTrail, $path) {

  if (DEBUG) {

    RegisterDebug('Called Results()');

  }

  $crumbTrail += array(gettext('Results') => $GLOBALS['site']['file_root'].'result');

  $path = explode('/', $path);

  if (isset($path[1]) && $path[1] > '') {

    $target = $path[1];

    unset($path[1]);
    
    if (DEBUG) {
      
      RegisterDebug('Passing \''.implode('/', $path).'\' to results_'.$target
          .'() '.'in pages/results/'.$target.'.php');
      
    }

    if (file_exists('pages/results/'.$target.'.php')) {

      include_once 'pages/results/'.$target.'.php';

      $target = 'results_'.$target;

      if (function_exists($target)) {

        if (DEBUG) {
  
          RegisterDebug('Calling '.$target.'()');

        }

        $target($crumbTrail, implode('/', $path));

      } else {

        include_once 'pages/notfound.php';

        if (DEBUG) {

          RegisterDebug('Calling NotFound()');

        }

        NotFound($crumbTrail);

      }

    } else {

      include_once 'pages/notfound.php';

      if (DEBUG) {

        RegisterDebug('Calling NotFound()');

      }

      NotFound($crumbTrail);

    }

  } else {

    if (DEBUG) {

      RegisterDebug('Calling ResultsMain()');

    }

    ResultsMain($crumbTrail);

  }

}

// }}}
// {{{ ResultsMain()

/**
 * The function actually Generates the Main Result management page
 *
 * @access public
 * @param array The Crumb Trail
 * @return void
 */
function ResultsMain($crumbTrail) {
  global $citadel;

  page_header($GLOBALS['site']['title'].' :: '.gettext('Results'),
      '',
      $crumbTrail);

  print '<p>Scum,</p>'
    .'<p>You shouldn\'t be here. Move along before we call the authorities.'
    .'</p>';

  page_footer();

}

// }}}
  
?>

<?php

/**
 * Citadel Web Interface
 *
 * This is the main entry point to the Citadel Web Interface. All access
 * to the Citadel system is through this page.
 *
 * @access public
 * @author Adam Ashley <aashley@optimiser.com>
 * @package Citadel
 * @version $Revision: 1.4 $
 */

// Set the Include path to include our local Object tree at the same level
// as PEAR objects
ini_set('include_path', './objects:'.ini_get('include_path'));

// Start output buffering
ob_start();

// Send the correct XHTML Content Type if the browser supports it
//if (stristr($_SERVER['HTTP_ACCEPT'],'application/xhtml+xml')) {
//  header("Content-type: application/xhtml+xml");
//} else {
//  header("Content-type: text/html");
//}
  header("Content-type: application/xhtml+xml");

// Debug statistics
define('DEBUG', false);

if (DEBUG) {

  include_once 'include/debug.php';

  RegisterDebug('Script Started');

}

/**
 * Include Framework Multi-Lingual Support
 */
require_once "include/lang.php";

/**
 * Include Citadel Configuration Options
 */
require_once "include/config.php";
/**
 * Include Layout Related Code
 */
require_once "include/layout.php";
/**
 * Include PEAR Date Object
 */
require_once "Date.php";
/**
 * Include Citadel Objects
 */
require_once "citadel.inc";

// Start Required Objects
$roster = new Roster('citadel-38learn');
$citadel = new Citadel('citadel-38learn');

  if (!isset($_SESSION['user'])) {

    $_SESSION['user'] = array();

    $_SESSION['user']['id'] = $login->storage->data['iref_user'];
    $_SESSION['user']['namespace'] = $login->storage->data['iref_namespace'];

  }

  if (DEBUG) {

    RegisterDebug('Valid Login');

  }

  // Parse the $_SERVER['PATH_INFO']
  // We only care about the first item in the path info, which sends us to the
  // various modules in the system. It is up to the individual modules to parse
  // the rest of the path for their parameters.

  $path = explode('/', $_SERVER['PATH_INFO']);

  if ($path[1] == 'logout') {

    unset($_SESSION['user']);
    $login->logout();
    Header('Location: '.$GLOBALS['site']['base_url']);

  } else {

    $crumbTrail = array('Home' => $GLOBALS['site']['base_url']);

    if (isset($path[1]) && $path[1] > '') {

      $target = strtolower($path[1]);

      unset($path[1]);

      if (DEBUG) {
        
        RegisterDebug('Passing \''.implode('/', $path).'\' to '.$target.'() '
            .'in pages/'.$target.'.php');

      }
      
      if (file_exists('pages/'.$target.'.php')) {

        include_once 'pages/'.$target.'.php';

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

      include_once 'pages/home.php';

      if (DEBUG) {

        RegisterDebug('Calling Home()');

      }

      Home($crumbTrail);

    }

  }

// Clean up the links stripping the unwanted index.php/ from it

$output = ob_get_contents();

ob_end_clean();

//print str_replace('/index.php', '/', $output);
print $output;

// if in debug mode output the debug trace
if (DEBUG) {

  ParseDebug();
  page_end();

}

?>

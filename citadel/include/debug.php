<?php

/**
 * Debug Handler
 *
 * @access private
 * @author Adam Ashley <aashley@optimiser.com>
 */

/**
 * Register a DEBUG event
 */
function RegisterDebug($desc) {

  $GLOBALS['debug'][] = array('time' => getmicrotime(),
                              'desc' => $desc);

}

/**
 * Parse the Debug Log into a nice output
 */
function ParseDebug() {

  RegisterDebug('End Debug');

  $firstitem = 0;
  $lastitem = sizeof($GLOBALS['debug']) - 1;
  
  print '<div class="debug">'
    .'<pre>'
    ."<b>Debug Information:</b>\n"

    .'Total Generation Time: '
    .number_format($GLOBALS['debug'][$lastitem]['time'] - $GLOBALS['debug'][$firstitem]['time'], 2, '.', '')
    ." seconds.\n\n";

  foreach ($GLOBALS['debug'] as $item) {

    print number_format($item['time'] - $GLOBALS['debug'][$firstitem]['time'],
                        6,
                        '.',
                        '')
      .': '.$item['desc']."\n";

  }

  print "\n<b>Useful Variables:</b>\n"
    .'$_SERVER[\'PHP_SELF\']: '.$_SERVER['PHP_SELF']."\n"
    .'$_SERVER[\'PATH_INFO\']: '.$_SERVER['PATH_INFO']."\n"
    .'$_ENV[\'LANG\']: '.$_ENV['LANG']."\n"
    .'getenv("LANG"): '.getenv("LANG")."\n";

  print "\n<b>Session Storage:</b>\n";
  print_r($_SESSION);

  print '</pre>'
    .'</div>';


}

/**
 * Return microtime as long
 */
function getmicrotime(){
    list($usec, $sec) = explode(' ', microtime());
      return ((float) $usec + (float) $sec);
}

?>

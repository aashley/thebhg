<?php

/**
 * Debug Handler
 *
 * @access private
 * @author Adam Ashley <aashley@optimiser.com>
 * @package Framework
 * @version $Rev: 262 $ $Date: 2004-02-23 08:17:24 +0800 (Mon, 23 Feb 2004) $   
 */

/**
 * Register a DEBUG event
 *
 * @param string A description of this event
 * @return void
 */
function RegisterDebug($desc) {

  $GLOBALS['debug'][] = array('time' => getmicrotime(),
                              'desc' => $desc);

}

/**
 * Parse the Debug Log into a nice output
 *
 * @return void
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
 *
 * @return float
 */
function getmicrotime(){
    list($usec, $sec) = explode(' ', microtime());
      return ((float) $usec + (float) $sec);
}


// Error Handling

error_reporting(E_ALL);

function short($str) { 
  if(strstr($str,'/')) 
    return substr(strrchr($str,'/'),1); 
  else 
    return $str; 
} 

/**
 * Generate and format back traces for error message
 */
function myErrorHandler($errno,$errstr,$errfile,$errline) { 
  $errortype = array (
      1   =>  "Error",
      2   =>  "Warning",
      4   =>  "Parsing Error",
      8   =>  "Notice",
      16  =>  "Core Error",
      32  =>  "Core Warning",
      64  =>  "Compile Error",
      128 =>  "Compile Warning",
      256 =>  "User Error",
      512 =>  "User Warning",
      1024=>  "User Notice"
      );
  
  $err = "<B>$errortype[$errno]:</B> $errstr in ".short($errfile)
    ." at line $errline<br />\n"; 
  $err .= "<b>Backtrace</b><br />\n"; 
  $trace = debug_backtrace(); 
  foreach($trace as $ent) { 
    if(isset($ent['file'])) 
      $err .= $ent['file'].':'; 
    if(isset($ent['function'])) { 
      $err .= $ent['function'].'('; 
      if(isset($ent['args'])) { 
        $args=''; 
        foreach($ent['args'] as $arg) { 
          $args.=$arg.','; 
        } 
        $err .= rtrim(short($args),','); 
      } 
      $err .= ') '; 
    } 
    if(isset($ent['line'])) 
      $err .= 'at line '.$ent['line'].' '; 
    if(isset($ent['file'])) 
      $err .= 'in '.short($ent['file']); 
    $err .= "<br />\n"; 
  }
  $err .= "<br />\n";
  if (DEBUG) {
    echo $err;
  }
} 
set_error_handler('myErrorHandler');


?>

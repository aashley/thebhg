<?php

/**
 * Web Framework Multi-Lingual Support
 *
 * This file contains the code that detects the users supported languages
 * see's if we have the language and tells gettext to use it
 */

// Start the multi-lingual support
header('Content-Type: text/html; charset=UTF-8');

// Location where our translations are
$path = dirname($_SERVER['SCRIPT_FILENAME']).'/include/locale';

// default language
$language = 'en';

if ($_SERVER['HTTP_ACCEPT_LANGUAGE'] > '') {

  $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

  foreach ($langs as $l) {

    $lang = explode(';', $l);

    if (is_dir($path.'/'.$lang[0])) {

      $language = $lang[0];

      break;

    }

  }

}

// If we are in debug mode, allow choosing of the language with a paramenter
if (DEBUG) {
  
  $language = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : $language;

}

// Set the Language
putenv("LANG=$language");
putenv("LANGUAGE=$language");
setlocale(LC_ALL, $language);
                                                                                
// Set the gettext text domain as 'messages'
$domain = 'overseer-web';
bindtextdomain($domain, $path);
bind_textdomain_codeset($domain, 'UTF-8');
textdomain($domain);

?>

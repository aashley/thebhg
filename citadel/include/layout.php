<?php

/**
 * Citadel Web Interface :: Layout Functions
 *
 * This file contains all the Layout Related Includes and Functions
 *
 * @access public
 * @author Adam Ashley <aashley@optimiser.com>
 * @package Citadel
 * @version $Revision: 1.15 $
 */

/**
 * Include Citadel Customised PEAR HTML_QuickForm Object
 */
require_once "HTML/CitadelQuickForm.php";
/**
 * Include PEAR HTML_Table Object
 */
require_once "HTML/Table.php";

// {{{ page_header()

/**
 * Page Header
 *
 * This function outputs the top of the page and the left hand menu.
 *
 * @access public
 * @param string The title of this page we are generating.
 * @param string The title displayed in the H1 tag in the content frame. If left
 *               as the default then it is set the same as $title.
 * @param array The parts to build the crumb trail out of
 * @param boolean whether this page is part of the admin system and as such
 *                should have the admin menu
 */
function page_header($title = '', 
                     $longtitle = "", 
                     $crumb = array(),
                     $pagemenu = array(),
                     $overlib = false) {

  if (DEBUG) {

    RegisterDebug('Called page_header()');

  }
  
  if ($title == '') {

    $title = $GLOBALS['site']['title'];

  }

  $keywords = $GLOBALS['site']['keywords'];
  $file_root = $GLOBALS['site']['base_url'];
  $link_root = $file_root.$GLOBALS['site']['link_prefix'];

  if ($longtitle == '') {

    $longtitle = $title;

  }

  $cout = '';
    
  if (sizeof($crumb) > 0) {

    foreach ($crumb as $item => $url) {

      if ($cout == '') {

        $cout .= '<a href="'.$url.'">'.$item.'</a> ';

      } else {

        $cout .= '> '.'<a href="'.$url.'">'.$item.'</a> ';

      }

    }

  }

  $date = new Date();
  $date->convertTZbyID('EST');
    
  $date = $date->format('%A %B %e, %Y %T %Z');

  if ($overlib) {

    $overlib = "    <div id=\"overDiv\" style=\"position:absolute; visibility:hidden; z-index:1000;\"></div>\n"
      ."    <script language=\"JavaScript\" src=\"".$file_root."javascript/overlib_mini.js\"><!-- overLIB (c) Erik Bosrup --></script>\n";

  } else {

    $overlib = '';

  }

  print <<<EOH
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
  <head>
    <title>$title</title>
    <link rel="icon" href="${file_root}images/favicon.ico" />
    <link rel="shortcut icon" href="${file_root}images/favicon.ico" />
    <link href="${file_root}style/citadel.css" rel="stylesheet" rev="stylesheet" type="text/css" />
    <link href="${file_root}style/citadel-leftmenu.css" rel="stylesheet" rev="stylesheet" type="text/css" />
    <link href="${file_root}style/citadel-rightmenu.css" rel="stylesheet" rev="stylesheet" type="text/css" />
    <meta http-equiv="Keywords" content="$keywords" />
    <script type="text/javascript">

var imgarr = new Array('${file_root}images/admin_link.jpg',
                       '${file_root}images/admin_link-over.jpg',
                       '${file_root}images/bhg_link.jpg',
                       '${file_root}images/bhg_link-over.jpg',
                       '${file_root}images/courses_link.jpg',
                       '${file_root}images/courses_link-over.jpg',
                       '${file_root}images/exam_link.jpg',
                       '${file_root}images/exam_link-over.jpg',
                       '${file_root}images/grads_link.jpg',
                       '${file_root}images/grads_link-over.jpg',
                       '${file_root}images/main_link.jpg',
                       '${file_root}images/main_link-over.jpg');
var imgTemp = new Array();

for (var i = 0; i < imgarr.length; i++) {
  imgTemp[i] = new Image();
  imgTemp[i].src = imgarr[i];
}

  </script>
  </head>
  <body>
    <div id="wrapper">
      <div id="wrapperleft">
        <div id="wrapperright">
          <div id="leftmenu">
            <a id="linkmain" href="${file_root}">Main</a>
            <a id="linkcourses" href="${file_root}courses">Courses</a>
            <a id="linkexams" href="${file_root}exams">Exams</a>
            <a id="linkgrads" href="${file_root}graduates">Graduates</a>
            <div id="slaveone">Slave One</div>
          </div>
          <div id="rightmenu">
            <div id="bobafett">Copyright 2001</div>
            <a id="linkadmin" href="${file_root}admin">Admin</a>
            <a id="linkbhg" href="http://www.thebhg.org">The BHG</a>
          </div>
          <div id="maincontent">
EOH;
  
}

// }}}
// {{{ page_footer()

/**
 * Page Footer
 *
 * This function outputs the bottom of the page.
 *
 * @access public
 */
function page_footer() {
  global $login;

  if (DEBUG) {

    RegisterDebug('Called page_footer()');

  }

  $file_root = $GLOBALS['site']['file_root'];

  $year = date('Y');

  print <<<EOF
          </div>
          <div class="clear"></div>
        </div>
      </div>
    </div>
    <div id="footer">Copyright &copy; 2003 Bounty Hunter's Guild</div>
  </body>
</html>
EOF;

  if (!DEBUG) {

    page_end();

  }

}

// }}}
// {{{ page_end()

function page_end() {
  
  print <<<EOE
  </body>
</html>              
EOE;

}

// }}}

?>

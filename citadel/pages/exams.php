<?php

/**
 * Citadel Web Interface :: Exam Account Management
 *
 * The Exam Account Management section of the Citadel Interface
 *
 * @access public
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package Citadel
 * @version $Revision: 1.2 $
 */

// {{{ Exams()

/**
 * The decision function for the exam tree
 *
 * This function takes the path and sends you to the correct page
 *
 * @access public
 * @param array The Crumb Trail from higher pages
 * @param string The directories under this one in the URL
 * @return void
 */
function Exams($crumbTrail, $path) {

  if (DEBUG) {

    RegisterDebug('Called Exams()');

  }

  $crumbTrail += array(gettext('Exams') => $GLOBALS['site']['file_root'].'exam');

  $path = explode('/', $path);

  if (isset($path[1]) && $path[1] > '') {

    $target = $path[1];

    unset($path[1]);
    
    if (DEBUG) {
      
      RegisterDebug('Passing \''.implode('/', $path).'\' to exams_'.$target
          .'() '.'in pages/exams/'.$target.'.php');
      
    }

    if (file_exists('pages/exams/'.$target.'.php')) {

      include_once 'pages/exams/'.$target.'.php';

      $target = 'exams_'.$target;

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

      RegisterDebug('Calling ExamsMain()');

    }

    ExamsMain($crumbTrail);

  }

}

// }}}
// {{{ ExamsMain()

/**
 * The function actually Generates the Main Exam management page
 *
 * @access public
 * @param array The Crumb Trail
 * @return void
 */
function ExamsMain($crumbTrail) {
  global $citadel;

  page_header($GLOBALS['site']['title'].' :: '.gettext('Exams'),
      '',
      $crumbTrail);

  print '<p>Scum,</p>'
    .'<p>Below are the Citadel exams. This section is quite simple, so even '
    .'you should have no problem. Simply choose the exam you want to take '
    .'and click on "Take Exam". Now I know you think you\'re a hotshot, but '
    .'you would be wise (you? ya right) to click on "View Course Notes" first '
    .'and do some quick studying before jumping into the exam. And remember, '
    .'your results are recorded and displayed for all to see. So if you miss '
    .'an easy question, the evidence of your ignorance will be posted for all '
    .'to see.</p>';

  $exams = &$citadel->GetExams();

  $table = new HTML_Table();

  for ($i = 0; $i < sizeof($exams); $i++) {

    $table->addRow(
        array($exams[$i]->GetName(),
              '<a href="'.$GLOBALS['site']['file_root'].'notes/'
              .strtolower($exams[$i]->GetAbbrev()).'">View Course Notes</a>',
              '<a href="'.$GLOBALS['site']['file_root'].'exams/take/'
              .strtolower($exams[$i]->GetAbbrev()).'">Take Exam</a>')
        );

  }

  print '<p>'.$table->toHtml().'</p>';

  page_footer();

}

// }}}
  
?>

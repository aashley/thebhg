<?php

/**
 * Citadel Web Interface :: Admin Account Management
 *
 * The Admin Account Management section of the Citadel Interface
 *
 * @access public
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package Citadel
 * @version $Revision: 1.8 $
 */

// {{{ Admin()

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
function Admin($crumbTrail, $path) {
  global $citadel;

  if (DEBUG) {

    RegisterDebug('Called Admin()');

  }

  $crumbTrail += array(gettext('Administration') => $GLOBALS['site']['file_root'].'admin');

  $login = new Login_HTTP();

  /* Not Needed
  if ($login->IsValid()) {*/

    $loginpos = $login->GetPosition();

    if (   $loginpos->GetID() == 5
        || in_array($login->GetID(), $citadel->GetAllMarkers(true))) {

      $path = explode('/', $path);
    
      if (isset($path[1]) && $path[1] > '') {
    
        $target = $path[1];
    
        unset($path[1]);
        
        if (DEBUG) {
          
          RegisterDebug('Passing \''.implode('/', $path).'\' to admin_'.$target
              .'() '.'in pages/admin/'.$target.'.php');
          
        }
    
        if (file_exists('pages/admin/'.$target.'.php')) {
    
          include_once 'pages/admin/'.$target.'.php';
    
          $target = 'admin_'.$target;
    
          if (function_exists($target)) {
    
            if (DEBUG) {
      
              RegisterDebug('Calling '.$target.'()');
    
            }
    
            $target($crumbTrail, implode('/', $path), $login);
    
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
    
          RegisterDebug('Calling AdminMain()');
    
        }
    
        AdminMain($crumbTrail, $login);
    
      }

    } else {

      page_header($GLOBALS['site']['title'].' :: Administration',
          '',
          $crumbTrail);

      print 'You do not have permission to access the Administration site.';

      page_footer();

    }

/* Not Needed
   } else {

    page_header($GLOBALS['site']['title'].' :: Administration',
        '',
        $crumbTrail);

    print 'Your login session is invalid. Please try again.';

    print '<pre>';
    print_r($_COOKIE);
    print '</pre>';

    page_footer();

  }*/

}

// }}}
// {{{ AdminMain()

/**
 * The function actually Generates the Main Admin management page
 *
 * @access public
 * @param array The Crumb Trail
 * @return void
 */
function AdminMain($crumbTrail, &$login) {
  global $citadel;

  page_header($GLOBALS['site']['title'].' :: '.gettext('Administration'),
      '',
      $crumbTrail);

  print '<h1>Citadel Administration</h1>';

  $loginpos = $login->GetPosition();

  if (   $loginpos->GetID() == 5
      || $login->GetID() == 94) {

    $table = new HTML_Table();

    $table->addRow(
        array('<a href="'.$GLOBALS['site']['file_root']
              .'admin/news">Manage News</a>',
              '<a href="'.$GLOBALS['site']['file_root']
              .'admin/create">Create Exam</a>'),
        array(),
        'TH');

    print '<p>'.$table->toHtml().'</p>';

  }

  $exams = &$citadel->GetExamsMarkedBy($login);

  $table = new HTML_Table();

  for ($i = 0; $i < sizeof($exams); $i++) {

    $table->addRow(
        array($exams[$i]->GetName().' ['.$exams[$i]->GetAbbrev().']',
              '<a href="'.$GLOBALS['site']['file_root'].'admin/grade/'
              .strtolower($exams[$i]->GetAbbrev()).'">Grade ('
              .$exams[$i]->CountPending().' pending)</a>',
              '<a href="'.$GLOBALS['site']['file_root'].'admin/edit/'
              .strtolower($exams[$i]->GetAbbrev()).'">Edit Exam</a>',
              '<a href="'.$GLOBALS['site']['file_root'].'admin/questions/'
              .strtolower($exams[$i]->GetAbbrev()).'">Edit Questions</a>')
        );

  }

  print '<p>'.$table->toHtml().'</p>';

  page_footer();

}

// }}}
  
?>

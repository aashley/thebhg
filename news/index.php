<?php

ob_start();

print '<HTML><HEAD><TITLE>News Test</TITLE></HEAD><BODY>';

include_once 'roster.inc';

print '<a href="'.$_SERVER['PHP_SELF'].'?mode=admin">Admin</a> '
.'<a href="backend.php">Backend</a><br><br>';

$news = new News('test-4-god');

if ($news->LoadConfig('sample.ini')) {

  if ($_REQUEST['mode'] == 'admin') {

    $news->RenderAdmin();

  } else {
    
    $news->Render();

  }

} else {

  print 'Could not load Config...<br>'
    .$news->Error().'<br>';

}

print '</BODY></HTML>';

?>

<?php

ob_start();

include_once 'roster.inc';

$news = new News('test-4-god');

if ($news->LoadConfig('sample.ini')) {

  $news->RenderBackend();

} else {

  print 'Could not load Config...<br>'
    .$news->Error().'<br>';

}

?>

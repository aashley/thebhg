<?php

function Admin_News($crumbTrail, $path) {

  page_header($GLOBALS['site']['title'].' :: Administration :: News',
      '',
      $crumbTrail);

  $news = new News('citadel-38learn');

  if ($news->LoadConfig('news.ini')) {

    $news->RenderAdmin();

  } else {

    print 'Could not load News configuration file...<br />'
      .$news->Error().'<br />';

  }

  page_footer();

}

?>

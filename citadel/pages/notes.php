<?php

function Notes($crumbTrail, $path) {
  global $citadel;

  $path = explode('/', $path);

  $exam = $citadel->GetExambyAbbrev($path[1]);

  $book = $exam->GetNotebookID();

  if ($book == 0) {

    page_header($GLOBALS['site']['title'].' :: Course Notes :: '
        .$exam->GetName(),
        '',
        $crumbTrail);

    print '<p>There is no notebook for the '.$exam->GetName().' Exam.</p>';

    page_footer();

  } else {

    Header('Location: http://holonet.thebhg.org/index.php'
        .'?module=library&page=book&id='.$book);

  }

}

?>

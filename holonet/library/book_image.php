<?php

include_once 'library.inc';

if (isset($_REQUEST['id'])) {

  $book = new Book($_REQUEST['id']);

  if ($book->HasImage()) {

    $image = $book->GetImageData();

    Header('Content-Type: '.$book->GetImageType());
    Header('Length: '.sizeof($image));

    echo $image;

  } else {
    
    print 'No Image';

  }

} else {
  
  print 'No ID';

}

?>

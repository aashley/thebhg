<?php
include_once('news-config.php');
include_once('roster.inc');

$news = new News($coder_id);

// This call should specify the filename of the config file.
if ($news->LoadConfig($ini_file)) {

	  $news->RenderBackend();

} else {

	  print 'Could not load configuration file.<bR>'
		      .$news->Error().'<br>';

}
?>

<?php ob_start(); ?>
<html>
<head>
<title>News Administration</title>
</head>
<body>
<?php

include_once('news-config.php');
include_once('roster.inc');

$news = new News($coder_id);

// This call should specify the filename of the config file.
if ($news->LoadConfig($ini_file)) {
	  $news->RenderAdmin();
} else {
	  echo 'Could not load configuration file.<br>'
		      .$news->Error().'<br>';
}

?>
</body>
</html>
<?php ob_end_flush(); ?>

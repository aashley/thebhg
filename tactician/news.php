<?php
include_once('news-config.php');
include_once('roster.inc');

$news = new News($coder_id);
if ($news->LoadConfig($ini_file)) {
	$news->Render();
}
else {
	echo 'Could not load configuration file.<br>'
		    .$news->Error() . '<br>';
}
?>

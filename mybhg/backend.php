<?php
include('header.php');
ob_clean();
header('Content-Type: text/xml; charset=ISO-8859-1');

$sections = $news->GetAvailableSections();
$sid = array();
foreach ($sections as $sec) {
	$sid[] = $sec['id'];
}
$items = $news->GetNews(10, 'posts', $sid);

echo '<?xml version="1.0" encoding="ISO-8859-1"?><rss version="0.92"><channel><title>MyBHG</title><link>http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '</link><description>The news feed for the BHG as a whole.</description><language>en</language>';

foreach ($items as $item) {
	echo '<item><title>' . htmlspecialchars($item->GetTitle()) . '</title><link>http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 'news.php#' . $item->GetID() . '</link></item>';
}

echo '</channel></rss>';

ob_end_flush();
exit();
?>

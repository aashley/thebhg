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

echo '<?xml version="1.0"?>';
?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<title>MyBHG</title>
		<link>http://<?php echo $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']); ?></link>
		<description>The news feed for the BHG as a whole.</description>
		<language>en</language>
<?php

foreach ($items as $item) {
	$link = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'index.php#'.$item->GetID();
?>
		<item>
			<title><?php echo htmlspecialchars($item->GetTitle()); ?></title>
			<link><?php echo $link; ?></link>
			<guid><?php echo $link; ?></guid>
			<pubDate><?php echo date('r', $item->GetTimestamp()); ?></pubDate>
			<description><![CDATA[<?php echo $item->Render('%message%'); ?>]]></description>
			<content:encoded><![CDATA[<?php echo $item->Render('%message%'); ?>]]></content:encoded>
			<dc:creator><?php echo htmlspecialchars($item->GetPoster()->GetName()); ?></dc:creator>
		</item>
<?php
}

?>
	</channel>
</rss>
<?php

ob_end_flush();
exit();
?>

<?php
$title = 'News';
include('header.php');

$sections = $news->GetAvailableSections();
$sid = array();
if (empty($my_user)) {
	foreach ($sections as $sec) {
		$sid[] = $sec['id'];
	}
}
else {
	$sid =& $my_sections;
}
$items = $news->GetNews($my_posts, 'posts', $sid);
display_articles($items);
?>
<?php
$show_blocks = true;
include('footer.php');
?>

<?php
$title = 'Administration :: Menu';
include('../header.php');

if (empty($my_user) || !check_auth($my_user, 1)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../footer.php');
}

$items = array(
	'News'=>array(
		'news/post.php'=>'Post Story',
		'news/edit.php'=>'Edit Story',
		'news/delete.php'=>'Delete Story'
	),
	'Calendar'=>array(
		'calendar/add.php'=>'Add Event',
		'calendar/edit.php'=>'Edit Event',
		'calendar/delete.php'=>'Delete Event'
	)
);

if (lookup_auth_level($my_user) == 2) {
	$items = array_merge($items, array(
		'Blocks'=>array(
			'blocks/add.php'=>'Add Block',
			'blocks/edit.php'=>'Edit Block',
			'blocks/delete.php'=>'Delete Block'
		),
		'Link Sections'=>array(
			'link-sections/add.php'=>'Add Link Section',
			'link-sections/edit.php'=>'Edit Link Section',
			'link-sections/delete.php'=>'Delete Link Section'
		),
		'Links'=>array(
			'links/add.php'=>'Add Link',
			'links/edit.php'=>'Edit Link',
			'links/delete.php'=>'Delete Link'
		)
	));
}

foreach ($items as $stitle=>$section) {
	echo '<b>' . $stitle . '</b><ul>';
	foreach ($section as $url=>$title) {
		echo '<li><a href="' . $url . '">' . $title . '</a></li><br />';
	}
	echo '</ul><br />';
}

include('../footer.php');
?>

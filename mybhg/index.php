<?php
$title = 'Index';
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

$welcome = $config->GetValue('welcome');
if ($welcome->IsNotDeleted()) {
	$table = new BlockTable();
	$table->StartRow();
	$table->AddHeader('Welcome');
	$table->EndRow();
	$table->AddRow($welcome->GetValue());
	$table->EndTable();
	echo '<br />';
}

display_articles($items);
?>
<?php
$show_blocks = true;
include('footer.php');
?>

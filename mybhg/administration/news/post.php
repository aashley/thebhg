<?php
$title = 'Administration :: Post News';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 1)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	if ($news->PostNews($_REQUEST['title'], $_REQUEST['body'], $my_user, $_REQUEST['section'])) {
		echo 'News posted successfully.';
	}
	else {
		echo 'Error posting news: ' . $news->Error() . '<br /><br />';
		echo 'Called $news->PostNews with the following parameters:<br />';
		echo 'title: ' . $_REQUEST['title'] . '<br />';
		echo 'body: ' . $_REQUEST['body'] . '<br />';
		echo 'user: Person(' . $my_user->GetID() . ')<br />';
		echo 'section: ' . $_REQUEST['section'];
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->AddTextBox('Title:', 'title');
	$form->AddTextArea('Article Text:', 'body', '', 10, 60);
	$form->StartSelect('Section:', 'section');
	$sections = $news->GetAvailableSections();
	foreach ($sections as $section) {
		$form->AddOption($section['id'], $section['name']);
	}
	$form->EndSelect();
	$form->AddSubmitButton('submit', 'Post Article');
	$form->EndForm();
}

include('../../footer.php');
?>

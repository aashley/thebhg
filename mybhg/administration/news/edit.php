<?php
$title = 'Administration :: Edit News';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 1)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

if ($_REQUEST['submit']) {
	$item = $news->GetItem($_REQUEST['id']);
	$poster = $item->GetPoster();
	if (lookup_auth_level($my_user) == 2 || $poster->GetID() == $my_user->GetID()) {
		if ($item->SetTitle($_REQUEST['title']) &&
		    $item->SetMessage($_REQUEST['body']) &&
		    $item->SetSection($_REQUEST['section'])) {
			echo 'Article saved successfully.';
		}
		else {
			echo 'Error saving article: ' . $item->Error();
		}
	}
	else {
		echo 'You do not have permission to edit this news item.';
	}
}
elseif ($_REQUEST['id']) {
	$item = $news->GetItem($_REQUEST['id']);
	$poster = $item->GetPoster();
	if (lookup_auth_level($my_user) == 2 || $poster->GetID() == $my_user->GetID()) {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Title:', 'title', $item->GetTitle());
		$form->AddTextArea('Article Text:', 'body', $item->GetMessage(), 10, 60);
		$form->StartSelect('Section:', 'section', $item->GetSectionID());
		$sections = $news->GetAvailableSections();
		foreach ($sections as $section) {
			$form->AddOption($section['id'], $section['name']);
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Save Article');
		$form->EndForm();
	}
	else {
		echo 'You do not have permission to edit this news item.';
	}
}
else {
	$sections = $news->GetAvailableSections();
	$sid = array();
	foreach ($sections as $sec) {
		$sid[] = $sec['id'];
	}
	
	if (isset($_REQUEST['show'])) {
		$items = $news->GetNews(-1, 'all', $sid);
	}
	else {
		echo 'Note: In order to keep the size of this list down, only articles from the last seven days are shown. If you need to edit an earlier article, please <a href="' . $PHP_SELF . '?show=all">click here to show the full list</a>. Be aware that said list may take some time to load.';
		hr();
		$items = $news->GetNews(7, 'days', $sid);
	}

	if (count($items)) {
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('News Article:', 'id');
		foreach ($items as $item) {
			$poster = $item->GetPoster();
			if (lookup_auth_level($my_user) == 2 || $poster->GetID() == $my_user->GetID()) {
				$form->AddOption($item->GetID(), '(' . $item->GetSectionName() . ') ' . $item->GetTitle());
			}
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Article');
		$form->EndForm();
	}
	else {
		echo 'No articles found.';
	}
}

include('../../footer.php');
?>

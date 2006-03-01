<?php
include_once('header.php');

page_header('Moderate News');

if (!$GLOBALS['approve']){
	echo 'You have no authority here.';
	page_footer();
	exit;
}

include_once('roster.inc');
$roster = new Roster();
$cids = array(7=>'tact-whats-that', 6=>'ka-4-hunt', 18=>'kag-73-comp', 20=>'cg-555-deer', );
$sections = array(7=>'Tactician', 6=>'Bounties', 18=>'Kabal Games', 20=>'Cadre Games');
$news = new News(($_REQUEST['section'] ? $cids[$_REQUEST['section']] : 'my-69-bhg'));

if ($GLOBALS['approve']) {
	switch ($_REQUEST['op']){
		default:
		case 'new':
			if ($_REQUEST['submit']) {
				if ($news->PostNews($_REQUEST['title'], $_REQUEST['body'], $login, $_REQUEST['section'])) {
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
				foreach ($sections as $section => $name) {
					$form->AddOption($section, $name);
				}
				$form->EndSelect();
				$form->AddSubmitButton('submit', 'Post Article');
				$form->EndForm();
			}
		break;
		
		case 'delete':
			if ($_REQUEST['submit']) {
				$item = $news->GetItem($_REQUEST['id']);
				
				if ($item->Delete()) {
					echo 'Article deleted successfully.';
				}
				else {
					echo 'Error deleting article: ' . $item->Error();
				}

			}
			else {

				$sid = array();
				foreach ($sections as $id=>$sec) {
					$sid[] = $id;
				}

				if (isset($_REQUEST['show'])) {
					$items = $news->GetNews(-1, 'all', $sid);
				}
				else {
					echo 'Note: In order to keep the size of this list down, only articles from the last seven days are shown. If you need to delete an earlier article, please <a href="' . $PHP_SELF . '?op=delete&show=all">click here to show the full list</a>. Be aware that said list may take some time to load.';
					hr();
					$items = $news->GetNews(7, 'days', $sid);
				}
			
				if (count($items)) {
					$form = new Form($_SERVER['PHP_SELF']);
					$form->StartSelect('News Article:', 'id');
					$form->addHidden('op', 'delete');
					foreach ($items as $item) {
						$form->AddOption($item->GetID(), '(' . $item->GetSectionName() . ') ' . $item->GetTitle());
					}
					$form->EndSelect();
					$form->AddSubmitButton('submit', 'Delete Article');
					$form->EndForm();
				}
				else {
					echo 'No articles found.';
				}
			}
		break;
		
		case 'edit':
		
			if ($_REQUEST['submit']) {
				$item = $news->GetItem($_REQUEST['id'], 'my-69-bhg');

				$item->SetTitle($_REQUEST['title']);
				$item->SetMessage($_REQUEST['body']);
				$item->SetSection($_REQUEST['new_section']);
				
				echo 'Article saved successfully.';
				
			}
			elseif ($_REQUEST['id']) {
				$item = $news->GetItem($_REQUEST['id']);
				
					$form = new Form($_SERVER['PHP_SELF']);
					$form->AddHidden('id', $_REQUEST['id']);
					$form->AddTextBox('Title:', 'title', $item->GetTitle());
					$form->AddTextArea('Article Text:', 'body', $item->GetMessage(), 10, 60);
					$form->StartSelect('Section:', 'new_section', $item->GetSectionID());
					$form->addHidden('section', $item->GetSectionID());
					foreach ($sections as $section => $name) {
						$form->AddOption($section, $name);
					}
					$form->EndSelect();
					$form->addHidden('op', 'edit');
					$form->AddSubmitButton('submit', 'Save Article');
					$form->EndForm();

			}
			else {
				
				$sid = array();
				foreach ($sections as $id=>$sec) {
					$sid[] = $id;
				}
				
				if (isset($_REQUEST['show'])) {
					$items = $news->GetNews(-1, 'all', $sid);
				}
				else {
					echo 'Note: In order to keep the size of this list down, only articles from the last seven days are shown. If you need to edit an earlier article, please <a href="' . $PHP_SELF . '?op=edit&show=all">click here to show the full list</a>. Be aware that said list may take some time to load.';
					hr();
					$items = $news->GetNews(7, 'days', $sid);
				}
			
				if (count($items)) {
					$form = new Form($_SERVER['PHP_SELF'], 'get');
					$form->StartSelect('News Article:', 'id');
					foreach ($items as $item) {
						$form->AddOption($item->GetID(), '(' . $item->GetSectionName() . ') ' . $item->GetTitle());
					}
					$form->EndSelect();
					$form->addHidden('op', 'edit');
					$form->AddSubmitButton('', 'Edit Article');
					$form->EndForm();
				}
				else {
					echo 'No articles found.';
				}
			}
		
		break;
	}
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>

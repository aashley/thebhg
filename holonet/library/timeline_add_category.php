<?php
function title() {
	return 'Administration :: Add Timeline Category';
}

function auth($user) {
	$pos = $user->GetPosition();
	return ($pos->GetID() == 4 || $user->GetID() == 666);
}

function output() {
	global $timeline, $page;

	menu_header();

	if ($_REQUEST['submit']) {
		if ($timeline->AddCategory($_REQUEST['name'])) {
			echo 'Category added successfully.';
		}
		else {
			echo 'Error adding category.';
		}
	}
	else {
		$form = new Form($page);
		$form->AddTextBox('Name:', 'name');
		$form->AddSubmitButton('submit', 'Add Category');
		$form->EndForm();
	}

	timeline_admin_footer();
}
?>

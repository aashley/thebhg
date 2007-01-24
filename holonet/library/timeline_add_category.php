<?php
function title() {
	return 'Administration :: Add Timeline Category';
}

function auth($user) {
	$pos = $user->GetPosition();
	return ($pos->GetID() == 4 || $pos->GetID() == 1 || $pos->GetID() == 10 || $user->GetID() == 666);
}

function output() {
	global $timeline, $page;

	menu_header();

	if ($_REQUEST['submit']) {
		if ($timeline->AddCategory($_REQUEST['name'], $_REQUEST['parent'])) {
			echo 'Category added successfully.';
		}
		else {
			echo 'Error adding category.';
		}
	}
	else {
		$form = new Form($page);
		$form->StartSelect('Parent Category:', 'parent');
		$form->AddOption(0, 'No Parent');
		timeline_form_categories($timeline->GetCategories(), 0, $form);
		$form->EndSelect();
		$form->AddTextBox('Name:', 'name');
		$form->AddSubmitButton('submit', 'Add Category');
		$form->EndForm();
	}

	timeline_admin_footer();
}
?>

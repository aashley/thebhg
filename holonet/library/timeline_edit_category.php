<?php
function title() {
	return 'Administration :: Edit Timeline Category';
}

function auth($user) {
	$pos = $user->GetPosition();
	return ($pos->GetID() == 4 || $user->GetID() == 666);
}

function output() {
	global $timeline, $page;

	menu_header();

	if ($_REQUEST['submit']) {
		$cat = $timeline->GetCategory($_REQUEST['id']);
		if ($cat->SetName($_REQUEST['name'])) {
			echo 'Category saved successfully.';
		}
		else {
			echo 'Error saving category.';
		}
	}
	elseif ($_REQUEST['id']) {
		$cat = $timeline->GetCategory($_REQUEST['id']);
		$form = new Form($page);
		$form->AddHidden('id', $_REQUEST['id']);
		$form->AddTextBox('Name:', 'name', $cat->GetName());
		$form->AddSubmitButton('submit', 'Save Category');
		$form->EndForm();
	}
	else {
		$form = new Form($page, 'get');
		$form->StartSelect('Category:', 'id');
		foreach ($timeline->GetCategories() as $cat) {
			$form->AddOption($cat->GetID(), $cat->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Edit Category');
		$form->EndForm();
	}

	timeline_admin_footer();
}
?>

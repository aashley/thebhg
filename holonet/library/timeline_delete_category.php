<?php
function title() {
	return 'Administration :: Delete Timeline Category';
}

function auth($user) {
	$pos = $user->GetPosition();
	return ($pos->GetID() == 4 || $pos->GetID() == 1 || $pos->GetID() == 10 || $user->GetID() == 666);
}

function output() {
	global $timeline, $page;

	menu_header();

	if ($_REQUEST['submit']) {
		$cat = $timeline->GetCategory($_REQUEST['id']);
		if ($cat->DeleteCategory()) {
			echo 'Category deleted successfully.';
		}
		else {
			echo 'Error deleting category.';
		}
	}
	else {
		$form = new Form($page);
		$form->StartSelect('Category:', 'id');
		timeline_form_categories($timeline->GetCategories(), 0, $form);
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Delete Category');
		$form->EndForm();
	}

	timeline_admin_footer();
}
?>

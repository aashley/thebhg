<?php
function title() {
	return 'Administration :: Delete Timeline Category';
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
		foreach ($timeline->GetCategories() as $cat) {
			$form->AddOption($cat->GetID(), $cat->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Delete Category');
		$form->EndForm();
	}

	timeline_admin_footer();
}
?>

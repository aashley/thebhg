<?php
$title = 'Administration :: Site Configuration :: Delete Variable';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

$value = $config->GetValue($_REQUEST['name']);

if ($_REQUEST['submit']) {
	if ($value->SetValue($_REQUEST['value'])) {
		echo 'Variable saved.';
	}
	else {
		echo 'Error saving variable.';
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->AddHidden('name', $value->GetName());
	$form->AddTextArea('Value:', 'value', htmlspecialchars($value->GetValue()), 10, 60);
	$form->AddSubmitButton('submit', 'Save Variable');
	$form->EndForm();
}

include('../../footer.php');
?>

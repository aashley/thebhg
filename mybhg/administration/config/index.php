<?php
$title = 'Administration :: Site Configuration';
include('../../header.php');

if (empty($my_user) || !check_auth($my_user, 2)) {
	echo 'Sorry, but you are not authorised to view this page.';
	include('../../footer.php');
}

$table = new Table();
$table->StartRow();
$table->AddHeader('Name');
$table->AddHeader('Value');
$table->AddHeader('');
$table->AddHeader('');
$table->EndRow();
foreach ($config->GetValues() as $value) {
	$table->StartRow();
	$table->AddCell($value->GetDescription());
	if ($value->IsDeleted()) {
		$table->AddCell('<i>Not set</i>');
	}
	else {
		$table->AddCell(nl2br(htmlspecialchars($value->GetValue())));
	}
	$table->AddCell('<a href="edit.php?name=' . urlencode($value->GetName()) . '">Edit</a>');
	$table->AddCell('<a href="delete.php?name=' . urlencode($value->GetName()) . '">Delete</a>');
	$table->EndRow();
}
$table->EndTable();

include('../../footer.php');
?>

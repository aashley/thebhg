<?php
function title() {
	return 'Criminals';
}

function output() {
	global $db, $page;

	if (empty($_REQUEST['status'])) $status = 0;
	else $status = $_REQUEST['status'];
	if (empty($_REQUEST['sortprice'])) $sortprice = 0;
	else $sortprice = $_REQUEST['sortprice'];
	if (empty($_REQUEST['pageno'])) $pageno = 0;
	else $pageno = $_REQUEST['pageno'];
	$sql = "SELECT criminals.id, criminals.name, statustypes.status, criminals.price FROM criminals, statustypes WHERE criminals.status=statustypes.id";
	if ($status) $sql .= " AND criminals.status=$status";
	if ($sortprice) {
		$sql .= " ORDER BY criminals.price DESC";
	}
	else {
		$sql .= " ORDER BY criminals.name ASC";
	}
	$all_crims = mysql_query($sql, $db);
	$sql .= " LIMIT " . ($pageno * 30) . ",30";
	$crims = mysql_query($sql, $db);
	if ($crims && mysql_num_rows($crims)) {
		$table = new Table('', true);
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Status');
		$table->AddHeader('Informant Price');
		$table->EndRow();
		while ($crim = mysql_fetch_array($crims)) {
			$table->AddRow('<a href="' . internal_link('criminal', array('id'=>$crim['id'])) . '">' . stripslashes($crim['name']) . '</a>', $crim['status'], ($crim['price'] ? number_format($crim['price']) . ' ICs' : 'N/A'));
		}
		$table->EndTable();
	}
	else {
		echo mysql_error($db);
		echo "No criminals found.<BR><BR>\n";
	}

	echo 'Pages: ';
	if ($pageno > 0) {
		$page_array[] = '<a href="' . internal_link($page, array('pageno'=>($pageno - 1), 'sortprice'=>$sortprice, 'status'=>$sortprice)) . '">Previous</a>';
	}
	$pagenos = ceil(mysql_num_rows($all_crims) / 30);
	for ($i = 0; $i < $pagenos; $i++) {
		if ($i == $pageno) $page_array[] = ($i + 1);
		else $page_array[] = '<a href="' . internal_link($page, array('pageno'=>$i, 'sortprice'=>$sortprice, 'status'=>$status)) . '">' . ($i + 1) . '</a>';
	}
	if ($pageno < ($pagenos - 1)) {
		$page_array[] = '<a href="' . internal_link($page, array('pageno'=>($pageno + 1), 'sortprice'=>$sortprice, 'status'=>$sortprice)) . '">Next</a>';
	}
	echo implode(' | ', $page_array);

	hr();

	$form = new Form($GLOBALS['page'], 'get', '', '', 'Options');
	$form->StartSelect('Criminals To Select:', 'status', isset($status) ? $status : false);
	$form->AddOption(0, 'All');
	$status_types = mysql_query("SELECT id, LOWER(status) AS name FROM statustypes ORDER BY name ASC", $db);
	while ($status_row = mysql_fetch_array($status_types)) {
		$form->AddOption($status_row['id'], ucwords($status_row['name']));
	}
	$form->EndSelect();
	$form->StartSelect('Sort By:', 'sortprice', $sortprice);
	$form->AddOption(0, 'Name');
	$form->AddOption(1, 'Price');
	$form->EndSelect();
	$form->AddSubmitButton('', 'Go');
	$form->EndForm();
}
?>

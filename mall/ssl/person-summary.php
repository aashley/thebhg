<?php
include('header.php');

$store = new Store();
$sales = $store->GetSales($roster->GetPerson($_REQUEST['id']));
if (is_array($sales)) {
	echo count($sales);
}
else {
	echo '0';
}
?>

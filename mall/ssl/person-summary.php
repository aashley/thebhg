<?php
include('header.php');

$store = new Store();
$sales = $store->GetSales($roster->GetPerson($id));
if (is_array($sales)) {
	echo count($sales);
}
else {
	echo '0';
}
?>

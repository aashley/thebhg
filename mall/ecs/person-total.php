<?php
include('header.php');

$store = new Store();
$sales = $store->GetSales($roster->GetPerson($_REQUEST['id']));
if (is_array($sales)) {
	foreach ($sales as $sale) {
		$item = $sale->GetItem();
		$total += ($item->GetPrice() * $sale->GetQuantity());
	}
	echo $total;
}
else {
	echo '0';
}
?>

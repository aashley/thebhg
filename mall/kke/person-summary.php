<?php
include('header.php');

$store = new Store();
$sales = $store->GetSales($roster->GetPerson($id));
if (is_array($sales)) {
	foreach ($sales as $sale) {
		$item = $sale->GetItem();
		$total += $sale->GetQuantity();
		$value += ($sale->GetQuantity() * $item->GetPrice());
	}
	echo number_format($total) . "\n" . number_format($value);
}
else {
	echo "0\n0";
}
?>

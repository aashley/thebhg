<?php
include('header.php');

$store = new Store();
$sales = $store->GetSales($roster->GetPerson($_REQUEST['id']));
if ($sales) {
	foreach ($sales as $sale) {
		$item = $sale->GetItem();
		echo '<a href="' . $base_url . 'index.php?frame=registries/item.php&amp;id=' . $sale->GetID() . '">' . $sale->GetName() . '</a> - <a href="' . $base_url . 'index.php?frame=item.php&amp;id=' . $item->GetID() . '">' . $item->GetName() . '</a> (' . number_format($sale->GetValue()) . ' ICs)<br>';
	}
}
else {
	echo 'No ' . $str_plural . ' purchased.';
}
?>

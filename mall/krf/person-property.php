<?php
include('header.php');

function sale_sort($a, $b) {
	$a = $a->GetItem();
	$b = $b->GetItem();
	if ($a->GetPrice() == $b->GetPrice()) return strcmp($a->GetName(), $b->GetName());
	elseif ($a->GetPrice() > $b->GetPrice()) return -1;
	else return 1;
}

$store = new Store();
$sales = $store->GetSales($roster->GetPerson($id));
if ($sales) {
	usort($sales, sale_sort);
	foreach ($sales as $sale) {
		$item = $sale->GetItem();
		echo $sale->GetQuantity() . ' x <a href="' . $base_url . 'index.php?frame=item.php&amp;id=' . $item->GetID() . '">' . $item->GetName() . '</a> (' . number_format($sale->GetQuantity() * $item->GetPrice()) . ' ICs)<br>';
	}
}
else {
	echo 'No ' . $str_plural . ' purchased.';
}
?>

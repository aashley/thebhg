<?php
include('header.php');
page_header();

function sale_sort($a, $b) {
	$a_item = $a->GetItem();
	$a_val = $a->GetQuantity() * $a_item->GetPrice();
	$b_item = $b->GetItem();
	$b_val = $b->GetQuantity() * $b_item->GetPrice();
	if ($a_val == $b_val) return strcmp($a_item->GetName(), $b_item->GetName());
	elseif ($a_val > $b_val) return -1;
	else return 1;
}

$store = new Store();

$div = $roster->GetDivision($id);
echo "<B>$str_name Registries - " . $div->GetName();
$dc = $div->GetCategory();
if ($dc->GetID() == 2) {
	echo ' Kabal';
}
echo '</B><HR NOSHADE SIZE=2>';

echo '<CENTER><TABLE CELLSPACING=1 CELLPADDING=2 WIDTH="100%"><TR><TH>Name</TH><TH>' . ucwords($str_plural) . '</TH><TH>Value</TH><TH COLSPAN=2>&nbsp;</TH></TR>';

$plebs = $div->GetMembers();
foreach ($plebs as $pleb) {
	$rank = $pleb->GetRank();
	$position = $pleb->GetPosition();
	$sales = $store->GetSales($pleb);
	$csales = $sales ? count($sales) : 1;
	echo '<TR VALIGN="top"><TD ROWSPAN="' . $csales . '"><A NAME="' . $pleb->GetID() . '"></A><A HREF="' . roster_person($pleb->GetID()) . '" TARGET="_blank">' . $rank->GetName() . ' ' . $pleb->GetName() . '</A><BR><SMALL>Position: ' . $position->GetName() . '<BR>Account Balance: ' . ($rank->IsUnlimitedCredits() ? 'N/A' : number_format($pleb->GetAccountBalance()) . ' ICs') . '</TD>';
	if ($sales) {
		usort($sales, sale_sort);
		$first = true;
		foreach ($sales as $sale) {
			$item = $sale->GetItem();
			if ($first) {
				$first = false;
			}
			else {
				echo '<TR>';
			}
			echo '<TD><SMALL>' . $sale->GetQuantity() . ' x <A HREF="../item.php?id=' . $item->GetID() . '">' . $item->GetName() . '</A></SMALL></TD><TD><SMALL>' . number_format($sale->GetQuantity() * $item->GetPrice()) . ' ICs</SMALL></TD><TD><SMALL><A HREF="transfer.php?id=' . $sale->GetID() . '">Transfer</A></SMALL></TD><TD><SMALL><A HREF="delete.php?id=' . $sale->GetID() . '">Refund</A></SMALL></TD></TR>';
		}
	}
	else {
		echo "<TD COLSPAN=4><CENTER><SMALL>No $str_plural sold to this person.</SMALL></CENTER></TD></TR>";
	}
}

echo '</TABLE></CENTER>';

reg_footer();
?>

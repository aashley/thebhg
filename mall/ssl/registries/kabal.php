<?php
include('header.php');
page_header();

function sale_sort($a, $b) {
	if ($a->GetValue() == $b->GetValue()) return strcmp($a->GetName(), $b->GetName());
	elseif ($a->GetValue() > $b->GetValue()) return -1;
	else return 1;
}

$store = new Store();

$div = $roster->GetDivision($_REQUEST['id']);
echo "<H1>$str_name Registries - " . $div->GetName();
$dc = $div->GetCategory();
if ($dc->GetID() == 2) {
	echo ' Kabal';
}
echo '</H1><HR NOSHADE SIZE=2>';

$ss_title = ucwords($str_singular);
echo "<CENTER><TABLE CELLSPACING=1 CELLPADDING=2 WIDTH=\"100%\"><TR><TH>Person</TH><TH>$ss_title Name</TH><TH>$ss_title Type</TH><TH>Value</TH></TR>";

$plebs = $div->GetMembers();
foreach ($plebs as $pleb) {
	$rank = $pleb->GetRank();
	$position = $pleb->GetPosition();
	start_timer('Get Sales for ' . $pleb->GetName());
	$sales = $store->GetSales($pleb);
	end_timer('Get Sales for ' . $pleb->GetName());
	add_timer('Total Get Sales', $timers['Get Sales for ' . $pleb->GetName()]);
	$csales = $sales ? count($sales) : 1;
	echo '<TR VALIGN="top"><TD ROWSPAN="' . $csales . '"><A NAME="' . $pleb->GetID() . '"></A><A HREF="' . roster_person($pleb->GetID()) . '" TARGET="_blank">' . $rank->GetName() . ' ' . $pleb->GetName() . '</A><BR><SMALL>Position: ' . $position->GetName() . '<BR>Account Balance: ' . ($rank->IsUnlimitedCredits() ? 'N/A' : number_format($pleb->GetAccountBalance()) . ' ICs') . '</SMALL></TD>';
	if ($sales) {
		start_timer('Sale Sort (ignore)');
		//usort($sales, sale_sort);
		end_timer('Sale Sort (ignore)');
		add_timer('Total Sorting in sale_sort', $timers['Sale Sort (ignore)']);
		$first = true;
		foreach ($sales as $sale) {
			start_timer('GetItem (ignore)');
			$item = $sale->GetItem();
			end_timer('GetItem (ignore)');
			add_timer('Total Get Items', $timers['GetItem (ignore)']);
			if ($first) {
				$first = false;
			}
			else {
				echo '<TR VALIGN="top">';
			}
			if ($sale->GetName()) {
				$name = $sale->GetName();
			}
			else {
				$name = '(No Name)';
			}
			echo '<TD><SMALL><CENTER><A HREF="item.php?id=' . $sale->GetID() . '">' . htmlspecialchars($name) . '</A></CENTER></SMALL></TD><TD><SMALL><CENTER>' . $item->GetName() . '</CENTER></SMALL></TD><TD><SMALL><CENTER>' . number_format($sale->GetValue()) . ' ICs</CENTER></SMALL></TD></TR>';
		}
	}
	else {
		echo "<TD COLSPAN=\"3\"><SMALL><CENTER>No $str_plural sold to this person.</CENTER></SMALL></TD></TR>";
	}
}

echo '</TABLE></CENTER>';

reg_footer();
?>

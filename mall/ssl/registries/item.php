<?php
include('header.php');
page_header();

$sale = new Sale($_REQUEST['id']);
$item = $sale->GetItem();
$pleb = $sale->GetOwner();

echo '<H1>' . $sale->GetName() . ' owned by ' . $pleb->GetName() . '</H1><BR>';
echo "<A HREF=\"edit.php?id=".$_REQUEST['id']."\">Edit this " . $str_singular . '</A><BR>';
if ($auction = $sale->GetAuction()) {
	if ($auction->GetEnd() >= time()) {
		echo "This $str_singular is up for sale. <A HREF=\"auction-withdraw.php?id=".$_REQUEST['id']."\">Click here</A> to withdraw it.<HR NOSHADE SIZE=2>";
	}
	else {
		echo "The auction involving this $str_singular has finished. <A HREF=\"auction-sell.php?id=".$_REQUEST['id']."\">Click here</A> to sell the $str_singular or withdraw it from sale.<HR NOSHADE SIZE=2>";
	}
}
else {
	echo "<A HREF=\"auction.php?id=".$_REQUEST['id']."\">Auction this $str_singular</A><HR NOSHADE SIZE=2>";
}

echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
echo '<TR><TH COLSPAN=2>Basic ' . ucwords($str_singular) . ' Information</TH></TR>';
echo '<TR><TH CLASS="RIGHT">Name:</TH><TD>' . $sale->GetName() . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Type:</TH><TD><A HREF="../item.php?id=' . $item->GetID() . '">' . $item->GetName() . '</A></TD></TR>';
echo '<TR><TH CLASS="RIGHT">Value:</TH><TD>' . number_format($sale->GetValue()) . ' ICs</TD></TR>';
echo '</TABLE><HR NOSHADE SIZE=2>';

echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
echo '<TR><TH COLSPAN=2>Current Specifications</TH></TR>';
echo '<TR><TH CLASS="RIGHT">Consumables:</TH><TD>' . number_format($sale->GetConsumables()) . ' day' . ($sale->GetConsumables() > 1 ? 's' : '') . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Hull:</TH><TD>' . number_format($sale->GetHull()) . ' RU</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Shields:</TH><TD>' . number_format($sale->GetShields()) . ' SBD</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Speed:</TH><TD>' . number_format($sale->GetSpeed()) . ' MGLT</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Acceleration:</TH><TD>' . number_format($sale->GetAcceleration()) . ' MGLT/sec</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Maneuverability:</TH><TD>' . number_format($sale->GetTurnRate()) . ' DPF</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Hyperdrive Factor:</TH><TD>';
if ($sale->GetHyperdrive()) echo 'x' . number_format($sale->GetHyperdrive(), 2);
else echo 'No hyperdrive fitted';
echo '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Power:</TH><TD>' . number_format(-1 * $sale->GetPower()) . ' units available</TD></TR>';
echo '</TABLE><HR NOSHADE SIZE=2>';

echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
echo '<TR><TH COLSPAN=4>' . ucwords($bay_plural) . ' and ' . ucwords($mod_plural) . '</TH></TR>';
$bays = $item->GetBays();
if ($bays) {
	foreach ($bays as $hullbay) {
		$bay = $hullbay->GetBay();
		$parts = $sale->GetPartsInBay($hullbay);
		$first = true;
		$size = $sale->GetFreeSpace($hullbay);
		echo '<TR VALIGN="top"><TD ROWSPAN="' . ($parts ? count($parts) : 1) . '">' . $bay->GetName() . '<BR><SMALL>Total Size: ' . number_format($hullbay->GetSize()) . " $vol_plural<BR>Free Space: " . number_format($size) . " $vol_plural" . ($bay->GetExternal() ? '<BR>External access' : '') . '</SMALL></TD>';
		if ($parts) {
			foreach ($parts as $part) {
				if ($first) {
					$first = false;
				}
				else {
					echo '<TR VALIGN="top">';
				}
				echo '<TD><SMALL><A HREF="../part.php?id=' . $part->GetID() . '">' . $part->GetName() . '</A></SMALL></TD><TD><SMALL>' . number_format($part->GetSize()) . ' ' . ($part->GetSize() == 1 ? $vol_singular : $vol_plural) . '</SMALL></TD><TD><SMALL>' . number_format($part->GetPrice()) . ' ICs</SMALL></TD></TR>';
			}
		}
		else {
			echo '<TD COLSPAN=3><SMALL>No parts have been placed in this bay.</SMALL></TD></TR>';
		}
	}
}
echo '</TABLE><HR NOSHADE SIZE=2>';

echo '<TABLE CELLSPACING=1 CELLPADDING=2><TR><TH>' . ucwords($str_singular) . ' Description</TH></TR>';
echo '<TR><TD>' . htmlspecialchars(nl2br($sale->GetDescription())) . '</TD></TR></TABLE><HR NOSHADE SIZE=2>';

echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
echo '<TR><TH COLSPAN=2>' . ucwords($str_singular) . ' History</TH></TR>';
$history = $sale->GetHistory();
$events = $history->GetEvents();
if ($events) {
	foreach ($events as $event) {
		echo '<TR VALIGN="top"><TD><SMALL>' . date('D j/n/Y \a\t g:i:s', $event->GetTime()) . '</SMALL></TD><TD><SMALL>' . $event->GetEventText() . '</TD></TR>';
	}
}
echo '</TABLE>';

reg_footer();
?>

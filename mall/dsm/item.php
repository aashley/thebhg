<?php
include('header.php');
page_header();

$item = new Item($id);

echo '<H1>' . $item->GetName() . "</H1><HR NOSHADE SIZE=2>\n";
if ($item->HasImage()) echo "<IMG SRC=\"image.php?id=$id\" ALT=\"Ship Image\"><HR NOSHADE SIZE=2>\n";
echo $item->GetDescription() . "<HR NOSHADE SIZE=2>\n";

echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
echo '<TR><TH CLASS="RIGHT">Name:</TH><TD>' . $item->GetName() . '</TD></TR>';
$type = $item->GetItemType();
echo '<TR><TH CLASS="RIGHT">Type:</TH><TD>' . $type->GetName() . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Number Sold:</TH><TD>' . number_format($item->GetTotalSales()) . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Sales Limit:</TH><TD>' . ($item->GetLimit() ? $item->GetLimit() : 'Unlimited') . ($item->GetShipOnly() ? ' (sold only as complete ship)' : '') . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Cost:</TH><TD>' . number_format($item->GetPrice()) . ' ICs</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Restrictions:</TH><TD>';
if ($item->GetRestriction() >= 1 && $item->GetRestriction() <= 3 && ($item->GetMin() != -1 || $item->GetMax() != -1)) {
	if ($item->GetMin() == $item->GetMax()) {
		switch ($item->GetRestriction()) {
			case 1:
				$rank = new Rank($item->GetMin());
				echo 'Must be a ' . $rank->GetName();
				break;
			case 2:
				$pos = new Position($item->GetMin());
				echo 'Must hold the position of ' . $pos->GetName();
				break;
			case 3:
				$div = new Division($item->GetMin());
				echo 'Must be in ' . $div->GetName();
		}
	}
	elseif ($item->GetMin() == -1) {
		switch ($item->GetRestriction()) {
			case 1:
				$rank = new Rank($item->GetMax());
				echo 'Must hold a rank no higher than ' . $rank->GetName();
				break;
			case 2:
				$pos = new Position($item->GetMax());
				echo 'Must hold a position no higher than ' . $pos->GetName();
		}
	}
	elseif ($item->GetMax() == -1) {
		switch ($item->GetRestriction()) {
			case 1:
				$rank = new Rank($item->GetMin());
				echo 'Must hold the rank of ' . $rank->GetName() . ' or higher';
				break;
			case 2:
				$pos = new Position($item->GetMin());
				echo 'Must hold a position of ' . $pos->GetName() . ' or higher';
		}
	}
	else {
		switch ($item->GetRestriction()) {
			case 1:
				$min = new Rank($item->GetMin());
				$max = new Rank($item->GetMax());
				echo 'Must hold a rank between ' . $min->GetName() . ' and ' . $max->GetName();
				break;
			case 2:
				$min = new Position($item->GetMin());
				$max = new Position($item->GetMax());
				echo 'Must hold a position between ' . $min->GetName() . ' and ' . $max->GetName();
		}
	}
}
else echo 'No restriction';
echo '</TD></TR>';
$bays = $item->GetBays();
echo '<TR VALIGN="top"><TH CLASS="RIGHT" ROWSPAN=' . count($bays) . '>'.ucwords($bay_plural).':</TH>';
if ($bays) {
	$first = true;
	foreach ($bays as $hullbay) {
		$bay = $hullbay->GetBay();
		$size = $hullbay->GetSize();
		$bays_output[] = ($first == false ? '<TR>' : '') . '<TD>' . $bay->GetName() . '<BR><SMALL>Size: ' . $size . ' ' . ($size > 1 ? $vol_plural : $vol_singular) . ($bay->GetExternal() ? '<BR>External access provided' : '') . '</SMALL></TD></TR>';
		$first = false;
	}
	echo implode('', $bays_output);
}
else {
	echo '<TD>No bays included.</TD>';
}
echo '</TR>';
echo "</TABLE><BR>\n";

echo '<A HREF="buy.php?id=' . $item->GetID() . '">Buy This Item</A>';

page_footer();
?>

<?php
include('header.php');
page_header();

$ship_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."ships WHERE id=$id", $db);
$item = new Item(mysql_result($ship_result, 0, 'hull'));

echo '<H1>' . stripslashes(mysql_result($ship_result, 0, 'name')) . "</H1><HR NOSHADE SIZE=2>\n";
if ($item->HasImage()) echo "<IMG SRC=\"image.php?id=$id\" ALT=\"Ship Image\"><HR NOSHADE SIZE=2>\n";
echo stripslashes(mysql_result($ship_result, 0, 'description')) . "<HR NOSHADE SIZE=2>\n";

echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
echo '<TR><TH CLASS="RIGHT">Name:</TH><TD>' . stripslashes(mysql_result($ship_result, 0, 'name')) . '</TD></TR>';
$type_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'shiptypes WHERE id='.mysql_result($ship_result, 0, 'type'), $db);
echo '<TR><TH CLASS="RIGHT">Type:</TH><TD>' . stripslashes(mysql_result($type_result, 0, 'name')) . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Number Sold:</TH><TD>' . number_format($item->GetTotalSales()) . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Sales Limit:</TH><TD>' . ($item->GetLimit() ? $item->GetLimit() : 'Unlimited') . ($item->GetShipOnly() ? ' (sold only as complete ship)' : '') . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Cost:</TH><TD>' . number_format(mysql_result($ship_result, 0, 'price')) . ' ICs</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Base ' . ucwords($str_singular) . ':</TH><TD><A HREF="item.php?id=' . $item->GetID() . '">' . $item->GetName() . '</A></TD></TR>';
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
echo '</TD></TR></TABLE><HR NOSHADE SIZE=2>';

$parts_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'shipparts WHERE ship='.$id, $db);
$hull = $item->GetHullStrength();
$hyper = 1000;
if ($parts_result && mysql_num_rows($parts_result)) {
	while ($part_row = mysql_fetch_array($parts_result)) {
		$stats = new Stats($part_row['part']);
		$cons += $stats->GetConsumables();
		$hull += $stats->GetHull();
		$shields += $stats->GetShields();
		$speed += $stats->GetSpeed();
		$accel += $stats->GetAcceleration();
		$turn += $stats->GetTurnRate();
		if ($stats->GetHyperdrive() > 0.0 && $hyper > $stats->GetHyperdrive()) $hyper = $stats->GetHyperdrive();
		$power += $stats->GetPower();
	}
}

echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
echo '<TR><TH COLSPAN=3>' . ucwords($bay_plural) . ' and ' . ucwords($mod_plural) . '</TH></TR>';
$bays = $item->GetBays();
if ($bays) {
	foreach ($bays as $hullbay) {
		$bay = $hullbay->GetBay();
		$size = $hullbay->GetSize();
		$parts_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'shipparts WHERE ship='.$id.' AND hullbay='.$hullbay->GetID(), $db);
		$parts = array();
		if ($parts_result && mysql_num_rows($parts_result)) {
			while ($part_row = mysql_fetch_array($parts_result)) {
				$parts[] = new Part($part_row['part']);
			}
		}
		if ($parts) {
			foreach ($parts as $part) {
				$size -= $part->GetSize();
			}
		}
		echo '<TR VALIGN="top"><TD ROWSPAN="' . ($parts ? count($parts) : 1) . '">' . $bay->GetName() . '<BR><SMALL>Total Size: ' . number_format($hullbay->GetSize()) . " $vol_plural<BR>Free Space: " . number_format($size) . " $vol_plural" . ($bay->GetExternal() ? '<BR>External access' : '') . '</SMALL></TD>';
		if ($parts) {
			$first = true;
			foreach ($parts as $part) {
				if ($first) {
					$first = false;
				}
				else {
					echo '<TR VALIGN="top">';
				}
				echo '<TD><SMALL><A HREF="part.php?id=' . $part->GetID() . '">' . $part->GetName() . '</A></SMALL></TD><TD><SMALL>' . number_format($part->GetSize()) . ' ' . ($part->GetSize() == 1 ? $vol_singular : $vol_plural) . '</SMALL></TD></TR>';
			}
		}
		else {
			echo '<TD COLSPAN=2><SMALL>No parts have been placed in this bay.</SMALL></TD></TR>';
		}
	}
}
else {
	echo 'No bays included.';
}
echo "</TABLE><BR>\n";

echo '<A HREF="shipbuy.php?id=' . $id . '">Buy This Item</A>';

page_footer();
?>

<?php
include('header.php');
page_header();

$item = new Part($id);

echo '<H1>' . $item->GetName() . "</H1><BR>\n";
echo $item->GetDescription() . "<HR NOSHADE SIZE=2>\n";

echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
echo '<TR><TH CLASS="RIGHT">Name:</TH><TD>' . $item->GetName() . '</TD></TR>';
$type = $item->GetPartType();
echo '<TR><TH CLASS="RIGHT">Type:</TH><TD>' . $type->GetName() . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Number Sold:</TH><TD>' . number_format($item->GetTotalSales()) . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Sales Limit:</TH><TD>' . ($item->GetLimit() ? $item->GetLimit() : 'Unlimited') . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Cost:</TH><TD>' . number_format($item->GetPrice()) . ' ICs</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Size:</TH><TD>' . number_format($item->GetSize()) . ($item->GetSize() > 1 ? " $vol_plural" : " $vol_singular") . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">&nbsp;</TH><TD>' . ($item->GetExternal() ? 'External access required' : 'External access not required') . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Restrictions:</TH><TD>';
$rest = false;
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
	$rest = true;
}
if ($item->GetBay()) {
	if ($rest) echo '<BR>';
	else $rest = true;
	$bay = $item->GetBay();
	$name = $bay->GetName();
	echo 'Must be placed in a';
	if (in_array(strtolower($name{0}), array('a', 'e', 'i', 'o', 'u'))) echo 'n';
	echo ' ' . $bay->GetName();
}
if ($rest == false) echo 'No restriction';
echo '</TD></TR>';
echo "</TABLE><HR NOSHADE SIZE=2>\n";

echo '<U>Specifications</U><TABLE CELLSPACING=1 CELLPADDING=2>';
$stats = $item->GetStats();
if ($stats->GetConsumables()) echo '<TR><TH CLASS="RIGHT">Consumables:</TH><TD>' . $stats->GetConsumables() . ' days</TD></TR>';
if ($stats->GetHull()) echo '<TR><TH CLASS="RIGHT">Hull:</TH><TD>' . $stats->GetHull() . ' RU</TD></TR>';
if ($stats->GetShields()) echo '<TR><TH CLASS="RIGHT">Shields:</TH><TD>' . $stats->GetShields() . ' SBD</TD></TR>';
if ($stats->GetSpeed()) echo '<TR><TH CLASS="RIGHT">Speed:</TH><TD>' . $stats->GetSpeed() . ' MGLT</TD></TR>';
if ($stats->GetAcceleration()) echo '<TR><TH CLASS="RIGHT">Acceleration:</TH><TD>' . $stats->GetAcceleration() . ' MGLT/sec</TD></TR>';
if ($stats->GetTurnRate()) echo '<TR><TH CLASS="RIGHT">Maneuverability:</TH><TD>' . $stats->GetTurnRate() . ' DPF</TD></TR>';
if ($stats->GetHyperdrive() > 0.0) echo '<TR><TH CLASS="RIGHT">Hyperdrive:</TH><TD>x' . number_format($stats->GetHyperdrive(), 2) . '</TD></TR>';
if ($stats->GetPower()) echo '<TR><TH CLASS="RIGHT">Power:</TH><TD>' . $stats->GetPower() . ' units</TD></TR>';
echo '</TABLE><HR NOSHADE SIZE=2>';

echo '<A HREF="partbuy.php?id=' . $item->GetID() . '">Buy This Part</A>';

page_footer();
?>

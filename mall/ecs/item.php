<?php
include('header.php');
page_header();
ini_set('include_path', ini_get('include_path').':/home/thebhg/public_html/include:/home/thebhg/public_html/holonet/include');
include_once('roster.inc');
$roster_pass = 'roster-69god';

$item = new Item($id);

echo '<H1>' . $item->GetName() . "</H1><HR NOSHADE SIZE=2>\n";
echo $item->GetDescription() . "<HR NOSHADE SIZE=2>\n";

echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
echo '<TR><TH CLASS="RIGHT">Name:</TH><TD>' . $item->GetName() . '</TD></TR>';
$type = $item->GetType();
echo '<TR><TH CLASS="RIGHT">Type:</TH><TD>' . $type->GetName() . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Number Sold:</TH><TD>' . number_format($item->GetTotalSales()) . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Sales Limit:</TH><TD>' . ($item->GetLimit() ? $item->GetLimit() : 'Unlimited') . '</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Cost:</TH><TD>' . number_format($item->GetPrice()) . ' ICs</TD></TR>';
echo '<TR><TH CLASS="RIGHT">Restrictions:</TH><TD>';
if ($item->GetRestriction() >= 1 && $item->GetRestriction() <= 3 && ($item->GetMin() != -1 || $item->GetMax() != -1)) {
	if ($item->GetMin() == $item->GetMax()) {
		switch ($item->GetRestriction()) {
			case 1:
				$rank = new Rank($item->GetMin(), $roster_pass);
				echo 'Must be a ' . $rank->GetName();
				break;
			case 2:
				$pos = new Position($item->GetMin(), $roster_pass);
				echo 'Must hold the position of ' . $pos->GetName();
				break;
			case 3:
				$div = new Division($item->GetMin(), $roster_pass);
				echo 'Must be in ' . $div->GetName();
		}
	}
	elseif ($item->GetMin() == -1) {
		switch ($item->GetRestriction()) {
			case 1:
				$rank = new Rank($item->GetMax(), $roster_pass);
				echo 'Must hold a rank no higher than ' . $rank->GetName();
				break;
			case 2:
				$pos = new Position($item->GetMax(), $roster_pass);
				echo 'Must hold a position no higher than ' . $pos->GetName();
		}
	}
	elseif ($item->GetMax() == -1) {
		switch ($item->GetRestriction()) {
			case 1:
				$rank = new Rank($item->GetMin(), $roster_pass);
				echo 'Must hold the rank of ' . $rank->GetName() . ' or higher';
				break;
			case 2:
				$pos = new Position($item->GetMin(), $roster_pass);
				echo 'Must hold a position of ' . $pos->GetName() . ' or higher';
		}
	}
	else {
		switch ($item->GetRestriction()) {
			case 1:
				$min = new Rank($item->GetMin(), $roster_pass);
				$max = new Rank($item->GetMax(), $roster_pass);
				echo 'Must hold a rank between ' . $min->GetName() . ' and ' . $max->GetName();
				break;
			case 2:
				$min = new Position($item->GetMin(), $roster_pass);
				$max = new Position($item->GetMax(), $roster_pass);
				echo 'Must hold a position between ' . $min->GetName() . ' and ' . $max->GetName();
		}
	}
}
else echo 'No restriction';
echo '</TD></TR>';
echo "</TABLE><BR>\n";

echo '<A HREF="buy.php?id=' . $item->GetID() . '">Buy This Item</A>';

page_footer();
?>

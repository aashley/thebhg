<?php
include('header.php');

page_header();

function credit_sort($a, $b) {
	if ($a->GetPrice() == $b->GetPrice()) {
		if ($a->GetName() > $b->GetName()) return 1;
		elseif ($a->GetName() == $b->GetName()) return 0;
		else return -1;
	}
	elseif ($a->GetPrice() > $b->GetPrice()) return 1;
	else return -1;
}

$type = new PartType($id);
echo '<H1>' . $type->GetName() . "</H1><BR>\n";
echo $type->GetDescription() . "<HR NOSHADE SIZE=2>\n";

$items = $type->GetParts();
if ($items) {
	usort($items, credit_sort);
	echo '<TABLE CELLSPACING=1 CELLPADDING=2><TR><TH>Name</TH><TH>Value</TH></TR>';
	for ($i = 0; $i < count($items); $i++) {
		echo '<TR><TD><A HREF="part.php?id=' . $items[$i]->GetID() . '">' . $items[$i]->GetName() . '</A></TD><TD>' . number_format($items[$i]->GetPrice()) . ' ICs</TD></TR>';
	}
	echo "</TABLE><HR NOSHADE SIZE=2>\n";
}

page_footer();
?>

<?php
include('header.php');

if ($filter == 3) {
	if (!isset($PHP_AUTH_USER) || strlen($PHP_AUTH_USER) == 0) {
		header("WWW-Authenticate: Basic realm=\"$str_abbrev Purchasing\"");
		header('HTTP/1.0 401 Forbidden');
		page_header();
		echo 'Achtung!';
		page_footer();
		die();
	}
	else {
		$login = new Login($PHP_AUTH_USER, $PHP_AUTH_PW);
		if (!$login->IsValid()) {
			header("WWW-Authenticate: Basic realm=\"$str_abbrev Purchasing\"");
			header('HTTP/1.0 401 Forbidden');
			page_header();
			echo 'Achtung! Your password is wrong!';
			page_footer();
			die();
		}
	}
}

function show_auctions($auctions) {
	if ($auctions) {
		foreach ($auctions as $auction) {
			if (($auction->GetEnd() + 604800) < time()) {
				$auction->Withdraw();
				continue;
			}
			$sale = $auction->GetSale();
			$owner = $sale->GetOwner();
			$bids = $auction->GetBids();
			echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
			echo '<TR><TH>Name:</TH><TD><A HREF="registries/item.php?id=' . $sale->GetID() . '">' . $sale->GetName() . '</A></TD></TR>';
			echo '<TR><TH>Owner:</TH><TD><A HREF="' . roster_person($owner->GetID()) . '">' . $owner->GetName() . '</A></TD></TR>';
			echo '<TR><TH>Current Value:</TH><TD>' . number_format($sale->GetValue()) . ' ICs</TD></TR>';
			echo '<TR><TH>Minimum Bid Accepted:</TH><TD>' . number_format($auction->GetMinimum()) . ' ICs' . ($auction->GetEnforce() ? ' (hard limit)' : '') . '</TD></TR>';
			echo '<TR><TH>Maximum Bid Made:</TH><TD>';
			if ($bids) {
				foreach ($bids as $bid) {
					if ($bid->IsValid()) {
						echo number_format($bids[0]->GetBid()) . ' ICs';
						break;
					}
				}
			}
			else {
				echo 'No bids made as yet.';
			}
			echo '</TD></TR>';
			if ($auction->GetEnd() >= time()) {
				echo '<TR><TH>Time Remaining:</TH><TD>' . format_time($auction->GetEnd() - time()) . '</TD></TR>';
				echo '<TR><TD COLSPAN=2><SPAN ALIGN="right"><A HREF="bid.php?id=' . $auction->GetID() . '">Make A Bid</A></SPAN></TD></TR>';
			}
			else {
				echo '<TR><TD COLSPAN=2>This auction is closed.</TD></TR>';
			}
			echo '</TABLE><HR NOSHADE SIZE=2>';
		}
	}
	else {
		echo 'There are no auctions in this category.';
	}
}

page_header();

$auction = new Auction($id);
$sale = $auction->GetSale();
$pleb = $roster->GetPerson($PHP_AUTH_USER);
$store = new Store();

echo '<H1>Junkyard - Showing ';

if (empty($filter)) {
	$filter = 0;
}

switch ($filter) {
	case 0:
		$auctions = $store->GetAuctions(false, true);
		echo 'open auctions';
		break;
	case 1:
		$auctions = $store->GetAuctions(false, false);
		echo 'finished auctions';
		break;
	case 2:
		$auctions = $store->GetAuctions(true);
		echo 'all auctions';
		break;
	case 3:
		$auctions = $store->GetMyAuctions($pleb);
		echo 'my auctions';
}

echo "</H1><BR><A HREF=\"$PHP_SELF?filter=0\">Show open auctions</A> | <A HREF=\"$PHP_SELF?filter=1\">Show finished auctions</A> | <A HREF=\"$PHP_SELF?filter=2\">Show all auctions</A> | <A HREF=\"$PHP_SELF?filter=3\">Show my auctions</A>";

if ($filter != 3) {
	echo '<HR NOSHADE SIZE=2>';
	show_auctions($auctions);
}
else {
	echo '<HR NOSHADE SIZE=2><B>Auctions being run by me</B><BR><BR>';
	show_auctions($auctions[0]);
	echo '<HR NOSHADE SIZE=2><B>Auctions I\'ve bidded on</B><BR><BR>';
	show_auctions($auctions[1]);
}

page_footer();
?>

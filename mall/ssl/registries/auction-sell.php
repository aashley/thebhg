<?php
include('header.php');
page_header();

$sale = new Sale($_REQUEST['id']);
$auction = $sale->GetAuction();
$item = $sale->GetItem();
$pleb = $sale->GetOwner();

if (!isset($PHP_AUTH_USER) || strlen($PHP_AUTH_USER) == 0) {
	header("WWW-Authenticate: Basic realm=\"$str_abbrev Purchasing\"");
	header('HTTP/1.0 401 Forbidden');
	echo 'Achtung!';
	page_footer();
	die();
}
else {
	$login = new Login($PHP_AUTH_USER, $PHP_AUTH_PW);
	if (!$login->IsValid()) {
		header("WWW-Authenticate: Basic realm=\"$str_abbrev Purchasing\"");
		header('HTTP/1.0 401 Forbidden');
		echo 'Achtung! Your password is wrong!';
		page_footer();
		die();
	}
}

$pos = $login->GetPosition();
$admin = ($pos->GetID() == 3 || $pos->GetID() == 7);
if ($PHP_AUTH_USER != $pleb->GetID() && !$admin) {
	echo 'This is not the ship you are looking for. Move along.';
	page_footer();
	die();
}

echo '<H1>Auctioning ' . $sale->GetName() . ' owned by ' . $pleb->GetName() . '</H1><HR NOSHADE SIZE=2>';

if (!$auction) {
	echo "This $str_singular is not up for auction.";
}
elseif ($auction->GetEnd() >= time()) {
	echo 'This auction has not finished yet. Please try again after ' . date('G:i:s T \o\n L j F Y', $auction->GetEnd()) . '.';
}
elseif (empty($bid)) {
	if ($bids = $auction->GetBids()) {
		echo '<TABLE CELLSPACING=1 CELLPADDING=2><TR><TH>Person</TH><TH>Time</TH><TH>Bid</TH><TH>&nbsp;</TH></TR>';
		foreach ($bids as $bid) {
			$bidder = $bid->GetPerson();
			echo '<TR><TD>' . $bidder->GetName() . '</TD><TD>' . date('j F Y \a\t G:i:s T', $bid->GetTime()) . '</TD><TD>' . number_format($bid->GetBid()) . ' ICs</TD><TD>';
			if ($bid->IsValid()) {
				echo "<A HREF=\"$PHP_SELF?id=$_REQUEST['id']&amp;bid=" . $bid->GetID() . '">Accept This Bid</A>';
			}
			else {
				echo 'This bid cannot be accepted, as the bidder either does not have sufficient funds, or is prohibited from buying this type of ship.';
			}
			echo '</TD></TR>';
		}
		echo '</TABLE>';
	}
	else {
		echo 'No bids have been made.';
	}
	echo "<HR NOSHADE SIZE=2><A HREF=\"auction-withdraw.php?id=".$_REQUEST['id']."\">Withdraw this $str_singular from auction</A>";
}
else {
	$bid = new Bid($bid);
	if ($bid->AcceptBid()) {
		$bidder = $bid->GetPerson();
		echo "The $str_singular has been sold to " . $bidder->GetName() . ' for '. number_format($bid->GetBid()) . ' ICs.';
	}
	else {
		echo "Error selling $str_singular: the buyer either has insufficient funds, or is prohibited from buying this type of ship.";
	}
}

reg_footer();
?>

<?php
include('header.php');

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

page_header();

$auction = new Auction($id);
$sale = $auction->GetSale();
$pleb = $roster->GetPerson($PHP_AUTH_USER);

echo '<H1>Bidding for ' . $sale->GetName() . '</H1><HR NOSHADE SIZE=2>';

if ($auction->GetEnd() < time()) {
	echo 'This auction is now closed.';
}
elseif (empty($bid)) {
	echo "<FORM NAME=\"bid\" METHOD=\"post\" ACTION=\"$PHP_SELF\"><INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"$id\">";
	echo 'Amount to bid: <INPUT TYPE="name" NAME="bid" VALUE="' . $auction->GetMinimum() . '"><BR><BR>';
	echo '<INPUT TYPE="submit" VALUE="Make Bid"> <INPUT TYPE="reset">';
	echo '</FORM>';
}
else {
	if ($bid < $auction->GetMinimum() && $auction->GetEnforce()) {
		echo 'Your bid is below the minimum bid for this ship, and the owner has elected to enforce the minimum limit. Please go back and change your bid.';
	}
	else {
		if ($auction->MakeBid($pleb, $bid)) {
			echo 'Your bid has been made.';
		}
		else {
			echo 'Error making bid.';
		}
	}
}

page_footer();
?>
<?php
include('header.php');
page_header();

$sale = new Sale($id);
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
else {
	$auction->Withdraw();
	echo "This $str_singular has been withdrawn from auction.";
}

reg_footer();
?>
<?php
include('header.php');
page_header();
echo "<B>$str_name Registries - Refund " . ucwords($str_plural) . '</B><HR NOSHADE SIZE=2>';

$store = new Store();
$sale = $store->GetSale($_REQUEST['id']);
$owner = $sale->GetOwner();

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
	$pos = $login->GetPosition();
	if (!($login->IsValid() && $pos->GetID() == 3 || $pos->GetID() == 7 || $login->GetID() == 666 || $login->GetID() == $owner->GetID())) {
		header("WWW-Authenticate: Basic realm=\"$str_abbrev Purchasing\"");
		header('HTTP/1.0 401 Forbidden');
		page_header();
		echo 'Achtung! Your password is wrong or you are not permitted to access this page!';
		page_footer();
		die();
	}
}

if ($submit) {
	$sale->Refund();
	echo ucwords($sale->GetQuantity() > 1 ? $str_plural : $str_singular) . ' returned.';
}
else {
	echo '<FORM NAME="transfer" METHOD="POST" ACTION="' . $PHP_SELF . '">';
	echo '<INPUT TYPE="hidden" NAME="id" VALUE="' . $id . '">';
	echo 'Are you sure that you want to return ' . ($sale->GetQuantity() > 1 ? 'these ' . $str_plural : 'this ' . $str_singular) . '?<P>';
	echo '<INPUT TYPE="submit" NAME="submit" VALUE="Yes">';
	echo '</FORM>';
}
?>

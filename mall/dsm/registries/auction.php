<?php
include('header.php');
page_header();

$sale = new Sale($id);
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

if ($sale->IsForSale()) {
	echo "This $str_singular is already for sale.";
}
else {
	if (empty($end)) {
		echo "<FORM NAME=\"auction\" METHOD=\"post\" ACTION=\"$PHP_SELF\"><INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"$id\">";

		echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
		echo '<TR><TD>Minimum Bid:</TD><TD><INPUT TYPE="text" NAME="minimum" VALUE="0" SIZE=8> ICs</TD></TR>';
		echo '<TR><TD>Enforce Minimum Bid:</TD><TD><INPUT TYPE="checkbox" NAME="enforce" VALUE="true"></TD></TR>';
		echo '<TR VALIGN="top"><TD>Description:</TD><TD><TEXTAREA ROWS=5 COLS=60 NAME="description"></TEXTAREA></TD></TR>';
		echo '<TR><TD>Duration:</TD><TD><SELECT NAME="end" SIZE=1>';
		$durations = array(1=>'1 hour', 12=>'12 hours', 24=>'24 hours', 48=>'2 days', 96=>'4 days', 168=>'7 days', 336=>'2 weeks');
		foreach ($durations as $hours=>$label) {
			echo '<OPTION VALUE="' . (time() + ($hours * 3600)) . '">' . $label . '</OPTION>';
		}
		echo '</SELECT></TD></TR>';
		echo '</TABLE>';

		echo '<INPUT TYPE="submit" VALUE="Auction Ship"> <INPUT TYPE="reset">';
		echo '</FORM><HR NOSHADE SIZE=2>';
	}
	else {
		if ($sale->StartAuction($minimum, $enforce == 'true', $description, $end)) {
			echo 'Auction started successfully.';
		}
		else {
			echo 'Error starting auction.';
		}
	}
}

reg_footer();
?>

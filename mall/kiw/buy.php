<?php
include('header.php');

$roster = new Roster('roster-69god');

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

echo "<H1>Buying $str_singular...</H1><HR NOSHADE SIZE=2>";

$item = new Item($id);
$pleb = $roster->GetPerson($PHP_AUTH_USER);

if (!$item->CheckPerson($pleb)) echo "You are not authorised to buy this $str_singular.";
elseif ($item->GetLimit() > 0 && $item->GetLimit() <= $item->GetTotalSales()) echo "Too many $str_plural of this type have been sold.";
else {
	if ($item->GetLimit() > 0) {
		if ($item->Sell($pleb, 1)) echo 'Congratulations, you are now the proud owner of one ' . $item->GetName() . '.';
		else echo "Error while adding this $str_singular to your inventory. Do you already own one?";
	}
	elseif (isset($qty) && $qty > 0) {
		if ($item->Sell($pleb, $qty)) echo "Congratulations, you are now the proud owner of $qty " . $item->GetName() . ($qty != 1 ? 's' : '') . '.';
		else echo "Error while adding $str_singular to your inventory.";
	}
	else {
		
		echo "<FORM NAME=\"buy\" METHOD=\"POST\" ACTION=\"$PHP_SELF\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=$id>";
		echo 'Number of ' . $item->GetName() . '\'s to buy: <INPUT TYPE="text" NAME="qty" SIZE=4><P>';
		echo '<INPUT TYPE="submit" VALUE="Buy!"> <INPUT TYPE="reset">';
		echo '</FORM>';
	}
}

page_footer();
?>

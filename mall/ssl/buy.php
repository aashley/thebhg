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

$item = new Item($id);
$pleb = $roster->GetPerson($PHP_AUTH_USER);

if (!$item->CheckPerson($pleb))	echo "You are not authorised to buy this $str_singular";
elseif ($item->GetShipOnly()) echo "This item can only be sold as a complete $str_singular.";
elseif ($item->GetLimit() > 0 && $item->GetLimit() <= $item->GetTotalSales()) echo "Too many $str_plural of this type have been sold.";
else {
	if (isset($name)) {
		if ($sale = $item->Sell($pleb, $name)) {
			echo "Congratulations, you are now the proud owner of a " . $item->GetName() . ' called "' . $name . '".';
		}
		else {
			echo "Error while adding $str_singular to your inventory.";
		}
	}
	else {
		
		echo "<FORM NAME=\"buy\" METHOD=\"POST\" ACTION=\"$PHP_SELF\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=$id>";
		echo 'Name: <INPUT TYPE="text" NAME="name" SIZE=20><BR><BR>';
		echo '<INPUT TYPE="submit" VALUE="Buy!"> <INPUT TYPE="reset">';
		echo '</FORM>';
	}
}

page_footer();
?>

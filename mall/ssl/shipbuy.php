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

$ship_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."ships WHERE id=$id", $db);
$item = new Item(mysql_result($ship_result, 0, 'hull'));
$pleb = $roster->GetPerson($PHP_AUTH_USER);

if (!$item->CheckPerson($pleb))	echo "You are not authorised to buy this $str_singular";
elseif ($item->GetLimit() > 0 && $item->GetLimit() <= $item->GetTotalSales()) echo "Too many $str_plural of this type have been sold.";
elseif ($pleb->GetAccountBalance() < mysql_result($ship_result, 0, 'price')) echo "You don't have enough credits to buy this $str_singular.";
else {
	if (isset($name)) {
		if ($sale = $item->Sell($pleb, $name, 1, true)) {
			$part_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix."shipparts WHERE ship=$id", $db);
			if ($part_result && mysql_num_rows($part_result)) {
				while ($part_row = mysql_fetch_array($part_result)) {
					$part = new Part($part_row['part']);
					$sale->AddPart($part, $part_row['hullbay'], 1);
				}
			}
			$pleb->MakePurchase(mysql_result($ship_result, 0, 'price'), $str_name, $name);
			echo "Congratulations, you are now the proud owner of a " . stripslashes(mysql_result($ship_result, 0, 'name')) . ' called "' . $name . '".';
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

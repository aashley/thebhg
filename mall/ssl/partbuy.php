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

$store = new Store();
$item = new Part($id);
$pleb = $roster->GetPerson($PHP_AUTH_USER);

if (!$item->CheckPerson($pleb)) echo "You are not authorised to buy this $mod_singular.";
elseif ($item->GetLimit() > 0 && $item->GetLimit() <= $item->GetTotalSales()) echo "Too many $mod_plural of this type have been sold.";
else {
	if (isset($bay)) {
		$foo = explode(',', $bay);
		$ship = new Sale($foo[0]);
		$hb = new Hullbay($foo[1]);
		switch ($ship->AddPart($item, $hb)) {
			case 1:
				echo "The $mod_singular has been added to your $str_singular.";
				break;
			case 0:
				echo "Error adding $mod_singular: internal error.";
				break;
			case -1:
				echo "Error adding $mod_singular: you have insufficient credits for this transaction.";
				break;
			case -2:
				echo "Error adding $mod_singular: the $bay_singular is unsuitable for this part.";
				break;
			case -3:
				echo "Error adding $mod_singular: there is insufficient space in the $bay_singular for this part.";
				break;
			case -4:
				echo "Error adding $mod_singular: there are no $mod_plural of this type remaining.";
				break;
			case -5:
				echo "Error adding $mod_singular: you are not authorised to purchase this $mod_singular.";
				break;
			case -6:
				echo "Error adding $mod_singular: database error.";
				break;
			case -7:
				echo "Error adding $mod_singular: you cannot add or remove parts from a $str_singular when it is up for auction.";
				break;
		}
	}
	else {
		echo "<FORM NAME=\"buy\" METHOD=\"POST\" ACTION=\"$PHP_SELF\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=$id>";
		echo ucwords($str_singular) . ' and ' . ucwords($bay_singular) . ': <SELECT NAME="bay">';
		$ships = $store->GetSales($pleb);
		if ($ships) {
			foreach ($ships as $ship) {
				$hull = $ship->GetItem();
				$bays = $hull->GetBays();
				if ($bays) {
					foreach ($bays as $hullbay) {
						$bay = $hullbay->GetBay();
						if ($item->GetExternal() && !$bay->GetExternal()) continue;
						if ($item->GetSize() > $ship->GetFreeSpace($hullbay)) continue;
						echo '<OPTION VALUE="' . $ship->GetID() . ',' . $hullbay->GetID() . '">' . $ship->GetName() . ': ' . $bay->GetName() . '</OPTION>';
					}
				}
			}
		}
		echo '</SELECT><P>';
		echo '<INPUT TYPE="submit" VALUE="Buy!"> <INPUT TYPE="reset">';
		echo '</FORM>';
	}
}

page_footer();
?>

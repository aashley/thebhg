<?php
include('header.php');
page_header();

$sale = new Sale($_REQUEST['id']);
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
$admin = ($pos->GetID() == 3 || $pos->GetID() == 7 || $login->GetID() == 666);
if ($PHP_AUTH_USER != $pleb->GetID() && !$admin) {
	echo 'This is not the ship you are looking for. Move along.';
	page_footer();
	die();
}

echo '<H1>Editing ' . $sale->GetName() . '</H1><HR NOSHADE SIZE=2>';
if (isset($delete_ship)) {
	echo 'About to delete ship ' . $sale->GetID() . '.<br>';
	if ($delete_ship != 0) {
		$sale->Refund();
		echo 'Ship deleted, refund given.';
	}
	else {
		$sale->Delete();
		echo 'Ship deleted, no refund given.';
	}
}
elseif (isset($name)) {
	if ($name != $sale->GetName()) if (!$sale->SetName($name)) echo 'Error saving name.<BR>';
	if ($description != $sale->GetDescription()) if (!$sale->SetDescription($description)) echo 'Error saving description.<BR>';
	$curr_owner = $sale->GetOwner();
	if ($curr_owner->GetID() != $owner && $owner != $PHP_AUTH_USER) {
		if ($sale->SetOwner($owner)) {
			$new_owner = $roster->GetPerson($owner);
			echo ucwords($str_singular) . ' transferred to ' . $new_owner->GetName() . '.<BR>';
		}
		else {
			echo 'Error transferring ' . $str_singular . ': you cannot transfer a ' . $str_singular . ' that is up for sale.';
		}
	}
	echo 'Save complete.';
}
elseif (isset($delete)) {
	$result = mysql_db_query($db_name, "SELECT * FROM {$prefix}partsales WHERE id=$delete", $db);
	if ($result && mysql_num_rows($result)) {
		$part = new Part($part);
		$pleb->MakeSale($part->GetPrice());
		if ($sale->DeletePart($delete)) {
			echo ucwords($mod_singular) . ' deleted.';
		}
		else {
			echo 'Error deleting ' . $mod_singular . ': you cannot remove a ' . $mod_singular . ' from a ' . $str_singular . ' that is up for sale.';
		}
	}
	else {
		echo 'Error deleting ' . $mod_singular . ': you cannot delete a non-existant ' . $mod_singular . '.';
	}
}
else {
	if ($admin) {
		echo '<A HREF="' . $_SERVER['PHP_SELF'] . '?delete_ship=0&amp;id='.$_REQUEST['id'].'">Delete Ship</A> | <A HREF="' . $_SERVER['PHP_SELF'] . '?delete_ship=1&amp;id='.$_REQUEST['id'].'">Delete Ship With Refund</A><BR><BR>';
	}
	echo "<FORM NAME=\"edit\" METHOD=\"post\" ACTION=\"".$_SERVER['PHP_SELF']."\"><INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"".$_REQUEST['id']."\">";

	echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
	echo '<TR><TH CLASS="RIGHT">Name:</TH><TD><INPUT TYPE="text" NAME="name" VALUE="' . $sale->GetName() . '" SIZE=20></TD></TR>';
	echo '<TR><TH CLASS="RIGHT">Owner:</TH><TD><SELECT NAME="owner">';
	person_list($pleb->GetID());
	echo '</SELECT></TD></TR>';
	echo '<TR VALIGN="top"><TH CLASS="RIGHT">Description:</TH><TD><TEXTAREA COLS=60 ROWS=10 NAME="description">' . $sale->GetDescription() . '</TEXTAREA></TD></TR>';
	echo '</TABLE>';

	echo '<INPUT TYPE="submit" VALUE="Save ' . ucwords($str_singular) . '"> <INPUT TYPE="reset">';
	echo '</FORM><HR NOSHADE SIZE=2>';

	echo '<TABLE CELLSPACING=1 CELLPADDING=2>';
	echo '<TR><TH COLSPAN=4>' . ucwords($bay_plural) . ' and ' . ucwords($mod_plural) . '</TH></TR>';

	$bays = $item->GetBays();
	foreach ($bays as $hullbay) {
		$bay = $hullbay->GetBay();
		$parts = $sale->GetPartsInBay($hullbay);
		$first = true;
		$size = $hullbay->GetSize();
		echo '<TR VALIGN="top"><TD ROWSPAN="' . ($parts ? count($parts) : 1) . '">' . $bay->GetName() . '<BR><SMALL>Total Size: ' . number_format($hullbay->GetSize()) . " $vol_plural<BR>Free Space: " . number_format($size) . " $vol_plural" . ($bay->GetExternal() ? '<BR>External access' : '') . '</SMALL></TD>';
		if ($parts) {
			foreach ($parts as $psid=>$part) {
				if ($first) {
					$first = false;
				}
				else {
					echo '<TR VALIGN="top">';
				}
				echo '<TD><SMALL>' . $part->GetName() . '</SMALL></TD><TD><SMALL>' . number_format($part->GetSize()) . ' ' . ($part->GetSize() == 1 ? $vol_singular : $vol_plural) . '</SMALL></TD><TD><SMALL>' . number_format($part->GetPrice()) . ' ICs</SMALL></TD><TD><SMALL><A HREF="' . $_SERVER['PHP_SELF'] . '?delete=' . $psid . '&amp;id=' . $_REQUEST['id'] . '&amp;part=' . $part->GetID() . '">Delete</A></SMALL></TD></TR>';
			}
		}
		else {
			echo '<TD COLSPAN=4><SMALL>No ' . $mod_plural . ' have been placed in this ' . $bay_singular . '.</SMALL></TD></TR>';
		}
	}
	echo '</TABLE><HR NOSHADE SIZE=2>';
}

page_footer();
?>

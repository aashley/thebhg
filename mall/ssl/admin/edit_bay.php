<?php
include('header.php');
page_header();

$store = new Store();

if (empty($id)) {
	echo "<FORM NAME=\"edit_bay\" METHOD=\"post\" ACTION=\"$PHP_SELF\">";
	echo 'Hull: <SELECT NAME="id">';
	$items = $store->GetItems();
	if ($items) {
		foreach ($items as $item) {
			echo '<OPTION VALUE="' . $item->GetID() . '">' . $item->GetName() . '</OPTION>';
		}
	}
	echo '</SELECT><BR><BR>';
	echo '<INPUT TYPE="submit" VALUE="Edit Bays"> <INPUT TYPE="reset">';
	echo '</FORM>';
}
elseif (empty($hullbay)) {
	$item = new Item($id);
	$hullbays = $item->GetBays();
	if (count($hullbays)) {
		echo "<FORM NAME=\"edit_bay\" METHOD=\"post\" ACTION=\"$PHP_SELF\"><INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"$id\"><TABLE BORDER=\"0\">";
		foreach ($hullbays as $hullbay) {
			echo '<TR><TD>Bay ' . $hullbay->GetID() . '</TD><TD><SELECT NAME="hullbay[' . $hullbay->GetID() . ']"><OPTION VALUE="-1">No bay</OPTION>';
			$hb_bay = $hullbay->GetBay();
			$bays = $store->GetBays();
			if ($bays) {
				foreach ($bays as $bay) {
					echo '<OPTION VALUE="' . $bay->GetID() . '"' . ($hb_bay->GetID() == $bay->GetID() ? ' SELECTED' : '') . '>' . $bay->GetName() . '</OPTION>';
				}
			}
			echo '</SELECT></TD>';
                        echo '<TD>Size:</TD><TD><INPUT TYPE="text" NAME="size[' . $hullbay->GetID() . ']" VALUE="' . $hullbay->GetSize() . '" SIZE="5"> ' . $vol_plural . '</TD></TR>';
		}
		echo '</TABLE><INPUT TYPE="submit" VALUE="Save Bays"> <INPUT TYPE="reset">';
	}
}
else {
	foreach ($hullbay as $hb_id=>$hb_bay) {
		$hb = new HullBay($hb_id);
		if ($hb_bay == -1) $hb->Delete();
		else {
                        $hb->SetBay($hb_bay);
                        $hb->SetSize($size[$hb_id]);
                }
	}
	echo 'Done.';
}

page_footer();
?>

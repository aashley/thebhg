<?php
include('header.php');
page_header();

$store = new Store();

function do_form() {
	global $store;
	
	echo "<FORM NAME=\"add_bay\" METHOD=\"post\" ACTION=\"$PHP_SELF\"><TABLE BORDER=\"0\">";
	echo '<TR><TD>Hull:</TD><TD><SELECT NAME="item">';
	$items = $store->GetItems();
	if ($items) {
		foreach ($items as $item) {
			echo '<OPTION VALUE="' . $item->GetID() . '">' . $item->GetName() . '</OPTION>';
		}
	}
	echo '</SELECT></TD></TR>';
	for ($i = 0; $i < 10; $i++) {
		echo '<TR><TD>Bay ' . ($i + 1) . "</TD><TD><SELECT NAME=\"bay[$i]\"><OPTION VALUE=\"-1\">No bay</OPTION>";
		$bays = $store->GetBays();
		if ($bays) {
			foreach ($bays as $bay) {
				echo '<OPTION VALUE="' . $bay->GetID() . '">' . $bay->GetName() . '</OPTION>';
			}
		}
		echo '</SELECT></TD>';
                echo '<TD>Size:</TD><TD><INPUT TYPE="text" NAME="size[' . $i . ']" SIZE="5"> ' . $vol_plural . '</TD></TR>';
	}
	echo '</TABLE><INPUT TYPE="submit" VALUE="Add Bay"> <INPUT TYPE="reset">';
}

if (isset($item)) {
	$item = new Item($item);
	for ($i = 0; $i < 10; $i++) {
		if ($bay[$i] > 0) {
			if ($item->AddBay($bay[$i], $size[$i])) {
				echo "Bay $i added.<BR>";
			}
			else {
				echo "Error adding bay $i.<BR>";
			}
		}
	}
	echo '<a href="index.php">Click here to return to the main menu.</a><hr>';
}

do_form();

page_footer();
?>

<?php
include('header.php');

page_header();

if (empty($id)) {
	$store = new Store();
	$items = $store->GetItems();
	echo "<FORM NAME=\"delete_item\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n";
	echo 'Item: <SELECT NAME="id" SIZE=1>';
	if ($items) {
		for ($i = 0; $i < count($items); $i++) echo '<OPTION VALUE=' . $items[$i]->GetID() . ' NAME="' . $items[$i]->GetName() . '">' . $items[$i]->GetName() . '</OPTION>';
	}
	echo '</SELECT><BR><BR>';
	echo '<INPUT TYPE="submit" VALUE="Delete">';
	echo '</FORM>';
}
else {
	$item = new Item($id);
	$item->Delete();
	echo 'Item deleted.';
}

page_footer();

?>

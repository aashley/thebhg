<?php
include('header.php');

page_header();

function do_form() {
	global $db, $db_name, $prefix, $roster;

	echo <<<EOF1
<FORM NAME="add_ship" METHOD="post" ACTION="$PHP_SELF">
<TABLE BORDER=0>
<TR><TD>Name:</TD><TD><INPUT TYPE="text" NAME="name" SIZE=20></TD></TR>
<TR><TD>Type:</TD><TD><SELECT NAME="type">
EOF1;
	$st_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'shiptypes ORDER BY name ASC', $db);
	if ($st_result && mysql_num_rows($st_result)) {
		while ($type = mysql_fetch_array($st_result)) {
			echo '<OPTION VALUE="' . $type['id'] . '">' . stripslashes($type['name']) . '</OPTION>';
		}
	}
	echo <<<EOF2
</SELECT></TD></TR>
<TR><TD>Price:</TD><TD><INPUT TYPE="text" NAME="price" SIZE=10> ICs</TD></TR>
<TR VALIGN="top"><TD>Description:</TD><TD><TEXTAREA NAME="description" ROWS=10 COLS=60></TEXTAREA></TD></TR>
<TR><TD>Copy From Ship:</TD><TD><SELECT NAME="ship">
EOF2;
	$store = new Store();
	if (isset($_REQUEST['show_all'])) {
		$sales_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'sales ORDER BY name ASC', $db);
	}
	else {
		$owners = array(1293);
		$tact = $roster->SearchPosition(3);
		if ($tact) $owners[] = $tact[0]->GetID();
		$marl = $roster->SearchPosition(7);
		if ($marl) $owners[] = $marl[0]->GetID();
		$sales_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'sales WHERE owner IN (' . implode(',', $owners) . ') ORDER BY name ASC', $db);
	}
	if ($sales_result && mysql_num_rows($sales_result)) {
		while ($srow = mysql_fetch_array($sales_result)) {
			$sale = new Sale($srow['id']);
			$owner = $sale->GetOwner();
			$div = $owner->GetDivision();
			$key = $div->GetName() . ' - ' . $owner->GetName() . ': ' . $sale->GetName();
			$options[$key] = '<OPTION VALUE="' . $sale->GetID() . '">' . htmlspecialchars($key) . '</OPTION>';
		}
	}
	ksort($options);
	echo implode('', $options);
	echo '</SELECT><BR>';
	if (isset($_REQUEST['show_all'])) echo '<A HREF="' . $_SERVER['PHP_SELF'] . '">Show only TACT, MARL, and SSL Wreckers ships</A>';
	else echo '<A HREF="' . $_SERVER['PHP_SELF'] . '?show_all">Show ships owned by all hunters</A>';
	echo <<<EOF3
</TD></TR>
</TABLE>
<INPUT TYPE="submit" VALUE="Add Ship"> <INPUT TYPE="reset">
</FORM>
EOF3;
}

if (isset($name)) {
	$sale = new Sale($ship);
	$item = $sale->GetItem();
	$name = addslashes($name);
	$desc = addslashes($description);
	if (mysql_db_query($db_name, "INSERT INTO {$prefix}ships (type, name, description, price, hull) VALUES ($type, '$name', '$desc', $price, " . $item->GetID() . ')', $db)) {
		$sid = mysql_insert_id($db);
		$bays = $item->GetBays();
		foreach ($bays as $hullbay) {
			$parts = $sale->GetPartsInBay($hullbay);
			if ($parts) {
				foreach ($parts as $part) {
					mysql_db_query($db_name, "INSERT INTO {$prefix}shipparts (ship, part, hullbay) VALUES ($sid, " . $part->GetID() . ', ' . $hullbay->GetID() . ')', $db) or printf("%s\n", mysql_error($db));
				}
			}
		}
		echo 'Ship added successfully.<HR>';
		do_form();
	}
	else {
		echo mysql_error($db);
	}
}
else {
	do_form();
}

page_footer();
?>

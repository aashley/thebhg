<?php
include('header.php');

page_header();

if (isset($_REQUEST['id'])) {
	$part = new Part($_REQUEST['id']);
	$part->Delete();
	echo ucwords($mod_singular) . ' deleted.';
}
else {
	echo "<FORM NAME=\"delete_part\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n";
	echo ucwords($mod_singular) . ': <SELECT NAME="id" SIZE=1>';
	$store = new Store();
	if ($parts = $store->GetParts()) {
		for ($i = 0; $i < count($parts); $i++) {
			$type = $parts[$i]->GetPartType();
			$part_list[$type->GetName()][$parts[$i]->GetName()] = '<OPTION VALUE=' . $parts[$i]->GetID() . ' NAME="' . $parts[$i]->GetName() . '">' . $type->GetName() . ': ' . $parts[$i]->GetName() . '</OPTION>';
		}
		ksort($part_list);
		foreach ($part_list as $plist) {
			ksort($plist);
			foreach ($plist as $part) {
				echo $part;
			}
		}
	}
	echo '</SELECT><BR><BR>';
	echo '<INPUT TYPE="submit" VALUE="Delete Part">';
	echo '</FORM>';
}

page_footer();
?>

<?php
include('header.php');
page_header();

$store = new Store();

if (empty($id)) {
	echo "<FORM NAME=\"edit_bay\" METHOD=\"get\" ACTION=\"$PHP_SELF\">";
	echo 'Bay Type: <SELECT NAME="id">';
	$bays = $store->GetBays();
	if ($bays) {
		foreach ($bays as $bay) {
			echo '<OPTION VALUE="' . $bay->GetID() . '">' . $bay->GetName() . '</OPTION>';
		}
	}
	echo '</SELECT><BR><BR><INPUT TYPE="submit" VALUE="Edit Bay"> <INPUT TYPE="reset"></FORM>';
}
elseif (empty($name)) {
	$bay = new Bay($id);
	echo "<FORM NAME=\"edit_bay\" METHOD=\"post\" ACTION=\"$PHP_SELF\">";
	echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"$id\">";
	echo '<TABLE BORDER=\"0\">';
	echo '<TR><TD>Name:</TD><TD><INPUT TYPE="text" NAME="name" SIZE=16 VALUE="' . $bay->GetName() . '"></TD></TR>';
	echo '<TR VALIGN="top"><TD>Description:</TD><TD><TEXTAREA NAME="description" ROWS=5 COLS=60>' . $bay->GetDescription() . '</TEXTAREA></TD></TR>';
	echo '<TR><TD>External Access:</TD><TD><INPUT TYPE="checkbox" NAME="external" VALUE="on"' . ($bay->GetExternal() ? ' CHECKED' : '') . '></TD></TR>';
	echo '</TABLE>';
	echo '<INPUT TYPE="submit" VALUE="Save Bay"> <INPUT TYPE="reset">';
	echo '</FORM>';
}
else {
	$bay = new Bay($id);
	if ($bay->SetName($name) && $bay->SetDescription($description) && $bay->SetExternal($external == 'on')) {
		echo 'Bay type saved.';
	}
	else {
		echo 'Error saving bay type.';
	}
}

page_footer();
?>

<?php
include('header.php');

page_header();

if (isset($name)) {
	$type = new PartType($id);
	if ($type->SetName($name) && $type->SetDescription($description)) echo 'Changes saved. Click <A HREF="index.php">here</A> to return to the main menu.';
	else echo 'Error saving changes.';
}
elseif (isset($id)) {
	$type = new PartType($id);
	$name = $type->GetName();
	$description = $type->GetDescription();
	echo <<<EOF
<FORM NAME="edit_type" METHOD="post" ACTION="$PHP_SELF">
<INPUT TYPE="hidden" NAME="id" VALUE=$id>
<TABLE BORDER=0>
<TR><TD>Name:</TD><TD><INPUT TYPE="text" NAME="name" VALUE="$name" SIZE=20></TD></TR>
<TR VALIGN="top"><TD>Description:</TD><TD><TEXTAREA NAME="description" ROWS=10 COLS=60>$description</TEXTAREA></TD></TR>
</TABLE>
<INPUT TYPE="submit" VALUE="Save"> <INPUT TYPE="reset">
</FORM>
EOF;
}
else {
	$store = new Store();
	$types = $store->GetPartTypes();
	echo "<FORM NAME=\"edit_type\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n";
	echo 'Type: <SELECT NAME="id" SIZE=1>';
	if ($types) {
		for ($i = 0; $i < count($types); $i++) echo '<OPTION VALUE=' . $types[$i]->GetID() . ' NAME="' . $types[$i]->GetName() . '">' . $types[$i]->GetName() . '</OPTION>';
	}
	echo '</SELECT><BR><BR>';
	echo '<INPUT TYPE="submit" VALUE="Edit">';
	echo '</FORM>';
}

page_footer();

?>

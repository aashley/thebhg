<?php
include('header.php');

page_header();

function do_form() {
	echo <<<EOF
<FORM NAME="add_type" METHOD="post" ACTION="$PHP_SELF">
<TABLE BORDER=0>
<TR><TD>Name:</TD><TD><INPUT TYPE="text" NAME="name" SIZE=20></TD></TR>
<TR VALIGN="top"><TD>Description:</TD><TD><TEXTAREA NAME="description" ROWS=10 COLS=60></TEXTAREA></TD></TR>
</TABLE>
<INPUT TYPE="submit" VALUE="Add Type"> <INPUT TYPE="reset">
</FORM>
EOF;
}

if (isset($name)) {
	$store = new Store();
	if ($store->AddType($name, $description)) {
		echo 'Type added successfully. You may <A HREF="index.php">return to the main menu</A>, or add another type using the form below.<HR>';
		do_form();
	}
	else echo 'Error adding type.';
}
else do_form();

page_footer();

?>

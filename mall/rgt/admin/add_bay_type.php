<?php
include('header.php');
page_header();

$store = new Store();

function do_form() {
?>
<FORM NAME="add_bay" METHOD="post" ACTION="<?php echo $PHP_SELF; ?>">
<TABLE BORDER="0">
<TR><TD>Name:</TD><TD><INPUT TYPE="text" NAME="name" SIZE=16></TD></TR>
<TR VALIGN="top"><TD>Description:</TD><TD><TEXTAREA NAME="description" ROWS=5 COLS=60></TEXTAREA></TD></TR>
<TR><TD>External Access:</TD><TD><INPUT TYPE="checkbox" NAME="external" VALUE="on"></TD></TR>
</TABLE>
<INPUT TYPE="submit" VALUE="Add Bay Type"> <INPUT TYPE="reset">
</FORM>
<?php
}
if (isset($name)) {
	$external = ($external == 'on');
	if ($store->AddBay($name, $description, $external)) {
		echo 'Bay type added.';
	}
	else {
		echo 'Error adding bay type.';
	}
        echo '<hr>';
}
do_form();

page_footer();
?>

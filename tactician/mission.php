<?php
include('header.php');
if (isset($hidden)) {
	include('auth.php');
	$pos = $login->GetPosition();
	if ($login->GetID() != 666 && $pos->GetID() != 3) {
		page_header();
		echo 'You are not permitted to access this page.';
		page_footer();
	}
}

page_header();

$id = (int) $id;
$mission_result = mysql_query("SELECT * FROM missions WHERE id=$id" . (empty($hidden) ? ' AND hidden=0' : ''), $db);
if ($mission_result && mysql_num_rows($mission_result)) {
	$mission = mysql_fetch_array($mission_result);
	echo '<CENTER><H1>' . stripslashes($mission['title']) . "</H1>\n";
	$author = $roster->GetPerson($mission['author']);
	echo '<B>Written by ' . roster_link($author) . "</B></CENTER><BR><HR NOSHADE><BR>\n";
	echo stripslashes($mission['text']);
	echo "<BR><HR NOSHADE><BR>\n";
	if ($mission['complete'] == 0) {
		echo "<FORM NAME=\"mission\" METHOD=\"post\" ACTION=\"send.php\">\n";
		echo '<INPUT TYPE="hidden" NAME="id" VALUE="' . $mission['id'] . "\">\n";
		echo "<TABLE>\n";
		echo "<TR VALIGN=\"top\"><TD>Roster ID:</TD><TD><INPUT TYPE=\"text\" NAME=\"rosterid\" SIZE=\"5\"></TD></TR>\n";
		echo "<TR VALIGN=\"top\"><TD>Password:</TD><TD><INPUT TYPE=\"password\" NAME=\"password\" SIZE=\"16\"></TD></TR>\n";
		echo "<TR VALIGN=\"top\"><TD>Your Answer:</TD><TD><INPUT TYPE=\"text\" NAME=\"answer\" SIZE=\"20\"></TD></TR>\n";
		echo "<TR VALIGN=\"top\"><TD>Reasoning:</TD><TD><TEXTAREA NAME=\"reasoning\" COLS=\"60\" ROWS=\"10\"></TEXTAREA></TD></TR>\n";
		echo "</TABLE>\n";
		echo "<INPUT TYPE=\"submit\" VALUE=\"Send Answer\">&nbsp;<INPUT TYPE=\"reset\">\n";
		echo "</FORM>\n";
	}
	else {
		echo "<U>Answer</U><BR><BR>\n";
		echo stripslashes($mission['answer']);
		echo "<BR><HR NOSHADE><BR>\n";
		echo "<U>Results</U><BR><BR>\n";
		echo stripslashes(nl2br($mission['results']));
	}
}
else {
	echo "Unable to display mission ID $id.";
}

page_footer();
?>

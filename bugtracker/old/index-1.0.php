<?php
/* BHG bug tracker
 * Author: Jernai Teifsel <jernai@iinet.net.au>
 * 
 * This bug tracker is kind of a mini-Bugzilla, with little bits of the
 * Sourceforge bug tracker thrown in for good measure.
 *
 * Known bugs: None, but there almost certainly are some.
 */

require("config.php");

$id = -1;

// include("../main/opendb.php");
$db = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name);

function page_start($title, $auth = false) {
	global $name, $id, $user_db, $db, /*$db_main, $db_roster, */$PHP_AUTH_USER, $PHP_AUTH_PW/*, $main_site*/;

	$auth_fail = false;
	if ($auth) {
		if (!isset($PHP_AUTH_USER) || $PHP_AUTH_USER == "") {
			$auth_fail = true;
		}
		else {
			$logon_id = mysql_db_query($user_db, "SELECT * FROM roster WHERE id=$PHP_AUTH_USER AND passwd=PASSWORD('$PHP_AUTH_PW')", $db);
			if (!($logon_id && mysql_num_rows($logon_id))) {
				$auth_fail = true;
			}
			else {
				$id = mysql_result($logon_id, 0, "id");
			}
		}
	}
	if ($auth && $auth_fail) {
		header("WWW-Authenticate: Basic realm=\"Bug Tracker\"");
		header("HTTP/1.0 401 Unauthorized");
	}

	echo
"<HTML>
<HEAD>
<TITLE>$name - $title</TITLE>
<LINK REL=\"stylesheet\" TYPE=\"text/css\" HREF=\"bugs.css\">
</HEAD>
<BODY BGCOLOR=\"WHITE\" TEXT=\"BLACK\">
<P CLASS=\"HEADING\">$name: $title</P>
";

/*	$title = "$name - $title";
	include("../main/header.php");
	echo "<BR><BR><BR>\n";*/

	if ($auth && $auth_fail) {
		echo "<P>There was an error while authenticating against the roster. Check your username and password and try again.</P>";
		page_end();
		die("");
	}
}

function page_end($module = 1) {
	global $title, $main_site, $db/*, $db_main, $db_roster*/;

	echo
"<HR>
<P CLASS=\"MENU\">[ <A HREF=\"$PHP_SELF?page=reportbug\">Report New Bug</A> | <A HREF=\"$PHP_SELF?page=listbugs&module=$module\">List Bugs By Module</A> | <A HREF=\"$PHP_SELF?page=listnewbugs\">List New Bugs</A> | <A HREF=\"$PHP_SELF?page=admin/index\">Administration</A> ]</P>
</BODY>
</HTML>";
	// include("../main/footer.php");
}

function is_admin() {
	global $id, $admins;

	return in_array($id, $admins);
}

function is_manager($module) {
	global $id, $db_name;

	$module_result = mysql_query("SELECT * FROM $db_name.modules WHERE id=$module AND manager=$id");
	return ($module_result && mysql_num_rows($module_result));
}

function managed_modules() {
	global $id, $db_name;

	$list = false;

	if (is_admin()) {
		$modules = mysql_query("SELECT * FROM $db_name.modules ORDER BY id ASC");
	}
	else {
		$modules = mysql_query("SELECT * FROM $db_name.modules WHERE manager=$id ORDER BY id ASC");
	}

	while ($module = mysql_fetch_array($modules)) {
		$list[] = $module["id"];
	}
	
	return $list;
}

function dropdown_modules($name, $select = -1) {
	global $db_name;
	
	echo "<SELECT SIZE=1 NAME=\"$name\">\n";
	$modules = mysql_query("SELECT * FROM $db_name.modules ORDER BY name ASC");
	while ($module = mysql_fetch_array($modules)) {
		echo "<OPTION VALUE=\"" . $module["id"] . "\"" . (($module["id"] == $select) ? " SELECTED" : "") . ">" . stripslashes($module["name"]) . "</OPTION>\n";
	}
	echo "</SELECT>\n";
}

function dropdown_status($name, $select = -1) {
	global $db_name;
	
	echo "<SELECT SIZE=1 NAME=\"$name\">\n";
	$status = mysql_query("SELECT * FROM $db_name.status ORDER BY description ASC");
	while ($stat = mysql_fetch_array($status)) {
		echo "<OPTION VALUE=\"" . $stat["id"] . "\"" . (($stat["id"] == $select) ? " SELECTED" : "") . ">" . stripslashes($stat["description"]) . "</OPTION>\n";
	}
	echo "</SELECT>\n";
}

function dropdown_priority($name, $select = -1) {
	global $db_name;
	
	echo "<SELECT SIZE=1 NAME=\"$name\">\n";
	$priority = mysql_query("SELECT * FROM $db_name.priority ORDER BY level ASC");
	while ($stat = mysql_fetch_array($priority)) {
		echo "<OPTION VALUE=\"" . $stat["level"] . "\"" . (($stat["level"] == $select) ? " SELECTED" : "") . ">" . stripslashes($stat["description"]) . "</OPTION>\n";
	}
	echo "</SELECT>\n";
}

function bleach($str) {
	return addslashes(htmlspecialchars($str));
}

function email($module, $subject, $message) {
	global $name, $db_name, $user_db;

	$coders = mysql_query("SELECT $user_db.roster.name, $user_db.roster.email FROM $db_name.maintainers, $user_db.roster WHERE $user_db.roster.id=$db_name.maintainers.coder AND $db_name.maintainers.module=$module");
	if ($coders && mysql_num_rows($coders)) {
		while ($coder = mysql_fetch_array($coders)) {
			$to[] = stripslashes($coder["name"]) . " <" . stripslashes($coder["email"]) . ">";
		}
	}
	$recip = implode(", ", $to);

	$headers = "From: $name <bugtracker@thebhg.org>\n";
	$headers .= "X-Sender: <bugtracker@thebhg.org>\n";
	$headers .= "X-Mailer: PHP\n";
	$headers .= "Return-Path: <bugtracker@thebhg.org>\n";

	mail($recip, $subject, $message, $headers);
}

function index() {
	page_start("Index");

	echo "<P>Welcome to the BHG bug tracker. This allows hunters to report bugs found in BHG systems, and developers to keep easy track of those bugs. Additionally, wish lists of features can be kept in this system for tracking.</P>\n";
	echo "<P>Any problems with this bug tracker should be reported using the report bug link below. You can e-mail <A HREF=\"mailto:jernai@iinet.net.au\">Jernai Teifsel</A> if you have any problems that prevent you from reporting a bug in the usual way.</P>\n";
	
	page_end();
}

function reportbug() {
	global $PHP_SELF;
	
	page_start("Report New Bug", true);

	echo "<FORM NAME=\"reportbug\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"savebug\">\n";
	echo "<TABLE BORDER=0>\n";
	echo "<TR><TD>Module:</TD><TD>\n";
	dropdown_modules("module");
	echo "</TD></TR>\n";
	echo "<TR><TD>Subject:</TD><TD><INPUT TYPE=TEXT SIZE=40 NAME=\"subject\"></TD></TR>\n";
	echo "<TR><TD>Description:</TD><TD><TEXTAREA ROWS=6 COLS=60 NAME=\"description\"></TEXTAREA></TD></TR>\n";
	echo "</TABLE>\n";
	echo "<P><INPUT TYPE=CHECKBOX NAME=\"wishlist\" VALUE=\"on\"> This is a feature request or wish list, not a bug</P>\n";
	echo "<P>Please note: Bug descriptions are displayed within &lt;PRE&gt; tags, and as a result, don't wordwrap in most browsers. Please press enter at the end of each line unless you are pasting code.</P>\n";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Report Bug\">&nbsp;<INPUT TYPE=RESET>\n";
	echo "</FORM>\n";

	page_end();
}

function savebug() {
	global $id, $module, $subject, $description, $user_db, $db_name, $new_status, $new_priority, $PHP_SELF, $wishlist;

	$subj = bleach($subject);
	$desc = bleach($description);

	page_start("Save Bug Report", true);

	if (mysql_query("INSERT INTO $db_name.bugs (module, status, priority, reporter, subject, description, time) VALUES ($module, $new_status, " . ((isset($wishlist) && ($wishlist == "on")) ? "6" : "$new_priority") . ", $id, '$subj', '$desc', " . time() . ")")) {
		$module_info = mysql_query("SELECT * FROM $db_name.modules WHERE id=$module");
		$bugid = mysql_insert_id();
		email($module, "New bug report for module \"" . stripslashes(mysql_result($module_info, 0, "name")) . "\"", "A new bug has been reported. You can view the details of the bug at http://bugs.thebhg.org$PHP_SELF?page=viewbug&bugid=$bugid\n\nBHG Bug Tracker");
		echo "<P>Your bug has been added successfully. You can view the bug <A HREF=\"$PHP_SELF?page=viewbug&bugid=" . mysql_insert_id() . "\">here</A>.</P>\n";
	}
	else {
		echo mysql_error() . "<BR>\n";
		echo "<P>There was an error adding the bug. Please e-mail <A HREF=\"mailto:jernai@iinet.net.au\">Jernai Teifsel</A> with the details on what you were trying to add, and any error messages shown above.</P>\n";
	}

	page_end($module);
}

function viewbug() {
	global $bugid, $db_name, $user_db, $db, $PHP_SELF;

	page_start("View Bug");

	echo "<P><A HREF=\"$PHP_SELF?page=addnote&bugid=$bugid\">Add a note to this bug</A></P>\n";

	$bug_result = mysql_db_query($db_name, "SELECT bugs.id, bugs.module AS modnumber, modules.name AS module, status.description AS status, priority.description AS priority, bugs.reporter, bugs.coder, bugs.subject, bugs.description, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, status, priority WHERE bugs.module=modules.id AND bugs.status=status.id AND bugs.priority=priority.level AND bugs.id=$bugid", $db);
	if (!($bug_result && $bug = mysql_fetch_array($bug_result))) {
		echo mysql_error() . "<BR>\n";
		echo "<P>Error getting bug $bugid.</P>\n";
		page_end();
		return;
	}

	echo "<P><B>Basic Information</B></P>\n";
	echo "<TABLE BORDER=1>\n";
	echo "<TR><TD>Bug ID</TD><TD>" . $bug["id"] . "</TD></TR>\n";
	echo "<TR><TD>Module</TD><TD>" . stripslashes($bug["module"]) . "</TD></TR>\n";
	echo "<TR><TD>Status</TD><TD>" . stripslashes($bug["status"]) . "</TD></TR>\n";
	echo "<TR><TD>Priority</TD><TD>" . stripslashes($bug["priority"]) . "</TD></TR>\n";
	$reporter = mysql_query("SELECT * FROM $user_db.roster WHERE id=" . $bug["reporter"]);
	echo "<TR><TD>Reported by</TD><TD><A HREF=\"mailto:" . stripslashes(mysql_result($reporter, 0, "email")) . "\">" . stripslashes(mysql_result($reporter, 0, "name")) . "</A></TD></TR>\n";
	$coder = mysql_query("SELECT * FROM $user_db.roster WHERE id=" . $bug["coder"]);
	if (mysql_num_rows($coder)) {
		$code_monkey = "<A HREF=\"mailto:" . stripslashes(mysql_result($coder, 0, "email")) . "\">" . stripslashes(mysql_result($coder, 0, "name")) . "</A>";
	}
	else {
		$code_monkey = "No-one";
	}
	echo "<TR><TD>Assigned to</TD><TD>$code_monkey</TD></TR>\n";
	echo "<TR><TD>Reported at</TD><TD>" . date("l j/n/Y G:i:s", $bug["time"]) . "</TD></TR>\n";
	echo "<TR><TD>Last updated</TD><TD>" . date("l j/n/Y G:i:s", $bug["lastupdate"]) . "</TD></TR>\n";
	echo "<TR><TD>Subject</TD><TD>" . stripslashes($bug["subject"]) . "</TD></TR>\n";
	echo "<TR><TD>Description</TD><TD><PRE>" . stripslashes($bug["description"]) . "</PRE></TD></TR>\n";
	echo "</TABLE>\n";

	echo "<HR>\n";

	echo "<P><B>Notes</B></P>\n";
	$notes = mysql_query("SELECT * FROM notes WHERE bugid=$bugid ORDER BY time ASC");
	if (mysql_num_rows($notes)) {
		echo "<TABLE BORDER=1>\n";
		while ($note = mysql_fetch_array($notes)) {
			echo "<TR VALIGN=TOP>\n";
			$nper = mysql_query("SELECT * FROM $user_db.roster WHERE id=" . $note["writer"]);
			echo "<TD><P>By: " . stripslashes(mysql_result($nper, 0, "name")) . "<BR>At: " . date("j/n/Y G:i:s", $note["time"]) . "</P></TD>\n";
			echo "<TD><PRE>" . stripslashes($note["note"]) . "</PRE></TD>\n";
			echo "</TR>\n";
		}
		echo "</TABLE>\n";
	}
	else {
		echo "<P>No notes have been made yet.</P>\n";
	}

	page_end($bug["modnumber"]);
}

function listbugs() {
	global $module, $showall, $db, $db_name, $PHP_SELF, $user_db;

	page_start("Bug List");

	if (!isset($module)) {
		$module = 1;
	}

	echo "<FORM NAME=\"listbugs\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"listbugs\">\n";
	echo "<P>Show bugs from module: ";
	dropdown_modules("module", $module);
	echo "</P>\n";
	echo "<P><INPUT TYPE=SUBMIT VALUE=\"Change View\"></P>\n";
	echo "</FORM>\n";

	echo "<HR>\n";
	echo "<P><B>Module Information</B></P>\n";
	$module_info = mysql_query("SELECT $user_db.roster.name, $user_db.roster.email FROM $db_name.modules, $user_db.roster WHERE $db_name.modules.manager=$user_db.roster.id AND $db_name.modules.id=$module");
	echo "<P>Module Manager: <A HREF=\"mailto:" . stripslashes(mysql_result($module_info, 0, "email")) . "\">" . stripslashes(mysql_result($module_info, 0, "name")) . "</A><BR>\n";
	$coders = mysql_query("SELECT $user_db.roster.name, $user_db.roster.email FROM $db_name.maintainers, $user_db.roster WHERE $db_name.maintainers.coder=$user_db.roster.id AND $db_name.maintainers.module=$module ORDER BY name ASC");
	echo "Coder(s):";
	while ($coder = mysql_fetch_array($coders)) {
		$coder_list[] = " <A HREF=\"mailto:" . stripslashes($coder["email"]) . "\">" . stripslashes($coder["name"]) . "</A>";
	}
	echo implode(",", $coder_list);
	echo "</P>\n";

	echo "<TABLE BORDER=1>";
	echo "<TR><TD><B>Status</B></TD><TD><B>Priority</B></TD><TD><B>Subject</B></TD><TD><B>Date/Time</B></TD><TD><B>Last Update</B></TD></TR>\n";
	$bugs = mysql_db_query($db_name, "SELECT bugs.id, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.module=$module ORDER BY bugs.status ASC, bugs.priority ASC, lastupdate DESC, bugs.time DESC", $db);
	if (mysql_num_rows($bugs)) {
		while ($bug = mysql_fetch_array($bugs)) {
			echo "<TR><TD>" . stripslashes($bug["status"]) . "</TD><TD>" . stripslashes($bug["priority"]) . "</TD><TD><A HREF=\"$PHP_SELF?page=viewbug&bugid=" . $bug["id"] . "\">" . stripslashes($bug["subject"]) . "</A></TD><TD>" . date("j/n/Y G:i:s", $bug["time"]) . "</TD><TD>" . date("j/n/Y G:i:s", $bug["lastupdate"]) . "</TD></TR>\n";
		}
	}
	echo "</TABLE>\n";
	
	page_end($module);
}

function listnewbugs() {
	global $db, $db_name, $PHP_SELF, $user_db;

	page_start("New Bug List");

	echo "<TABLE BORDER=1>";
	echo "<TR><TD><B>Module</B></TD><TD><B>Status</B></TD><TD><B>Priority</B></TD><TD><B>Subject</B></TD><TD><B>Date/Time</B></TD><TD><B>Last Update</B></TD></TR>\n";
	$bugs = mysql_db_query($db_name, "SELECT bugs.id, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.status<4 AND (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(bugs.lastupdate))<(3600*24*7) ORDER BY UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.module ASC, bugs.status ASC, bugs.priority ASC, bugs.time DESC", $db);
	echo mysql_error();
	if (mysql_num_rows($bugs)) {
		while ($bug = mysql_fetch_array($bugs)) {
			echo "<TR><TD>" . stripslashes($bug["name"]) . "</TD><TD>" . stripslashes($bug["status"]) . "</TD><TD>" . stripslashes($bug["priority"]) . "</TD><TD><A HREF=\"$PHP_SELF?page=viewbug&bugid=" . $bug["id"] . "\">" . stripslashes($bug["subject"]) . "</A></TD><TD>" . date("j/n/Y G:i:s", $bug["time"]) . "</TD><TD>" . date("j/n/Y G:i:s", $bug["lastupdate"]) . "</TD></TR>\n";
		}
	}
	echo "</TABLE>\n";
	
	page_end();
}

function addnote() {
	global $db_name, $bugid, $db, $id, $PHP_SELF;

	page_start("Add Note", true);

	$bug_result = mysql_query("SELECT * FROM $db_name.bugs WHERE id=$bugid");
	echo mysql_error();
	$bug = mysql_fetch_array($bug_result);
	$coder_result = mysql_query("SELECT * FROM $db_name.maintainers WHERE coder=$id AND module=" . $bug["module"]);
	if (mysql_num_rows($coder_result)) {
		$coder = true;
	}
	else {
		$coder = false;
	}

	echo "<FORM NAME=\"addnote\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"savenote\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"bugid\" VALUE=$bugid>\n";
	if ($coder || is_admin() || is_manager($bug["module"])) {
		echo "<P>As a coder on this module, you have access to alter almost all the fields available on a bug.</P>\n";
		echo "<TABLE BORDER=0>\n";
		echo "<TR><TD>Change module to:</TD><TD>";
		dropdown_modules("module", $bug["module"]);
		echo "</TD></TR>\n";
		echo "<TR><TD>Status:</TD><TD>";
		dropdown_status("status", $bug["status"]);
		echo "</TD></TR>\n";
		echo "<TR><TD>Priority:</TD><TD>";
		dropdown_priority("priority", $bug["priority"]);
		echo "</TD></TR>\n";
		echo "</TABLE>\n";
		echo "<P><INPUT TYPE=CHECKBOX NAME=\"assign\" VALUE=\"on\"> Assign bug to me</P>\n";
	}
	echo "Note to add:<BR>\n";
	echo "<TEXTAREA COLS=60 ROWS=6 NAME=\"note\"></TEXTAREA>\n";
	echo "<P>Please note: Notes are displayed within &lt;PRE&gt; tags, and as a result, don't wordwrap in most browsers. Please press enter at the end of each line unless you are pasting code.</P>\n";
	echo "<P><INPUT TYPE=SUBMIT VALUE=\"Add Note\"> <INPUT TYPE=RESET></P>\n";
	echo "</FORM>\n";

	page_end($bug["module"]);
}

function savenote() {
	global $id, $bugid, $module, $status, $priority, $db, $db_name, $assign, $note, $PHP_SELF;

	page_start("Save Note", true);

	$note = bleach($note);

	if (mysql_query("INSERT INTO $db_name.notes (bugid, writer, time, note) VALUES ($bugid, $id, " . time() . ", '$note')") && mysql_query("UPDATE $db_name.bugs SET lastupdate=NULL WHERE id=$bugid")) {
		echo "<P>Your note has been added to the bug. You can go back to the bug by clicking <A HREF=\"$PHP_SELF?page=viewbug&bugid=$bugid\">here</A>.</P>\n";
	}
	else {
		echo mysql_error() . "<BR>\n";
		echo "<P>There was an error adding the note. Please e-mail <A HREF=\"mailto:jernai@iinet.net.au\">Jernai Teifsel</A> with the details on what you were trying to add, and any error messages shown above.</P>\n";
	}

	$bug_result = mysql_query("SELECT * FROM $db_name.bugs WHERE id=$bugid");
	echo mysql_error();
	$bug = mysql_fetch_array($bug_result);
	$coder_result = mysql_query("SELECT * FROM $db_name.maintainers WHERE coder=$id AND module=" . $bug["module"]);
	if (mysql_num_rows($coder_result)) {
		$coder = true;
	}
	else {
		$coder = false;
	}

	if ($coder || is_admin()) {
		if (mysql_query("UPDATE $db_name.bugs SET module=$module, priority=$priority, status=$status" . ((isset($assign) && $assign == "on") ? ", coder=$id" : "") . " WHERE id=$bugid")) {
			echo "<P>Bug updated.</P>\n";
		}
		else {
			echo mysql_error() . "<BR>\n";
			echo "<P>There was an error altering the bug. Please e-mail <A HREF=\"mailto:jernai@iinet.net.au\">Jernai Teifsel</A> with the details on what you were trying to add, and any error messages shown above.</P>\n";
		}
	}
	
	page_end($module);
}

function admin_index() {
	global $id, $PHP_SELF;

	echo "<P>Welcome to the administration interface to the bug tracker. You may select from one of the following options:</P>\n";

	echo "<UL>\n";
	echo "<LI><A HREF=\"$PHP_SELF?page=admin/addcoder\">Add a coder to a module</A>\n";
	echo "<LI><A HREF=\"$PHP_SELF?page=admin/selectdeletecoder\">Delete a coder from a module</A>\n";
	if (is_admin()) {
		echo "<LI><A HREF=\"$PHP_SELF?page=admin/addmodule\">Add a new module</A>\n";
		echo "<LI><A HREF=\"$PHP_SELF?page=admin/selecteditmodule\">Edit a module</A>\n";
		echo "<LI><A HREF=\"$PHP_SELF?page=admin/deletemodule\">Delete a module</A>\n";
		echo "<LI><A HREF=\"$PHP_SELF?page=admin/deletebug\">Delete a bug</A>\n";
	}
	echo "</UL>\n";
}

function admin_addmodule() {
	global $id, $PHP_SELF;

	echo "<FORM NAME=\"addmodule\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"admin/savenewmodule\">\n";
	echo "<P>Name of module to add: <INPUT TYPE=TEXT SIZE=20 NAME=\"modulename\"><BR>\n";
	echo "<P>BHG roster ID of manager: <INPUT TYPE=TEXT SIZE=5 NAME=\"manager\"></P>\n";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Add Module\"> <INPUT TYPE=RESET>\n";
	echo "</FORM>\n";
}

function admin_savenewmodule() {
	global $id, $PHP_SELF, $db_name, $db, $user_db, $modulename, $manager;

	if (mysql_query("INSERT INTO $db_name.modules (name, manager) VALUES ('" . addslashes($modulename) . "', $manager)") && mysql_query("INSERT INTO $db_name.maintainers (module, coder) VALUES (" . mysql_insert_id() . ", $manager)")) {
		$manager_id = mysql_query("SELECT * FROM $user_db.roster WHERE id=$manager");
		if ($manager_id && mysql_num_rows($manager_id)) {
			echo "<P>Module $modulename has been added, with the manager set to " . stripslashes(mysql_result($manager_id, 0, "name")) . ".</P>\n";
		}
		else {
			echo "<P>Module $modulename has been added, but you gave a non-existant roster ID as the manager.</P>\n";
		}
	}
	else {
		echo mysql_error() . "<BR>\n";
		echo "<P>Error creating module.</P>\n";
	}
}

function admin_selecteditmodule() {
	global $id, $db_name, $PHP_SELF;

	echo "<FORM NAME=\"editmodule\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"admin/editmodule\">\n";
	echo "<P>Select module to edit: ";
	dropdown_modules("module");
	echo "</P>\n";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Edit Module\">\n";
	echo "</FORM>\n";
}

function admin_editmodule() {
	global $id, $module, $db_name, $PHP_SELF;

	$module_result = mysql_query("SELECT * FROM $db_name.modules WHERE id=$module");
	$mod = mysql_fetch_array($module_result);

	echo "<FORM NAME=\"editmodule\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"admin/savemodule\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"module\" VALUE=\"$module\">\n";
	echo "<P>Module name: <INPUT TYPE=TEXT SIZE=20 NAME=\"modulename\" VALUE=\"" . $mod["name"] . "\"><BR>\n";
	echo "Roster ID of maintainer: <INPUT TYPE=TEXT SIZE=5 NAME=\"manager\" VALUE=\"" . $mod["manager"] . "\"></P>\n";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Save Module\">\n";
	echo "</FORM>\n";
}

function admin_savemodule() {
	global $id, $module, $modulename, $manager, $db_name, $PHP_SELF;

	if (mysql_query("UPDATE $db_name.modules SET name=\"" . addslashes($modulename) . "\", manager=$manager WHERE id=$module")) {
		echo "<P>Module updated.</P>\n";
	}
	else {
		echo mysql_error() . "<BR>\n";
		echo "<P>Error updating module.</P>\n";
	}
}

function admin_deletemodule() {
	global $id, $PHP_SELF;

	echo "<FORM NAME=\"deletemodule\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"admin/zapmodule\">\n";
	echo "<P>Module to delete: ";
	dropdown_modules("module");
	echo "</P>\n";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Delete Module\">\n";
	echo "</FORM>\n";
}

function admin_zapmodule() {
	global $id, $PHP_SELF, $module, $db_name;

	mysql_select_db($db_name);
	if (mysql_query("DELETE FROM modules WHERE id=$module") && mysql_query("DELETE FROM maintainers WHERE module=$module")) {
		echo "Deleted from modules and maintainers succesfully.<BR>\n";
		$bugs_result = mysql_query("SELECT * FROM bugs WHERE module=$module");
		$bugs = false;
		while ($bug = mysql_fetch_array($bugs_result)) {
			$bugs[] = $bug["id"];
		}
		if ($bugs) {
			if (mysql_query("DELETE FROM notes WHERE bugid IN (" . implode(",", $bugs) . ")")) {
				echo "Deleted from notes successfully.<BR>\n";
			}
			else {
				echo mysql_error . "<BR>\n";
				echo "Error deleting from notes.<BR>\n";
			}
		}
		if (mysql_query("DELETE FROM bugs WHERE module=$module")) {
			echo "Deleted from bugs successfully.<BR>\n";
		}
		else {
			echo mysql_error . "<BR>\n";
			echo "Error deleting from bugs.<BR>\n";
		}
	}
	else {
		echo mysql_error . "<BR>\n";
		echo "Error deleting from modules and maintainers.<BR>\n";
	}
}

function admin_deletebug() {
	global $PHP_SELF, $db_name;

	echo "<FORM NAME=\"deletebug\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"admin/zapbug\">\n";
	echo "<P>Select the bug to delete: ";
	echo "<SELECT SIZE=1 NAME=\"bugid\">\n";
	$bugs = mysql_query("SELECT * FROM $db_name.bugs ORDER BY id ASC");
	while ($bug = mysql_fetch_array($bugs)) {
		echo "<OPTION VALUE=\"" . $bug["id"] . "\">" . $bug["id"] . ": " . stripslashes($bug["subject"]) . "</OPTION>\n";
	}
	echo "</SELECT>\n</P>";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Delete Bug\">\n";
}

function admin_zapbug() {
	global $PHP_SELF, $db_name, $bugid;

	mysql_select_db($db_name);
	if (mysql_query("DELETE FROM bugs WHERE id=$bugid") && mysql_query("DELETE FROM notes WHERE bugid=$bugid")) {
		echo "Delete successful.\n";
	}
	else {
		echo mysql_error() . "<BR>\n";
		echo "Error deleting bug.\n";
	}
}

function admin_addcoder() {
	global $PHP_SELF, $db_name, $id;

	echo "<FORM NAME=\"addcoder\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"admin/savecoder\">\n";
	echo "<P>BHG roster ID: <INPUT TYPE=TEXT SIZE=5 NAME=\"rosterid\"><BR>\n";
	echo "Module: \n";
	echo "<SELECT NAME=\"module\" SIZE=1>\n";
	$modules = mysql_query("SELECT * FROM $db_name.modules WHERE id IN (" . implode(",", managed_modules()) . ") ORDER BY name ASC");
	while ($mod = mysql_fetch_array($modules)) {
		echo "<OPTION VALUE=\"" . $mod["id"] . "\">" . stripslashes($mod["name"]) . "</OPTION>\n";
	}
	echo "</SELECT></P>\n";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Add Coder\"> <INPUT TYPE=RESET>";
}

function admin_savecoder() {
	global $PHP_SELF, $db_name, $id, $module, $rosterid, $user_db;

	if (mysql_query("INSERT INTO $db_name.maintainers (module, coder) VALUES ($module, $rosterid)")) {
		$coder = mysql_query("SELECT * FROM $user_db.roster WHERE id=$rosterid");
		$module_name = mysql_query("SELECT * FROM $db_name.modules WHERE id=$module");
		if ($coder && mysql_num_rows($coder)) {
			echo stripslashes(mysql_result($coder, 0, "name")) . " added as a coder to " . stripslashes(mysql_result($module_name, 0, "name")) . ".\n";
		}
		else {
			echo "Coder added to " . stripslashes(mysql_result($module_name, 0, "name")) . ", but they have no roster record!\n";
		}
	}
	else {
		echo mysql_error() . "<BR>\n";
		echo "Error adding coder.\n";
	}
}

function admin_selectdeletecoder() {
	global $PHP_SELF, $db_name, $id;

	echo "<FORM NAME=\"deletecoder\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"admin/deletecoder\">\n";
	echo "<P>Module to delete coder from: ";
	echo "<SELECT NAME=\"module\" SIZE=1>\n";
	$modules = mysql_query("SELECT * FROM $db_name.modules WHERE id IN (" . implode(",", managed_modules()) . ") ORDER BY name ASC");
	while ($module = mysql_fetch_array($modules)) {
		echo "<OPTION VALUE=\"" . $module["id"] . "\">" . stripslashes($module["name"]) . "</OPTION>\n";
	}
	echo "</SELECT></P>\n";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Select Module\">";
}

function admin_deletecoder() {
	global $PHP_SELF, $db_name, $id, $user_db, $module;

	echo "<FORM NAME=\"deletecoder\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"admin/zapcoder\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"module\" VALUE=\"$module\">\n";
	echo "<P>Select coder to delete: ";
	echo "<SELECT NAME=\"coder\" SIZE=1>\n";
	$coders = mysql_query("SELECT $db_name.maintainers.coder AS id, $user_db.roster.name FROM $db_name.maintainers, $user_db.roster WHERE $user_db.roster.id=$db_name.maintainers.coder AND $db_name.maintainers.module=$module");
	while ($coder = mysql_fetch_array($coders)) {
		echo "<OPTION VALUE=\"" . $coder["id"] . "\">" . stripslashes($coder["name"]) . "</OPTION>\n";
	}
	echo "</SELECT></P>\n";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Delete Coder\">";
}

function admin_zapcoder() {
	global $PHP_SELF, $db_name, $user_db, $id, $module, $coder;

	if (mysql_query("DELETE FROM maintainers WHERE module=$module AND coder=$coder")) {
		echo "Coder deleted.";
	}
	else {
		echo mysql_error() . "<BR>\n";
		echo "Error deleting coder.";
	}
}

$pages = explode("/", $page, 2);
switch ($pages[0]) {
	case "admin":
		page_start("Administration", true);
		if (managed_modules()) {
			switch ($pages[1]) {
				case "addmodule":
					if (is_admin()) admin_addmodule();
					break;
				case "savenewmodule":
					if (is_admin()) admin_savenewmodule();
					break;
				case "selecteditmodule":
					if (is_admin()) admin_selecteditmodule();
					break;
				case "editmodule":
					if (is_admin()) admin_editmodule();
					break;
				case "savemodule":
					if (is_admin()) admin_savemodule();
					break;
				case "addcoder":
					admin_addcoder();
					break;
				case "savecoder":
					admin_savecoder();
					break;
				case "selectdeletecoder":
					admin_selectdeletecoder();
					break;
				case "deletecoder":
					admin_deletecoder();
					break;
				case "zapcoder":
					admin_zapcoder();
					break;
				case "deletemodule":
					if (is_admin()) admin_deletemodule();
					break;
				case "zapmodule":
					if (is_admin()) admin_zapmodule();
					break;
				case "deletebug":
					if (is_admin()) admin_deletebug();
					break;
				case "zapbug":
					if (is_admin()) admin_zapbug();
					break;
				case "index": default:
					admin_index();
			}
		}
		else {
			echo "<P>You are not authorised to use the administration interface.</P>\n";
		}
		page_end();
		break;
	case "reportbug":
		reportbug();
		break;
	case "listbugs":
		listbugs();
		break;
	case "listnewbugs":
		listnewbugs();
		break;
	case "viewbug":
		viewbug();
		break;
	case "addnote":
		addnote();
		break;
	case "savenote":
		savenote();
		break;
	case "savebug":
		savebug();
		break;
	case "index": default:
		index();
}

?>

<?php
/* Roach Motel 3.0
 * Author: Jernai Teifsel <jernai@iinet.net.au>
 * 
 * This bug tracker is kind of a mini-Bugzilla, with little bits of the
 * Sourceforge bug tracker thrown in for good measure.
 *
 * Known bugs: None, but there almost certainly are some.
 */

define("CODENAME", "Roach Motel");
define("VERSION", "3.0.5a");

ob_start("ob_gzhandler");

require("config.php");
include("roster.inc");

$id = -1;

$db = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name, $db);

$roster = new Roster('bugs-are-everwhere');
$news = new News('bugs-are-everwhere');

function page_start($title, $auth = false) {
	global $name, $user, $id, $db, $PHP_AUTH_USER, $PHP_AUTH_PW, $module, $PHP_SELF;

	$auth_fail = false;
	if ($auth) {
		if (!isset($PHP_AUTH_USER) || $PHP_AUTH_USER == "") {
			$auth_fail = true;
		}
		else {
			$login = new Login($PHP_AUTH_USER, $PHP_AUTH_PW);
			if ($login->IsValid()) {
				$user = $login;
				$id = $user->GetID();
			}
			else {
				$auth_fail = true;
			}
		}
	}
	if ($auth && $auth_fail) {
		header("WWW-Authenticate: Basic realm=\"Bug Tracker\"");
		header("HTTP/1.1 401 Unauthorized");
	}

	if (empty($module)) {
		$module = 1;
	}

	header('Content-Type: text/html; charset=ISO-8859-1');
	echo
"<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html/loose.dtd\">
<HTML>
<HEAD>
<TITLE>$name - $title</TITLE>
<LINK REL=\"stylesheet\" TYPE=\"text/css\" HREF=\"bugs-3.css\">
</HEAD>
<BODY>
<P CLASS=\"HEADING\">$name :: $title</P>
";

	if ($auth && $auth_fail) {
		echo "<P>There was an error while authenticating against the roster. Check your username and password and try again.</P>";
		page_end();
		header("Content-Length: " . ob_get_length());
		ob_end_flush();
		exit;
	}
}

function page_end($module = 1) {
	global $title, $main_site, $db, $PHP_SELF;

	echo "<BR><HR><P CLASS=\"MENU\">[ <A HREF=\"$PHP_SELF?page=index\">News</A> :: <A HREF=\"$PHP_SELF?page=reportbug\">Report Bug</A> :: <A HREF=\"$PHP_SELF?page=search\">Search</A> :: <A HREF=\"$PHP_SELF?page=listbugs&amp;module=$module\">Modules</A> :: <A HREF=\"$PHP_SELF?page=listnewbugs\">List New Bugs</A> :: <A HREF=\"$PHP_SELF?page=my\">My Bugs</A> :: <A HREF=\"$PHP_SELF?page=stats\">Statistics</A> :: <A HREF=\"$PHP_SELF?page=admin/index\">Administration</A> ]<BR><BR>\nPowered by ".CODENAME." version ".VERSION.".</P></BODY>\n</HTML>";
}

function is_admin() {
	global $id, $admins;

	return in_array($id, $admins);
}

function is_manager($module) {
	global $id, $db_name, $db;

	$module_result = mysql_query("SELECT * FROM $db_name.modules WHERE id=$module AND manager=$id", $db);
	return ($module_result && mysql_num_rows($module_result));
}

function managed_modules() {
	global $id, $db_name, $db;

	$list = false;

	if (is_admin()) {
		$modules = mysql_query("SELECT * FROM $db_name.modules ORDER BY id ASC", $db);
	}
	else {
		$modules = mysql_query("SELECT * FROM $db_name.modules WHERE manager=$id ORDER BY id ASC", $db);
	}

	while ($module = mysql_fetch_array($modules)) {
		$list[] = $module["id"];
	}
	
	return $list;
}

function dropdown_modules($name, $select = -1, $multiple = false) {
	global $db_name, $db;
	
	if ($multiple) {
		echo "<SELECT SIZE=8 MULTIPLE NAME=\"{$name}[]\">\n";
	}
	else {
		echo "<SELECT SIZE=1 NAME=\"$name\">\n";
	}
	$modules = mysql_query("SELECT * FROM $db_name.modules ORDER BY name ASC", $db);
	while ($module = mysql_fetch_array($modules)) {
		echo "<OPTION VALUE=\"" . $module["id"] . "\"" . (($module["id"] == $select) ? " SELECTED" : "") . ">" . stripslashes($module["name"]) . "</OPTION>\n";
	}
	echo "</SELECT>\n";
}

function dropdown_status($name, $select = -1, $multiple = false) {
	global $db_name, $db;
	
	if ($multiple) {
		echo "<SELECT SIZE=8 MULTIPLE NAME=\"{$name}[]\">\n";
	}
	else {
		echo "<SELECT SIZE=1 NAME=\"$name\">\n";
	}
	$status = mysql_query("SELECT * FROM $db_name.status ORDER BY description ASC", $db);
	while ($stat = mysql_fetch_array($status)) {
		echo "<OPTION VALUE=\"" . $stat["id"] . "\"" . (($stat["id"] == $select) ? " SELECTED" : "") . ">" . stripslashes($stat["description"]) . "</OPTION>\n";
	}
	echo "</SELECT>\n";
}

function dropdown_priority($name, $select = -1, $multiple = false) {
	global $db_name, $db;
	
	if ($multiple) {
		echo "<SELECT SIZE=8 MULTIPLE NAME=\"{$name}[]\">\n";
	}
	else {
		echo "<SELECT SIZE=1 NAME=\"$name\">\n";
	}
	$priority = mysql_query("SELECT * FROM $db_name.priority ORDER BY level ASC", $db);
	while ($stat = mysql_fetch_array($priority)) {
		echo "<OPTION VALUE=\"" . $stat["level"] . "\"" . (($stat["level"] == $select) ? " SELECTED" : "") . ">" . stripslashes($stat["description"]) . "</OPTION>\n";
	}
	echo "</SELECT>\n";
}

function dropdown_coders($name, $module, $current_coder) {
	global $db_name, $db, $id, $roster;
	
	echo "<SELECT SIZE=1 NAME=\"$name\">\n<OPTION VALUE=\"0\"" . (($current_coder == 0) ? " SELECTED" : "") . ">No-one</OPTION>";
	$modules = mysql_query("SELECT * FROM $db_name.maintainers WHERE module=$module", $db);
	while ($module = mysql_fetch_array($modules)) {
		$coder = $roster->GetPerson($module["coder"]);
		$module_opt[$coder->GetName()] = "<OPTION VALUE=\"" . $module["coder"] . "\"" . (($module["coder"] == $current_coder) ? " SELECTED" : "") . ">" . $coder->GetName() . "</OPTION>\n";
	}
	ksort($module_opt);
	echo implode("", $module_opt);
	echo "</SELECT>\n";
}

function bleach($str, $nowrap) {
	if (!$nowrap) {
		$str = wordwrap($str, 60);
	}
	return addslashes(htmlspecialchars($str));
}

function email($module, $subject, $message) {
	global $name, $db_name, $roster, $db;

	$coders = mysql_query("SELECT coder FROM maintainers WHERE module=$module", $db);
	if ($coders && mysql_num_rows($coders)) {
		while ($coder = mysql_fetch_array($coders)) {
			$code_monkey = $roster->GetPerson($coder["coder"]);
			$to[] = $code_monkey->GetName() . " <" . $code_monkey->GetEmail() . ">";
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
	global $roster, $news;

	$jer = $roster->GetPerson(666);
	
	page_start("Index");

	echo "<P>Welcome to the BHG bug tracker. This allows hunters to report bugs found in BHG systems, and developers to keep easy track of those bugs. Additionally, wish lists of features can be kept in this system for tracking.</P>\n";
	echo "<P>Any problems with this bug tracker should be reported using the report bug link below. You can e-mail <A HREF=\"mailto:" . $jer->GetEmail() . "\">" . $jer->GetName() . "</A> if you have any problems that prevent you from reporting a bug in the usual way.</P>\n";
	$news->LoadConfig('news.ini');
	$news->Render();
	
	page_end();
}

function reportbug() {
	global $PHP_SELF;
	
	page_start("Report New Bug", true);

	echo "<FORM NAME=\"reportbug\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"savebug\">\n";
	echo "<TABLE>\n";
	echo "<TR><TD>Module:</TD><TD>\n";
	dropdown_modules("module");
	echo "</TD></TR>\n";
	echo "<TR><TD>Subject:</TD><TD><INPUT TYPE=TEXT SIZE=40 NAME=\"subject\"></TD></TR>\n";
	echo "<TR><TD>Description:</TD><TD><TEXTAREA ROWS=6 COLS=60 NAME=\"description\"></TEXTAREA></TD></TR>\n";
	echo "</TABLE>\n";
	echo "<P><INPUT TYPE=CHECKBOX NAME=\"wishlist\" VALUE=\"on\"> This is a feature request or wish list, not a bug</P>\n";
	echo "<P><INPUT TYPE=CHECKBOX NAME=\"nowrap\" VALUE=\"on\"> <U>Do not</U> automatically word-wrap this note</P>\n";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Report Bug\">&nbsp;<INPUT TYPE=RESET>\n";
	echo "</FORM>\n";

	page_end();
}

function savebug() {
	global $id, $module, $subject, $description, $db_name, $new_status, $new_priority, $PHP_SELF, $wishlist, $roster, $nowrap, $db;

	$subj = bleach($subject, true);
	$desc = bleach($description, $nowrap == "on");

	page_start("Save Bug Report", true);

	if (mysql_query("INSERT INTO $db_name.bugs (module, status, priority, reporter, subject, description, time) VALUES ($module, $new_status, " . ((isset($wishlist) && ($wishlist == "on")) ? "6" : "$new_priority") . ", $id, '$subj', '$desc', " . time() . ")", $db)) {
		$module_info = mysql_query("SELECT * FROM $db_name.modules WHERE id=$module", $db);
		$bugid = mysql_insert_id($db);
		email($module, "Notice: New bug report for module \"" . stripslashes(mysql_result($module_info, 0, "name")) . "\"", "A new bug has been reported. You can view the details of the bug at http://bugs.thebhg.org$PHP_SELF?page=viewbug&bugid=$bugid\n\nBHG Bug Tracker");
		echo "<P>Your bug has been added successfully. You can view the bug <A HREF=\"$PHP_SELF?page=viewbug&bugid=$bugid\">here</A>.</P>\n";
	}
	else {
		$jer = $roster->GetPerson(666);
		echo mysql_error() . "<BR>\n";
		echo "<P>There was an error adding the bug. Please e-mail <A HREF=\"mailto:" . $jer->GetEmail() . "\">" . $jer->GetName() . "</A> with the details on what you were trying to add, and any error messages shown above.</P>\n";
	}

	page_end($module);
}

function viewbug() {
	global $bugid, $db_name, $roster, $db, $PHP_SELF;

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
	echo "<TABLE RULES='all' FRAME='box'>\n";
	echo "<TR><TD>Bug ID</TD><TD>" . $bug["id"] . "</TD></TR>\n";
	echo "<TR><TD>Module</TD><TD>" . stripslashes($bug["module"]) . "</TD></TR>\n";
	echo "<TR><TD>Status</TD><TD>" . stripslashes($bug["status"]) . "</TD></TR>\n";
	echo "<TR><TD>Priority</TD><TD>" . stripslashes($bug["priority"]) . "</TD></TR>\n";
	$reporter = $roster->GetPerson($bug["reporter"]);
	echo "<TR><TD>Reported by</TD><TD><A HREF=\"mailto:" . $reporter->GetEmail() . "\">" . $reporter->GetName() . "</A></TD></TR>\n";
	if ($bug["coder"]) {
		$coder = $roster->GetPerson($bug["coder"]);
		$code_monkey = "<A HREF=\"mailto:" . $coder->GetEmail() . "\">" . $coder->GetName() . "</A>";
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
	$notes = mysql_query("SELECT * FROM notes WHERE bugid=$bugid ORDER BY time ASC", $db);
	if (mysql_num_rows($notes)) {
		echo "<TABLE RULES='all' FRAME='box'>\n";
		while ($note = mysql_fetch_array($notes)) {
			echo "<TR VALIGN=TOP>\n";
			$nper = $roster->GetPerson($note["writer"]);
			echo "<TD><P>By: " . $nper->GetName() . "<BR>At: " . date("j/n/Y G:i:s", $note["time"]) . "</P></TD>\n";
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
	global $module, $showall, $db, $db_name, $PHP_SELF, $roster;

	page_start("Modules");

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
	$module_info = mysql_query("SELECT manager FROM modules WHERE id=$module", $db);
	$manager = $roster->GetPerson(mysql_result($module_info, 0, "manager"));
	echo "<P>Module Manager: <A HREF=\"mailto:" . $manager->GetEmail() . "\">" . $manager->GetName() . "</A><BR>\n";
	$coders = mysql_query("SELECT coder FROM maintainers WHERE module=$module", $db);
	echo "Coder(s):";
	while ($coder = mysql_fetch_array($coders)) {
		$code_monkey = $roster->GetPerson($coder["coder"]);
		$coder_list[$code_monkey->GetName()] = " <A HREF=\"mailto:" . $code_monkey->GetEmail() . "\">" . $code_monkey->GetName() . "</A>";
	}
	ksort($coder_list);
	echo implode(", ", $coder_list);
	echo "</P>\n";

	echo "<TABLE RULES='all' FRAME='box'>";
	echo "<TR><TD><B>Status</B></TD><TD><B>Priority</B></TD><TD><B>Subject</B></TD><TD><B>Date/Time</B></TD><TD><B>Last Update</B></TD></TR>\n";
	$bugs = mysql_db_query($db_name, "SELECT bugs.id, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.module=$module ORDER BY bugs.status ASC, bugs.priority ASC, lastupdate DESC, bugs.time DESC", $db);
	if (mysql_num_rows($bugs)) {
		while ($bug = mysql_fetch_array($bugs)) {
			$highlight = (time() - $bug["lastupdate"]) < (7 * 24 * 60 * 60) ? " CLASS=\"HIGHLIGHT\"" : "";
			echo "<TR><TD$highlight>" . stripslashes($bug["status"]) . "</TD><TD$highlight>" . stripslashes($bug["priority"]) . "</TD><TD$highlight><A HREF=\"$PHP_SELF?page=viewbug&bugid=" . $bug["id"] . "\">" . stripslashes($bug["subject"]) . "</A></TD><TD$highlight>" . date("j/n/Y G:i:s", $bug["time"]) . "</TD><TD$highlight>" . date("j/n/Y G:i:s", $bug["lastupdate"]) . "</TD></TR>\n";
		}
	}
	echo "</TABLE>\n";
	
	page_end($module);
}

function listnewbugs() {
	global $db, $db_name, $PHP_SELF, $roster;

	page_start("New Bug List");

	echo "<TABLE RULES='all' FRAME='box'>";
	echo "<TR><TD><B>Module</B></TD><TD><B>Status</B></TD><TD><B>Priority</B></TD><TD><B>Subject</B></TD><TD><B>Date/Time</B></TD><TD><B>Last Update</B></TD></TR>\n";
	$bugs = mysql_db_query($db_name, "SELECT bugs.id, bugs.module, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.status<4 AND (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(bugs.lastupdate))<(3600*24*7) ORDER BY modules.name ASC, UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.status ASC, bugs.priority ASC, bugs.time DESC", $db);
	echo mysql_error();
	if (mysql_num_rows($bugs)) {
		while ($bug = mysql_fetch_array($bugs)) {
			echo "<TR><TD><A HREF=\"$PHP_SELF?page=listbugs&module=" . $bug["module"] . "\">" . stripslashes($bug["name"]) . "</A></TD><TD>" . stripslashes($bug["status"]) . "</TD><TD>" . stripslashes($bug["priority"]) . "</TD><TD><A HREF=\"$PHP_SELF?page=viewbug&bugid=" . $bug["id"] . "\">" . stripslashes($bug["subject"]) . "</A></TD><TD>" . date("j/n/Y G:i:s", $bug["time"]) . "</TD><TD>" . date("j/n/Y G:i:s", $bug["lastupdate"]) . "</TD></TR>\n";
		}
	}
	echo "</TABLE>\n";
	
	page_end();
}

function addnote() {
	global $db_name, $bugid, $db, $id, $PHP_SELF;

	page_start("Add Note", true);

	$bug_result = mysql_query("SELECT * FROM $db_name.bugs WHERE id=$bugid", $db);
	echo mysql_error();
	$bug = mysql_fetch_array($bug_result);
	$coder_result = mysql_query("SELECT * FROM $db_name.maintainers WHERE coder=$id AND module=" . $bug["module"], $db);
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
		echo "<TABLE>\n";
		echo "<TR><TD>Change module to:</TD><TD>";
		dropdown_modules("module", $bug["module"]);
		echo "</TD></TR>\n";
		echo "<TR><TD>Status:</TD><TD>";
		dropdown_status("status", $bug["status"]);
		echo "</TD></TR>\n";
		echo "<TR><TD>Priority:</TD><TD>";
		dropdown_priority("priority", $bug["priority"]);
		echo "</TD></TR>\n";
		echo "<TR><TD>Assign bug to:</TD><TD>";
		dropdown_coders("assign", $bug["module"], $bug["coder"]);
		echo "</TD></TR>\n";
		echo "</TABLE><BR>\n";
	}
	echo "Note to add:<BR>\n";
	echo "<TEXTAREA COLS=60 ROWS=6 NAME=\"note\"></TEXTAREA>\n";
	echo "<P><INPUT TYPE=CHECKBOX NAME=\"nowrap\" VALUE=\"on\"> <U>Do not</U> automatically word-wrap this note</P>\n";
	echo "<P><INPUT TYPE=SUBMIT VALUE=\"Add Note\"> <INPUT TYPE=RESET></P>\n";
	echo "</FORM>\n";

	page_end($bug["module"]);
}

function savenote() {
	global $id, $bugid, $module, $status, $priority, $db, $db_name, $assign, $note, $nowrap, $roster, $name, $PHP_SELF;

	page_start("Save Note", true);

	$note = bleach($note, $nowrap == "on");

	if (mysql_query("INSERT INTO $db_name.notes (bugid, writer, time, note) VALUES ($bugid, $id, " . time() . ", '$note')", $db) && mysql_query("UPDATE $db_name.bugs SET lastupdate=NULL WHERE id=$bugid", $db)) {
		echo "<P>Your note has been added to the bug. You can go back to the bug by clicking <A HREF=\"$PHP_SELF?page=viewbug&bugid=$bugid\">here</A>.</P>\n";
	}
	else {
		echo mysql_error() . "<BR>\n";
		echo "<P>There was an error adding the note. Please e-mail <A HREF=\"mailto:jernai@iinet.net.au\">Jernai Teifsel</A> with the details on what you were trying to add, and any error messages shown above.</P>\n";
	}

	$bug_result = mysql_query("SELECT * FROM $db_name.bugs WHERE id=$bugid", $db);
	echo mysql_error();
	$bug = mysql_fetch_array($bug_result);
	$coder_result = mysql_query("SELECT * FROM $db_name.maintainers WHERE coder=$id AND module=" . $bug["module"], $db);
	if (mysql_num_rows($coder_result)) {
		$coder = true;
	}
	else {
		$coder = false;
	}

	if ($coder || is_admin()) {
		if (mysql_query("UPDATE $db_name.bugs SET module=$module, priority=$priority, status=$status, coder=$assign WHERE id=$bugid", $db)) {
			if ($assign != $id && $assign > 0 && $assign != $bug["coder"]) {
				$owner = $roster->GetPerson($assign);
				$assigner = $roster->GetPerson($id);
				$headers = "From: $name <bugtracker@thebhg.org>\nX-Sender: <bugtracker@thebhg.org>\nX-Mailer: PHP\nReturn-Path: <bugtracker@thebhg.org>\n";
				$message = "You have been assigned bug \"" . stripslashes($bug["subject"]) . "\" by " . $assigner->GetName() . ". Full details of the bug are at http://bugs.thebhg.org$PHP_SELF?page=viewbug&bugid=$bugid\n\nBHG Bug Tracker";
				mail($owner->GetEmail(), "Notice: Bug assigned to you", $message, $headers);
			}
			echo "<P>Bug updated.</P>\n";
		}
		else {
			echo mysql_error() . "<BR>\n";
			echo "<P>There was an error altering the bug. Please e-mail <A HREF=\"mailto:jernai@iinet.net.au\">Jernai Teifsel</A> with the details on what you were trying to add, and any error messages shown above.</P>\n";
		}
	}
	if ($id != $bug["coder"] && $bug["coder"] > 0) {
		$owner = $roster->GetPerson($bug["coder"]);
		$pleb = $roster->GetPerson($id);
		$headers = "From: $name <bugtracker@thebhg.org>\nX-Sender: <bugtracker@thebhg.org>\nX-Mailer: PHP\nReturn-Path: <bugtracker@thebhg.org>\n";
		$message = "A new note has been added to bug \"" . stripslashes($bug["subject"]) . "\" by " . $pleb->GetName() . ". Full details of the bug are at http://bugs.thebhg.org$PHP_SELF?page=viewbug&bugid=$bugid\n\nBHG Bug Tracker";
		mail($owner->GetEmail(), "Notice: Note added to bug", $message, $headers);
	}
		
	page_end($module);
}

function stats() {
	global $db, $db_name, $roster, $PHP_SELF;

	page_start("Statistics");

	$managers_result = mysql_query("SELECT COUNT(DISTINCT id) AS modules, manager FROM $db_name.modules GROUP BY manager ORDER BY modules DESC", $db);
	echo "<B>Managers</B>\n<OL>\n";
	while ($manager = mysql_fetch_array($managers_result)) {
		$pleb = $roster->GetPerson($manager["manager"]);
		echo "<LI>" . $pleb->GetName() . ": " . $manager["modules"] . " module" . ($manager["modules"] > 1 ? "s" : "");
	}
	echo "</OL><BR><BR>\n";

	$coders_result = mysql_query("SELECT COUNT(DISTINCT module) AS modules, coder FROM $db_name.maintainers GROUP BY coder ORDER BY modules DESC", $db);
	echo "<B>Coders</B>\n<OL>\n";
	while ($coder = mysql_fetch_array($coders_result)) {
		$pleb = $roster->GetPerson($coder["coder"]);
		echo "<LI>" . $pleb->GetName() . ": " . $coder["modules"] . " module" . ($coder["modules"] > 1 ? "s" : "");
	}
	echo "</OL><BR><BR>\n";

	$coders_result = mysql_query("SELECT COUNT(DISTINCT id) AS modules, coder FROM $db_name.bugs GROUP BY coder ORDER BY modules DESC", $db);
	echo "<B>Bug Assignees</B>\n<OL>\n";
	while ($coder = mysql_fetch_array($coders_result)) {
		$pleb = $roster->GetPerson($coder["coder"]);
		echo "<LI>" . ($pleb->GetName() ? $pleb->GetName() : "Unassigned") . ": " . $coder["modules"] . " bug" . ($coder["modules"] > 1 ? "s" : "");
	}
	echo "</OL><BR><BR>\n";

	$coders_result = mysql_query("SELECT COUNT(DISTINCT id) AS modules, reporter FROM $db_name.bugs GROUP BY reporter ORDER BY modules DESC", $db);
	echo "<B>Bug Reporters</B>\n<OL>\n";
	while ($coder = mysql_fetch_array($coders_result)) {
		$pleb = $roster->GetPerson($coder["reporter"]);
		echo "<LI>" . $pleb->GetName() . ": " . $coder["modules"] . " bug" . ($coder["modules"] > 1 ? "s" : "");
	}
	echo "</OL><BR><BR>\n";

	$coders_result = mysql_query("SELECT COUNT(DISTINCT id) AS modules, writer FROM $db_name.notes GROUP BY writer ORDER BY modules DESC", $db);
	echo "<B>Notes</B>\n<OL>\n";
	while ($coder = mysql_fetch_array($coders_result)) {
		$pleb = $roster->GetPerson($coder["writer"]);
		echo "<LI>" . $pleb->GetName() . ": " . $coder["modules"] . " note" . ($coder["modules"] > 1 ? "s" : "");
	}
	echo "</OL><BR><BR>\n";

	page_end();
}

function my() {
	global $db, $roster, $id, $PHP_SELF;

	page_start("My Bugs", true);

	echo "<TABLE RULES='all' FRAME='box'><TR><TD COLSPAN=6><B>Bugs assigned to you</B></TD></TR>";
	echo "<TR><TD><B>Module</B></TD><TD><B>Status</B></TD><TD><B>Priority</B></TD><TD><B>Subject</B></TD><TD><B>Date/Time</B></TD><TD><B>Last Update</B></TD></TR>\n";
	$bugs = mysql_query("SELECT bugs.id, bugs.module, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.coder=$id AND bugs.status IN (2, 3) ORDER BY modules.name ASC, UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.status ASC, bugs.priority ASC, bugs.time DESC", $db);
	echo mysql_error($db);
	if (mysql_num_rows($bugs)) {
		while ($bug = mysql_fetch_array($bugs)) {
			echo "<TR><TD><A HREF=\"$PHP_SELF?page=listbugs&module=" . $bug["module"] . "\">" . stripslashes($bug["name"]) . "</A></TD><TD>" . stripslashes($bug["status"]) . "</TD><TD>" . stripslashes($bug["priority"]) . "</TD><TD><A HREF=\"$PHP_SELF?page=viewbug&bugid=" . $bug["id"] . "\">" . stripslashes($bug["subject"]) . "</A></TD><TD>" . date("j/n/Y G:i:s", $bug["time"]) . "</TD><TD>" . date("j/n/Y G:i:s", $bug["lastupdate"]) . "</TD></TR>\n";
		}
	}
	echo "</TABLE><BR><BR>\n";

	echo "<TABLE RULES='all' FRAME='box'><TR><TD COLSPAN=6><B>New bugs in your modules</B></TD></TR>";
	echo "<TR><TD><B>Module</B></TD><TD><B>Status</B></TD><TD><B>Priority</B></TD><TD><B>Subject</B></TD><TD><B>Date/Time</B></TD><TD><B>Last Update</B></TD></TR>\n";
	$modules_result = mysql_query("SELECT * FROM maintainers WHERE coder=$id AND module>0 GROUP BY module ORDER BY module ASC", $db);
	if (mysql_num_rows($modules_result)) {
		while ($module = mysql_fetch_array($modules_result)) {
			$modules[] = $module["module"];
		}
	}
	$bugs = mysql_query("SELECT bugs.id, bugs.module, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.status=1 AND (modules.manager=$id" . ((isset($modules) && count($modules)) ? " OR modules.id IN (" . implode(",", $modules) . ")" : "") . ")  ORDER BY modules.name ASC, UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.status ASC, bugs.priority ASC, bugs.time DESC", $db);
	echo mysql_error($db);
	if (mysql_num_rows($bugs)) {
		while ($bug = mysql_fetch_array($bugs)) {
			echo "<TR><TD><A HREF=\"$PHP_SELF?page=listbugs&module=" . $bug["module"] . "\">" . stripslashes($bug["name"]) . "</A></TD><TD>" . stripslashes($bug["status"]) . "</TD><TD>" . stripslashes($bug["priority"]) . "</TD><TD><A HREF=\"$PHP_SELF?page=viewbug&bugid=" . $bug["id"] . "\">" . stripslashes($bug["subject"]) . "</A></TD><TD>" . date("j/n/Y G:i:s", $bug["time"]) . "</TD><TD>" . date("j/n/Y G:i:s", $bug["lastupdate"]) . "</TD></TR>\n";
		}
	}
	echo "</TABLE>\n";
	
	page_end();
}

function search() {
	global $db, $PHP_SELF;

	page_start("Search");

	echo "<FORM NAME=\"search\" METHOD=\"post\" ACTION=\"$PHP_SELF\"><INPUT TYPE=\"hidden\" NAME=\"page\" VALUE=\"dosearch\">\n";
	echo "<TABLE><TR><TD>Module(s):</TD><TD>Status:</TD><TD>Priority:</TD></TR>\n";
	echo "<TR><TD>";
	dropdown_modules("modules", -1, true);
	echo "</TD><TD>";
	dropdown_status("status", -1, true);
	echo "</TD><TD>";
	dropdown_priority("priority", -1, true);
	echo "</TD></TR></TABLE><BR>\n";
	echo "<INPUT TYPE=\"radio\" NAME=\"show_all\" VALUE=\"1\" CHECKED>&nbsp;Show all bugs<BR>\n";
	echo "<INPUT TYPE=\"radio\" NAME=\"show_all\" VALUE=\"0\">&nbsp;Only show bugs updated in the last <INPUT TYPE=\"text\" NAME=\"days\" VALUE=\"14\" SIZE=\"3\"> days</INPUT><BR><BR>\n";
	echo "<INPUT TYPE=\"submit\" VALUE=\"Search\"> <INPUT TYPE=\"reset\">\n</FORM>\n";

	page_end();
}

function dosearch() {
	global $db, $modules, $status, $priority, $show_all, $days, $PHP_SELF;

	page_start("Search");

	$sql = "SELECT bugs.id, bugs.module, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status";
	if (isset($modules)) {
		$sql .= " AND bugs.module IN (" . implode(",", $modules) . ")";
	}
	if (isset($status)) {
		$sql .= " AND bugs.status IN (" . implode(",", $status) . ")";
	}
	if (isset($priority)) {
		$sql .= " AND bugs.priority IN (" . implode(",", $priority) . ")";
	}
	if ($show_all == 0 && isset($days)) {
		$sql .= " AND UNIX_TIMESTAMP(bugs.lastupdate)>" . (time() - ($days * 3600 * 24));
	}
	$sql .= " ORDER BY modules.name ASC, bugs.status DESC, bugs.priority ASC, UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.time DESC";
	$bugs = mysql_query($sql, $db);
	echo mysql_error($db);
	if (mysql_num_rows($bugs)) {
		echo "<TABLE RULES='all' FRAME='box'>";
		echo "<TR><TD><B>Module</B></TD><TD><B>Status</B></TD><TD><B>Priority</B></TD><TD><B>Subject</B></TD><TD><B>Date/Time</B></TD><TD><B>Last Update</B></TD></TR>\n";
		while ($bug = mysql_fetch_array($bugs)) {
			echo "<TR><TD><A HREF=\"$PHP_SELF?page=listbugs&module=" . $bug["module"] . "\">" . stripslashes($bug["name"]) . "</A></TD><TD>" . stripslashes($bug["status"]) . "</TD><TD>" . stripslashes($bug["priority"]) . "</TD><TD><A HREF=\"$PHP_SELF?page=viewbug&bugid=" . $bug["id"] . "\">" . stripslashes($bug["subject"]) . "</A></TD><TD>" . date("j/n/Y G:i:s", $bug["time"]) . "</TD><TD>" . date("j/n/Y G:i:s", $bug["lastupdate"]) . "</TD></TR>\n";
		}
		echo "</TABLE>\n";
	}
	else {
		echo "No rows matching those criteria found.";
	}

	page_end();
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
		echo "<LI><A HREF=\"news-admin.php\">News administration</A>\n";
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
	global $id, $PHP_SELF, $db_name, $db, $roster, $modulename, $manager;

	if (mysql_query("INSERT INTO $db_name.modules (name, manager) VALUES ('" . addslashes($modulename) . "', $manager)", $db) && mysql_query("INSERT INTO $db_name.maintainers (module, coder) VALUES (" . mysql_insert_id() . ", $manager)", $db)) {
		$manager_id = $roster->GetPerson($manager);
		if ($manager_id) {
			echo "<P>Module $modulename has been added, with the manager set to " . $manager_id->GetName() . ".</P>\n";
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
	global $id, $module, $db_name, $PHP_SELF, $db;

	$module_result = mysql_query("SELECT * FROM $db_name.modules WHERE id=$module", $db);
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
	global $id, $module, $modulename, $manager, $db_name, $PHP_SELF, $db;

	if (mysql_query("UPDATE $db_name.modules SET name=\"" . addslashes($modulename) . "\", manager=$manager WHERE id=$module", $db)) {
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
	global $id, $PHP_SELF, $module, $db_name, $db;

	mysql_select_db($db_name);
	if (mysql_query("DELETE FROM modules WHERE id=$module", $db) && mysql_query("DELETE FROM maintainers WHERE module=$module", $db)) {
		echo "Deleted from modules and maintainers succesfully.<BR>\n";
		$bugs_result = mysql_query("SELECT * FROM bugs WHERE module=$module", $db);
		$bugs = false;
		while ($bug = mysql_fetch_array($bugs_result)) {
			$bugs[] = $bug["id"];
		}
		if ($bugs) {
			if (mysql_query("DELETE FROM notes WHERE bugid IN (" . implode(",", $bugs) . ")", $db)) {
				echo "Deleted from notes successfully.<BR>\n";
			}
			else {
				echo mysql_error . "<BR>\n";
				echo "Error deleting from notes.<BR>\n";
			}
		}
		if (mysql_query("DELETE FROM bugs WHERE module=$module", $db)) {
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
	global $PHP_SELF, $db_name, $db;

	echo "<FORM NAME=\"deletebug\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"admin/zapbug\">\n";
	echo "<P>Select the bug to delete: ";
	echo "<SELECT SIZE=1 NAME=\"bugid\">\n";
	$bugs = mysql_query("SELECT * FROM $db_name.bugs ORDER BY id ASC", $db);
	while ($bug = mysql_fetch_array($bugs)) {
		echo "<OPTION VALUE=\"" . $bug["id"] . "\">" . $bug["id"] . ": " . stripslashes($bug["subject"]) . "</OPTION>\n";
	}
	echo "</SELECT>\n</P>";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Delete Bug\">\n";
}

function admin_zapbug() {
	global $PHP_SELF, $db_name, $bugid, $db;

	mysql_select_db($db_name);
	if (mysql_query("DELETE FROM bugs WHERE id=$bugid", $db) && mysql_query("DELETE FROM notes WHERE bugid=$bugid", $db)) {
		echo "Delete successful.\n";
	}
	else {
		echo mysql_error() . "<BR>\n";
		echo "Error deleting bug.\n";
	}
}

function admin_addcoder() {
	global $PHP_SELF, $db_name, $id, $db;

	echo "<FORM NAME=\"addcoder\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"admin/savecoder\">\n";
	echo "<P>BHG roster ID: <INPUT TYPE=TEXT SIZE=5 NAME=\"rosterid\"><BR>\n";
	echo "Module: \n";
	echo "<SELECT NAME=\"module\" SIZE=1>\n";
	$modules = mysql_query("SELECT * FROM $db_name.modules WHERE id IN (" . implode(",", managed_modules()) . ") ORDER BY name ASC", $db);
	while ($mod = mysql_fetch_array($modules)) {
		echo "<OPTION VALUE=\"" . $mod["id"] . "\">" . stripslashes($mod["name"]) . "</OPTION>\n";
	}
	echo "</SELECT></P>\n";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Add Coder\"> <INPUT TYPE=RESET>";
}

function admin_savecoder() {
	global $PHP_SELF, $db_name, $id, $module, $rosterid, $roster, $db;

	if (mysql_query("INSERT INTO $db_name.maintainers (module, coder) VALUES ($module, $rosterid)", $db)) {
		$coder = $roster->GetPerson($rosterid);
		$module_name = mysql_query("SELECT * FROM $db_name.modules WHERE id=$module", $db);
		if ($coder && !($coder->Error())) {
			echo $coder->GetName() . " added as a coder to " . stripslashes(mysql_result($module_name, 0, "name")) . ".\n";
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
	global $PHP_SELF, $db_name, $id, $db;

	echo "<FORM NAME=\"deletecoder\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"admin/deletecoder\">\n";
	echo "<P>Module to delete coder from: ";
	echo "<SELECT NAME=\"module\" SIZE=1>\n";
	$modules = mysql_query("SELECT * FROM $db_name.modules WHERE id IN (" . implode(",", managed_modules()) . ") ORDER BY name ASC", $db);
	while ($module = mysql_fetch_array($modules)) {
		echo "<OPTION VALUE=\"" . $module["id"] . "\">" . stripslashes($module["name"]) . "</OPTION>\n";
	}
	echo "</SELECT></P>\n";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Select Module\">";
}

function admin_deletecoder() {
	global $PHP_SELF, $db_name, $id, $roster, $module, $db;

	echo "<FORM NAME=\"deletecoder\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"page\" VALUE=\"admin/zapcoder\">\n";
	echo "<INPUT TYPE=HIDDEN NAME=\"module\" VALUE=\"$module\">\n";
	echo "<P>Select coder to delete: ";
	echo "<SELECT NAME=\"coder\" SIZE=1>\n";
	$coders = mysql_query("SELECT coder FROM maintainers WHERE module=$module", $db);
	while ($coder = mysql_fetch_array($coders)) {
		$code_monkey = $roster->GetPerson($coder["coder"]);
		echo "<OPTION VALUE=\"" . $coder["coder"] . "\">" . $code_monkey->GetName() . "</OPTION>\n";
	}
	echo "</SELECT></P>\n";
	echo "<INPUT TYPE=SUBMIT VALUE=\"Delete Coder\">";
}

function admin_zapcoder() {
	global $PHP_SELF, $db_name, $id, $module, $coder, $db;

	if (mysql_query("DELETE FROM $db_name.maintainers WHERE module=$module AND coder=$coder", $db)) {
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
	case "stats":
		stats();
		break;
	case "my":
		my();
		break;
	case "search":
		search();
		break;
	case "dosearch":
		dosearch();
		break;
	case "index": default:
		index();
}

header("Content-Length: " . ob_get_length());
ob_end_flush();

exit;

?>

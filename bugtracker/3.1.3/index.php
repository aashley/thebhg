<?php
/* Roach Motel 3.1
 * Author: Jernai Teifsel <jernai@iinet.net.au>
 * 
 * This bug tracker is kind of a mini-Bugzilla, with little bits of the
 * Sourceforge bug tracker thrown in for good measure.
 *
 * Known bugs: None, but there almost certainly are some.
 */

define('CODENAME', 'Roach Motel');
define('VERSION', '3.1.3');

ob_start('ob_gzhandler');

require('config.php');
include('roster.inc');

$id = -1;

$db = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name, $db);

$roster = new Roster($roster_section);

function page_start($titl, $auth = false) {
	global $name, $user, $id, $db, $module, $title;

	$title = $titl;

	$auth_fail = false;
	if ($auth) {
		if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] == "") {
			$auth_fail = true;
		}
		else {
			$login = new Login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
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
		header('WWW-Authenticate: Basic realm="Bug Tracker"');
		header('HTTP/1.1 401 Unauthorized');
	}

	if (empty($module)) {
		$module = 1;
	}

	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Gecko')) {
		header('Content-Type: application/xhtml+xml; charset=UTF-8');
	}
	else {
		header('Content-Type: text/html; charset=UTF-8');
	}
	echo <<<EOH
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?xml-stylesheet href="#style" type="text/css" ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>$name - $title</title>
<style type="text/css" id="style">
EOH;
	readfile('bugs.css');
	echo <<<EOH
</style>
</head>
<body>
<div class="content">
EOH;

	if ($auth && $auth_fail) {
		echo '<p>There was an error while authenticating against the roster. Check your username and password and try again.</p>';
		page_end();
		header('Content-Length: ' . ob_get_length());
		ob_end_flush();
		exit;
	}
}

function page_end($module = 1, $items = false) {
	global $title, $main_site, $db, $PHP_SELF, $name;

	echo <<<EOF
</div>

<div class="menu">

<div class="section">
<div class="heading">$name :: $title</div>
</div>
EOF;

	if ($items == 'admin') {
		$items = array($_SERVER['PHP_SELF'] . '?page=admin/addcoder'=>'Add Coder to Module', $_SERVER['PHP_SELF'] . '?page=admin/selectdeletecoder'=>'Delete Coder from Module');
		if (is_admin()) {
			$items = array_merge($items, array($_SERVER['PHP_SELF'] . '?page=admin/addmodule'=>'Add New Module', $_SERVER['PHP_SELF'] . '?page=admin/selecteditmodule'=>'Edit Module', $_SERVER['PHP_SELF'] . '?page=admin/deletemodule'=>'Delete Module', $_SREVER['PHP_SELF'] . '?page=admin/deletebug'=>'Delete Bug'));
		}
	}

	if ($items) {
		echo '<div class="section"><ul class="menu">';
		foreach ($items as $url=>$name) {
			echo '<a href="' . $url . '"><li>' . $name . '</li></a>';
		}
		echo '</ul></div>';
	}

	echo <<<EOF
<div class="section">
<ul class="menu">
<a href="{$_SERVER['PHP_SELF']}?page=index"><li>News</li></a>
<a href="{$_SERVER['PHP_SELF']}?page=reportbug"><li>Report Bug</li></a>
<a href="{$_SERVER['PHP_SELF']}?page=search"><li>Search</li></a>
<a href="{$_SERVER['PHP_SELF']}?page=listnewbugs"><li>List New Bugs</li></a>
<a href="{$_SERVER['PHP_SELF']}?page=my"><li>My Bugs</li></a>
<a href="{$_SERVER['PHP_SELF']}?page=stats"><li>Statistics</li></a>
<a href="{$_SERVER['PHP_SELF']}?page=admin/index"><li>Administration</li></a>
</ul>
</div>

<div class="section">
<div class="heading">Modules</div>
<ul class="menu">
EOF;
	
	$modules = mysql_query("SELECT * FROM $db_name.modules ORDER BY name ASC", $db);
	while ($module = mysql_fetch_array($modules)) {
		echo '<a href="' . $_SERVER['PHP_SELF'] . '?page=listbugs&amp;module=' . $module['id'] . '"><li>' . stripslashes($module['name']) . '</li></a>';
	}
	
	echo <<<EOF
</ul>
</div>

<div class="section">
<div class="footer">Copy &copy; 2001-03 <a href="mailto:jernai@iinet.net.au">Adam Harvey</a>.</div>
EOF;
	echo '<div class="footer">This is ' . CODENAME . ' version ' . VERSION . '.</div>';
	echo <<<EOF
</div>
</div>
</body>
</html>
EOF;
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

function dropdown_roster($name, $select = -1, $multiple = false) {
	global $roster;

	if ($multiple) {
		echo '<select size="8" multiple="multiple" name="' . $name . '[]">';
	}
	else {
		echo '<select size="1" name="' . $name . '">';
	}

	foreach ($roster->GetDivisions('name') as $div) {
		if ($div->IsActive() && $div->GetMemberCount()) {
			echo '<optgroup label="' . htmlspecialchars($div->GetName()) . '">';
			foreach ($div->GetMembers('name') as $pleb) {
				echo '<option value="' . $pleb->GetID() . '"' . ($select == $pleb->GetID() ? ' selected="selected"' : '') . '>' . htmlspecialchars($pleb->GetName()) . '</option>';
			}
			echo '</optgroup>';
		}
	}

	echo '</select>';
}

function dropdown_modules($name, $select = -1, $multiple = false) {
	global $db_name, $db;
	
	if ($multiple) {
		echo '<select size="8" multiple="multiple" name="' . $name . '[]">';
	}
	else {
		echo '<select size="1" name="' . $name . '">';
	}
	$modules = mysql_query("SELECT * FROM $db_name.modules ORDER BY name ASC", $db);
	while ($module = mysql_fetch_array($modules)) {
		echo '<option value="' . $module['id'] . '"' . (($module['id'] == $select) ? ' selected="selected"' : '') . '>' . stripslashes($module['name']) . '</option>';
	}
	echo '</select>';
}

function dropdown_status($name, $select = -1, $multiple = false) {
	global $db_name, $db;
	
	if ($multiple) {
		echo '<select size="8" multiple="multiple" name="' . $name . '[]">';
	}
	else {
		echo '<select size="1" name="' . $name . '">';
	}
	$status = mysql_query("SELECT * FROM $db_name.status ORDER BY description ASC", $db);
	while ($stat = mysql_fetch_array($status)) {
		echo '<option value="' . $stat['id'] . '"' . (($stat['id'] == $select) ? ' selected="selected"' : '') . '>' . stripslashes($stat['description']) . '</option>';
	}
	echo '</select>';
}

function dropdown_priority($name, $select = -1, $multiple = false) {
	global $db_name, $db;
	
	if ($multiple) {
		echo '<select size="8" multiple="multiple" name="' . $name . '[]">';
	}
	else {
		echo '<select size="1" name="' . $name . '">';
	}
	$priority = mysql_query("SELECT * FROM $db_name.priority ORDER BY level ASC", $db);
	while ($stat = mysql_fetch_array($priority)) {
		echo '<option value="' . $stat['level'] . '"' . (($stat['level'] == $select) ? ' selected="selected"' : '') . '>' . stripslashes($stat['description']) . '</option>';
	}
	echo '</select>';
}

function dropdown_coders($name, $module, $current_coder) {
	global $db_name, $db, $id, $roster;
	
	echo '<select size="1" name="' . $name . '"><option value="0"' . (($current_coder == 0) ? ' selected="selected"' : '') . '>No-one</option>';
	$modules = mysql_query("SELECT * FROM $db_name.maintainers WHERE module=$module", $db);
	while ($module = mysql_fetch_array($modules)) {
		$coder = $roster->GetPerson($module["coder"]);
		$module_opt[$coder->getname()] = '<option value="' . $module['coder'] . '"' . (($module['coder'] == $current_coder) ? ' selected="selected"' : '') . '>' . $coder->getname() . '</option>';
	}
	ksort($module_opt);
	echo implode("", $module_opt);
	echo '</select>';
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
	$to = array();
	if ($coders && mysql_num_rows($coders)) {
		while ($coder = mysql_fetch_array($coders)) {
			$code_monkey = $roster->GetPerson($coder["coder"]);
			$to[] = $code_monkey->GetName() . ' <' . $code_monkey->GetEmail() . '>';
		}
	}
	$recip = implode(", ", $to);

	$headers = <<<EOH
From: $name <bugtracker@thebhg.org>
X-Sender: <bugtracker@thebhg.org>
X-Mailer: PHP
Return-Path: <bugtracker@thebhg.org>
EOH;

	mail($recip, $subject, $message, $headers);
}

function index() {
	global $roster, $roster_section;

	$jer = $roster->GetPerson(666);
	$news = new News($roster_section);
	
	page_start('Index');

	echo 'Welcome to the BHG bug tracker. This allows hunters to report bugs found in BHG systems, and developers to keep easy track of those bugs. Additionally, wish lists of features can be kept in this system for tracking.<br /><br />';
	echo 'Any problems with this bug tracker should be reported using the report bug link at right. You can e-mail <a href="mailto:' . $jer->GetEmail() . '">' . $jer->GetName() . '</a> if you have any problems that prevent you from reporting a bug in the usual way.';

	$items = $news->GetNews(5, 'posts');
	if (is_array($items) && count($items)) {
		echo '<hr /><table>';
		$first = true;
		foreach ($items as $item) {
			if ($first) {
				$first = false;
			}
			else {
				echo '<tr><td colspan="2" /></tr>';
			}
			$poster = $item->GetPoster();
			echo '<tr><th>' . htmlspecialchars($item->GetTitle()) . '</th><th>Posted by <a href="mailto:' . urlencode($poster->GetEmail()) . '">' . htmlspecialchars($poster->GetName()) . '</a> on ' . date('j/n/Y \a\t G:i:s T', $item->GetTimestamp()) . '</th></tr>';
			$message = $item->GetMessage();
			if (stristr($message, '<') === false) {
				$message = nl2br(htmlspecialchars($message));
			}
			else {
				$message = str_replace('<br>', '<br />', $message);
			}
			echo '<tr><td colspan="2">' . nl2br($message) . '</td></tr>';
		}
		echo '</table>';
	}
	
	page_end();
}

function reportbug() {
	page_start('Report New Bug', true);

	echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="savebug" />';
	echo '<table>';
	echo '<tr><td>Module:</td><td>';
	dropdown_modules('module');
	echo '</td></tr>';
	echo '<tr><td>Subject:</td><td><input type="text" size="40" name="subject" /></td></tr>';
	echo '<tr><td>Description:</td><td><textarea rows="6" cols="60" name="description"></textarea></td></tr>';
	echo '<tr><td>Feature Request:</td><td><input type="checkbox" name="wishlist" value="on" /></td></tr>';
	echo '<tr><td colspan="2"><div class="information">The above box should only be ticked if this is <u>not</u> a bug.</div></td></tr>';
	echo '<tr><td>Disable Word-Wrap:</td><td><input type="checkbox" name="nowrap" value="on" /></td></tr>';
	echo '<tr><td colspan="2"><div class="information">The above box should only be ticked if this is a code sample.</div></td></tr>';
	echo '<tr><td colspan="2"><div class="buttons"><input type="reset" /><input type="submit" value="Report Bug" /></div></td></tr>';
	echo '</table></form>';

	page_end();
}

function savebug() {
	global $db_name, $new_status, $new_priority, $roster, $db, $id;

	$subj = bleach($_POST['subject'], true);
	$desc = bleach($_POST['description'], $_POST['nowrap'] == 'on');

	page_start("Save Bug Report", true);

	if (mysql_query("INSERT INTO $db_name.bugs (module, status, priority, reporter, subject, description, time) VALUES ({$_POST['module']}, $new_status, " . ($_POST['wishlist'] == 'on' ? '6' : $new_priority) . ", $id, '$subj', '$desc', " . time() . ")", $db)) {
		$module_info = mysql_query("SELECT * FROM $db_name.modules WHERE id=" . $_POST['module'], $db);
		$bugid = mysql_insert_id($db);
		email($module, 'Notice: New bug report for module "' . stripslashes(mysql_result($module_info, 0, 'name')) . '"', 'A new bug has been reported. You can view the details of the bug at http://bugs.thebhg.org' . $_SERVER['PHP_SELF'] . '?page=viewbug&bugid=' . $bugid . "\n\nBHG Bug Tracker");
		echo 'Your bug has been added successfully. You can view the bug <a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bugid . '">here</a>.';
	}
	else {
		$jer = $roster->GetPerson(666);
		echo mysql_error($db) . "<br />\n";
		echo 'There was an error adding the bug. Please e-mail <a href="mailto:' . $jer->GetEmail() . '">' . $jer->GetName() . '</a> with the details on what you were trying to add, and any error messages shown above.';
	}

	page_end($module);
}

function viewbug() {
	global $db_name, $roster, $db;

	page_start('View Bug');

	$bug_result = mysql_db_query($db_name, 'SELECT bugs.id, bugs.module AS modnumber, modules.name AS module, status.description AS status, priority.description AS priority, bugs.reporter, bugs.coder, bugs.subject, bugs.description, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, status, priority WHERE bugs.module=modules.id AND bugs.status=status.id AND bugs.priority=priority.level AND bugs.id=' . $_REQUEST['bugid'], $db);
	if (!($bug_result && $bug = mysql_fetch_array($bug_result))) {
		echo mysql_error() . '<br /><br />Error getting bug number ' . $_REQUEST['bugid'] . '.';
		page_end();
		return;
	}

	echo '<table>';
	echo '<tr><td>Bug ID:</td><td>' . $bug['id'] . '</td></tr>';
	echo '<tr><td>Module:</td><td><a href="' . $_SERVER['PHP_SELF'] . '?page=listbugs&amp;module=' . $bug['modnumber'] . '">' . stripslashes($bug['module']) . '</a></td></tr>';
	echo '<tr><td>Status:</td><td>' . stripslashes($bug['status']) . '</td></tr>';
	echo '<tr><td>Priority:</td><td>' . stripslashes($bug['priority']) . '</td></tr>';
	$reporter = $roster->GetPerson($bug['reporter']);
	echo '<tr><td>Reported By:</td><td><a href="mailto:' . $reporter->GetEmail() . '">' . $reporter->GetName() . '</a></td></tr>';
	if ($bug['coder']) {
		$coder = $roster->GetPerson($bug['coder']);
		$code_monkey = '<a href="mailto:' . $coder->GetEmail() . '">' . $coder->GetName() . '</a>';
	}
	else {
		$code_monkey = 'No-one';
	}
	echo '<tr><td>Assigned To:</td><td>' . $code_monkey . '</td></tr>';
	echo '<tr><td>Reported:</td><td>' . date('l j/n/Y \a\t G:i:s T', $bug['time']) . '</td></tr>';
	echo '<tr><td>Last Update:</td><td>' . date('l j/n/Y \a\t G:i:s T', $bug['lastupdate']) . '</td></tr>';
	echo '<tr><td>Subject:</td><td>' . stripslashes($bug['subject']) . '</td></tr>';
	echo '<tr><td>Description:</td><td><pre>' . stripslashes($bug['description']) . '</pre></td></tr>';
	echo '</table>';

	echo '<hr />';

	$notes = mysql_query("SELECT * FROM notes WHERE bugid={$_REQUEST['bugid']} ORDER BY time ASC", $db);
	if (mysql_num_rows($notes)) {
		echo '<table>';
		while ($note = mysql_fetch_array($notes)) {
			echo '<tr>';
			$nper = $roster->GetPerson($note["writer"]);
			echo '<td>By: ' . $nper->GetName() . '<br />On: ' . date('j/n/Y \a\t G:i:s T', $note['time']) . '</td>';
			echo '<td><pre>' . stripslashes($note['note']) . '</pre></td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	else {
		echo 'No notes have been made on this bug yet.';
	}

	page_end($bug['modnumber'], array($_SERVER['PHP_SELF'] . '?page=addnote&amp;bugid=' . $_REQUEST['bugid']=>'Add Note to Bug'));
}

function listbugs() {
	global $db, $db_name, $roster;

	if (!isset($_REQUEST['module'])) {
		$module = 1;
	}
	else {
		$module = $_REQUEST['module'];
	}
	$module_info = mysql_query('SELECT * FROM modules WHERE id=' . $module, $db);

	page_start(stripslashes(mysql_result($module_info, 0, 'name')));

	echo '<table>';
	$manager = $roster->GetPerson(mysql_result($module_info, 0, 'manager'));
	echo '<tr><td>Manager:</td><td><a href="mailto:' . $manager->GetEmail() . '">' . $manager->GetName() . '</a></td></tr>';
	$coders = mysql_query("SELECT coder FROM maintainers WHERE module=$module", $db);
	echo '<tr><td>Coder(s):</td><td>';
	if ($coders && mysql_num_rows($coders)) {
		while ($coder = mysql_fetch_array($coders)) {
			$code_monkey = $roster->GetPerson($coder['coder']);
			$coder_list[$code_monkey->GetName()] = ' <a href="mailto:' . $code_monkey->GetEmail() . '">' . $code_monkey->GetName() . '</a>';
		}
		ksort($coder_list);
		echo implode(', ', $coder_list);
	}
	else {
		echo 'N/A';
	}
	echo '</td></tr></table>';

	echo '<hr />';

	$bugs = mysql_db_query($db_name, "SELECT bugs.id, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.module=$module ORDER BY bugs.status ASC, bugs.priority ASC, lastupdate DESC, bugs.time DESC", $db);
	echo '<table>';
	echo '<tr><th>Status</th><th>Priority</th><th>Subject</th><th>Date/Time</th><th>Last Update</th></tr>';
	if (mysql_num_rows($bugs)) {
		while ($bug = mysql_fetch_array($bugs)) {
			if ((time() - $bug['lastupdate']) < (7 * 24 * 60 * 60)) {
				echo '<tr class="highlight">';
			}
			else {
				echo '<tr>';
			}
			echo '<td>' . stripslashes($bug['status']) . '</td><td>' . stripslashes($bug['priority']) . '</td><td><a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bug['id'] . '">' . stripslashes($bug['subject']) . '</a></td><td>' . date('j/n/Y \a\t G:i:s T', $bug['time']) . '</td><td>' . date('j/n/Y \a\t G:i:s T', $bug['lastupdate']) . '</td></tr>';
		}
	}
	else {
		echo '<tr><td colspan="5">No bugs found.</td></tr>';
	}
	echo '</table>';
	
	page_end($module);
}

function listnewbugs() {
	global $db, $db_name,$roster;

	page_start('New Bug List');

	$bugs = mysql_db_query($db_name, "SELECT bugs.id, bugs.module, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.status<4 AND (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(bugs.lastupdate))<(3600*24*7) ORDER BY modules.name ASC, UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.status ASC, bugs.priority ASC, bugs.time DESC", $db);
	echo '<table>';
	echo '<tr><th>Module</th><th>Status</th><th>Priority</th><th>Subject</th><th>Date/Time</th><th>Last Update</th></tr>';
	if (mysql_num_rows($bugs)) {
		while ($bug = mysql_fetch_array($bugs)) {
			echo '<tr><td><a href="' . $_SERVER['PHP_SELF'] . '?page=listbugs&amp;module=' . $bug['module'] . '">' . stripslashes($bug['name']) . '</a></td><td>' . stripslashes($bug['status']) . '</td><td>' . stripslashes($bug['priority']) . '</td><td><a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bug['id'] . '">' . stripslashes($bug['subject']) . '</a></td><td>' . date('j/n/Y \a\t G:i:s T', $bug['time']) . '</td><td>' . date('j/n/Y \a\t G:i:s T', $bug['lastupdate']) . '</td></tr>';
		}
	}
	else {
		echo '<tr><td colspan="6">No bugs found.</td></tr>';
	}
	echo '</table>';

	page_end();
}

function addnote() {
	global $db_name, $db, $id;

	page_start('Add Note', true);

	$bug_result = mysql_query("SELECT * FROM $db_name.bugs WHERE id=" . $_REQUEST['bugid'], $db);
	$bug = mysql_fetch_array($bug_result);
	$coder_result = mysql_query("SELECT * FROM $db_name.maintainers WHERE coder=$id AND module=" . $bug['module'], $db);
	if (mysql_num_rows($coder_result)) {
		$coder = true;
	}
	else {
		$coder = false;
	}

	echo '<form name="addnote" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="savenote" />';
	echo '<input type="hidden" name="bugid" value="' . $_REQUEST['bugid'] . '" />';
	echo '<table>';
	if ($coder || is_admin() || is_manager($bug["module"])) {
		echo '<tr><td colspan="2">As a coder on this module, you have access to alter almost all the fields available on a bug.</td></tr>';
		echo '<tr><td>Module:</td><td>';
		dropdown_modules('module', $bug['module']);
		echo '</td></tr>';
		echo '<tr><td>Status:</td><td>';
		dropdown_status('status', $bug['status']);
		echo '</td></tr>';
		echo '<tr><td>Priority:</td><td>';
		dropdown_priority('priority', $bug['priority']);
		echo '</td></tr>';
		echo '<tr><td>Assign Bug To:</td><td>';
		dropdown_coders('assign', $bug['module'], $bug['coder']);
		echo '</td></tr>';
	}
	echo '<tr><td>Note:</td><td><textarea cols="60" rows="6" name="note"></textarea></td></tr>';
	echo '<tr><td>Disable Word-Wrap:</td><td><input type="checkbox" name="nowrap" value="on" /></td></tr>';
	echo '<tr><td colspan="2"><div class="information">The above box should only be ticked if this is a code sample.</div></td></tr>';
	echo '<tr><td colspan="2"><div class="buttons"><input type="reset" /><input type="submit" value="Add Note" /></div></td></tr>';
	echo '</table></form>';

	page_end($bug['module']);
}

function savenote() {
	global $id, $db, $db_name, $roster, $name;

	page_start('Save Note', true);

	$note = bleach($_POST['note'], $_POST['nowrap'] == "on");

	if (mysql_query("INSERT INTO $db_name.notes (bugid, writer, time, note) VALUES ({$_POST['bugid']}, $id, " . time() . ", '$note')", $db) && mysql_query("UPDATE $db_name.bugs SET lastupdate=NULL WHERE id={$_POST['bugid']}", $db)) {
		echo 'Your note has been added to the bug. You can go back to the bug by clicking <a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $_POST['bugid'] . '">here</a>.';
	}
	else {
		echo mysql_error() . '<br /><br />';
		echo 'There was an error adding the note. Please e-mail <A HREF="mailto:jernai@iinet.net.au">Jernai Teifsel</A> with the details on what you were trying to add, and any error messages shown above.';
	}

	$bug_result = mysql_query("SELECT * FROM $db_name.bugs WHERE id=" . $_POST['bugid'], $db);
	$bug = mysql_fetch_array($bug_result);
	$coder_result = mysql_query("SELECT * FROM $db_name.maintainers WHERE coder=$id AND module=" . $bug['module'], $db);
	if (mysql_num_rows($coder_result)) {
		$coder = true;
	}
	else {
		$coder = false;
	}

	if ($coder || is_admin()) {
		if (mysql_query("UPDATE $db_name.bugs SET module={$_POST['module']}, priority={$_POST['priority']}, status={$_POST['status']}, coder={$_POST['assign']} WHERE id={$_POST['bugid']}", $db)) {
			if ($assign != $id && $assign > 0 && $assign != $bug['coder']) {
				$owner = $roster->GetPerson($assign);
				$assigner = $roster->GetPerson($id);
				$headers = "From: $name <bugtracker@thebhg.org>\nX-Sender: <bugtracker@thebhg.org>\nX-Mailer: PHP\nReturn-Path: <bugtracker@thebhg.org>\n";
				$message = 'You have been assigned bug "' . stripslashes($bug['subject']) . '" by ' . $assigner->GetName() . '. Full details of the bug are at http://bugs.thebhg.org' . $_SERVER['PHP_SELF'] . "?page=viewbug&bugid={$_POST['bugid']}\n\nBHG Bug Tracker";
				mail($owner->GetEmail(), 'Notice: Bug assigned to you', $message, $headers);
			}
			echo '<br /><br />Bug updated.';
		}
		else {
			echo mysql_error() . '<br /><br />';
			echo 'There was an error altering the bug\'s properties. Please e-mail <A HREF="mailto:jernai@iinet.net.au">Jernai Teifsel</A> with the details on what you were trying to add, and any error messages shown above.';
		}
	}
	if ($id != $bug['coder'] && $bug['coder'] > 0) {
		$owner = $roster->GetPerson($bug['coder']);
		$pleb = $roster->GetPerson($id);
		$headers = "From: $name <bugtracker@thebhg.org>\nX-Sender: <bugtracker@thebhg.org>\nX-Mailer: PHP\nReturn-Path: <bugtracker@thebhg.org>\n";
		$message = 'A new note has been added to bug "' . stripslashes($bug['subject']) . '" by ' . $pleb->GetName() . '. Full details of the bug are at http://bugs.thebhg.org' . $_SERVER['PHP_SELF'] . "?page=viewbug&bugid={$_REQUEST['bugid']}\n\nBHG Bug Tracker";
		mail($owner->GetEmail(), 'Notice: Note added to bug', $message, $headers);
	}
		
	page_end($module);
}

function stats() {
	global $db, $db_name, $roster;

	page_start('Statistics');

	$managers_result = mysql_query("SELECT COUNT(DISTINCT id) AS modules, manager FROM $db_name.modules GROUP BY manager ORDER BY modules DESC", $db);
	echo '<a name="managers" /><table><tr><th class="numeric" /><th>Manager</th><th class="numeric">Modules</th></tr>';
	$last_mod = -1;
	$rank = 0;
	$row = 0;
	while ($manager = mysql_fetch_array($managers_result)) {
		$row++;
		if ($last_mod != $manager['modules']) {
			$last_mod = $manager['modules'];
			$rank = $row;
		}
		$pleb = $roster->GetPerson($manager['manager']);
		echo '<tr><td class="numeric">' . number_format($rank) . '</td><td>' . $pleb->GetName() . '</td><td class="numeric">' . number_format($manager['modules']) . '</td></tr>';
	}
	echo '</table><hr />';

	$coders_result = mysql_query("SELECT COUNT(DISTINCT module) AS modules, coder FROM $db_name.maintainers GROUP BY coder ORDER BY modules DESC", $db);
	echo '<a name="coders" /><table><tr><th class="numeric" /><th>Coder</th><th class="numeric">Modules</th></tr>';
	$last_mod = -1;
	$rank = 0;
	$row = 0;
	while ($coder = mysql_fetch_array($coders_result)) {
		$row++;
		if ($last_mod != $coder['modules']) {
			$last_mod = $coder['modules'];
			$rank = $row;
		}
		$pleb = $roster->GetPerson($coder['coder']);
		echo '<tr><td class="numeric">' . number_format($rank) . '</td><td>' . $pleb->GetName() . '</td><td class="numeric">' . number_format($coder['modules']) . '</td></tr>';
	}
	echo '</table><hr />';

	$coders_result = mysql_query("SELECT COUNT(DISTINCT id) AS modules, coder FROM $db_name.bugs GROUP BY coder ORDER BY modules DESC", $db);
	echo '<a name="assignees" /><table><tr><th class="numeric" /><th>Assignee</th><th class="numeric">Bugs</th></tr>';
	$last_mod = -1;
	$rank = 0;
	$row = 0;
	while ($coder = mysql_fetch_array($coders_result)) {
		$row++;
		if ($last_mod != $coder['modules']) {
			$last_mod = $coder['modules'];
			$rank = $row;
		}
		$pleb = $roster->GetPerson($coder['coder']);
		echo '<tr><td class="numeric">' . number_format($rank) . '</td><td>' . ($pleb->GetName() ? $pleb->GetName() : 'Unassigned') . '</td><td class="numeric">' . number_format($coder['modules']) . '</td></tr>';
	}
	echo '</table><hr />';

	$coders_result = mysql_query("SELECT COUNT(DISTINCT id) AS modules, reporter FROM $db_name.bugs GROUP BY reporter ORDER BY modules DESC", $db);
	echo '<a name="reporters" /><table><tr><th class="numeric" /><th>Reporter</th><th class="numeric">Bugs</th></tr>';
	$last_mod = -1;
	$rank = 0;
	$row = 0;
	while ($coder = mysql_fetch_array($coders_result)) {
		$row++;
		if ($last_mod != $coder['modules']) {
			$last_mod = $coder['modules'];
			$rank = $row;
		}
		$pleb = $roster->GetPerson($coder['reporter']);
		echo '<tr><td class="numeric">' . number_format($rank) . '</td><td>' . $pleb->GetName() . '</td><td class="numeric">' . number_format($coder['modules']) . '</td></tr>';
	}
	echo '</table><hr />';

	$coders_result = mysql_query("SELECT COUNT(DISTINCT id) AS modules, writer FROM $db_name.notes GROUP BY writer ORDER BY modules DESC", $db);
	echo '<a name="notes" /><table><tr><th class="numeric" /><th>User</th><th class="numeric">Notes</th></tr>';
	$last_mod = -1;
	$rank = 0;
	$row = 0;
	while ($coder = mysql_fetch_array($coders_result)) {
		$row++;
		if ($last_mod != $coder['modules']) {
			$last_mod = $coder['modules'];
			$rank = $row;
		}
		$pleb = $roster->GetPerson($coder['writer']);
		echo '<tr><td class="numeric">' . number_format($rank) . '</td><td>' . $pleb->GetName() . '</td><td class="numeric">' . number_format($coder['modules']) . '</td></tr>';
	}
	echo '</table><hr />';

	page_end(1, array('#managers'=>'Managers', '#coders'=>'Coders', '#assignees'=>'Bug Assignees', '#reporters'=>'Bug Reporters', '#notes'=>'Notes'));
}

function my() {
	global $db, $roster, $id;

	page_start('My Bugs', true);

	$bugs = mysql_query("SELECT bugs.id, bugs.module, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.coder=$id AND bugs.status IN (2, 3) ORDER BY modules.name ASC, UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.status ASC, bugs.priority ASC, bugs.time DESC", $db);
	echo '<table><tr><th colspan="6">Bugs assigned to you</th></tr>';
	echo '<tr><th>Module</th><th>Status</th><th>Priority</th><th>Subject</th><th>Date/Time</th><th>Last Update</th></tr>';
	if (mysql_num_rows($bugs)) {
		while ($bug = mysql_fetch_array($bugs)) {
			echo '<tr><td><a href="' . $_SERVER['PHP_SELF'] . '?page=listbugs&amp;module=' . $bug['module'] . '">' . stripslashes($bug['name']) . '</a></td><td>' . stripslashes($bug['status']) . '</td><td>' . stripslashes($bug['priority']) . '</td><td><a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bug['id'] . '">' . stripslashes($bug['subject']) . '</a></td><td>' . date('j/n/Y \a\t G:i:s T', $bug['time']) . '</td><td>' . date('j/n/Y \a\t G:i:s T', $bug['lastupdate']) . '</td></tr>';
		}
	}
	else {
		echo '<tr><td colspan="6">No bugs found.</td></tr>';
	}
	echo '</table><hr />';

	$modules_result = mysql_query("SELECT * FROM maintainers WHERE coder=$id AND module>0 GROUP BY module ORDER BY module ASC", $db);
	if (mysql_num_rows($modules_result)) {
		while ($module = mysql_fetch_array($modules_result)) {
			$modules[] = $module["module"];
		}
	}
	$bugs = mysql_query("SELECT bugs.id, bugs.module, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.status=1 AND (modules.manager=$id" . ((isset($modules) && count($modules)) ? " OR modules.id IN (" . implode(",", $modules) . ")" : "") . ")  ORDER BY modules.name ASC, UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.status ASC, bugs.priority ASC, bugs.time DESC", $db);
	echo '<table><tr><th colspan="6">New bugs in your modules</th></tr>';
	echo '<tr><th>Module</th><th>Status</th><th>Priority</th><th>Subject</th><th>Date/Time</th><th>Last Update</th></tr>';
	if (mysql_num_rows($bugs)) {
		while ($bug = mysql_fetch_array($bugs)) {
			echo '<tr><td><a href="' . $_SERVER['PHP_SELF'] . '?page=listbugs&amp;module=' . $bug['module'] . '">' . stripslashes($bug['name']) . '</a></td><td>' . stripslashes($bug['status']) . '</td><td>' . stripslashes($bug['priority']) . '</td><td><a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bug['id'] . '">' . stripslashes($bug['subject']) . '</a></td><td>' . date('j/n/Y \a\t G:i:s T', $bug['time']) . '</td><td>' . date('j/n/Y \a\t G:i:s T', $bug['lastupdate']) . '</td></tr>';
		}
	}
	else {
		echo '<tr><td colspan="6">No bugs found.</td></tr>';
	}
	echo '</table>';
	
	page_end();
}

function search() {
	global $db;

	page_start('Search');

	echo '<form name="search" method="post" action="' . $_SERVER['PHP_SELF'] . '"><input type="hidden" name="page" value="dosearch" />';
	echo '<table><tr><td>Module(s):</td><td>Status:</td><td>Priority:</td></tr>';
	echo '<tr><td>';
	dropdown_modules('modules', -1, true);
	echo '</td><td>';
	dropdown_status('status', -1, true);
	echo '</td><td>';
	dropdown_priority('priority', -1, true);
	echo '</td></tr></table><br /><table>';
	echo '<tr><td><input type="radio" name="show_all" value="1" checked="checked" /></td><td>Show all bugs</td></tr>';
	echo '<tr><td><input type="radio" name="show_all" value="0" /></td><td>Only show bugs updated in the last <input type="text" name="days" value="14" size="3" /> days</td></tr>';
	echo '<tr><td colspan="2"><div class="buttons"><input type="reset" /><input type="submit" value="Report Bug" /></div></td></tr>';
	echo '</table></form>';

	page_end();
}

function dosearch() {
	global $db;

	page_start('Search');

	$sql = "SELECT bugs.id, bugs.module, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status";
	if (isset($_POST['modules'])) {
		$sql .= " AND bugs.module IN (" . implode(",", $_POST['modules']) . ")";
	}
	if (isset($_POST['status'])) {
		$sql .= " AND bugs.status IN (" . implode(",", $_POST['status']) . ")";
	}
	if (isset($_POST['priority'])) {
		$sql .= " AND bugs.priority IN (" . implode(",", $_POST['priority']) . ")";
	}
	if ($_POST['show_all'] == 0 && isset($_POST['days'])) {
		$sql .= " AND UNIX_TIMESTAMP(bugs.lastupdate)>" . (time() - ($_POST['days'] * 3600 * 24));
	}
	$sql .= " ORDER BY modules.name ASC, bugs.status DESC, bugs.priority ASC, UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.time DESC";
	$bugs = mysql_query($sql, $db);
	echo '<table>';
	echo '<tr><th>Module</th><th>Status</th><th>Priority</th><th>Subject</th><th>Date/Time</th><th>Last Update</th></tr>';
	if (mysql_num_rows($bugs)) {
		while ($bug = mysql_fetch_array($bugs)) {
			echo '<tr><td><a href="' . $_SERVER['PHP_SELF'] . '?page=listbugs&amp;module=' . $bug['module'] . '">' . stripslashes($bug['name']) . '</a></td><td>' . stripslashes($bug['status']) . '</td><td>' . stripslashes($bug['priority']) . '</td><td><a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bug['id'] . '">' . stripslashes($bug['subject']) . '</a></td><td>' . date('j/n/Y \a\t G:i:s T', $bug['time']) . '</td><td>' . date('j/n/Y \a\t G:i:s T', $bug['lastupdate']) . '</td></tr>';
		}
	}
	else {
		echo '<tr><td colspan="6">No bugs found.</td></tr>';
	}
	echo '</table>';

	page_end();
}

function admin_index() {
	echo 'Welcome to the administration interface to the bug tracker. You may select from the options at right.';
}

function admin_addmodule() {
	echo '<form name="addmodule" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/savenewmodule" />';
	echo '<table>';
	echo '<tr><td>Name:</td><td><input type="text" size="20" name="modulename" /></td></tr>';
	echo '<tr><td>Manager:</td><td>';
	dropdown_roster('manager');
	echo '</td></tr>';
	echo '<tr><td colspan="2"><div class="buttons"><input type="reset" /><input type="submit" value="Add Module" /></div></td></tr>';
	echo '</table></form>';
}

function admin_savenewmodule() {
	global $db_name, $db, $roster;

	if (mysql_query("INSERT INTO $db_name.modules (name, manager) VALUES ('" . addslashes($_POST['modulename']) . '\', ' . $_POST['manager'] . ')', $db) && mysql_query("INSERT INTO $db_name.maintainers (module, coder) VALUES (" . mysql_insert_id() . ', ' . $_POST['manager'] . ')', $db)) {
		$manager_id = $roster->GetPerson($_POST['manager']);
		if ($manager_id) {
			echo "Module {$_POST['modulename']} has been added, with the manager set to " . $manager_id->GetName() . '.';
		}
		else {
			echo "Module {$_POST['modulename']} has been added, but you gave a non-existant roster ID as the manager.";
		}
	}
	else {
		echo mysql_error() . '<br /><br />Error creating module.';
	}
}

function admin_selecteditmodule() {
	echo '<form name="editmodule" method="get" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/editmodule" />';
	echo 'Select module to edit: ';
	dropdown_modules('module');
	echo '<br /><br /><input type="submit" value="Edit Module" />';
	echo '</form>';
}

function admin_editmodule() {
	global $db_name, $db;

	$module_result = mysql_query("SELECT * FROM $db_name.modules WHERE id=" . $_GET['module'], $db);
	$mod = mysql_fetch_array($module_result);

	echo '<form name="editmodule" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/savemodule" />';
	echo '<input type="hidden" name="module" value="' . $_GET['module'] . '" />';
	echo '<table>';
	echo '<tr><td>Name:</td><td><input type="text" size="20" name="modulename" value="' . htmlspecialchars(stripslashes($mod['name'])) . '" /></td></tr>';
	echo '<tr><td>Manager:</td><td>';
	dropdown_roster('manager', $mod['manager']);
	echo '</td></tr>';
	echo '<tr><td colspan="2"><div class="buttons"><input type="reset" /><input type="submit" value="Save Module" /></div></td></tr>';
	echo '</table></form>';
}

function admin_savemodule() {
	global $db_name, $db;

	if (mysql_query("UPDATE $db_name.modules SET name=\"" . addslashes($_POST['modulename']) . "\", manager={$_POST['manager']} WHERE id=" . $_POST['module'], $db)) {
		echo 'Module updated.';
	}
	else {
		echo mysql_error() . '<br /><br />Error updating module.';
	}
}

function admin_deletemodule() {
	echo '<form name="deletemodule" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/zapmodule" />';
	echo 'Select module to delete: ';
	dropdown_modules('module');
	echo '<br /><br /><input type="submit" value="Delete Module" />';
	echo '</form>';
}

function admin_zapmodule() {
	global $db_name, $db;

	if (mysql_query('DELETE FROM modules WHERE id=' . $_POST['module'], $db) && mysql_query('DELETE FROM maintainers WHERE module=' . $_POST['module'], $db)) {
		echo 'Deleted from modules and maintainers succesfully.<br />';
		$bugs_result = mysql_query('SELECT * FROM bugs WHERE module=' . $_POST['module'], $db);
		$bugs = false;
		while ($bug = mysql_fetch_array($bugs_result)) {
			$bugs[] = $bug['id'];
		}
		if ($bugs) {
			if (mysql_query('DELETE FROM notes WHERE bugid IN (' . implode(',', $bugs) . ')', $db)) {
				echo 'Deleted from notes successfully.<br />';
			}
			else {
				echo mysql_error() . '<br /><br />Error deleting from notes.<br />';
			}
		}
		if (mysql_query('DELETE FROM bugs WHERE module=' . $_POST['module'], $db)) {
			echo 'Deleted from bugs successfully.<br />';
		}
		else {
			echo mysql_error() . '<br /><br />Error deleting from bugs.<br />';
		}
	}
	else {
		echo mysql_error() . '<br /><br />Error deleting from modules and maintainers.<br />';
	}
}

function admin_deletebug() {
	global $db_name, $db;

	echo '<form name="deletebug" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/zapbug" />';
	echo 'Select the bug to delete: ';
	echo '<select size="1" name="bugid">';
	$bugs = mysql_query("SELECT * FROM $db_name.bugs ORDER BY id ASC", $db);
	while ($bug = mysql_fetch_array($bugs)) {
		echo '<option value="' . $bug['id'] . '">' . $bug['id'] . ': ' . htmlspecialchars(stripslashes($bug['subject'])) . '</option>';
	}
	echo '</select>';
	echo '<br /><br /><input type="submit" value="Delete Bug" /></form>';
}

function admin_zapbug() {
	global $db_name, $db;

	if (mysql_query('DELETE FROM bugs WHERE id=' . $_POST['bugid'], $db) && mysql_query('DELETE FROM notes WHERE bugid=' . $_POST['bugid'], $db)) {
		echo 'Delete successful.';
	}
	else {
		echo mysql_error($db) . '<br /><br />Error deleting bug.';
	}
}

function admin_addcoder() {
	global $db_name, $db;

	echo '<form name="addcoder" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/savecoder" />';
	echo '<table>';
	echo '<tr><td>Module:</td><td>';
	echo '<select name="module" size="1">';
	$modules = mysql_query("SELECT * FROM $db_name.modules WHERE id IN (" . implode(',', managed_modules()) . ') ORDER BY name ASC', $db);
	while ($mod = mysql_fetch_array($modules)) {
		echo '<option value="' . $mod['id'] . '">' . stripslashes($mod['name']) . '</option>';
	}
	echo '</select></td></tr>';
	echo '<tr><td>Coder:</td><td>';
	dropdown_roster('rosterid');
	echo '</td></tr>';
	echo '<tr><td colspan="2"><div class="buttons"><input type="reset" /><input type="submit" value="Add Coder" /></div></td></tr>';
	echo '</table></form>';
}

function admin_savecoder() {
	global $db_name, $roster, $db;

	if (mysql_query("INSERT INTO $db_name.maintainers (module, coder) VALUES ({$_POST['module']}, {$_POST['rosterid']})", $db)) {
		$coder = $roster->GetPerson($_POST['rosterid']);
		$module_name = mysql_query("SELECT * FROM $db_name.modules WHERE id=" . $_POST['module'], $db);
		if ($coder && !($coder->Error())) {
			echo $coder->GetName() . ' added as a coder to ' . stripslashes(mysql_result($module_name, 0, 'name')) . '.';
		}
		else {
			echo 'Coder added to ' . stripslashes(mysql_result($module_name, 0, 'name')) . ', but they have no roster record!';
		}
	}
	else {
		echo mysql_error() . '<br /><br />Error adding coder.';
	}
}

function admin_selectdeletecoder() {
	global $db_name, $db;

	echo '<form name="deletecoder" method="get" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/deletecoder" />';
	echo 'Module to delete coder from: ';
	echo '<select name="module" size="1">';
	$modules = mysql_query("SELECT * FROM $db_name.modules WHERE id IN (" . implode(',', managed_modules()) . ') ORDER BY name ASC', $db);
	while ($module = mysql_fetch_array($modules)) {
		echo '<option value="' . $module['id'] . '">' . stripslashes($module['name']) . '</option>';
	}
	echo '</select><br /><br />';
	echo '<input type="submit" value="Select Module" />';
	echo '</form>';
}

function admin_deletecoder() {
	global $db_name, $roster, $db;

	echo '<form name="deletecoder" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/zapcoder" />';
	echo '<input type="hidden" name="module" value="' . $_GET['module'] . '" />';
	echo 'Select coder to delete: ';
	echo '<select name="coder" size="1">';
	$coders = mysql_query('SELECT coder FROM maintainers WHERE module=' . $_GET['module'], $db);
	while ($coder = mysql_fetch_array($coders)) {
		$code_monkey = $roster->GetPerson($coder['coder']);
		echo '<option value="' . $coder['coder'] . '">' . $code_monkey->GetName() . '</option>';
	}
	echo '</select><br /><br />';
	echo '<input type="submit" value="Delete Coder" />';
	echo '</form>';
}

function admin_zapcoder() {
	global $db_name, $db;

	if (mysql_query("DELETE FROM $db_name.maintainers WHERE module={$_POST['module']} AND coder=" . $_POST['coder'], $db)) {
		echo 'Coder deleted.';
	}
	else {
		echo mysql_error() . '<br /><br />Error deleting coder.';
	}
}

$pages = explode("/", $_REQUEST['page'], 2);
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
		page_end(1, 'admin');
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

ob_end_flush();
exit;

?>

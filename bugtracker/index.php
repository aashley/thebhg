<?php
/* Roach Motel
 * Author: Adam Harvey <jer@cernun.net>
 * 
 * This bug tracker is kind of a mini-Bugzilla, with little bits of the
 * Sourceforge bug tracker thrown in for good measure.
 *
 * Known bugs: None, but there almost certainly are some.
 */

define('CODENAME', 'Roach Motel');
define('VERSION', '3.2.0');

ob_start();

include_once 'DB.php';
include_once 'config.php';
include_once 'roster.inc';

$id = -1;

$db = DB::connect("mysql://$db_user:$db_pass@localhost/$db_name");
$db->setFetchMode(DB_FETCHMODE_ASSOC);

if (DB::isError($db)) {
	page_start('Error');
	echo 'Unable to connect to database. Please contact <a href="mailto:jer@cernun.net">Jernai Teifsel</a> with the time this error occurred.';
	echo '</div></body></html>';
	exit;
}

$roster = new Roster($roster_section);
$rm_coder = $roster->getPerson($coder);

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
	global $title, $main_site, $db, $PHP_SELF, $name, $roster, $rm_coder;

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
	
	$modules = $db->getAll('SELECT * FROM modules ORDER BY name ASC');
	foreach ($modules as $module) {
		echo '<a href="' . $_SERVER['PHP_SELF'] . '?page=listbugs&amp;module=' . $module['id'] . '"><li>' . htmlspecialchars($module['name']) . '</li></a>';
	}
	
	$rm_coder_name = $rm_coder->getName();
	$rm_coder_email = $rm_coder->getEmail();
	echo <<<EOF
</ul>
</div>

<div class="section">
<div class="footer">Copy &copy; 2001-04 <a href="mailto:$rm_coder_email">$rm_coder_name</a>.</div>
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
	global $id, $db;

	$result = $db->getOne('SELECT id FROM modules WHERE id = ? AND manager = ?', array($module, $id));
	return !is_null($result);
}

function managed_modules() {
	global $id, $db;

	if (is_admin()) {
		$modules = $db->getCol('SELECT id FROM modules ORDER BY id ASC');
	}
	else {
		$modules = $db->getCol('SELECT id FROM modules WHERE manager = ? ORDER BY id ASC', 0, array($id));
	}

	return $modules;
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
	global $db;
	
	if ($multiple) {
		echo '<select size="8" multiple="multiple" name="' . $name . '[]">';
	}
	else {
		echo '<select size="1" name="' . $name . '">';
	}
	$modules = $db->getAll('SELECT * FROM modules ORDER BY name ASC');
	foreach ($modules as $module) {
		echo '<option value="' . $module['id'] . '"' . (($module['id'] == $select) ? ' selected="selected"' : '') . '>' . htmlspecialchars($module['name']) . '</option>';
	}
	echo '</select>';
}

function dropdown_status($name, $select = -1, $multiple = false) {
	global $db;
	
	if ($multiple) {
		echo '<select size="8" multiple="multiple" name="' . $name . '[]">';
	}
	else {
		echo '<select size="1" name="' . $name . '">';
	}
	$status = $db->getAll('SELECT * FROM status ORDER BY description ASC');
	foreach ($status as $stat) {
		echo '<option value="' . $stat['id'] . '"' . (($stat['id'] == $select) ? ' selected="selected"' : '') . '>' . htmlspecialchars($stat['description']) . '</option>';
	}
	echo '</select>';
}

function dropdown_priority($name, $select = -1, $multiple = false) {
	global $db;
	
	if ($multiple) {
		echo '<select size="8" multiple="multiple" name="' . $name . '[]">';
	}
	else {
		echo '<select size="1" name="' . $name . '">';
	}
	$priority = $db->getAll('SELECT * FROM priority ORDER BY level ASC');
	foreach ($priority as $stat) {
		echo '<option value="' . $stat['level'] . '"' . (($stat['level'] == $select) ? ' selected="selected"' : '') . '>' . htmlspecialchars($stat['description']) . '</option>';
	}
	echo '</select>';
}

function dropdown_coders($name, $module, $current_coder) {
	global $db, $id, $roster;
	
	echo '<select size="1" name="' . $name . '"><option value="0"' . (($current_coder == 0) ? ' selected="selected"' : '') . '>No-one</option>';
	$modules = $db->getAll('SELECT * FROM maintainers WHERE module = ?', array($module));
	foreach ($modules as $module) {
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
	return htmlspecialchars($str);
}

function email($module, $subject, $message) {
	global $name, $roster, $db, $mail_from;

	$coders = $db->getCol('SELECT coder FROM maintainers WHERE module = ? GROUP BY coder', 0, array($module));
	foreach ($coders as $coder) {
		$code_monkey = $roster->GetPerson($coder);
		$code_monkey->SendEmail($mail_from, $subject, $message);
	}
}

function index() {
	global $roster, $roster_section, $rm_coder;

	$news = new News($roster_section);
	
	page_start('Index');

	echo 'Welcome to the BHG bug tracker. This allows hunters to report bugs found in BHG systems, and developers to keep easy track of those bugs. Additionally, wish lists of features can be kept in this system for tracking.<br /><br />';
	echo 'Any problems with this bug tracker should be reported using the report bug link at right. You can e-mail <a href="mailto:' . $rm_coder->GetEmail() . '">' . htmlspecialchars($rm_coder->GetName()) . '</a> if you have any problems that prevent you from reporting a bug in the usual way.';

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
	global $new_status, $new_priority, $roster, $db, $id, $name, $rm_coder;

	$subj = bleach($_POST['subject'], true);
	$desc = bleach($_POST['description'], $_POST['nowrap'] == 'on');

	page_start("Save Bug Report", true);

	$result = $db->query('INSERT INTO bugs (module, status, priority, reporter, subject, description, time) VALUES (?, ?, ?, ?, ?, ?, UNIX_TIMESTAMP())', array($_POST['module'], $new_status, ($_POST['wishlist'] == 'on' ? '6' : $new_priority), $id, $subj, $desc));
	if ($result == DB_OK) {
		$module_name = $db->getOne('SELECT name FROM modules WHERE id = ?', array($_POST['module']));
		$bugid = $db->getOne('SELECT LAST_INSERT_ID()');
		email($_POST['module'], 'Notice: New bug report for module "' . $module_name . '"', 'A new bug has been reported. You can view the details of the bug at http://bugs.thebhg.org' . $_SERVER['PHP_SELF'] . '?page=viewbug&bugid=' . $bugid . "\n\n$name");
		echo 'Your bug has been added successfully. You can view the bug <a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bugid . '">here</a>.';
		header('Location: /index.php?page=viewbug&bugid=' . $bugid);
	}
	else {
		echo $result->getMessage() . "<br />\n";
		echo 'There was an error adding the bug. Please e-mail <a href="mailto:' . $rm_coder->GetEmail() . '">' . htmlspecialchars($rm_coder->GetName()) . '</a> with the details on what you were trying to add, and any error messages shown above.';
	}

	page_end($module);
}

function viewbug() {
	global $roster, $db;

	page_start('View Bug');

	$bug = $db->getRow('SELECT bugs.id, bugs.module AS modnumber, modules.name AS module, status.description AS status, priority.description AS priority, bugs.reporter, bugs.coder, bugs.subject, bugs.description, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, status, priority WHERE bugs.module = modules.id AND bugs.status = status.id AND bugs.priority = priority.level AND bugs.id = ?', 0, array($_REQUEST['bugid']));
	if (DB::isError($bug)) {
		echo $bug->getMessage();
		page_end();
		return;
	}

	echo '<table>';
	echo '<tr><td>Bug ID:</td><td>' . $bug['id'] . '</td></tr>';
	echo '<tr><td>Module:</td><td><a href="' . $_SERVER['PHP_SELF'] . '?page=listbugs&amp;module=' . $bug['modnumber'] . '">' . htmlspecialchars($bug['module']) . '</a></td></tr>';
	echo '<tr><td>Status:</td><td>' . htmlspecialchars($bug['status']) . '</td></tr>';
	echo '<tr><td>Priority:</td><td>' . htmlspecialchars($bug['priority']) . '</td></tr>';
	$reporter = $roster->GetPerson($bug['reporter']);
	echo '<tr><td>Reported By:</td><td><a href="mailto:' . htmlspecialchars($reporter->GetEmail()) . '">' . htmlspecialchars($reporter->GetName()) . '</a></td></tr>';
	if ($bug['coder']) {
		$coder = $roster->GetPerson($bug['coder']);
		$code_monkey = '<a href="mailto:' . htmlspecialchars($coder->GetEmail()) . '">' . htmlspecialchars($coder->GetName()) . '</a>';
	}
	else {
		$code_monkey = 'No-one';
	}
	echo '<tr><td>Assigned To:</td><td>' . $code_monkey . '</td></tr>';
	echo '<tr><td>Reported:</td><td>' . date('l j/n/Y \a\t G:i:s T', $bug['time']) . '</td></tr>';
	echo '<tr><td>Last Update:</td><td>' . date('l j/n/Y \a\t G:i:s T', $bug['lastupdate']) . '</td></tr>';
	echo '<tr><td>Subject:</td><td>' . htmlspecialchars($bug['subject']) . '</td></tr>';
	echo '<tr><td>Description:</td><td><pre>' . htmlspecialchars($bug['description']) . '</pre></td></tr>';
	echo '</table>';

	echo '<hr />';

	$notes = $db->getAll('SELECT * FROM notes WHERE bugid = ? ORDER BY time ASC', array($_REQUEST['bugid']));
	if (count($notes) > 0) {
		echo '<table>';
		foreach ($notes as $note) {
			echo '<tr>';
			$nper = $roster->GetPerson($note['writer']);
			echo '<td>By: ' . htmlspecialchars($nper->GetName()) . '<br />On: ' . date('j/n/Y \a\t G:i:s T', $note['time']) . '</td>';
			echo '<td><pre>' . htmlspecialchars($note['note']) . '</pre></td>';
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
	global $db, $roster;

	if (!isset($_REQUEST['module'])) {
		$module = 1;
	}
	else {
		$module = $_REQUEST['module'];
	}
	$module = $db->getRow('SELECT * FROM modules WHERE id = ?', 0, array($module));

	page_start($module['name']);

	echo '<table>';
	$manager = $roster->GetPerson($module['manager']);
	echo '<tr><td>Manager:</td><td><a href="mailto:' . htmlspecialchars($manager->GetEmail()) . '">' . htmlspecialchars($manager->GetName()) . '</a></td></tr>';
	$coders = $db->getCol('SELECT coder FROM maintainers WHERE module = ?', 0, array($module['id']));
	echo '<tr><td>Coder(s):</td><td>';
	if (count($coders) > 0) {
		foreach ($coders as $coder) {
			$code_monkey = $roster->GetPerson($coder);
			$coder_list[$code_monkey->GetName()] = ' <a href="mailto:' . htmlspecialchars($code_monkey->GetEmail()) . '">' . htmlspecialchars($code_monkey->GetName()) . '</a>';
		}
		ksort($coder_list);
		echo implode(', ', $coder_list);
	}
	else {
		echo 'N/A';
	}
	echo '</td></tr></table>';

	echo '<hr />';

	$bugs = $db->getAll("SELECT bugs.id, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.module=? ORDER BY bugs.status ASC, bugs.priority ASC, lastupdate DESC, bugs.time DESC", array($module['id']));
	echo '<table>';
	echo '<tr><th>Status</th><th>Priority</th><th>Subject</th><th>Date/Time</th><th>Last Update</th></tr>';
	if (count($bugs) > 0) {
		foreach ($bugs as $bug) {
			if ((time() - $bug['lastupdate']) < (7 * 24 * 60 * 60)) {
				echo '<tr class="highlight">';
			}
			else {
				echo '<tr>';
			}
			echo '<td>' . htmlspecialchars($bug['status']) . '</td><td>' . htmlspecialchars($bug['priority']) . '</td><td><a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bug['id'] . '">' . htmlspecialchars($bug['subject']) . '</a></td><td>' . date('j/n/Y \a\t G:i:s T', $bug['time']) . '</td><td>' . date('j/n/Y \a\t G:i:s T', $bug['lastupdate']) . '</td></tr>';
		}
	}
	else {
		echo '<tr><td colspan="5">No bugs found.</td></tr>';
	}
	echo '</table>';
	
	page_end($module);
}

function listnewbugs() {
	global $db, $roster;

	page_start('New Bug List');

	$bugs = $db->getAll('SELECT bugs.id, bugs.module, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.status<4 AND (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(bugs.lastupdate))<(3600*24*7) ORDER BY modules.name ASC, UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.status ASC, bugs.priority ASC, bugs.time DESC');
	echo '<table>';
	echo '<tr><th>Module</th><th>Status</th><th>Priority</th><th>Subject</th><th>Date/Time</th><th>Last Update</th></tr>';
	if (count($bugs) > 0) {
		foreach ($bugs as $bug) {
			echo '<tr><td><a href="' . $_SERVER['PHP_SELF'] . '?page=listbugs&amp;module=' . $bug['module'] . '">' . htmlspecialchars($bug['name']) . '</a></td><td>' . htmlspecialchars($bug['status']) . '</td><td>' . htmlspecialchars($bug['priority']) . '</td><td><a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bug['id'] . '">' . htmlspecialchars($bug['subject']) . '</a></td><td>' . date('j/n/Y \a\t G:i:s T', $bug['time']) . '</td><td>' . date('j/n/Y \a\t G:i:s T', $bug['lastupdate']) . '</td></tr>';
		}
	}
	else {
		echo '<tr><td colspan="6">No bugs found.</td></tr>';
	}
	echo '</table>';

	page_end();
}

function addnote() {
	global $db, $id;

	page_start('Add Note', true);

	$bug = $db->getRow('SELECT * FROM bugs WHERE id = ?', 0, array($_REQUEST['bugid']));
	$coder_result = $db->query('SELECT * FROM maintainers WHERE coder = ? AND module = ?', array($id, $bug['module']));
	if ($coder_result->numRows() > 0) {
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
	global $id, $db, $roster, $name, $mail_from, $rm_coder;

	page_start('Save Note', true);

	$note = bleach($_POST['note'], $_POST['nowrap'] == "on");
	$bugid = (int) $_POST['bugid'];

	$result = $db->query('INSERT INTO notes (bugid, writer, time, note) VALUES (?, ?, UNIX_TIMESTAMP(), ?)', array($bugid, $id, $note));
	if ($result == DB_OK) {
		echo 'Your note has been added to the bug. You can go back to the bug by clicking <a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bugid . '">here</a>.';
		header('Location: /index.php?page=viewbug&bugid=' . $bugid);
	}
	else {
		echo $result->getMessage() . '<br /><br />';
		echo 'There was an error adding the note. Please e-mail <a href="mailto:' . $rm_coder->getEmail() . '">' . htmlspecialchars($rm_coder->getName()) . '</a> with the details on what you were trying to add, and any error messages shown above.';
	}

	$bug = $db->getRow('SELECT * FROM bugs WHERE id = ?', 0, array($bugid));
	$coder_result = $db->query('SELECT * FROM maintainers WHERE coder = ? AND module = ?', array($id, $bug['module']));
	if ($coder_result->numRows() > 0) {
		$coder = true;
	}
	else {
		$coder = false;
	}

	if ($coder || is_admin()) {
		$result = $db->query('UPDATE bugs SET module = ?, priority = ?, status = ?, coder = ? WHERE id = ?', array($_POST['module'], $_POST['priority'], $_POST['status'], $_POST['assign'], $bugid));
		if ($result == DB_OK) {
			if ($_POST['assign'] != $id && $_POST['assign'] > 0 && $_POST['assign'] != $bug['coder']) {
				$owner = $roster->GetPerson($_POST['assign']);
				$assigner = $roster->GetPerson($id);
				$message = 'You have been assigned bug "' . $bug['subject'] . '" by ' . $assigner->GetName() . '. Full details of the bug are at http://bugs.thebhg.org' . $_SERVER['PHP_SELF'] . "?page=viewbug&bugid={$bugid}\n\n$name";
				$owner->SendEmail($mail_from, 'Notice: Bug assigned to you', $message);
			}
			echo '<br /><br />Bug updated.';
		}
		else {
			echo $result->getMessage() . '<br /><br />';
			echo 'There was an error altering the bug\'s properties. Please e-mail <a href="mailto:' . $rm_coder->getEmail() . '">' . htmlspecialchars($rm_coder->getName()) . '</a> with the details on what you were trying to do, and any error messages shown above.';
		}
	}
	if ($id != $bug['coder'] && $bug['coder'] > 0) {
		$owner = $roster->GetPerson($bug['coder']);
		$pleb = $roster->GetPerson($id);
		$message = 'A new note has been added to bug "' . $bug['subject'] . '" by ' . $pleb->GetName() . '. Full details of the bug are at http://bugs.thebhg.org' . $_SERVER['PHP_SELF'] . "?page=viewbug&bugid={$bugid}\n\n$name";
		$owner->SendEmail($mail_from, 'Notice: Note added to bug', $message);
	}
		
	page_end($module);
}

function stats() {
	global $db, $roster;

	page_start('Statistics');

	$managers = $db->getAll('SELECT COUNT(DISTINCT id) AS modules, manager FROM modules GROUP BY manager ORDER BY modules DESC');
	echo '<a name="managers" /><table><tr><th class="numeric" /><th>Manager</th><th class="numeric">Modules</th></tr>';
	$last_mod = -1;
	$rank = 0;
	$row = 0;
	foreach ($managers as $manager) {
		$row++;
		if ($last_mod != $manager['modules']) {
			$last_mod = $manager['modules'];
			$rank = $row;
		}
		$pleb = $roster->GetPerson($manager['manager']);
		echo '<tr><td class="numeric">' . number_format($rank) . '</td><td>' . htmlspecialchars($pleb->GetName()) . '</td><td class="numeric">' . number_format($manager['modules']) . '</td></tr>';
	}
	echo '</table><hr />';

	$coders = $db->getAll('SELECT COUNT(DISTINCT module) AS modules, coder FROM maintainers GROUP BY coder ORDER BY modules DESC');
	echo '<a name="coders" /><table><tr><th class="numeric" /><th>Coder</th><th class="numeric">Modules</th></tr>';
	$last_mod = -1;
	$rank = 0;
	$row = 0;
	foreach ($coders as $coder) {
		$row++;
		if ($last_mod != $coder['modules']) {
			$last_mod = $coder['modules'];
			$rank = $row;
		}
		$pleb = $roster->GetPerson($coder['coder']);
		echo '<tr><td class="numeric">' . number_format($rank) . '</td><td>' . htmlspecialchars($pleb->GetName()) . '</td><td class="numeric">' . number_format($coder['modules']) . '</td></tr>';
	}
	echo '</table><hr />';

	$coders = $db->getAll('SELECT COUNT(DISTINCT id) AS modules, coder FROM bugs GROUP BY coder ORDER BY modules DESC');
	echo '<a name="assignees" /><table><tr><th class="numeric" /><th>Assignee</th><th class="numeric">Bugs</th></tr>';
	$last_mod = -1;
	$rank = 0;
	$row = 0;
	foreach ($coders as $coder) {
		$row++;
		if ($last_mod != $coder['modules']) {
			$last_mod = $coder['modules'];
			$rank = $row;
		}
		$pleb = $roster->GetPerson($coder['coder']);
		echo '<tr><td class="numeric">' . number_format($rank) . '</td><td>' . ($pleb->GetName() ? htmlspecialchars($pleb->GetName()) : 'Unassigned') . '</td><td class="numeric">' . number_format($coder['modules']) . '</td></tr>';
	}
	echo '</table><hr />';

	$coders = $db->getAll('SELECT COUNT(DISTINCT id) AS modules, reporter FROM bugs GROUP BY reporter ORDER BY modules DESC');
	echo '<a name="reporters" /><table><tr><th class="numeric" /><th>Reporter</th><th class="numeric">Bugs</th></tr>';
	$last_mod = -1;
	$rank = 0;
	$row = 0;
	foreach ($coders as $coder) {
		$row++;
		if ($last_mod != $coder['modules']) {
			$last_mod = $coder['modules'];
			$rank = $row;
		}
		$pleb = $roster->GetPerson($coder['reporter']);
		echo '<tr><td class="numeric">' . number_format($rank) . '</td><td>' . htmlspecialchars($pleb->GetName()) . '</td><td class="numeric">' . number_format($coder['modules']) . '</td></tr>';
	}
	echo '</table><hr />';

	$coders = $db->getAll('SELECT COUNT(DISTINCT id) AS modules, writer FROM notes GROUP BY writer ORDER BY modules DESC');
	echo '<a name="notes" /><table><tr><th class="numeric" /><th>User</th><th class="numeric">Notes</th></tr>';
	$last_mod = -1;
	$rank = 0;
	$row = 0;
	foreach ($coders as $coder) {
		$row++;
		if ($last_mod != $coder['modules']) {
			$last_mod = $coder['modules'];
			$rank = $row;
		}
		$pleb = $roster->GetPerson($coder['writer']);
		echo '<tr><td class="numeric">' . number_format($rank) . '</td><td>' . htmlspecialchars($pleb->GetName()) . '</td><td class="numeric">' . number_format($coder['modules']) . '</td></tr>';
	}
	echo '</table><hr />';

	page_end(1, array('#managers'=>'Managers', '#coders'=>'Coders', '#assignees'=>'Bug Assignees', '#reporters'=>'Bug Reporters', '#notes'=>'Notes'));
}

function my() {
	global $db, $roster, $id;

	page_start('My Bugs', true);

	$bugs = $db->getAll('SELECT bugs.id, bugs.module, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.coder=? AND bugs.status IN (2, 3) ORDER BY modules.name ASC, UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.status ASC, bugs.priority ASC, bugs.time DESC', array($id));
	echo '<table><tr><th colspan="6">Bugs assigned to you</th></tr>';
	echo '<tr><th>Module</th><th>Status</th><th>Priority</th><th>Subject</th><th>Date/Time</th><th>Last Update</th></tr>';
	if (count($bugs) > 0) {
		foreach ($bugs as $bug) {
			echo '<tr><td><a href="' . $_SERVER['PHP_SELF'] . '?page=listbugs&amp;module=' . $bug['module'] . '">' . htmlspecialchars($bug['name']) . '</a></td><td>' . htmlspecialchars($bug['status']) . '</td><td>' . htmlspecialchars($bug['priority']) . '</td><td><a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bug['id'] . '">' . htmlspecialchars($bug['subject']) . '</a></td><td>' . date('j/n/Y \a\t G:i:s T', $bug['time']) . '</td><td>' . date('j/n/Y \a\t G:i:s T', $bug['lastupdate']) . '</td></tr>';
		}
	}
	else {
		echo '<tr><td colspan="6">No bugs found.</td></tr>';
	}
	echo '</table><hr />';

	$modules = $db->getCol('SELECT module FROM maintainers WHERE coder = ? AND module > 0 GROUP BY module ORDER BY module ASC', 0, array($id));
	$sql = 'SELECT bugs.id, bugs.module, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status AND bugs.status=1 AND (modules.manager=?';
	if (count($modules) > 0) {
		$sql .= ' OR modules.id IN (' . implode(",", $modules) . ')';
	}
	$sql .= ') ORDER BY modules.name ASC, UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.status ASC, bugs.priority ASC, bugs.time DESC';
	$bugs = $db->getAll($sql, array($id));
	echo '<table><tr><th colspan="6">New bugs in your modules</th></tr>';
	echo '<tr><th>Module</th><th>Status</th><th>Priority</th><th>Subject</th><th>Date/Time</th><th>Last Update</th></tr>';
	if (count($bugs) > 0) {
		foreach ($bugs as $bug) {
			echo '<tr><td><a href="' . $_SERVER['PHP_SELF'] . '?page=listbugs&amp;module=' . $bug['module'] . '">' . htmlspecialchars($bug['name']) . '</a></td><td>' . htmlspecialchars($bug['status']) . '</td><td>' . htmlspecialchars($bug['priority']) . '</td><td><a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bug['id'] . '">' . htmlspecialchars($bug['subject']) . '</a></td><td>' . date('j/n/Y \a\t G:i:s T', $bug['time']) . '</td><td>' . date('j/n/Y \a\t G:i:s T', $bug['lastupdate']) . '</td></tr>';
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
	echo '<tr><td colspan="2"><div class="buttons"><input type="reset" /><input type="submit" value="Search" /></div></td></tr>';
	echo '</table></form>';

	page_end();
}

function dosearch() {
	global $db;

	page_start('Search');

	$sql = "SELECT bugs.id, bugs.module, modules.name, priority.description AS priority, status.description AS status, bugs.subject, bugs.time, UNIX_TIMESTAMP(bugs.lastupdate) AS lastupdate FROM bugs, modules, priority, status WHERE modules.id=bugs.module AND priority.level=bugs.priority AND status.id=bugs.status";
	if (isset($_POST['modules'])) {
		$modules = array();
		foreach ($_POST['modules'] as $module) {
			$modules[] = (int) $module;
		}
		$sql .= " AND bugs.module IN (" . implode(",", $modules) . ")";
	}
	if (isset($_POST['status'])) {
		$statuss = array();
		foreach ($_POST['status'] as $status) {
			$statuss[] = (int) $status;
		}
		$sql .= " AND bugs.status IN (" . implode(",", $statuss) . ")";
	}
	if (isset($_POST['priority'])) {
		$prioritys = array();
		foreach ($_POST['priority'] as $priority) {
			$prioritys[] = (int) $priority;
		}
		$sql .= " AND bugs.priority IN (" . implode(",", $prioritys) . ")";
	}
	if ($_POST['show_all'] == 0 && isset($_POST['days'])) {
		$sql .= " AND UNIX_TIMESTAMP(bugs.lastupdate)>" . (time() - (((int) $_POST['days']) * 3600 * 24));
	}
	$sql .= " ORDER BY modules.name ASC, bugs.status DESC, bugs.priority ASC, UNIX_TIMESTAMP(bugs.lastupdate) DESC, bugs.time DESC";
	$bugs = $db->getAll($sql);
	echo '<table>';
	echo '<tr><th>Module</th><th>Status</th><th>Priority</th><th>Subject</th><th>Date/Time</th><th>Last Update</th></tr>';
	if (count($bugs) > 0) {
		foreach ($bugs as $bug) {
			echo '<tr><td><a href="' . $_SERVER['PHP_SELF'] . '?page=listbugs&amp;module=' . $bug['module'] . '">' . htmlspecialchars($bug['name']) . '</a></td><td>' . htmlspecialchars($bug['status']) . '</td><td>' . htmlspecialchars($bug['priority']) . '</td><td><a href="' . $_SERVER['PHP_SELF'] . '?page=viewbug&amp;bugid=' . $bug['id'] . '">' . htmlspecialchars($bug['subject']) . '</a></td><td>' . date('j/n/Y \a\t G:i:s T', $bug['time']) . '</td><td>' . date('j/n/Y \a\t G:i:s T', $bug['lastupdate']) . '</td></tr>';
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
	global $db, $roster;

	$result = $db->query('INSERT INTO modules (name, manager) VALUES (?, ?)', array($_POST['modulename'], $_POST['manager']));
	if ($result == DB_OK) {
		$module_id = $db->getOne('SELECT LAST_INSERT_ID()');
		$result = $db->query('INSERT INTO maintainers (module, coder) VALUES (?, ?)', array($module_id, $_POST['manager']));
		if ($result == DB_OK) {
			$manager_id = $roster->GetPerson($_POST['manager']);
			if ($manager_id) {
				echo "Module {$_POST['modulename']} has been added, with the manager set to " . htmlspecialchars($manager_id->GetName()) . '.';
			}
			else {
				echo "Module {$_POST['modulename']} has been added, but you gave a non-existant roster ID as the manager.";
			}
		}
		else {
			echo $result->getMessage() . '<br /><br />Error creating coder record.';
		}
	}
	else {
		echo $result->getMessage . '<br /><br />Error creating module.';
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
	global $db;

	$mod = $db->getRow('SELECT * FROM modules WHERE id = ?', 0, array($_GET['module']));

	echo '<form name="editmodule" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/savemodule" />';
	echo '<input type="hidden" name="module" value="' . $_GET['module'] . '" />';
	echo '<table>';
	echo '<tr><td>Name:</td><td><input type="text" size="20" name="modulename" value="' . htmlspecialchars($mod['name']) . '" /></td></tr>';
	echo '<tr><td>Manager:</td><td>';
	dropdown_roster('manager', $mod['manager']);
	echo '</td></tr>';
	echo '<tr><td colspan="2"><div class="buttons"><input type="reset" /><input type="submit" value="Save Module" /></div></td></tr>';
	echo '</table></form>';
}

function admin_savemodule() {
	global $db;

	$result = $db->query('UPDATE modules SET name = ?, manager = ? WHERE id = ?', array($_POST['modulename'], $_POST['manager'], $_POST['module']));
	if ($result == DB_OK) {
		echo 'Module updated.';
	}
	else {
		echo $result->getMessage() . '<br /><br />Error updating module.';
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
	global $db;

	$result = $db->query('DELETE FROM modules WHERE id = ?', array($_POST['module']));
	if ($result == DB_OK) {
		$result = $db->query('DELETE FROM maintainers WHERE module = ?', array($_POST['module']));
		if ($result == DB_OK) {
			echo 'Deleted from modules and maintainers succesfully.<br />';
			$bugs = $db->getCol('SELECT id FROM bugs WHERE module = ?', 0, array($_POST['module']));
			$result = $db->query('DELETE FROM notes WHERE bugid IN (' . implode(', ', $bugs) . ')');
			if ($result == DB_OK) {
				echo 'Deleted from notes successfully.<br />';
			}
			else {
				echo $result->getMessage() . '<br /><br />Error deleting from notes.<br />';
			}
			$result = $db->query('DELETE FROM bugs WHERE module = ?', array($_POST['module']));
			if ($result == DB_OK) {
				echo 'Deleted from bugs successfully.<br />';
			}
			else {
				echo $result->getMessage() . '<br /><br />Error deleting from bugs.<br />';
			}
		}
		else {
			echo $result->getMessage() . '<br /><br />Error deleting from maintainers.<br />';
		}
	}
	else {
		echo $result->getMessage() . '<br /><br />Error deleting from modules.<br />';
	}
}

function admin_deletebug() {
	global $db;

	echo '<form name="deletebug" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/zapbug" />';
	echo 'Select the bug to delete: ';
	echo '<select size="1" name="bugid">';
	$bugs = $db->getAll('SELECT * FROM bugs ORDER BY id DESC');
	foreach ($bugs as $bug) {
		echo '<option value="' . $bug['id'] . '">' . $bug['id'] . ': ' . htmlspecialchars($bug['subject']) . '</option>';
	}
	echo '</select>';
	echo '<br /><br /><input type="submit" value="Delete Bug" /></form>';
}

function admin_zapbug() {
	global $db;

	$result = $db->query('DELETE FROM notes WHERE bugid = ?', array($_POST['bugid']));
	if ($result == DB_OK) {
		$result = $db->query('DELETE FROM bugs WHERE id = ?', array($_POST['bugid']));
		if ($result == DB_OK) {
			echo 'Delete successful.';
		}
		else {
			echo $result->getMessage() . '<br /><br />Error deleting bug.';
		}
	}
	else {
		echo $result->getMessage() . '<br /><br />Error deleting notes.';
	}
}

function admin_addcoder() {
	global $db;

	echo '<form name="addcoder" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/savecoder" />';
	echo '<table>';
	echo '<tr><td>Module:</td><td>';
	echo '<select name="module" size="1">';
	$modules = $db->getAll('SELECT * FROM modules WHERE id IN (' . implode(',', managed_modules()) . ') ORDER BY name ASC');
	foreach ($modules as $mod) {
		echo '<option value="' . $mod['id'] . '">' . htmlspecialchars($mod['name']) . '</option>';
	}
	echo '</select></td></tr>';
	echo '<tr><td>Coder:</td><td>';
	dropdown_roster('rosterid');
	echo '</td></tr>';
	echo '<tr><td colspan="2"><div class="buttons"><input type="reset" /><input type="submit" value="Add Coder" /></div></td></tr>';
	echo '</table></form>';
}

function admin_savecoder() {
	global $roster, $db;

	$result = $db->query('INSERT INTO maintainers (module, coder) VALUES (?, ?)', array($_POST['module'], $_POST['rosterid']));
	if ($result == DB_OK) {
		$coder = $roster->GetPerson($_POST['rosterid']);
		$module_name = $db->getOne('SELECT name FROM modules WHERE id = ?', array($_POST['module']));
		if ($coder && !($coder->Error())) {
			echo htmlspecialchars($coder->GetName()) . ' added as a coder to ' . $module_name . '.';
		}
		else {
			echo 'Coder added to ' . $module_name . ', but they have no roster record!';
		}
	}
	else {
		echo $result->getMessage() . '<br /><br />Error adding coder.';
	}
}

function admin_selectdeletecoder() {
	global $db;

	echo '<form name="deletecoder" method="get" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/deletecoder" />';
	echo 'Module to delete coder from: ';
	echo '<select name="module" size="1">';
	$modules = $db->getAll('SELECT * FROM modules WHERE id IN (' . implode(',', managed_modules()) . ') ORDER BY name ASC');
	foreach ($modules as $module) {
		echo '<option value="' . $module['id'] . '">' . htmlspecialchars($module['name']) . '</option>';
	}
	echo '</select><br /><br />';
	echo '<input type="submit" value="Select Module" />';
	echo '</form>';
}

function admin_deletecoder() {
	global $roster, $db;

	echo '<form name="deletecoder" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<input type="hidden" name="page" value="admin/zapcoder" />';
	echo '<input type="hidden" name="module" value="' . $_GET['module'] . '" />';
	echo 'Select coder to delete: ';
	echo '<select name="coder" size="1">';
	$coders = $db->getCol('SELECT coder FROM maintainers WHERE module = ?', 0, array($_GET['module']));
	foreach ($coders as $coder) {
		$code_monkey = $roster->GetPerson($coder);
		echo '<option value="' . $coder . '">' . htmlspecialchars($code_monkey->GetName()) . '</option>';
	}
	echo '</select><br /><br />';
	echo '<input type="submit" value="Delete Coder" />';
	echo '</form>';
}

function admin_zapcoder() {
	global $db;

	$result = $db->query('DELETE FROM maintainers WHERE module = ? AND coder = ?', array($_POST['module'], $_POST['coder']));
	if ($result == DB_OK) {
		echo 'Coder deleted.';
	}
	else {
		echo $result->getMessage() . '<br /><br />Error deleting coder.';
	}
}

function admin_stripslashes() {
	global $db;

	$bugs = $db->getAll('SELECT * FROM bugs');
	foreach ($bugs as $bug) {
		$result = $db->query('UPDATE bugs SET subject = ?, description = ? WHERE id = ?', array(stripslashes($bug['subject']), stripslashes($bug['description']), $bug['id']));
		if ($result == DB_OK) {
			echo 'Bug #'.$bug['id'].' updated successfully.<br />';
		}
		else {
			echo 'Error updating bug #'.$bug['id'].'.<br />';
		}
	}

	$modules = $db->getAll('SELECT * FROM modules');
	foreach ($modules as $module) {
		$result = $db->query('UPDATE modules SET name = ? WHERE id = ?', array(stripslashes($module['name']), $module['id']));
		if ($result == DB_OK) {
			echo 'Module #'.$module['id'].' updated successfully.<br />';
		}
		else {
			echo 'Error updating module #'.$module['id'].'.<br />';
		}
	}

	$notes = $db->getAll('SELECT * FROM notes');
	foreach ($notes as $note) {
		$result = $db->query('UPDATE notes SET note = ? WHERE id = ?', array(stripslashes($note['note']), $note['id']));
		if ($result == DB_OK) {
			echo 'Note #'.$note['id'].' updated successfully.<br />';
		}
		else {
			echo 'Error updating note #'.$note['id'].'.<br />';
		}
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
				case "stripslashes":
					if (is_admin()) admin_stripslashes();
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

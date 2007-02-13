<?php
$db = mysql_connect('localhost', 'thebhg', 'monkey69');
mysql_select_db('ircstats', $db);

ini_set('include_path', ini_get('include_path') . ':/var/www/html/include');
include('roster.inc');
$roster = new Roster();

class pleb {
	var $id;
	var $nicks;
	var $words;
	var $online;
}

function find_nick($plebs, $nick) {
	$nick = trim($nick);
	foreach ($plebs as $key=>$pleb) {
		if (in_array($nick, $pleb->nicks) && $pleb->online == true) return $key;
	}
	return -1;
}
?>

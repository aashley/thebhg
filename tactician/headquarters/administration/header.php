<?php

include_once('form.php');
include_once('table.php');

if (!function_exists('constructlayout')) {
	include_once('../../Layout.inc');
}

ini_set('include_path', ini_get('include_path') . ':/var/www/html/include');
include_once('roster.inc');

$db = mysql_connect('localhost', 'ka', 'habecrimes');
mysql_select_db('ka', $db);

$login = new Login_HTTP();

$GLOBALS['approve'] = false;

$roster = new Roster();

function hunter_dropdown($form, $exclude = array(0, 16), $select = false) {
	global $roster;

	$divisions = $roster->GetDivisions('name');
	foreach ($divisions as $div) {
		if (in_array($div->GetID(), $exclude)) {
			continue;
		}
		if ($div->GetMemberCount()) {
			$members = $div->GetMembers('name');
			foreach ($members as $pleb) {
				$form->addOption($pleb->getID(), htmlspecialchars($div->GetName() . ': ' . $pleb->GetName()));
			}
		}
	}
}

if ($login->getPosition()->GetID() == 3 || $login->getID() == 2650) {
	$GLOBALS['approve'] = true;
	$subarray = array(
		'Assistant Access'=>'headquarters/administration/assistant.php',
		'Edit Asst. Access'=>'headquarters/administration/edit.php',
		'Delete Assistant'=>'headquarters/administration/delete.php',
		'Post News'=>'headquarters/administration/news.php?op=new',
		'Edit News'=>'headquarters/administration/news.php?op=edit',
		'Delete News'=>'headquarters/administration/news.php?op=delete'
	);
}

function hr(){
	echo '<hr>';
}

function page_header($ltitle) {
	global $title;

	$title = $ltitle;
}

function page_footer() {
	global $title, $ka, $global_ka;

	$ka = $global_ka;
	$new_output = iconv('ISO-8859-1', 'UTF-8', ob_get_contents());
	ob_clean();
	echo $new_output;
	ConstructLayout(iconv('ISO-8859-1', 'UTF-8', $title), KABALS);
}

function add_menu($menu_array) {
	global $subarray;

	$subarray = array_merge(array('<b>Page Links</b>'=>'#'), $menu_array, array('<b>KG Links</b>'=>'#'), $subarray);
}

?>

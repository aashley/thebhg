<?php
define('VERSION', '1.1.1a');

ob_start();
header('Content-Type: text/html; charset=UTF-8');

include_once('roster.php');
include_once('auth.php');
include_once('util.php');
include_once('db.php');

include_once('classes/block.php');
include_once('classes/calendar.php');
include_once('classes/config.php');
include_once('classes/form.php');
include_once('classes/rss.php');
include_once('classes/timeline.php');
include_once('classes/weather.php');

include_once('classes/table.php');
include_once('classes/blocktable.php');

if (strpos($_SERVER['HTTP_HOST'], 'thebhg.org') !== false || strpos($_SERVER['HTTP_HOST'], 'bhg') !== false) {
	define('PARENT_DIR', '/');
}
else {
	define('PARENT_DIR', '/bhg/my/');
}

// Create the site config.
$config = new Config($db);

// Set the default values.
$themeConfig = $config->GetValue('theme');
$postConfig = $config->GetValue('posts');
$tzConfig = $config->GetValue('timezone');

$my_theme = $themeConfig->GetValue();
$my_posts = (int) $postConfig->GetValue();

// Check if the user is logged in, and if so, load some arrays up.
$my_weather = 'http://weather.interceptvector.com/weather.xml?id=QVNYWDAyMzQ%3D%%1';
if ($_COOKIE['mybhg_rid']) {
	$mu_result = mysql_query('SELECT * FROM prefs WHERE id=' . $_COOKIE['mybhg_rid'], $db);
	$mu_row = mysql_fetch_array($mu_result);
	if ($_COOKIE['mybhg_key'] == $mu_row['key']) {
		$my_user = $roster->GetPerson($_COOKIE['mybhg_rid']);
		if ($mu_row['timezone']) {
			$my_tz = stripslashes($mu_row['timezone']);
		}
		else {
			$my_tz = $tzConfig->GetValue();
		}
		putenv('TZ=' . $my_tz);
		if ($mu_row['blocks']) {
			$my_blocks = explode(',', $mu_row['blocks']);
		}
		else {
			$my_blocks = array();
		}
		if ($mu_row['sections']) {
			$my_sections = explode(',', $mu_row['sections']);
		}
		else {
			$my_sections = array();
		}
		if ($mu_row['weather']) {
			$my_weather = stripslashes($mu_row['weather']);
		}
		if ($mu_row['theme']) {
			$my_theme = stripslashes($mu_row['theme']);
		}
		if ($mu_row['posts']) {
			$my_posts = $mu_row['posts'];
		}
	}
	else {
		setcookie('mybhg_key');
		setcookie('mybhg_rid');
	}
}

// Load up the appropriate theme.
include_once('themes/theme.php');
$themes = get_themes();
$theme = $themes[$my_theme];

// Create a new calendar.
$calendar = new Calendar($db);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>MyBHG<?php if (isset($title)) echo ' :: ' . $title; ?></title>
<link rel="alternate" type="application/rss+xml" title="RSS Feed" href="/backend.php" />
<?php
if (!$theme->IECompliant()) {
?>
<!-- compliance patch for microsoft browsers -->
<!--[if lt IE 7]>
<script src="/themes/ie7/ie7-standard.js" type="text/javascript">
</script>
<![endif]-->
<?php
}
?>
<?php
if ($_GET['css']) {
	echo '<link rel="stylesheet" href="' . $_GET['css'] . '" />';
}

$themes = array();
foreach (get_themes() as $th) {
	$themes[$th->GetName()] = $th->GetStyleSheet();
}
ksort($themes);
unset($themes[$theme->GetName()]);
echo '<link rel="stylesheet" title="' . $theme->GetName() . '" href="' . $theme->GetStyleSheet() . '" />';
foreach ($themes as $name => $ss) {
	echo '<link rel="alternate stylesheet" title="' . $name . '" href="' . $ss . '" />';
}
?>
</head>
<body>
<?php
$items = array('news.php' => 'News', 'sections.php'=>'Sections', 'calendar.php'=>'Calendar', 'about.php'=>'About', 'search.php'=>'Search');
if (isset($my_user)) {
	$items['prefs.php'] = 'Preferences';
	$items['logout.php'] = 'Logout';
	if (lookup_auth_level($my_user) > 0) {
		$items['administration/index.php'] = 'Admin';
	}
}
else {
	$items['login.php'] = 'Login';
}
?>
<div id="header">
<div id="title"><?php if (isset($title)) echo $title; ?></div>
<div id="menu">
<ul>
<?php
	$first = true;
	foreach ($items as $url=>$name) {
		echo '<li';
		if ($first) {
			echo ' class="first">';
			$first = false;
		}
		else {
			echo '>';
		}
		echo '<a href="' . PARENT_DIR . $url . '">' . $name . '</a></li>';
	}
?>
</ul>
</div>
</div>
<div id="blocks">
<?php
if (empty($my_user) || (count($my_blocks) || $my_weather{0} != '-')) {
	if (empty($my_user) || count($my_blocks)) {
		$sql = 'SELECT id FROM blocks';
		if (isset($my_blocks)) {
			$sql .= ' WHERE id IN (' . implode(',', $my_blocks) . ')';
		}
		$sql .= ' ORDER BY weight';
		$block_result = mysql_query($sql, $db);
		if ($block_result && mysql_num_rows($block_result)) {
			while ($block_row = mysql_fetch_array($block_result)) {
				$block = get_block($block_row['id'], $db);
				echo '<div class="block"><div class="header">' . $block->GetTitle() . '</div>' . $block->GetHTML() . '</div>';
			}
		}
	}

/*	if ($my_weather{0} != '-') {
		$station = new Station($my_weather, $db);
		$table = new BlockTable();
		$table->StartRow();
		$table->AddHeader($station->GetName() . ' Weather');
		$table->EndRow();
		$table->AddRow($station->GetOutput() . (isset($my_user) ? '<br /><b><a href="' . PARENT_DIR . 'forecast.php">View Forecast</a></b><br /><b><a href="' . PARENT_DIR . 'weather.php">Change Settings</a></b>' : ''));
		$table->EndTable();
	}*/
}
?>
</div>
<div id="content">
<?php
if (strpos($_SERVER['HTTP_HOST'], 'my.thebhg.org') !== false) {
	$table = new BlockTable();
	$table->StartRow();
	$table->AddHeader('Important Note:');
	$table->AddCell('This site is a development version of the main BHG web site. It is extremely likely that you want to be at <a href="http://www.thebhg.org/">http://www.thebhg.org/</a> instead. This site may contain code that doesn\'t work as expected, prints reams of debugging output, or is just plain broken. You were warned.');
	$table->EndRow();
	$table->EndTable();
}
?>

<?php

include_once('header.php');

page_header('KAC Statistics');

$errors = Array();

if ($_REQUEST['flag']){
	$flag = $_REQUEST['flag'];
	$file_name = 'functions/'.$flag.'.inc';
	if (file_exists($file_name)){
		include_once $file_name;
	} else {
		$errors[] = 'Improper flag.';
	}
} else {
	$errors[] = 'Flag required.';
}

if (!function_exists('output')){
	$errors[] = 'Error loading required function. Ensure flag is are correct.';
} else {
	output();
}

if ($ka->Error()){
	$errors[] = $ka->Error();
}

if (count($errors)){
	hr();
	echo '<center><h5>Wanring. Errors Found.</h5></center>'.implode('<br />', $errors);
}

page_footer();

?>
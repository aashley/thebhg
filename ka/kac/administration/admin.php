<?php

include_once('header.php');

page_header('Administration');

$errors = Array();

if ($level == 3) {
	if ($_REQUEST['function']){
		$function = $_REQUEST['function'];
		if ($_REQUEST['flag']){
			$flag = $_REQUEST['flag'];
			$file_name = 'functions/'.$function.'-'.$flag.'.inc';
			if (file_exists($file_name)){
				include_once $file_name;
			} else {
				$file_name = 'functions/'.$function.'.inc';
				if (file_exists($file_name)){
					include_once $file_name;
				} else {
					$errors[] = 'Missing or improper function-flag combination.';
				}
			}
		} else {
			$errors[] = 'Flag required.';
		}
	} else {
		$errors[] = 'Function required.';
	} 
	
	if (!function_exists('output')){
		$errors[] = 'Error loading required function. Ensure flags and function are correct. Inform the Coders about this problem.';
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
} else {
	echo 'Access denied. Be gone with you, pesant.';
}

page_footer();

?>
<?php

//HEADER FUNCTIONS

$replacements = array();

$replace = new Shell(0, 'ams_replacements', 'date_deleted');

foreach ($replace->storage as $dump){
	if (class_exists($replace->GetValue('class'))){
		$class = new $replace->GetValue('class');
	}
	
	$replacements[$replace->GetValue('name')] = 0;
}

function Parse($text) {
global $replacements; 

  $search = array();

  $replace = array();

  foreach ($replacements as $rep => $wit) {

    array_push($search, $rep);
    array_push($replace, $wit);

  }

  $return = str_replace($search, $replace, $message);

  return $return;
  
}

function title(){
return 'Index';
}

function output(){
$shell = new Shell(1, 'ams_settings');

echo $shell->GetValue('text');
}

?>
<?php

function title(){
return 'Index';
}

function output(){
$shell = new Shell(1, 'ams_settings');

echo $shell->GetValue('text');
}

?>
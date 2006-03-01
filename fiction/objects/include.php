<?php

$include = array('fiction', 'article', 'form', 'table', 'library', 'compguide', 'compack', 'competition', 'book');

foreach ($include as $page){
	include_once $page.'.php';
}

?>
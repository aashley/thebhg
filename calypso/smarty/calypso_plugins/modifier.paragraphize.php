<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     lower
 * Purpose:  convert string to lowercase
 * -------------------------------------------------------------
 */
function smarty_modifier_paragraphize ($string)
{
	$output = "";
	$paragraph_array = preg_split ('/[\r\n]+/', $string);
	foreach ($paragraph_array as $paragraph)
		$output .= "<p>" . $paragraph . "</p>\r\n";
	return $output;
}

?>

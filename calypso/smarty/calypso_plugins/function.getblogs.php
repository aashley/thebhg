<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getblogs} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getblogs<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array of active blogs<br>
	 *
	 * Examples: {getblogs}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getblogs ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if ($params['assign'] == '')
			$params['assign'] = 'blogs';

		// Construct the query.
		$sql = sprintf (
			" SELECT                  " .
			"   blog_id               " .
			"     AS id,              " .
			"   blog_linktitle        " .
			"     AS linktitle,       " .
			"   blog_title            " .
			"     AS title,           " .
			"   blog_description      " . 
			"     AS description,     " .
			"   blog_person           " . 
			"     AS owner,           " .
			"   blog_default_comments " .
			"     AS enable_comments, " .
			"   CONCAT('%s',          " .
			"     blog_linktitle,'/') " .
			"     AS url              " .
			" FROM                    " .
			"   blogs                 " .
			" ORDER BY                " .
			"   blog_title ASC        " ,
			$system["home"]
		);

		// Query the database.
		$rows = $database->getAll ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $rows);
	}

?>

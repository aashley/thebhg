<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getblog} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getblog<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array of information describing a single blog<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *
	 * Examples: {getblog blogid=1}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getblog ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, create a default.
		if ($params['assign'] == '')
			$params['assign'] = 'blogs';

		// Require a blogid.
		if (empty ($params['blogid']))
			$smarty->trigger_error ('getblog: blogid is a required parameter');

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
			" WHERE                   " .
			"   %s                    " .
			" LIMIT 1                 " , 
			$system["home"],
			(is_numeric ($params['blogid']) ? "blog_id = {$params['blogid']}" : "blog_linktitle = '{$params['blogid']}'")
		);
		$row = $database->getRow ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $row); 
	}

?>

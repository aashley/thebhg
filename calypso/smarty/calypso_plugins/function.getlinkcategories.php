<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getlinkcategories} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getlinkcategories<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array of information describing a set of links categories<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *
	 * Examples: {getlinkcategories blogid=1}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getlinkcategories ($params, &$smarty) 
	{
		// Get variables from smarty.
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if (empty ($params['assign']))
			$params['assign'] = 'categories';

		if (empty ($params['blogid']))
			$smarty->trigger_error ('getlinkcategories: blogid is a required parameter');

		// Construct the query.
		$sql = sprintf (
			" SELECT                   " .
			"   link_categories.id,    " .
			"   link_categories.title  " .
			" FROM                     " .
			"   link_categories, blogs " .
			" WHERE                    " .
			"   blogs.blog_id = %s     " .
			" AND                      " .
			"   link_categories.person " .
			"     = blogs.blog_person  " .
			" ORDER BY                 " .
			"   link_categories.title  " . 
			"     ASC                  " ,
			$params['blogid']
		);

		// Query the database.
		$rows = $database->getAll ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $rows);        
	}

?>

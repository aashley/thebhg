<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getcategory} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getcategory<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array of information describing a single category<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - categoryid = the unique id of the category
	 *
	 * Examples: {getcategory blogid=1 categoryid=1}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getcategory ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, create a default.
		if ($params['assign'] == '')
			$params['assign'] = 'category';

		// Require a categoryid.
		if ($params['categoryid'] == '')
			$smarty->trigger_error ('getcategory: categoryid is a required parameter');

		// Require a blogid.
		if ($params['blogid'] == '')
			$smarty->trigger_error ('getcategory: blogid is a required parameter');

		// Construct the query.
		$sql = sprintf (
			" SELECT                              " .
			"   categories.category_id AS id,     " .
			"   categories.category_title         " .
			"     AS title,                       " .
			"   categories.category_titleword     " .
			"     AS linktitle,                   " .
			"   categories.category_description   " .
			"     AS description,                 " .
			"   CONCAT('%s',                      " .
			"     blogs.blog_linktitle, '/',      " .
			"     categories.category_titleword,  " . 
			"     '/') AS url                     " .
			" FROM                                " .
			"   categories, blogs                 " .
			" WHERE                               " .
			"   blogs.blog_id = %s                " .
			" AND                                 " .
			"   categories.%s                     " .
			" LIMIT 1                             " , 
			$system['home'],
			$params['blogid'],
			(is_numeric ($params['categoryid']) ? "category_id = {$params['categoryid']}" : "category_titleword = '{$params['categoryid']}'")
		);

		// Query the database.
		$row = $database->getRow ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $row);   
	}

?>

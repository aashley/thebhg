<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getcategories} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getcategories<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array of information describing a set of categories<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - entry = the unique id of an entry
	 *         - limit = maximum number of categories
	 *
	 * Examples: {getcategories blogid=1 limit=5}
	 *           {getcategories entryid=1 limit=5}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getcategories ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if ($params['assign'] == '')
			$params['assign'] = 'categories';

		if (empty ($params['blogid']) && empty ($params['entryid']))
			$smarty->trigger_error ('getcategories: blogid or entryid are required parameters');

		if (!empty ($params['entryid']))
		{
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
				"   categories, blogs, entry2category " .
				" WHERE                               " .
				"   entry2category.entry = %s         " .
				" AND                                 " .
				"   categories.category_id =          " .
				"     entry2category.category         " .
				" AND                                 " .
				"   blogs.blog_person =               " .
				"     categories.category_person      " .
				" ORDER BY                            " .
				"   categories.category_title ASC     " .
				"   %s                                " , 
				$system['home'],
				$params['entryid'],
				(!empty ($params['limit']) ? " LIMIT {$params['limit']}" : "")
			);
		} else {
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
				"   categories.category_person =      " .
				"     blogs.blog_person               " .
				" ORDER BY                            " .
				"   categories.category_title ASC     " .
				"   %s                                " , 
				$system['home'],
				$params['blogid'],
				(!empty ($params['limit']) ? " LIMIT {$params['limit']}" : "")
			);
		}

		// Query the database.
		$rows = $database->getAll ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $rows);        
	}

?>

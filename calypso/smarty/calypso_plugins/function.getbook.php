<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getbook} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getbooks<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return the books a blog is reading<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - isbn = the unique id of the book
	 *
	 * Examples: {getbook blogid=1 isbn=1}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getbook ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if (empty ($params['assign']))
			$params['assign'] = 'book';

		// Require a blogid.
		if (empty ($params['blogid']))
			$smarty->trigger_error ('getbook: blogid is a required parameter');

		if (empty ($params['isbn']))
			$smarty->trigger_error ('getbook: isbn is a required parameter');

		// Construct the query.
		$sql = sprintf (
			" SELECT                " .
			"   books.isbn,         " .
			"   books.small,        " .
			"   books.medium,       " .
			"   books.large,        " .
			"   books.title,        " .
			"   books.url,          " .
			"   books.authors,      " .
			"   books.completed     " .
			" FROM                  " .
			"   books, blogs        " .
			" WHERE                 " .
			"   blogs.blog_id = %s  " .
			" AND                   " .
			"   books.person =      " .
			"     blogs.blog_person " .
			" AND                   " .
			"   books.isbn = %s     " .
			" LIMIT 1               " ,
			$params['blogid'],
			$params['isbn']
		);

		$row = $database->getRow ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $row);  
	}

?>

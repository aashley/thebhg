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
	 * Name:     getbook<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return the book in our database<br>
	 * Input:<br>
	 *         - isbn = the unique id of the book
	 *
	 * Examples: {getbook isbn=1}
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

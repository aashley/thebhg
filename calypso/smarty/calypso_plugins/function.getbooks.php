<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getbooks} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getbooks<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return the books a blog is reading<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - status = 0=All,1=Incomplete,2=Completed
	 *         - limit = the maximum number of books
	 *
	 * Examples: {getbooks blogid=1 status=1 limit=5}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */zz
	function smarty_function_getbooks ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if (empty ($params['assign']))
			$params['assign'] = 'books';

		if (empty ($params['status']))
			$params['status'] = 0;

		// Require a blogid.
		if (empty ($params['blogid']))
			$smarty->trigger_error ('getbooks: blogid is a required parameter');

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
			" %s                    " .
			" %s                    " ,
			$params['blogid'],
			(($params['status'] != 0) ? " AND books.completed = " . ($params['status'] - 1) : ""),
			(!empty ($params['limit']) ? " LIMIT {$params['limit']}" : "")
		);
		$result = $database->query ($sql);

		$array = array ();
		while ($row = $result->fetchRow (DB_FETCHMODE_ASSOC))
		{
			if (!empty ($params['asarray']))
				$row["authors"] = split (", ", $row["authors"]);

			$array [] = $row;
		}

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $array);  
	}

?>

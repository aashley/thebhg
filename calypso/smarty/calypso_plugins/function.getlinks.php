<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getlinks} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getlinks<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array of information describing a set of links<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - blogid = the unique id of the category
	 *         - limit = maximum number of links
	 *
	 * Examples: {getlinks blogid=1 categoryid=1}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getlinks ($params, &$smarty) 
	{
		// Get variables from smarty.
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if (empty ($params['assign']))
			$params['assign'] = 'links';

		if (empty ($params['blogid']))
			$smarty->trigger_error ('getlinks: blogid is a required parameter');

		// Construct the query.
		$sql = sprintf (
			" SELECT                 " .
			"   links.link_id        " .
			"     AS id,             " .
			"   links.link_url       " .
			"     AS url,            " .
			"   links.link_title     " .
			"     AS title,          " .
			"   links.link_feed      " .
			"     AS feedurl,        " .
			"   links.link_icon      " .
			"     AS favicon         " .
			" FROM                   " .
			"   links, blogs         " .
			" WHERE                  " .
			"   blogs.blog_id = %s   " .
			" AND                    " .
			"   links.link_person =  " .
			"     blogs.blog_person  " .
			" %s                     " .
			" ORDER BY               " .
			"   links.link_title ASC " .
			" %s                     " , 
			$params['blogid'],
			(!empty ($params['categoryid']) ? " AND links.link_category = {$params['categoryid']} " : ""),
			(!empty ($params['limit']) ? " LIMIT {$params['limit']}" : "")
		);

		// Query the database.
		$rows = $database->getAll ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $rows);        
	}

?>

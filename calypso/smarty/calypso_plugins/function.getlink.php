<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getlink} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getlink<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array of information describing a set of links<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - linkid = the unique id of the link
	 *
	 * Examples: {getlink blogid=1 linkid=1}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getlink ($params, &$smarty) 
	{
		// Get variables from smarty.
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if (empty ($params['assign']))
			$params['assign'] = 'link';

		if (empty ($params['blogid']))
			$smarty->trigger_error ('getlink: blogid is a required parameter');

		if (empty ($params['linkid']))
			$smarty->trigger_error ('getlink: linkid is a required parameter');

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
			" AND                    " .
			"   links.link_id = %s   " .
			" LIMIT 1                " , 
			$params['blogid'],
			$params['linkid']
		);

		// Query the database.
		$row = $database->getRow ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $row);        
	}

?>

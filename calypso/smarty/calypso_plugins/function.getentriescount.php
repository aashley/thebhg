<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getentriescount} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getentriescount<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array of information describing a set of comments<br>
	 * Input:<br>
	 *         - categoryid = the unique id of the category
	 *
	 * Examples: {getentriescount categoryid=1}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getentriescount ($params, &$smarty) 
	{
		// Get variables from smarty.
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if ($params['assign'] == '')
			$params['assign'] = 'entries';

		if ($params['categoryid'] == '')
			$smarty->trigger_error ('getentriescount: categoryid is a required parameter');

		// Construct the query.
		$sql = sprintf (
			" SELECT             " .
			"   COUNT(*) as num  " .
			" FROM               " .
			"   entry2category   " .
			" WHERE              " .
			"   category = %s    " , 
			$params['categoryid']
		);

		// Query the database.
		$count = $database->getOne ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $count);        
	}

?>

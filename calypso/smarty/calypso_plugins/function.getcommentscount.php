<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getcommentscount} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getcommentscount<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array of information describing a set of comments<br>
	 * Input:<br>
	 *         - entryid = the unique id of the entry
	 *
	 * Examples: {getcommentscount entryid=1}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getcommentscount ($params, &$smarty) 
	{
		// Get variables from smarty.
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if ($params['assign'] == '')
			$params['assign'] = 'comments';

		if ($params['entryid'] == '')
			$smarty->trigger_error ('getcomments: entryid is a required parameter');

		// Construct the query.
		$sql = sprintf (
			" SELECT               " .
			"   COUNT(*) as num    " .
			" FROM                 " .
			"   comments           " .
			" WHERE                " .
			"   comment_entry = %s " , 
			$params['entryid']
		);

		// Query the database.
		$count = $database->getOne ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $count);        
	}

?>

<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getcomments} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getcomments<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array of information describing a set of comments<br>
	 * Input:<br>
	 *         - entryid = the unique id of the entry
	 *
	 * Examples: {getcomments entryid=1 limit=5}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getcomments ($params, &$smarty) 
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
			" SELECT                  " .
			"   comment_id            " .
			"     AS id,              " .
			"   comment_person        " .
			"     AS owner,           " .
			"   comment_timestamp     " .
			"     AS timestamp,       " .
			"   comment_message       " .
			"     AS content          " .
			" FROM                    " .
			"   comments              " .
			" WHERE                   " .
			"   comment_entry = %s    " .
			" ORDER BY                " .
			"   comment_timestamp ASC " .
			" %s                      " ,
			$params['entryid'],
			(!empty ($params['limit']) ? " LIMIT {$params['limit']}" : "")
		);

		// Query the database.
		$rows = $database->getAll ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $rows);        
	}

?>

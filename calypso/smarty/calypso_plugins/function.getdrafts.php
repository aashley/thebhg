<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getdrafts} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getdrafts<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return the entries in the given timeframe<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - limit = maximum number of drafts
	 *
	 * Examples: {getdrafts blogid=1 limit=5}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getdrafts ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if (empty ($params['assign']))
			$params['assign'] = 'entries';

		if (empty ($params['blogid']))	
			$smarty->trigger_error ('getdrafts: blogid is a required parameters');

		// Construct the query.
		$sql = sprintf (
			" SELECT                          " .
			"   entries.entry_id AS id,       " .
			"   entries.entry_timestamp       " .
			"     AS timestamp,               " .
			"   entries.entry_status          " .
			"     AS status,                  " .
			"   entries.entry_person          " .
			"     AS owner,                   " .
			"   entries.entry_title           " .
			"     AS title,                   " .
			"   entries.entry_message         " .
			"     AS content,                 " .
			"   entries.entry_allow_comments  " .
			"     AS show_comments,           " .
			"   CONCAT('%s',                  " .
			"     blogs.blog_linktitle,       " .
			"     DATE_FORMAT(                " .
			"       FROM_UNIXTIME(            " .
			"       entries.entry_timestamp), " .
			"       '/%%Y/%%m/%%d/'           " .
			"     ),                          " .
			"     entries.entry_titleword)    " .
			"     AS url,                     " .
			"   CONCAT('%s',                  " .
			"     blogs.blog_linktitle, '%s', " .
			"     DATE_FORMAT(                " .
			"       FROM_UNIXTIME(            " .
			"       entries.entry_timestamp), " .
			"       '/%%Y/%%m/%%d/'           " .
			"     ),                          " .
			"     entries.entry_titleword)    " .
			"     AS editurl                  " .
			" FROM entries, blogs             " .	
			" WHERE                           " .
			"   blogs.blog_id = %s            " .	
			" AND                             " .
			"   entries.entry_person =        " .
			"     blogs.blog_person           " .
			" AND                             " .
			"   entries.entry_status = 0      " .
			" ORDER BY                        " .
			"   entries.entry_timestamp DESC  " .
			" %s                              " ,
			$system['home'],
			$system['home'],
			"/admin",
			$params['blogid'],
			(!empty ($params['limit']) ? " LIMIT {$params['limit']}" : "")
		);

		// Query the database.
		$rows = $database->getAll ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $rows);  
}

?>

<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getrecententries} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getrecententries<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return the entries in the given timeframe<br>
	 * Input:<br>
	 *         - limit = a maximum number of entries to return
	 *
	 * Examples: {getrecententries limit=5}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getrecententries ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if (empty ($params['assign']))
			$params['assign'] = 'entries';

		if (empty ($params['limit']))
			$params['limit'] = 5;

		// Construct the query.
		$sql = sprintf (
			" SELECT                         " .
			"   entries.entry_id AS id,      " .
			"   entries.entry_timestamp      " .
			"     AS timestamp,              " .
			"   entries.entry_status         " .
			"     AS status,                 " .
			"   entries.entry_person         " .
			"     AS owner,                  " .
			"   entries.entry_title          " .
			"     AS title,                  " .
			"   entries.entry_message        " .
			"     AS content,                " .
			"   entries.entry_allow_comments " .
			"     AS show_comments,          " .
			"   blogs.blog_id AS blog,       " .
			"   CONCAT('%s',                 " .
			"     blogs.blog_linktitle,      " .
			"     DATE_FORMAT(               " .
			"       FROM_UNIXTIME(           " .
			"       entries.entry_timestamp)," .
			"       '/%%Y/%%m/%%d/'          " .
			"     ),                         " .
			"     entries.entry_titleword)   " .
			"     AS url                     " .
			" FROM entries, blogs            " .	
			" WHERE                          " .
			"   entries.entry_person =       " .
			"     blogs.blog_person          " .
			" AND                            " .
			"   entries.entry_status = 1     " .
			" ORDER BY                       " .
			"   entries.entry_timestamp DESC " .
			" LIMIT %s                       " ,
			$system['home'],
			$params['limit']
		);

		$rows = $database->getAll ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $rows);  
}

?>

<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getentries} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getentries<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return the entries in the given timeframe<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - year = the year the entries were posted in
	 *         - month = the month the entries were posted in
	 *         - day = the day the entries were posted on
	 *         - limit = a maximum number of entries to return
	 *
	 * Examples: {getentries blogid=1 year=2003 month=12 day=31 limit=5}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getentries ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if (empty ($params['assign']))
			$params['assign'] = 'entries';

		if (!empty ($params['categoryid']))
		{
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
				"   entries.entry_titleword       " .
				"     AS linktitle,               " .
				"   entries.entry_message         " .
				"     AS content,                 " .
				"   entries.entry_allow_comments  " .
				"     AS show_comments,           " .
				"   blogs.blog_linktitle          " .
				" FROM entries, blogs, categories " .	
				" WHERE                           " .
				"   entries.entry_category %s     " .	
				" AND                            " .
				"   entries.entry_status = 1     " .
				" AND                             " .
				"   categories.category_id = %s   " .
				" AND                             " .
				"   entries.entry_person =        " .
				"     categories.category_person  " .
				" AND                             " .
				"   blogs.blog_person =           " .
				"     categories.category_person  " .
				" ORDER BY                        " .
				"   entries.entry_timestamp DESC  " .
				" %s                              " ,
				(($params['categoryid'] == 0) ? "= 'a:1:{i:0;i:0;}'" : "LIKE '%\"{$params['categoryid']}\"%'"),
				$params['categoryid'],
				(!empty ($params['limit']) ? "LIMIT {$params['limit']}" : "")
			);
		} elseif (!empty ($params['blogid'])) {
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
				"   entries.entry_status = 1      " .
				" AND                             " .
				"   entries.entry_person =        " .
				"     blogs.blog_person           " .
				" %s                              " .
				" %s                              " .
				" %s                              " .
				" ORDER BY                        " .
				"   entries.entry_timestamp DESC  " .
				" %s                              " ,
				$system['home'],
				$system['home'],
				"/admin",
				$params['blogid'],
				(!empty ($params['year']) ? "AND YEAR(FROM_UNIXTIME(entries.entry_timestamp)) = {$params['year']}" : ""),
				(!empty ($params['month']) ? "AND MONTH(FROM_UNIXTIME(entries.entry_timestamp)) = {$params['month']}" : ""),
				(!empty ($params['day']) ? "AND DAYOFMONTH(FROM_UNIXTIME(entries.entry_timestamp)) = {$params['day']}" : ""),
				(!empty ($params['limit']) ? "LIMIT {$params['limit']}" : "")
			);
		} else
			$smarty->trigger_error ('getentries: blogid or categoryid are required parameters');

		// Query the database.
		$rows = $database->getAll ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $rows);  
}

?>

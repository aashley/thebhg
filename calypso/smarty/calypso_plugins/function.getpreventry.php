<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getpreventry} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getpreventry<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return the entry immediatly before the entry given<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - entryid = the unique id of the entry
	 *         - year = the year the entry was posted in
	 *         - month = the month the entry was posted in
	 *         - day = the day the entry was posted on
	 *
	 * Examples: {getpreventry blogid=1 year=2003 month=12 day=31}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getpreventry ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if (empty ($params['assign']))
			$params['assign'] = 'prev';

		// Require the blogid parameter.
		if (empty ($params['blogid']))
			$smarty->trigger_error ('getpreventry: blogid is a required parameter');

		if (!empty ($params['entryid']))
		{
			// Construct the query.
			$last_sql = sprintf (
				" SELECT            " .
				"   entry_timestamp " .
				" FROM              " . 
				"   entries         " .
				" WHERE             " .
				"   entry_id = %s   " .
				" LIMIT 1           " ,	
				$params['entryid']
			);
		} else {
			// Construct the query.
			$last_sql = sprintf (
				" SELECT                        " .
				"   entries.entry_timestamp     " .
				" FROM                          " .
				"   entries, blogs              " .
				" WHERE                         " .
				"   blogs.blog_id = %s          " .
				" AND                           " .
				"   entries.entry_person =      " .
				"     blogs.blog_person         " .
				" AND                           " .
				"   YEAR(FROM_UNIXTIME(entries.entry_timestamp)) = %s " .
				" %s                            " .
				" %s                            " .
				" ORDER BY                      " .
				"   entries.entry_timestamp ASC " .
				" LIMIT 1                       " ,
				$params['blogid'],
				$params['year'],
				(!empty ($params['month']) ? "AND MONTH(FROM_UNIXTIME(entries.entry_timestamp)) = {$params['month']}" : ""),
				(!empty ($params['day']) ? "AND DAYOFMONTH(FROM_UNIXTIME(entries.entry_timestamp)) = {$params['day']}" : "")
			);
		}

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
			"   blogs.blog_id = %s           " .
			" AND                            " .
			"   entries.entry_status = 1     " .
			" AND                            " .
			"   entries.entry_person =       " .
			"     blogs.blog_person          " .
			" AND                            " .
			"   entries.entry_timestamp < %s " .
			" AND                            " .
			"   entries.entry_status = 1     " .
			" ORDER BY                       " .
			"   entries.entry_timestamp DESC " .
			" LIMIT 1                        " ,
			$system['home'],
			$params['blogid'],
			$database->getOne ($last_sql)
		);

		// Query the database.
		$result = $database->query ($sql);

		// If there is no prev entry, abort
		if ($result->numRows () <= 0)
		{
			$smarty->assign ($params['assign'], false);
			return;
		}

		$row = $result->fetchRow (DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $row);   
	}

?>

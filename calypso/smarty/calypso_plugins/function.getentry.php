<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getentry} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getentry<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return a single entry with the given id<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - entryid = the unique id of the entry
	 *         - year = the year the entry was posted in
	 *         - month = the month the entry was posted in
	 *         - day = the day the entry was posted on
	 *
	 * Examples: {getentry blogid=1 entryid=1 year=2003 month=12 day=31}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getentry ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if (empty ($params['assign']))
			$params['assign'] = 'entry';

		if (empty ($params['blogid']))
			$smarty->trigger_error ('getentry: blogid is a required parameter');

		if (empty ($params['entryid']))
			$smarty->trigger_error ('getentry: entryid is a required parameter');

		if (is_numeric ($params['entryid']))
		{
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
				"     AS url,                    " .
				"   CONCAT('%s',                 " .
				"     blogs.blog_linktitle, '%s'," .
				"     DATE_FORMAT(               " .
				"       FROM_UNIXTIME(           " .
				"       entries.entry_timestamp)," .
				"       '/%%Y/%%m/%%d/'          " .
				"     ),                         " .
				"     entries.entry_titleword)   " .
				"     AS editurl                 " .
				" FROM entries, blogs            " .	
				" WHERE                          " .
				"   blogs.blog_id = %s           " .	
				" AND                            " .
				"   entries.entry_person =       " .
				"     blogs.blog_person          " .
				" AND                            " .
				"   entries.entry_id = %s        " .
				" LIMIT 1                        " ,
				$system['home'],
				$system['home'],
				"/admin",
				$params['blogid'],
				$params['entryid']
			);
		} else {
			if (empty ($params['year']))
				$smarty->trigger_error ('getentry: year is a required parameter');
	
			if (empty ($params['month']))
				$smarty->trigger_error ('getentry: month is a required parameter');
	
			if (empty ($params['day']))
				$smarty->trigger_error ('getentry: day is a required parameter');
	
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
				"     AS url,                    " .
				"   CONCAT('%s',                  " .
				"     blogs.blog_linktitle, '%s', " .
				"     DATE_FORMAT(                " .
				"       FROM_UNIXTIME(            " .
				"       entries.entry_timestamp), " .
				"       '/%%Y/%%m/%%d/'           " .
				"     ),                          " .
				"     entries.entry_titleword)    " .
				"     AS editurl                  " .
				" FROM entries, blogs            " .	
				" WHERE                          " .
				"   blogs.blog_id = %s           " .	
				" AND                            " .
				"   entries.entry_person =       " .
				"     blogs.blog_person          " .
				" AND                            " .
				"   entries.entry_titleword = '%s' " .
				" AND YEAR(FROM_UNIXTIME(entries.entry_timestamp)) = %s       " .
				" AND MONTH(FROM_UNIXTIME(entries.entry_timestamp)) = %s      " .
				" AND DAYOFMONTH(FROM_UNIXTIME(entries.entry_timestamp)) = %s " .
				" LIMIT 1                        " ,
				$system['home'],
				$system['home'],
				"/admin",
				$params['blogid'],
				$params['entryid'],
				$params['year'],
				$params['month'],
				$params['day']
			);
		}
		$row = $database->getRow ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $row);  
}

?>

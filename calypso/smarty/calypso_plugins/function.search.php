<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {search} function plugin
	 *
	 * Type:     function<br>
	 * Name:     search<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return the entries in the given timeframe<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - query = string to search for
	 *
	 * Examples: {search blogid=1 query="cheese"}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_search ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, default.
		if (empty ($params['assign']))
			$params['assign'] = 'entries';

		// Require the blogid parameter.
		if (empty ($params['blogid']))
			$smarty->trigger_error ('search: blogid is a required parameter');

		// Require the query parameter.
		if (empty ($params['query']))
			$smarty->trigger_error ('search: query is a required parameter');

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
			"   COUNT(*) AS comments          " .	
			" FROM entries, blogs, comments   " .	
			" WHERE                           " .
			"   MATCH (entries.entry_message) " .
			"   AGAINST ('%s')                " .
			" AND                             " .
			"   blogs.blog_id = %s            " .	
			" AND                             " .
			"   entries.entry_person =        " .
			"     blogs.blog_person           " .
			" AND                             " .
			"   comments.comment_entry =      " .
			"     entries.entry_id            " .
			" GROUP BY                        " .
			"   comments.comment_entry        " .
			" ORDER BY                        " .
			"   entries.entry_timestamp DESC  " ,
			$system['home'],
			$params['query'],
			$params['blogid']
		);
		$rows = $database->getAll ($sql, DB_FETCHMODE_ASSOC);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $rows);  
}

?>

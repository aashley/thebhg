<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getarchives} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getarchives<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array of information describing a set of archives<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - limit = a maximum number of archives to return
	 *
	 * Examples: {getarchives blogid=1 limit=5}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getarchives ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');
			
		// If an output variable name is not set, use default.
		if ($params['assign'] == '')
			$params['assign'] = 'archives';

		// If a limit is not set, use default.
		if ($params['limit'] == '')
			$params['limit'] = '5';

		// Require the blogid parameter.
		if ($params['blogid'] == '')
			$smarty->trigger_error ('getarchives: blogid is a required parameter');

		// Construct the query.
		$sql = sprintf (
			" SELECT                     " .
			"   entries.entry_timestamp, " .
			"   blogs.blog_linktitle     " .
			" FROM                       " .
			"   entries, blogs           " .
			" WHERE                      " .
			"   blogs.blog_id = %s       " .
			" AND                        " .
			"   entries.entry_person =   " .
			"     blogs.blog_person      " .
			" AND                        " .
			"   entries.entry_status = 1 " .
			" ORDER BY                   " .
			"   entries.entry_timestamp  " .
			"     ASC                    " .
			" LIMIT 1                    " , 
			$params['blogid']
		);

		// Query the database.
		$result = $database->query ($sql);

		if ($result->numRows() <= 0)
			$first_post = time ();
		else
			$first_post = $row ["entry_timestamp"];

		$row = $result->fetchRow (DB_FETCHMODE_ASSOC);

		// Create an empty array.
		$array = array ();

		// Loop until the limited number of months.
		for ($i = 0; $i < $params['limit']; $i++) 
		{
			$timestamp = strtotime ("-" . $i . " months");
			if ($timestamp > $first_post) 
			{
				$array [] = array (
					"url"   => $system["home"] . $row ["blog_linktitle"] . date("/Y/m/", $timestamp),
					"title" => date ("F Y", $timestamp)
				);
			}
		}

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $array);        
	}

?>

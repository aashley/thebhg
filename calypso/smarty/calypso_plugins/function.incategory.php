<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {incategory} function plugin
	 *
	 * Type:     function<br>
	 * Name:     incategory<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array of information describing a single category<br>
	 * Input:<br>
	 *         - entryid = the unique id of the entry
	 *         - categoryid = the unique id of the category
	 *
	 * Examples: {incategory entryid=1 categoryid=1}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_incategory ($params, &$smarty) 
	{
		// Get variables from smarty.
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, create a default.
		if (empty ($params['assign']))
			$params['assign'] = 'incategory';

		// Require a categoryid.
		if (empty ($params['categoryid']))
			$smarty->trigger_error ('incategory: categoryid is a required parameter');

		// Require a entryid.
		if (empty ($params['entryid']))
			$smarty->trigger_error ('incategory: entryid is a required parameter');

		// Construct the query.
		$sql = sprintf (
			" SELECT            " .
			"   COUNT(*) AS num " .
			" FROM              " .
			"   entry2category  " .
			" WHERE             " .
			"   entry = %s      " .
			" AND               " .
			"   category = %s   " ,
			$params['entryid'],
			$params['categoryid']
		);

		// Query the database.
		$row = $database->getOne ($sql);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], ($row > 0));   
	}

?>

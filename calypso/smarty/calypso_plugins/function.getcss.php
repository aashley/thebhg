<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getcss} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getcss<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return the style sheet<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *
	 * Examples: {getcss blogid=1}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getcss ($params, &$smarty) 
	{
		// Get variables from smarty.
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, create a default.
		if ($params['assign'] == '')
			$params['assign'] = 'css';

		// Require a blogid.
		if (!empty ($params['blogid']))
		{
			// Construct the query.
			$sql = sprintf (
				" SELECT                 " .
				"   styles.style_content " .
				" FROM                   " .
				"   styles, blogs        " .
				" WHERE                  " .
				"   blogs.blog_id = %s   " .
				" AND                    " .
				"   styles.style_id =    " .
				"     blogs.blog_style   " , 
				$params['blogid']
			);
		} else {
			// Construct the query.
			$sql = sprintf (
				" SELECT          " .
				"   style_content " .
				" FROM            " .
				"   styles        " .
				" WHERE           " .
				"   style_id = 8  "
			);
		}

		// Query the database.
		$style = $database->getOne ($sql);

		// Send the generated array to smarty.
		$smarty->assign ($params['assign'], $style);   
	}

?>

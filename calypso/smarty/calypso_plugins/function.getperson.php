<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {getperson} function plugin
	 *
	 * Type:     function<br>
	 * Name:     getperson<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  return an array describing a person<br>
	 * Input:<br>
	 *         - personid = the unique id of the person
	 *
	 * Examples: {getperson personid=1}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_getperson ($params, &$smarty) 
	{
		// Get variables from smarty.
		$database = $smarty->get_template_vars ('database');

		// If an output variable name is not set, create a default.
		if ($params['assign'] == '')
			$params['assign'] = 'person';

		// Include the Roster objects into this script.
		require_once ('roster.inc');
		$roster = new Roster;

		// If we have a person, use it. Otherwise, login.
		if (!empty ($params['personid']))
			$person = new Person ($params['personid']);
		else
			$person = new Login_HTTP ();

		// Construct the query.
		$sql = sprintf (
			" SELECT             " .
			"   blog_id          " .
			" FROM               " .
			"   blogs            " .
			" WHERE              " .
			"   blog_person = %s " .
			" LIMIT 1            " , 
			$person->GetID ()
		);

		$array = array (
			'id'    => $person->GetID (),
			'name'  => $person->GetName (),
			'email' => $person->GetEmail (),
			'blog'	=> $database->getOne ($sql),
			'foaf'  => 'http://holonet.thebhg.org/roster/foaf/person.php?id=' . $person->GetID ()
		);

		// Rreturn the information in an array.
		$smarty->assign ($params['assign'], $array);  
	}

?>

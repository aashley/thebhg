<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	/**
	 * Smarty {ping} function plugin
	 *
	 * Type:     function<br>
	 * Name:     ping<br>
	 * Date:     Dec 31, 2003<br>
	 * Purpose:  Tell the website of our choosing that we have an update<br>
	 * Input:<br>
	 *         - blogid = the unique id of the blog
	 *         - recipient = (1 = Weblogs.com, 2 = Blo.gs)
	 *
	 * Examples: {ping blogid=1 recipient=1}
	 * @author   Thomas Reynolds <Thomas.Reynolds@asu.edu>
	 * @param array
	 * @param Smarty
	 * @return array
	 */
	function smarty_function_ping ($params, &$smarty) 
	{
		// Get variables from smarty.
		$system   = $smarty->get_template_vars ('system');
		$database = $smarty->get_template_vars ('database');

		// Require a blogid.
		if (empty ($params['blogid']))
			$smarty->trigger_error ('ping: blogid is a required parameter');

		// Require a blogid.
		if (empty ($params['recipient']))
			$smarty->trigger_error ('ping: recipient is a required parameter');

		// Construct the query.
		$sql = sprintf (
			" SELECT            " .
			"   blog_linktitle  " .
			"     AS linktitle, " .
			"   blog_title      " .
			"     AS title,     " .
			" FROM              " .
			"   blogs           " .
			" WHERE             " .
			"   blog_id = %s    " .
			" LIMIT 1           " , 
			$params['blogid']
		);
		$row = $database->getRow ($sql, DB_FETCHMODE_ASSOC);
		$row["url"] = $system["home"] . $row["linktitle"] . "/";
		$row["rdf"] = $row["url"] . "index.rdf";

		// Grab the PEAR library code.
		require_once ('XML/RPC.php');

		// Create an array w/ our parameters.
		$params = array (
			new XML_RPC_Value ($row["title"], "string"),
			new XML_RPC_Value ($row["url"],   "string"),
			new XML_RPC_Value ($row["url"],   "string"),
			new XML_RPC_Value ($row["rdf"],   "string")
		);

		// Route the ping to wherever we chose.
		switch ($params['recipient'])
		{
			case 1:
				$message = new XML_RPC_Message ("weblogUpdates.ping",
								array_slice ($params, 0, 2));
				$client = new XML_RPC_Client ("/RPC2", "rpc.weblogs.com", 80);
				break;
			case 2:
				$message = new XML_RPC_Message ("weblogUpdates.extendedPing", $params);
				$client = new XML_RPC_Client ("/", "ping.blo.gs", 80);
				break;
		}

		// Send the XML.
		$response = $client->send ($message);
	}

?>

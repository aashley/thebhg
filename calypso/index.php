<?php

	// Get the config settings.
	require_once ('calypso.conf');

	// Get the admin functions
	require_once ('libraries/calypso_admin.php');

	// Create the Database
	require_once ("DB.php");
	$dbh = DB::connect ($database);

	ini_set ('magic_quotes_gpc', FALSE);

	// Include the Smarty library
	$smarty_path = $system ["base"] . '/smarty';
	ini_set ("include_path", 
		ini_get ("include_path") . ":" . 
		$system ["base"] . "/libraries:" .
		$smarty_path
	);
	require_once ('Smarty.class.php');

	// Setup Smarty
	$smarty = new Smarty;
	$smarty->force_compile = true;
	$smarty->caching       = false;
	$smarty->compile_check = false;
	$smarty->compile_dir   = $smarty_path . '/compiled';
	$smarty->cache_dir     = $smarty_path . '/cache';
	$smarty->template_dir  = array (
		$system ["base"] . '/templates/general',
		$system ["base"] . '/templates/administration'
	);
	$smarty->plugins_dir   = array (
		"calypso_plugins", 
		"core", 
		"plugins"
	);

	// Attach these bad boys to smarty.
	$smarty->assign ('system',   $system);
	$smarty->assign ('database', $dbh);

	switch ($_REQUEST["route"]) 
	{
		default:
			$smarty->display ('frontpage.html');
        		break;
		case 1:
			$smarty->display ('blog_frontpage.html', 
					  'blog:{$_REQUEST["blogid"]}');
        		break;
		case 7:
			$smarty->display ('blog_search.html', 
					  'blog:{$_REQUEST["blogid"]}');
			break;
		case 12:
			$smarty->display ('archive_by_entry.html',
					  'blog:{$_REQUEST["blogid"]},entry:{$_REQUEST["entryid"]}');
			break;
		case 8:
			$smarty->display ('archive_by_day.html', 
					  'blog:{$_REQUEST["blogid"]},year:{$_REQUEST["year"]},month:{$_REQUEST["month"]},day:{$_REQUEST["day"]}');
			break;
		case 13:
			$smarty->display ('archive_by_month.html', 
					  'blog:{$_REQUEST["blogid"]},year:{$_REQUEST["year"]},month:{$_REQUEST["month"]}');
			break;
		case 9:
			$smarty->display ('archive_by_year.html', 
					  'blog:{$_REQUEST["blogid"]},year:{$_REQUEST["year"]}');
			break;
		case 2:
			$smarty->display ('archive_by_category.html', 
					  'blog:{$_REQUEST["blogid"]},category:{$_REQUEST["category"]}');
			break;
		case 31:
			$smarty->display ('list_categories.html', 
					  'blog:{$_REQUEST["blogid"]}');
			break;
		case 6:
	 		header ("Content-Type: text/css");
			$smarty->display ('display_style_sheet.html', 
					  'blog:{$_REQUEST["blogid"]}');
			break;
		case 27:
			header ("Content-Type: text/xml");
			$smarty->display ('syndicate_links.html', 
					  'blog:{$_REQUEST["blogid"]}');
			break;
		case 28:
			header ("Content-Type: text/xml");

			$xml = "http://allconsuming.net/rest.cgi?action=GetCurrentlyReadingList&username=JediJawa";
     		$xsl = $system ["home"] . "xsl/allconsuming-to-foaf.xsl";
			echo xslt_trans_w3 ($xml, $xsl);

			break;
		case 22:
			header ("Content-Type: text/xml");
			$smarty->display ('admin_syndicate_opml.html');
			break;
		case 23:
			header ("Content-Type: text/xml");
			$smarty->display ('admin_syndicate_foaf.html');
			break;
		case 19:
			$smarty->display ('entries_list.html');
			break;
		case 15:
			require_once ('roster.inc');
			$roster = new Roster;
			$person = new Login_HTTP ();
			$smarty->assign ('personid', $person->GetID());  
			if (isset ($_POST ["SaveDraft"])) 
			{
				calypso_create_entry ($_POST ["person"], $_POST ["title_entry"], $_POST ["content_entry"], $_POST ["category_boxes"], 0, (isset ($_POST ["pingback_box"]) ? 1 : 0), (isset ($_POST ["comments_box"]) ? 1 : 0));
				$smarty->display ('entry_create_success.html');
			} elseif (isset ($_POST ["Publish"])) 
			{
				calypso_create_entry ($_POST ["person"], $_POST ["title_entry"], $_POST ["content_entry"], $_POST ["category_boxes"], 1, (isset ($_POST ["pingback_box"]) ? 1 : 0), (isset ($_POST ["comments_box"]) ? 1 : 0));
				$smarty->display ('entry_create_success.html');
			} else 
				$smarty->display ('entry_create.html');
			break;
		case 20:
			if (isset ($_POST ["SaveDraft"])) 
			{
				calypso_modify_entry ($_POST ["person"], $_POST ["entry"], $_POST ["title_entry"], $_POST ["content_entry"], $_POST ["category_boxes"], 0, (isset ($_POST ["pingback_box"]) ? 1 : 0), (isset ($_POST ["comments_box"]) ? 1 : 0));
				$smarty->display ('entry_create_success.html');
			} elseif (isset ($_POST ["Publish"])) 
			{
				calypso_modify_entry ($_POST ["person"], $_POST ["entry"], $_POST ["title_entry"], $_POST ["content_entry"], $_POST ["category_boxes"], 1, (isset ($_POST ["pingback_box"]) ? 1 : 0), (isset ($_POST ["comments_box"]) ? 1 : 0));
				$smarty->display ('entry_create_success.html');
 			} elseif (isset ($_POST ["Delete"])) 
			{
				calypso_delete_entry ($_POST ["person"], $_POST ["entry"]);
				$smarty->display ('entries_list.html');
			} else
				$smarty->display ('entry_edit.html');
			break;
		case 17:
			if (isset ($_POST ["Delete"]))
				calypso_delete_category ($_POST ["person"], $_POST ["category"]);
			elseif (isset ($_POST ["Create"]))
				calypso_create_category ($_POST ["person"], $_POST ["title"], $_POST ["description"]);

			$smarty->display ('categories_list.html');
			break;
		case 27:
			if (isset ($_POST ["Delete"]))
				calypso_delete_link ($_POST ["person"], $_POST ["link"]);
			elseif (isset ($_POST ["Create"]))
				calypso_create_link ($_POST ["person"], $_POST ["title"], $_POST ["url"]);

			$smarty->display ('links_list.html');
			break;
		case 26:
			if (isset ($_POST ["Completed"]))
				calypso_completed_book ($_POST ["person"], $_POST ["isbn"], 1);
			elseif (isset ($_POST ["Uncompleted"]))
				calypso_completed_book ($_POST ["person"], $_POST ["isbn"], 0);
			elseif (isset ($_POST ["Delete"]))
				calypso_delete_book ($_POST ["person"], $_POST ["isbn"]);
			elseif (isset ($_POST ["Update"]))
				calypso_update_book ($_POST ["person"], $_POST ["isbn"]);
			elseif (isset ($_POST ["Create"]))
				calypso_create_book ($_POST ["person"], $_POST ["isbn"]);
			
			$smarty->display ('books_list.html');
			break;
		case 35:
			if (isset ($_POST ["Update"]))
				calypso_update_options ($_POST ["person"], $_POST ["title"], $_POST ["description"], $_POST ["icbm"], $_POST ["allconsuming"]);
			
			$smarty->display ('options.html');
			break;

	// Calypso RSS 1.0 and 2.0 feeds.
		case 24:
			header ("Content-Type: application/rss+xml");

			$xml = substr ($system ["home"], 0, -1) . str_replace ("rss10.xml", "atom03.xml", $_SERVER ["REQUEST_URI"]);
     		$xsl = $system ["home"] . "xsl/atom03-to-rss10.xsl";
			echo xslt_trans_w3 ($xml, $xsl);

			break;
		case 34:
			header ("Content-Type: application/rss+xml");

			$xml = substr ($system ["home"], 0, -1) . str_replace ("rss20.xml", "atom03.xml", $_SERVER ["REQUEST_URI"]);
     		$xsl = $system ["home"] . "xsl/atom03-to-rss20.xsl";
			echo xslt_trans_w3 ($xml, $xsl);

			break;
		case 25:
			header ("Content-Type: application/atom+xml");
			$smarty->display ('admin_syndicate_atom.html');
			break;

	// Per-blog RSS 1.0 and 2.0 feeds.
		case 5:
			header ("Content-Type: application/rss+xml");

			$xml = substr ($system ["home"], 0, -1) . str_replace ("rss10.xml", "atom03.xml", $_SERVER ["REQUEST_URI"]);
     		$xsl = $system ["home"] . "xsl/atom03-to-rss10.xsl";
			echo xslt_trans_w3 ($xml, $xsl);

			break;
		case 32:
			header ("Content-Type: application/rss+xml");

			$xml = substr ($system ["home"], 0, -1) . str_replace ("rss20.xml", "atom03.xml", $_SERVER ["REQUEST_URI"]);
     		$xsl = $system ["home"] . "xsl/atom03-to-rss20.xsl";
			echo xslt_trans_w3 ($xml, $xsl);

			break;
		case 21:
			header ("Content-Type: application/atom+xml");
			$smarty->display ('syndicate_atom03.html', 
					  'blog:{$_REQUEST["blogid"]}');
			break;

	// Per-category RSS 1.0 and 2.0 feeds.
		case 29:
			header ("Content-Type: application/rss+xml");

			$xml = substr ($system ["home"], 0, -1) . str_replace ("rss10.xml", "atom03.xml", $_SERVER ["REQUEST_URI"]);
     		$xsl = $system ["home"] . "xsl/atom03-to-rss10.xsl";
			echo xslt_trans_w3 ($xml, $xsl);

			break;
		case 33:
			header ("Content-Type: application/rss+xml");

			$xml = substr ($system ["home"], 0, -1) . str_replace ("rss20.xml", "atom03.xml", $_SERVER ["REQUEST_URI"]);
     		$xsl = $system ["home"] . "xsl/atom03-to-rss20.xsl";
			echo xslt_trans_w3 ($xml, $xsl);

			break;
		case 30:
			header ("Content-Type: application/atom+xml");
			$smarty->display ('syndicate_category_atom.html',
					  'blog:{$_REQUEST["blogid"]},category:{$_REQUEST["category"]}');
			break;

		case 36:
			header ("Content-Type: application/rsd+xml");
			$smarty->display ('syndicate_rsd.html',
					  'blog:{$_REQUEST["blogid"]}');
			break;

	// XML-RPC Server
		case 11:
			require_once ('libraries/server-xmlrpc.php');
			break;
	}

?>

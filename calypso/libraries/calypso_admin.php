<?php

	function getmicrotime ()
	{  
		list ($usec, $sec) = explode(' ', microtime());  
		return ((float) $usec + (float) $sec);  
	}

	function xslt_trans_w3 ($xmlfile, $xslfile) 
	{
		$rfile = sprintf (
			"http://www.w3.org/2000/06/webdata/xslt?xslfile=%s&xmlfile=%s",
			$xslfile,
			$xmlfile
		);

		return include_once ($rfile);
	}


	function calypso_linktitle ($string)
	{
		return preg_replace ("/[^\w\d]/", "", ucwords ($string));
	}

	function calypso_create_entry ($person, $title, $content, $categories, $status = 0, $pingback = 0, $comments = 0)
	{
		global $smarty;
		$database = $smarty->get_template_vars ('database');

		$sql = sprintf (
			" INSERT INTO                " . 
			"   entries (                " . 
			"     entry_timestamp,       " . 
			"     entry_status,          " . 
			"     entry_person,          " . 
			"     entry_title,           " . 
			"     entry_titleword,       " .
			"     entry_message,         " . 
			"     entry_allow_comments   " .
			"   ) values (               " . 
			"     UNIX_TIMESTAMP(NOW()), " . 
			"     %s,                    " . 
			"     %s,                    " . 
			"     %s,                    " .
			"     %s,                    " .
			"     %s,                    " .
			"     %s                     " .
			"   )                        " , 
			$status,
			$person,
			DB_Common::quote ($title),
			DB_Common::quote (calypso_linktitle ($title)),
			DB_Common::quote ($content),
			$comments
		);
		$database->query ($sql);

		// FIXME: MYSQL-only func
		$entry = @mysql_insert_id ($database->connection);

		if (!empty ($categories))
		{ 
			foreach ($categories as $cat_id)
			{
				$cat_sql = sprintf (
					" INSERT INTO         " . 
					"    entry2category ( " . 
					"     entry,          " . 
					"     category        " . 
					"   ) values (        " . 
					"     %s,             " .
					"     %s              " .
					"   )                 " , 
					$entry,
					$cat_id
				);
				$database->query ($cat_sql);
			}
		}

		$smarty->assign ('entryid', $entry);     
	}

	function calypso_modify_entry ($person, $entry, $title, $content, $categories, $status = 0, $pingback = 0, $comments = 0)
	{
		global $smarty;
		$database = $smarty->get_template_vars ('database');

		$sql = sprintf (
			" UPDATE                      " . 
			"   entries                   " .
			" SET                         " . 
			"   entry_status = %s,        " . 
			"   entry_title = %s,         " . 
			"   entry_titleword = %s,     " .
			"   entry_message = %s,       " . 
			"   entry_allow_comments = %s " .
			" WHERE                       " .
			"   entry_id = %s             " . 
			" AND                         " . 
			"   entry_person = %s         " , 
			$status,
			DB_Common::quote ($title),
			DB_Common::quote (calypso_linktitle ($title)),
			DB_Common::quote ($content),
			$comments,
			$entry,
			$person
		);
		$database->query ($sql);

		$delete_sql = sprintf (
			" DELETE FROM      " . 
			"   entry2category " .
			" WHERE            " .
			"   entry = %s     " ,
			$entry
		);
		$database->query ($delete_sql);

		foreach ($categories as $cat_id)
		{
			$cat_sql = sprintf (
				" INSERT INTO         " . 
				"    entry2category ( " . 
				"     entry,          " . 
				"     category        " . 
				"   ) values (        " . 
				"     %s,             " .
				"     %s              " .
				"   )                 " , 
				$entry,
				$cat_id
			);
			$database->query ($cat_sql);
		}
	}

	function calypso_delete_entry ($person, $entry)
	{
		global $smarty;
		$database = $smarty->get_template_vars ('database');

		$sql = sprintf (
			" DELETE FROM         " . 
			"   entries           " .
			" WHERE               " .
			"   entry_id = %s     " . 
			" AND                 " . 
			"   entry_person = %s " , 
			$entry,
			$person
		);
		$database->query ($sql);

		$delete_sql = sprintf (
			" DELETE FROM      " . 
			"   entry2category " .
			" WHERE            " .
			"   entry = %s     " ,
			$entry
		);
		$database->query ($delete_sql);
	}

	function calypso_create_category ($person, $title, $description)
	{
		global $smarty;
		$database = $smarty->get_template_vars ('database');

		$sql = sprintf (
			" INSERT INTO              " . 
			"   categories (           " . 
			"     category_person,     " .
			"     category_title,      " .
			"     category_titleword,  " .
			"     category_description " .
			"   ) VALUES (             " .
			"     %s,                  " .
			"     %s,                  " .
			"     %s,                  " .
			"     %s                   " .
			"   )                      " ,
			$person,
			DB_Common::quote ($title),
			DB_Common::quote (calypso_linktitle ($title)),
			DB_Common::quote ($description)
		);
		$database->query ($sql);
	}

	function calypso_delete_category ($person, $category)
	{
		global $smarty;
		$database = $smarty->get_template_vars ('database');

		$sql = sprintf (
			" DELETE FROM            " . 
			"   categories           " . 
			" WHERE                  " . 
			"   category_id = %s     " . 
			" AND                    " .
			"   category_person = %s " .
			" LIMIT 1                " ,
			$category,
			$person
		);
		$database->query ($sql);
	}

	function calypso_create_book ($person, $isbn)
	{
		global $smarty;
		$database = $smarty->get_template_vars ('database');

		//if (!valid_isbn ($isbn))
		//	return false;

		require_once ('Snoopy.class.php');
		require_once ('AmazonProduct.class.php');
		require_once ('AmazonSearchEngine.class.php');

		$se = new AmazonSearchEngine ();

		$se->searchIsbn ($isbn);
		$result = $se->results [0];

		if (!$result->Asin)
			return false;

		$sql = sprintf (
			" INSERT INTO    " . 
			"   books        " .
			" SET            " . 
			"   person = %s, " .
			"   isbn = %s,   " .
			"   small = %s,  " .
			"   medium = %s, " .
			"   large = %s,  " .
			"   title = %s,  " .
			"   url = %s,    " .
			"   authors = %s " , 
			$person,
			DB_Common::quote ($result->Asin),
			DB_Common::quote ($result->ImageUrlSmall),
			DB_Common::quote ($result->ImageUrlMedium),
			DB_Common::quote ($result->ImageUrlLarge),
			DB_Common::quote ($result->ProductName),
			DB_Common::quote ($result->url),
			DB_Common::quote (implode(', ', $result->Authors))
		);
		$database->query ($sql);
	}

	function calypso_update_book ($person, $isbn)
	{
		global $smarty;
		$database = $smarty->get_template_vars ('database');

		//if (!valid_isbn ($isbn))
		//	return false;

		require_once ('Snoopy.class.php');
		require_once ('AmazonProduct.class.php');
		require_once ('AmazonSearchEngine.class.php');

		$se = new AmazonSearchEngine ();

		$se->searchIsbn ($isbn);
		$result = $se->results [0];

		$sql = sprintf (
			" UPDATE         " . 
			"   books        " .
			" SET            " . 
			"   small = %s,  " .
			"   medium = %s, " .
			"   large = %s,  " .
			"   title = %s,  " .
			"   url = %s,    " .
			"   authors = %s " .
			" WHERE          " .
			"   isbn = %s    " .
			" AND            " .
			"   person = %s  " ,
			DB_Common::quote ($result->ImageUrlSmall),
			DB_Common::quote ($result->ImageUrlMedium),
			DB_Common::quote ($result->ImageUrlLarge),
			DB_Common::quote ($result->ProductName),
			DB_Common::quote ($result->url),
			DB_Common::quote (implode(', ', $result->Authors)),
			$isbn,
			$person
		);
		$database->query ($sql);
	}

	function calypso_completed_book ($person, $isbn, $completed)
	{
		global $smarty;
		$database = $smarty->get_template_vars ('database');

		$sql = sprintf (
			" UPDATE           " . 
			"   books          " .
			" SET              " . 
			"   completed = %s " .
			" WHERE            " .
			"   isbn = %s      " .
			" AND              " .
			"   person = %s    " ,
			$completed,
			$isbn,
			$person
		);
		$database->query ($sql);
	}

	function calypso_delete_book ($person, $isbn)
	{
		global $smarty;
		$database = $smarty->get_template_vars ('database');

		$sql = sprintf (
			" DELETE FROM   " . 
			"   books       " . 
			" WHERE         " . 
			"   person = %s " . 
			" AND           " .
			"   isbn = '%s' " .
			" LIMIT 1       " , 
			$person,
			$isbn
		);
		$database->query ($sql);
	}

	/**
	* Validate a ISBN number
	*
	* This function checks given number according
	*
	* @param  string  $isbn number (only numeric chars will be considered)
	* @return bool    true if number is valid, otherwise false
	* @author Damien Seguy <dams@nexen.net>
	*/
	function valid_isbn ($isbn)
	{
		if (preg_match ("/[^0-9 IXSBN-]/", $isbn))
			return false;

		if (!ereg ("^ISBN", $isbn))
			return false;

		$isbn = ereg_replace ("-", "", $isbn);
		$isbn = ereg_replace (" ", "", $isbn);
		$isbn = eregi_replace ("ISBN", "", $isbn);

		if (strlen($isbn) != 10)
			return false;

		if (preg_match ("/[^0-9]{9}[^0-9X]/", $isbn))
			return false;

		$t = 0;
		for($i=0; $i< strlen($isbn)-1; $i++)
			$t += $isbn[$i]*(10-$i);

		$f = $isbn[9];

		if ($f == "X")
			$t += 10;
		else
			$t += $f;
        
		if ($t % 11)
			return false;
		else
			return true;
	}

	function calypso_create_link ($person, $title, $url)
	{
		global $smarty;
		$database = $smarty->get_template_vars ('database');

		$feed = autodiscover_rss ($url);
		$icon = autodiscover_favicon ($url);

		$sql = sprintf (
			" INSERT INTO         " . 
			"   links             " . 
			" SET                 " .
			"   %s                " .
			"   %s                " .
			"   link_person = %s, " .
			"   link_title = %s,  " .
			"   link_url = %s     " , 
			(($feed) ? "link_feed = " . DB_Common::quote ($feed) . ",": ""),
			(($icon) ? "link_icon = " . DB_Common::quote ($icon) . ",": ""),
			$person,
			DB_Common::quote ($title),
			DB_Common::quote ($url)
		);
		$database->query ($sql);
	}

	function calypso_delete_link ($person, $link)
	{
		global $smarty;
		$database = $smarty->get_template_vars ('database');

		$sql = sprintf (
			" DELETE FROM        " . 
			"   links            " . 
			" WHERE              " . 
			"   link_person = %s " . 
			" AND                " .
			"   link_id = %s     " .
			" LIMIT 1            " , 
			$person,
			$link
		);
		$database->query ($sql);
	}

	function autodiscover_rss ($location)
	{
		$html = html_from_url ($location);
		if (!html)
			return false;

		$rss = rss_from_html ($html, $location);
		if (!rss)
			return false;

		return $rss;
	}

	function autodiscover_favicon ($location)
	{
		$html = html_from_url ($location);
		if (!html)
			return false;

		$icon = favicon_from_html ($html, $location);
		if (!icon)
			return false;

		return $icon;
	}

	function html_from_url ($location)
	{
		$ch = curl_init ($location);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array ('Connection: close'));
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 15);
		$response = curl_exec ($ch);
		curl_close ($ch);
		return $response;
	}

	# Code from http://keithdevens.com/weblog/archive/2002/Jun/03/RSSAuto-DiscoveryPHP
	function rss_from_html ($html, $location)
	{
		if (!$html or !$location)
			return false;
		else {
			# search through the HTML, save all <link> tags
			# and store each link's attributes in an associative array
			preg_match_all ('/<link\s+(.*?)\s*\/?>/si', $html, $matches);
			$links = $matches[1];
			$final_links = array();
			$link_count = count ($links);
			for ($n = 0; $n < $link_count; $n++) {
				$attributes = preg_split ('/\s+/s', $links[$n]);
				foreach ($attributes as $attribute) {
					$att = preg_split ('/\s*=\s*/s', $attribute, 2);
					if (isset($att[1])) {
						$att[1] = preg_replace ('/([\'"]?)(.*)\1/', '$2', $att[1]);
						$final_link[strtolower($att[0])] = $att[1];
					}
				}
				$final_links[$n] = $final_link;
			}
			#now figure out which one points to the RSS file
			for ($n = 0; $n < $link_count; $n++) {
				if (strtolower ($final_links[$n]['rel']) == 'alternate') {
					if (strtolower ($final_links[$n]['type']) == 'application/rss+xml')
						$href = $final_links[$n]['href'];
					if (!$href and strtolower ($final_links[$n]['type']) == 'text/xml') {
						#kludge to make the first version of this still work
						$href = $final_links[$n]['href'];
					}
					if ($href) {
						if (strstr ($href, "http://") !== false) #if it's absolute
							$full_url = $href;
						else { #otherwise, 'absolutize' it
							$url_parts = parse_url($location);
							#only made it work for http:// links. Any problem with this?
							$full_url = "http://$url_parts[host]";
							if (isset($url_parts['port']))
								$full_url .= ":$url_parts[port]";
							if ($href{0} != '/') { #it's a relative link on the domain
								$full_url .= dirname ($url_parts['path']);
								if (substr ($full_url, -1) != '/') {
									#if the last character isn't a '/', add it
									$full_url .= '/';
								}
							}
							$full_url .= $href;
						}
						return $full_url;
					}
				}
			}
			return false;
		}
	}
	
	function favicon_from_html ($html, $location)
	{
		if (!$html or !$location)
			return false;
		else {
			# search through the HTML, save all <link> tags
			# and store each link's attributes in an associative array
			$html = eregi_replace ('shortcut icon', 'shortcuticon', $html);
			preg_match_all ('/<link\s+(.*?)\s*\/?>/si', $html, $matches);
			$links = $matches[1];
			$final_links = array();
			$link_count = count ($links);
			for ($n = 0; $n < $link_count; $n++) {
				$attributes = preg_split ('/\s+/s', $links[$n]);
				foreach ($attributes as $attribute) {
					$att = preg_split ('/\s*=\s*/s', $attribute, 2);
					if (isset($att[1])) {
						$att[1] = preg_replace ('/([\'"]?)(.*)\1/', '$2', $att[1]);
						$final_link[strtolower($att[0])] = $att[1];
					}
				}
				$final_links[$n] = $final_link;
			}
			#now figure out which one points to the favicon file
			for ($n = 0; $n < $link_count; $n++) {
				if (stristr ('shortcuticon', $final_links[$n]['rel'])) {
					$href = $final_links[$n]['href'];
					if (strstr ($href, "http://")) #if it's absolute
						$full_url = $href;
					else { #otherwise, 'absolutize' it
						$url_parts = parse_url($location);
						#only made it work for http:// links. Any problem with this?
						$full_url = "http://$url_parts[host]";
						if (isset($url_parts['port']))
							$full_url .= ":$url_parts[port]";
						if ($href{0} != '/') { #it's a relative link on the domain
							$full_url .= dirname ($url_parts['path']);
							if (substr ($full_url, -1) != '/') {
								#if the last character isn't a '/', add it
								$full_url .= '/';
							}
						}
						$full_url .= $href;
					}
					return $full_url;
				}
			}
			return false;
		}
	}
?>

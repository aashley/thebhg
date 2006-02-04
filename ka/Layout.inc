<?php
	//Disable errors.
	//ini_set ("display_errors", "0");

	// Define display constants.
	define('KABALS', 0);
	define('CADRES', 1);
	
	require_once 'roster.inc';
	$roster = new Roster($coder);
	
	require_once 'hunts/objects/ka.inc';
	$ka = new KA ('ka-4-hunt');
				
	$results = $roster->SearchPosition('TACT');
	$judicator = $results[0];
	
/*	$results = $roster->SearchPosition('PR');
	$proctor = $results[0];*/
	
	
	$base = "http://" . $_SERVER["HTTP_HOST"] . "/";
		
	ob_start();

 	function ConstructLayout ($title = "", $display = KABALS)
	{
		global $roster, $judicator, $proctor, $ka, $base, $subarray;
		
		$kabals = $roster->GetKabals(1);
		
		$output = ob_get_contents();
		ob_end_clean();
					
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>Kabal Authority<? if (strlen($title) > 0) { echo ": $title"; } ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=$base?>style.css" title="default" media="screen" />
	</head>
	<body>
		<div id="header">
			<h1><span>The Kabal Authority</span></h1>
			<ol id="topnav">
				<li><a href="<?=$base?>news/" title="Get the latest Kabal Authority news">News</a></li>
				<li><a href="<?=$base?>headquarters/" title="Headquarters">Headquarters</a></li>
				<li><a href="<?=$base?>kabals/" title="Kabals">Kabals</a></li>
				<li><a href="<?=$base?>hunts/" title="View hunts you have not completed">Hunts</a></li>
				<li><a href="<?=$base?>kag/" title="Kabal Authority Games">KAGs</a></li>
				<li><a href="<?=$base?>kac/" title="Kabal Authority Cup">KACs</a></li>
				<li><a href="<?=$base?>cg/" title="Cadre Games">CGs</a></li>
				<li><a href="<?=$base?>application/" title="Apply for KA Positions">Applications</a></li>
			</ol>
		</div>
		<div id="content">
<?=$output?>
		</div>
		<ol id="leftnav">
<?	if (isset($subarray)) { ?>
			<li>Navigation
				<ol>
<?		$counter = 0;
		foreach ($subarray as $key=>$value) { 
			unset($class);
			$counter++; 
			if (sizeof($subarray) == 1)
				$class = ' class="first last"';
			elseif ($counter == 1)
				$class = ' class="first"';
			elseif ($counter == sizeof($subarray))
				$class = ' class="last"';
?>
					<li<?=$class?>><a href="<?=$base?><?=$value?>" title="<?=$key?>"><?=$key?></a></li>
<?		} ?>
				</ol>
			</li>
<? 	} ?>
<!--
<?	if (eregi ("admin", $_SERVER["REQUEST_URI"])) { ?>
			<li>Administration
				<ol>
					<li class="first"><a href="<?=$base?>admin/create/hunt/" title="Create a New Hunt">Create a New Hunt</a></li>
					<li class="last"><a href="<?=$base?>admin/modify/hunt/" title="Modify a Hunt">Modify a Hunt</a></li>
				</ol>
			</li>
<?	} elseif (sizeof($hunts) > 0) { ?>
			<li>Current Hunts
				<ol>
	<? 	$counter = 0;
		foreach ($hunts as $hunt) {
			$type = $hunt->GetType();
			unset($class);
			$counter++; 
			if (sizeof($hunts) == 1)
				$class = ' class="first last"';
			elseif ($counter == 1)
				$class = ' class="first"';
			elseif ($counter == sizeof($hunts))
				$class = ' class="last"';
?>
					<li<?=$class?>><a href="<?=$base?>hunts/" title="Participate in the <?=$type->GetName()?> Hunt"><?=$type->GetName()?> Hunt</a></li>
<? 		} ?>
				</ol>
			</li>
<? 	} ?>
-->
			<li>BHG <?php if ($display == KABALS) echo 'Kabals'; else echo 'Cadres'; ?>
				<ol>
<? 	$counter = 0;
	if ($display == KABALS) {
		$divisions = $kabals;
	}
	else {
		$divisions = $roster->GetCadres();
	}
	foreach ($divisions as $div) {
		unset($class);
		$counter++; 
		if (sizeof($divisions) == 1)
			$class = ' class="first last"';
		elseif ($counter == 1)
			$class = ' class="first"';
		elseif ($counter == sizeof($divisions))
			$class = ' class="last"';
?>
					<li<?=$class?>><a href="<?php if ($url = ($display == KABALS ? $div->GetURL() : $div->GetHomePage())) echo $url; else echo 'http://holonet.thebhg.org/index.php?module=roster&amp;page=' . ($display == KABALS ? 'division' : 'cadre') . '&amp;id=' . $div->GetID(); ?>" title="Visit the <?php echo iconv('ISO-8859-1', 'UTF-8', $div->GetName()) . ($display == KABALS ? ' Kabal' : ' Cadre'); ?> website"><?php echo iconv('ISO-8859-1', 'UTF-8', $div->GetName()); ?></a></li>
<? } ?>
				</ol>
			</li>
			<li>KA Contacts
				<ol>
					<li class="first last"><a href="mailto:<?=$judicator->GetEmail()?>" title="Email Judicator <?=$judicator->GetName()?>">JUD <?=$judicator->GetName()?></a></li>
<!--					<li class="last"><a href="mailto:<?=$proctor->GetEmail()?>" title="Email Proctor <?=$proctor->GetName()?>">PR <?=$proctor->GetName()?></a></li>-->
				</ol>
			</li>
			<li>Legal
				<ol>
					<li class="first"><a href="http://www.thebhg.org/disclaimer" title="Copyright &amp; Disclaimers">Copyright &amp; Disclaimers</a></li>
					<li class="last"><a href="http://www.thebhg.org/privacy" title="Privacy Policy">Privacy Policy</a></li>
				</ol>
			</li>
		</ol>
	</body>
</html>
<? 		exit;
	}

	/* board_to_html : Converts non-HTML board posts into valid HTML.
	 * Parameters : message : The message.
	 *              html : 1 if HTML is set on, 0 otherwise.
	 * Returns : The HTML message.
	 */
	function board_to_html($message, $html) {
		// Icky HTML-ising code follows. Be warned.
		
		// Now for the stuff that gets done if HTML is NOT set.
		if (!$html) {
			// Change all characters and board code as required.
			$search = array('"&#34;"',
					'"&#39;"',
					'"&"',
					'"<"', 
					'">"',
					'"\[quote\]"i',
					'"\[/quote\]"i',
					'"\[b\]"i',
					'"\[/b\]"i',
					'"\[i\]"i',
					'"\[/i\]"i',
					'"\[u\]"i',
					'"\[/u\]"i',
					'"\[tt\]"i',
					'"\[/tt\]"i',
					'"\[url=(.*?)\]"i',
					'"\[/url\]"i',
					'"([^=\"\'\\]])((http://|ftp://|gopher://|https://|news:|telnet://|snews:|irc:|nntp://|wais://)[^[:space:]<>]*)"',
					'"^((http://|ftp://|gopher://|https://|news:|telnet://|snews:|irc:|nntp://|wais://)[^[:space:]<>]*)"',
					'"([^/])(www[.][^[:space:]<>]*)"',
					'"^(www[.][^[:space:]<>]*)"',
					'"([^/])(ftp[.][^[:space:]<>]*)"',
					'"^(ftp[.][^[:space:]<>]*)"',
					'"(([A-Za-z0-9_]|\\-|\\.)+@([^[:space:]<>]*)([[:alnum:]-]))"',
					'"\[img=(.*?)\]"i');
			$replace = array('"',
					'\'',
					'&amp;',
					'&lt;', 
					'&gt;',
					'<blockquote><small>quote:</small><hr noshade="noshade">',
					'<hr noshade="noshade"></blockquote><br />',
					'<b>',
					'</b>',
					'<i>',
					'</i>',
					'<u>',
					'</u>',
					'<tt>',
					'</tt>',
					'<a href="\\1" target="_blank">',
					'</a>',
					'\\1<a href="\\2" target="_blank">\\2</a>',
					'<a href="\\1" target="_blank">\\1</a>',
					'\\1<a href="\\2" target="_blank">\\2</a>',
					'<a href="http://\\1" target="_blank">\\1</a>',
					'\\1<a href="ftp://\\2" target="_blank">\\2</a>',
					'<a href="ftp://\\1" target="_blank">\\1</a>',
					'<a href="mailto:\\1">\\1</A>',
					'<img src="\\1" alt="">');
		}
		else {
			$search = array('"\[quote\]"i',
					'"\[/quote\]"i',
					'"\[b\]"i',
					'"\[/b\]"i',
					'"\[i\]"i',
					'"\[/i\]"i',
					'"\[u\]"i',
					'"\[/u\]"i',
					'"\[tt\]"i',
					'"\[/tt\]"i',
					'"\[url=(.*?)\]"i',
					'"\[/url\]"i',
					'"(\A|\s)http://(.*?)(\z|\s)"',
					'"(\A|\s)ftp://(.*?)(\z|\s)"',
					'"\[img=(.*?)\]"i');
			$replace = array('<blockquote><small>quote:</small><hr noshade="noshade">',
					'<hr noshade="noshade"></blockquote><br />',
					'<b>',
					'</b>',
					'<i>',
					'</i>',
					'<u>',
					'</u>',
					'<tt>',
					'</tt>',
					'<a href="\\1" target="_blank">',
					'</a>',
					'\\1<a href="http://\\2" target="_blank">http://\\2</A>\\3',
					'\\1<a href="ftp://\\2" target="_blank">ftp://\\2</A>\\3',
					'<img src="\\1" alt="">');
		}
		$message = preg_replace($search, $replace, $message);
		
		// Last up, we do the stuff that happens regardless of whether HTML
		// is set on or not. This basically just consists of replacing line 
		// breaks with <BR>s.
		$search = array("\n", "\r");
		$replace = array("<br />\n", '');
		$message = str_replace($search, $replace, $message);
	
		return $message;
	}
	
	function CheckAccess ()
	{	
		global $login, $login_position;
		$login_position = $login->GetPosition();
		if (!in_array($login_position->GetID(), array (6, 8, 10, 11, 12, 13, 14)))
		{
			echo "Error";
			ConstructLayout();
		}
	}
?>

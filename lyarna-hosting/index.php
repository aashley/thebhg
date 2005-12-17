<?php
$dir = new DirectoryIterator('/etc/httpd/vhost.d/');

$sites = array();

foreach ($dir as $file) {

	if ($file->isFile()) {

		if (preg_match('/^(www\.[a-z]*\.lyarna\.net)\.conf/', $file->getFileName(), $matches)) {

			$sites[] = $matches[1];

		}

	}

}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Lyarna Web Hosting</title>
<link rel="stylesheet" type="text/css" media="screen" href="lyarna.css"/>
</head>
<body>
	<div id="header">
		<h1>Lyarna Web Hosting</h1>
	</div>
	<div id="sidebar">
		<div>
			<h3>Hosted Sites</h3>
			<ul><?php

foreach ($sites as $site) {

	print "				<li><a href=\"$site\">$site</a></li>\n";

}

?>			</ul>
		</div>
	</div>
	<div id="content">
		<p>Lyarna Web Hosting provides free hosting to members of the BHG. There are 
		two levels of hosting available 'Free' and 'Contributor'. The Free plan is
		available to any active Hunter within the BHG (ie no Trainees). The 
		'Contributor' plan is available to any BHG member who has donated funds to
		the cost of the BHG server.</p>

		<h2>Plan Features</h2>
		
		<h3>Common Features</h3>
		<ul>
			<li>Subdomain of Lyarna.net (username.lyarna.net)</li>
			<li>Lyarna.net Email Address (username@lyarna.net)</li>
			<li>Unlimited subdomain email address (blah@username.lyarna.net goes to username@username.lyarna.net)</li>
			<li>PHP 5</li>
			<li>MySQL Database</li>
			<li>BHG Roster code access</li>
			<li>SSH and FTP access</li>
			<li>Shell access (nothing IRC related permitted)</li>
		</ul>

		<h3>Free Features</h3>
		<ul>
			<li>100Mb disk space</li>
			<li>1Gb transfer per month</li>
		</ul>

		<h3>Contributor Features</h3>
		<ul>
			<li>1Gb disk space</li>
			<li>10Gb transfer per month</li>
		</ul>

		<p>If you want one contact Wonko at aashley@adamashley.name</p>

		<p>Also if you want your own domain hosted it can be done talk to wonko about it, but it'll cost you money.</p>
	</div>
	<div id="footer">
	</div>
</body>
</html>
	

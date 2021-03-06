<?php
	
	require_once 'roster.inc';
	$roster = new Roster();
				
	$results = $roster->SearchPosition('WARD');
	$ward = $results[0];
	
	$base = "http://" . $_SERVER["HTTP_HOST"] . "/";
		
	ob_start();

 	function ConstructLayout ($title = "")
	{
		global $roster, $ward, $base, $subarray;
		
		$kabals = $roster->GetKabals();
		
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
				<li><a href="<?=$base?>bounties/" title="Bounties">Bounties</a></li>
				<li><a href="http://citadel.thebhg.org/" title="The Citadel">The Citadel</a></li>
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
			else
				$class = '';
?>
					<li<?=$class?>><a href="<?=$base?><?=$value?>" title="<?=$key?>"><?=$key?></a></li>
<?		} ?>
				</ol>
			</li>
<? 	} ?>
			<li>BHG Kabals
				<ol>
<? 	$counter = 0;
	
	foreach ($kabals as $div) {
		unset($class);
		$counter++; 
		if (sizeof($kabals) == 1)
			$class = ' class="first last"';
		elseif ($counter == 1)
			$class = ' class="first"';
		elseif ($counter == sizeof($kabals))
			$class = ' class="last"';
		else
			$class = '';
?>
					<li<?=$class?>><a href="<?=$div->GetURL()?>" title="Visit the <?php echo iconv('ISO-8859-1', 'UTF-8', $div->GetName()) ?> Kabal website"><?php echo iconv('ISO-8859-1', 'UTF-8', $div->GetName()); ?></a></li>
<? } ?>
				</ol>
			</li>
			<li>KA Contacts
				<ol>
					<li class="first last"><a href="mailto:<?=$ward->GetEmail()?>" title="Email Judicator <?=$ward->GetName()?>">WARD <?=$ward->GetName()?></a></li>

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

?>

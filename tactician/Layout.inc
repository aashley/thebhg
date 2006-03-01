<?php
	//Disable errors.
	//ini_set ("display_errors", "0");

	// Define display constants.
	define('KABALS', 1);
	define('CADRES', 2);
	
	require_once 'roster.inc';
	$roster = new Roster($coder);
	
	require_once 'bounties/objects/ka.inc';
	$ka = new KA ('ka-4-hunt');
				
	$results = $roster->SearchPosition('TACT');
	$judicator = $results[0];
	
/*	$results = $roster->SearchPosition('PR');
	$proctor = $results[0];*/
	
	
	$base = "http://" . $_SERVER["HTTP_HOST"] . "/";
		
	ob_start();

 	function ConstructLayout ($title = "", $display = 0)
	{
		global $roster, $judicator, $proctor, $ka, $base, $subarray;
		
		$kabals = $roster->GetKabals();
		
		$output = ob_get_contents();
		ob_end_clean();
					
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>Tactician's Office<? if (strlen($title) > 0) { echo ": $title"; } ?></title>
		<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="<?=$base?>style.css" title="default" media="screen" />
	</head>
	<body>
		<div id="header">
			<h1><span>The Tactician's Office</span></h1>
			<ol id="topnav">
				<li><a href="<?=$base?>news/" title="Get the latest Tactican news">News</a></li>
				<li><a href="<?=$base?>headquarters/" title="Headquarters">Headquarters</a></li>
				<li><a href="<?=$base?>bounties/" title="Open Bounties">Bounties</a></li>
				<li><a href="<?=$base?>kag/" title="Kabal Games">KAGs</a></li>
				<li><a href="<?=$base?>cg/" title="Cadre Games">CGs</a></li>
				<li><a href="<?=$base?>om/" title="Online Missions">OMs</a></li>
				<li><a href="<?=$base?>ladder/" title="Tactician Ladder">Ladder</a></li>
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
<? 	} 

if ($display != 0){
	?>
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
<? } ?>
				
			<li>Email Tactician
				<ol>
					<li class="first last"><a href="mailto:<?=$judicator->GetEmail()?>" title="Email Tactician <?=$judicator->GetName()?>">TACT <?=$judicator->GetName()?></a></li>
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

<?php
	include_once 'header.php';
	    
	$gui->addContent("Welcome to the Lyarna Podracing Circuit. If this is your first time here, or you seek information, check out our nifty handbook,"
		." <a href=\"manual.php\">So, You want to be a Podracer!</a>. The buttons to your left will help you navigate, otherwise.");
	
	$gui->addContent ("<p align=\"center\"><a href=\"calender.php\">Show Calender</a><br></p>");
	$gui->addContent ("<p align=\"center\"><a href=\"schedule.php?resl=show\">Show Race Results</a><br></p>");
	$gui->addContent ("<p align=\"center\"><a href=\"schedule.php?sched=show\">Show Schedule</a><br></p>");
	
	$gui->setTitle ("Lyarna Podracing Circuit");
	$gui->outputGui ();
?>
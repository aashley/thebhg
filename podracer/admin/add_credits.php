<?php

	include "../header.php";

	$hunter = new Login_HTTP($coder_id);
	$team_member = $podracer->findTeamMember($hunter->getID());
	$team = $team_member->getTeam();
	if (isset($_REQUEST['Submit'])) {
		$creds = eregi_replace (",", "", $_REQUEST['creds']);
		if ($hunter->GetAccountBalance() >= $creds)	{
			if ($creds < 0){
				$creds = 0;
			}
			$team->addCredits ($creds);
			$hunter->MakePurchase($creds, 'Lyarna Podracer Circuit', 'Depositing into '.$team->GetName().'\'s Account');
			$team_member->addDonations($creds);
			$gui->addContent ("<p align=\"center\"><br>".number_format($creds)." credits successfully added to ".$team->getName()."'s account</p>");
			$gui->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
		} else {
			$gui->addContent ("<p align=\"center\"><br>You do not have enough credits</p>");          
  			$gui->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
		}
	} else {
    	$gui->addContent ("<h2 align=\"center\">Email Team Members</h2>\r\n");
		$gui->addContent ("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">\r\n");
		$gui->addContent ("<table>");
		$gui->addContent ("<tr><td colspan=2>How many credits would you like to donate?</td><tr>\r\n");
		$gui->addContent ("<tr><td>Subject</td><td><input type=\"text\" name=\"creds\"></td><tr>");
		$gui->addContent ("</table>");
		$gui->addContent ("<p align=\"center\"><input type=\"Submit\" name=\"Submit\" value=\"Contribute\">&nbsp;&nbsp;<input type=\"Reset\" name=\"Reset\" value=\"Reset\"></p>\r\n");
		$gui->addContent ("</form>\r\n");
	}
	$gui->setTitle ("Contribute Credits");
	$gui->outputGui ();
?>
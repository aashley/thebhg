<?php

	include "../setup.php";
	
	if (!isset($PHP_AUTH_USER)) 
	{
		die(login_failed());
	} 
	else 
	{  
		//Login object from the BHG roster
		$hunter_obj = new Login ($PHP_AUTH_USER, $PHP_AUTH_PW, $coder_id);
		if ($hunter_obj->IsValid())
		{
			$team_member_obj = $podracer_obj->findTeam_member ($hunter_obj->getID());
			$team_obj = $team_member_obj->getTeam();
			if (isset($Submit))
			{
				$creds = eregi_replace (",", "", $creds);
				if ($hunter_obj->GetAccountBalance() >= $creds)
				{
					$team_obj->addCredits ($creds);
					$hunter_obj->makePurchase($creds);
					$team_member_obj->addDonations($creds);
					$gui_obj->addContent ("<p align=\"center\"><br>".number_format($creds)." credits successfully added to ".$team_obj->getName()."'s account</p>");
					$gui_obj->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
				}
				else
				{
					$gui_obj->addContent ("<p align=\"center\"><br>You do not have enough credits</p>");          
          $gui_obj->addContent ("<p align=\"center\"><a href=\"".$base_url."admin/index.php\">Return to admin</a></p>");
				}
			}
			else
			{
        $gui_obj->addContent ("<h2 align=\"center\">Contribute Credits</h2\r\n");
				$gui_obj->addContent ("<form action=\"".$PHP_SELF."\" method=\"GET\">\r\n");
				$gui_obj->addContent ("<p align=\"center\">How many credits would you like to contribute?<br>");
				$gui_obj->addContent ("<input type=\"text\" name=\"creds\">\r\n");
				$gui_obj->addContent ("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
				$gui_obj->addContent ("</p></form>\r\n");
			}
			$gui_obj->setTitle ("Contribute Credits");
			$gui_obj->outputGui ();
		} 
		else 
		{
			die(login_failed());
		}
	}
?>
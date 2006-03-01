<?php
	
	include "../header.php";
	$gui->setTitle("Team Admin");
	
	$hunter = new Login_HTTP($coder_id);
		if (in_array($hunter->getID(), $admin))
		{
			if ($_REQUEST['type'] == 1)
			{
				if (isset($_REQUEST['Submit']))
				{
					$part = $podracer->createTeam($_REQUEST['name'], $_REQUEST['credits'], $_REQUEST['leader'], $_REQUEST['slogan'], $_REQUEST['url'], $_REQUEST['logo']);
					$podracer->CreateTeamMember($_REQUEST['leader'], $part->getID());
					$gui->addContent("Team created<br><a href=\"teams.php?type=1\">Create Another Team</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
					$gui->addContent("Name: <input type=\"text\" name=\"name\" size=\"20\"><br>");
					$gui->addContent("Credits: <input type=\"text\" name=\"credits\" size=\"6\"><br>");
					$divisions = $roster->GetDivisions('name');
					$options = array();
					$exclude = array(16, 0);
					foreach ($divisions as $div) {
						if (in_array($div->GetID(), $exclude)) {
							continue;
						}
						if ($div->GetMemberCount()) {
							$members = $div->GetMembers('name');
							foreach ($members as $pleb) {
								$options[] = '<option value="'.$pleb->GetID().'">'.$div->GetName() . ': ' . $pleb->GetName().'</option>';
							}
						}
					}
					$gui->addContent("Leader: <select name=\"leader\">".implode('', $options)."</select><br>");		
					$gui->addContent("Slogan: <input type=\"text\" name=\"slogan\" size=\"20\"><br>");
					$gui->addContent("URL: <input type=\"text\" name=\"url\" size=\"20\"><br>");
					$gui->addContent("Logo URL: <input type=\"text\" name=\"logo\" size=\"20\"><br>");	
					$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
					$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
					$gui->addContent("</form>\r\n");
				}
			}
			elseif (isset($_REQUEST['selected']))
			{
				if ($_REQUEST['type'] == 2)
				{
					if (isset($_REQUEST['Submit']))
					{
						$team = new Team ($_REQUEST['selected']);
						$team->setName($_REQUEST['name']);
						$team->setCredits($_REQUEST['credits']);
						$team->setLeader($_REQUEST['leader']);
						$team->setSlogan($_REQUEST['slogan']);
						$team->setURL($_REQUEST['url']);
						$team->setImage($_REQUEST['logo']);
						$gui->addContent("Team edited<br><a href=\"teams.php?type=2\">Edit Another Team</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$team = new Team ($_REQUEST['selected']);
						$leader = $team->getLeader();
						$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
						$gui->addContent("Name: <input type=\"text\" name=\"name\" value=\"".$team->getName()."\" size=\"20\"><br>");
						$gui->addContent("Credits: <input type=\"text\" name=\"credits\" value=\"".$team->getCredits()."\" size=\"6\"><br>");
						$options = array();
						$exclude = array(16, 0);
						foreach ($team->listMembers() as $iteration){
							if (!is_object($iteration)){ continue; }
							$pleb = $iteration->GetBHGID();
							$c = ($leader->getID() == $pleb->GetID());
							$options[] = '<option value="'.$pleb->GetID().'"'.($c ? ' selected' : '').'>' . $pleb->GetName().'</option>';
						}

						$gui->addContent("Leader: <select name=\"leader\">".implode('', $options)."</select><br>");		
						$gui->addContent("Slogan: <input type=\"text\" name=\"slogan\" value=\"".$team->getSlogan()."\" size=\"20\"><br>");
						$gui->addContent("URL: <input type=\"text\" name=\"url\" value=\"".$team->getURL()."\" size=\"20\"><br>");		
						$gui->addContent("Logo URL: <input type=\"text\" name=\"logo\" value=\"".$team->getImage()."\" size=\"20\"><br>");		
						$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
						$gui->addContent("</form>\r\n");
					}
				}
				elseif ($_REQUEST['type'] == 3)
				{
					$team = new Team ($_REQUEST['selected']);
					$team->delete();
					$gui->addContent("Team deleted<br><a href=\"teams.php?type=3\">Delete Another Team</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
				$gui->addContent("<select name=\"selected\">\r\n");
				$teams_array = $podracer->listTeams();
				for ($i = 0; $i < sizeof ($teams_array); $i++)
				{
					$team = $teams_array [$i];
					$gui->addContent("<option value=\"".$team->getID()."\">".$team->getName()."</option>\r\n");
					unset($team);
				}		
				$gui->addContent("</select>\r\n");
				$gui->addContent("<input type=\"Submit\" name=\"Select\" value=\"Select\">");
				$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
				$gui->addContent("</form>\r\n");
			}				
			$gui->outputGui();
		} 
		else 
		{
			die(login_failed());
		}
?>
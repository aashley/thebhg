<?php
	
	include "../header.php";
	$gui->setTitle("Team Member Admin");
	$hunter = new Login_HTTP($coder_id);
		if (in_array($hunter->getID(), $admin))
		{
			if ($_REQUEST['type'] == 1)
			{
				if (isset($_REQUEST['Submit']))
				{
					$part = $podracer->createTeammember($_REQUEST['bhg_id'], $_REQUEST['team']);
					$gui->addContent("Team Member created<br><a href=\"team_members.php?type=1\">Create Another Team Member</a> | <a href=\"index.php\">Return to Admin</a>");
				}
				else
				{
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
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
					$gui->addContent("Add Member: <select name=\"bhg_id\">".implode('', $options)."</select><br>");					
					$gui->addContent("Team: <select name=\"team\">");
					$team_array = $podracer->listTeams();
					for ($k = 0; $k < sizeof ($team_array); $k++)
					{
						$team = $team_array [$k];
						$gui->addContent("<option value=\"".$team->getID()."\">".$team->getName()."</option>");
						unset ($team);
					}					
					$gui->addContent("</select><br>");
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
						$team = new Teammember ($_REQUEST['selected']);
						$team->setBhgid($_REQUEST['bhg_id']);
						$team->setTeam($_REQUEST['teama']);
						$gui->addContent("Team Member edited<br><a href=\"team_members.php?type=2\">Edit Another Team Member</a> | <a href=\"index.php\">Return to Admin</a>");
					}
					else
					{
						$team = new Teammember ($_REQUEST['selected']);
						$team_id = $team->getTeam();
						$person = $team->getBhgid();
						$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");
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
									$c = ($person->getID() == $pleb->GetID());
									$options[] = '<option value="'.$pleb->GetID().'"'.($c ? ' selected' : '').'>'.$div->GetName() . ': ' . $pleb->GetName().'</option>';
								}
							}
						}
						$gui->addContent("Member: <select name=\"bhg_id\">".implode('', $options)."</select><br>");
						$gui->addContent("Team: <select name=\"teama\">");
						$team_array = $podracer->listTeams();
						for ($k = 0; $k < sizeof ($team_array); $k++)
						{
							$team_list = $team_array [$k];
							$gui->addContent("<option value=\"".$team_list->getID()."\"");
							if ($team_id->getID() == $team_list->getID())
							{
								$gui->addContent("selected");
							}
							$gui->addContent(">".$team_list->getName()."</option>");
							unset ($team_list);
						}					
						$gui->addContent("</select><br>");
						$gui->addContent("<input type=\"Submit\" name=\"Submit\" value=\"Submit\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
						$gui->addContent("<input type=\"hidden\" name=\"selected\" value=\"".$_REQUEST['selected']."\">\r\n");
						$gui->addContent("</form>\r\n");
					}
				}
				elseif ($_REQUEST['type'] == 3)
				{
					$team = new Teammember ($_REQUEST['selected']);
					$team->delete();
					$gui->addContent("Team Member deleted<br><a href=\"team_members.php?type=3\">Delete Another Team Member</a> | <a href=\"index.php\">Return to Admin</a>");
				}
			}
			else
			{
				$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
				$gui->addContent("<select name=\"selected\">\r\n");
				$teams_array = $podracer->listTeamsmembers();
				for ($i = 0; $i < sizeof ($teams_array); $i++)
				{
					$team = $teams_array [$i];
					$person = $team->getBhgid();
					$team_id = $team->getTeam();
					$leader = $team_id->GetLeader();
					if ($leader->GetID() != $person->GetID()){
						$gui->addContent("<option value=\"".$team->getID()."\">".$team_id->getName()." - ".$person->getName()."</option>\r\n");
					}
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
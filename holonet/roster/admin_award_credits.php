<?php
include_once("dropdowns.php");
require_once("forms.php");

function title() {
	return 'Administration :: Award Credits';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return ($auth_data['commission'] || $auth_data['chief']);
}

function output() {
	global $auth_data, $pleb, $roster;
	
	$division = $pleb->GetDivision();
	$position = $pleb->GetPosition();

	open_window("Award Credits");

	if (!isset($_REQUEST['division'])) {

	  $_REQUEST['division'] = $division->GetID();

	}

	if (   $division->GetID() == 10
	    || $division->GetID() == 9
	    || $person->GetID() == 94) {

	  PrintFormOpen($_SERVER['PHP_SELF']);

	  print "<TR><TD>Division:</TD><TD>"
	    .DivisionDropDown('division',
			      1,
			      0,
			      1,
			      0,
			      $_REQUEST['division'],
			      1)
	    ." <INPUT TYPE=\"SUBMIT\" VALUE=\"GO\"></TD></TR>";

	  PrintFormClose();

	}

	$count = 10;

	$div = new Division($_REQUEST['division'], 'roster-69god');

	if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Award Credits') {

	  print "<TABLE BORDER=\"0\" CELLSPACING=\"2\" CELLPADDING=\"2\">"
	    ."<TR><TD>The following credits have been awarded pending approval from "
	    ."the Underlord.</TD></TR>";

	  for ($i = 0; $i < sizeof($_REQUEST['person']); $i++) {

	    if (   $_REQUEST['person'][$i] != 0 
		&& $_REQUEST['credits'][$i] != 0) {

	      $sql = "INSERT INTO holonet_pending_credits (`for`, "
							 ."`from`, "
							 ."`amount`, "
							 ."`reason`, "
							 ."`timestamp`) "
		    ."VALUES (".$_REQUEST['person'][$i].", "
			       .$pleb->GetID().", "
			       ."'".str_replace(',', '', $_REQUEST['credits'][$i])."', "
			       ."'".addslashes($_REQUEST['reason'][$i])."', "
			       .time().")";

	      $for = new Person($_REQUEST['person'][$i]);

	      if (mysql_query($sql, $roster->roster_db)) {

		print "<TR><TD>Awarding ".$_REQUEST['credits'][$i]."ics to "
		  .$pleb->GetName()."</TD></TR>";

	      } else {

		print "<TR><TD>Could not award credits to ".$pleb->GetName()."<BR>"
		  ."ERROR: ".mysql_error()."<BR>"
		  ."SQL: ".$sql
		  ."</TD></TR>";

	      }

	    }

	  }

	  print "</TABLE>";

	} else {

	  PrintFormOpen($_SERVER['PHP_SELF']);
	  
	  print "<TR><TD ALIGN=\"CENTER\">Awarding Credits to Members of "
	    .$div->GetName()."</TD></TR>"
	  
	    ."<TR><TD>"
	  
	    ."<TABLE CELLSPACING=\"2\" CELLPADDING=\"2\">"
	    ."<TR>"
	    ."<TD><B>Person</B></TD>"
	    ."<TD><B>Credits</B></TD>"
	    ."<TD><B>Reason</B></TD>"
	    ."</TR>";
	  
	  $members = $div->GetMembers();
	  
	  for ($i = 0; $i < 10; $i++) {
	  
	    print "<TR>"
	      ."<TD>".PersonDropDown('person[]',
				     1,
				     0,
				     $_REQUEST['division'],
				     1,
				     0,
				     1,
				     0)."</TD>"
	  
	      ."<TD>"
	      ."<INPUT TYPE=\"TEXT\" NAME=\"credits[]\" SIZE=\"10\" MAXLENGTH=\"10\">"
	      ."</TD>"
	  
	      ."<TD>"
	      ."<INPUT TYPE=\"TEXT\" NAME=\"reason[]\" SIZE=\"20\" MAXLENGTH=\"250\">"
	      ."</TD>"
	  
	      ."</TR>";
	  
	  }
	  
	  print "</TABLE></TD></TR>";
	  
	  print "<TR><TD COLSPAN=\"2\"><INPUT TYPE=\"SUBMIT\" NAME=\"submit\" "
	  ."VALUE=\"Award Credits\"></TD></TR>";
	  
	  PrintFormClose();

	}

	close_window();
}
?>

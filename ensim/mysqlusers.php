<HTML>
<!----- Copyright (c) 2000-2001 Ensim Corporation ----->
<HEAD>
<LINK REL="stylesheet" href="https://spanky.cernun.net:19638/webhost/services/virtualhosting/siteadmin/stylesheet/" type="text/css">
 </HEAD>
<BODY bgcolor = "#ffffff" marginheight = "2" marginwidth = "15" topmargin = "2" leftmargin = "15">
 <table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr>
   <td class=head>
     <table width=640 border=0 cellspacing=1 cellpadding=1>
       <tr>
         <td class=head>
                                 MYSQL 
                   </td>
                        <td align=right class=head3>
                <script language="JavaScript">
        function popUpHelpWindow() {
           helpwin=window.open("https://spanky.cernun.net:19638/docs/en_US/site/oh_site_viewing_a_sites_databases.htm","helpWindow","resizable=yes,scrollbars=yes,height=275,width=400");
           helpwin.focus();
        }
        function popUpHelpWindow2(flag) {
           var myfile = flag
           helpwin=window.open("https://spanky.cernun.net:19638/docs/en_US/site/" + myfile,"helpWindow","resizable=yes,scrollbars=yes,height=275,width=400");
           helpwin.focus();
        }
        </script>
         <a href="javascript:popUpHelpWindow()" onMouseOver="status='Click here for help'; return true;" onMouseOut="status=''; return true;" onClick="status=''; return true;"><IMG SRC="https://spanky.cernun.net:19638/webhost/help_toolbar_gif" WIDTH = "15" ALIGN = "absmiddle" BORDER = "0" HEIGHT = "15"><font color=white>Help</font></a>

                </td>
               </tr>
    <tr>
    <td class=cell1 colspan=2>
     &nbsp;
                               <a href="index_html" onMouseOver="status='Manage Databases'; return true;" onMouseOut="status=''; return true;">Manage Databases</a>
                                 <img src=red_gif width=4 height=4>
          <a href="form_mysqllistdb" onMouseOver="status='List Databases'; return true;" onMouseOut="status=''; return true;">List Databases</a>
                                 <img src=red_gif width=4 height=4>
                                     <b>
          <a href="users" onMouseOver="status='List Users'; return true;" onMouseOut="status=''; return true;">List Users</a>
          </b>
                                 <img src=red_gif width=4 height=4>
                                     <a href="form_mysqlcreatedb" onMouseOver="status='Create Database'; return true;" onMouseOut="status=''; return true;">Create Database</a>
                                 <img src=red_gif width=4 height=4>
                                     <a href="form_mysqlsitepass" onMouseOver="status='Change Password'; return true;" onMouseOut="status=''; return true;">Change Password</a>
                              </td>
   </tr>
  </table>
 </td>
</tr>
</table>
&nbsp;<br>


 
<?php
function DropDown($name, $options) {
	$return = "<SELECT SIZE=\"1\" NAME=\"$name\">\n"
		."<OPTION VALUE=\"\"></OPTION>\n";
	foreach ($options as $option) {
		$return .= "<OPTION VALUE=\"$option\">$option</OPTION>\n";
	}
	$return .= "</SELECT>\n";
	return $return;
}


$globaluser = 'root';
$globalpass = 'g00n3r';
                                                                                                                               
$rootdb = mysql_connect('localhost', $globaluser, $globalpass);

$username = str_replace(array('\\', '"'), '', $_COOKIE['ocw_username']);
$username = substr($username, 0, strpos($username, '@'));

if (isset($_REQUEST['op'])) {

	$usersdbs = array();
	$usersacct = array();
                                                                                                                               
	$databases = mysql_list_dbs($rootdb);
                                                                                                                               
	while ($db = mysql_fetch_array($databases)) {
		if (preg_match('/^'.$username."_[A-Za-z1-9_]/", $db['Database'])) {
			array_push($usersdbs, $db['Database']);
		}
	}
                                                                                                                               
	$users = mysql_query("SELECT * FROM mysql.user WHERE UPPER(User) LIKE UPPER('$username%') and Host = 'localhost'"); 
	while ($user = mysql_fetch_array($users)) {
		array_push($usersacct, $user['User']);
	}

	$success = true;
	$hosts = array('localhost', 'localhost.localdomain', '127.0.0.1');

	switch ($_REQUEST['op']) {

		case 'createuser':
			$message = 'Create MySQL User';
			
			if (   !isset($_REQUEST['newusername'])
					|| strlen($_REQUEST['newusername']) == 0) {
				$reason = 'Invalid username.';
				$success = false;
				break;
			}
			
			if (in_array($username.'_'.$_REQUEST['newusername'], $usersacct)) {
				$reason = 'Username already exists.';
				$success = false;
				break;
			}

			if (   !isset($_REQUEST['newpassword'])
					|| strlen($_REQUEST['newpassword']) == 0) {
				$reason = 'Invalid password.';
				$success = false;
				break;
			}

			foreach ($hosts as $host) {
				$sql = "INSERT INTO mysql.user "
											 ."VALUES ('$host', "
															 ."'".$username.'_'.$_REQUEST['newusername']."', "
															 ."PASSWORD('".$_REQUEST['newpassword']."'), "
															 ."'N', "
															 ."'N', "
															 ."'N', "
															 ."'N', "
															 ."'N', "
															 ."'N', "
															 ."'N', "
															 ."'N', "
															 ."'N', "
															 ."'N', "
															 ."'N', "
															 ."'N', "
															 ."'N', "
															 ."'N')";
				
				if (mysql_query($sql)) {
					$success = $success && true;
				} else {
					$success = $success && false;
					$reason = mysql_errno().': '.mysql_error().'. SQL: '.$sql.'<br>';
				}
			}
			break;

		case 'createperm':
			$message = 'Create Access Permission';
			if ($username == $_REQUEST['user']) {
				$reason = 'Can not create permission for domain account. Already has full access.';
				$success = false;
				break;
			}

			if (!in_array($_REQUEST['database'], $usersdbs)) {
				$reason = 'Database does not exist.';
				$success = false;
				break;
			}

			if (!in_array($_REQUEST['user'], $usersacct)) {
				$reason = 'User does not exist.';
				$success = false;
				break;
			}

			foreach ($hosts as $host) {
				if ($_REQUEST['type'] == 'full') {
					$sql = "INSERT INTO mysql.db "
								."VALUES ('$host', "
												."'".$_REQUEST['database']."', "
												."'".$_REQUEST['user']."', "
												."'Y', "
												."'Y', "
												."'Y', "
												."'Y', "
												."'Y', "
												."'Y', "
												."'N', "
												."'Y', "
												."'Y', "
												."'Y')";
				} else {
					$sql = $sql = "INSERT INTO mysql.db "
								."VALUES ('$host', "
												."'".$_REQUEST['database']."', "
												."'".$_REQUEST['user']."', "
												."'Y', "
												."'N', "
												."'N', "
												."'N', "
												."'N', "
												."'N', "
												."'N', "
												."'N', "
												."'N', "
												."'N')";
				}
				if (mysql_query($sql)) {
					$success = $success && true;
				} else {
					$success = $success && false;
					$reason = mysql_errno().': '.mysql_error().'. SQL: '.$sql.'<br>';
				}
			}
			break;

		default:
			$message = 'Unknown Operation';
			$success = false;
			break;
			
	}

	mysql_query("FLUSH PRIVILEGES");
	
	if ($success) {
		$image = "greenbal_gif";
		$short = "Successful";
		$long = "<b>Result : </b>".$message.": succeeded.";
		$reason = "<b>Result : </b>".$message.": succeeded.";
	} else {
		$image = "redball_gif";
		$short = "Failure";
		$long = "<b>Result : </b>".$message.": failed.<br>";
		$reason = "<b>Result : </b>".$message.": failed.<br>".$reason;
	}
	?>
<script language="JavaScript">
var msglist=['<?php echo str_replace("'", "\\'", htmlspecialchars($reason)); ?>','']
var detailsWindow
 
function popUpDetailsWindow() {
	detailsWindow = window.open("","detailsWindow","resizable=yes,scrollbars=yes,height=250,width=400")
	detailsWindow.focus()
	if (!detailsWindow.opener) { detailsWindow.opener = window }
	writeDetails()
}
 
function writeDetails() {
	var content = '<html><head>\n'
			  
	content += ' <title>Details</title>\n'
	content += ' </head>\n'
	content += "<link REL='stylesheet' href='/stylesheet/' type='text/css'>"


	content += ' <body onLoad="self.focus()" bgcolor=#fffff0 link=blue vlink=blue alink=red>\n'
	content += '  <table border=0 width=100% height=100% cellpadding=4 cellspacing=0>\n'
	content += '   <tr><td class=head height=10><b><font face=arial size=2 color=#ffffff>Details of the last action performed:</font></b></td></tr>\n'
	content += '   <tr><td class=cell1 height=80% valign=top bgcolor=#fffff0><br><ul>\n'
	if (msglist.length > 1) {
	  for (var i=0; i<msglist.length-1;i++) {
	    content += '<li>' + msglist[i] + '</li>\n'
	  }
	}
	content += '   </ul></td></tr>\n'
	content += '   <tr><td class=cell1 align=center>\n'
	content += '    <form><input type=button name="Close Window" value="Close Window" onClick="self.close()"></form>\n'
	content += '   </form></tr></table>\n'
	content += ' </body></html>\n'
	detailsWindow.document.write(content)
	detailsWindow.document.close()
}
</script>             

<table width=640 border=0 cellspacing=0 cellpadding=1>
  <tr>
    <td class=head>
      <table width=640 border=0 cellspacing=0 cellpadding=1>

        <tr>
          <td class=cell1>
						&nbsp; 
            <img border=0 src="<?php echo $image; ?>" alt="Action <?php echo $short; ?>"> 
			      <b>Status:</b>&nbsp;<?php echo $short; ?>
          </td>
          <td class=cell1 align=left>&nbsp;
            <?php echo $long; ?>
          </td>
          <td class=cell1>
				    <a href="javascript:popUpDetailsWindow()" onClick="status=''; return true;" onMouseOver="status='Click here for details'; return true;" onMouseOut="status=''; return true;"><b>Details</b></a>
          </td>
        </tr>
			</table> 
		</td>
	</tr>
</table> 
<br>
<?php

}

// Reload details
$usersdbs = array();
$usersacct = array();
                                                                                                                               
$databases = mysql_list_dbs($rootdb);
                                                                                                                               
while ($db = mysql_fetch_array($databases)) {
	if (preg_match('/^'.$username."_[A-Za-z1-9_]/", $db['Database'])) {
		array_push($usersdbs, $db['Database']);
	}
}
sort($usersdbs);
                                                                                                                               
$users = mysql_query("SELECT * FROM mysql.user WHERE UPPER(User) LIKE UPPER('$username%') and Host = 'localhost'"); 
while ($user = mysql_fetch_array($users)) {
	if ($username != $user['User']) 
		array_push($usersacct, $user['User']);
}
sort($usersacct);

?>
<table width=640 border=0 cellspacing=1 cellpadding=0>
<tr>
<td class=head>
	<table width=640 border=0 cellspacing=1 cellpadding=1>
	<tr>
		<td class=head3> &nbsp;Create User</td>
	</tr>
	<form method=POST action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="hidden" name="op" value="createuser">
	<tr>
		<td class=help valign=center colspan=2>For uniqueness, the database will be created with <?php echo $username;?>_ as a prefix.</td>
	</tr>
	<tr>
		<td class=cell1 valign=center>Username</td>
		<td class=cell1 valign=top><?php echo $username;?>_<input type="text" name="newusername" value=""></td>
	</tr>
	<tr>
		<td class=cell1 valign=center>Password</td>
		<td class=cell1 valign=top><input type="text" name="newpassword" value=""></td>
	</tr>
	<tr>
		<td class=cell1 align=center colspan=2><input type=submit value='Save'><input type=reset value="Reset"></td>
	</tr>
	</form>
	</table>
</td>
</tr>
</table>
<br>


<table width=640 border=0 cellspacing=1 cellpadding=0>
<tr>
<td class=head>
	<table width=640 border=0 cellspacing=1 cellpadding=1>
	<tr>
		<td class=head3> &nbsp;Grant Permission</td>
	</tr>
	<form method=POST action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="hidden" name="op" value="createperm">
	<tr>
		<td class=cell1 valign=center>User</td>
		<td class=cell1 valign=top><?php echo DropDown('user', $usersacct);?></td>
	</tr>
	<tr>
		<td class=cell1 valign=center>Database</td>
		<td class=cell1 valign=top><?php echo DropDown('database', $usersdbs);?></td>
	</tr>
	<tr>
		<td class=cell1 valign=center>Access Type</td>
		<td class=cell1 valign=top><input type="radio" name="type" value="full" id="full"><label for="full">Full Access</label><br><input type="radio" name="type" value="readonly" id="readonly"><label for="readonly">Read-Only Access</label></td>
	</tr>
	<tr>
		<td class=cell1 align=center colspan=2><input type=submit value='Save'><input type=reset value="Reset"></td>
	</tr>
	</form>
	</table>
</td>
</tr>
</table>
<br>


<table width=640 border=0 cellspacing=1 cellpadding=0>
<tr>
<td class=head>
  <table width=640 border=0 cellspacing=1 cellpadding=1>
  <tr>
    <td class=head3> &nbsp;Manage Permission</td>
  </tr>
  <tr>
    <td class=head4> &nbsp;Database Name </td>
    <td class=head4 align=center> &nbsp;User Account </td>
    <td class=head4 align=center> &nbsp;Access Type </td>
    <td class=head4 align=center> &nbsp;Actions </td>
  </tr>
<?php 
foreach ($usersdbs as $db) {

	$users = mysql_query("SELECT * FROM mysql.db WHERE Db = '".$db."' AND UPPER(User) LIKE UPPER('$username%') AND Host = 'localhost' ORDER BY User", $rootdb);

	$rows = mysql_num_rows($users);

	$first = true;

	while ($user = mysql_fetch_array($users)) {

		print '<tr>';

		if ($first) {

			print '<td rowspan="'.$rows.'" class="cell1" valign="top">&nbsp;&nbsp;'.$db.'</td>';

			$first = false;

		}

		print '<td class="cell1" align="center">'.$user['User'].'</td>';

		if ($user['Insert_priv'] == 'Y') {

			if ($user['User'] == $username) {

				print '<td class="cell1" align="center">Domain Account</td>';

			} else {

				print '<td class="cell1" align="center">Full</td>';

			}

		} else {

			print '<td class="cell1" align="center">Read-Only</td>';

		}

		if ($user['User'] == $username) {

			print '<td class="cell1" align="center">&nbsp;</td>';

		} else {
			
			print '<td class="cell1" align="center"><a href="'.$_SERVER['PHP_SELF'].'?op=revoke&database='.$db.'&user='.$user['User'].'" onclick=\'return confirm("Do you really want to delete the user '.$user['User'].' permission to access database '.$db.' ?")\'><IMG src="/webhost/remove_gif" align=center border=0 width=20 height=20></a></td>';

		}

		print "</tr>\n";

	}

}

?>
</table>
</td>
</tr>
</table>
<P>&nbsp;</P>
</BODY>
</HTML>

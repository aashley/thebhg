<?php



	/***************************************

	* admin_index.php

	* KA Site Admin template

	***************************************/



include('../setup.php');

$site = "admin_".$site;







   if (!isset($PHP_AUTH_USER)) {

    Header( "WWW-Authenticate: Basic realm=\"$site_title\"");

    Header( "HTTP/1.0 401 Unauthorized");

    $page = "noaccess.inc";

  } else {

      $login = new Login($PHP_AUTH_USER, $PHP_AUTH_PW);

      if ($login->isValid()) {

        $login_id_num = $login->GetID();

        $login_id_name = $login->GetName();

        $login_id_email = $login->GetEmail();

        $login_id_position = $login->GetPosition($login_id_num);

        $login_id_division = $login->GetDivision($login_id_num);

        $login_id_position_id = $login_id_position->GetID();

        $login_id_position_name = $login_id_position->GetName();

        $login_id_division_id = $login_id_division->GetID();

        $login_id_division_name = $login_id_division->GetName();

      } else {

        header('WWW-Authenticate: Basic realm="$site_title"');

        header('HTTP/1.0 401 Unauthorized');

        $page = "noaccess.inc";

      }

    }





?>



<html>
<head><title>The Kabal Authority</title></head>



<body bgcolor="#6B7C84" text="#FFFFFF" link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF">



<?php echo "<center><table border=0 width=70%><tr><td align=center><font face=\"".FontsMain()."\" size=-2><A HREF=\"mailto:jud@thebhg.org\">Judicator<br>".$jud."</A></td><td align=center><img src=\"../images/kabanner.jpg\"></td><td align=center><font face=\"".FontsMain()."\" size=-2><A HREF=\"mailto:pr@thebhg.org\">Proctor<br>".$pr."</A></td></tr></table></center><br>"; ?>



<table width="753" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#6B7C84">

  <tr>

	<td bordercolor="#000000">

	  <table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#4E595F" bordercolor="#6B7C84">

		<tr>

		  <td bordercolor="#000000">

			<table border="0" cellspacing="1" cellpadding="3" width="100%">

			  <tr>

            	<td>

			     <font face="<?php echo FontsMain(); ?>">





                     <?php

                         include("admin_chmanual.php");

                      ?>





                    </font>
				</td>

			  </tr>

			</table>

		  </td>

		</tr>

	  </table>

	</td>

  </tr>

</table>



<?php echo ka_menu(); ?>


</body>
</html>
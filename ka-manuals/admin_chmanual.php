<?php


if ($login_id_num == 144 || $login_id_division_id == 9 || $login_id_division_id == 10 || $login_id_position_id == 11 || $login_id_position_id == 12 || $login_id_position_id == 10) {

echo "<a href=\"http://ka.thebhg.org/manuals/admin_form.php?report=chmanual\">CH Manual</a>";
echo "<br>";
echo "<a href=\"http://ka.thebhg.org/manuals/admin_form.php?report=wardmanual\">WARD Manual</A>";

if($report == "chmanual" )
	{	
	include('ch_manual.inc');
	}
if($report == "wardmanual" )
	{
	include('w_manual.inc');
	}
?>

<?php
} else {
  echo "<center><br><br><font face=\".FontsMain().\" SIZE=\"-1\">";
  echo "Error: Only CRA or above may view this<br><br><br>";
}
?>
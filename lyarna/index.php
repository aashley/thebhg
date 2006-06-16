<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Lyarna System: Home of the Bounty Hunters Guild</title>
  <link rel="shortcut icon" href="/images/lyarna.png">
  <script language="JavaScript">
<!--

function confirm_entry(link){
	
	progress = confirm("Are you SURE you want to do that?");
	
	if (progress == true){ 
	window.location = link;
	} else {
	alert ("Delete canceled.");
	}

}

-->
</script>
  
</head>

<body>

<center>

<table cellpadding="0" cellspacing="0">
  <tr>
  <td class="center">
    <img src="images/top.jpg" alt="Lyarna System">
  </td>
  </tr>

  <tr>
  <td class="center">
    <table cellpadding="0" cellspacing="0">
      <tr>
      <td class="center">
        <img src="images/nav.jpg" width="119" height="386" border="0" alt="" usemap="#nav">
          <map name="nav">
          <area shape="rect" alt="Other Locations" coords="11,178,112,190" href="buildings/?type=other" target="iframe">
          <area shape="rect" alt="Personal Sites" coords="16,149,112,162" href="buildings/?type=personal" target="iframe">
          <area shape="rect" alt="Hunter Estates" coords="15,118,112,133" href="buildings/?type=estate" target="iframe">
          <area shape="rect" alt="Kabal Complexes" coords="4,90,111,105" href="buildings/?type=hq" target="iframe">
          <area shape="rect" alt="BHG Locations" coords="24,62,111,77" href="buildings/?type=complex" target="iframe">
          <area shape="rect" alt="Planets" coords="28,33,112,47" href="planets/" target="iframe">
          </map>
      </td>
      <td class="center">  
        <img src="images/middlebottomleft.jpg" alt="">
      </td>
      <td class="center">
        <iframe src="planets/" width="483" height="366" frameborder="0" name="iframe"></iframe> 
      </td>
      <td class="center">
        <img src="images/middlebottomright.jpg" alt="">
      </td>
      </tr>
    </table>
  </td>
  </tr>
</table>

<p class="footer"><b>&lt;<a href="planets/admin.php" target="iframe">Admin Planets</a> | <a href="buildings/admin.php" target="iframe">Admin Buildings</a>&gt;</b></p>

<p class="footer">
<?php

include_once 'roster.inc';

$roster = new roster();

$grav = new person(2650);
$slag = new person(1187);
$wee = new person(484);
$skor = new person(1699);
$mena = new person(106);
$main = new position(4);

$search = $roster->SearchPosition('SP');
$maint = (is_object($search[0]) ? $search[0] : $grav);

function linky($id, $false = false){
	return ' <a href="http://holonet.thebhg.org/index.php?module=3&page=hunter&id='.$id->getID().'">'.$id->getName().'</a>' . ($false ? '' : '.<br />');
}

echo 'Code &copy;'.linky($grav, true).' originally by'.linky($wee, true).'; layout &copy;'.linky($skor);
echo 'Most graphics and planetary data by'.linky($slag, true).' original data by'.linky($mena);
echo 'Site maintained by'.linky($grav, true).' and'.linky($slag);
?>
All locations created by other various members of the <a href="http://www.thebhg.org/">Bounty Hunters Guild</a>.<br>
This site is part of the <a href="http://www.thebhg.org/" target="_blank">Bounty Hunters Guild</a>, and is subject to their <a href="http://www.thebhg.org/privacy" target="_blank">privacy policies</a>, <a href="http://www.thebhg.org/disclaimer" target="_blank">copyright disclaimers</a> and other guidelines.
</p>

</center>

</body>
</html>

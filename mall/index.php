<?php
include_once('roster.inc');
$roster = new Roster();

$tact = $roster->SearchPosition(3);
$marl = $roster->SearchPosition(7);
$skor = $roster->GetPerson(1699);

function roster_link($person) {
	$pos = $person->GetPosition();
	echo '<A HREF="http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=' . $person->GetID() . '">' . htmlspecialchars($pos->GetName()) . ' ' . htmlspecialchars($person->GetName()) . '</A>';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html/loose.dtd">
<HTML>
<HEAD>
<TITLE>Xerokine Outlet Centre</TITLE>
<STYLE TYPE="text/css">
<!--
BODY {
	background: black;
	color: #cfcfcf;
	font-family: Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 8pt;
}
A {
	text-decoration: none;
}
A:HOVER, A:ACTIVE {
	text-decoration: underline;
	color: white;
}
IMG {
	border: 0;
}
-->
</STYLE>
<BODY BGCOLOR="black" TEXT="#cfcfcf" LINK="#cfcfcf" VLINK="#cfcfcf" ALINK="white">
<TABLE BORDER="0" WIDTH="100%">
<TR>
<TD WIDTH="33%">&nbsp;</TD>
<TD>
<CENTER>
<IMG SRC="xoc.jpg" WIDTH="600" HEIGHT="430" BORDER="0" ALT="Xerokine Outlet Centre" USEMAP="#map">
<BR>
<A HREF="ssl/">Stalker&nbsp;Shipyards&nbsp;Limited</A> | <A HREF="kiw/">Khan&nbsp;Industrial&nbsp;Weapons</A> | <A HREF="kke/">Kal-Ket's&nbsp;Entrepot</A> | <A HREF="dsm/">Darth&nbsp;Shadow&nbsp;Manufacturing</A> | <A HREF="rgt/">Royal&nbsp;Ground&nbsp;Transport</A> | <A HREF="krf/">Koral&nbsp;Robotics&nbsp;Foundry</A>
<BR><BR>
<TABLE BORDER="0" WIDTH="100%" STYLE="border-top: solid 1px #cfcfcf"><TR><TD>&nbsp;</TD></TR></TABLE>
The Xerokine Outlet Centre is run by 
<?php
if ($tact) {
	roster_link($tact[0]);
	if ($marl) {
		echo ' and ';
	}
}
if ($marl) {
	roster_link($marl[0]);
}
?>.<BR>
Menu graphic designed and created by <?php roster_link($skor); ?>.<BR><BR>
All rights reserved 1995-2003, original contents are protected by the United States (US) Copyright Act in accordance with the Emperor's Hammer <A HREF="http://www.emperorshammer.org/disclaim.htm">Disclaimers and Copyrights</A> detailed herein. This site abides by the Emperor's Hammer <A HREF="http://www.emperorshammer.org/privacy.htm">Privacy Policy</A>.<BR><BR>
That's it! You people have stood in my way long enough. I'm going to clown college!
</CENTER>
</TD>
<TD WIDTH="33%">&nbsp;</TD>
</TR>
</TABLE>
<MAP NAME="map">
<AREA SHAPE="rect" COORDS="25,200,238,243" HREF="kke/" ALT="Kal-Ket's Entrepot">
<AREA SHAPE="rect" COORDS="298,265,398,295" HREF="ssl/" ALT="Stalker Shipyards Limited">
<AREA SHAPE="rect" COORDS="492,228,577,251" HREF="kiw/" ALT="Khan Industrial Weapons">
<AREA SHAPE="rect" COORDS="123,283,239,300" HREF="dsm/" ALT="Darth Shadow Manufacturing">
<AREA SHAPE="rect" COORDS="340,296,440,325" HREF="rgt/" ALT="Royal Ground Transport">
<AREA SHAPE="rect" COORDS="75,370,224,412" HREF="krf/" ALT="Koral Robotics Foundry">
<AREA SHAPE="rect" COORDS="352,412,593,427" HREF="kke/" ALT="Kal-Ket's Entrepot">
<AREA SHAPE="rect" COORDS="352,382,593,395" HREF="ssl/" ALT="Stalker Shipyards Limited">
<AREA SHAPE="rect" COORDS="352,396,593,411" HREF="kiw/" ALT="Khan Industrial Weapons">
<AREA SHAPE="rect" COORDS="322,367,593,381" HREF="dsm/" ALT="Darth Shadow Manufacturing">
<AREA SHAPE="rect" COORDS="352,353,593,366" HREF="rgt/" ALT="Royal Ground Transport">
<AREA SHAPE="rect" COORDS="368,337,593,353" HREF="krf/" ALT="Koral Robotics Foundry">
</MAP>
</BODY>
</HTML>

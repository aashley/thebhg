<?php
include('header.php');

$oxx = $roster->GetPerson(257);
$jer = $roster->GetPerson(666);
$fruity = $roster->GetPerson(94);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<HTML>
<HEAD>
<TITLE><?=$str_name?></TITLE>
<NOSCRIPT>
<META HTTP-EQUIV="Refresh" CONTENT="0; URL=index-large.php">
</NOSCRIPT>
<LINK REL="stylesheet" TYPE="text/css" HREF="style.css">
</HEAD>
<BODY CLASS="OUTER">
<SCRIPT LANGUAGE="javascript1.2" TYPE="text/javascript">
<!--
if (document.body.clientHeight > 500) {
	location.href = 'index-large.php';
	var index = 'index-large.php';
}
else {
	location.href = 'index-small.php';
	var index = 'index-small.php';
}
// -->
</SCRIPT>
<CENTER>
<SCRIPT>
<!--
document.writeln('<IMG SRC="images/splash.jpg" HEIGHT=220 WIDTH=167 ALT="Shuttle Splash Image"><BR><BR>');
document.writeln('[ <A HREF="' + index + '"><?php echo $str_name; ?></A> ]');
// -->
</SCRIPT>
<NOSCRIPT>
<IMG SRC="images/splash.jpg" HEIGHT=220 WIDTH=167 ALT="Shuttle Splash Image"><BR><BR>
[ <A HREF="index-large.php"><?php echo $str_name; ?></A> ]
</NOSCRIPT>
<BR><BR><SMALL>
Layout and graphics by <A HREF="<?php echo $oxx->GetEmail(); ?>">Lord <?php echo $oxx->GetName(); ?></A><BR>
Concept and code by <A HREF="<?php echo $fruity->GetEmail(); ?>"><?php $pos = $fruity->GetPosition(); echo $pos->GetName() . ' ' . $fruity->GetName(); ?></A> and <A HREF="<?php echo $jer->GetEmail(); ?>"><?php $pos = $jer->GetPosition(); echo $pos->GetName() . ' ' . $jer->GetName(); ?></A><BR><BR>
All rights reserved 1999-2001, Original contents are protected by the<BR>
United States (US) Copyright Act in accordance with the Emperor's Hammer<BR>
<A HREF="http://www.emperorshammer.org/disclaim.htm">Disclaimers and Copyrights</A> detailed herein.<BR>
This site abides by the Emperor's Hammer <A HREF="http://www.emperorshammer.org/privacy.htm">Privacy Policy</A><BR><BR>
186,000 miles per second. It's not the law, just a good challenge.
</SMALL>
</CENTER>
</BODY>
</HTML>

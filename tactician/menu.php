<?php
include('header.php');
page_header('', 'MENU');
?>
<TABLE CLASS="MENU" WIDTH=160 HEIGHT=308>
<TR VALIGN="top"><TD CLASS="MENU">
<DIV CLASS="MENUITEM"><A CLASS="MENU" HREF="main.php">News</A></DIV>
<DIV CLASS="MENUITEM"><A CLASS="MENU" HREF="mlist.php?complete=0">Current Missions</A></DIV>
<DIV CLASS="MENUITEM"><A CLASS="MENU" HREF="mlist.php?complete=1">Archived Missions</A></DIV>
<DIV CLASS="MENUITEM"><A CLASS="MENU" HREF="submit.php">Submit Mission</A></DIV>
<DIV CLASS="MENUITEM"><A CLASS="MENU" HREF="stats/index.php">Statistics</A></DIV>
<DIV CLASS="MENUITEM"><A CLASS="MENU" HREF="faq.php">FAQ</A></DIV>
<DIV CLASS="MENUITEM"><A CLASS="MENU" HREF="contact.php">Contact Us</A></DIV>
<DIV CLASS="MENUITEM"><A CLASS="MENU" HREF="admin.php">Administration</A></DIV>
</TD></TR>
</TABLE>
<?php
page_footer();
?>

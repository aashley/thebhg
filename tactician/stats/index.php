<?php
include('../header.php');
page_header('Statistics');

echo <<<EOM
Note: The first OM set to have answers tracked was OM set 34.<HR NOSHADE>
<TABLE CELLPADDING=0 CELLSPACING=1 CLASS="STATS">
<TR VALIGN="top"><TD CLASS="STATS"><A HREF="authors.php">Author Statistics</A></TD><TD CLASS="STATS">View the authors that have written OMs for each Tactician.</TD></TR>
<TR VALIGN="top"><TD CLASS="STATS"><A HREF="author_difficulty.php">Author Difficulty</A></TD><TD CLASS="STATS">View the average solve rate for each author.</TD></TR>
<TR VALIGN="top"><TD CLASS="STATS"><A HREF="answers.php">Answer Statistics</A></TD><TD CLASS="STATS">Find out what percentage of hunters get the right answer.</TD></TR>
<TR VALIGN="top"><TD CLASS="STATS"><A HREF="hof.php">Mission Hall of Fame</A></TD><TD CLASS="STATS">Discover what the hardest and easiest missions have been.</TD></TR>
<TR VALIGN="top"><TD CLASS="STATS"><A HREF="hunters.php">Hunter Statistics</A></TD><TD CLASS="STATS">Find out who can solve a mission blindfolded, and who has a little more difficulty.</TD></TR>
</TABLE>
EOM;

page_footer();
?>

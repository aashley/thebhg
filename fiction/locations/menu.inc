<?php
$fic = new Fiction();

echo "<form method=post action=$PHP_SELF>";
echo "<table bordercolor=#000000 cellspacing=0 cellpadding=0 border=1 style='border-collapse: collapse' width=75%>";
echo "<td align=center colspan=2 bgcolor=#00009C><font color = #FFFFFF style=font-variant: small-caps;>Admin Menu";
echo "</td></tr>";

echo "<tr><td align=center><font color = #000000>Select Fiction: ";
echo "</font>";
echo "<td align=left>";
echo $fic->FicBox($login);
echo "</td></tr>";

echo "<tr><td align=center><font color = #000000>Select Admin Function: ";
echo "</font>";
echo "<td align=left>";
echo $fic->AdminBox();
echo "</td></tr>";

echo "<TR><TD align=center colspan=2>";
echo "<INPUT TYPE=submit VALUE='Run Admin Function'>";
echo "</TD></TR>";

echo "</form>";
echo "</table><br /><br />";

?>
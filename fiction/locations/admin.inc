<?php
$submit = new Competition();
if ($action == "process"){
    $new = $submit->Add($competition, $start, $end);

    if ($new == 1){

        echo "Competition added successfully.";

    } else {

        echo $submit->error;

    }
} else {
    echo "<form method=post action=$PHP_SELF>";

    echo "<table bordercolor=#000000 cellspacing=0 cellpadding=0 border=1 style='border-collapse: collapse' width=75%>";
    echo "<td align=center colspan=2 bgcolor=#00009C><font color = #FFFFFF style=font-variant: small-caps;>Competition Menu";
    echo "</td></tr>";

    echo "<TR><TD style=\"text-align: center\">";
    echo "<b>Start</b> Date (mm-dd-yyyy) </TD>";
    echo "<TD style=\"text-align: left\">";
    echo "<INPUT TYPE=\"text\" name=\"start\" />";
    echo "</TD></TR>";

    echo "<TR><TD style=\"text-align: center\">";
    echo "<b>End</b> Date (mm-dd-yyyy) </TD>";
    echo "<TD style=\"text-align: left\">";
    echo "<INPUT TYPE=\"text\" name=\"end\" />";
    echo "</TD></TR>";

    echo "<TR><TD style=\"text-align: center\">";
    echo "Competition Text </TD>";
    echo "<TD style=\"text-align: left\">";
    echo "<textarea cols=\"40\" rows=\"10\" name=\"competition\"></textarea>";
    echo "</TD></TR>";

    echo "<input type=\"hidden\" name=\"action\" value=\"process\" />";

    echo "<TR><TD style=\"text-align: center\" colspan=2>";
    echo "<INPUT TYPE=\"submit\" VALUE=\"Add Competition\" />";
    echo "</TD></TR>";

    echo "</form>";
    echo "</table>";

    echo "<br /><br />";
}
?>
<?php
if ($bhg_id) {
    $layout = new Layout($bhg_id);

    if ($action == "process") {
        if ($layout->SaveLayout($layout)) {
            echo "Layout successfully changed.<br />";
        } else {
            echo "Error changing layout.";
        }
    }

    unset($layout);
} else {
    echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
    echo "<table cellspacing=\"0\" cellpadding=\"0\" style=\"border: 1px solid #000000; border-collapse: collapse; width: 75%\">";
    echo "<td align=\"center\" colspan=\"2\">Edit Personal Fiction Layout";
    echo "</td></tr>";

    echo "<tr><td style=\"text-align: center; vertical-align: top\">Edit Layout: </td>";

    echo "<td style=\"text-align: left\">";
    echo "<textarea name=\"fiction\" rows=\"50 cols=\"50\">" . $layout->ViewLayout() . "</textarea>";
    echo "</td></tr>";

    echo "<input type=\"hidden\" name=\"bhg_id\" value=\"" . $bhg_id . "\" />";
    echo "<input type=\"hidden\" name=\"action\" value=\"process\" />";
    echo "<input type=\"hidden\" name=\"op\" value=\"edit_layout\" />";

    echo "<tr><td style=\"text-align: center\" colspan=\"2\">";
    echo "<input type=\"submit\" value=\"Submit Edits\" />";
    echo "</td></tr>";
    echo "</form>";
    echo "</table>";
} else {
    echo "<p style=\"text-align: center\">BHG ID required to proceed.</p>";
}

?>
<?php
$submit = new Submit();
if ($action == "process") {
    $new = $submit->Post($login, $fiction, $title, $publish);

    if ($new) {
        echo "Fiction was submitted successfully!";
    } else {
        echo $new->roster_error;
    }
} else {
    if ($upload) {
        $file = $_FILES['fiction']['tmp_name'];
    } else {
        echo "<table cellspacing=\"0\" cellpadding=\"0\" style=\"border: 1px solid #000000; border-collapse: collapse; width: 75%\">";
        echo "<td colspan=\"2\" style=\"text-align: center; background-color: #00009C\"><p style=\"color: #FFFFFF; font-variant: small-caps\">Upload Fiction</p>";
        echo "</td></tr>";

        echo "<tr><td style=\"text-align: center\">Upload Fiction: </td>";

        echo "<td style=\"text-align: left\">";
        echo "<form enctype=\"multipart/form-data\" action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">"
           . "<input type=\"hidden\" name=\"upload\" value=\"1\" />"
           . "File: <input name=\"fiction\" type=\"file\" /><br />"
           . "<input type=\"submit\" value=\"Upload and Format Fiction\" />"
           . "<input type=\"hidden\" name=\"op\" value=\"add\" />"
           . "</form>";
        echo "</td></tr>";

        echo "</table><br /><br />";
    }

    echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
    echo "<table cellspacing=\"0\" cellpadding=\"0\" style=\"border: 1px solid #000000; border-collapse: collapse; width: 75%\">";
    echo "<td colspan=\"2\" style=\"text-align: center; background-color: #00009C\"><p style=\"color: #FFFFFF; font-variant: small-caps\">Add New Fiction</p>";
    echo "</td></tr>";

    echo "<tr><td style=\"text-align: center\">Title: </td>";

    echo "<td style=\"text-align: left\">";
    echo "<input size=\"50\" type=\"text\" name=\"title\" />";
    echo "</td></tr>";

    echo "<tr><td style=\"text-align: center; vertical-align: top\">Fiction: </td>";

    echo "<td style=\"text-align: left\">";
    echo "<textarea name=\"fiction\" rows=\"10\" cols=\"50\">";
    if ($file) {
        include($file);
    }

    echo "</textarea>";
    echo "</td></tr>";

    echo "<tr><td style=\"text-align: center; vertical-align: top\">Publish as: </td>";

    echo "<td style=\"text-align: left\">";
    echo "<select size=\"1\" name=\"publish\">";
    echo "<option value=\"1\">Published</option>";
    echo "<option value=\"0\">Draft</option>";
    echo "</select>";

    echo "</td></tr>";

    echo "<input type=\"hidden\" name=\"action\" value=\"process\" />";
    echo "<input type=\"hidden\" name=\"op\" value=\"add\" />";

    echo "<tr><td style=\"text-align: center\" colspan=\"2\">";
    echo "<input type=\"submit\" value=\"Add New Fiction\" />";
    echo "</td></tr>";

    echo "</form>";
    echo "</table>";
}

?>
<?php

if ($article) {
    $submit = new Article($article);

    if ($action == "delete") {
        $del = $submit->Delete();

        if ($del) {
            echo "Fiction successfully deleted";
        } else {
            echo $del->roster_error;
        }
    } elseif ($action == "undelete") {
        $del = $submit->Undelete();

        if ($del) {
            echo "Fiction successfully undeleted";
        } else {
            echo $del->error;
        }
    } elseif ($action == "process") {
        echo "<p style=\"color: #000000\">";

        if ($fiction) {
            $fic = $submit->SaveFiction($fiction);

            if ($fic) {
                echo "Fiction was updated successfully!";
            } else {
                echo $submit->error;
            }

            echo "<br />";
        }

        if ($title) {
            $tit = $submit->SaveTitle($title);

            if ($tit) {
                echo "Title was updated successfully!";
            } else {
                echo $submit->error;
            }

            echo "<br />";
        }

        if ($publish == 1) {
            $pub = $submit->Publish();

            if ($pub) {
                echo "Fiction was published!";
            } else {
                echo $submit->error;
            }
        }
        echo "</p>";
    } else {
        echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
        echo "<table cellspacing=\"0\" cellpadding=\"0\" style=\"border: 1px solid #000000; border-collapse: collapse; width: 75%\">";
        echo "<td colspan=\"2\" style=\"text-align: center; background-color: #00009C\"><p style=\"color: #FFFFFF; font-variant: small-caps\">Edit Fiction</p>";
        echo "</td></tr>";

        echo "<tr><td style=\"text-align: center\">Title: ";

        echo "<td style=\"text-align: left\">";
        echo "<input size=\"50\" type=\"text\" name=\"title\" value=\"" . $submit->GetTitle() . "\" />";
        echo "</td></tr>";

        echo "<tr><td style=\"text-align: center; vertical-align: top\">Fiction: </td>";

        echo "<td style=\"text-align: left\">";
        echo "<textarea name=\"fiction\" rows=\"10\" cols=\"50\">";
        echo $submit->GetFictionEdit();
        echo "</textarea>";
        echo "</td></tr>";

        if ($submit->AllowPublish){

            if (!$submit->GetPublished()) {
                echo "<tr><td style=\"text-align: center; vertical-align: top\">Publish </td>";

                echo "<td style=\"text-align: left\">";
                echo "<select size=\"1\" name=\"publish\">";
                echo "<option value=\"0\">Do Not Publish</option>";
                echo "<option value=\"1\">Publish</option>";
                echo "</select>";

                echo "</td></tr>";
            }

        }

        echo "<input type=\"hidden\" name=\"action\" value=\"process\" />";
        echo "<input type=\"hidden\" name=\"op\" value=\"edit\" />";
        echo "<input type=\"hidden\" name=\"article\" value=\"" . $article . "\" />";

        echo "<tr><td style=\"text-align: center\" colspan=\"2\">";
        echo "<input type=\"submit\" value=\"Edit Fiction\" />";
        echo "</td></tr>";

        echo "</form>";

        echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
        echo "<input type=\"hidden\" name=\"op\" value=\"edit\" />";
        echo "<input type=\"hidden\" name=\"article\" value=\"" . $article . "\" />";
        echo "<tr><td style=\"text-align: center\" colspan=\"2\">";
        if ($submit->GetDeleted()) {
            echo "<input type=\"hidden\" name=\"action\" value=\"undelete\" />";
            echo "<input type=\"submit\" value=\"Undelete Fiction\" />";
        } else {
            echo "<input type=\"hidden\" name=\"action\" value=\"delete\" />";
            echo "<input type=\"submit\" value=\"Delete Fiction\" />";
        }

        echo "</td></tr>";
        echo "</form>";

        echo "</table>";
    }
} else {
    echo "<center>Fiction Object required to proceed.</center>";
}

?>
<?php

class Layout Extends Fiction {
    var $bhg_id;

    function Layout($bhg_id) {
        $this->Fiction();
        $this->bhg_id = $bhg_id;
    }

    function Parse($art) {
        $sql = "SELECT * FROM `fiction` WHERE `id` = '".$art."' LIMIT 1";
        $query = mysql_query($sql, $this->link);
        $return = array();
        $article = mysql_fetch_array($query);
        $bhg_id = $article['poster'];

        $sql_layout = "SELECT * FROM `layout` WHERE `bhg_id` = '$bhg_id'";
        $query_layout = mysql_query($sql_layout, $this->link);
        $article_layout = mysql_fetch_array($query_layout);

        if ($article_layout['bhg_id'] > 0) {
            $layout = $article_layout['layout'];
        } else {
            $sql = "SELECT * FROM `layout` WHERE `bhg_id` = '0'";
            $query = mysql_query($sql, $this->link);
            $result = mysql_fetch_array($query);
            $layout = $result['layout'];
        }

        $output = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"border-collapse: collapse; border: 1px solid #000000; width: 75%\"><tr><td>";

        require_once('roster.inc');

        $person = new Person($article['poster']);
        $name = $person->GetName();
        $date = getdate($article['date']);
        $title = stripslashes($article['title']);
        $fiction = nl2br(stripslashes($article['fiction']));

        $layout = str_replace("%NAME%", $name, $layout);
        $layout = str_replace("%DATE%", $date['mon'] . "/" . $date['mday'] . "/" . $date['year'], $layout);
        $layout = str_replace("%TITLE%", $title, $layout);
        $layout = str_replace("%FICTION%", $fiction, $layout);
        array_push($return, $layout);

        $count = count($return);
        $i = 0;

        while ($i < $count) {
            $raw = $return[$i];
            $for = count($raw);
            $run = 0;

            while ($run < $for) {
                $output .= $raw[$run];
                $run++;
            }

            $i++;
        }

        $output .= "</td></tr></table>";

        return $output;
    }

    function SaveLayout($layout) {
        $sql = "UPDATE `layout` SET `layout` = '" . addslashes($layout) . "' WHERE `bhg_id` = '" . $this->bhg_id . "' LIMIT 1";

        if (mysql_query($sql, $this->link)) {
            return true;
        } else {
            $this->error = 'Error: Could not save layout.' . mysql_error();

            return false;
        }
    }

    function ViewLayout() {
        $sql = "SELECT * FROM `layout` WHERE `bhg_id` = '" . $this->bhg_id . "'";
        $query = mysql_query($sql, $this->link);

        if (mysql_num_rows($query) > 0) {
            $result = mysql_fetch_array($query);

            return stripslashes($result['layout']);
        } else {
            $sql = "SELECT * FROM `layout` WHERE `bhg_id` = '0'";
            $query = mysql_query($sql, $this->link);
            $result = mysql_fetch_array($query);

            return stripslashes($result['layout']);
        }
    }
}

?>
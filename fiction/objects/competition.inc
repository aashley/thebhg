<?php
class Competition extends Fiction {
    function Competition() {
        $this->Fiction();
    }

    function Output($layout_dir){
        $sql = "SELECT * FROM `competitions` WHERE `start` < ".time()." AND `end` > ".time()." ORDER BY `start` LIMIT 1";

        $query = mysql_query($sql, $this->link);

        $i = 0;

        $return = array();

        $output = "<table style=\"width: 100%; border: 1px solid #FFFFFF; border-collapse: collapse; cell-spacing: 0; cell-padding: 0\"><tr><td>";

        if (mysql_num_rows($query) > 0){

            while ($article = mysql_fetch_array($query)){

                $start = getdate($article['start']);

                $end = getdate($article['end']);

                $competition = nl2br(stripslashes($article['competition']));

                $layout = file($layout_dir."/layout.inc");

                $header = 'Fiction Competition For '.$start['month'];

                include_once 'roster.inc';

                $person = new Person(2650);

                $name = $person->GetName();

                $reload = new Fiction();

                $layout = str_replace("%NAME%", $name, $layout);

                $layout = str_replace("%START%", $start['mon']."-".$start['mday']."-".$start['year'], $layout);

                $layout = str_replace("%END%", $end['mon']."-".$end['mday']."-".$end['year'], $layout);

                $layout = str_replace("%HEADER%", $header, $layout);

                $layout = str_replace("%CONTENT%", $competition, $layout);

                $layout = str_replace("%TYPE%", $class, $layout);

                array_push($return, $layout);
            }

            $count = count($return);

            while ($i < $count){

                $raw = $return[$i];

                $for = count($raw);

                $run = 0;

                while ($run < $for){

                    $output .= $raw[$run];

                    $run++;
                }

                $i++;

            }

        } else {

            $output .= "Sorry, there are no current competitions available.";

        }

        $reload = new Fiction();

        $output .= "</td></tr><tr><td colspan=\"2\"><form action=admin.php method=\"post\"><INPUT type=\"hidden\" name=\"op\" value=\"special\">"
                ."<INPUT type=\"submit\" value=\"Submit your Fiction\"></form></td></tr></table>";

        return $output;

    }

    function CanPost($bhg_id, $resource) {

        $sql = "SELECT * FROM `fiction` WHERE `bhg_id` = '$bhg_id' AND `resource` = '$resource' AND `date` = 0 AND `resource_date` = 0";

        $query = mysql_query($sql, $this->link);

        if (mysql_num_rows($query) > 0){

            $this->error = 'Error: You have already submitted a fiction for this competition.';

            return false;

        } else {

            return true;

        }

    }

    function Add($competition, $start, $end){
        $en = explode("-", $end);

        $end = mktime (0,0,0,$en[0],$en[1],$en[2]);

        $st = explode("-", $start);

        $start = mktime (0,0,0,$st[0],$st[1],$st[2]);

        $sql = "INSERT INTO `competitions` (`start`, `end`, `competition`) VALUES ('$start', '$end', '"
        .addslashes($competition)."')";

        if (mysql_query($sql, $this->link)){

            return true;

        } else {

            $this->error = "Error Adding Fiction ".mysql_error();

            return false;

        }

    }

}
?>
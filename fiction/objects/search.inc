<?php
class Search extends Fiction {
    function Search() {
        $this->Fiction();
    }

    function ByPerson($bhg_id) {
        $sql = "SELECT * FROM `fiction` WHERE `bhg_id` = '$bhg_id' AND `date_deleted` = '0' AND `date` > '0' ORDER BY `id`";
        $query = mysql_query($sql, $this->link);
        $return = array();

        while ($result = mysql_fetch_array($query)) {
            $run = new Article($result['id']);
            array_push($return, $run);
        }

        return $return;
    }

    function IsPoster($bhg_id) {
        $sql = "SELECT * FROM `fiction` WHERE `bhg_id` = '$bhg_id' AND `date_deleted` = '0' AND `date` > '0' ORDER BY `id`";
        $query = mysql_query($sql, $this->link);
        $result = mysql_num_rows($query);

        return ($result > 0);
    }

    function IsFiction($id) {
        $sql = "SELECT * FROM `fiction` WHERE `id` = '$id' AND `date_deleted` = '0' AND `date` > '0' ORDER BY `id`";
        $query = mysql_query($sql, $this->link);
        $result = mysql_num_rows($query);

        return ($result > 0);
    }

    function AllPosters() {
        $sql = "SELECT * FROM `fiction` WHERE `date_deleted` = '0' AND `date` > '0' ORDER BY `bhg_id`";
        $query = mysql_query($sql, $this->link);
        $result = array();
        $return = array();

        while ($resultant = mysql_fetch_array($query)) {
            $run = $resultant['bhg_id'];
            array_push($result, $run);
        }

        $count = count($result);
        $i = 0;

        while ($i < $count) {
            $id = $result[$i];

            if ($id != $old) {
                array_push($return, $id);
                $old = $result[$i];
            }

            $i++;
        }
        return $return;
    }

    function ByTitle($title) {
        $sql = "SELECT * FROM `fiction` WHERE `title` = '$title' AND `date_deleted` = '0' AND `date` > '0'";
        $query = mysql_query($sql, $this->link);
        $return = array();

        while ($result = mysql_fetch_array($query)) {
            $run = new Article($result['id']);
            array_push($return, $run);
        }

        return $return;
    }

    function ByDate($date) {
        $sql = "SELECT * FROM `fiction` WHERE `date` = '$date' AND `date_deleted` = '0' AND `date` > '0' ORDER BY `id`";
        $query = mysql_query($sql, $this->link);
        $return = array();

        while ($result = mysql_fetch_array($query)) {
            $run = new Article($result['id']);
            array_push($return, $run);
        }

        return $return;
    }

    function RANDomFiction() {
        $sql = "SELECT * FROM `fiction` WHERE `date_deleted` = '0' AND `date` > '0'";

        $query = mysql_query($sql, $this->link);
        $return = array();
        while ($result = mysql_fetch_array($query)) {
            array_push($return, $result['id']);
        }
        $key = mt_rand(0, (count($return) - 1));

        return new Article($return[$key]);
    }

    function RANDomPoster() {
        $sql = "SELECT * FROM `fiction` WHERE `date_deleted` = '0' AND `date` > '0'";

        $query = mysql_query($sql, $this->link);
        $return = array();
        while ($result = mysql_fetch_array($query)) {
            array_push($return, $result['bhg_id']);
        }
        $key = mt_rand(0, (count($return) - 1));

        return $this->ByPerson($return[$key]);
    }
}

?>
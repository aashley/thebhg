<?php
class Submit extends Fiction {
    function Submit() {
        $this->Fiction();
    }

    function Post($bhg_id, $fiction, $title, $publish) {
        if ($publish) {
            $date = time();
        } else {
            $date = 0;
        }

        $sql = "INSERT INTO `fiction` (`bhg_id`, `fiction`, `title`, `date`) VALUES ('" . $bhg_id . "', '" . addslashes($fiction) . "', '" . addslashes($title) . "', '" . $date . "')";

        if (mysql_query($sql, $this->link)) {
            return true;
        } else {
            $this->error = 'Error: Could not add fiction.' . mysql_error();

            return false;
        }
    }

    function Resource($bhg_id, $fiction, $title, $resource) {
        $sql = "SELECT * FROM `fiction` WHERE `bhg_id` = '$bhg_id' AND `resource` = '$resource' AND `date` = 0 AND `resource_date` = 0";

        $query = mysql_query($sql, $this->link);

        if (mysql_num_rows($query) > 0){

            $this->error = 'Error: You have already submitted a fiction for this competition.';

            return false;

        } else {

          $date = time();

          $sql = "INSERT INTO `fiction` (`bhg_id`, `fiction`, `title`, `resource`, `resource_date`) VALUES ('" . $bhg_id . "', '" . addslashes($fiction) . "', '" . addslashes($title) . "', '" . $resource . "', '" . $date . "')";

          if (mysql_query($sql, $this->link)) {

               return true;

          } else {

                $this->error = 'Error: Could not add fiction.' . mysql_error();

                return false;
          }

        }

    }

}
?>
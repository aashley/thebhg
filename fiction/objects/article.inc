<?php
class Article extends Fiction {

    var $fiction_title;
    var $fiction_date;
    var $fiction_bhg_id;
    var $fiction_fiction;
    var $fiction_resource;
    var $fiction_date_deleted;

    function Article($id) {

        $this->Fiction();

        $sql = 'SELECT `id`, '
              .'`title`, '
              .'`date`, '
              .'`bhg_id`, '
              .'`fiction`, '
              .'`date_deleted` '
              .'FROM `fiction` WHERE `id` = \''.$id."'";

        $query = mysql_query($sql, $this->link);

        if ($fiction = @mysql_fetch_array($query)) {

            foreach ($fiction as $key => $value) {

                $key = 'fiction_'.$key;

                $this->$key = stripslashes($value);

            }

        }

    }

    function GetID() {
        return $this->fiction_id;
    }

    function GetFiction() {
        return nl2br(stripslashes($this->fiction_fiction));
    }

    function GetFictionEdit() {
        return stripslashes($this->fiction_fiction);
    }

    function GetDate() {
        return getdate($this->fiction_date);
    }

    function GetDeleted() {
        return ($this->fiction_date_deleted > 0);
    }

    function GetPublished() {
        return ($this->fiction_date > 0);
    }

    function GetDateDeleted() {
        return getdate($this->fiction_date_deleted);
    }

    function AllowPublish() {
        return ($this->fiction_resource == 0);
    }

    function GetPoster() {
        include_once 'roster.inc';
        $new = new Person($this->fiction_bhg_id);

        return $new;
    }

    function GetTitle() {
        return stripslashes($this->fiction_title);
    }

    function Publish() {
        $sql = "UPDATE `fiction` SET `date` = '".time()."' WHERE `id` = '".$this->fiction_id."' LIMIT 1";

        if (mysql_query($sql, $this->link)) {

            return true;

        } else {

            $this->error = 'Error: Could not publish fiction. '.mysql_error();

            return false;

        }

    }

    function SaveTitle($title) {
        $sql = "UPDATE `fiction` SET `title` = '".addslashes($title)."' WHERE `id` = '".$this->fiction_id."' LIMIT 1";

        if (mysql_query($sql, $this->link)) {

            return true;

        } else {

            $this->error = 'Error: Could not edit fiction. '.mysql_error();

            return false;

        }

    }

    function SaveFiction($fiction) {
        $sql = "UPDATE `fiction` SET `fiction` = '".addslashes($fiction)."' WHERE `id` = '".$this->fiction_id."' LIMIT 1";

        if (mysql_query($sql, $this->link)) {

            return true;

        } else {

            $this->error = 'Error: Could not edit fiction. '.mysql_error();

            return false;

        }

    }

    function Delete() {
        $sql = "UPDATE `fiction` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->fiction_id."' LIMIT 1";

        if (mysql_query($sql, $this->link)) {

            return true;

        } else {

            $this->error = 'Error: Could not add fiction. '.mysql_error();

            return false;

        }

    }

    function Undelete() {
        $sql = "UPDATE `fiction` SET `date_deleted` = '0' WHERE `id` = '".$this->fiction_id."' LIMIT 1";

        if (mysql_query($sql, $this->link)) {

            return true;

        } else {

            $this->error = 'Error: Could not add fiction. '.mysql_error();

            return false;

        }

    }

}

?>
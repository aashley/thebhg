<?php
class Article extends Arena {

    var $fiction_title;
    var $fiction_date;
    var $fiction_bhg_id;
    var $fiction_fiction;
    var $fiction_resource;
    var $fiction_date_deleted;

    function Article($id) {

        Arena::Arena();

        $sql = 'SELECT `id`, '
              .'`title`, '
              .'`date`, '
              .'`bhg_id`, '
              .'`fiction`, '
              .'`date_deleted` '
              .'FROM `fiction` WHERE `id` = \''.$id."'";

        $query = mysql_query($sql, $this->fiction);

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
        $new = new Person($this->fiction_bhg_id);

        return $new;
    }

    function GetTitle() {
        return stripslashes($this->fiction_title);
    }

}

?>
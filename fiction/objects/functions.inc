<?php
require_once('roster.inc');
class Fiction extends BHGObject {

    var $link;
    var $db;

    function Fiction() {
        $this->db = 'thebhg_fiction';

        $this->link = mysql_connect("localhost", "thebhg_fiction", "c80509a2");
        mysql_select_db($this->db, $this->link);

        $this->BHGObject();
    }

    function CountFictions(){

        $sql = "SELECT * FROM `fiction` WHERE `date_deleted` = 0 AND `date` > 0";
        $query = mysql_query($sql, $this->link);

        return mysql_num_rows($query);

    }

    function CountCompSubmit(){

        $sql = "SELECT * FROM `fiction` WHERE `resource` = 1 AND `resource_date` > 0";
        $query = mysql_query($sql, $this->link);

        return mysql_num_rows($query);

    }

    function FicBox($bhg_id){

        $sql = "SELECT * FROM `fiction` WHERE `bhg_id` = $bhg_id";
        $query = mysql_query($sql, $this->link);

        $return = "<select size=\"1\" name=\"article\">";

        while ($info = mysql_fetch_array($query)){

        $return .= "<option value=\""
             .$info['id']
             ."\">"
             .$info['title']
             ."</option>";

        }

        $return .= "</select>";

        return $return;

    }

    function Resource(){

        $sql = "SELECT * FROM `resource`";
        $query = mysql_query($sql, $this->link);

        $return = "<select size=\"1\" name=\"resource\">";

        while ($info = mysql_fetch_array($query)){

        $return .= "<option value=\""
             .$info['id']
             ."\">"
             .$info['name']
             ."</option>";

        }

        $return .= "</select>";

        return $return;

    }

    function AdminBox(){

        $return = "<select size=\"1\" name=\"op\">";
        $return .= "<option value=\"edit\">Edit Fiction</option>"
                .  "<option value=\"add\">Add New Fiction</option>"
                .  "<option value=0></option>"
                .  "<option value=\"special\">Submit for Competition</option>"
                .  "</select>";

        return $return;

    }

    function CountPosters(){

        $search = new Search();
        $base = $search->AllPosters();
        $return = count($base);

        return $return;

    }

    function Copyright(){
        return "Fiction Archive Code © 2003-2004 <a href=\"mailto:TheCapn@capncommonsense.com\">Ric Gravant</a><br />".
               "Layout © <a href=\"mailto:kal-ket@earthlink.net\">Baron Kal-Ket</a><br /><br />Report all bugs to ".
               "<a href=\"mailto:TheCapn@capncommonsense.com?subject='Fiction Archive Error'\">Ric Gravant</a>".
               "<br /><br />This site conforms to the Emperors Hammer ".
               "<a href=\"http://www.emperorshammer.org/privacy.htm\">Privacy Policy</a> and ".
               "<a href=\"http://www.emperorshammer.org/irc.htm\">Codes of Conduct</a>.";
    }
}

?>
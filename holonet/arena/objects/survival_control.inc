<?

 Class SurvivalControl extends Survival {

    function SurvivalControl(){
        Arena::Arena();
    }

    function New_Contract($bhg_id, $type){

	    $solo = new Survival();
	    
        $sql = "INSERT INTO `arena_survival_contracts` (`type`, `bhg_id`, `ranger`) VALUES ('$type', '$bhg_id', '".$solo->CurrentRanger()."')";

        if (mysql_query($sql, $this->connect)) {

            $id = mysql_insert_id($this->connect);

            $solo->NotifyRanger();

           return $id;
        } else {
           return false;
        }

    }
    
    function NewContract($bhg_id, $type){
        $sql = "INSERT INTO `arena_survival_request` (`type`, `bhg_id`) VALUES ('$type', '$bhg_id')";

        if (mysql_query($sql, $this->connect)) {
           return true;
        } else {
           return false;
        }

    }
    
    function Deny($bhg_id, $type){
        $sql = "DELETE FROM `arena_survival_request` WHERE `type` = '$type' AND `bhg_id` = '$bhg_id'";
        
        if (mysql_query($sql, $this->connect)) {
           return true;
        } else {
           return false;
        }
    }

 }

?>
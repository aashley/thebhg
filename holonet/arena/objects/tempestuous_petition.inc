<?

 Class Petition extends Tempy {

    var $tempy_id;
    var $tempy_bhg_id;
    var $tempy_mod;
    var $tempy_reason;
    var $tempy_juror1;
    var $tempy_juror2;
    var $tempy_juror3;
    var $tempy_juror4;
    var $tempy_approved;
    var $tempy_started;
    var $tempy_date_deleted;
    var $tempy_complete;
    var $tempy_fiction1;
    var $tempy_fiction2;
    var $tempy_fiction3;
    var $tempy_arena1;
    var $tempy_arena2;
    var $tempy_runon;
    

    function Petition($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_tempy_jury` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'tempy_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function Approve($bhg_id) {
        $sql = "UPDATE `arena_tempy_jury` SET `approved` = '1', `mod` = '$bhg_id' WHERE `id` = '".$this->tempy_id."'";

        if (mysql_query($sql, $this->connect)) {
	        
            $person = new Person($this->tempy_bhg_id);

            $text = $person->GetName().", your petition to the Tempestuous Group has been approved. Please wait while a jury is compiled.";           

            $from = "Tempestuous Group <overseer@thebhg.org>";
            $subject = "Petition Approved";

            $person->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }

    }

    function Deny() {
        $sql = "UPDATE `arena_tempy_jury` SET `date_deleted` = '1' WHERE `id` = '".$this->tempy_id."'";

        if (mysql_query($sql, $this->connect)) {

            $person = new Person($this->tempy_bhg_id);

            $text = $person->GetName().", your petition to the Tempestuous Group was denied.";

            $from = "Tempestuous Group <overseer@thebhg.org>";
            $subject = "Petition Denined";

            $person->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }

    }

    function Remove() {
        $sql = "UPDATE `arena_tempy_jury` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->tempy_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }
    
    function SolidifyJury(){
	    $sql = "UPDATE `arena_tempy_jury` SET `started` = '".time()."' WHERE `id` = '".$this->tempy_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
            
            $juror1 = new Person($this->tempy_juror1);
		    $juror2 = new Person($this->tempy_juror2);
		    $juror3 = new Person($this->tempy_juror3);
		    $juror4 = new Person($this->tempy_juror4);
		    $mod = new Person($this->tempy_mod);
		    $person = new Person($this->tempy_bhg_id);
		    
		    $from = "Tempestuous Group <overseer@thebhg.org>";
	        $subject = "Jury Chosen";
		    
		    $text = $person->GetName().", your jury for admission to the Tempestuous Board has been chosen. On the Arena Holonet, you will now "
		    		."see an option where you can submit the links for your works of Fiction, your Arena Matches, and your Run-On. Please contant "
		    		."the overseer if you can not.";
	
	        $person->SendEmail($from, $subject, $text);
	        $mod->SendEmail($from, $subject, $text);
	        
	        $text = "You have been chosen as a Jury Member for ".$person->GetName()."'s application and your position is solidifed. You will receive notification once"
	        		." the applicant has entered the required information for you to review.";
	        		
	        $juror1->SendEmail($from, $subject, $text);
	        $juror2->SendEmail($from, $subject, $text);
	        $juror3->SendEmail($from, $subject, $text);
	        $juror4->SendEmail($from, $subject, $text);
	        
	        return true;

        } else {

            return false;

        }

    }
    
    function Signup($bhg_id){	    
	    $sql = "UPDATE `arena_tempy_jury` SET ";
	    $mail = false;
	    
	    if ($this->tempy_juror1){
		    if ($this->tempy_juror2){
			    if ($this->tempy_juror3){
				    if ($this->tempy_juror4){
				    	return false;
				    } else {
					    $sql .= "`juror4`";
					    $place = "4th";
					    $mail = true;
			    	}
			    } else {
				    $sql .= "`juror3`";
				    $place = "3rd";
			    }
		    } else {
			    $sql .= "`juror2`";
			    $place = "2nd";
		    }
	    } else {
		    $sql .= "`juror1`";
		    $place = "1st";
	    }
	    
	    $sql .= " = '$bhg_id' WHERE `id` = '".$this->tempy_id."'";
	    
	    if (mysql_query($sql, $this->connect)){

            return true;

        } else {

            return false;

        }
        
    }	
    
    function RemoveSignup($bhg_id){   	    
	    $sql = "UPDATE `arena_tempy_jury` SET ";
	    
	    if ($this->tempy_juror1 == $bhg_id){
		    $sql .= "`juror1`";
		    $place = "1st";
	    } elseif ($this->tempy_juror2 == $bhg_id){
		    $sql .= "`juror2`";
			$place = "2nd";
		} elseif ($this->tempy_juror3 == $bhg_id){
		    $sql .= "`juror3`";
		    $place = "3rd";
		} elseif ($this->tempy_juror4 == $bhg_id){
		    $sql .= "`juror4`";
		    $place = "4th";
	    } else {
		    return false;
	    }
	    
	    $sql .= " = '0' WHERE `id` = '".$this->tempy_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    $person = new Person($bhg_id);
		    
		    $text = $person->GetName().", you have been taken off a jury.";
		    
		    $from = "Tempestuous Group <overseer@thebhg.org>";
            $subject = "Removed as Juror";

            $person->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }
        
    }	        
    
    function Solidified(){
	    if ($this->tempy_started){
		    return true;
    	} else {
		    return false;
	    }
    }
    
    function SetWorks($fic1, $fic2, $fic3, $arena1, $arena2, $runon){
	    $sql = "UPDATE `arena_tempy_jury` SET "
	    		."`fiction1` = '$fic1', "
	    		."`fiction2` = '$fic2', "
	    		."`fiction3` = '$fic3', "
	    		."`arena1` = '$arena1', "
	    		."`arena2` = '$arena2', "
	    		."`runon` = '$runon' "
	    		."WHERE `id` = '".$this->tempy_id."'";
	    		
	    if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }
    }
    
    function AllWorks(){
	    if ($this->tempy_fiction1){
		    if ($this->tempy_fiction2){
			    if ($this->tempy_fiction3){
				    if ($this->tempy_arena1){
					    if ($this->tempy_arena2){
						    if ($this->tempy_runon){
		   						$juror1 = new Person($this->tempy_juror1);
							    $juror2 = new Person($this->tempy_juror2);
							    $juror3 = new Person($this->tempy_juror3);
							    $juror4 = new Person($this->tempy_juror4);
							    $mod = new Person($this->tempy_mod);
							    $person = new Person($this->tempy_bhg_id);
							    
							    $from = "Tempestuous Group <overseer@thebhg.org>";
						        $subject = "Works Submitted";
							    
							    $text = $person->GetName().", has submitted the required works for review. Jury members, please go to the Holonet. You "
							    		."will see an option where you review these works and then vote to either admit or deny the applicant. Should "
							    		."there be a tie, the presiding moderator, ".$mod->GetName(). " will cast the final vote.";
						
						        $person->SendEmail($from, $subject, $text);
						        $mod->SendEmail($from, $subject, $text);						        		
						        $juror1->SendEmail($from, $subject, $text);
						        $juror2->SendEmail($from, $subject, $text);
						        $juror3->SendEmail($from, $subject, $text);
						        $juror4->SendEmail($from, $subject, $text);
						        
						        return true;
						   	} else {
		   						return false;
	   						}
   						} else {
						    return false;
					    }
				   	} else {
					    return false;
				    }
			    } else {
				    return false;
			    }
		    } else {
			    return false;
		    }
	    } else {
		    return false;
	    }      	
    }
	
    function Vote($juror_id, $approved, $comments){
	    $sql = "INSERT INTO `arena_tempy_voting` (`juror`, `petition_id`, `approved`, `comment`) VALUES ('$juror_id', '".$this->tempy_id.
	    		"', '$approved', '".addslashes($comments)."')";
	    
	    if (mysql_query($sql, $this->connect)) {

		    $this->Check();
		    
            return true;

        } else {

            return false;

        }
    }
    
    function Complete(){
    	$sql = "UPDATE `arena_tempy_jury` SET `complete` = '0' WHERE `id` = '".$this->tempy_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }
    }
    
    function Admitted(){
	    $tempy = new Tempy();
	    
	    if ($tempy->InsertMember($this->tempy_bhg_id)){
		    
		    $juror1 = new Person($this->tempy_juror1);
		    $juror2 = new Person($this->tempy_juror2);
		    $juror3 = new Person($this->tempy_juror3);
		    $juror4 = new Person($this->tempy_juror4);
		    $person = new Person($this->tempy_bhg_id);
		    
		    $from = "Tempestuous Group <overseer@thebhg.org>";
	        $subject = "New Tempestuous Member";
		    
		    $text = $person->GetName().", your jury has spoken. Congratulations, you are the newest member of the Tempestuous Group. You may now"
		   			." post in the next Tempestuous Run-On, should you so desire.";
	
	        $person->SendEmail($from, $subject, $text);
	        
	        $text = "The application has been processed and your valued services are no longer required. Thank you for your work.";
	        		
	        $juror1->SendEmail($from, $subject, $text);
	        $juror2->SendEmail($from, $subject, $text);
	        $juror3->SendEmail($from, $subject, $text);
	        $juror4->SendEmail($from, $subject, $text);
	        
	        $this->Complete();
	        
        }
        
    }
    
    function NotAdmitted(){
		    
	    $juror1 = new Person($this->tempy_juror1);
	    $juror2 = new Person($this->tempy_juror2);
	    $juror3 = new Person($this->tempy_juror3);
	    $juror4 = new Person($this->tempy_juror4);
	    $person = new Person($this->tempy_bhg_id);
	    
	    $from = "Tempestuous Group <overseer@thebhg.org>";
        $subject = "Application Rejected";
	    
	    $text = $person->GetName().", your jury has spoken. Your application to the Tempestuous Group has been denyed by your jury. Thank you for your"
	    		." interest.";

        $person->SendEmail($from, $subject, $text);
        
        $text = "The application has been processed and your valued services are no longer required. Thank you for your work.";
        		
        $juror1->SendEmail($from, $subject, $text);
        $juror2->SendEmail($from, $subject, $text);
        $juror3->SendEmail($from, $subject, $text);
        $juror4->SendEmail($from, $subject, $text);
        
        $this->Complete();
        
    } 
    
    function NotifyMod(){		    
	    $person = new Person($this->tempy_mod);

		$text = "A jury has tied in their votes. Please go to the Arena Holonet to cast a deciding vote. Thank you.";

        $from = "Tempestuous Group <overseer@thebhg.org>";
        $subject = "Moderator Vote Required";

        $person->SendEmail($from, $subject, $text);    
    }
    
    function Check(){
	    if ($this->VotedIn()){		    
		    $this->Admitted();
	    } elseif ($this->Denied()){
		    $this->NotAdmitted();
	    } elseif ($this->RequireMod()){
		    $this->NotifyMod();
	    }   
    }
    
    function Votes(){
	    $sql = "SELECT * FROM `arena_tempy_voting` WHERE `petition_id` = '".$this->tempy_id."' AND `approved` = 1";
	    $query = mysql_query($sql, $this->connect);
	    
	    return mysql_num_rows($query);
    }
    
    function VotedIn(){
	    $sql = "SELECT * FROM `arena_tempy_voting` WHERE `petition_id` = '".$this->tempy_id."' AND `approved` = 1";
	    $query = mysql_query($sql, $this->connect);
	    
	    return (mysql_num_rows($query) >= 3);
    }
    
    function CanVote($juror_id){	    
	    if ($juror_id == 5){
		    if ($this->RequireMod()){
			    return true;
		    } else {
			    return false;
		    }
	    }
	    
	    $sql = "SELECT * FROM `arena_tempy_voting` WHERE `petition_id` = '".$this->tempy_id."' AND `juror` = '$juror_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    return (mysql_num_rows($query) == 0);
    }
    
    function RequireMod(){
	    $sql = "SELECT * FROM `arena_tempy_voting` WHERE `petition_id` = '".$this->tempy_id."' AND `approved` = 1";
	    $query = mysql_query($sql, $this->connect);
	    
	    if ((mysql_num_rows($query) == 2) && ($this->TotalVotes == 4)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function Denied(){
	    $sql = "SELECT * FROM `arena_tempy_voting` WHERE `petition_id` = '".$this->tempy_id."' AND `approved` = 1";
	    $query = mysql_query($sql, $this->connect);
	    
	    if ((mysql_num_rows($query) < 3) && ($this->TotalVotes >= 4)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function TotalVotes(){
	    $sql = "SELECT * FROM `arena_tempy_voting` WHERE `petition_id` = '".$this->tempy_id."'";
	    $query = mysql_query($sql, $this->connect);
	    
	    return mysql_num_rows($query);
    }
    
    function GetFiction($id, $nolink = 0){
	    $fictions = array('1'=>$this->tempy_fiction1, '2'=>$this->tempy_fiction2, '3'=>$this->tempy_fiction3);

	    $fiction = $fictions[$id];
	    
	    if ($nolink){
		    return $fiction;
	    } else {
	    	return "http://fiction.thebhg.org/index.php?page=fiction&id=".$fiction;
    	}
    }
	
    function GetArena($id, $nolink = 0){
	    $matches = array('1'=>$this->tempy_arena1, '2'=>$this->tempy_arena2);

	    $arena = $matches[$id];
	    
	    if ($nolink){
		    return $arena;
	    } else {
		    return "http://boards.thebhg.org/index.php?op=view&topic=".$arena;
	    }
    }
    
    function GetRO($nolink = 0){	
	    if ($nolink){
		    return $this->tempy_runon;
	    } else {    
	    	return "http://boards.thebhg.org/index.php?op=view&topic=".$this->tempy_runon;
    	}
    }
	    
    function GetID() {
        return $this->tempy_id;
    }
    
    function GetApplicant(){
	    return new Person($this->tempy_bhg_id);
    }
    
    function GetReason(){
	    return stripslashes($this->tempy_reason);
    }

    function GetStatus() {
        if ($this->tempy_date_deleted == 1){
            return "Denyed";
        } elseif ($this->tempy_approved){
		        return "Approved";
        } else {
            return "Pending Approval";
        }
    }
    
    function CanRemove() {
	    return ($this->tempy_started == 0);
    }

    function GetStart() {
        $date = getdate($this->tempy_started);
        return $date['month']." ".$date['mday'].", ".$date['year'];
    }

    function GetEnd() {
        if ($this->tempy_complete){
            $date = getdate($this->tempy_complete);
            return $date['month']." ".$date['mday'].", ".$date['year'];
        } else {
            return "<b>Pending</b>";
        }
    }
    
    function Jurors(){
	    return array('1'=>$this->tempy_juror1, '2'=>$this->tempy_juror2, '3'=>$this->tempy_juror3, '4'=>$this->tempy_juror4);
    }
    
    function Juror($id){
	    $opps = $this->Jurors();
	    return new Person($opps[$id]);
    }
    
    function JurorID($bhg_id){    
	    if ($bhg_id == $this->tempy_mod){
		    return 5;
	    }
	    
	    foreach ($this->Jurors() as $return=>$id){
		    if ($id == $bhg_id){
			    return $return;
		    }
	    }
    }

    function Undelete() {
        $sql = "UPDATE `arena_tempy_jury` SET `date_deleted` = '0' WHERE `id` = '".$this->tempy_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

 }

?>
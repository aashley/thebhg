<?

 Class Challenge extends TTG {

    var $ttg_id;
    var $ttg_bhg_id;
    var $ttg_match_id1;
    var $ttg_match_id2;
    var $ttg_match_id3;
    var $ttg_c1;
    var $ttg_c2;
    var $ttg_c3;
    var $ttg_approved;
    var $ttg_date_deleted;
    var $ttg_started;
    var $ttg_completed;
    var $ttg_last_challenger;
    var $ttg_final_match;
    var $ttg_final_challenger;
    var $ttg_win;

    function Challenge($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_ttg_queue` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'ttg_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function Approve() {
        $sql = "UPDATE `arena_ttg_queue` SET `approved` = '1' WHERE `id` = '".$this->ttg_id."'";

        if (mysql_query($sql, $this->connect)) {
	        
            $person = new Person($this->ttg_bhg_id);
            $adjunct = $this->Adjunct();
            $overseer = $this->Overseer();

            $text = $person->GetName().", your challenge to the Twilight Gauntlet has been approved by the Overseer. You will be notified once your "
            		."opponent's have signed up to face you. You will be notified when a challenger signs up to face you and then finally when your "
            		."match is ready.";

            $text .= "\n\nGood luck. You will need it."
                    ."\n\n-The Overseer, ".$overseer->GetName();

            $from = "Twilight Gauntlet <overseer@thebhg.org>";
            $subject = "Gauntlet Approved";

            $person->SendEmail($from, $subject, $text);
            $adjunct->SendEmail($from, $subject, $text);
            $overseer->SendEmail($from, $subject, $text);
            
            $text = $person->GetName().' has challenged the Gauntlet. Go and defend yourselves. Sign up to challenge via the Holonet in admin.';
            
            $tg = new TTG():
            $subject = "New Gauntlet Challenger";
            
            foreach ($ttg->GetMembers(1) as $member){
	            $member->SendEmail($from, $subject, $text);
            }

            return true;

        } else {

            return false;

        }

    }

    function Deny() {
        $sql = "UPDATE `arena_ttg_queue` SET `date_deleted` = '1' WHERE `id` = '".$this->ttg_id."'";

        if (mysql_query($sql, $this->connect)) {

            $person = new Person($this->ttg_bhg_id);

            $text = $person->GetName().", your challenge to the Twilight Gauntlet has been denied.";

            $from = "Twilight Gauntlet <overseer@thebhg.org>";
            $subject = "Gauntlet Denined";

            $person->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }

    }

    function Remove() {
        $sql = "UPDATE `arena_ttg_queue` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->ttg_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }
    
    function ThrowDown($bhg_id){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `id` = '".$this->ttg_id."'";
	    $query = mysql_query($sql, $this->connect);
	    $info = mysql_fetch_array($query);
	    
	    $sql = "UPDATE `arena_ttg_queue` SET ";
	    
	    if ($info['c1']){
		    if ($info['c2']){
			    if ($info['c3']){
				    return false;
			    } else {
				    $sql .= "`c3`";
				    $place = "3rd";
			    }
		    } else {
			    $sql .= "`c2`";
			    $place = "2nd";
		    }
	    } else {
		    $sql .= "`c1`";
		    $place = "1st";
	    }
	    
	    $sql .= " = '$bhg_id' WHERE `id` = '".$this->ttg_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    $person = new Person($this->ttg_bhg_id);
		    $challenger = new Person($bhg_id);
		    
		    $text = $person->GetName().", your $place challenger has been chosen. ".$challenger->GetName()." has taken up your challenge and will meet "
		    ."you on the field of battle as soon as ";
		    
		    if ($place == "3rd"){
			    $text .= "the Overseer has prepared the match against your first challenger.";
		    } else {
			    $text .= "the remainder of your challengers have been chosen.";
		    }
		    
		    $from = "Twilight Gauntlet <overseer@thebhg.org>";
            $subject = "Gauntlet Challenger Chosen";

            $person->SendEmail($from, $subject, $text);
            $challenger->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }
        
    }	
    
    function PickUp($bhg_id){   
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `id` = '".$this->ttg_id."'";
	    $query = mysql_query($sql, $this->connect);
	    $info = mysql_fetch_array($query);
	    
	    $sql = "UPDATE `arena_ttg_queue` SET ";
	    
	    if ($info['c1'] == $bhg_id){
		    $sql .= "`c1`";
		    $place = "1st";
	    } elseif ($info['c2'] == $bhg_id){
		    $sql .= "`c2`";
			$place = "2nd";
		} elseif ($info['c3'] == $bhg_id){
		    $sql .= "`c3`";
		    $place = "3rd";
	    } else {
		    return false;
	    }
	    
	    $sql .= " = '0' WHERE `id` = '".$this->ttg_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    $person = new Person($this->ttg_bhg_id);
		    $challenger = new Person($bhg_id);
		    
		    $text = $person->GetName().", your $place challenger, ".$challenger->GetName()." has retracted his place as your challenger.";
		    
		    $from = "Twilight Gauntlet <overseer@thebhg.org>";
            $subject = "Gauntlet Challenger Removed";

            $person->SendEmail($from, $subject, $text);
            $challenger->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }
        
    }	        
    
    function CurrentChallenger(){
	    if ($this->ttg_last_challenger < 3){
		    return $this->ttg_last_challenger+1;
	    } else {
		    return 3;
	    }
    }
    
    function CanChallenge(){
	    if ($this->ttg_c1){
		    if ($this->ttg_c2){
			    if ($this->ttg_c3){
				    return false;
			    } else {
				    return true;
			    }
		    } else {
			    return true;
		    }
	    } else {
			return true;
	    }
    }
    
    function CanStart(){
	    if ($this->ttg_c1){
		    if ($this->ttg_c2){
			    if ($this->ttg_c3){
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
    }

    function GetID() {
        return $this->ttg_id;
    }
    
    function GetChallenger(){
	    return new Person($this->ttg_bhg_id);
    }

    function GetStatus() {
        if ($this->ttg_date_deleted == 1){
            return "Denyed";
        } elseif ($this->ttg_approved){
	        if ($this->ttg_started){
		        return "Started";
	        } else {
		        return "Approved";
	        }
        } else {
            return "Pending Approval";
        }
    }
    
    function CanRemove() {
	    return ($this->ttg_started == 0);
    }

    function GetStart() {
        $date = getdate($this->ttg_started);
        return $date['month']." ".$date['mday'].", ".$date['year'];
    }

    function GetEnd() {
        if ($this->ttg_completed){
            $date = getdate($this->ttg_completed);
            return $date['month']." ".$date['mday'].", ".$date['year'];
        } else {
            return "<b>Pending</b>";
        }
    }
    
    function NextRound(){
	    if ($this->ttg_last_challenger == 0){
		    return 2;
	    } elseif ($this->ttg_last_challenger == 1){
		    return 3;
	    }
    }

    function GetMatch($id = 0) {
	    
	    if ($id == 0){
		    if ($this->ttg_match_id3){
			    $id = 3;
		    } elseif ($this->ttg_match_id2){
			    $id = 2;
		    } elseif ($this->ttg_match_id1){
			    $id = 1;
		    } else {
			    return false;
		    }
	    }
	    
	    if ($id == 1){
		    $match = $this->ttg_match_id1;
	    } elseif ($id == 2){
		    $match = $this->ttg_match_id2;
	    } elseif ($id == 3){
		    $match = $this->ttg_match_id3;
	    } else {
		    return false;
	    }
        return new Match($match);
    }
    
    function Opponents(){
	    return array('1'=>$this->ttg_c1, '2'=>$this->ttg_c2, '3'=>$this->ttg_c3);
    }
    
    function Opponent($id){
	    $opps = $this->Opponents();
	    return new Person($opps[$id]);
    }
    
    function FinalOutcome(){
	    return $this->ttg_win;
    }
    
    function FinalChallenger(){
	    return $this->ttg_final_challenger;
    }
    
    function FinalMatch(){
	    return new Match($this->ttg_final_match);
    }

    function StartChallenge($id) {
        $sql = "UPDATE `arena_ttg_queue` SET `match_id1` = '$id', `started` = ".time()." WHERE `id` = '".$this->ttg_id."'";

        if (mysql_query($sql, $this->connect)) {
 			$person = new Person($this->ttg_bhg_id);
 			$challenger = new Person($this->Opponent($this->CurrentChallenger()));
 			$match = $this->GetMatch(1);

            $text = $person->GetName().", your first Twilight Gauntlet match has been posted.\n\n".$match->RawLink();

            $from = "Twilight Gauntlet <overseer@thebhg.org>";
            $subject = "Your gauntlet has begun!";

            $person->SendEmail($from, $subject, $text);
	        $challenger->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }

    }
    
    function Notify($id) {
	    $match = $this->GetMatch($id);
		$person = new Person($this->ttg_bhg_id);
		$challenger = new Person($this->Opponent($this->CurrentChallenger()));

        $text = $person->GetName().", a Twilight Gauntlet match has been posted.\n\n".$match->RawLink();

        $from = "Twilight Gauntlet <overseer@thebhg.org>";
        $subject = "Twilight Match Posted";

        $person->SendEmail($from, $subject, $text);
 		$challenger->SendEmail($from, $subject, $text);
    }
    
    function FinalChallenge($id, $bhg_id) {
        $sql = "UPDATE `arena_ttg_queue` SET `final_match` = '$id', `final_challenger` = '$bhg_id', `completed` = 0 WHERE `id` = '".$this->ttg_id."'";

        if (mysql_query($sql, $this->connect)) {
 			$person = new Person($this->ttg_bhg_id);
 			$challenger = new Person($bhg_id);

            $text = $challenger->GetName().", your spot in the Twilight Gauntlet has been challenged by ".$person->GetName().". Soon, the final arena "
            		." match will be posted for the climatic battle. You will be notified by the Overseer when this battle is up. ";

            $from = "Twilight Gauntlet <overseer@thebhg.org>";
            $subject = "Your seat in the Gauntlet has been Challenged!";

            $person->SendEmail($from, $subject, $text);
	        $challenger->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }

    }
    
    function Complete(){
	    $sql = "UPDATE `arena_ttg_queue` SET `completed` = ".time()." WHERE `id` = '".$this->ttg_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }
    }
    
    function FinalUp() {
		$person = new Person($this->ttg_bhg_id);
		$challenger = new Person($this->FinalChallenger());
		$match = $this->FinalMatch();

        $text = "Your final Twilight Gauntlet match is up, ".$person->GetName().". You will challenge your opponent, ".$challenger->GetName()." for "
        		."their spot in the Twilight Gauntlet. Best of luck to both of you, and may the best hunter win.\n\n".$match->RawLink();

        $from = "Twilight Gauntlet <overseer@thebhg.org>";
        $subject = "Final Match Posted";

        $person->SendEmail($from, $subject, $text);
        $challenger->SendEmail($from, $subject, $text);
    }
    
    function Progress($id, $mbid) {
	    $insert = '`match_id'.$id.'` = '.$mbid;
	    $sql = "UPDATE `arena_ttg_queue` SET `last_challenger` = '".$this->CurrentChallenger()."', $insert WHERE `id` = '".$this->ttg_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;
            $this->Notify($id);

        } else {

            return false;

        }
    }
    
    function DeclareWin(){
	    $sql = "UPDATE `arena_ttg_queue` SET `completed` = 1, `last_challenger` = '".$this->CurrentChallenger()."' WHERE `id` = '".$this->ttg_id."'";

        if (mysql_query($sql, $this->connect)) {
	        $person = new Person($this->ttg_bhg_id);

            $text = $person->GetName().", congratulations. You have successfully won your Gauntlet Run! You have earned the right to challenge any "
            		."Gauntlet Member for their spot on the Twilight Gauntlet. Please go to the Arena section of the Holonet and click on Admin. There,"
            		." you will find a link for you to use to choose the member of the Twilight Gauntlet that you wish to challenge to a final duel. "
            		."Good luck in your last match, and once again, congratulations!\n\n";

            $from = "Twilight Gauntlet <overseer@thebhg.org>";
            $subject = "You have completed the Gauntlet Run!";

            $person->SendEmail($from, $subject, $text);
	        
            return true;

        } else {

            return false;

        }
    }
    
    function EndGauntlet() {
        $sql = "UPDATE `arena_ttg_queue` SET `completed` = '".time()."' WHERE `id` = '".$this->ttg_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

    function Undelete() {
        $sql = "UPDATE `arena_ttg_queue` SET `date_deleted` = '0' WHERE `id` = '".$this->ttg_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

 }

?>
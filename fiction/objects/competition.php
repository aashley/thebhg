<?php

class Competition extends Fiction {

	var $id;
	var $library;
	var $pack;
	var $description;
	var $starts;
	var $ends;
	var $auto;
	var $graded;
	var $date_deleted;
	var $table;
	
	function Competition($id){
		Fiction::Fiction();
		
		$this->table = 'competitions';
		
		$sql = "SELECT * FROM `".$this->table."` WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		while ($info = mysql_fetch_assoc($query)){
			foreach ($info as $name=>$value){
				$this->$name = stripslashes($value);
			}
		}
	}
	
	function GetID(){
		return $this->id;
	}
	
	function GetLibrary(){
		return new Library($this->library);
	}
	
	function AutoAward(){
		return ($this->auto == 1);
	}
	
	function GetPack(){
		return new CompPack($this->pack);
	}
	
	function GetDescription($format = true){
		return ($format ? nl2br($this->description) : $this->description);
	}
	
	function Starts($format = false){
		return ($format ? date('j F Y \a\t G:i:s T', $this->starts) : $this->starts);
	}
	
	function Ends($format = false){
		return ($format ? date('j F Y \a\t G:i:s T', $this->ends) : $this->ends);
	}
	
	function Graded(){
		return ($this->graded == 1);
	}
	
	function DateDeleted(){
		return $this->date_deleted;
	}
	
	function BooBoo($id){
		$sql = "SELECT * FROM `competition_grades` WHERE `grader` = '$id' AND `competition` = '".$this->id."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return unserialize(stripslashes($info['smatter']));
	}
	
	function PercentGraded(){
		$sql = "SELECT * FROM `competition_grades` WHERE `partial` = 0 AND `competition` = '".$this->id."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$num = mysql_num_rows($query);

		$sql = "SELECT * FROM `library_admin` WHERE `competitions` = 1 AND `date_deleted` = 0 AND `library` = '".$this->library."'";
		$query = mysql_query($sql, $this->connect);
		$grad = mysql_num_rows($query);
		
		if ($grad <= 0){
			$grad = 1;
		}

		return (100*round(($num/$grad), 2)).'% of the graders reporting. ('.$num.'/'.$grad.')';
	}
	
	function CanGrade($id = 0){
		if (!$this->Graded() && $this->Ends() <= time()){
			if ($id){
				$sql = "SELECT * FROM `competition_grades` WHERE `competition` = '".$this->id."' AND `grader` = '$id' AND `date_deleted` = 0";
				$query = mysql_query($sql, $this->connect);

				if (mysql_num_rows($query)){
					return false;
				}
				return true;
			} else {
				return true;
			}
		}
		return false;
	}
	
	function del($del){
		if (!($del === 0)){
			$del = time();
		}
		$sql = "UPDATE `".$this->table."` SET `date_deleted` = '".$del."' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		return ($query ? true : false);
	}
	
	function Edit($library, $pack, $description, $starts, $ends, $graded){		
		$sql = "UPDATE `".$this->table."` SET `library` = '$library', `description` = '"
		.addslashes($description)."', `pack` = '$pack', `starts` = '$starts', `ends` = '$ends' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function Grade($de = false){
		$sql = "UPDATE `".$this->table."` SET `graded` = '".($de ? 0 : 1)."' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		$subs = $this->GetSubmissions();
		$awards = array('1'=>40000, '2'=>50000, '3'=>40000);
				
		foreach ($subs as $id=>$pts){
			$fic = $pts['fic'];
			$fic->Publish();
		}
		
		return ($query ? true : false);
	}
	
	function GradeComp($grade, $whois){
		$return = array();
		$total = 0;
		$errors = 0;
		
		$sql = "SELECT * FROM `competition_grades` WHERE `competition` = '".$this->id."' AND `grader` = '$whois' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		if (mysql_num_rows($query)){
			$info = mysql_fetch_assoc($query);
			$sma = unserialize(stripslashes($info['smatter']));
			$sql = "UPDATE `competition_grades` SET `date_deleted` = '".time()."' WHERE `competition` = '".$this->id."' AND `grader` = '$whois' AND `date_deleted` = 0";
			mysql_query($sql, $this->connect);
		}		
		$partial = 0;
		foreach ($grade as $gui=>$hunt){
			$total += $gui;
			foreach ($hunt as $id=>$pt){
				foreach ($pt as $pts){
					if (strlen($pts) == 0 && !$partial){
						$partial = 1;		
					}
					if ($pts > $gui){
						$pts = $gui;
					}
					$return[$id] += $pts;
				}
			}
		}
		
		if (is_array($sma)){
			foreach ($sma as $gui=>$hunt){
				foreach ($hunt as $id=>$pt){
					foreach ($pt as $pts){
						$return[$id] -= $pts;
					}
				}
			}
		}

		arsort($return);
		
		$i = 1;
		foreach ($return as $id=>$pts){
			$fic = $this->GetFiction($id);
			$sql = "UPDATE `competition_results` SET `score` = (`score` + '$pts') WHERE `fiction` = '$id' AND `competition` = '".
				$this->id."'";
			$query = mysql_query($sql, $this->connect);

			$errors += ($query ? 0 : 1);
			$i++;
		}
		
		$this->ReRank();
		
		if (!$errors){
			$sql = "INSERT INTO `competition_grades` (`competition`, `grader`, `partial`, `smatter`) VALUES ('".$this->id."', '$whois', '$partial', '".addslashes(serialize($grade))."')";
			mysql_query($sql, $this->connect);
		}
		
		return ($errors ? false : true);
	}
	
	function ReRank(){
		$sql = "SELECT * FROM `competition_results` WHERE `competition` = '".$this->GetID()."' AND `date_deleted` = 0 ORDER BY `score` DESC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		$i = 1;
		while ($info = mysql_fetch_array($query)){
			$sql = "UPDATE `competition_results` SET `rank` = '$i' WHERE `id` = '".$info['id']."'";
			mysql_query($sql, $this->connect);
			$i++;
		}
	}
	
	function GetCompetitions(){
		$sql = "SELECT `id` FROM `competitions` WHERE `library` = '".$this->GetID()."' AND `date_deleted` = 0 AND ".
			"`starts` <= '".time()."' AND `ends` >= '".time()."' AND `graded` = 0";
		$query = mysql_query($sql, $this->connect);
		while ($info = mysql_fetch_assoc($query)){
			$return[] = $this->GetComp($info['id']);
		}
		
		return $return;
	}
	
	function CanSubmit($bhg_id){
		$comp = $this->id;
		$sql = "SELECT `fiction`, `id` FROM `competition_results` WHERE `bhg_id` = '$bhg_id' AND `competition` = '$comp' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);

		return (mysql_num_rows($query) ? false : true);
	}
		
	function Submit($bhg_id, $fiction_id){
		$comp = $this->id;		
		
		$sql = "INSERT INTO `competition_results` (`bhg_id`, `competition`, `fiction`, `date`) VALUES ('$bhg_id', '".
			"$comp', '$fiction_id', '".time()."')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? mysql_insert_id($this->connect) : false);
	}
	
	function GetSubmissions(){
		$sql = "SELECT * FROM `competition_results` WHERE `competition` = '".$this->GetID()."' AND `date_deleted` = 0 ORDER BY `rank` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$fc = $this->GetFiction($info['fiction']);
			if (!$fc->DateDeleted()){
				$return[$info['id']] = array('fic'=>$fc, 'score'=>$info['score'], 'date'=>$info['date'], 
					'datefrmt'=>date('j F Y \a\t G:i:s T', $info['date']), 'rank'=>$info['rank']);
			}
		}
		
		return $return;
	}
}
?>
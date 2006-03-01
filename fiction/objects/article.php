<?php

class Article extends Fiction {

	var $id;
	var $title;
	var $date;
	var $bhg_id;
	var $fiction;
	var $library;
	var $date_deleted;
	var $table;
	
	function Article($id){
		Fiction::Fiction();
		
		$this->table = 'fiction';
		
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
	
	function View($ip){
		$time = time()-(3600*24);
		$sql = "SELECT * FROM `views` WHERE `fiction` = '".$this->id."' AND `date` > '$time' AND `ip_addy` = '$ip'";
		$query = mysql_query($sql, $this->connect);
		if (mysql_num_rows($query)){
			return false;
		}
		
		$sql = "INSERT INTO `views` (`fiction`, `ip_addy`, `date`) VALUES ('".$this->id."', '$ip', '".time()."')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
		
	function GetTitle(){
		return $this->title;
	}
	
	function GetFiction($format = true){
		return ($format ? nl2br(str_replace(array('[*', '*]', '&IND*'), array('<', '>', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'), str_replace(array('<', '>'), array('&lt;', '&gt;'), $this->fiction))) : $this->fiction);
	}
	
	function GetCount(){
		return nl2br(str_replace(array('[*', '*]', '&IND*'), array('<', '>', ''), $this->fiction));
	}
	
	function GradeBrakedown(){
		$sql = "SELECT * FROM `competition_results` WHERE `fiction` = '".$this->id."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		$comp = new Competition($info['competition']);
		$pack = $comp->GetPack();
		
		$sql = "SELECT * FROM `competition_grades` WHERE `competition` = '".$comp->GetID()."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		if (!mysql_num_rows($query)){
			return '';
		} else {
			hr();
			$ptna = array();
			$table = new Table();
			$table->StartRow();
			$table->AddHeader('Grader');
			$sort = array();
			foreach ($pack->PackContents() as $id=>$cnt){
				$sort[$cnt['points']][] = $cnt['guide']->GetName();
				$ptna[] = $cnt['points'];
			}
			
			ksort($sort);
			
			foreach ($sort as $arr){
				foreach ($arr as $name){
					$table->AddHeader($name);
				}
			}
			$table->EndRow();
			$total = 0;
			$i = 1;
			$pzza = 0;
			while ($outp = mysql_fetch_assoc($query)){
				$array = unserialize(stripslashes($outp['smatter']));
				ksort($array);
				$table->StartRow();
				$table->AddCell('Grader '.$i);
				foreach ($array as $gui=>$hunt){
					foreach ($hunt[$this->id] as $pts){
						$table->AddCell($pts.'/'.$gui);
						$pzza++;
						if ($pzza == 6){
							$pzza = 0;
						}
					}
				}
				$table->EndRow();
				$i++;
			}
			$table->EndTable();
		}
	}
	
	function Published($format = false){
		return (($this->date == -1) ? false : ($format ? date('j F Y \a\t G:i:s T', $this->date) : $this->date));
	}
	
	function GetPerson(){
		return new Person($this->bhg_id, 'fight-51-me');
	}
	
	function GetLibrary(){
		return new Library($this->library);
	}
	
	function DateDeleted(){
		return $this->date_deleted;
	}
	
	function del($del){
		if (!($del === 0)){
			$del = time();
		}
		$sql = "UPDATE `".$this->table."` SET `date_deleted` = '".$del."' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		return ($query ? true : false);
	}
	
	function Publish(){
		$sql = "UPDATE `".$this->table."` SET `date` = '".time()."' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function Edit($title, $fiction, $repub, $lib){
		$chg = false;
		
		if ($repub == 0 && $this->Published()){
			$pub = 0;
			$chg = true;
		} elseif ($repub > 0 && !$this->Published()){
			$pub = time();
			$chg = true;
		} elseif ($repub == -1){
			$pub = -1;
			$chg = true;
		}
		
		$sql = "UPDATE `".$this->table."` SET `title` = '".addslashes($title)."', `fiction` = '"
		.addslashes($fiction)."', `library` = '$lib'".($chg ? ", `date` = '$pub'" : '')." WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function Competition(){
		$sql = "SELECT `competition` FROM `competition_results` WHERE `fiction` = '".$this->id."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		if (mysql_num_rows($query)){
			$info = mysql_fetch_assoc($query);
			return $this->GetComp($info['competition']);
		}
		
		return false;
	}
	
	function GetComments(){
		$sql = "SELECT * FROM `comments` WHERE `fiction` = '".$this->id."' AND `date_deleted` = 0 ORDER BY `date` DESC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$return[$info['id']] = array('per'=>new Person($info['bhg_id']), 'comment'=>stripslashes(nl2br($info['comment'])),
				'date'=>$info['date'], 'datefrmt'=>date('j F Y \a\t G:i:s T', $info['date']));
		}
		
		return $return;
	}
	
	function NewComment($id, $comment){
		$sql = "INSERT INTO `comments` (`bhg_id`, `comment`, `date`, `fiction`) VALUES ('$id', '".addslashes($comment)
		."', '".time()."', '".$this->id."')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function DeleteComment($id){
		$sql = "UPDATE `comments` SET `date_deleted` = '".time()."' WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function Rate($num, $bhg_id){
		if ($num > 20){
			$num = 20;
		}
		
		if ($num < 0){
			$num = 0;
		}
		
		$sql = "SELECT * FROM `ratings` WHERE `bhg_id` = '$bhg_id' AND `date_deleted` = 0 AND `fiction` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		if (mysql_num_rows($query)){
			$info = mysql_fetch_assoc($query);
			$sql = "UPDATE `ratings` SET `rating` = '$num' WHERE `id` = '".$info['id']."'";
		} else {
			$sql = "INSERT INTO `ratings` (`bhg_id`, `fiction`, `rating`) VALUES ('$bhg_id', '".$this->id."', '$num')";
		}
		
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function Rating($format = false){
		$sql = "SELECT * FROM `ratings` WHERE `date_deleted` = 0 AND `fiction` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$rate = 0;
		$rows = mysql_num_rows($query);
		if ($rows){
			while ($info = mysql_fetch_assoc($query)){
				$rate += $info['rating'];
			}
			$rate = round($rate/$rows);
			$return = round($rate/4, 2);			
			
			if ($format){
				$a = 1;
				$rt = '';
				for ($i = 1; $i <= $rate; $i++){
					if ($a == 1){
						$rt .= '<img border=0 src="rating/fleft.png">';
			 		}
			 		if ($a == 2){
				 		$rt .= '<img border=0 src="rating/fleft-mid.png">';
			 		}
			 		if ($a == 3){
				 		$rt .= '<img border=0 src="rating/fright-mid.png">';
			 		}
			 		if ($a == 4){
				 		$rt .= '<img border=0 src="rating/fright.png">';
			 		}
			 		$a++;
			 		if ($a > 4){
				 		$a = 1;
			 		}
				}
				$rt .= ' ('.$return.')';
				return $rt;
			} else {
				return $return;
			}
		}
		
		return false;
	}
}
?>
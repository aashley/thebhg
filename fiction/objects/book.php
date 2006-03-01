<?php

class Book extends Fiction {

	var $id;
	var $name;
	var $date;
	var $bhg_id;
	var $library;
	var $date_deleted;
	var $table;
	
	function Book($id){
		Fiction::Fiction();
		
		$this->table = 'books';
		
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
		$sql = "SELECT * FROM `views` WHERE `book` = '".$this->id."' AND `date` > '$time' AND `ip_addy` = '$ip'";
		$query = mysql_query($sql, $this->connect);
		if (mysql_num_rows($query)){
			return false;
		}
		
		$sql = "INSERT INTO `views` (`book`, `ip_addy`, `date`) VALUES ('".$this->id."', '$ip', '".time()."')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function GetName(){
		return $this->name;
	}
	
	function Published($format = false){
		return ($format ? date('j F Y \a\t G:i:s T', $this->date) : $this->date);
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
	
	function Edit($name, $repub, $lib){
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
		
		$sql = "UPDATE `".$this->table."` SET `name` = '".addslashes($name)."', `library` = '$lib'"
			.($chg ? ", `date` = '$pub'" : '')." WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function Chapters(){
		$sql = "SELECT * FROM `book_chapters` WHERE `book` = '".$this->id."' AND `date_deleted` = 0 ORDER BY `chapter` DESC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		$i = 1;
		
		while ($info = mysql_fetch_assoc($query)){
			$return[$i][$info['id']][$info['chapter']] = $this->GetFiction($info['fiction']);
			$i++;
		}
		
		return $return;
	}
	
	function SimipleChapters(){
		$sql = "SELECT * FROM `book_chapters` WHERE `book` = '".$this->id."' AND `date_deleted` = 0 ORDER BY `chapter` DESC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$fic = $this->GetFiction($info['fiction']);
			$return[$fic->GetID()] = $fic->GetTitle();
			$i++;
		}
		
		return $return;
	}
	
	function ChapterCount(){
		$sql = "SELECT `id` FROM `book_chapters` WHERE `book` = '".$this->id."' AND `date_deleted` = 0 ORDER BY `chapter`";
		$query = mysql_query($sql, $this->connect);
		
		return mysql_num_rows($query);
	}
	
	function NewChapter($id){
		$ch = $this->ChapterCount();
		$ch++;
		
		$sql = "SELECT `id` FROM `book_chapters` WHERE `fiction` = '$id' AND `date_deleted` = 0 AND `book` = '"
			.$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		if (mysql_num_rows($query)){
			echo 'You already have this fiction as a chapter.<br />';
			return false;
		}
		
		$sql = "INSERT INTO `book_chapters` (`fiction`, `book`, `chapter`) VALUES ('$id', '".$this->id."', '$ch')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function DeleteChapter($id){
		$sql = "UPDATE `book_chapters` SET `date_deleted` = '".time()."' WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		foreach ($this->Chapters() as $order=>$i){
			foreach ($i as $id=>$a){
				$sql = "UPDATE `book_chapters` SET `chapter` = '$order' WHERE `id` = '$id'";
				mysql_query($sql, $this->connect);
			}
		}
		
		return ($query ? true : false);
	}
	
	function MoveUp($id, $ch){
		$och = $ch;
		$ch++;
		if ($ch > $this->ChapterCount()){
			echo 'You have tried to make this higher than you had to. Die.<br />';
			return false;
		}
		
		$sql = "UPDATE `book_chapters` SET `chapter` = '$och' WHERE `chapter` = '$ch' AND `book` = '".$this->id."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		$sql = "UPDATE `book_chapters` SET `chapter` = '$ch' WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function MoveDown($id, $ch){
		$och = $ch;
		$ch--;
		if ($ch <= 0){
			echo 'You have tried to make this lower than you had to. Die.<br />';
			return false;
		}
		
		$sql = "UPDATE `book_chapters` SET `chapter` = '$och' WHERE `chapter` = '$ch' AND `book` = '".$this->id."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		$sql = "UPDATE `book_chapters` SET `chapter` = '$ch' WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function GetComments(){
		$sql = "SELECT * FROM `b_comments` WHERE `book` = '".$this->id."' AND `date_deleted` = 0 ORDER BY `date` DESC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$return[$info['id']] = array('per'=>new Person($info['bhg_id']), 'comment'=>stripslashes(nl2br($info['comment'])),
				'date'=>$info['date'], 'datefrmt'=>date('j F Y \a\t G:i:s T', $info['date']));
		}
		
		return $return;
	}
	
	function NewComment($id, $comment){
		$sql = "INSERT INTO `b_comments` (`bhg_id`, `comment`, `date`, `book`) VALUES ('$id', '".addslashes($comment)
		."', '".time()."', '".$this->id."')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function DeleteComment($id){
		$sql = "UPDATE `b_comments` SET `date_deleted` = '".time()."' WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function Rating($format = false){
		$rate = 0;
		$rata = 0;
		foreach ($this->SimipleChapters() as $id=>$a){
			$sql = "SELECT * FROM `ratings` WHERE `date_deleted` = 0 AND `fiction` = '$id'";
			$query = mysql_query($sql, $this->connect);
			$rows = mysql_num_rows($query);

			if ($rows){
				while ($info = mysql_fetch_assoc($query)){
					$rate += $info['rating'];
				}
				$rata += round($rate/$rows);
			}
		}
		
		$return = round($rata/4, 2);
			
		if ($format){
			$a = 1;
			$rt = '';
			for ($i = 1; $i <= $rata; $i++){
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
		
		return false;
		
	}
}
?>
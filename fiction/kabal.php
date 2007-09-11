<?php

include_once 'roster.inc';

class Fiction extends BHGObject {

	var $connect;
	var $library;
	var $coder;
	
	function Fiction($code_string){
		$this->connect = mysql_connect("localhost", "fiction", "c80509a2");
		mysql_select_db('fiction', $this->connect);
		
		$sql = "SELECT `id` FROM `libraries` WHERE `key` = '".strtoupper(md5($code_string))."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		if (mysql_num_rows($query)){
			$info = mysql_fetch_assoc($query);
			$this->library = $info['id'];
			$this->coder = $code_string;
		} else {
			echo '<h3>Invalid Coder ID. Fiction Archive Unaccessible.</h3>';
		}
	}
			
	function RandomFiction(){
		$sql = "SELECT `id` FROM `fiction` WHERE `date_deleted` = 0 AND `date` > 0 AND `library` = '".$this->library."' ORDER BY RAND() LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $this->GetFiction($info['id']);
	}
	
	function RandomLibrary(){
		$sql = "SELECT `bhg_id` FROM `fiction` WHERE `library` = '".$this->library."' GROUP BY `bhg_id` ORDER BY RAND() LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return new Person($info['bhg_id']);
	}
	
	function ScanLibrary($kabal){
		$kabal = new Kabal($kabal);
		$fics = array();
		foreach ($kabal->GetMembers() as $hunter){
			$sql = "SELECT `id`, `bhg_id` FROM `fiction` WHERE `date_deleted` = 0 AND `date` > 0 AND `bhg_id` = '".$hunter->GetID()."'";
			$query = mysql_query($sql, $this->connect);
			
			while ($info = mysql_fetch_assoc($query)){
				$fics[$info['bhg_id']][$info['id']] = $this->GetFiction($info['id']);
			}
		}
		
		return $fics;
	}
	
	function KabalArchives($kabal, $resource, $get = 0){
		$fics = $this->ScanLibrary($kabal);
		$return = array();
		foreach ($fics as $hunter=>$crap){
			$person = new Person($hunter);
			$return[$hunter] = $person->GetName();
		}
		
		$return += $this->WritersList();
		if ($resource == 'AUTHOR'){
			return $return;
		} elseif ($resource == 'FICTIONS'){
			$output = array();
			if (is_array($fics[$get])){
				foreach ($fics[$get] as $id=>$art){
					$output[$id] = $art->GetTitle();
				}
			}
			$output += $this->BuildLibrary($get);
			return $output;
		}
	}
	
	function RandomBook(){
		$sql = "SELECT `id` FROM `books` WHERE `date_deleted` = 0 AND `date` > 0 AND `library` = '".$this->library."' ORDER BY RAND() LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $this->GetBook($info['id']);
	}
	
	function LatestFiction(){
		$sql = "SELECT `id` FROM `fiction` WHERE `date_deleted` = 0 AND `date` > 0 AND `library` = '".$this->library."' ORDER BY `date` DESC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $this->GetFiction($info['id']);
	}
	
	function HighestRated(){
		$sql = "SELECT SUM(`rating`) as sum, `fiction` FROM `ratings` WHERE `date_deleted` = 0 AND `library` = '".$this->library."' GROUP BY `fiction` ORDER BY sum DESC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $this->GetFiction($info['fiction']);
	}
	
	function HighestRatedBook(){
		$sql = "SELECT SUM(ratings.fiction) as sum, ratings.fiction as fiction, book_chapters.book as book FROM book_chapters, ratings, books "
			." WHERE book_chapters.date_deleted = 0 AND books.library = '".$this->library."' GROUP BY book, fiction ORDER BY sum DESC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		echo mysql_error($this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $this->GetBook($info['book']);
	}
	
	function MostViewedFic(){
		$sql = "SELECT COUNT(*) as sum, `fiction` FROM `views` WHERE `date_deleted` = 0 AND `library` = '".$this->library."' AND `book` = 0 GROUP BY `fiction` ORDER BY sum DESC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $this->GetFiction($info['fiction']);
	}
	
	function MostViewedBook(){
		$sql = "SELECT COUNT(*) as sum, `book` FROM `views` WHERE `date_deleted` = 0 AND `library` = '".$this->library."' AND `fiction` = 0 GROUP BY `book` ORDER BY sum DESC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $this->GetBook($info['book']);
	}
	
	function LatestFicByID(){
		$sql = "SELECT `id` FROM `fiction` WHERE `date_deleted` = 0 AND `library` = '".$this->library."' AND `date` > 0 ORDER BY `id` DESC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $this->GetFiction($info['id']);
	}
	
	function TotalFictions(){
		$sql = "SELECT `id` FROM `fiction` WHERE `date_deleted` = 0 AND `library` = '".$this->library."' AND `date` > 0";
		$query = mysql_query($sql, $this->connect);
		
		return mysql_num_rows($query);
	}
	
	function WritersList(){
		$sql = "SELECT `bhg_id` FROM `fiction` WHERE `library` = '".$this->library."' GROUP BY `bhg_id`";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while($info = mysql_fetch_assoc($query)){
		 	$per = new Person($info['bhg_id']);
			$return[$info['bhg_id']] = $per->GetName();
		}
		
		asort($return);
		
		return $return;
	}
	
	function TotalWriters(){
		return count($this->WritersList());
	}
	
	function BuildLibrary($id){
		$sql = "SELECT `id`, `title` FROM `fiction` WHERE `bhg_id` = '$id' AND `date_deleted` = 0 AND `date` > 0 AND `library` = '".$this->library."' ORDER BY `title`";
		$query = mysql_query($sql, $this->connect);

		$return = array();
			
		while ($info = mysql_fetch_assoc($query)){
			$return[$info['id']] = stripslashes($info['title']);
		}
		
		asort($return);
		
		return $return;
	}
	
	function BookLibrary($id){
		$sql = "SELECT `id`, `name` FROM `books` WHERE `bhg_id` = '$id' AND `date_deleted` = 0 AND `date` > 0 AND `library` = '".$this->library."' ORDER BY `name`";
		$query = mysql_query($sql, $this->connect);

		$return = array();
			
		while ($info = mysql_fetch_assoc($query)){
			$return[$info['id']] = stripslashes($info['name']);
		}
		
		asort($return);
		
		return $return;
	}
	
	function GetBook($id){
		return new Book($id, $this->coder);
	}
	
	function GetFiction($id){
		return new Article($id, $this->coder);
	}
	
	function GetLibrary(){
		return new Library($this->library, $this->coder);
	}	
}

class Book extends Fiction {

	var $id;
	var $name;
	var $date;
	var $bhg_id;
	var $library;
	var $date_deleted;
	var $table;
	
	function Book($id, $coder){
		Fiction::Fiction($coder);
		
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
	
	function GetTitle(){
		return $this->name;
	}
	
	function Published($format = false){
		return ($format ? date('j F Y \a\t G:i:s T', $this->date) : $this->date);
	}
	
	function GetPerson(){
		return new Person($this->bhg_id);
	}
	
	function GetLibrary(){
		return new Library($this->library, $this->coder);
	}
	
	function DateDeleted(){
		return $this->date_deleted;
	}
	
	function Chapters(){
		$sql = "SELECT * FROM `book_chapters` WHERE `book` = '".$this->id."' AND `date_deleted` = 0 ORDER BY `chapter` DESC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$fic = $this->GetFiction($info['fiction']);
			$return[$fic->GetID()] = $fic;
			$i++;
		}
		
		return $return;
	}
	
	function ChapterCount(){
		$sql = "SELECT `id` FROM `book_chapters` WHERE `book` = '".$this->id."' AND `date_deleted` = 0 ORDER BY `chapter`";
		$query = mysql_query($sql, $this->connect);
		
		return mysql_num_rows($query);
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
					$rt .= '<img border=0 src="rating/left.png">';
		 		}
		 		if ($a == 2){
			 		$rt .= '<img border=0 src="rating/left-mid.png">';
		 		}
		 		if ($a == 3){
			 		$rt .= '<img border=0 src="rating/right-mid.png">';
		 		}
		 		if ($a == 4){
			 		$rt .= '<img border=0 src="rating/right.png">';
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

class Article extends Fiction {

	var $id;
	var $title;
	var $date;
	var $bhg_id;
	var $fiction;
	var $library;
	var $date_deleted;
	var $table;
	
	function Article($id, $coder){
		Fiction::Fiction($coder);
		
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
		return ($format ? nl2br(str_replace(array('[*', '*]'), array('<', '>'), str_replace(array('<', '>'), array('&lt;', '&gt;'), $this->fiction))) : $this->fiction);
	}
	
	function Published($format = false){
		return (($this->date == -1) ? false : ($format ? date('j F Y \a\t G:i:s T', $this->date) : $this->date));
	}
	
	function GetPerson(){
		return new Person($this->bhg_id);
	}
	
	function GetLibrary(){
		return new Library($this->library, $this->coder);
	}
	
	function DateDeleted(){
		return $this->date_deleted;
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
						$rt .= '<img border=0 src="rating/left.png">';
			 		}
			 		if ($a == 2){
				 		$rt .= '<img border=0 src="rating/left-mid.png">';
			 		}
			 		if ($a == 3){
				 		$rt .= '<img border=0 src="rating/right-mid.png">';
			 		}
			 		if ($a == 4){
				 		$rt .= '<img border=0 src="rating/right.png">';
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

class Library extends Fiction {

	var $id;
	var $name;
	var $description;
	var $date_deleted;
	var $table;
	
	function Library($id, $coder){
		Fiction::Fiction($coder);
		
		$this->table = 'libraries';
		
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
	
	function GetName(){
		return $this->name;
	}
	
	function GetDescription($format = true){
		return ($format ? nl2br($this->description) : $this->description);
	}
	
	function DateDeleted(){
		return $this->date_deleted;
	}
}

?>

<?php

class Fiction extends BHGObject {

	var $connect;
	
	function Fiction(){
		$this->BHGObject('fight-51-me');
		$this->connect = mysql_connect("localhost", "thebhg_fiction", "c80509a2");
		mysql_select_db('thebhg_fiction', $this->connect);
	}
	
	function MedalBoard(){
		return new MedalBoard('fight-51-me');
	}
	
	function next_medal($person, $group) {
		$mb = $this->MedalBoard();	
		$mg = $mb->GetMedalGroup($group);
		if ($mg->GetDisplayType() != 0) {
			echo 'Numeric medal, leaving immediately.<br>';
			$medals = $mg->GetMedals();
			return $medals[0];
		}
		
		$medals = $person->GetMedals();
		if (count($medals)) {
			$orders = array();
			$group_medals = $mg->GetMedals();
			foreach ($group_medals as $medal) {
				$orders[$medal->GetOrder()] = 0;
			}
			foreach ($medals as $am) {
				$medal = $am->GetMedal();
				$mgroup = $medal->GetGroup();
				if ($mgroup->GetID() == $group) {
					$orders[$medal->GetOrder()]++;
				}
			}
			ksort($orders);
			$last = 0;
			foreach ($orders as $key=>$o) {
				if ($o < $last) {
					$order = $key;
					break;
				}
				$last = $o;
			}
			if (empty($order)) {
				$order = min(array_keys($orders));
			}
			
			$medals = $mg->GetMedals();
			foreach ($medals as $medal) {
				if ($medal->GetOrder() == $order) {
					return $medal;
				}
			}
			return $medals[0];
		}
		else {
			$medals = $mg->GetMedals();
			return $medals[0];
		}
	}
	
	function NewLibrary($name, $key, $description, $fullaccess){
		$sql = "INSERT INTO `libraries` (`name`, `key`, `description`, `full_access`) VALUES ('".addslashes($name)."', '"
			.addslashes(strtoupper(md5($key)))."', '".addslashes($description)."', '$fullaccess')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? mysql_insert_id($this->connect) : false);
	}
	
	function NewFiction($bhg_id, $title, $fiction, $publish, $library){
		$date = (($publish == -1) ? -1 : ($publish ? time() : 0));
		$sql = "INSERT INTO `fiction` (`bhg_id`, `title`, `fiction`, `date`, `library`) VALUES ('$bhg_id', '"
		.addslashes($title)."', '".addslashes($fiction)."', '$date', '$library')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? mysql_insert_id($this->connect) : false);
	}
	
	function NewBook($bhg_id, $title, $publish, $library){
		$date = (($publish == -1) ? -1 : ($publish ? time() : 0));
		$sql = "INSERT INTO `books` (`bhg_id`, `name`, `date`, `library`) VALUES ('$bhg_id', '".addslashes($title)
			."', '$date', '$library')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? mysql_insert_id($this->connect) : false);
	}
	
	function NewCompGuide($name, $description){
		$sql = "INSERT INTO `competition_guide` (`name`, `description`) VALUES ('$name', '$description')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? mysql_insert_id($this->connect) : false);
	}
	
	function NewCompPack($name, $description){
		$sql = "INSERT INTO `competition_packages` (`name`, `description`) VALUES ('$name', '$description')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? mysql_insert_id($this->connect) : false);
	}
	
	function NewAdmin($bhg_id, $posi, $divi, $lib, $mod, $libr, $comp){
		$sql = "INSERT INTO `library_admin` (`bhg_id`, `division`, `position`, `library`, `moderator`, `librarian`, "
			."`competitions`) VALUES ('$bhg_id', '$divi', '$posi', '$lib', '$mod', '$libr', '$comp')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? mysql_insert_id($this->connect) : false);
	}
	
	function NewCompetition($library, $pack, $desc, $starts, $ends){
		$sql = "INSERT INTO `competitions` (`library`, `pack`, `description`, `starts`, `ends`) VALUES (".
			"'$library', '$pack', '$desc', '$starts', '$ends')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? mysql_insert_id($this->connect) : false);
	}
	
	function NewsPost($news){
		$sql = "INSERT INTO `news` (`news`, `date`) VALUES ('".addslashes($news)."', '".time()."')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? mysql_insert_id($this->connect) : false);
	}
	
	function NewRestriction($library, $divi){
		$sql = "INSERT INTO `library_restrictions` (`library`, `division`) VALUES ('$library', '$divi')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? mysql_insert_id($this->connect) : false);
	}
			
	function RandomFiction(){
		$sql = "SELECT `id` FROM `fiction` WHERE `date_deleted` = 0 AND `date` > 0 ORDER BY RAND() LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $info['id'];
	}
	
	function RandomLibrary(){
		$sql = "SELECT `bhg_id` FROM `fiction` GROUP BY `bhg_id` ORDER BY RAND() LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $info['bhg_id'];
	}
	
	function RandomBook(){
		$sql = "SELECT `id` FROM `books` WHERE `date_deleted` = 0 AND `date` > 0 ORDER BY RAND() LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $info['id'];
	}
	
	function LatestFiction(){
		$sql = "SELECT `id` FROM `fiction` WHERE `date_deleted` = 0 AND `date` > 0 ORDER BY `date` DESC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $info['id'];
	}
	
	function HighestRated(){
		$sql = "SELECT SUM(`rating`) as sum, `fiction` FROM `ratings` WHERE `date_deleted` = 0 GROUP BY `fiction` ORDER BY sum DESC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $info['fiction'];
	}
	
	function HighestRatedBook(){
		$sql = "SELECT SUM(ratings.fiction) as sum, ratings.fiction as fiction, book_chapters.book as book FROM book_chapters, ratings "
			." WHERE book_chapters.date_deleted = 0 GROUP BY book, fiction ORDER BY sum DESC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		echo mysql_error($this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $info['book'];
	}
	
	function MostViewedFic(){
		$sql = "SELECT COUNT(*) as sum, `fiction` FROM `views` WHERE `date_deleted` = 0 AND `book` = 0 GROUP BY `fiction` ORDER BY sum DESC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $info['fiction'];
	}
	
	function MostViewedBook(){
		$sql = "SELECT COUNT(*) as sum, `book` FROM `views` WHERE `date_deleted` = 0 AND `fiction` = 0 GROUP BY `book` ORDER BY sum DESC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $info['book'];
	}
	
	function LatestFicByID(){
		$sql = "SELECT `id` FROM `fiction` WHERE `date_deleted` = 0 AND `date` > 0 ORDER BY `id` DESC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_assoc($query);
		
		return $info['id'];
	}
	
	function TotalFictions(){
		$sql = "SELECT `id` FROM `fiction` WHERE `date_deleted` = 0 AND `date` > 0";
		$query = mysql_query($sql, $this->connect);
		
		return mysql_num_rows($query);
	}
	
	function AllFictions($lib = array()){
		$write = false;
		if (is_array($lib) && count($lib)){
			$libs = implode(', ', $lib);
			$write = true;
		}
		$sql = "SELECT `id`, `title` FROM `fiction` WHERE `date_deleted` = 0 AND `date` > 0".($write ? ' AND `library` IN ('
			.$libs.')' : '');
		$query = mysql_query($sql, $this->connect);
		$return = array();

		while($info = mysql_fetch_assoc($query)){
			$return[$info['id']] = stripslashes($info['title']);
		}

		return $return;
	}
	
	function WritersList($lib = array()){
		$write = false;
		if (is_array($lib) && count($lib)){
			$libs = implode(', ', $lib);
			$write = true;
		}
		$sql = "SELECT `bhg_id` FROM `fiction`".($write ? ' WHERE `library` IN ('.$libs.')' : '')." GROUP BY `bhg_id`";
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
	
	function BuildLibrary($id, $all = false){
		$sql = "SELECT `id`, `title` FROM `fiction` WHERE `bhg_id` = '$id' ".($all ? '' : "AND `date_deleted` = 0 AND `date` > 0 ")."ORDER BY `title`";
		$query = mysql_query($sql, $this->connect);

		$return = array();
			
		while ($info = mysql_fetch_assoc($query)){
			$fic = new Article($info['id']);
			$go = true;
			if ($fic->date == -1){
				$comp = $fic->Competition();
				if ($comp->graded == 0){
					if ($comp->CanGrade()){
						$go = false;
					}
				}
			}
			if ($go){
				$return[$info['id']] = stripslashes((($fic->date == -1) ? 'Competition Submission :: ' : '').$info['title']);
			}
		}
		
		asort($return);
		
		return $return;
	}
	
	function BookLibrary($id, $all = false){
		$sql = "SELECT `id`, `name` FROM `books` WHERE `bhg_id` = '$id' ".($all ? '' : "AND `date_deleted` = 0 AND `date` > 0 ")."ORDER BY `name`";
		$query = mysql_query($sql, $this->connect);

		$return = array();
			
		while ($info = mysql_fetch_assoc($query)){
			$return[$info['id']] = stripslashes($info['name']);
		}
		
		asort($return);
		
		return $return;
	}
	
	function GetBook($id){
		return new Book($id);
	}
	
	function GetNews(){
		$sql = "SELECT * FROM `news` ORDER BY `date` DESC LIMIT 5";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$return[$info['date']] = nl2br(stripslashes($info['news']));
		}
		
		return $return;
	}
	
	function GetFiction($id){
		return new Article($id);
	}
	
	function GetLibrary($id){
		return new Library($id);
	}
	
	function AccessibleLibraries($bhg_id){
		$person = new Person($bhg_id);
		$sql = "SELECT `id` FROM `libraries` WHERE `full_access` = 1 and `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$return[] = $this->GetLibrary($info['id']);
		}
		
		$division = $person->GetDivision();
		
		$sql = "SELECT `library` FROM `library_restrictions` WHERE `division` = '".$division->GetID()."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		while ($info = mysql_fetch_assoc($query)){
			$return[] = $this->GetLibrary($info['library']);
		}
		
		return $return;
	}
	
	function GetComp($id){
		return new Competition($id);
	}
	
	function OpenCompetitions($id, $extra = array()){
		$libs = $this->AccessibleLibraries($id);
		if (count($extra)){
			foreach ($extra as $ex){
				$libs[] = $this->GetLibrary($ex);
			}
		}
		$return = array();
		foreach ($libs as $lib){
			$sql = "SELECT `id` FROM `competitions` WHERE `library` = '".$lib->GetID()."' AND `date_deleted` = 0 AND ".
				"`starts` <= '".time()."' AND `ends` >= '".time()."' AND `graded` = 0";

			$query = mysql_query($sql, $this->connect);
			while ($info = mysql_fetch_assoc($query)){
				$return[] = $this->GetComp($info['id']);
			}
		}

		return $return;
	}
	
	function ClosedComps(){
		$return = array();
		$sql = "SELECT `id` FROM `competitions` WHERE `date_deleted` = 0 AND `graded` = 1";

		$query = mysql_query($sql, $this->connect);
		while ($info = mysql_fetch_assoc($query)){
			$return[] = $this->GetComp($info['id']);
		}

		return $return;
	}
	
	function EditableComps($extra = array()){
		if (count($extra)){
			foreach ($extra as $ex){
				$libs[] = $this->GetLibrary($ex);
			}
		}
		$return = array();
		foreach ($libs as $lib){
			$sql = "SELECT `id` FROM `competitions` WHERE `library` = '".$lib->GetID()."' AND `date_deleted` = 0 AND ".
				"`starts` >= '".time()."' AND `graded` = 0";
			$query = mysql_query($sql, $this->connect);
			while ($info = mysql_fetch_assoc($query)){
				$return[] = $this->GetComp($info['id']);
			}
		}
		
		return $return;
	}
	
	function GradeableComps($extra = array()){
		if (count($extra)){
			foreach ($extra as $ex){
				$libs[] = $this->GetLibrary($ex);
			}
		}
		$return = array();
		foreach ($libs as $lib){
			$sql = "SELECT `id` FROM `competitions` WHERE `library` = '".$lib->GetID()."' AND `date_deleted` = 0 AND ".
				"`graded` = 0";
			$query = mysql_query($sql, $this->connect);
			while ($info = mysql_fetch_assoc($query)){
				$return[] = $this->GetComp($info['id']);
			}
		}
		
		return $return;
	}
	
	function Libraries($all = false){
		$sql = "SELECT `id` FROM `libraries`".($all ? '' : ' WHERE `date_deleted` = 0')." ORDER BY `name`";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$return[] = $this->GetLibrary($info['id']);
		}
		
		return $return;
	}
	
	function GetPack($id){
		return new CompPack($id);
	}
	
	function GetGuide($id){
		return new CompGuide($id);
	}
	
	function CompPacks($all = false){
		$sql = "SELECT `id` FROM `competition_packages`".($all ? '' : ' WHERE `date_deleted` = 0')." ORDER BY `name`";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$return[] = $this->GetPack($info['id']);
		}
		
		return $return;
	}
	
	function CompGuides($all = false){
		$sql = "SELECT `id` FROM `competition_guide`".($all ? '' : ' WHERE `date_deleted` = 0')." ORDER BY `name`";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$return[] = $this->GetGuide($info['id']);
		}
		
		return $return;
	}
	
	function LibraryAdmin($lib){
		$sql = "SELECT * FROM `library_admin` WHERE `library` = '$lib' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$return[$info['id']] = 
				array('person'=>new Person($info['bhg_id']), 'division'=>new Division($info['division']),
				'position'=>new Position($info['position']), 'mod'=>$info['moderator'], 'libr'=>$info['librarian'],
				'comp'=>$info['competitions']);
		}
		
		return $return;
	}
	
	function AdminFix($id, $class, $state){
		$sql = "UPDATE `library_admin` SET `$class` = '$state' WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function LibraryRestrict($lib){
		$sql = "SELECT * FROM `library_restrictions` WHERE `library` = '$lib' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$return[$info['id']] = array('division'=>new Division($info['division']));
		}
		
		return $return;
	}
	
	function RestrictFix($id, $class, $state){
		$sql = "UPDATE `library_restrictions` SET `$class` = '$state' WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function PersonalAdmin($bhg_id, $divi, $posi){
		$return = array();
		
		$sql = "SELECT * FROM `library_admin` WHERE `bhg_id` = '$bhg_id' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		while ($info = mysql_fetch_assoc($query)){
			$return[] = array('lib'=>$this->GetLibrary($info['library']), 'mod'=>$info['moderator'], 
				'libr'=>$info['librarian'], 'comp'=>$info['competitions']);
		}
		
		$sql = "SELECT * FROM `library_admin` WHERE `division` = '$divi' AND `position` = '$posi' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		while ($info = mysql_fetch_assoc($query)){
			$return[] = array('lib'=>$this->GetLibrary($info['library']), 'mod'=>$info['moderator'], 
				'libr'=>$info['librarian'], 'comp'=>$info['competitions']);
		}
		
		$sql = "SELECT * FROM `library_admin` WHERE `division` = '0' AND `position` = '$posi' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);

		while ($info = mysql_fetch_assoc($query)){
			$return[] = array('lib'=>$this->GetLibrary($info['library']), 'mod'=>$info['moderator'], 
				'libr'=>$info['librarian'], 'comp'=>$info['competitions']);
		}

		return $return;
	}
	
	function FAMod($id){		
		$sql = "SELECT * FROM `super_admin` WHERE `bhg_id` = '$id' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		return mysql_num_rows($query);
	}
	
	function FAMods(){		
		$sql = "SELECT * FROM `super_admin` WHERE `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$return[$info['bhg_id']] = new Person($info['bhg_id']);
		}
		
		return $return;
	}
	
	function AddFAMod($id){
		$sql = "INSERT INTO `super_admin` (`bhg_id`) VALUES ('$id')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function RemoveFAMod($id){
		$sql = "UPDATE `super_admin` SET `date_deleted` = '".time()."' WHERE `bhg_id` = '$id' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
		
}

?>
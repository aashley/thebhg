<?

Class Shell extends Core {

	var $table;
	var $search;
	var $given;
	var $storage = array();
	var $fields = array();
	
	function Shell ($id, $table, $search = 'id') {
		Core::Core();
	
		$this->table = $table;
		$this->search = $search;
		$this->given = $id;
	    $this->UpdateCache();
	}
	
	function UpdateCache () {
		$sql = "SELECT * FROM `".$this->table."` WHERE `".$this->search."` = '".$this->given."'";
	    $query = mysql_query($sql, $this->connect);
	    $info = mysql_fetch_assoc($query);
		
		if (is_array($info)){
			foreach ($info as $field=>$value){
				$this->storage[$field] = $value;
			}
			$this->fields = array_keys($this->storage);
		}
	}
    
    function SetPiece ($table, $value) {
		if (in_array($table, $this->fields)){
			$sql = "UPDATE `".$this->table."` SET `$table` = '".addslashes($value)."' WHERE `id` = '".$this->storage[id]."'";
			$query = mysql_query($sql, $this->connect);
		
			if ($query){
			    $this->UpdateCache();
		    } else {
			    $this->roster_error = 'Error from Database: '.mysql_error($this->connect);
		    }
		
			return ($query ? true : false);
		} else {
			$this->roster_error = "Field ($table) does not exist.";
			return false;
		}
	}
    
	function GetValue ($field) {
		return $this->storage[$field];
	}
    
	function Compare ($field, $id) {
		return ($this->GetValue($field) == $id);
	}
	
	function BuildShell ($id, $table, $search = '') {
		return new Shell($id, $table, ($search ? $search : 'id'));
	}
	
	function eMail ($send_to = array(), $letter = 0) {
		
		$data = $this->BuildShell($letter, 'arena_settings', 'system');
			
		$read = $this->Read($data->GetValue('text'));
		
		foreach ($send_to as $person){
			if (is_object($person)){
				$mail = $person;
			} elseif (is_int($person)) {
				$mail = new Person($person);
			} else {
				continue;
			}
			
			$mail->SendMail($read['from'], $read['subject'], $read['text']);
		}
	}
	
	function Store($data){
	    return serialize($data);
    }
    
    function Read($data){
	    return unserialize($data);
    }
	
	function ShellDump ($shell) {
		return $this->$shell;
	}

 }

?>
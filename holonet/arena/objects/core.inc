<?php

 Class Core extends Roster {
	 
	var $connect;
	var $lyarna;
	var $fiction;

    function Core(){   
		$this->connect = mysql_connect('localhost', 'thebhg_holonet', 'w0rdy');
			mysql_select_db('thebhg_holonet', $this->connect);
			
		$this->lyarna = $this->LyarnaConnect();
		$this->fiction = $this->FictionConnect();
    }
    
    function Store($data){
	    return serialize($data);
    }
    
    function Read($data){
	    return unserialize($data);
    }
    
    function FictionConnect(){
        $fiction = mysql_connect("localhost", "thebhg_fiction", "c80509a2");
        mysql_select_db('thebhg_fiction', $fiction);

    	return $fiction;    
    }
    
    function LyarnaConnect(){
	    $lyarna = mysql_connect("localhost", "thebhg_lyarna", "lyarnasys55");
        mysql_select_db('thebhg_lyarna', $lyarna);
        
        return $lyarna;
    }

 }

?>
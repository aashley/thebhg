<?php

	/***************************************
	* DB Class
	* Wrapper for the DB. Only handles errors
	*
	* Extra Functions:
	*
	* DB([$question_id])
	*     Opens the DB connection
	*
	* getDbconnection()
	*     Returns the connection var
	*
	* query($sql)
	*     Does a sql query and error checking
	*
	* getInsert_id()
	*     Returns the id of the last thing
	*     inserted into the database.
	*     
	***************************************/
	
	class DB
	{
		var $dbname;
		var $dbhost;
		var $dbusername;
		var $dbpassword;
		var $dbconnection;
		var $insert_id;
		var $error;
		
		function DB ($name, $host, $username, $password)
		{
			$db_connection = @mysql_connect($host, $username, $password);
			if (!$db_connection)
			{				
				echo "DB Connection Failed";
			}
			mysql_select_db($name);
			$this->dbname = $name;
			$this->dbhost = $host;
			$this->dbusername = $username;
			$this->dbpassword =  $password;
			$this->dbconnection = $db_connection;
		}
		
		function getDbconnection ()
		{
			return $this->dbconnection;
		}
				
		function query ($sql)
		{
			$query_result = @mysql_db_query ($this->dbname, $sql, $this->dbconnection);
			if (!$query_result)
			{
				$error_out = "mySQL Error ".mysql_errno($this->dbconnection).": ".mysql_error($this->dbconnection)."\r\n";
				$error_out .= "SQL: ".$sql."\r\n";
				echo convertURL($error_out);
				$date = date("F jS Y, g:iA", time());
				$error_sql = "INSERT INTO errors (date, text) values ('$date', '$error_out')";
				$error_result = @mysql_db_query ($this->dbname, $error_sql, $this->dbconnection);
				$this->error = $error_out;
			}
			$this->insert_id = @mysql_insert_id ($this->dbconnection);
			return $query_result;
		}
		
		function getInsert_id ()
		{
			return $this->insert_id;
		}
		
		function error ()
		{
			return $this->error;
		}	
	}
?>
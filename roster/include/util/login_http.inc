<?php
/**
 * This file provides extra functionality toi the Core Roster Functionality
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.9 $
 * @package Roster
 * @subpackage Utilities
 */

/**
 * HTTP AUTH Roster Login
 *
 * This object is an extension of the Roster 
 * Login object that does all the HTTP_AUTH
 * as well as verification against the roster.
 * This has the advantage of logging a user in
 * using a one-line new Object line.
 *
 *<pre>
 *  20030829  aa  moved the clearing of all login variables so it works in all
 *  20030818  aa  Added object to Roster CVS
 *                added Logout function
 *                updated docs
 *  20030818  kh  created object
 *</pre>
 *
 * @author Khylari <Khylari@cox.net>
 * @package Roster
 * @subpackage Utilities
 * @access public
 * @version $Revision: 1.9 $
 */
class Login_HTTP extends Login
{

  // {{{ properties
  
	/**
	 * This variable stores the coder_id that
	 * is set when creating the object. This
	 * only exists to add compatibility to
	 * the BHG Roster.
	 * @access protected
	 * @var string
	 */
	var $coder_id;

	/**
	 * This is the database connection that is
	 * created in the contructor. This may be
	 * remove if this object is moved into the
	 * central BHG Roster. At that point it will
	 * use the BHGObject instead.
	 * @access protected
	 * @var mixed
	 */
	var $db_connection;

	/**
	 * This is the URL that the login applies too.
	 * This will be .thebhg.org for as long as the
	 * the BHG uses that domain. This only exists
	 * in case of a domain name change later.
	 * @access protected
	 * @var string
	 */
	var $base = ".thebhg.org";

	/**
	 * This is the title that will be displayed on
	 * the HTTP_AUTH window that pops up. It needs
	 * to stay the same for all logins so that we
	 * don't get asked for the login info every time.
	 * @access protected
	 * @var string
	 */
	var $name = "BHG Login";

  // }}}
  // {{{ Login_HTTP()

	/**
   * Object constructor
   *
	 * Object constructor. We create the database connection
	 * (pass it off to BHGObject?) and check to see if the
	 * current info stored in cookies is correct. If it is
	 * not, we launch into the login code.
   *
	 * @access public
   * @param string Coder Identification String
	 * @return void
	 */
	function Login_HTTP($coder_id = "")	{

    parent::BHGObject($coder_id);
		$this->coder_id = $coder_id;
//		$this->db_connection = @mysql_connect ("localhost", "thebhg_blogs", "blogm3up");
//		@mysql_select_db ("thebhg_blogs");
		if ($this->IsValid())
			parent::Person($_COOKIE["BHGLogin_id"], $this->coder_id);
		else
			$this->DoLogin();
	}

  // }}}
  // {{{ Logout()

  /**
   * Logout and require a new login
   *
   * Logout the current user and cause the next page to require login details
   * again. May not work for all users as some (most?) browsers cache http auth
   * details and will automatically send it if asked for the same set again.
   *
   * @access public
   * @return void
   */
  function Logout() {
    $this->ClearLoginVariables();
  }

  // }}}
  // {{{ IsValid()
	
	/**
   * Check if session is valid
   *
	 * Check to see if this login session is valid.
	 * We do this by making sure it is the same IP
	 * address as the last connection and it has
	 * the correct unique key we assigned it.
   *
	 * @access public
	 * @return boolean True if the login info is correct, False otherwise
	 */
	function IsValid ()
	{
    $sql = "SELECT COUNT(*) AS num "
          ."FROM http_logins "
          ."WHERE login_id = {$_COOKIE["BHGLogin_id"]} "
            ."AND login_key = '{$_COOKIE["BHGLogin_key"]}' "
            ."AND login_ip = '{$_SERVER["REMOTE_ADDR"]}';";
    
		if (   ($_COOKIE["BHGLogin"] == 1) 
        && (@mysql_result(@mysql_query($sql, $this->roster_db), 0, "num") > 0))
			return true;
		else
			return false;
	}

  // }}}
  // {{{ DoLogin()

	/**
   * Internal function to display Login Box
   *
	 * This is an internal function that calls the HTTP_AUTH
	 * code to show the login form to a user. 
   *
	 * @access protected
	 * @return void
	 */
	function DoLogin ()
	{
		if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
      
			parent::Login($_SERVER['PHP_AUTH_USER'], 
                    $_SERVER['PHP_AUTH_PW'], 
                    $this->coder_id);
      
			if (!parent::IsValid()) {
        
  	  	/**
	    	 * Clear out the existing login variables.
  		   */
    		$this->ClearLoginVariables();			
				header('WWW-Authenticate: Basic realm="'.$this->name.'"');
				header('HTTP/1.0 401 Unauthorized');
				exit;
        
			} else {
        
				$this->SetLoginVariables();

      }
      
		}	else {
      
      header('WWW-Authenticate: Basic realm="'.$this->name.'"');
			header('HTTP/1.0 401 Unauthorized');
			exit;
      
	 	}
    
	}

  // }}}
  // {{{ ClearLoginVariables()

	/**
   * Delete any cookies from login sys
   *
	 * Delete any cookies on the user's computer that
	 * might cause strange outcomes. To "clear" these
	 * cookies, we are setting their expiration date
	 * to the dawn of UNIX time.
	 *
	 * Also delete any duplicate logins in the data-
	 * base so that there is no confusion.
   *
	 * @access protected
	 * @return void
	 */
	function ClearLoginVariables () {
		/**
		 * Delete the cookies
		 */
		setcookie ("BHGLogin"    , 0, 0, "/", $this->base);
		setcookie ("BHGLogin_id" , 0, 0, "/", $this->base);
		setcookie ("BHGLogin_key", 0, 0, "/", $this->base);     
		setcookie ("BHGLogin_ip" , 0, 0, "/", $this->base);

		/**
		 * Delete the row.
		 */
		@mysql_query("DELETE FROM http_logins "
                ."WHERE login_id = ".parent::GetID().";", $this->roster_db);
	}

  // }}}
  // {{{ SetLoginVariables()

	/**
   * Create the auth tracking cookies
   *
	 * Create cookies to hold all the data needed
	 * for login verification at a later time.
	 * Also insert a row into the database to track
	 * current logins.
   *
	 * @access protected
	 * @return void
	 */
	function SetLoginVariables () {

		/**
		 * Randomize the "seed" used in generating random
		 * numbers. Set the expiration time for 1 month.
		 * Generate a random key number.
		 */
		mt_srand ((float) microtime() * 1000000); 
		$expiration = time() + 2592000;
		$key = mt_rand();

		/**
		 * Create the cookies.
		 */
		setcookie ("BHGLogin"    , 1                      , $expiration, "/", $this->base);
		setcookie ("BHGLogin_id" , parent::GetID()        , $expiration, "/", $this->base);
		setcookie ("BHGLogin_ip" , $_SERVER["REMOTE_ADDR"], $expiration, "/", $this->base);
		setcookie ("BHGLogin_key", $key                   , $expiration, "/", $this->base);

		/**
		 * Create the database row.
		 */
		@mysql_query ("INSERT INTO http_logins (login_id, "
                                          ."login_key, "
                                          ."login_ip) "
                 ."VALUES (".parent::GetID().", "
                         ."'".$key."', "
                         ."'".$_SERVER["REMOTE_ADDR"]."');", 
                  $this->roster_db);
    
	}

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

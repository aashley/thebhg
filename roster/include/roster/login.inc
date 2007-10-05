<?php
/**
 * This file contains objects required for the Core Roster Functionality
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.17 $
 * @package Roster
 * @subpackage Roster
 */

/**
 * Login - This provides login abilities
 *
 * This object takes a username and password, checks them against the roster
 * and if the login credentials are correct it returns a Login object. A Login
 * Object is a child of Person so it has all the functionality of a Person.
 *
 * <pre>
 *  20030317  aa  documentation fixes.
 *  20020522  aa  Documentation Added
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Roster
 * @access public
 * @version $Revision: 1.17 $
 *
 */
class Login extends Person {

  // {{{ properties

  /**
   * Is the Login Valid
   *
   * @access protected
   * @var integer $login_isvalid
   * @see IsValid()
   */
  var $login_isvalid = 0;

  // }}}
  // {{{ Login()

  /**
   * User Login
   *
   * Checks the login is valid and calls parents constructor
   *
   * @access public
   * @param string username Persons Username (ID number in our case)
   * @param string password Password
   * @param string coder Coder Identification
   */
  function Login($username, $password, $coder = '') {
    Person::Person($username, $coder);
    
    $sql = "SELECT id FROM roster_roster WHERE id != '' AND passwd != '' AND id = $username AND passwd = OLD_PASSWORD('$password')";
    $dbdetails = mysql_query($sql, $this->roster_db);

    if (@mysql_num_rows($dbdetails) == 1) {
//      Person::Person(mysql_result($dbdetails, 0, 'id'), $coder);
      $this->login_isvalid = 1;
    } else {
      $this->login_isvalid = 0;
    }

  }

  // }}}
  // {{{ IsValid()

  /**
   * Is The Login Valid?
   *
   * @access public
   * @return boolean whether the login is valid or not
   */
  function IsValid() {
    return $this->login_isvalid;
  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

<?
/**
 * This file contains core objects required for all parts of the Roster
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.34 $
 * @package Roster
 */

/** 
 * BHGObject - Base object for Roster Version 3.0
 * 
 * This object provides Error handling and database connections to its
 * classes. Should never be instansiated by itself.
 *
 *<pre>
 *  20030408  aa  Documentation Fixes
 *  20030330  aa  removed mysql_select_db call from Constructor so that the 
 *                roster connection isnt automatically made available to anyone
 *                using the Object
 *                rolling back security fix, didnt work as planned
 *  20030318  aa  changed Allowed to store details in a database
 *  20030317  aa  documentation fixes.
 *  20020531  aa  typo bugfix in settings
 *  20020528  aa  added settings system
 *  20020524  aa  changed permissions to use md5 checksums, coder id's are no
 *                longer stored anywhere
 *</pre>
 * 
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @access protected
 * @version $Revision: 1.34 $
 */ 
class BHGObject {

  // {{{ properties

  /**
   * Database Name
   *
   * @access protected
   * @var    string
   */
  var $roster_dbname;

  /**
   * Database Link
   *
   * @access protected
   * @var    resource
   */
  var $roster_db;

  /**
   * Error String to be returned
   *
   * @access protected
   * @var    string
   * @see    Error()
   */
  var $roster_error = "";

  /**
   * Coder Identification
   *
   * @access protected
   * @var    string
   * @see    Allowed()
   */
  var $roster_coder;

  
  // }}}
  // {{{ BHGObject()
  
  /**
   * Object Constructor
   *
   * Creates the initial connection to the database.
   * Initialises the error storage and sets the database name.
   * Always call this function first in the Constructor of any
   * direct decendants.
   *
   * @access public
   * @param coder Coder Identification String
   */
  function BHGObject($coder = '') {
    $this->roster_coder = $coder;  // Store coder ID
    $this->roster_error = "";
    $this->roster_dbname = 'thebhg_roster';  // Set the name of the database everything in

    // Connect to the db and set the default db
    $this->roster_db = mysql_connect("localhost", "thebhg_rosedit", "657cbf05");
    mysql_select_db($this->roster_dbname,$this->roster_db);

  }

  // }}}
  // {{{ Error()

  /**
   * Retrieve Error Message
   *
   * Returns what ever is in the roster_error variable and sets roster_error
   * to default. Used to get error message when something breaks.
   *
   * @access public
   * @return string
   */
  function Error () {
    $ret = $this->roster_error;

    unset($this->roster_error);

    return $ret;
  }

  // }}}
  // {{{ Allowed()

  /**
   * Check Access Permissions
   *
   * Compares the value of roster_coder with its internal array to see
   * whether this coder has access to the requested level.<br><br>
   *
   * <pre>
   *   Recognised levels:
   *     god        - Has access to everything.
   *     credits    - Has access to Adding and Removing Credits.
   *     purchase   - Has access to MakePurchase and MarkSale (used in ssl).
   *     kabal      - Has access to kabal related stuff.
   *     medalaward - Has access to medalawarding.
   *     college    - Has access to College related things.
   *     ssl        - Has access to SSL functions.
   *     history    - Has access to the History.
   *     email      - Has access to send e-mails from the system.
   *     allnews    - Has access to news from all coder IDs.
   * </pre>
   *
   * roster_coder needs to be set in constructor, is id string for each
   * project, different strings have different access levels. No coder
   * string required to access Read only functions. Write functions need
   * some sort of coder access.
   *
   * @access public
   * @param string The level of access you are requesting
   * @returns boolean
   */
  function Allowed($level) {
    
    // If no coder id, return 0, no permission
    if ($this->roster_coder == '') {
      return 0;
    }

    $check = strtoupper(md5($this->roster_coder));

    $sql = 'SELECT * '
          .'FROM coders '
          .'WHERE md5 = \''.$check.'\' ';

    $checkdb = mysql_query($sql, $this->roster_db);

    if ($check = mysql_fetch_array($checkdb)) {

      // if coder id has god permission return 1 they can do it all
      if ($check['god'] == 1) {

        return true;

      } else {

        // else return the value at the relevant point in the array
        return ($check[$level] == 1);

      }

    } else {

      // if the coder id provided does not exist in our list of accesses return 0 no permission
      return false;

    }
    
  }

  // }}}
  // {{{ GetCoderName()
  
  /**
   * Return the Name of a Coder
   *
   * @access public 
   * @param mixed Either the Coders ID Number or the Coders 
   *              Identification String
   * @return string
   */
  function GetCoderName($id) {

    if (is_numeric($id)) {

      $sql = 'SELECT name '
            .'FROM coders '
            .'WHERE id = '.$id;

    } else {

      $sql = 'SELECT name '
            .'FROM coders '
            .'WHERE md5 = \''.strtoupper(md5($id)).'\' ';

    }

    return mysql_result(mysql_query($sql, $this->roster_db), 0, 'name');
    
  }

  // }}}
  // {{{ GetCoderID()

  /**
   * Get A Coder's ID Number
   *
   * @access public
   * @param integer Coder Identification String
   * @return integer The Coder's ID Number
   */
  function GetCoderID($id) {

    $sql = 'SELECT id '
          .'FROM coders '
          .'WHERE md5 = \''.strtoupper(md5($id)).'\'';

    return mysql_result(mysql_query($sql, $this->roster_db), 0, 'id');

  }

  // }}}
  // {{{ GetSetting()

  /**
   * Load the value of a setting from the store
   *
   * @access public
   * @param string The name of the Setting you want
   * @return string The Value of the Setting
   * @deprecated deprecated since 1.23, you should be using the Settings Object
   * @uses Settings::GetRealSetting()
   */
  function GetSetting($name) {
    
    $settings = new Settings($this->roster_coder);

    return $settings->GetRealSetting($name);

  }

  // }}}
  // {{{ SaveSetting()

  /**
   * Change the value of a setting in the store
   *
   * @access public
   * @param string The name of the Setting to change
   * @param string The new value for the setting
   * @return boolean Whether the change succeded
   * @deprecated deprecated since 1.23, you should be using the Settings Object
   * @uses Settings::SaveRealSetting()
   */
  function SaveSetting($name, $value) {

    $settings = new Settings($this->roster_coder);

    return $settings->SaveRealSetting($name);

  }

  // }}}
  
}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

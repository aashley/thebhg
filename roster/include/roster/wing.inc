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
 * A Wing, A special instance of a Division
 * 
 * A subclass of division that provide extra functionality for wings
 *
 * <pre>
 *  20030619  aa  standardised on boolean returns
 *  20030617  aa  made sure all queries run against roster connection
 *  20030317  aa  documentation fixes
 *  20020816  aa  completed Set functions
 *  20020814  aa  initial version created from kabal.inc
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
class Wing extends Division {

  // {{{ properties

  /**
   * Wing's Slogan
   *
   * @access protected
   * @var string $wing_slogan
   * @see GetSlogan()
   */
  var $wing_slogan;

  /**
   * Filename of a Wing's Logo
   *
   * @access protected
   * @var string $wing_logo
   * @see GetLogoURL()
   * @see GetLogoDIR()
   */
  var $wing_logo;

  // }}}
  // {{{ Wing()

  /**
   * Object Constructor
   *  
   * Calls Division Constructor to establish db connection and sets initial
   * settings. Loads data for wing from database
   *
   * @access public
   * @param int id ID Number of the Wing to create an object for
   * @param string coder Coder Identification String
   *
   */
  function Wing($id, $coder = '') {
    
    Division::Division($id, $coder);
    
    $test = $this->Error();
    
    if ( isset($test) && $test > "" ) {
      
      $this->roster_error = $test;
      
    } else {

      $cat = $this->GetCategory();
      
      if ($cat->HasWings() == 1) {
        
        $sql = "SELECT slogan, "
                     ."logo, "
                     ."welcomemessage "
              ."FROM roster_divisions "
              ."WHERE id = $id";
              
        $wingdb = mysql_query($sql, $this->roster_db);
        
        if ($wing = @mysql_fetch_array($wingdb)) {
          
          $this->wing_homepage = $wing["home_page_url"];
          
          $this->wing_slogan = $wing["slogan"];
          
          $this->wing_logo = $wing["logo"];
          
          $this->wing_welcomemsg = $wing["welcomemessage"];
          
        } else {
          
          $this->roster_error = "Something Really Bad Happened If You Got "
                               ."This. Contact Koral NOW!!!";
        }
        
      } else { 
        
        $this->roster_error = "Invalid Wing. This division does not represent "
                             ."a Wing.";
                             
      }
      
    }
    
  }

  // }}}
  // {{{ GetWarden()

  /**
   * Get A Wing's Warden
   *
   * @access public
   * @return object Person The Warden's Person Object
   */
  function GetWarden() {
    
    $sql = "SELECT id "
          ."FROM roster_roster "
          ."WHERE position = 10 "
            ."AND division = ".$this->division_id;
            
    $result = mysql_query($sql, $this->roster_db);
    
    if ($row = mysql_fetch_array($result)) {
      
      return new Person($row["id"], $this->roster_coder);
      
    } else {
      
      return new Person(6, $this->roster_coder);
      
    }
    
  }

  // }}}
  // {{{ GetSlogan()

  /**
   * Get A Wing's Slogan
   *
   * @access public
   * @return string the slogan
   */
  function GetSlogan() {
    return $this->wing_slogan;
  }

  // }}}
  // {{{ GetURL()

  /**
   * Get the URL of the Wing's Home page
   *
   * @access public
   * @return string the URL
   */
  function GetURL() {
    return $this->wing_homepage;
  }

  // }}}
  // {{{ GetWelcomeMessage()

  /**
   * Get A Wing's Welcome Message
   *
   * @access public
   * @return string the Welcome Message
   */
  function GetWelcomeMessage() {
    return $this->wing_welcomemsg;
  }

  // }}}
  // {{{ GetLogoURL()

  /**
   * Get the URL to a Wing's Logo
   *
   * for use in img tags on web sites
   *
   * @access public
   * @return string the URL
   */
  function GetLogoURL() {
    return $this->GetSetting('imagecache_url')."/wing/".$this->wing_logo;
  }

  // }}}
  // {{{ GetLogoDIR()

  /**
   * Get the local filesystem listing for the location of the Wing's Logo
   *
   * @access public
   * @return string the location of the file
   */
  function GetLogoDIR() {
    return $this->GetSetting('imagecache_dir')."/wing/".$this->wing_logo;
  }

  // }}}
  // {{{ HasLogo()

  /**
   * Whether the set logo is valid
   *
   * @access public
   * @return boolean
   */
  function HasLogo() {
    return (   $this->wing_logo > ""
            && is_file($this->GetLogoDIR()));
  }

  // }}}
  // {{{ SetSlogan()

  /**
   * Set A Wing's Slogan
   *
   * @access public
   * @param string slogan new Slogan
   * @return boolean whether the update worked
   */
  function SetSlogan($slogan) {

    if ($this->Allowed('kabal')) {

      $sql = "UPDATE roster_divisions "
            ."SET slogan = '".addslashes($slogan)."' "
            ."WHERE id = ".$this->division_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->wing_slogan = $slogan;

        return true;

      } else {

        $this->roster_error = 'Could not set new Slogan';

        return false;

      }

    } else {

      $this->roster_error = "The Coder that create this object does not have "
        ."permission to call this function";

      return false;

    }
    
  }

  // }}}
  // {{{ SetURL()

  /**
   * Set A Wing's Home Page URL
   *
   * @access public
   * @param string url the new URL
   * @return boolean whether the update worked
   */
  function SetURL($url) {

    if ($this->Allowed('kabal')) {

      $sql = "UPDATE roster_divisions "
            ."SET home_page_url = '".addslashes($url)."' "
            ."WHERE id = ".$this->division_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->wing_homepage = $url;

        return true;

      } else {

        $this->roster_error = 'Could not set new Home Page';

        return false;

      }

    } else {

      $this->roster_error = "The Coder that create this object does not have "
        ."permission to call this function";

      return false;

    }
    
  }

  // }}}
  // {{{ SetWelcomeMessage()

  /**
   * Set A Wing's Welcome Message
   *
   * @access public
   * @param string message the new welcome message
   * @return boolean whether the update worked
   */
  function SetWelcomeMessage($message) {

    if ($this->Allowed('kabal')) {

      $sql = "UPDATE roster_divisions "
            ."SET welcomemessage = '".addslashes($message)."' "
            ."WHERE id = ".$this->division_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->wing_welcomemsg = $message;

        return true;

      } else {

        $this->roster_error = 'Could not set new Welcome Message';

        return false;

      }

    } else {

      $this->roster_error = "The Coder that create this object does not have "
        ."permission to call this function";

      return false;

    }
    
  }

  // }}}
  // {{{ TODO: SetLogo()

  /**
   * Set A Wing's Logo
   *
   * @access public
   * @param string logo the location of the file on the disc
   * @return boolean whether the update worked
   * @todo This entire function needs to be completed
   */
  function SetLogo($logo) {
  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

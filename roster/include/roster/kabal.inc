<?php
/**
 * This file contains objects required for the Core Roster Functionality
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.26 $
 * @package Roster
 * @subpackage Roster
 */

/**
 * A Kabal, A special instance of a Division
 * 
 * A subclass of division that provide extra functionality for kabals
 *
 * <pre>
 *  20030619  aa  standardised on boolean returns
 *  20030617  aa  made sure all queries run against roster connection
 *  20030317  aa  documentation fixes
 *  20030207  ah  fixed constructor to use StripSlashes for welcome message
 *  20020816  aa  completed SetFunctions
 *  20020531  aa  changed to use global settings system
 *  20020522  aa  doco changes
 *  20011031  AA  Read Only functions done
 *  20011007  AA  Initial Version
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Roster
 * @access public
 * @version $Revision: 1.26 $
 *
 */
class Kabal extends Division {

  // {{{ properties

  /**
   * Kabal's Home Page
   *
   * @access protected
   * @var string $kabal_homepage
   * @see GetHomePage()
   */
  var $kabal_homepage;

  /**
   * Kabal's Slogan
   *
   * @access protected
   * @var string $kabal_slogan
   * @see GetSlogan()
   */
  var $kabal_slogan;

  /**
   * Filename of a Kabal's Logo
   *
   * @access protected
   * @var string $kabal_logo
   * @see GetLogoURL()
   * @see GetLogoDIR()
   */
  var $kabal_logo;

  /**
   * Kabal's Welcome Message
   *
   * @access protected
   * @var string $kabal_welcomemsg
   * @see GetWelcomMessage()
   */
  var $kabal_welcomemsg;

  // }}}
  // {{{ Kabal()

  /**
   * Object Constructor
   *  
   * Calls Division Constructor to establish db connection and sets initial
   * settings. Loads data for kabal from database
   *
   * @access public
   * @param int id ID Number of the Kabal to create an object for
   * @param string coder Coder Identification String
   *
   */
  function Kabal($id, $coder = '') {
    
    Division::Division($id, $coder);
    
    $test = $this->Error();
    
    if ( isset($test) && $test > "" ) {
      
      $this->roster_error = $test;
      
    } else {

      $cat = $this->GetCategory();
      
      if ($cat->HasKabals() == 1) {
        
        $sql = "SELECT home_page_url, "
                     ."slogan, "
                     ."logo, "
                     ."welcomemessage "
              ."FROM roster_divisions "
              ."WHERE id = $id";
              
        $kabaldb = mysql_query($sql, $this->roster_db);
        
        if ($kabal = @mysql_fetch_array($kabaldb)) {
          
          $this->kabal_homepage = $kabal["home_page_url"];
          
          $this->kabal_slogan = $kabal["slogan"];
          
          $this->kabal_logo = $kabal["logo"];
          
          $this->kabal_welcomemsg = stripslashes($kabal["welcomemessage"]);
          
        } else {
          
          $this->roster_error = "Something Really Bad Happened If You Got "
                               ."This. Contact Koral NOW!!!";
        }
        
      } else { 
        
        $this->roster_error = "Invalid Kabal. This division does not represent "
                             ."a Kabal.";
                             
      }
      
    }
    
  }

  // }}}
  // {{{ GetCheif()

  /**
   * Get A Kabal's Chief
   *
   * @access public
   * @return object Person The Chief's Person Object
   * @uses Person
   */
  function GetChief() {
    
    $sql = "SELECT id "
          ."FROM roster_roster "
          ."WHERE position = 11 "
            ."AND division = ".$this->division_id;
            
    $result = mysql_query($sql, $this->roster_db);
    
    if ($row = mysql_fetch_array($result)) {
      
      return new Person($row["id"], $this->roster_coder);
      
    } else {
      
      return new Person(6, $this->roster_coder);
      
    }
    
  }

  // }}}
  // {{{ GetCRA()

  /**
   * Get A Kabals's CRA
   *
   * @access public
   * @return object Person The CRA's Person Object
   * @uses Person
   */
  function GetCRA() {
    
    $sql = "SELECT id "
          ."FROM roster_roster "
          ."WHERE position = 12 "
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
   * Get A Kabal's Slogan
   *
   * @access public
   * @return string the slogan
   */
  function GetSlogan() {
    return $this->kabal_slogan;
  }

  // }}}
  // {{{ GetURL()

  /**
   * Get the URL of the Kabal's Home page
   *
   * @access public
   * @return string the URL
   */
  function GetURL() {
    return $this->kabal_homepage;
  }

  // }}}
  // {{{ GetWelcomeMessage()

  /**
   * Get A Kabal's Welcome Message
   *
   * @access public
   * @return string the Welcome Message
   */
  function GetWelcomeMessage() {
    return $this->kabal_welcomemsg;
  }

  // }}}
  // {{{ GetLogoURL()

  /**
   * Get the URL to a Kabal's Logo
   *
   * for use in img tags on web sites
   *
   * @access public
   * @return string the URL
   */
  function GetLogoURL() {
    return $this->GetSetting('imagecache_url')."/kabal/".$this->kabal_logo;
  }

  // }}}
  // {{{ GetLogoDIR()

  /**
   * Get the local filesystem listing for the location of the Kabal's Logo
   *
   * @access public
   * @return string the location of the file
   */
  function GetLogoDIR() {
    return $this->GetSetting('imagecache_dir')."/kabal/".$this->kabal_logo;
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
    return (   $this->kabal_logo > ""
            && is_file($this->GetLogoDIR()));
  }

  // }}}
  // {{{ SetSlogan()

  /**
   * Set A Kabal's Slogan
   *
   * @access public
   * @param string slogan new Slogan
   * @return boolean whether the update worked
   * @uses BHGObject::Allowed()
   */
  function SetSlogan($slogan) {

    if ($this->Allowed('kabal')) {

      $sql = "UPDATE roster_divisions "
            ."SET slogan = '".addslashes($slogan)."' "
            ."WHERE id = ".$this->division_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->kabal_slogan = $slogan;

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
   * Set A Kabal's Home Page URL
   *
   * @access public
   * @param string url the new URL
   * @return boolean whether the update worked
   * @uses BHGObject::Allowed()
   */
  function SetURL($url) {

    if ($this->Allowed('kabal')) {

      $sql = "UPDATE roster_divisions "
            ."SET home_page_url = '".addslashes($url)."' "
            ."WHERE id = ".$this->division_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->kabal_homepage = $url;

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
   * Set A Kabal's Welcome Message
   *
   * @access public
   * @param string message the new welcome message
   * @return boolean whether the update worked
   * @uses BHGObject::Allowed()
   */
  function SetWelcomeMessage($message) {

    if ($this->Allowed('kabal')) {

      $sql = "UPDATE roster_divisions "
            ."SET welcomemessage = '".addslashes($message)."' "
            ."WHERE id = ".$this->division_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->kabal_welcomemsg = $message;

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
  // {{{ SetLogo()

  /**
   * Set A Kabal's Logo
   *
   * @access public
   * @param string logo the location of the file on the disc
   * @return boolean whether the update worked
   * @uses BHGObject::Allowed()
   */
  function SetLogo($logo) {

    if ($this->Allowed('kabal')) {

      $sql = "UPDATE roster_divisions "
            ."SET kabal_logo = '".addslashes($logo)."' "
            ."WHERE id = ".$this->division_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->kabal_logo = $logo;

        return true;

      } else {

        $this->roster_error = 'Could not set new Logo file name';

        return false;

      }

    } else {

      $this->roster_error = "The Coder that create this object does not have "
        ."permission to call this function";

      return false;

    }
   }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

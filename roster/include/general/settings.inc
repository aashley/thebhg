<?php
/**
 * This file contains core objects required for all parts of the Roster
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.16 $
 * @package Roster
 */

/**
 * Settings - Storage for roster settings
 *
 * This object provides access to the settings of the roster which are stored
 * within the roster_settings table
 *
 * <pre>
 *  20030617  aa  updated queries so they definatly go against roster connection
 *  20030616  aa  fixed local filesystem location for cache
 *  20030317  aa  Documentation Fixes.
 *  20030215  aa  Fixed Object Constuctor so its actually run and the DB is
 *                loaded.
 *  20030128  aa  Split settings out of BHG Object to own object to save memory.
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @access public
 * @version $Revision: 1.16 $
 */
class Settings extends BHGObject {
  
  // {{{ properties
  
  /**
   * System Settings
   *
   * This array stores global system settings that maybe required at any point
   *
   * @access private
   * @var array
   * @see GetSetting()
   * @see SaveSetting()
   */
  var $roster_settings = array();

  
  // }}}
  // {{{ Settings()
  
  /**
   * Object Constructor
   *
   * @access public
   * @param string Coder Identification String
   */
  function Settings($coder = '') {
    BHGObject::BHGObject($coder);
    
    $this->roster_settings['imagecache_dir'] = "/home/virtual/site5/fst/var/www/html/cache";
    $this->roster_settings['imagecache_url'] = "http://www.thebhg.org/cache";

    $sql = "SELECT * "
          ."FROM roster_settings";

    $settings = mysql_query($sql, $this->roster_db);

    while ($option = mysql_fetch_array($settings)) {

      $this->roster_settings[stripslashes($option['name'])] =
        stripslashes($option['value']);

    }

    mysql_free_result($settings);

  }

 
  // }}}
  // {{{ GetRealSetting()

  /**
   * Load the value of a setting from the store
   *
   * @access public
   * @param string The name of the Setting you want
   * @return string The Value of the Setting
   */
  function GetRealSetting($name) {

    return $this->roster_settings[$name];

  }

  // }}}
  // {{{ SaveRealSetting()

  /**
   * Change the value of a setting in the store
   *
   * @access public
   * @param string The name of the Setting to change
   * @param string The new value for the setting
   * @return boolean Whether the change succeded
   */
  function SaveRealSetting($name, $value) {
    
    if ($this->Allowed('god')) {

      $check = mysql_query("SELECT name "
                          ."FROM roster_settings "
                          ."WHERE name = '".addslashes($name)."'", $this->roster_db);

      if (mysql_num_rows($check) == 1) {

        $sql = "UPDATE roster_settings "
              ."SET value = '".addslashes($value)."' "
              ."WHERE name = '".addslashes($name)."'";

      } else {

        $sql = "INSERT INTO roster_settings (name, "
                                           ."humanname, "
                                           ."value) "
              ."VALUES ('".addslashes($name)."', "
                      ."'".addslashes($name)."', "
                      ."'".addslashes($value)."')";

      }

      mysql_free_result($check);

      if (mysql_query($sql, $this->roster_db)) {

        return true;

      } else {

        $this->roster_error = "Could not save setting";

        return false;

      }

    } else {

      $this->roster_error = 'The programmer who called this does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

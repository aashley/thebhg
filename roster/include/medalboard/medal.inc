<?
/**
 * This file contains objects required for the Medal Board
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.20 $
 * @package Roster
 * @subpackage MedalBoard
 */

/**
 * Medal - A Medal woohoo!!
 *
 * <pre>
 *  20030408  aa  Documentation Fixes.
 *  20030317  aa  documentation fixes.
 *  20020815  aa  documentation updates
 *  20020814  aa  Read Only completed
 *  20020712  aa  Initial File Creation
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage MedalBoard
 * @access public
 * @version $Revision: 1.20 $
 * @todo All Set* functions need to be completed
 *
 */
class Medal extends BHGObject {

  // {{{ properties

  /**
   * Medal's ID Number
   *
   * @access protected
   * @var integer $medal_id
   * @see GetID()
   */
  var $medal_id;

  /**
   * Medal's Name
   *
   * @access protected
   * @var string $medal_name
   * @see GetName()
   * @see SetName()
   */
  var $medal_name;

  /**
   * Medal's Abbreviation
   *
   * @access protected
   * @var string $medal_abbrev
   * @see GetAbbrev()
   * @see SetAbbrev()
   */
  var $medal_abbrev;

  /**
   * Medal's Group
   *
   * @access protected
   * @var integer $medal_group
   * @see GetGroup()
   * @see SetGroup()
   */
  var $medal_group;

  /**
   * Medal's Image file name
   *
   * @access protected
   * @var integer $medal_image
   * @see GetImageURL()
   * @see GetImageDIR()
   * @see SetImage()
   */
  var $medal_image;

  /**
   * Medal's ordering rank
   *
   * @access protected
   * @var integer $medal_order
   * @see IncreaseWeight()
   * @see DecreaseWeight()
   * @see GetWeight()
   */
  var $medal_order;

  // }}}
  // {{{ Medal()

  /**
   * Object Constructor
   *
   * Calls parent construct and loads relevant data.
   *
   * @access public
   * @param integer ID Number of the Medal
   * @param string  Coder Identification String
   */
  function Medal($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $sql = "SELECT id, "
                 ."name, "
                 ."abbrev, "
                 ."`group`, "
                 ."image, "
                 ."`order` "
          ."FROM mb_medal_names "
          ."WHERE id = ".$id." ";

    $medaldb = mysql_query($sql, $this->roster_db);

    if ($medal = @mysql_fetch_array($medaldb)) {

      $this->medal_id = $medal['id'];
      $this->medal_name = stripslashes($medal['name']);
      $this->medal_abbrev = stripslashes($medal['abbrev']);
      $this->medal_group = $medal['group'];
      $this->medal_image = stripslashes($medal['image']);
      $this->medal_order = $medal['order'];

    } else {

      $this->roster_error = "Invalid Medal ID. Could not create object.".mysql_error();

    }

  }

  
  // }}}
  // {{{ GetID()

  /**
   * Get the ID Number of a Medal
   *
   * @access public
   * @return integer The ID Number
   */
  function GetID() {
    return $this->medal_id;
  }

  
  // }}}
  // {{{ GetName()

  /**
   * Get the Name of a Medal
   *
   * @access public
   * @return string the name
   */
  function GetName() {
    return $this->medal_name;
  }

  
  // }}}
  // {{{ GetAbbrev()

  /**
   * Get the Abbreviation of a Medal
   *
   * @access public
   * @return string the abbreviation
   */
  function GetAbbrev() {
    return $this->medal_abbrev;
  }

  
  // }}}
  // {{{ GetGroup()

  /**
   * Get the Group of a Medal
   *
   * @access public
   * @return object MedalGroup the Group this medal belongs to
   * @uses MedalGroup
   */
  function GetGroup() {
    return new MedalGroup($this->medal_group, $this->roster_coder);
  }

  
  // }}}
  // {{{ GetImageURL()

  /**
   * Get the URL of the Image for this Medal
   *
   * @access public
   * @return string the URL of the image
   */
  function GetImageURL() {
    return $this->GetSetting('imagecache_url')."/medal/".$this->medal_image;
  }

  
  // }}}
  // {{{ GetImageDIR()

  /**
   * Get the DIR of the Image for this Medal
   *
   * @access public
   * @return string the DIR of the image
   */
  function GetImageDIR() {
    return $this->GetSetting('imagecache_dir')."/medal/".$this->medal_image;
  }


  // }}}
  // {{{ HasImage()

  /**
   * Whether this medal has an image or not
   *
   * @access public
   * @return boolean
   */
  function HasImage() {
    return (   $this->medal_image > ""
            && is_file($this->GetImageDIR()));
  }

  
  // }}}
  // {{{ GetOrder()

  /**
   * Get the Order of a Medal
   *
   * @access public
   * @return integer The Order
   */
  function GetOrder() {
    return $this->medal_order;
  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

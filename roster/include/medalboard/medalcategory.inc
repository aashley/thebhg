<?php
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
 * MedalCategory - A Category of Medals woohoo!!<br><br>
 *
 *<pre>
 *  20030408  aa  Documentation Fixes.
 *  20030317  aa  documentation fixes.
 *  20020916  aa  fixed problem in constructor, querying wrong table. Thats
 *                what happens when you build it in 5mins using regex :)
 *                fixed loading of medalgroups
 *  20020815  aa  Initial File Creation. Completed Read-Only functions in 
 *                five minutes. :)
 *</pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage MedalBoard
 * @access public
 * @version $Revision: 1.20 $
 * @todo All Set* functions
 *
 */
class MedalCategory extends BHGObject {

  // {{{ properties

  /**
   * MedalCategory's ID Number
   *
   * @access protected
   * @var integer $medalcategory_id
   * @see GetID()
   */
  var $medalcategory_id;

  /**
   * MedalCategory's Name
   *
   * @access protected
   * @var string $medalcategory_name
   * @see GetName()
   * @see SetName()
   */
  var $medalcategory_name;

  /**
   * MedalCategory's ordering rank
   *
   * @access protected
   * @var integer $medalcategory_order
   * @see IncreaseWeight()
   * @see DecreaseWeight()
   * @see GetWeight()
   */
  var $medalcategory_order;

  // }}}
  // {{{ MedalCategory()

  /**
   * Object Constructor
   *
   * Calls parent construct and loads relevant data.
   *
   * @access public
   * @param integer ID Number of the MedalCategory
   * @param string  Coder Identification String
   */
  function MedalCategory($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $sql = "SELECT id, "
                 ."name, "
                 ."`order` "
          ."FROM mb_medal_categories "
          ."WHERE id = ".$id." ";

    $medalcategorydb = mysql_query($sql, $this->roster_db);

    if ($medalcategory = @mysql_fetch_array($medalcategorydb)) {

      $this->medalcategory_id = $medalcategory['id'];
      $this->medalcategory_name = stripslashes($medalcategory['name']);
      $this->medalcategory_order = $medalcategory['order'];

    } else {

      $this->roster_error = "Invalid MedalCategory ID. Could not create object.";

    }

  }

  
  // }}}
  // {{{ GetID()

  /**
   * Get the ID Number of a MedalCategory
   *
   * @access public
   * @return integer The ID Number
   */
  function GetID() {
    return $this->medalcategory_id;
  }

  
  // }}}
  // {{{ GetName()

  /**
   * Get the Name of a MedalCategory
   *
   * @access public
   * @return string the name
   */
  function GetName() {
    return $this->medalcategory_name;
  }
  
  
  // }}}
  // {{{ GetOrder()

  /**
   * Get the Order of a MedalCategory
   *
   * @access public
   * @return integer The Order
   */
  function GetOrder() {
    return $this->medalcategory_order;
  }


  // }}}
  // {{{ GetMedalGroups()

  /**
   * Get the Medal Groups within this category
   *
   * @access public
   * @return array MedalGroup objects
   * @uses MedalGroup
   */
  function GetMedalGroups() {

    $sql = "SELECT id "
          ."FROM mb_medal_groups "
          ."WHERE category = ".$this->medalcategory_id." "
          ."ORDER BY `order` ASC, "
                   ."name ASC ";

    $medalgroups = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($medalgroup = @mysql_fetch_array($medalgroups)) {

      $return[] = new MedalGroup($medalgroup['id'], $this->roster_coder);

    }

    return $return;

  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

<?php 
/**
 * This file contains objects required for the Medal Board
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.24 $
 * @package Roster
 * @subpackage MedalBoard
 */

/**
 * MedalGroup - A Grouping Medal woohoo!!
 *
 * <pre>
 *  20030408  aa  Documentation Fixes.
 *  20030317  aa  documentation fixes.
 *  20020917  aa  added GetDescription and GetAwardedMedals
 *  20020916  aa  fixes to the loading of medals
 *  20020916  aa  fixed loading of medal groups
 *  20020815  aa  oops forgot GetMedals :) 
 *  20020814  aa  Initial File Creation
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage MedalBoard
 * @access public
 * @version $Revision: 1.24 $
 * @todo All Set* functions
 *
 */
class MedalGroup extends BHGObject {

  // {{{ properties

  /**
   * MedalGroup's ID Number
   *
   * @access protected
   * @var integer $medalgroup_id
   * @see GetID()
   */
  var $medalgroup_id;

  /**
   * MedalGroup's Name
   *
   * @access protected
   * @var string $medalgroup_name
   * @see GetName()
   * @see SetName()
   */
  var $medalgroup_name;

  /**
   * MedalGroup's Abbreviation
   *
   * @access protected
   * @var string $medalgroup_abbrev
   * @see GetAbbrev()
   * @see SetAbbrev()
   */
  var $medalgroup_abbrev;

  /**
   * MedalGroup's Category
   *
   * @access protected
   * @var integer $medalgroup_category
   * @see GetCategory()
   * @see SetCategory()
   */
  var $medalgroup_category;

  /**
   * MedalGroup's Multiple Setting
   *
   * TODO: remember what this does and describe it
   *
   * @access protected
   * @var integer $medalgroup_multiple
   * @see GetMultiple()
   * @see SetMultiple()
   */
  var $medalgroup_multiple;

  /**
   * MedalGroup's Display Type Setting
   *
   * This controls how a medal is display in the idline
   *
   * @access protected
   * @var integer $medalgroup_displaytype
   * @see GetDisplayType()
   * @see SetDisplayType()
   */
  var $medalgroup_displaytype;

  /**
   * MedalGroup's Start Bracket Setting
   *
   * The Start bracket to use when displaying this medal in an idline
   *
   * @access protected
   * @var integer $medalgroup_startbracket
   * @see GetStartBracket()
   * @see SetStartBracket()
   */
  var $medalgroup_startbracket;

  /**
   * MedalGroup's End Bracket Setting
   *
   * The End bracket to use when displaying this medal in an idline
   *
   * @access protected
   * @var integer $medalgroup_endbracket
   * @see GetEndBracket()
   * @see SetEndBracket()
   */
  var $medalgroup_endbracket;

  /**
   * MedalGroup's ordering rank
   *
   * @access protected
   * @var integer $medalgroup_order
   * @see IncreaseWeight()
   * @see DecreaseWeight()
   * @see GetWeight()
   */
  var $medalgroup_order;

  // }}}
  // {{{ MedalGroup()

  /**
   * Object Constructor
   *
   * Calls parent construct and loads relevant data.
   *
   * @access public
   * @param integer ID Number of the MedalGroup
   * @param string  Coder Identification String
   */
  function MedalGroup($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $sql = "SELECT id, "
                 ."name, "
                 ."abbrev, "
                 ."category, "
                 ."multiple, "
                 ."displaytype, "
                 ."startbracket, "
                 ."endbracket, "
                 ."`order` "
          ."FROM mb_medal_groups "
          ."WHERE id = ".$id." ";

    $medalgroupdb = mysql_query($sql, $this->roster_db);

    if ($medalgroup = mysql_fetch_array($medalgroupdb)) {

      $this->medalgroup_id = $medalgroup['id'];
      $this->medalgroup_name = stripslashes($medalgroup['name']);
      $this->medalgroup_abbrev = stripslashes($medalgroup['abbrev']);
      $this->medalgroup_category = $medalgroup['category'];
      $this->medalgroup_multiple = $medalgroup['multiple'];
      $this->medalgroup_displytype = $medalgroup['displaytype'];
      $this->medalgroup_startbracket = 
        stripslashes($medalgroup['startbracket']);
      $this->medalgroup_endbracket = stripslashes($medalgroup['endbracket']);
      $this->medalgroup_order = $medalgroup['order'];

    } else {

      $this->roster_error = "Invalid MedalGroup ID. Could not create object.";

    }

  }

  
  // }}}
  // {{{ GetID()

  /**
   * Get the ID Number of a MedalGroup
   *
   * @access public
   * @return integer The ID Number
   */
  function GetID() {
    return $this->medalgroup_id;
  }

  
  // }}}
  // {{{ GetName()

  /**
   * Get the Name of a MedalGroup
   *
   * @access public
   * @return string the name
   */
  function GetName() {
    return $this->medalgroup_name;
  }

  
  // }}}
  // {{{ GetAbbrev()

  /**
   * Get the Abbreviation of a MedalGroup
   *
   * @access public
   * @return string the abbreviation
   */
  function GetAbbrev() {
    return $this->medalgroup_abbrev;
  }

  
  // }}}
  // {{{ GetCategory()

  /**
   * Get the Category of a MedalGroup
   *
   * @access public
   * @return object MedalCategory the Category this medalgroup belongs to
   * @uses MedalCategory
   */
  function GetCategory() {
    return new MedalCategory($this->medalgroup_category, $this->roster_coder);
  }

  
  // }}}
  // {{{ GetMultiple()

  /**
   * Get the Multiple Setting for this MedalGroup
   *
   * @access public
   * @return integer the setting
   */
  function GetMultiple() {
    return $this->medalgroup_multiple;
  }

  
  // }}}
  // {{{ GetDisplayType()

  /**
   * Get the Display Type Setting for this MedalGroup
   *
   * @access public
   * @return integer the display type
   */
  function GetDisplayType() {
    return $this->medalgroup_displaytype;
  }


  // }}}
  // {{{ GetStartBracket()

  /**
   * Get the Start Bracket for this medal groupt
   *
   * @access public
   * @return string the start bracket
   */
  function GetStartBracker() {
    return $this->medalgroup_startbracket;
  }

  
  // }}}
  // {{{ GetEndBracket()

  /**
   * Get the End Bracket for this medal groupt
   *
   * @access public
   * @return string the end bracket
   */
  function GetEndBracker() {
    return $this->medalgroup_endbracket;
  }

  
  // }}}
  // {{{ GetOrder()

  /**
   * Get the Order of a MedalGroup
   *
   * @access public
   * @return integer The Order
   */
  function GetOrder() {
    return $this->medalgroup_order;
  }


  // }}}
  // {{{ GetMedals()

  /**
   * Get the medals in this group
   *
   * Returns an array of medal objects. Sorted according to the sorting order
   * specified in the medals.
   *
   * @access public
   * @return array Medal Objects
   * @uses Medal
   */
  function GetMedals() {

    $sql = "SELECT id "
          ."FROM mb_medal_names "
          ."WHERE `group` = ".$this->medalgroup_id." "
          ."ORDER BY `order` ASC, "
                   ."name ASC";

    $medals = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($medal = mysql_fetch_array($medals)) {

      $return[] = new Medal($medal['id'], $this->roster_coder);

    }

    return $return;
    
  }

  // }}}
  // {{{ GetAwardedMedals()

  /**
   * Get the medals that have been awarded in this group
   *
   * @access public
   * @return array AwardedMedal
   * @uses AwardedMedal
   */
  function GetAwardedMedals() {

    $sql = "SELECT mb_awarded_medals.id "
          ."FROM mb_awarded_medals, "
               ."mb_medal_names "
          ."WHERE mb_medal_names.`group` = ".$this->medalgroup_id." "
            ."AND mb_medal_names.id = mb_awarded_medals.medal "
          ."ORDER BY mb_awarded_medals.`date` ASC, "
                   ."mb_medal_names.`order` ASC, "
                   ."mb_medal_names.name ";

    $medals = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($medal = mysql_fetch_array($medals)) {

      $return[] = new AwardedMedal($medal['id'], $this->roster_coder);

    }

    return $return;

  }

  // }}}
  // {{{ GetDescription()

  /**
   * Get the long text description of this medal group
   *
   * This function loads the data itself instead of loading it in at object
   * creation for two reasons. 1) The data is stored in a seperate table, and
   * 2) which is more important, this data is accessed so infrequently that 
   * loading it with the object everytime is a lot of unnessesary overhead.
   *
   * @access public
   * @return string The Description
   */
  function GetDescription() {

    $sql = "SELECT html "
          ."FROM mb_medal_descriptions "
          ."WHERE `group` = ".$this->medalgroup_id;

    $result = mysql_query($sql, $this->roster_db);

    if ($result && mysql_num_rows($result) > 0) {
      
      return stripslashes(mysql_result($result, 0, 'html'));

    } else {

      return "";

    }

  }

  // }}}
  
}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

<?php
/**
 * This file contains objects required for the Core Roster Functionality
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.21 $
 * @package Roster
 * @subpackage Roster
 */

/**
 * Position - A Position that a person can hold
 *
 * weeee
 *
 * <pre>
 *  20030317  aa  documentation fixes.
 *  20020105  aa  added flag for whether this position has an email forwarder
 *  20021218  ah  added support for special divisions
 *  20020522  aa  documented it
 * </pre>
 * 
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Roster
 * @access public
 * @version $Revision: 1.21 $
 */
class Position extends BHGObject {

  // {{{ properties

  /**
   * Position's ID Number
   *
   * @access protected
   * @var integer position_id
   * @see GetID()
   */
  var $position_id;

  /**
   * Position's Name
   *
   * @access protected
   * @var integer position_name
   * @see GetName()
   */
  var $position_name;

  /**
   * Position's Abbreviation
   *
   * @access protected
   * @var integer position_abbrev
   * @see GetAbbrev()
   */
  var $position_abbrev;

  /**
   * Position's Monthly Income
   *
   * @access protected
   * @var integer position_income
   * @see GetIncome()
   */
  var $position_income;

  /**
   * Position's Weighting
   *
   * @access protected
   * @var integer position_order
   * @see GetWeight()
   * @see IncreaseWeight()
   * @see DecreaseWeight()
   */
  var $position_order;

  /**
   * Whether this position is consider to be a trainee
   *
   * Whether to consider this position as a trainee for the purposes of deciding
   * what rank a person can get to while holding this position
   *
   * @access protected
   * @var integer position_id
   * @see IsTrainee()
   */
  var $position_istrainee;

  /**
   * Special division name for this position
   *
   * @access protected
   * @var string position_special_division
   * @see GetSpecialDivision()
   * @see SetSpecialDivision()
   */
  var $position_special_division;

  /**
   * Flag for whether we create an email alias for this position
   *
   * @access protected
   * @var integer position_is_email_alias
   * @see IsEmailAlias()
   * @see SetEmailAlias()
   */
  var $position_is_email_alias;

  // }}}
  // {{{ Position()
  
  /**
   * Object Constructor
   *
   * call parent constructor and load relevant data
   *
   * @access public
   * @param integer id Position ID Number
   * @param string coder Coder Identification String
   */
  function Position($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $sql = "SELECT id, "
                 ."name, "
                 ."abbrev, "
                 ."income, "
                 ."istrainee, "
                 ."special_division, "
                 ."is_email_alias, "
                 ."`order` "
          ."FROM roster_position "
          ."WHERE id = $id";
          
    $positiondb = mysql_query($sql, $this->roster_db);
    
    if ($position = @mysql_fetch_array($positiondb)) {
      
      $this->position_id = $position["id"];
      $this->position_name = $position["name"];
      $this->position_abbrev = $position["abbrev"];
      $this->position_income = $position["income"];
      $this->position_order = $position["order"];
      $this->position_istrainee = $position["istrainee"];
      $this->position_special_division = $position["special_division"];
      $this->position_is_email_alias = $position["is_email_alias"];
      
    } else {
      
      $this->roster_error = "Invalid Position ID ($id). "
        ."Could not create object.";
        
    }
    
  }

  // }}}
  // {{{ GetID()

  /**
   * Get A Positions ID Number
   *
   * @access public
   * @return integer The ID Number
   */
  function GetID() {
    return $this->position_id;
  }

  // }}}
  // {{{ GetName()

  /**
   * Get A Positions Name
   *
   * @access public
   * @return string the name
   */
  function GetName() {
    return $this->position_name;
  }

  // }}}
  // {{{ GetAbbrev()

  /**
   * Get A Positions Abbreviation
   *
   * @access public
   * @return string The Abbreviation
   */
  function GetAbbrev() {
    return $this->position_abbrev;
  }

  // }}}
  // {{{ GetIncome()

  /**
   * Get A Positions Income
   *
   * @access public
   * @return integer The Income
   */
  function GetIncome() {
    return $this->position_income;
  }

  // }}}
  // {{{ GetWeight()

  /**
   * Get A Positions Weight
   *
   * @access public
   * @return integer The Weight
   */
  function GetWeight() {
    return $this->position_order;
  }

  // }}}
  // {{{ IsTrainee()

  /**
   * Is this Position consider to be a Trainee
   *
   * @access public
   * @return integer Whether this position is a trainee
   */
  function IsTrainee() {
    return $this->position_istrainee;
  }

  // }}}
  // {{{ GetSpecialDivision()
  
  /**
   * Gets the special division for this position
   *
   * If this is a non-empty string, this string will be used as the division
   * in ID lines for hunters holding this position.
   *
   * @access public
   * @return string The special division name
   */
  function GetSpecialDivision() {
    return $this->position_special_division;
  }

  // }}}
  // {{{ IsEmailAlias()

  /**
   * Check whether we are setting an email alias for this pos
   *
   * @access public
   * @return boolean
   */
  function IsEmailAlias() {
    return ($this->position_is_email_alias == 1);
  }

  // }}}
  // {{{ TODO: IncreaseWeight()

  /**
   * Increase A Positions Internal Weighting
   *
   * @access public
   * @return boolean whether the update worked
   * @todo Complete This Function
   */
  function IncreaseWeight() {
  }

  // }}}
  // {{{ TODO: DecreaseWeight()

  /**
   * Decrease A Positions Internal Weighting
   *
   * @access public
   * @return boolean whether the update worked
   * @todo Complete This Function
   */
  function DecreaseWeight() {
  }

  // }}}
  // {{{ TODO: SetName()

  /**
   * Set A Positions Name
   *
   * @access public
   * @return boolean whether the update worked
   * @todo Complete This Function
   */
  function SetName() {
  }

  // }}}
  // {{{ TODO: SetAbbrev()

  /**
   * Set A Positions Abbreviation
   *
   * @access public
   * @return boolean whether the update worked
   * @todo Complete This Function
   */
  function SetAbbrev() {
  }

  // }}}
  // {{{ TODO: SetIncome()

  /**
   * Set A Positions Income
   *
   * @access public
   * @return boolean whether the update worked
   * @todo Complete This Function
   */
  function SetIncome() {
  }

  // }}}
  // {{{ TODO: SetSpecialDivision()

  /**
   * Sets the special division for the position
   *
   * @access public
   * @return boolean whether the update succeeded
   * @todo Complete This Function
   */
  function SetSpecialDivision() {
  }

  // }}}
  // {{{ TODO: SetEmailAlias()

  /**
   * Set the flag for whether we do an alias here
   *
   * @access public
   * @return booean whether the update succeeded
   * @todo Complete This Function
   */
  function SetEmailAlias() {
  }

  // }}}
  // {{{ TODO: Delete()

  /**
   * Delete This Position
   *
   * After calling this the position object should be unset as it no longer
   * refers to a valid position.
   *
   * @access public
   * @return boolean whether the update worked
   * @todo Complete This Function
   */
  function Delete() {
  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

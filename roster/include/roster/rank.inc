<?php
/**
 * This file contains objects required for the Core Roster Functionality
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.20 $
 * @package Roster
 * @subpackage Roster
 */

/**
 * Rank - A rank that a person can hold
 *
 * bleh
 *
 * <pre>
 *  20030925  aa  added Comparison Functions
 *  20030317  aa  documentation fixes
 *  20020815  aa  documentation fixes
 *  20020522  aa  documented it
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Roster
 * @access public
 * @version $Revision: 1.20 $
 */
class Rank extends BHGObject {

  // {{{ properties
  
  /**
   * Rank's ID Number
   *
   * @access protected
   * @var integer rank_id
   * @see GetID()
   */
  var $rank_id;

  /**
   * Rank's Name
   *
   * @access protected
   * @var string rank_name
   * @see GetName()
   */
  var $rank_name;

  /**
   * Rank's Abbreviation
   *
   * @access protected
   * @var string rank_abbrev
   * @see GetAbbrev()
   */
  var $rank_abbrev;

  /**
   * Credits Needed to achieve this rank
   *
   * @access protected
   * @var integer rank_credits_needed
   * @see GetCreditsNeeded()
   */
  var $rank_credits_needed;

  /**
   * Whether the rank is always available
   *
   * If a rank is always available then you can achieve this rank even while
   * holding the position of Trainee
   *
   * @access protected
   * @var integer rank_always_available
   * @see IsAlwaysAvailable()
   */
  var $rank_always_available;

  /**
   * Does someone holding this rank have unlimited credits
   *
   * @access protected
   * @var integer rank_unlimited_credits
   * @see IsUnlimitedCredits()
   */
  var $rank_unlimited_credits;

  /**
   * Does this rank need to be manually set
   *
   * @access protected
   * @var integer rank_manual_set
   * @see IsManuallySet()
   * @see SetManuallySet()
   */
  var $rank_manual_set;

  /**
   * Internal ordering of ranks
   *
   * @access protected
   * @var integer rank_order
   * @see IncreaseWeight()
   * @see DecreaseWeight()
   * @see GetWeight()
   */
  var $rank_order;

  // }}}
  // {{{ Rank()

  /**
   * Object Constructor
   *
   * calls the parent constructor, and loads the relevant data
   *
   * @access public
   * @param integer id ID Number of the rank
   * @param string coder Coder Identification String
   */
  function Rank($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $sql = "SELECT id, "
                 ."name, "
                 ."abbrev, "
                 ."credits_needed, "
                 ."always_available, "
                 ."unlimited_credits, "
                 ."manual_set, "
                 ."`order` "
          ."FROM roster_rank "
          ."WHERE id = $id";
          
    $rankdb = mysql_query($sql, $this->roster_db);
    
    if ($rank = @mysql_fetch_array($rankdb)) {
      
      $this->rank_id = $rank["id"];
      $this->rank_name = $rank["name"];
      $this->rank_abbrev = $rank["abbrev"];
      $this->rank_credits_needed = $rank["credits_needed"];
      $this->rank_always_available = $rank["always_available"];
      $this->rank_unlimited_credits = $rank["unlimited_credits"];
      $this->rank_manual_set = $rank["manual_set"];
      $this->rank_order = $rank["order"];
      
    } else {
      
      $this->roster_error = "Invalid Rank ID. Could not create object.";
      
    }
    
  }

  // }}}
  // {{{ GetID()

  /**
   * Get A Rank's ID Number
   *
   * @access public
   * @return integer The Rank's ID Number
   */
  function GetID() {
    return $this->rank_id;
  }

  // }}}
  // {{{ GetName
 
  /**
   * Get A Rank's Name
   *
   * @access public
   * @return string The Rank's name
   */
  function GetName() {
    return $this->rank_name;
  }

  // }}}
  // {{{ GetAbbrev()
 
  /**
   * Get A Rank's Abbreviation
   *
   * @access public
   * @return string The Rank's Abbreviation
   */
  function GetAbbrev() {
    return $this->rank_abbrev;
  }

  // }}}
  // {{{ GetRequiredCredits()
 
  /**
   * Get A Rank's Required Number of Credits
   *
   * @access public
   * @return integer The Rank's required number of credits
   */
  function GetRequiredCredits() {
    return $this->rank_credits_needed;
  }

  // }}}
  // {{{ IsAlwaysAvailable()
   
  /**
   * Is this rank always available
   *
   * If a rank is always available then you can achieve this rank even while
   * holding the position of Trainee
   *
   * @access public
   * @return boolean whether the rank is always available or not
   */
  function IsAlwaysAvailable() {
    if ($this->rank_always_available == 1) {
      return true;
    } else {
      return false;
    }
  }
  
  // }}}
  // {{{ IsUnlimitedCredits()
 
  /**
   * Does this rank mean unlimited credits for the holder
   *
   * @access public
   * @return boolean whether the holder gets unlimited credits or not
   */
  function IsUnlimitedCredits() {
    if ($this->rank_unlimited_credits == 1) {
      return true;
    } else {
      return false;
    }
  }

  // }}}
  // {{{ IsManuallySet()

  /**
   * Does this rank need to be set manually
   *
   * If true then the automatic UpdateRank can not set this rank. It must be set
   * manually by a person from an interface.
   *
   * @access public
   * @return boolean whether the rank needs to be manually set
   */
  function IsManuallySet() {
    if ($this->rank_manual_set == 1) {
      return true;
    } else {
      return false;
    }
  }

  // }}}
  // {{{ GetWeight()

  /**
   * Get A Rank's Weight
   *
   * Weights are order from 1 most important to n least important
   *
   * @access public
   * @return integer The Rank's Weight
   */
  function GetWeight() {
    return $this->rank_order;
  }

  // }}}
  // {{{ GreaterThan()
  
  function GreaterThan($otherrank) {

    if (is_object($otherrank)) {

      if ($otherrank instanceof Rank) {

      } else {

        $this->roster_error = 'Invalid Object passed to Rank::GreaterThan().';

        return false;

      }

    } elseif (is_numeric($otherrank)) {

      $otherrank = new Rank($otherrank, $this->roster_coder);

    } else {

      $this->roster_error = 'Invalid Parameter passed to Rank::GreaterThan().';

      return false;

    }

    return ($this->GetWeight() < $otherrank->GetWeight());

  }

  // }}}
  // {{{ LessThan()

  function LessThan($otherrank) {

    if (is_object($otherrank)) {

      if ($otherrank instanceof Rank) {

      } else {

        $this->roster_error = 'Invalid Object passed to Rank::LessThan().';

        return false;

      }

    } elseif (is_numeric($otherrank)) {

      $otherrank = new Rank($otherrank, $this->roster_coder);

    } else {

      $this->roster_error = 'Invalid Parameter passed to Rank::LessThan().';

      return false;

    }

    return ($this->GetWeight() > $otherrank->GetWeight());

  }

  // }}}
  // {{{ GreaterThanOrEqual()

  function GreaterThanOrEqual($otherrank) {

    if (is_object($otherrank)) {

      if ($otherrank instanceof Rank) {

      } else {

        $this->roster_error = 'Invalid Object passed to '
          .'Rank::GreaterThanOrEqual().';

        return false;

      }

    } elseif (is_numeric($otherrank)) {

      $otherrank = new Rank($otherrank, $this->roster_coder);

    } else {

      $this->roster_error = 'Invalid Parameter passed to '
        .'Rank::GreaterThanEqual().';

      return false;

    }

    return ($this->GetWeight() <= $otherrank->GetWeight());

  }

  // }}}
  // {{{ LessThanOrEqual()

  function LessThanOrEqual($otherrank) {

    if (is_object($otherrank)) {

      if ($otherrank instanceof Rank) {

      } else {

        $this->roster_error = 'Invalid Object passed to '
          .'Rank::LessThanOrEqual().';

        return false;

      }

    } elseif (is_numeric($otherrank)) {

      $otherrank = new Rank($otherrank, $this->roster_coder);

    } else {

      $this->roster_error = 'Invalid Parameter passed to '
        .'Rank::LessThanOrEqual().';

      return false;

    }

    return ($this->GetWeight() >= $otherrank->GetWeight());

  }

  // }}}
  // {{{ TODO: IncreaseWeight()

  /**
   * Increase a Rank's Weight
   *
   * @access public
   * @return boolean whether the increase worked
   * @todo Complete This Function
   */
  function IncreaseWeight() {
  }

  // }}}
  // {{{ TODO: DecreaseWeight()

  /**
   * Decrease a Rank's Weight
   *
   * @access public
   * @return boolean whether the decrease worked
   * @todo Complete This Function
   */
  function DecreaseWeight()  {
  }

  // }}}
  // {{{ TODO: SetName()

  /**
   * Set A Rank's Name
   *
   * @access public
   * @param string name The new Name
   * @return boolean whether the change succeded or not
   * @todo Complete This Function
   */
  function SetName($name) {
  }

  // }}}
  // {{{ TODO: SetAbbrev()

  /**
   * Set A Rank's Abbreviation
   *
   * @access public
   * @param string abbrev the new abbreviation
   * @return boolean whether the change succeded or not
   * @todo Complete This Function
   */
  function SetAbbrev($abbrev) {
  }

  // }}}
  // {{{ TODO: SetRequiredCredits()

  /**
   * Set A Rank's Required Credits
   *
   * @access public
   * @param integer credits New number of required credits
   * @return boolean whether the change succeded or not
   * @todo Complete This Function
   */
  function SetRequiredCredits($credits) {
  }

  // }}}
  // {{{ TODO: SetAlwaysAvailable

  /**
   * Set Whether Rank is always available
   *
   * @access public
   * @param boolean available 
   * @return boolean whether the change succeded or not
   * @todo Complete This Function
   */
  function SetAlwaysAvailable($available) {
  }

  // }}}
  // {{{ TODO: SetUnlimitedCredits()

  /**
   * Set Whether Rank has unlimited credits
   *
   * @access public
   * @param boolean unlimited
   * @return boolean whether the change succeded or not
   * @todo Complete This Function
   */
  function SetUnlimitedCredits($unlimited) {
  }

  // }}}
  // {{{ TODO: SetManuallySet()

  /**
   * Set Whether a rank needs to be manually set
   *
   * @access public
   * @param boolean manual
   * @return boolean whether the change succeded or not
   * @todo Complete This Function
   */
  function SetManuallySet($manual) {
  }

  // }}}
  // {{{ TODO: Delete()

  /**
   * Delete This Rank
   *
   * After Calling this the object should be unset as the details it refered to
   * no longer exist. A Delete will not work if there is anyone holding this
   * rank.
   *
   * @access public
   * @return boolean whether the delete succeded or not
   * @todo Complete This Function
   */
  function Delete() {
  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

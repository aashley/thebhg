<?php
/**
 * This file contains objects required for the Medal Board
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.15 $
 * @package Roster
 * @subpackage MedalBoard
 */

/**
 * Awarded Medal
 *
 * This is a record of a medal that was been awarded to someone... dah!
 *
 * <pre>
 *  20030408  aa  Documentation Fixes.
 *  20030317  aa  documentation fixes.
 *  20020815  aa  code started. completed read only functionality.
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage MedalBoard
 * @access public
 * @version $Revision: 1.15 $
 *
 */
class AwardedMedal extends BHGObject {

  // {{{ properties

  /**
   * ID Number
   *
   * @access protected
   * @var integer $award_id
   * @see GetID()
   */
  var $award_id;

  /**
   * ID Number of the Medal Recipient
   *
   * @access protected
   * @var integer $award_recipient
   * @see GetRecipient()
   */
  var $award_recipient;

  /**
   * ID Number of the Medal Awarder
   *
   * @access protected
   * @var integer $award_awarder
   * @see GetAwarder()
   */
  var $award_awarder;

  /**
   * ID Number of the Medal
   *
   * @access protected
   * @var integer $award_medal
   * @see GetMedal()
   */
  var $award_medal;

  /**
   * The Reason why medal was awarded
   *
   * @access protected
   * @var string $award_why
   * @see GetReason()
   */
  var $award_why;

  /**
   * The Date on which the medal was awarded
   *
   * @access protected
   * @var integer $award_date
   * @see GetDate()
   */
  var $award_date;

  // }}}
  // {{{ AwardedMedal

  /**
   * Object Contructor
   *
   * blah it does the usual kinda thing you know
   *
   * @access public
   * @param integer ID Number of the Awarded Medal
   * @param string  Coder Identification String
   */
  function AwardedMedal($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $sql = "SELECT id, "
                 ."recipientid, "
                 ."awarderid, "
                 ."medal, "
                 ."why, "
                 ."date "
          ."FROM mb_awarded_medals "
          ."WHERE id = ".$id." ";

    $medaldb = mysql_query($sql, $this->roster_db);

    if ($medal = @mysql_fetch_array($medaldb)) {

      $this->award_id = $medal['id'];
      $this->award_recipient = $medal['recipientid'];
      $this->award_awarder = $medal['awarderid'];
      $this->award_medal = $medal['medal'];
      $this->award_why = stripslashes($medal['why']);
      $this->award_date = $medal['date'];

    } else {

      $this->roster_error = "Invalid Awarded Medal ID. Could not create object.";

    }

  }

  // }}}
  // {{{ GetID

  /**
   * Get the ID Number of the Awarded Medal
   *
   * @access public
   * @return integer
   */
  function GetID() {
    return $this->award_id;
  }
  
  // }}}
  // {{{ GetRecipient

  /**
   * Get the Recipient of the Awarded Medal
   *
   * @access public
   * @return object Person
   * @uses Person
   */
  function GetRecipient() {
    return new Person($this->award_recipient, $this->roster_coder);
  }
  
  // }}}
  // {{{ GetAwarder

  /**
   * Get the Awarder of the Awarded Medal
   *
   * @access public
   * @return object Person
   * @uses Person
   */
  function GetAwarder() {
    return new Person($this->award_awarder, $this->roster_coder);
  }
  
  // }}}
  // {{{ GetMedal

  /**
   * Get the Medal which has been Awarded
   *
   * @access public
   * @return object Medal
   * @uses Medal
   */
  function GetMedal() {
    return new Medal($this->award_medal, $this->roster_coder);
  }
  
  // }}}
  // {{{ GetReason

  /**
   * Get the Reason for the Awarded Medal
   *
   * @access public
   * @return string
   */
  function GetReason() {
    return $this->award_why;
  }
  
  // }}}
  // {{{ GetDate

  /**
   * Get the Date the Medal was awarded
   *
   * @access public
   * @return integer
   */
  function GetDate() {
    return $this->award_date;
  }
  
  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

<?php
/**
 * This file contains objects required for the Medal Board
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.29 $
 * @package Roster
 * @subpackage MedalBoard
 */

/**
 * MedalBoard - The Medal Board in all its glory
 * 
 * <pre>
 *  20030619  aa  standardised on boolean returns
 *  20030424  ah  Fixed a bug that was causing history events when a medal was
 *                awarded to be created for the awarder and not the recipient.
 *  20030408  aa  Documentation Fixes.
 *  20030317  aa  documentation fixes.
 *  20030215  aa  added cc of awarded medal emails to chiefs
 *  20021028  aa  added recording of histor to awardmedal
 *  20021026  aa  fixed awardmedal
 *  20020916  aa  fixed bad function call
 *  20020601  aa  email notification on medal award complete
 *  20020317  AA  Initial Version
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage MedalBoard
 * @access public
 * @version $Revision: 1.29 $
 *
 */
class MedalBoard extends BHGObject {

  // {{{ MedalBoard()

  /**
   * Object Constructor
   *
   * All it does is call the constructor of the BHGObject
   *
   * @access public
   * @param string coder Coder Identification String
   */
  function MedalBoard($coder = '') {
    BHGObject::BHGObject($coder);
  }

  // }}}
  // {{{ AwardMedal

  /**
   * Award a Medal to Someone
   *
   * @access public
   * @param integer ID number of the person getting the medal can also be
   *                a object of type Person
   * @param integer ID number of the person giving the medal. can also be a
   *                object of type Person
   * @param integer ID number of the medal to award. can also be a object of 
   *                type medal
   * @param string  The reason why the person is getting the medal
   * @param integer The date this medal was awarded in unixtime. If left 
   *                at the default value of 0 then the current time is 
   *                used.
   * @return boolean
   * @uses BHGObject::Allowed()
   * @uses BHGObject::GetSetting()
   * @uses Person
   * @uses Person::GetID()
   * @uses Person::RecordEvent()
   * @uses Person::GetDivision()
   * @uses Person::SendEmail()
   * @uses Person::GetName()
   * @uses Person::GetEmail()
   * @uses Person::IDLine()
   * @uses Medal
   * @uses Medal::GetID()
   * @uses Medal::GetName()
   * @uses Division
   * @uses Division::IsKabal()
   * @uses Kabal
   * @uses Kabal::GetChief()
   * @uses ParseEmailTemplate()
   */
  function AwardMedal($recipient, $awarder, $medal, $reason, $date = 0) {
    
    if ($this->Allowed('medalaward')) {

      // Make sure we have a valid recipient id

      $recipient_id = 0;
      
      if (is_object($recipient)) {
        
        if ($recipient instanceof Person) {
          
          $recipient_id = $recipient->GetID();
          
        } else {
          
          $this->roster_error = "Invalid Object passed as Recipient";
          
          return false;
          
        }
        
      } elseif (is_numeric($recipient)) {
        
        // We could place a check that queried the database to see if this
        // really is a valid id number
        $recipient_id = $recipient;
        
      } else {
        
        $this->roster_error = "Invalid Value passed as Recipient";
        
        return false;
        
      }

      // if the recipient number is still zero we couldnt find a valid one
      if (!$recipient_id) {
        
        $this->roster_error = "Could not load recipients ID number";
        
        return false;
        
      }


      // Check the awarder ID
      
      $awarder_id = 0;
      
      if (is_object($awarder)) {
        
        if ($awarder instanceof Person) {
          
          $awarder_id = $awarder->GetID();
          
        } else {
          
          $this->roster_error = "Invalid Object passed as Awarder";
          
          return false;
          
        }
        
      } elseif (is_numeric($awarder)) {
        
        $awarder_id = $awarder;
        
      } else {
        
        $this->roster_error = "Invalid Value passed as Awarder";
        
        return false;
        
      }

      if (!$awarder_id) {
        
        $this->roster_error = "Could not load awarders ID number";
        
        return false;
        
      }
      

      // Check the Medal
      
      $medal_id = 0;
      
      if (is_object($medal)) {
        
        if ($medal instanceof Medal) {
          
          $medal_id = $medal->GetID();
          
        } else {
          
          $this->roster_error = "Invalid Object passed as Medal";
          
          return false;
          
        }
        
      } elseif (is_numeric($medal)) {
        
        $medal_id = $medal;
        
      } else {
        
        $this->roster_error = "Invalid Value passed as Medal";
        
        return false;
        
      }

      if (!$medal_id) {
        
        $this->roster_error = "Could not load medals ID number";
        
        return false;
        
      }


      // Build the SQL
      
      $sql = "INSERT INTO mb_awarded_medals (recipientid, "
                                           ."awarderid, "
                                           ."medal, "
                                           ."why, "
                                           ."date) "
            ."VALUES (".$recipient_id.", "
                       .$awarder_id.", "
                       .$medal_id.", "
                     ."'".addslashes($reason)."', "
                       .(($date == 0) ? time() : $date).")";

      // Run the query
      if (mysql_query($sql, $this->roster_db)) {

        $awardid = mysql_insert_id();

        $person = new Person($recipient_id);

        $GLOBALS['internalexecute'] = 'history';

        $person->RecordEvent(8, $awardid);

        unset($person);

        $message = $this->GetSetting('awardedmedal');

        if ($message > "") {

          $replace = array();

          $recipient = new Person($recipient_id, $this->roster_coder);

          $rdiv = $recipient->GetDivision();

          $awarder = new Person($awarder_id, $this->roster_coder);

          $medal = new Medal($medal_id, $this->roster_coder);

          $replace['%recipient_name%'] = $recipient->GetName();
          $replace['%recipient_email%'] = $recipient->GetEmail();
          $replace['%recipient_idline%'] = $recipient->IDLine();
          $replace['%awarder_name%'] = $awarder->GetName();
          $replace['%awarder_email%'] = $awarder->GetEmail();
          $replace['%medal_name%'] = $medal->GetName();
          $replace['%reason%'] = $reason;

          $message = ParseEmailTemplate($message, $replace);

          $recipient->SendEmail("roster@thebhg.org",
                                "[Roster] Congratulations "
                                .$recipient->GetName()." you have recieved a "
                                ."medal",
                                $message);

          $awarder->SendEmail("roster@thebhg.org",
                              "[Roster] Congratulations "
                              .$recipient->GetName()." you have recieved a "
                              ."medal",
                              $message);

          if ($rdiv->IsKabal()) {

            $rkabal = new Kabal($rdiv->GetID(), $this->roster_coder);

            $chief = $rkabal->GetChief();

            $chief->SendEmail("roster@thebhg.org",
                              "[Roster] Congratulations "
                              .$recipient->GetName()." you have recieved a "
                              ."medal",
                              $message);

            unset($chief, $rkabal);

          }

        }

        return true;

      } else {

        $this->roster_error = "Could not award medal";

        return false;

      }

    } else {

      $this->roster_error = "The coder that created this program doesnt not "
        ."have permission to call this function";

      return false;

    }
        
  }

  // }}}
  // {{{ GetMedalCategories()
  
  /**
   * Get All Medal Categories
   *
   * @access public
   * @return array MedalCategories An array of Medal Category objects
   * @uses MedalCategory
   */
  function GetMedalCategories() {
    
    $sql = "SELECT id FROM mb_medal_categories ORDER BY `order`";

    $return = array();

    $categories = mysql_query($sql, $this->roster_db);

    while ($cat = mysql_fetch_array($categories)) {

      array_push($return, new MedalCategory($cat['id'], $this->roster_coder));

    }

    return $return;
    
  }

  // }}}
  // {{{ GetMedalCategory()

  /**
   * Get A Specific Medal Category
   *
   * @access public
   * @param integer The ID number of the requested Category
   * @return object MedalCategory
   * @uses MedalCategory
   */
  function GetMedalCategory($id) {
  
    return new MedalCategory($id, $this->roster_coder);
  
  }

  // }}}
  // {{{ GetMedalGroup()
  
  /**
   * Get A Specific Medal Group
   *
   * @access public
   * @param integer The ID number of the requested Group
   * @return object MedalGroup
   * @uses MedalGroup
   */
  function GetMedalGroup($id) {

    return new MedalGroup($id, $this->roster_coder);
  
  }

  // }}}
  // {{{ GetMedal()

  /**
   * Get a specific Medal
   *
   * @access public
   * @param integer The ID number of the requested medal
   * @return object Medal
   * @uses Medal
   */
  function GetMedal($id) {
  
    return new Medal($id, $this->roster_coder);
  
  }

  // }}}
  // {{{ GetRecentMedals()

  /**
   * Get all the medals that where awarded with in the last X days
   *
   * @access public
   * @param integer Number of days to retrieve. Defaults to one week
   * @return array AwardedMedal
   * @uses AwardedMedal
   */
  function GetRecentMedals($days = 7) {

    $startdate = time() - ($days * 24 * 60 * 60);

    $sql = "SELECT id "
          ."FROM mb_awarded_medals "
          ."WHERE date > ".$startdate." "
          ."ORDER BY date DESC";

    $medals = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($medal = mysql_fetch_array($medals)) {

      array_push($return, new AwardedMedal($medal['id'], $this->roster_coder));

    }

    return $return;
  
  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

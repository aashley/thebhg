<?php
/**
 * This file contains objects required for the Core Roster Functionality
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.18 $
 * @package Roster
 * @subpackage Roster
 */

/**
 * A Cadre
 *
 * A Cadre of hunters
 *
 * <pre>
 *  20031003  aa  added IsActive()
 *  20030924  ah  added GetHomePage(), GetSlogan(), SetHomePage(), and
 *                SetSlogan()
 *  20030923  aa  added GetMemberCount(), GetMembetPoints(), 
 *                GetAvailableMemberPoints()
 *                completed AddMember(), Close()
 *  20030709  aa  completed RemoveMember(), SetName()
 *  20030707  aa  completed Stubs and most read only functions
 *  20030630  aa  created file
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Roster
 * @access public
 * @version $Revision: 1.18 $
 *
 */
class Cadre extends BHGObject {

  // {{{ properties

  /**
   * Cadre ID Number
   *
   * @access protected
   * @var integer cadre_id
   * @see GetID()
   */
  var $cadre_id;

  /**
   * Cadre's Name
   *
   * @access protected
   * @var string cadre_name
   * @see GetName(), SetName()
   */
  var $cadre_name;

  /**
   * Cadre's Leader's ID Number
   *
   * @access protected
   * @var integer cadre_leader
   * @see GetLeader()
   */
  var $cadre_leader;

  /**
   * Cadre's Creation Date
   * 
   * @access protected
   * @var integer cadre_date_created
   * @see GetDateCreated()
   */
  var $cadre_date_created;

  /**
   * Cadre's Deletion Date
   * 
   * @access protected
   * @var integer cadre_date_deleted
   * @see GetDateClosed(), Close()
   */
  var $cadre_date_deleted;

  /**
   * Cadre Points
   *
   * Cadre 'buys' members with points, Cadre's have a max of 11pt and costs are
   * stored in this array.
   *
   * @access protected
   * @var array cadre_costs
   * @see CanJoin(), AddMember()
   */
  var $cadre_costs = array(17 => 7,   // DP
                           16 => 7,   // PRM
                           15 => 6,   // CARD
                           19 => 6,   // ARCH
                           20 => 5,   // MARQ
                           14 => 5,   // DUKE
                           13 => 4,   // COUNT
                           12 => 4);  // BRN

  // }}}
  // {{{ Cadre()

  /**
   * Object Constructor
   *
   * @access public
   * @param integer The ID Number of the Cadre
   * @param string Coder Identification String
   */
  function Cadre($id, $coder = '') {

    BHGObject::BHGObject($coder);

    $sql = 'SELECT id, '
                 .'name, '
                 .'leader, '
                 .'date_created, '
                 .'date_deleted, '
                 .'homepage, '
                 .'slogan '
          .'FROM roster_cadres '
          .'WHERE id = '.$id;

    $result = mysql_query($sql, $this->roster_db);

    if ($cadre = @mysql_fetch_assoc($result)) {

      foreach ($cadre as $key => $value) {

        $key = 'cadre_'.$key;

        $this->$key = stripslashes($value);

      }

    } else {

      $this->roster_error = 'Could not load cadre details.';

      return false;

    }

  }

  // }}}
  // {{{ GetID()

  /**
   * Get Cadre's ID Number
   * 
   * @access public
   * @return integer
   */
  function GetID() {

    return $this->cadre_id;

  }

  // }}}
  // {{{ GetName()

  /**
   * Get Cadre's Name
   *
   * @access public
   * @return string
   */
  function GetName() {

    return $this->cadre_name;

  }

  // }}}
  // {{{ GetLeader()

  /**
   * Get the Leader of the Cadre
   *
   * @access public
   * @return object Person
   * @uses Person
   */
  function GetLeader() {

    return new Person($this->cadre_leader, $this->roster_coder);

  }

  // }}}
  // {{{ GetMembers()

  /**
   * Get an array of Members
   *
   * This fuction returns an array containing the current members of this 
   * Cadre. The leader of the Cadre will always been in array position zero (0).
   * The rest of the members will be sorted by rank and credits, with the
   * highest ranked hunters first in the array.
   *
   * Note: This function can only be used on Cadre's that have not been closed.
   * Once closed a Cadre no longer has a current membership.
   *
   * @access public
   * @return array Person Objects
   * @uses Person
   */
  function GetMembers() {

    if (isset($this->cadre_date_deleted)
        && $this->cadre_date_deleted > 0) {

      $this->roster_error = 'This Cadre has been closed and as such does not '
        .'have a current membership. Please use the GetMembersOnDate() '
        .'function to load the membership from a specific date.';

      return false;

    }

    $sql = 'SELECT roster_roster.id '
          .'FROM roster_roster, '
               .'roster_rank '
          .'WHERE roster_roster.cadre = '.$this->cadre_id.' '
            .'AND roster_rank.id = roster_roster.rank '
          .'ORDER BY roster_rank.`order` ASC, '
                   .'roster_roster.rankcredits DESC ';

    if ($members = mysql_query($sql, $this->roster_db)) {

      $return = array();

      $return[0] = new Person($this->cadre_leader, $this->roster_coder);

      while ($member = mysql_fetch_assoc($members)) {

        if ($return[0]->GetID() != $member['id']) {

          $return[] = new Person($member['id'], $this->roster_coder);

        }

      }

      return $return;

    } else {

      $this->roster_error = 'There was an error loading the Current Members.';

      return false;
    
    }

  }

  // }}}
  // {{{ GetMemberCount()

  /**
   * The Number of people in this cadre
   *
   * @access public
   * @return integer
   */
  function GetMemberCount() {

    if (isset($this->cadre_date_deleted)
        && $this->cadre_date_deleted > 0) {

      $this->roster_error = 'This Cadre has been closed and as such does not '
        .'have a current membership. Please use the GetMemberCountOnDate() '
        .'function to load the membership from a specific date.';

      return false;

    }

    $sql = 'SELECT COUNT(*) AS count '
          .'FROM roster_roster '
          .'WHERE cadre = '.$this->cadre_id;

    return mysql_result(mysql_query($sql, $this->roster_db), 0, 'count');

  }

  // }}}
  // {{{ GetMembersOnDate()

  /**
   * Retrieve Members for a Date
   *
   * This function returns an array containing the members of a Cadre on a 
   * specific date. This can be used to access previous membership of a cadre
   * (ie figure out who was a member during a specific Cadre Games).
   *
   * Notes: 
   * 1) This function is much slower than GetMembers() so if you are after
   *    the current membership of a Cadre always use this functions.
   * 2) Cadre's that have been closed no longer have a current membership so
   *    this function must be used to access them.
   *
   * @access public
   * @param integer Date to retrieve membership from (Unixtime)
   * @return array Person Objects
   * @todo Complete this function
   */
  function GetMembersOnDate($date) {

    return array();

  }

  // }}}
  // {{{ GetDateCreated()

  /**
   * Get the Date the Cadre was Created
   *
   * @access public
   * @return integer
   */
  function GetDateCreated() {

    return $this->cadre_date_created;

  }

  // }}}
  // {{{ GetDateClosed()

  /**
   * Get the Date the Cadre was Closed
   *
   * @access public
   * @return mixed False if not closed, Unix Timestamp if closed.
   */
  function GetDateClosed() {

    if (   isset($this->cadre_date_deleted) 
        && $this->cadre_date_deleted > 0) {

      return $this->cadre_date_deleted;

    } else {

      return false;

    }

  }

  // }}}
  // {{{ GetMemberPoints()

  /**
   * Return the number of points spent to get the current membership
   *
   * @access public
   * @return mixed An integer of the number of points used on success. False
   *               on failure.
   * @uses GetMembers()
   * @uses Person
   * @uses Person::GetRank()
   * @uses Rank
   * @uses Rank::GetID()
   */
  function GetMemberPoints() {
    
    if (isset($this->cadre_date_deleted)
        && $this->cadre_date_deleted > 0) {

      $this->roster_error = 'This Cadre has been closed and as such does not '
        .'have a current membership to calculate point usage from.';

      return false;

    }

    $members = $this->GetMembers();

    if ($members === false) {

      $this->roster_error = 'Could not load list of members to calculate '
        .'costs from.';

      return false;

    }

    $points = 0;

    foreach ($members as $member) {

      $rank = $member->GetRank();

      if (array_key_exists($rank->GetID(), $this->cadre_costs)) {

        $points += $this->cadre_costs[$rank->GetID()];

      }

    }

    return $points;

  }

  // }}}
  // {{{ GetAvailableMemberPoints()

  /**
   * Get the number of points we have left to spend on members
   *
   * @access public
   * @return mixed An integer containing the number of available points or false
   *               on failure.
   * @uses GetMemberPoints
   * @uses BHGObject::GetSetting()
   */
  function GetAvailableMemberPoints() {

    $points = $this->GetMemberPoints();

    if ($points === false) {

      return false;

    } else {

      return $this->GetSetting('cadre_points') - $points;

    }

  }

  // }}}
  // {{{ GetHomePage()

  /**
   * Gets the cadre's home page.
   *
   * @access public
   * @return string The home page's URL.
   */
  function GetHomePage() {

    return $this->cadre_homepage;
    
  }
  
  // }}}
  // {{{ GetSlogan()

  /**
   * Gets the cadre's slogan.
   *
   * @access public
   * @return string The cadre's slogan.
   */
  function GetSlogan() {

    return $this->cadre_slogan;
    
  }
  
  // }}}
  // {{{ CanJoin()

  /**
   * Whether a specific person can join this cadre
   *
   * @access public
   * @param mixed Person Object or Person ID Number
   * @return boolean
   * @uses GetMemberCount()
   * @uses GetLeader()
   * @uses GetAvailableMemberPoints()
   * @uses Person
   * @uses Person::GetRank()
   * @uses Person::InCadre()
   * @uses Rank
   * @uses Rank::GreaterThanOrEqual()
   * @uses BHGObject::GetSetting()
   */
  function CanJoin(&$person) {

    if (isset($this->cadre_date_deleted)
        && $this->cadre_date_deleted > 0) {

      $this->roster_error = 'This Cadre has been closed and as such no one '
        .'can join it.';

      return false;

    }

    // Check that there is enough available slots in this cadre

    if ($this->GetMemberCount() >= $this->GetSetting('cadre_members')) {

      $this->roster_error = 'This Cadre is full. No new members can join at '
        .'this time.';

      return false;

    }

    // Check the cadre has enough available points

    if (is_object($person)) {

      if (   get_class($person) == 'person'
          || is_subclass_of($person, 'person')) {

        $rank = $person->GetRank();

      } else {

        $this->roster_error = 'Invalid object passed to Cadre::CanJoin().';

        return false;

      }

    } elseif (is_numeric($person)) {

      $person = new Person($person, $this->roster_coder);

      $rank = $person->GetRank();

    } else {

      $this->roster_error = 'Invalid parameter passed to Cadre::CanJoin().';

      return false;

    }

    // see if person is already in a cadre
    if ($person->InCadre()) {

      return false;

    }

    $leader = $this->GetLeader();

    $lrank = $leader->GetRank();

    if ($rank->GreaterThanOrEqual($lrank)) {

      return false;

    }

    if (array_key_exists($rank->GetID(), $this->cadre_costs)) {

      if ($this->cadre_costs[$rank->GetID()] 
          > $this->GetAvailableMemberPoints()) {

        $this->roster_error = 'This Cadre does not have enough points for '
          .'this member to join it\'s ranks.';

        return false;

      } else {

        return true;

      }

    } else {

      return true;

    }

  }

  // }}}
  // {{{ IsActive()

  /**
   * Is this Cadre currently open
   *
   * @access public
   * @return boolean
   */
  function IsActive() {

    if (   isset($this->cadre_date_deleted)
        && $this->cadre_date_deleted > 0) {

      return false;

    } else {

      return true;

    }

  }

  // }}}
  // {{{ GetCostToJoin()

  /**
   * Return the amount it will cost in points for this person to join
   * 
   * @access public
   * @return integer
   * @uses Person
   * @uses Person::GetRank()
   * @uses Rank
   * @uses Rank::GetID()
   */
  function GetCostToJoin($person) {
    
    if (isset($this->cadre_date_deleted)
        && $this->cadre_date_deleted > 0) {

      $this->roster_error = 'This Cadre has been closed and as such no one '
        .'can join it.';

      return false;

    }

    // Check the cadre has enough available points

    if (is_object($person)) {

      if (   get_class($person) == 'person'
          || is_subclass_of($person, 'person')) {

        $rank = $person->GetRank();

      } else {

        $this->roster_error = 'Invalid object passed to Cadre::CanJoin().';

        return false;

      }

    } elseif (is_numeric($person)) {

      $person = new Person($person, $this->roster_coder);

      $rank = $person->GetRank();

    } else {

      $this->roster_error = 'Invalid parameter passed to Cadre::CanJoin().';

      return false;

    }

    if (array_key_exists($rank->GetID(), $this->cadre_costs)) {

      return $this->cadre_costs[$rank->GetID()];

    } else {

      return 0;

    }

  }

  // }}}
  // {{{ AddMember()

  /**
   * Add a person to this Cadre
   *
   * @access public
   * @param mixed Person Object or Person ID Number
   * @return boolean
   * @uses BHGObject::Allowed()
   * @uses CanJoin()
   * @uses Person
   * @uses Person::SetCadre()
   */
  function AddMember(&$person) {

    if ($this->Allowed('cadre')) {

      if (isset($this->cadre_date_deleted)
          && $this->cadre_date_deleted > 0) {

        $this->roster_error = 'This Cadre has been closed and as such no one '
          .'can join it.';

        return false;

      }

      if (is_object($person)) {

        if (   get_class($person) == 'person'
            || is_subclass_of($person, 'person')) {

        } else {

          $this->roster_error = 'Invalid Object passed to Cadre::AddMember().';

          return false;

        }

      } elseif (is_numeric($person)) {

        $person = new Person($person, $this->roster_coder);

      } else {

        $this->roster_error = 'Invalid Object passed to Cadre::AddMember().';

        return false;

      }

      if ($this->CanJoin($person)) {
  
        return $person->SetCadre($this->cadre_id);

      } else {
      
        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ RemoveMember()

  /**
   * Remove a person from this Cadre
   *
   * @access public
   * @param integer The ID number of the member to remove
   * @return boolean
   * @uses BHGObject::Allowed()
   * @uses Person
   * @uses Person::InCadre()
   * @uses Person::SetCadre()
   */
  function RemoveMember($person) {

    if ($this->Allowed('cadre')) {

      if ($person == $this->cadre_leader) {

        $this->roster_error = 'Can not remove the Cadre Leader from the Cadre. '
          .'To replace the Leader please close this Cadre and form a new one.';

        return false;

      }

      if (is_object($person)) {

        if (   get_class($person) == 'person'
            || is_subclass_of($person, 'person')) {

        } else {

          $this->roster_error = 'Invalid Object passed to '
            .'Cadre::RemoveMember().';

          return false;

        }

      } elseif (is_numeric($person)) {

        $person = new Person($person, $this->roster_coder);

      } else {

        $this->roster_error = 'Invalid Object passed to '
          .'Cadre::RemoveMember().';

        return false;

      }

      if ($person->InCadre($this->cadre_id)) {

        if ($person->SetCadre(0)) {

          return true;

        } else {

          $this->roster_error = $person->Error();

          return false;

        }

      } else {

        $this->roster_error = 'This person is not a member of this cadre.';

        return false;

      }

    } else {

      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to access this function.';

      return false;

    }

  }

  // }}}
  // {{{ SetName()

  /**
   * Set the Name of this Cadre
   *
   * @access public
   * @param string The new name of the Cadre
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function SetName($name) {

    if ($this->Allowed('cadre')) {

      if ($name == $this->cadre_name) {

        return true;

      }

      $sql = 'UPDATE roster_cadres '
            .'SET name = \''.addslashes(stripslashes($name)).'\' '
            .'WHERE id = '.$this->cadre_id.' ';

      if (mysql_query($sql, $this->roster_db)) {

        $this->cadre_name = stripslashes($name);

        return true;

      } else {

        $this->roster_error = 'Could not save new name for Cadre.';

        return false;

      }

    } else {
      
      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to call this function.';
      
      return false;

    }

  }

  // }}}
  // {{{ SetHomePage()

  /**
   * Sets the home page of this cadre.
   *
   * @access public
   * @param string The new URL of the cadre.
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function SetHomePage($homepage) {

    if ($this->Allowed('cadre')) {

      if ($homepage == $this->cadre_homepage) {

        return true;

      }

      $sql = 'UPDATE roster_cadres '
            .'SET homepage = \''.addslashes(stripslashes($homepage)).'\' '
            .'WHERE id = '.$this->cadre_id.' ';

      if (mysql_query($sql, $this->roster_db)) {

        $this->cadre_homepage = stripslashes($name);

        return true;

      } else {

        $this->roster_error = 'Could not save new home page for Cadre.';

        return false;

      }

    } else {
      
      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to call this function.';
      
      return false;

    }

  }

  // }}}
  // {{{ SetSlogan()

  /**
   * Sets the slogan of this cadre.
   *
   * @access public
   * @param string The new slogan for the cadre.
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function SetSlogan($slogan) {

    if ($this->Allowed('cadre')) {

      if ($slogan == $this->cadre_slogan) {

        return true;

      }

      $sql = 'UPDATE roster_cadres '
            .'SET slogan = \''.addslashes(stripslashes($slogan)).'\' '
            .'WHERE id = '.$this->cadre_id.' ';

      if (mysql_query($sql, $this->roster_db)) {

        $this->cadre_slogan = stripslashes($slogan);

        return true;

      } else {

        $this->roster_error = 'Could not save new slogan for Cadre.';

        return false;

      }

    } else {
      
      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to call this function.';
      
      return false;

    }

  }

  // }}}
  // {{{ Close()

  /**
   * Close this Cadre
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   * @uses GetMembers()
   * @uses RemoveMember()
   */
  function Close() {

    if ($this->Allowed('cadre')) {

      $members = $this->GetMembers();

      foreach ($members as $member) {

        $this->RemoveMember($member);

      }

      $sql = 'UPDATE roster_cadres '
            .'SET date_deleted = UNIX_TIMESTAMP() '
            .'WHERE id = '.$this->cadre_id;

      if (mysql_query($sql, $this->roster_db)) {

        $sql = 'SELECT date_deleted '
              .'FROM roster_cadres '
              .'WHERE id = '.$this->cadre_id;

        $this->cadre_date_deleted = mysql_result(mysql_query($sql,
                                                             $this->roster_db),
                                                 0,
                                                 'date_deleted');

        $sql = 'UPDATE roster_roster '
              .'SET cadre = 0 '
              .'WHERE id = '.$this->cadre_leader;

        mysql_query($sql, $this->roster_db);

        return true;

      } else {

        $this->roster_error = 'Could not mark cadre as deleted.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';
      
      return false;

    }

  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker et: */

?>

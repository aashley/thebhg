<?
/**
 * This file contains objects required for the Core Roster Functionality
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.31 $
 * @package Roster
 * @subpackage Roster
 */

/**
 * The Division of People
 * 
 * Class to provide access to divisions in the BHG
 *
 * <pre>
 *  20030619  aa  standardised on boolean returns
 *  20030617  aa  made sure all db queries run against the roster connection
 *  20030207  ah  added quotes to make SetName and SetMailingList work
 *  20021220  aa  completed delete function and fixed SetMailingList
 *  20021106  aa  added ability to change sorting of GetMembers
 *  20020815  aa  made IsKabal and IsWing more generic
 *  20020801  aa  added GetMemberCount as loading the Member array and getting
 *                a sizeof if a lot of overhead if you dont actually need
 *                the member array
 *  20020605  aa  added colour support for division colours for the armor
 *  20020522  aa  doco updates
 *  20020303  AA  Write Functions complete
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
 * @version $Revision: 1.31 $
 * @todo Add SetCategory()
 *
 */
class Division extends BHGObject {

  // {{{ properties

  /**
   * Division's ID Number
   *
   * @access protected
   * @var integer $division_id 
   * @see GetID()
   */
  var $division_id;

  /**
   * Division's name
   *
   * @access protected
   * @var string $division_name
   * @see GetName()
   */
  var $division_name;

  /**
   * Division's Category
   *
   * @access protected
   * @var integer $division_category
   * @see GetCategory()
   */
  var $division_category;

  /**
   * Division's Mailing List Name
   *
   * @access protected
   * @var string $division_mailinglist
   * @see GetID()
   */
  var $division_mailinglist;

  // }}}
  // {{{ Division()

  /**
   * Object Constructor
   *  
   * Calls BHGObject Constructor to establish db connection and sets initial
   * settings. Loads data for division from database
   *
   * @access public
   * @param int id ID Number of the Division to create an object for
   * @param string coder Coder Identification String
   *
   */
  function Division($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $sql = "SELECT id, "
                 ."name, "
                 ."category, "
                 ."mailinglist, "
                 ."deleted "
          ."FROM roster_divisions "
          ."WHERE id = $id";
          
    $divisiondb = mysql_query($sql, $this->roster_db);
    
    if ($division = @mysql_fetch_array($divisiondb)) {
      
      $this->division_id = $division["id"];
      
      $this->division_name = $division["name"];
      
      $this->division_category = $division["category"];
      
      $this->division_mailinglist = $division["mailinglist"];
      
      $this->division_deleted = $division["deleted"];

    } else {
      
      $this->roster_error = "Invalid Division ID. Could not create object.";
      
    }
    
  }

  // }}}
  // {{{ GetID()

  /**
   * Get A Division's ID Number
   *
   * @access public
   * @return integer A Division's ID Number
   */
  function GetID() {
    return $this->division_id;
  }

  // }}}
  // {{{ GetName()

  /**
   * Get A Division's Name
   *
   * @access public
   * @return string A Division's Name
   */
  function GetName() {
    return $this->division_name;
  }

  // }}}
  // {{{ GetCategory()

  /**
   * Get A Division's Category
   *
   * @access public
   * @return object DivisionCategory 
   * @uses DivisionCategory
   */
  function GetCategory() {
    return new DivisionCategory($this->division_category, $this->roster_coder);
  }

  // }}}
  // {{{ GetMailingList()

  /**
   * Get A Division's Mailing List
   *
   * @access public
   * @return string A Division's Mailing List
   */
  function GetMailingList() {
    if ($this->division_mailinglist == "none") {
      return false;
    } else {
      return $this->division_mailinglist."@thebhg.org";
    }
  }

  // }}}
  // {{{ GetMembers()

  /**
   * Get A Division's Members
   *
   * @access public
   * @param string order accepts two values, 
   *                     'position' - order by position, rank, credits, name
   *                     'name' - order by name, rank, credits, position
   * @return array Array of Person Objects
   * @uses Person
   */
  function GetMembers($order = 'position') {
    $sql = "SELECT roster_roster.id "
          ."FROM roster_roster, "
               ."roster_rank, "
               ."roster_position "
          ."WHERE roster_roster.division = ".$this->GetID()." "
            ."AND roster_roster.rank = roster_rank.id "
            ."AND roster_roster.position = roster_position.id ";

    if ($order == 'name') {

      $sql .= "ORDER BY roster_roster.name ASC, "
                      ."roster_rank.order ASC, "
                      ."roster_roster.rankcredits DESC, "
                      ."roster_position.order ASC";

    } else {

      $sql .= "ORDER BY roster_position.order ASC, "
                      ."roster_rank.order ASC, "
                      ."roster_roster.rankcredits DESC, "
                      ."roster_roster.name ASC";

    }
    
    $results = mysql_query($sql, 
                          $this->roster_db);
    
    $return = array();
    
    if ($row = mysql_fetch_array($results)) {
      
      do {
        
        array_push($return, new Person($row["id"], $this->roster_coder));
        
      } while ($row = mysql_fetch_array($results));
      
      return $return;
      
    } else {
      
      return false;
      
    }
    
  }

  // }}}
  // {{{ GetMemberCount()

  /**
   * Get the number of members within this division
   *
   * @access public
   * @return integer
   */
  function GetMemberCount() {
    $results = mysql_query("SELECT COUNT(*) AS count "
                          ."FROM roster_roster, "
                               ."roster_rank, "
                               ."roster_position "
                          ."WHERE roster_roster.division = ".$this->GetID()." "
                            ."AND roster_roster.rank = roster_rank.id "
                            ."AND roster_roster.position = roster_position.id "
                          ."ORDER BY roster_position.order ASC, "
                                   ."roster_rank.order ASC, "
                                   ."roster_roster.rankcredits DESC, "
                                   ."roster_roster.name ASC", 
                          $this->roster_db);

    return mysql_result($results, 0, 'count');

  }

  // }}}
  // {{{ IsActive()

  /**
   * Whether this division is Active
   *
   * @access public
   * @return boolean 
   */
  function IsActive() {
    return $this->division_deleted == 0;
  }

  // }}}
  // {{{ IsKabal()

  /**
   * Whether this division is a Kabal
   *
   * @access public
   * @return boolean
   * @uses DivisionCategory
   * @uses DivisionCategory::HasKabals()
   */
  function IsKabal() {
    $category = new DivisionCategory($this->division_category);
    return $category->HasKabals();
  }

  // }}}
  // {{{ IsWing()

  /**
   * Whether this division is a Wing
   *
   * @access public
   * @return boolean
   * @uses DivisionCategory
   * @uses DivisionCategory::HasWings()
   */
  function IsWing() {
    $category = new DivisionCategory($this->division_category);
    return $category->HasWings();
  }

  // }}}
  // {{{ SetName()

  /**
   * Set A Division's Name
   *
   * @access public
   * @param string name The new Name
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function SetName($name) {
    
    if ($this->Allowed('god')) {
      
      // do it
      $sql = "UPDATE roster_divisions "
            ."SET name = '".addslashes($name)."' "
            ."WHERE id = ".$this->division_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->division_name = $name;
        
        return true;

      } else {

        $this->roster_error = "Could not set new Name";

        return false;

      }        
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }

  // }}}
  // {{{ SetMailingList()

  /**
   * Set A Division's Mailing List Name
   *
   * @access public
   * @param string mailinglist name of new mailing ist
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function SetMailingList($mailinglist) {
    
    if ($this->Allowed('god')) {
      
      // do it
      $sql = "UPDATE roster_divisions "
            ."SET mailinglist = '".addslashes($mailinglist)."' "
            ."WHERE id = ".$this->division_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->division_mailinglist = $mailinglist;
        
        return true;

      } else {

        $this->roster_error = "Could not set new mailing list";

        return false;

      }        
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }

  // }}}
  // {{{ Delete()

  /**
   * Delete this Division
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function Delete() {

    if ($this->Allowed('god')) {

      $sql = "UPDATE roster_divisions "
            ."SET deleted = 1 "
            ."WHERE id = ".$this->division_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->division_deleted = 1;

        return true;

      } else {

        $this->roster_error = "Could not delete division.";

        return false;

      }

    } else {

      $this->roster_error = "The coder that created this object does not have "
        ."permission to call this function";

        return false;

    }
    
  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

<?php
/**
 * This file contains objects required for the Core Roster Functionality
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.26 $
 * @package Roster
 * @subpackage Roster
 */

/**
 * A category of divisions
 * 
 * Class to provide access to division categories in the BHG
 *
 * <pre>
 *  20030619  aa  standardised on boolean returns
 *  20030617  aa  made sure all queries run against the roster connection
 *  20030402  aa  by default do not include deleted divisions
 *  20030317  aa  documentation fixes
 *  20030207  ah  fixed SetName to work properly
 *  20020815  aa  added support for wings
 *  20020303  AA  Write Functions Complete
 *  20011102  AA  Read functions complete
 *  20011007  AA  Initial Version
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Roster
 * @access public
 * @version $Revision: 1.26 $
 *
 */
class DivisionCategory extends BHGObject {

  // {{{ properties

  /**
   * Division Category's ID Number
   *
   * @access protected
   * @var integer $division_cat_id 
   * @see GetID()
   */
  var $division_cat_id;

  /**
   * Division Category's Name
   *
   * @access protected
   * @var integer $division_cat_name
   * @see GetName()
   */
  var $division_cat_name;

  /**
   * Flag whether this division category contains Kabals
   *
   * @access protected
   * @var integer $division_cat_kabal
   * @see HasKabals()
   */
  var $division_cat_kabal;

  /**
   * Division Category's Ordering Index
   *
   * @access protected
   * @var integer $division_cat_order
   * @see GetWeight()
   */
  var $division_cat_order;

  // }}}
  // {{{ DivisionCategory()

  /**
   * Object Constructor
   *  
   * Calls BHGObject Constructor to establish db connection and sets initial 
   * settings
   *
   * @access public
   * @param int id ID Number of the DivisionCategory to create an object for
   * @param string coder Coder Identification String
   *
   */
  function DivisionCategory($id, $coder = '') {
    BHGObject::BHGObject($coder);
    
    $divisioncdb = mysql_query("SELECT id, "
                                     ."name, "
                                     ."haskabals, "
																		 ."`order` "
															."FROM roster_division_categories "
															."WHERE id = $id",
															$this->roster_db);
		
    if ($divisionc = @mysql_fetch_array($divisioncdb)) {
			
      $this->division_cat_id = $divisionc["id"];
			
      $this->division_cat_name = $divisionc["name"];
			
      $this->division_cat_kabal = $divisionc["haskabals"];
			
      $this->division_cat_order = $divisionc["order"];
			
    } else {
			
      $this->roster_error = "Invalid Division Category ID. Could not create "
				."object.";
			
      return false;
			
    }
		
  }

  // }}}
  // {{{ GetID()

  /**
	 * Get This Division Category's ID Number
	 *
	 * @access public
	 * @return integer The ID Number
	 */
  function GetID() {
    return $this->division_cat_id;
  }

  // }}}
  // {{{ GetName()

  /**
	 * Get This Division Category's Name
	 *
	 * @access public
	 * @return string The Name
	 */
  function GetName() {
    return $this->division_cat_name;
  }

  // }}}
  // {{{ GetWeight()

  /**
	 * Get This Division Category's Weight
	 *
	 * ie Where to list it in relation to other division categories. Always order
	 * on Weight, then Name
	 *
	 * @access public
	 * @return integer The Weight
	 */
  function GetWeight() {
    return $this->division_cat_order;
  }

  // }}}
  // {{{ GetDivisions()

  /**
	 * Get This Divisions located within this category
	 *
	 * @access public
   * @param boolean deleted Include Deleted Divisions
	 * @return array An Array of Division Objects
   * @uses Division
	 */
  function GetDivisions($deleted = false) {
    $sql = "SELECT id "
			    ."FROM roster_divisions "
					."WHERE category = ".$this->division_cat_id.' '
          .($deleted ? '' : 'AND deleted = 0 ')
          ."ORDER BY name";
		
    $return = array();

    $results = mysql_query($sql, $this->roster_db);
		
    if ($row = mysql_fetch_array($results)) {
			
      do {
				
        array_push($return, new Division($row["id"], $this->roster_coder));
				
      } while ($row = mysql_fetch_array($results));
			
      return $return;
			
    } else {
			
      $this->roster_error = "There are no divisions within this category.";
			
      return false;
			
    }
		
  }

  // }}}
  // {{{ HasKabals()

  /**
	 * Whether This Division Category contains Kabals, or normal divisions
	 *
	 * @access public
	 * @return boolean 
	 */
  function HasKabals() {
    return ($this->division_cat_kabal == 1);
  }

  // }}}
  // {{{ HasWings()

  /**
   * Whether this Division Category contains Wings
   *
   * @access public
   * @return boolean
   */
  function HasWings() {
    return ($this->division_cat_kabal == 2);
  }

  // }}}
  // {{{ SetName()

  /**
	 * Set This Division Category's Name
	 *
	 * @access public
	 * @param string name the new name of the category
	 * @return boolean Whether the command succeded or failed
   * @uses BHGObject::Allowed()
	 */
  function SetName($name) {
    
    if ($this->Allowed('god')) {
      
      // do it
      $sql = "UPDATE roster_division_categories "
            ."SET name = '".addslashes($name)."' "
            ."WHERE id = ".$this->division_cat_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->division_cat_name = $name;
        
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
  // {{{ IncreaseWeight()

  /**
	 * Move this category up the list of categories
	 *
	 * @access public
	 * @return boolean Whether the command succeded or failed
   * @uses BHGObject::Allowed()
	 */
  function IncreaseWeight() {
    
    if ($this->Allowed('god')) {
      
      $weights = mysql_query("SELECT MAX(`order`) AS highest, "
                                   ."MIN(`order`) AS lowest "
                            ."FROM roster_division_categories", $this->roster_db);

      $weight = mysql_fetch_array($weights);

      mysql_free_result($weights);

      if ($this->division_cat_order == $weight['lowest']) {

        return true;

      }

      $newweight = $this->division_cat_order - 1;

      $oldrecord = mysql_query("SELECT id "
                              ."FROM roster_division_categories "
                              ."WHERE `order` = ".$newweight, $this->roster_db);

      $sql = "UPDATE roster_division_categories "
            ."SET `order` = ".$this->division_cat_order." "
            ."WHERE id = ".mysql_result($oldrecord, 0, 'id');

      if (mysql_query($sql, $this->roster_db)) {
      
        // do it
        $sql = "UPDATE roster_division_categories "
              ."SET `order` = ".$newweight." "
              ."WHERE id = ".$this->division_cat_id;

        if (mysql_query($sql, $this->roster_db)) {

          $this->division_cat_order = $newweight;
        
          return true;

        } else {

          $this->roster_error = "Could not set new weight";

          return false;

        }
        
      } else {

        $this->roster_error = "Could not move conflicting weight";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }

  // }}}
  // {{{ DecreaseWeight()

  /**
	 * Move this category down the list of categories
	 *
	 * @access public
	 * @return boolean Whether the command succeded or failed
   * @uses BHGObject::Allowed()
	 */
  function DecreaseWeight()  {
    
    if ($this->Allowed('god')) {
      
      $weights = mysql_query("SELECT MAX(`order`) AS highest, "
                                   ."MIN(`order`) AS lowest "
                            ."FROM roster_division_categories", $this->roster_db);

      $weight = mysql_fetch_array($weights);

      mysql_free_result($weights);

      if ($this->division_cat_order == $weight['highest']) {

        return true;

      }

      $newweight = $this->division_cat_order + 1;

      $oldrecord = mysql_query("SELECT id "
                              ."FROM roster_division_categories "
                              ."WHERE `order` = ".$newweight, $this->roster_db);

      $sql = "UPDATE roster_division_categories "
            ."SET `order` = ".$this->division_cat_order." "
            ."WHERE id = ".mysql_result($oldrecord, 0, 'id');

      if (mysql_query($sql, $this->roster_db)) {
      
        // do it
        $sql = "UPDATE roster_division_categories "
              ."SET `order` = ".$newweight." "
              ."WHERE id = ".$this->division_cat_id;

        if (mysql_query($sql, $this->roster_db)) {

          $this->division_cat_order = $newweight;
        
          return true;

        } else {

          $this->roster_error = "Could not set new weight";

          return false;

        }
        
      } else {

        $this->roster_error = "Could not move conflicting weight";

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
	 * Mark this category as being deleted
	 *
	 * @access public
	 * @return boolean Whether the command succeded or failed
   * @uses BHGObject::Allowed()
	 */
  function Delete() {
  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

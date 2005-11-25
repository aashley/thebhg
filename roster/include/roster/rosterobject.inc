<?php
/**
 * This file contains objects required for the Core Roster Functionality
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.64 $
 * @package Roster
 * @subpackage Roster
 */

/**
 * Roster - Primary object of the BHG Roster
 * 
 * This is the little beasty you use to do everything
 * 
 * <pre>
 *  20031124  aa  added SearchPositionBetween()
 *  20030925  aa  added CreateCadre()
 *  20030619  aa  standardised on boolean returns
 *  20030617  aa  made sure all queries are run against roster connection
 *  20030605  aa  fix for GetKabals() and GetWings()
 *  20030402  aa  changed GetDivisions(), GetKabals() and GetWings() to
 *                not include deleted divisions by default and added
 *                a parameter to optionally include them
 *  20030317  aa  documentation fixes
 *  20030306  ah  added CreateRank and CreatePosition
 *  20030207  ah  added GetDivisionCategory to complement GetDivision
 *  20030128  aa  added GetWing to completment GetKabal
 *  20030105  aa  added GetWings and made GetKabals use haskabals value
 *  20021107  aa  fixed setting the password in CreatePassword
 *  20021106  aa  added ability to change sort order of GetDivisions
 *  20020921  aa  made sure queries where using the correct db connection
 *  20020919  aa  added CreateUser
 *  20020522  aa  documentation updates
 *  20011016  AA  Initial Version
 *  20011031  AA  Completed Search Routines
 * </pre>
 * 
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Roster
 * @access public
 * @version $Revision: 1.64 $
 *
 */
class Roster extends BHGObject {

  // {{{ properties

  // }}}
  // {{{ Roster()
  
  /**
   * Object Constructor
   *
   * All it does is call the constructor of the BHGObject
   *
   * @access public
   * @param string Coder Identification String
   */
  function Roster($coder = '') {
    BHGObject::BHGObject($coder);
  }

  // }}}
  
  // {{{ GetCadres()

  /**
   * Get all Cadres
   *
   * Retrieve an array of all Cadres stored within the database. Sorted by Name
   *
   * @access public
   * @param boolean deleted Include Closed Cadres
   * @return array Array of Cadre Objects
   */
  function GetCadres($deleted = false) {
    
    $cadres = mysql_query("SELECT `roster_cadres`.`id` "
                            ."FROM `roster_cadres` "
                            ."WHERE 1 "
                            .(($deleted)
                              ? ''
                              : 'AND date_deleted IS NULL ')
                            ."ORDER BY `roster_cadres`.`name`",
                            $this->roster_db);
    
    $return = array();

    if ($cadre = mysql_fetch_array($cadres)) {
      
      do {
        
        array_push($return, new Cadre($cadre["id"], $this->roster_coder));
        
      } while ($cadre = mysql_fetch_array($cadres));

			return $return;
      
    } else {
      
      $this->roster_error = "No Cadres in database";
      
      return false;
      
    }
    
  }

  // }}}
  // {{{ GetDivisionCategories()

  /**
   * Get all Categories of Divisions
   *
   * Retrieve an array of objects containing all the division categories in the
   * database
   *
   * @access public
   * @return array Array of DivisionCategory Objects on success or 0 on failure
   */
  function GetDivisionCategories() {

    $categories = mysql_query("SELECT `id` "
                             ."FROM `roster_division_categories` "
                             ."ORDER BY `order`", 
                             $this->roster_db);
    $return = array();

    if ($cat = mysql_fetch_array($categories)) {

      do {

        array_push($return, 
                   new DivisionCategory($cat["id"],
                                        $this->roster_coder));

      } while ($cat = mysql_fetch_array($categories));

      return $return;

    } else {

      $this->roster_error = "No Categories in database";

      return false;

    }

  }

  // }}}
  // {{{ GetDivisions()

  /**
   * Get all Divisions
   *
   * Retrieve an array of all divisions. Array is sorted by the ordering of 
   * DivisionCategory and then by the name of the division.
   *
   * @access public
   * @param string order accepts two values
   *                     'category' - sort by category then by name
   *                     'name' - sort by name
   * @param boolean deleted Include deleted Divisions
   * @return array Array of Division Objects
   */
  function GetDivisions($order = 'category', $deleted = false) {

    $sql = "SELECT `roster_divisions`.`id` "
          ."FROM `roster_divisions`, "
               ."`roster_division_categories` "
          ."WHERE `roster_division_categories`.`id` = "
                ."`roster_divisions`.`category` "
          .($deleted ? '' : 'AND `roster_divisions`.`deleted` = 0 ');

    if ($order == 'name') {
      
      $sql .= "ORDER BY `roster_division_categories`.`order`, "
                      ."`roster_divisions`.`name`";

    } else {

      $sql .= "ORDER BY `roster_divisions`.`name`";

    }
    
    $divisions = mysql_query($sql,
                            $this->roster_db);
    
    $return = array();

    if ($div = mysql_fetch_array($divisions)) {
      
      do {
        
        array_push($return, 
                   new Division($div["id"], 
                                $this->roster_coder));
        
      } while ($div = mysql_fetch_array($divisions));

      return $return;
      
    } else {
      
      $this->roster_error = "No Divisions in database";
      
      return false;
      
    }
    
  }

  // }}}
  // {{{ GetKabals()

  /**
   * Get all Kabals
   *
   * Retrieve an array of all kabals stored within the database. Sorted by Name.
   * A Kabal is defined as being any division within a division category who's
   * haskabal value is set to 1
   *
   * @access public
   * @param boolean deleted Include Deleted Kabals
   * @return array Array of Kabal Objects
   */
  function GetKabals($deleted = false) {

    $sql = "SELECT `roster_divisions`.`id` "
                            ."FROM `roster_divisions`, "
                                 ."`roster_division_categories` "
                            ."WHERE `roster_division_categories`.`haskabals` = 1 "
                              ."AND `roster_division_categories`.`id` = "
                                    ."`roster_divisions`.`category` "
                              .($deleted 
                                  ? ''
                                  : 'AND `roster_divisions`.`deleted` = 0 ')
                            ."ORDER BY `roster_division_categories`.`order`, "
                            ."`roster_divisions`.`name`";

    $divisions = mysql_query($sql,
                            $this->roster_db);
    
    $return = array();

    if ($div = mysql_fetch_array($divisions)) {
      
      do {
        
        array_push($return, new Kabal($div["id"], $this->roster_coder));
        
      } while ($div = mysql_fetch_array($divisions));

			return $return;
      
    } else {
      
      $this->roster_error = "No Kabals in database";
      
      return false;
      
    }
    
  }

  // }}}
  // {{{ GetPositions()

  /**
   * Get the Positions 
   *
   * Get an array containing all the positions in the system
   *
   * @access public
   * @return array Position Objects
   */
  function GetPositions() {

    $return = array();

    $sql = "SELECT id "
          ."FROM roster_position "
          ."ORDER BY `order` ASC ";

    $positions = mysql_query($sql, $this->roster_db);

    while ($position = mysql_fetch_array($positions)) {

      array_push($return, new Position($position['id'], $this->roster_coder));

    }

    return $return;

  }

  // }}}
  // {{{ GetManualRanks()

  /**
   * Get the Ranks which are Manually Set
   *
   * Get all the ranks which must be manually set by someone
   *
   * @access public 
   * @return array Rank Objects
   */
  function GetManualRanks() {

    $return = array();

    $sql = "SELECT id "
          ."FROM roster_rank "
          ."WHERE manual_set = 1 "
          ."ORDER BY `order` ASC ";

    $ranks = mysql_query($sql, $this->roster_db);

    while ($rank = mysql_fetch_array($ranks)) {

      array_push($return, new Rank($rank['id'], $this->roster_coder));

    }

    return $return;

  }

  // }}}
  // {{{ GetRanks()

  /**
   * Get the Ranks
   *
   * Get all the ranks in the system
   *
   * @access public
   * @return array Rank Objects
   */
  function GetRanks() {

    $return = array();

    $sql = "SELECT id "
          ."FROM roster_rank "
          ."ORDER BY `order` ASC ";

    $ranks = mysql_query($sql, $this->roster_db);

    while ($rank = mysql_fetch_array($ranks)) {

      array_push($return, new Rank($rank['id'], $this->roster_coder));

    }

    return $return;

  }

  // }}}
  // {{{ GetWings()

  /**
   * Get all Wings
   *
   * Retrieve an array of all wings stored within the database. Sorted by Name
   * A Wing is defined as being any division within a division category who's
   * haskabal value is set to 2
   *
   * @access public
   * @param boolean deleted Include Deleted Wings
   * @return array Array of Wing Objects
   */
  function GetWings($deleted = false) {
    
    $divisions = mysql_query("SELECT `roster_divisions`.`id` "
                            ."FROM `roster_divisions`, "
                                 ."`roster_division_categories` "
                            ."WHERE `roster_division_categories`.`haskabals` = 2 "
                              ."AND `roster_division_categories`.`id` = "
                                    ."`roster_divisions`.`category` "
                              .($deleted 
                                  ? ''
                                  : 'AND `roster_divisions`.`deleted` = 0 ')
                            ."ORDER BY `roster_division_categories`.`order`, "
                            ."`roster_divisions`.`name`",
                            $this->roster_db);
    
    $return = array();

    if ($div = mysql_fetch_array($divisions)) {
      
      do {
        
        array_push($return, new Wing($div["id"], $this->roster_coder));
        
      } while ($div = mysql_fetch_array($divisions));

			return $return;
      
    } else {
      
      $this->roster_error = "No Wings in database";
      
      return false;
      
    }
    
  }

  // }}}

  // {{{ GetCadre()
  
  /**
   * Get a specific Cadre Object
   * 
   * Returns a Cadre object relatiing to id
   *
   * @access public
   * @param int ID Number of the required Cadre
   * @return object Cadre
   */
  function GetCadre($id) {
    return new Cadre($id, $this->roster_coder);
  }

  // }}}
  // {{{ GetDivision()

  /**
   * Get a specific Division Object
   *
   * Returns a division object relating to id
   *
   * @access public
   * @param int ID Number of the required division
   * @return object Division
   */
  function GetDivision($id) {
    return new Division($id, $this->roster_coder);
  }

  // }}}
  // {{{ GetDivisionCategory()

  /**
   * Get a specific DivisionCategory Object
   *
   * Returns a division category object relating to id
   *
   * @access public
   * @param int ID Number of the required division category
   * @return object DivisionCategory
   */
  function GetDivisionCategory($id) {
    return new DivisionCategory($id, $this->roster_coder);
  }

  // }}}
  // {{{ GetKabal()
  
  /**
   * Get a specific Kabal Object
   * 
   * Returns a kabal object relatiing to id
   *
   * @access public
   * @param int ID Number of the required Kabal
   * @return object Kabal
   */
  function GetKabal($id) {
    return new Kabal($id, $this->roster_coder);
  }

  // }}}
  // {{{ GetPerson()

  /**
   * Retieve a specific person's object
   *
   * Get the object relating to ID
   *
   * @access public
   * @param int ID Number for person
   * @return object Person
   */
  function GetPerson($id) {
    return new Person($id, $this->roster_coder);
  }

  // }}}
  // {{{ GetPosition()

  /**
   * Get a specific Position Object
   *
   * @access public
   * @param integer The position ID
   * @return object Position
   */
  function GetPosition($id) {

    return new Position($id, $this->roster_coder);

  }

  // }}}
  // {{{ GetRank()

  /**
   * Get a specific Rank Object
   *
   * @access public
   * @param integer The rank ID
   * @return object Rank
   */
  function GetRank($id) {

    return new Rank($id, $this->roster_coder);

  }

  // }}}
  // {{{ GetWing()
  
  /**
   * Get a specific Wing Object
   * 
   * Returns a Wing object relatiing to id
   *
   * @access public
   * @param int ID Number of the required Wing
   * @return object Wing
   */
  function GetWing($id) {
    return new Wing($id, $this->roster_coder);
  }

  // }}}

  // {{{ SearchEmail()

  /**
   * Perform a Search on a Persons Email Address
   *
   * Searches for all people who's Email Address contains the search string. By
   * default a wildcard search is performed, each word is searched for all 
   * instances be they in words or not. Setting exact to 1 will disable the 
   * wildcard searching.
   *
   * @access public
   * @param string  The String to Search for
   * @param integer Whether to do a wildcard search or to search for the
   *                exact string
   * @return array Array of Person Objects
   */
  function SearchEmail($searchfor, $exact = 0) {
    
    if ($exact) {
      
      $searchfor = str_replace('%', '', $searchfor);
      
    } else {
      
      $searchfor = str_replace(' ', '%', '%'.$searchfor.'%');
      
    }
    
    $results = mysql_query("SELECT id "
                          ."FROM roster_roster "
                          ."WHERE email LIKE '".addslashes($searchfor)."' "
                            ."AND division != 0 "
                          ."ORDER BY name", $this->roster_db);
    
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
  // {{{ SearchIRCNick()

  /**
   * Perform a Search on a Persons IRC Nicks
   *
   * Searches for all people who's IRC Nicks contains the search string. By 
   * default a wildcard search is performed, each word is searched for all 
   * instances be they in words or not. Setting exact to 1 will disable the 
   * wildcard searching.
   *
   * @access public
   * @param string  The String to Search for
   * @param integer Whether to do a wildcard search or to search for the
   *                exact string
   * @return array Array of Person Objects
   */
  function SearchIRCNick($searchfor, $exact = 0) {
    
    if ($exact) {
      
      $searchfor = str_replace('%', '', $searchfor);
      
    } else {
      
      $searchfor = str_replace(' ', '%', '%'.$searchfor.'%');
      
    }
    
    $results = mysql_query("SELECT id "
                          ."FROM roster_roster "
                          ."WHERE ircnicks LIKE '".addslashes($searchfor)."' "
                            ."AND division != 0 "
                          ."ORDER BY name", $this->roster_db);
    
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
  // {{{ SearchName()

  /**
   * Perform a Search on a Persons Name
   *
   * Searches for all people who's Name contains the search string. By default
   * a wildcard search is performed, each word is searched for all instances
   * be they in words or not. Setting exact to 1 will disable the wildcard 
   * searching.
   *
   * @access public
   * @param string  The String to Search for
   * @param integer Whether to do a wildcard search or to search for the
   *                exact string
   * @return array Array of Person Objects
   */
  function SearchName($searchfor, $exact = 0) {
    
    if ($exact) {
      
      $searchfor = str_replace('%', '', $searchfor);
      
    } else {
      
      $searchfor = str_replace(' ', '%', '%'.$searchfor.'%');
      
    }
    
    $results = mysql_query("SELECT id "
                          ."FROM roster_roster "
                          ."WHERE name LIKE '".addslashes($searchfor)."' "
                            ."AND division != 0 "
                          ."ORDER BY name", $this->roster_db);
    
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
  // {{{ SearchPosition()

  /**
   * Perform a Search on a Persons Position
   *
   * Searches for all people who hold the position. The SearchFor parameter
   * can take a variety of data types. It can take either a Position Object, a
   * Position ID Number in integer format or a String to search within the 
   * position's abbreviation.
   *
   * @access public
   * @param mixed Can be either a Position Object, the position ID Number
   *              or a string to look through the position abbreviations for.
   * @return array Array of Person Objects
   */
  function SearchPosition($searchfor) {
    
    if (is_object($searchfor)) {
      
      if ($searchfor instanceof Position) {
        
        $results = mysql_query("SELECT id "
                              ."FROM roster_roster "
                              ."WHERE position = ".$searchfor->GetID()." "
                                ."AND division != 0 "
                              ."ORDER BY name", $this->roster_db);
        
      } else {
        
        $this->roster_error = "Invalid Object Passed to SearchPosition";
        
        return false;
        
      }
      
    } elseif (is_numeric($searchfor)) {
      
      $results = mysql_query("SELECT id "
                            ."FROM roster_roster "
                            ."WHERE position = $searchfor "
                              ."AND division != 0 "
                            ."ORDER BY name", $this->roster_db);
      
    } elseif (is_string($searchfor)) {
      
      $results = mysql_query("SELECT roster_roster.id "
                            ."FROM roster_roster, "
                                 ."roster_position "
                            ."WHERE roster_roster.position = roster_position.id "
                              ."AND roster_position.abbrev = '".$searchfor."' "
                              ."AND division != 0 "
                            ."ORDER BY roster_roster.name", $this->roster_db);
      
    } else {
      
      $this->roster_error = "Invalid Search Parameter Passed to SearchPosition";
      
      return false;
      
    }
    
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
  // {{{ SearchRank()

  /**
   * Perform a Search on a Persons Rank
   *
   * Searches for all people who hold the rank. The SearchFor parameter can 
   * take a variety of data types. It can take either a Rank Object, a Rank ID 
   * Number in integer format or a String to search within the rank's 
   * abbreviation.
   *
   * @access public
   * @param string The String to Search for
   * @return array Array of Person Objects
   */
  function SearchRank($searchfor) {
    
    if (is_object($searchfor)) {
      
      if ($searchfor instanceof Rank) {
        
        $results = mysql_query("SELECT id "
                              ."FROM roster_roster "
                              ."WHERE rank = ".$searchfor->GetID()." "
                                ."AND division != 0 "
                              ."ORDER BY name", $this->roster_db);
        
      } else {
        
        $this->roster_error = "Invalid Object Passed to SearchRank";
        
        return false;
        
      }
      
    } elseif (is_numeric($searchfor)) {
      
      $results = mysql_query("SELECT id "
                            ."FROM roster_roster "
                            ."WHERE rank = $searchfor "
                              ."AND division != 0 "
                            ."ORDER BY name", $this->roster_db);
      
    } elseif (is_string($searchfor)) {
      
      $results = mysql_query("SELECT roster_roster.id "
                            ."FROM roster_roster, "
                                 ."roster_rank "
                            ."WHERE roster_roster.rank = roster_rank.id "
                              ."AND roster_rank.abbrev = '".$searchfor."' "
                              ."AND division != 0 "
                            ."ORDER BY roster_roster.name", $this->roster_db);
      
    } else {
      
      $this->roster_error = "Invalid Search Parameter Passed to SearchRank";
      
      return false;
      
    }
    
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

  // {{{ SearchPositionBetween()
  
  /**
   * Get the all the people that held a position between two dates
   *
   * Get the all the people that held a position between two dates. This 
   * function makes use of the PEAR Date Object instead of stand unix
   * timestamps. Passing in a division will only return people that held that
   * position and where in that division at the time.
   *
   * @param object Position
   * @param object Date
   * @param object Date
   * @param object Division
   * @return array of Person objects
   */
  function SearchPositionBetween($position, $from, $to, $division = null) {

    $sql = 'SELECT id, '
                 .'person, '
                 .'date, '
                 .'item1, '
                 .'item2, '
                 .'item3 '
          .'FROM roster_history '
          .'WHERE type = 2 '
            .'AND (   item1 = '.$position->getID().' '
                 .'OR item2 = '.$position->getID().') '
          .'ORDER BY date DESC';

    $results = mysql_query($sql, $this->roster_db);

    $return = array();

    $lastrecord = array();

    while ($row = mysql_fetch_array($results)) {

      $rowdate = new Date();

      $rowdate->setDate($row['date'], DATE_FORMAT_UNIXTIME);
      
      if (   $position->getID() == $row['item1']
          && $rowdate->before($to)
          && $rowdate->after($from)) {

        if (is_null($division)) {
          
          $return[] = $row['person'];

        } else {

          $person = $this->getPerson($row['person']);

          if ($person->InDivision($division, $from, $rowdate)) {

            $return[] = $row['person'];

          }

        }

      } elseif (   $position->getID() == $row['item2']
                && $rowdate->before($to)
                && $rowdate->after($from)) {

        if (is_null($division)) {
          
          $return[] = $row['person'];

        } else {

          $person = $this->getPerson($row['person']);

          if ($person->InDivision($division, $from, $rowdate)) {

            $return[] = $row['person'];

          }
          
        }

      } else {

        // We havent already passed a end record
        if (!isset($lastrecord[$row['person']])) {

          // We found a record saying transfered out
          if ($position->getID() == $row['item1']) {
            
            // after our window
            if ($rowdate->after($to)) {
              
              // flag it
              $lastrecord[$row['person']] = 'endafter';

            } else {

              $lastrecord[$row['person']] = 'endbefore';

            }

          // We found a record saying transfered in before the end of our
          // window and we havent found a previously matching record saying we
          // transfered out before the end
          } elseif (   $position->getID() == $row['item2']
                    && $rowdate->before($from)) {

            if (is_null($division)) {
              
              $return[] = $row['person'];

            } else {

              $person = $this->getPerson($row['person']);

              if ($person->InDivision($division, $from, $rowdate)) {

                $return[] = $row['person'];

              }

            }

          }

        } elseif ($lastrecord[$row['person']] == 'endafter') {

          if ($position->getID() == $row['item2']) {

            if ($rowdate->before($to)) {

              if (is_null($division)) {

                $return[] = $row['person'];

              } else {

                $person = $this->getPerson($row['person']);

                if ($person->InDivision($division, $from, $rowdate)) {

                  $return[] = $row['person'];

                }

              }

            }

            unset($lastrecord[$row['person']]);

          }

        } elseif ($lastrecord[$row['person']] == 'endbefore') {

          if ($position->getID() == $row['item2']) {

            unset($lastrecord[$row['person']]);

          }

        }

      }

    }

    $unique = array_unique($return);

    $return = array();

    foreach ($unique as $id) {

      $return[] = new Person($id, $this->roster_coder);

    }

    return $return;

  }

  // }}}
  
  // {{{ CreateCadre()

  /**
   * Create a new Cadre
   *
   * @access public
   * @param mixed Person Object or Person ID Number
   * @param string The Name of the Cadre
   * @return mixed Cadre Object on Success, False on Failure
   */
  function CreateCadre($leader, $name) {

    if ($this->Allowed('god')) {

      if (is_object($leader)) {

        if ($leader instanceof Person) {

        } else {

          $this->roster_error = 'Invalid Object passed to '
            .'Roster::CreateCadre().';

          return false;

        }

      } elseif (is_numeric($leader)) {

        $leader = new Person($leader, $this->roster_coder);

      } else {

        $this->roster_error = 'Invalid Parameter passed to '
          .'Roster::CreateCadre().';

        return false;

      }

      $sql = 'INSERT INTO roster_cadres(name, '
                                      .'leader, '
                                      .'date_created) '
            .'VALUES(\''.addslashes($name).'\', '
                    .$leader->GetID().', '
                    .'UNIX_TIMESTAMP())';

      if (mysql_query($sql, $this->roster_db)) {

        $cadreid = mysql_insert_id($this->roster_db);

        $leader->SetCadre($cadreid);

        return new Cadre($cadreid, $this->roster_coder);

      } else {

        $this->roster_error = 'Could not create cadre.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ CreateDivision()

  /**
   * Create a new Division
   *
   * This function creates a new division within the BHG Roster System.
   * To call this function the coder must have god level access.
   * 
   * @access public
   * @param string  The Name of the new division
   * @param integer The ID Number of the category to add the new division 
   *                to. Can also take an object of type DivisionCategory.
   * @returns object New division object on success. 0 on failure.
   */
  function CreateDivision($name, $category) {
    if ($this->Allowed('god')) {
      
      if (   is_object($category) 
          && ($category instanceof DivisionCategory)) {
        
        $cat = $category->GetID();
        
      } elseif (is_numeric($category)) {
        
        $cat = $category;
        
      } else {
        
        $this->roster_error = "Invalid Category passed to CreateDivision";
        
        return false;
        
      }
      

      $sql = "INSERT INTO roster_divisions (`name`, `category`) "
            ."VALUES ('".addslashes($name)."', $category)";
      
      if (mysql_query($sql, $this->roster_db)) {
        
        $lastid = mysql_query("SELECT LAST_INSERT_ID() AS LastID", $this->roster_db);
        
        return new Division(mysql_result($lastid, 0, "LastID"), 
                            $this->roster_coder);
        
      } else {
        
        $this->roster_error = "Error Creating Division";
        
        return false;
        
      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";
      
      return false;
      
    }
    
  }

  // }}}
  // {{{ CreatePerson()

  /**
   * Create a new Person
   *
   * @access public
   * @param string Person's Name
   * @param string Person's E-Mail Address
   * @param mixed  ID Number or Division Object
   * @param string The new person's password
   * @return object The Person object representing the new person
   */
  function CreatePerson($name, 
                        $email,
                        $division,
                        $password = "") {

    if ($this->Allowed('god')) {

      if (   is_object($division) 
          && ($division instanceof Division)) {

        $div = $division->GetID();

      } elseif (is_numeric($division)) {

        $div = $division;

      } else {

        $this->roster_error = "Invalid Division passed to CreatePerson.";

        return false;

      }

      if (!($password > "")) {
        
        $password = substr(md5(uniqid(rand())),0,8);

      }

      $sql = "INSERT INTO roster_roster (name, "
                                       ."email, "
                                       ."rank, "
                                       ."rankcredits, "
                                       ."accountbalance, "
                                       ."division, "
                                       ."position, "
                                       ."passwd, "
                                       ."date_joined) "
            ."VALUES ('".addslashes($name)."', "
                    ."'".addslashes($email)."', "
                    ."1, "
                    ."0, "
                    ."0, "
                    .$div.", "
                    ."18, "
                    ."PASSWORD('".$password."'), "
                    ."NOW())";

      if (mysql_query($sql, $this->roster_db)) {

        $newid = mysql_insert_id();

        $sql = "INSERT INTO roster_biographical_data (person) "
              ."VALUES ($newid)";

        mysql_query($sql, $this->roster_db);

        $person = new Person($newid, $this->roster_coder);

        $GLOBALS['internalexecute'] = 'history';

        $person->RecordEvent(9);

        if (($message = $this->GetSetting('newmember')) > "") {

          $div = $person->GetDivision();

          $search = $this->SearchPosition('U');

          $underlord = $search[0];

          $search = $this->SearchPosition('X');

          $executor = $search[0];

					$search = $this->SearchPosition('WARD');

					$warden = $search[0];

          $replace = array();

          $replace['%new_division_name%'] = $division->GetName();
          $replace['%new_division_chief_name%'] = $warden->GetName();
          $replace['%new_division_chief_email%'] = $warden->GetEmail();
          $replace['%new_member_email%'] = $person->GetEmail();
          $replace['%new_member_idline%'] = $person->IDLine();
          $replace['%underlord_name%'] = $underlord->GetName();

          $message = ParseEmailTemplate($message, $replace);

          $person->SendEmail("roster@thebhg.org",
                             "[Roster] Welcome to the Bounty Hunter's Guild, "
                             .$person->GetName(),
                             $message);

          $warden->SendEmail("roster@thebhg.org",
                             "[Roster] Welcome to the Bounty Hunter's Guild, "
                             .$person->GetName(),
                             $message);

          if ($this->GetSetting('newmemberemailexecutor') == 1) {

            $executor->SendEmail("roster@thebhg.org",
                                 "[Roster] Welcome to the Bounty Hunter's Guild, "
                                 .$person->GetName(),
                                 $message);

          }

          unset($underlord, $search, $warden, $div, $replace);

        }

        if (($message = $this->GetSetting('passwordchange')) > "") {

          $replace = array();

          $replace['%personal_page_url%'] = 
              $this->GetSetting('changepasswordurl');
          $replace['%username%'] = $person->GetID();
          $replace['%new_password%'] = $password;

          $message = ParseEmailTemplate($message, $replace);

          $person->SendEmail("roster@thebhg.org",
                             "[Roster] Your Initial Password",
                             $message);

          unset($replace);

        }

        return $person;

      } else {

        $this->roster_error = "There was a problem creating the new Person.";

        return false;

      }

    } else {

      $this->roster_error = "The programmer that created this object does not "
        ."have permission to call this function.";

      return false;

    }

  }

  // }}}
  // {{{ CreatePosition()

  /**
   * Create a new Position
   *
   * This function creates a new position within the BHG Roster System.
   * To call this function the coder must have god level access.
   * 
   * @access public
   * @param string   The name of the new position.
   * @param string   The abbreviated name of the new position.
   * @param integer  The monthly income of the position.
   * @param boolean  True if a trainee can hold this position, false
   *                 otherwise.
   * @param string   The division to show in the ID line of someone holding
   *                 this ID line. Leave blank to show the real division.
   * @param boolean  True if the position gets a thebhg.org e-mail alias,
   *                 false otherwise.
   * @param integer  The position to insert this position after. May be a
   *                 position ID or Position object.
   * @returns object New Position object on success. 0 on failure.
   */
  function CreatePosition($name, $abbrev, $income, $trainee, $sdiv, $alias,
                          $after) {
    if ($this->Allowed('god')) {
      
      if (   is_object($after) 
          && ($after instanceof Position)) {
        
        $order = $after->GetWeight() + 1;
        
      } elseif (is_int($after)) {
        
        $order = $after + 1;
        
      } else {
        
        $this->roster_error = "Invalid After parameter passed to "
                             ."CreatePosition";
        
        return false;
        
      }
      

      $sql = "UPDATE roster_position SET `order`=`order`+1 WHERE "
            ."`order`>='$order'";

      if (mysql_query($sql, $this->roster_db)) {

        $sql = "INSERT INTO roster_position (`name`, `abbrev`, `income`, "
              ."`istrainee`, `special_division`, `is_email_alias`, `order`) "
              ."VALUES ('".addslashes($name)."', '".addslashes($abbrev)."', "
              ."'$income', '$trainee', '".addslashes($sdiv)."', '$alias', "
              ."'$order')";
        
        if (mysql_query($sql, $this->roster_db)) {
          
          $lastid = mysql_query("SELECT LAST_INSERT_ID() AS LastID", $this->roster_db);
          
          return new Position(mysql_result($lastid, 0, "LastID"), 
                              $this->roster_coder);
          
        } else {
          
          $this->roster_error = "Error Creating Position";
          
          return false;
          
        }

      } else {

        $this->roster_error = "Error updating Position orders, query: $sql; "
                             ."error: ".mysql_error($this->roster_db);

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";
      
      return false;
      
    }
    
  }

  // }}}
  // {{{ CreateRank()

  /**
   * Create a new Rank
   *
   * This function creates a new rank within the BHG Roster System.
   * To call this function the coder must have god level access.
   * 
   * @access public
   * @param string   The name of the new rank.
   * @param string   The abbreviated name for the new rank.
   * @param integer  The number of credits required to achieve this new
   *                 rank.
   * @param boolean  True if the rank is available to everyone, including
   *                 trainees, false otherwise.
   * @param boolean  True if the rank features unlimited credits, false
   *                 otherwise.
   * @param boolean  True if the rank must be manually set, false otherwise.
   * @param mixed    The rank to place the new rank after in. May be a rank ID
   *                 or Rank object.
   * @returns object New Rank object on success. 0 on failure.
   */
  function CreateRank($name, $abbrev, $credits, $aa, $unlim, $manual, $after) {
    if ($this->Allowed('god')) {
      
      if (   is_object($after) 
          && ($after instanceof Rank)) {
        
        $order = $after->GetWeight() + 1;
        
      } elseif (is_numeric($after)) {
        
        $order = $after + 1;

        foreach ($this->GetRanks() as $rank) {

          if ($rank->GetWeight() == ($order - 1)) {
        
            $after = new Rank($after, $this->roster_coder);

          }

        }
        
      } else {
        
        $this->roster_error = "Invalid after parameter passed to CreateRank";
        
        return false;
        
      }
      

      $sql = "UPDATE roster_rank SET `order`=`order`+1 WHERE `order`>='$order'";

      if (mysql_query($sql, $this->roster_db)) {

        $sql = "INSERT INTO roster_rank (`name`, `abbrev`, `credits_needed`, "
              ."`always_available`, `unlimited_credits`, `manual_set`, `order`) "
              ."VALUES ('".addslashes($name)."', '".addslashes($abbrev)."', "
              ."'$credits', '$aa', '$unlim', '$manual', '$order')";
        
        if (mysql_query($sql, $this->roster_db)) {

          // If the rank is manually set, we're done, otherwise we will need to
          // update anyone who would fall under the new rank. We can narrow
          // this down somewhat using the credits required for this rank and
          // for the rank we just inserted after.

          if (!$manual) {

            $sql = "SELECT `id` FROM roster_roster WHERE `rankcredits` BETWEEN "
                  ."'$credits' AND '".$after->GetRequiredCredits()."'";

            if ($result = mysql_query($sql, $this->roster_db)) {

              if (mysql_num_rows($result) > 0) {

                while ($row = mysql_fetch_array($result)) {

                  $person = new Person($row['id'], $this->roster_coder);

                  $person->UpdateRank();

                }

              }

            } else {

              // This is a non-fatal error.
              
              $this->roster_error = "Error updating person records, query: "
                                   ."$sql; error: "
                                   .mysql_error($this->roster_db);

            }

          }
          
          $lastid = mysql_query("SELECT LAST_INSERT_ID() AS LastID", $this->roster_db);
          
          return new Rank(mysql_result($lastid, 0, "LastID"), 
                              $this->roster_coder);
          
        } else {
          
          $this->roster_error = "Error creating Rank, query: $sql; error: "
                               .mysql_error($this->roster_db);
          
          return false;
          
        }

      } else {

        $this->roster_error = "Error updating Rank orders, query: $sql; error: "
                             .mysql_error($this->roster_db);

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";
      
      return false;
      
    }
    
  }

  // }}}
  
}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

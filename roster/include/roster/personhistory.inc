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
 * PersonHistory - The entry point to a persons history
 *
 * This object is basically a list of HistoryEvents which can be filtered and
 * reordered
 *
 * <pre>
 *  20030619  aa  standardised on boolean returns
 *  20030611  aa  on Load of data set position to first item
 *  20030317  aa  documentation fixes
 *  20020523  aa  commented
 * </pre>
 *
 * @author Adam Asahley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Roster
 * @access public
 * @version $Revision: 1.20 $
 *
 */
class PersonHistory extends BHGObject {

  // {{{ properties

  /**
   * Array of HistoryItem ids and dates
   *
   * @access protected
   * @var array $history
   */
  var $history;

  /**
   * Counter indicating where in the array we are
   *
   * @access protected
   * @var integer position
   */
  var $position;

  /**
   * Person this history for
   *
   * @access protected
   * @var integer person
   */
  var $person;

  // }}}
  // {{{ PersonHistory

  /**
   * Object Constructor
   *
   * Calls the constructor of the Parent object and loads the relevant data
   *
   * @access public
   * @param integer id ID Number of the Person
   * @param string coder Coder Identification String
   */
  function PersonHistory($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $this->person = $id;

    $this->Unload();
    
  }

  // }}}
  // {{{ Load()

  /**
   * Load the History Items into memory
   *
   * This is always the first step when accessing the history. Tell the object
   * which selection of history items you wish to load.
   *
   * History Items can be filtered by type, and limited to certain date ranges
   *
   * @access public
   * @param integer startdate The Start Date to load from in Unixtime, 0 means
   *                          first available record
   * @param integer enddate The End Date to load to in Unixtime, 0 means the 
   *                        last available record
   * @param array limit Array of type identifies. Only these types of records
   *                    are returned.
   * @param string dateorder the order in which the items are sorted by date.
   *                         either ASC or DESC
   */
  function Load($startdate = 0, 
                $enddate = 0, 
                $limit = array(),
                $dateorder = 'ASC') {

    $sql = "SELECT id, "
                 ."date "
          ."FROM roster_history "
          ."WHERE person = ".$this->person." ";
    
    if (sizeof($limit) > 0) {
      
      $sql .= "AND type IN (".implode(',', $limit).") ";

    }

    if ($startdate > 0) {

      $sql .= "AND date >= ".$startdate." ";

    }

    if ($enddate > 0) {

      $sql .= "AND date <= ".$enddate." ";

    }

    $sql .= "ORDER BY date ".$dateorder;

    $items = mysql_query($sql, $this->roster_db);

    while ($item = mysql_fetch_array($items)) {

      $this->history[] = $item;

    }

    $this->position = 0;

    return true;

  }

  // }}}
  // {{{ Unload()

  /**
   * Unload the History
   *
   * If you wish to load a different set of history items call this first to
   * remove the first set
   *
   * @access public
   */
  function Unload() {

    unset($this->history);

    $this->history = array();
    $this->position = 0;

  }

  // }}}
  // {{{ Count()

  /**
   * How many HistoryItems are loaded
   *
   * @access public
   * @return integer the number of history items
   */
  function Count() {

    return sizeof($this->history);

  }

  // }}}
  // {{{ First()

  /**
   * Jump to the first item
   *
   * @access public
   * @return integer the index number of the item we looking at
   */
  function First() {

    $this->position = 0;

    return $this->position;

  }

  // }}}
  // {{{ Last()

  /**
   * Jump to the Last item
   *
   * @access public
   * @return integer the index number of the item we are looking at
   */
  function Last() {

    $this->position = sizeof($this->history) - 1;

    return $this->position;

  }

  // }}}
  // {{{ Next()

  /**
   * Goto the Next item
   *
   * @access public
   * @return mixed the index number of the item we are now looking at or
   *               false if already at last item. 
   *               use $history->Next === false to check
   */
  function Next() {

    if ($this->position < sizeof($this->history) - 1) {

      $this->position++;

      return $this->position;

    } else {

      return false;

    }

  }

  // }}}
  // {{{ Previous()

  /**
   * Goto the Previous itemm
   *
   * @access public
   * @return mixed the index number of the item we are now looking at or
   *               false if already at first item.
   *               use $history->Previous ==== false to check
   */
  function Previous() {

    if ($this->position == 0) {

      return false;

    } else {

      $this->position--;

      return $this->position;

    }

  }

  // }}}
  // {{{ GotoDate()

  /**
   * Goto the first available history item equal to or after the supplied date
   *
   * @access public
   * @param integer date the date we wish to jump to
   * @return mixed the index number of the item we are now looking at or 
   *               false if date after last item in array
   */
  function GotoDate($date) {

    for ($i = 0; $i < sizeof($this->history); $i++) {

      if ($this->history[$i]['date'] >= $date) {

        $this->position = $i;

        return $this->position;

      } elseif (   $i == (sizeof($this->history) - 1)
                && $this->history[$i]['date'] < $date) {

        return false;

      }

    }

  }

  // }}}
  // {{{ GetItem()

  /**
   * Get the HistoryItem Object for the item we currently pointing at
   *
   * @access public
   * @return object HistoryItem
   */
  function GetItem() {

    return new HistoryItem($this->history[$this->position]['id'], 
                           $this->roster_coder);

  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

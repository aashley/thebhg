<?php
/**
 * This file contains objects required for the Core Roster Functionality
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.19 $
 * @package Roster
 * @subpackage Roster
 */

/**
 * HistoryItem - Each an every event that happened throughout history
 *
 * This object represents a sinlge descret event
 *
 * <pre>
 *  20030602  aa  added support for Joined Cadre and Left Cadre events
 *  20030329  ah  more changes to the human-readable text in GetReadable
 *  20030317  aa  documentation fixes
 *  20030218  ah  small change to add demoted text
 *  20030128  aa  GetPerson function was incorrectly named GetID, surprised
 *                this object could even be instansiated.
 *  20020917  aa  created
 * </pre>
 *
 * @author Adam Asahley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Roster
 * @access public
 * @version $Revision: 1.19 $
 *
 */
class HistoryItem extends BHGObject {

  // {{{ properties

  /**
   * History Item ID Number
   *
   * @access protected
   * @var integer $item_id
   * @see GetID()
   */
  var $item_id;

  /**
   * History Item Date
   *
   * @access protected
   * @var integer $item_date
   * @see GetDate()
   */
  var $item_date;

  /**
   * History Item Person this event occured to
   *
   * @access protected
   * @var integer $item_person
   * @see GetPerson()
   */
  var $item_person;

  /**
   * History Item Type
   *
   * @access protected
   * @var integer $item_type
   * @see GetType()
   */
  var $item_type;

  /**
   * History Item Item 1
   *
   * @access protected
   * @var string $item_item1
   * @see GetItem()
   */
  var $item_item1;

  /**
   * History Item Item 2
   *
   * @access protected
   * @var string $item_item2
   * @see GetItem()
   */
  var $item_item2;

  /**
   * History Item Item 3
   *
   * @access protected
   * @var string $item_item3
   * @see GetItem()
   */
  var $item_item3;

  // }}}
  // {{{ HistoryItem()

  /**
   * Object Constructor
   *
   * Calls the constructor of the Parent object and loads the relevant data
   *
   * @access public
   * @param integer id ID Number of the Person
   * @param string coder Coder Identification String
   */
  function HistoryItem($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $sql = "SELECT id, "
                 ."date, "
                 ."person, "
                 ."type, "
                 ."item1, "
                 ."item2, "
                 ."item3 "
          ."FROM roster_history "
          ."WHERE id = ".$id;

    $itemdb = mysql_query($sql, $this->roster_db);

    if ($item = mysql_fetch_array($itemdb)) {

      $this->item_id = $item['id'];
      $this->item_date = $item['date'];
      $this->item_person = $item['person'];
      $this->item_type = $item['type'];
      $this->item_item1 = stripslashes($item['item1']);
      $this->item_item2 = stripslashes($item['item2']);
      $this->item_item3 = stripslashes($item['item3']);

    } else {

      $this->roster_error = "Invalid Event ID. Could not create object.";

    }
    
  }

  // }}}
  // {{{ GetID()

  /**
   * Get the ID Number
   *
   * @access public
   * @return integer ID Number
   */
  function GetID() {
    
    return $this->item_id;

  }

  // }}}
  // {{{ GetDate()

  /**
   * Get the Date of the event
   *
   * @access public
   * @return integer Date in Unixtime
   */
  function GetDate() {
    
    return $this->item_date;

  }

  // }}}
  // {{{ GetType()

  /**
   * Get the Type of the event
   *
   * @access public
   * @return integer Event Type
   */
  function GetType() {
    
    return $this->item_type;

  }

  // }}}
  // {{{ GetPerson()

  /**
   * Get the Person that this event relates to
   *
   * @access public
   * @return object Person
   * @uses Person
   */
  function GetPerson() {
    
    return new Person($this->item_person, $this->roster_coder);

  }

  // }}}
  // {{{ GetItem()

  /**
   * Get the the raw data item
   *
   * @access public
   * @param integer number the item number you wish
   * @return string the data
   */
  function GetItem($number) {

    $item1 = $this->item_item1;
    $item2 = $this->item_item2;
    $item3 = $this->item_item3;

    $get = "item".$number;
    
    return $$get;

  }

  // }}}
  // {{{ GetReadable()

  /**
   * Get the human readable description of this event
   *
   * This function returns a string that contains a sentence describing what
   * happened at this event.
   *
   *<pre>
   *  1   Rank Change
   *  2   Position Change
   *  3   Division Change
   *  4   Changed Name
   *  5   Changed Email
   *  6   Earned Rank Credits
   *  7   Change in Account Balance (Purchase/Sale)
   *  8   Awarded Medal
   *  9   Joined BHG
   * 10   Deleted From the Roster
   * 11   Joined Cadre
   * 12   Left Cadre
   *</pre>
   *
   *
   * @access public
   * @param boolean date Whether to include the date in the output.
   * @param boolean name Whether to include the name of the person that the 
   *                     event happened to.
   * @return string the formated output
   * @uses GetPerson()
   * @uses Person
   * @uses Person::GetName()
   * @uses Rank
   * @uses Rank::GetRequiredCredits()
   * @uses Rank::GetName()
   * @uses Position
   * @uses Position::GetName()
   * @uses Division
   * @uses Division::GetName()
   * @uses AwardedMedal
   * @uses AwardedMedal::GetMedal()
   * @uses AwardedMedal::GetReason()
   * @uses Medal
   * @uses Medal::GetName()
   * @uses Cadre
   * @uses Cadre::GetName()
   */
  function GetReadable($date = true,
                       $name = false) {

    if ($date) {

      $output = date('F jS Y, g:iA', $this->item_date).", ";

    } else {

      $output = "";

    }

    if ($name) {

      $person = $this->GetPerson();

      $output .= $person->GetName().", ";

    } else {

      $output .= "";

    }

    switch ($this->item_type) {

      case 1:
        $oldrank = new Rank($this->item_item1);
        $newrank = new Rank($this->item_item2);

        if ($newrank->GetRequiredCredits() >= $oldrank->GetRequiredCredits()) {
          $output .= "Promoted from ".$oldrank->GetName()." to "
            .$newrank->GetName().".";
        } else {
          $output .= "Demoted from ".$oldrank->GetName()." to "
            .$newrank->GetName().".";
        }

        unset($oldrank, $newrank);
        break;

      case 2:
        $oldposition = new Position($this->item_item1);
        $newposition = new Position($this->item_item2);

        $output .= "Changed position from ".$oldposition->GetName()." to "
          .$newposition->GetName().".";

        unset($oldposition, $newposition);
        break;

      case 3:
        $olddivision = new Division($this->item_item1);
        $newdivision = new Division($this->item_item2);

        $output .= "Transferred from ".$olddivision->GetName()." to "
          .$newdivision->GetName().".";

        unset($olddivision, $newdivision);
        break;

      case 4:
        $output .= "Changed Name from '".$this->item_item1."' to '"
          .$this->item_item2."'.";
        break;

      case 5:
        $output .= "Changed E-Mail Address from '".$this->item_item1."' to '"
          .$this->item_item2."'.";
        break;

      case 6:
        if (is_numeric($this->item_item1)) {

          $person = new Person($this->item_item1);

          $error = $person->Error();

          if ($error > "") {

            $awardedby = $this->item_item1;

          } else {

            $awardedby = $person->GetName();

          }

        } else {

          $awardedby = $this->item_item1;

        }

				if (strlen($awardedby)) {
					$output .= "Earned ".number_format($this->item_item2)." credits "
						."from ".$awardedby.", bringing total credits to "
						.number_format($this->item_item3).".";
				} else {
					$output .= "Earned ".number_format($this->item_item2)." credits, "
						."bringing total credits to ".number_format($this->item_item3).".";
				}

        unset($awardedby);
        break;

      case 7:
        if (is_numeric($this->item_item1)) {

          $person = new Person($this->item_item1);

          $error = $person->Error();

          if ($error > "") {

            $from = $this->item_item1;

          } else {

            $from = $person->GetName();

          }

        } else {

          $from = $this->item_item1;

        }

        if (   substr($this->item_item3, 0, 1) == '-'
            || $this->item_item3 < 0) {

					if (strlen($this->item_item2)) {
						$output .= "Sold ".$this->item_item2." to ".$from." for "
							.abs($this->item_item3).".";
					} else {
						$output .= "Sold an item for ".abs($this->item_item3).".";
					}

        } else {

					if (strlen($this->item_item2)) {
						$output .= "Purchased ".$this->item_item2." from ".$from." for "
							.abs($this->item_item3).".";
					} else {
						$output .= "Purchased an item for ".abs($this->item_item3).".";
					}
          
        }

        unset($from);
        break;

      case 8:
        $award = new AwardedMedal($this->item_item1);
        $medal = $award->GetMedal();
        $awarder = $award->GetAwarder();

        $output .= "Awarded ".$medal->GetName()." by ".$awarder->GetName();

        if ($award->GetReason() > "") {

          $output .= " for ".$award->GetReason();

        }

        $output .= ".";

        unset($award, $medal, $awarder);
        break;

      case 9:
        $output .= "Joined the Bounty Hunters Guild";
        
        if ($this->item_item1 > "") {
          
          $division = new Division($this->item_item1);
          
          $output .= ", entering ".$division->GetName();

        }

        $output .= ".";

        unset($division);
        break;

      case 10:
        $output .= "Deleted from the Roster.";
        break;

      case 11:
        $cadre = new Cadre($this->item_item1);
        
        $output .= 'Joined '.$cadre->GetName().' Cadre.';

        unset($cadre);
        break;

      case 12:
        $cadre = new Cadre($this->item_item1);
        
        $output .= 'Left '.$cadre->GetName().' Cadre.';

        unset($cadre);
        break;

      default:
        $output .= "Unknown Event Type.";
        break;

    }

    return $output;

  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

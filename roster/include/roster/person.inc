<?php
/**
 * This file contains objects required for the Core Roster Functionality
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.78 $
 * @package Roster
 * @subpackage Roster
 */

/**
 * Person - The Basis of everything, the person.
 *
 * This is the most imporant object it provides details about the basis of 
 * eveything in the BHG the individual Hunter<br><br>
 *
 * <pre>
 *  20040218  ah  fixed displaytype 2 support in IDLine
 *  20031124  aa  added InKabal()
 *  20031102  aa  fixed NTC Flag
 *  20030906  ah  fixed MakeSale to pass reason information to MakePurchase
 *  20030831  aa  updated ID Line to use new citadel db
 *  20030803  aa  simplified data loading
 *                sorted functions
 *                added support for aim, icq, jabber, msn and yahoo IM systems
 *  20030709  aa  added Cadre Support
 *                doco updates
 *  20030619  aa  prevent changes to Rank Credits and Account Balance for
 *                people in the Disavowed Group.
 *                standardised on boolean returns
 *  20030617  aa  made sure all db queries use the roster database connection
 *  20021220  aa  if transfered to kabal with welcome message send the msg
 *  20021218  ah  added support for special divisions to IDLine
 *  20021218  aa  when someone is Hunter and they have a GH or FH medal their
 *                position is set to the eqiv while executing UpdateRank
 *  20021216  aa  Fixed it so that Email and Name can not be set blank.
 *  20021204  aa  fixed RecordEvent call in MakePurchase, purchases should
 *                appear in history now.
 *                removed security checks on SendEmail, should fix notification
 *                until i can get around to doing it properly.
 *  20021109  ah  added some code to deal with AWOLs, full details in bug
 *                301 on the bug tracker
 *  20021105  aa  added GetBioData
 *  20021028  aa  fix for setting position/division/rank to the same as the
 *                current one
 *  20020918  aa  added calls to record history events
 *  20020815  aa  completed GetMedals
 *  20020722  aa  fixed display of citadel awards
 *  20020712  aa  made change to how AddCredits and MakePurchase work to 
 *                elminate the chances of two updates occuring at once
 *                and one clobbering the other
 *  20020709  aa  added citadel awards to the idline
 *  20020605  aa  added option to only display medals when calling idline
 *  20020601  aa  email notification on changes complete
 *  20020531  aa  added condition checks for sending emails
 *  20020525  aa  added SendEmail and internal function UpdateRank
 *  20020522  aa  doco changes
 *  20020330  aa  completed idlines
 *  20020224  aa  Completed almost all functions. Delete, medal support and 
 *                minor changes relating to other code remaining
 *  20020223  aa  Commented
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Roster
 * @access public
 * @version $Revision: 1.78 $
 *
 */
class Person extends BHGObject {

  // {{{ properties

  /**
   * Person's ID Number
   *
   * @access protected
   * @var integer $person_id 
   * @see GetID()
   */
  var $person_id;

  /**
   * Person's Name
   *
   * @access protected
   * @var string $person_name
   * @see GetName()
   */
  var $person_name;

  /**
   * Person's Email Address
   *
   * @access protected
   * @var string $person_email
   * @see GetEMail()
   */
  var $person_email;

  /**
   * Person's Rank
   *
   * @access protected
   * @var integer $person_rank
   * @see GetRank()
   */
  var $person_rank;

  /**
   * Total Credits Earned towards forwarding a person's rank
   *
   * @access protected
   * @var integer $person_rankcredits
   * @see GetRankCredits()
   */
  var $person_rankcredits;

  /**
   * Available Balance of a Person's Account
   *
   * @access protected
   * @var integer $person_accountbalance
   * @see GetAccountBalance()
   */
  var $person_accountbalance;

  /**
   * Person's Division
   *
   * @access protected
   * @var integer $person_division
   * @see GetDivision()
   */
  var $person_division;

  /**
   * Person's Position
   *
   * @access protected
   * @var integer $person_position
   * @see GetPosition()
   */
  var $person_position;

  /**
   * Cadre Person Belongs to
   *
   * @access protected
   * @var integer $person_cadre
   * @see GetCadre(), SetCadre()
   */
  var $person_cadre;

  /**
   * URL of Person's Home Page
   *
   * @access protected
   * @var string $person_url
   * @see GetHomePage()
   */
  var $person_url;

  /**
   * Person's Commonly Used IRC Nicks
   *
   * @access protected
   * @var string $person_ircnicks
   * @see GetIRCNicks()
   */
  var $person_ircnicks;

  /**
   * Person's Quote
   *
   * @access protected
   * @var string $person_quote
   * @see GetQuote()
   */
  var $person_quote;

  /**
   * Person's Previous Division
   *
   * @access protected
   * @var integer $person_previousdivision
   * @see GetPreviousDivision()
   */
  var $person_previousdivision;

  /**
   * Flag whether a person has a ship
   *
   * @access protected
   * @var boolean $person_hasship
   * @see HasShip()
   */
  var $person_hasship;

  /**
   * Flag Whether Person Has completed the NTC Basic Exam
   *
   * @access protected
   * @var boolean $person_ntcexam
   * @see CompletedNTC()
   */
  var $person_ntcexam;

  /**
   * Date Person Joined The BHG
   *
   * @access protected
   * @var integer $person_datejoined (unix timestamp)
   * @see GetJoinDate()
   */
  var $person_datejoined;

  /**
   * Unix Timestamp of when this person's record was last updated
   *
   * @access protected
   * @var integer $person_lastupdated
   * @see GetLastUpdate()
   */
  var $person_lastupdated;

  /**
   * AIM Screen Name
   *
   * @access protected
   * @var string $person_aim
   * @see GetAIM(), SetAIM()
   */
  var $person_aim;

  /**
   * ICQ Number
   * 
   * @access protected
   * @var integer $person_icq
   * @see GetICQ(), GetICQ()
   */
  var $person_icq;

  /**
   * Jabber ID
   * 
   * @access protected
   * @var string $person_jabber
   * @see GetJabber(), SetJabber()
   */
  var $person_jabber;

  /**
   * MSN Passport
   *
   * @access protected
   * @var string $person_msn
   * @see GetMSN(), SetMSN()
   */
  var $person_msn;

  /**
   * Yahoo ID
   *
   * @access protected
   * @var string $person_yahoo
   * @see GetYahoo(), SetYahoo()
   */
  var $person_yahoo;

  // }}}
  // {{{ Person()
  
  /**
   * Object Constructor
   *
   * Calls the contructor of the Parent object (BHGObject) and loads the 
   * relevant data from the database.
   *
   * @access public
   * @param integer id ID Number of the Person
   * @param string coder Coder Identification String
   */
  function Person($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $sql = "SELECT id, "
                 ."name, "
                 ."email, "
                 ."rank, "
                 ."rankcredits, "
                 ."accountbalance, "
                 ."division, "
                 ."position, "
                 ."cadre, "
                 ."url, "
                 ."ircnicks, "
                 ."quote, "
                 ."previous_division AS previousdivision, "
                 ."hasship, "
                 ."completed_ntc_exam, "
                 ."UNIX_TIMESTAMP(date_joined) AS datejoined, "
                 ."UNIX_TIMESTAMP(last_updated) AS lastupdated, "
                 .'icq, '
                 .'aim, '
                 .'msn, '
                 .'yahoo, '
                 .'jabber '
          ."FROM roster_roster "
          ."WHERE id = $id";
    
    $persondb = mysql_query($sql, $this->roster_db);

    if ($person = @mysql_fetch_assoc($persondb)) {
      
      foreach ($person as $key => $value) {

        $key = 'person_'.$key;

        $this->$key = stripslashes($value);

      }
      
    } else {
      
      $this->roster_error = "Invalid Person ID. Could not create object.";
      
    }
    
  }

  // }}}
  
  // Retrival Functions
  // {{{ GetID()

  /**
   * Get A Person's ID Number
   *
   * @access public
   * @return integer A Person's ID Number
   */
  function GetID() {
    return $this->person_id;
  }

  // }}}
  // {{{ GetName()

  /**
   * Get A Person's Name
   *
   * @access public
   * @return string A Person's Name
   */
  function GetName() {
    return $this->person_name;
  }


  // }}}
  // {{{ GetPosition()

  /**
   * Get A Person's Position
   *
   * @access public
   * @return object Position A Person's Position
   * @uses Position
   */
  function GetPosition() {
    return new Position($this->person_position, $this->roster_coder);
  }


  // }}}
  // {{{ GetRank()

  /**
   * Get A Person's Rank
   *
   * @access public
   * @return object Rank A Person's Rank
   * @uses Rank
   */
  function GetRank() {
    return new Rank($this->person_rank, $this->roster_coder);
  }


  // }}}
  // {{{ IDLine()

  /**
   * Get A Person's ID Line
   *
   * The includemedals parameter takes the following options:<br>
   *
   *  0 - Display ID Line only No Medals
   *  1 - Display Full ID Line Including Medals
   *  2 - Display Medals Only
   *
   * @access public
   * @param integer includemedals Flag whether to include medals in the ID Line
   * @return string A String containing the ID Line of the person
   * @uses Rank
   * @uses Rank::GetAbbrev()
   * @uses Division
   * @uses Division::GetName()
   * @uses Position
   * @uses Position::GetAbbrev()
   * @uses Position::GetSpecialDivision()
   */
  function IDLine($includemedals = 1) {
    $rank = new Rank($this->person_rank, $this->roster_coder);
    $position = new Position($this->person_position, $this->roster_coder);
    $division = new Division($this->person_division, $this->roster_coder);

    if ($position->GetSpecialDivision() == "") {
      $div_name = $division->GetName();
    }
    else {
      $div_name = $position->GetSpecialDivision();
    }

    $idline = $rank->GetAbbrev()
             ."/"
             .$this->person_name
             ."/"
             .$div_name
             ."/BHG -"
             .$position->GetAbbrev();

    if (!$includemedals) {

      return trim($idline);

    }

    if ($includemedals == 2) {

      $idline = "";

    }
    
    $result = mysql_query("SELECT count(*) AS count FROM mb_awarded_medals "
        ."WHERE recipientid = ".$this->person_id, $this->roster_db);

    if (mysql_result($result, 0, 'count') > 0) {

      $idline .= " ";

      $sql = "SELECT id "
            ."FROM mb_medal_categories "
            ."ORDER BY `order` ASC";
      
      $categories = mysql_query($sql, $this->roster_db);

      while ($category = mysql_fetch_array($categories)) {

        $sql = "SELECT id, "
                     ."displaytype, "
                     ."startbracket, "
                     ."endbracket "
              ."FROM mb_medal_groups "
              ."WHERE category = ".$category['id']." "
              ."ORDER BY `order`";

        $groups = mysql_query($sql, $this->roster_db);

        while ($group = mysql_fetch_array($groups)) {

          $recieved = array();

          $sql = "SELECT id, "
                       ."abbrev "
                ."FROM mb_medal_names "
                ."WHERE `group` = ".$group['id']." "
                ."ORDER BY `order`";


          $medals = mysql_query($sql, $this->roster_db);

          while ($medal = mysql_fetch_array($medals)) {

            if ($group['displaytype'] == 2) {

              $sql = "SELECT count(*) AS count "
                    ."FROM mb_awarded_medals "
                    ."WHERE recipientid = ".$this->person_id." "
                      ."AND medal = ".$medal['id'];

              $result = mysql_result(mysql_query($sql, $this->roster_db), 0, 'count');

              for ($i = 0; $i < $result; $i++) {

                $recieved[$medal['abbrev']][$i] = $medal['abbrev'];

              }

            } else {

              $sql = "SELECT count(*) AS count "
                    ."FROM mb_awarded_medals "
                    ."WHERE recipientid = ".$this->person_id." "
                      ."AND medal = ".$medal['id'];

              $result = mysql_result(mysql_query($sql, $this->roster_db), 0, 'count');

              for ($i = 0; $i < $result; $i++) {

                $recieved[$i] = $medal['abbrev'];

              }

            }

          }

          if ($group['displaytype'] == 1 && sizeof($recieved) > 0) {

            $idline .= $group['startbracket'].$recieved[0];

            if (sizeof($recieved) > 1) {

              $idline .= "x".sizeof($recieved);

            }

            $idline .= $group['endbracket']." ";

          } elseif ($group['displaytype'] == 2) {

            foreach ($recieved as $sub) {

              if (sizeof($sub) > 0) {
                
                $idline .= $group['startbracket'].$sub[0];

                if (sizeof($sub) > 1) {

                  $idline .= "x".sizeof($sub);

                }
  
                $idline .= $group['endbracket']." ";

              }

            }
            
          } else {
            
            foreach ($recieved as $value) {
              
              $idline .= $group['startbracket'].$value.$group['endbracket']." ";
            
            }

          }

        }

      }

    }

    $idline = trim($idline);

    // Add Citadel courses to list

    $sql = "SELECT ntc_exams.abbr "
          ."FROM ntc_exams, "
               ."ntc_exam_completed "
          ."WHERE ntc_exams.id = ntc_exam_completed.exam "
            ."AND ntc_exam_completed.has_passed = 1 "
            ."AND ntc_exam_completed.bhg_id = ".$this->person_id." "
          ."ORDER BY ntc_exams.id";

    $exams = mysql_query($sql, $this->roster_db);

    if (@mysql_num_rows($exams) > 0) {

      $ntc = "{";

      while ($exam = @mysql_fetch_array($exams)) {

        if ($ntc == "{") {
          
          $ntc .= $exam['abbr'];

        } else {

          $ntc .= "-".$exam['abbr'];

        }

      }

      $ntc .= "}";

      $idline .= " ".$ntc;

    }
  
    return trim($idline);
  }


  // }}}
  
  // {{{ GetCadre()

  /**
   * Get the Cadre of this Person
   *
   * @access public
   * @return mixed False if not in Cadre, Cadre Object if in cadre
   * @uses Cadre
   */
  function GetCadre() {

    if (isset($this->person_cadre)
        && $this->person_cadre > 0) {

      return new Cadre($this->person_cadre, $this->roster_coder);

    } else {

      return false;

    }

  }

  // }}}
  // {{{ GetDivision()

  /**
   * Get A Person's Division
   *
   * @access public
   * @return object Division A Person's Division
   * @uses Division
   */
  function GetDivision() {
    return new Division($this->person_division, $this->roster_coder);
  }


  // }}}
  // {{{ GetPreviousDivision()

  /**
   * Get A Person's ID Number
   *
   * @access public
   * @return object Division The Division A Person was in before the current
   *                         one.
   * @uses Division
   */
  function GetPreviousDivision() {
    return new Division($this->person_previousdivision, $this->roster_coder);
  }


  // }}}

  // {{{ GetAIM()

  /**
   * Retrieve AOL Screen Name
   *
   * @access public
   * @return mixed false if no screen name or string
   */
  function GetAIM() {

    if ($this->person_aim > '') {

      return $this->person_aim;

    } else {

      return false;

    }

  }

  // }}}
  // {{{ GetEmail()

  /**
   * Get A Person's Email Address
   *
   * @access public
   * @return string A Person's Email Address
   */
  function GetEmail() {
    return $this->person_email;
  }


  // }}}
  // {{{ GetHomePage()

  /**
   * Get A Person's Home Page URL
   *
   * @access public
   * @return string URL for a Person's Home Page
   */
  function GetHomePage() {
    return $this->person_url;
  }


  // }}}
  // {{{ GetICQ()

  /**
   * Retrieve ICQ Number
   *
   * @access public
   * @return mixed false if no screen name or integer
   */
  function GetICQ() {

    if ($this->person_icq > 0) {

      return $this->person_icq;

    } else {

      return false;

    }

  }

  // }}}
  // {{{ GetIRCNicks()

  /**
   * Get A Person's Regularly Used IRC Nicks
   *
   * @access public
   * @return string A Person's Regularly Used IRC Nicks
   */
  function GetIRCNicks() {
    return $this->person_ircnicks;
  }


  // }}}
  // {{{ GetJabber()

  /**
   * Retrieve Jabber ID
   *
   * @access public
   * @return mixed false if no id or string
   */
  function GetJabber() {

    if ($this->person_jabber > '') {

      return $this->person_jabber;

    } else {

      return false;

    }

  }

  // }}}
  // {{{ GetMSN()

  /**
   * Retrieve MSN Passport
   *
   * @access public
   * @return mixed false if no passport or string
   */
  function GetMSN() {

    if ($this->person_msn > '') {

      return $this->person_msn;

    } else {

      return false;

    }

  }

  // }}}
  // {{{ GetYahoo()

  /**
   * Retrieve Yahoo ID
   *
   * @access public
   * @return mixed false if no id or string
   */
  function GetYahoo() {

    if ($this->person_yahoo > '') {

      return $this->person_yahoo;

    } else {

      return false;

    }

  }

  // }}}
  
  // {{{ GetAccountBalance()

  /**
   * Get how many credits a person has left to spend
   *
   * @access public
   * @return integer Credits a person has left to spend
   */
  function GetAccountBalance() {
    return $this->person_accountbalance;
  }


  // }}}
  // {{{ GetRankCredits()

  /**
   * Get the Total number of credits a Person has earned in their entire history
   * with the BHG.
   *
   * @access public
   * @return integer A Person's Total Credits
   */
  function GetRankCredits() {
    return $this->person_rankcredits;
  }


  // }}}
  
  // {{{ GetBioData()

  /**
   * Get the BioData object for this person
   *
   * @access public
   * @return object BioData
   * @uses BioData
   */
  function GetBioData() {
    return new BioData($this->person_id, $this->roster_coder);
  }


  // }}}
  // {{{ GetJoinDate()

  /**
   * Get A Person's Join Date
   *
   * @access public
   * @return integer A Person's Join Date (Unix Timestamp)
   */
  function GetJoinDate() {
    return $this->person_datejoined;
  }


  // }}}
  // {{{ GetHistory()

  /**
   * Get A Person's History
   *
   * Place holder for future planned history of people. Currently does nothing
   *
   * @access public
   * @return object PersonHistory An Object Containing a person's history
   * @uses PersonHistory
   */
  function GetHistory() {
    return new PersonHistory($this->person_id, $this->roster_coder);
  }


  // }}}
  // {{{ GetLastUpdate()

  /**
   * Get the Unix Timestamp for the last time this person's record was updated
   *
   * @access public
   * @return integer time stamp of last update
   */
  function GetLastUpdate() {
    return $this->person_lastupdated;
  }


  // }}}
  // {{{ GetMedals()

  /**
   * Get A Person's Medals
   *
   * returns an array of AwardedMedal Objects sorted according to the 
   * conventions of the medal board
   *
   * @access public
   * @return array Array of AwardedMedal Objects
   * @uses AwardedMedal
   */
  function GetMedals() {
    $sql = "SELECT mb_awarded_medals.id "
          ."FROM mb_awarded_medals, "
               ."mb_medal_categories, "
               ."mb_medal_groups, "
               ."mb_medal_names "
          ."WHERE mb_awarded_medals.medal = mb_medal_names.id "
            ."AND mb_medal_names.group = mb_medal_groups.id "
            ."AND mb_medal_groups.category = mb_medal_categories.id "
            ."AND mb_awarded_medals.recipientid = ".$this->person_id." "
          ."ORDER BY mb_medal_categories.`order` ASC, "
                   ."mb_medal_groups.`order` ASC, "
                   ."mb_medal_names.`order` ASC, "
                   ."mb_awarded_medals.`date` ASC ";

    $medals = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($medal = @mysql_fetch_array($medals)) {

      $return [] = new AwardedMedal($medal['id'], $this->roster_coder);

    }

    return $return;
    
  }


  // }}}
  // {{{ GetQuote()

  /**
   * Get A Person's Quote
   *
   * @access public
   * @return string A Person's Quote
   */
  function GetQuote() {
    return $this->person_quote;
  }


  // }}}
  
  // Logic Functions
  // {{{ CompletedNTC()

  /**
   * Whether a person has completed  the primary Citadel exam
   *
   * @access public
   * @return boolean
   */
  function CompletedNTC() {
    return $this->person_completed_ntc_exam;
  }


  // }}}
	// {{{ HasEstate()

	/**
	 * Checks if the hunter has an estate.
	 *
	 * @return boolean
	 */
	function HasEstate() {
		$sql = 'SELECT COUNT(*) AS estates '
					.'FROM lyarna.estate '
					.'WHERE bhg_id = "'.intval($this->person_id).'" ';

		$result = mysql_query($sql, $this->roster_db);

		if ($result
		 && mysql_num_rows($result) > 0) {

			return (mysql_result($result, 0, 'estates') > 0);

		}

		return false;

	}
	
	// }}}
  // {{{ HasShip()

  /**
   * Does a person have a ship?
   *
   * @access public
   * @return boolean Whether a person has a ship or not
   */
  function HasShip() {
    return $this->person_hasship;
  }


  // }}}
  // {{{ InCadre()

  /**
   * Check whether this person is in a cadre
   *
   * If nothing is supplied it returns true or false if this person is in any
   * cadre, if a number or a Cadre Object is supplied as the first parameter
   * it checks if this person is in that specific cadre.
   *
   * @access public
   * @param mixed null for any cadre, Cadre ID number, or Cadre Object
   * @return boolean
   * @uses Cadre
   */
  function InCadre($cadre = null) {

    if (is_null($cadre)) {

      if (isset($this->person_cadre)
          && $this->person_cadre > 0) {

        return true;

      } else {

        return false;

      }

    } else {

      if (is_object($cadre)) {

        if ($cadre instanceof Cadre) {

          if (isset($this->person_cadre)
              && $this->person_cadre > 0
              && $this->person_cadre == $cadre->GetID()) {

            return true;

          } else {

            return false;

          }

        } else {

          $this->roster_error = 'Invalid Object passed to InCadre().';

          return false;

        }

      } elseif (is_numeric($cadre)) {

        if (isset($this->person_cadre)
            && $this->person_cadre > 0
            && $this->person_cadre == $cadre) {

          return true;

        } else {

          return false;

        }

      } else {

        $this->roster_error = 'Invalid parameter passed to InCadre().';

        return false;

      }

    }

  }

  // }}}
  // {{{ InDivision()

  /**
   * Is/was this person in a specific division
   *
   * Is this person currently in a division, or where they in this division
   * between two specific dates
   *
   * @param object Division
   * @param object Date
   * @param object Date
   * @return boolean
   */
  function InDivision($checkdiv, $from = null, $to = null) {

    if (is_null($from) || is_null($to)) {

      return ($this->person_division == $checkdiv->GetID());

    } else {

      $sql = 'SELECT id, '
                   .'person, '
                   .'date, '
                   .'item1, '
                   .'item2 '
            .'FROM roster_history '
            .'WHERE type = 3 '
              .'AND person = '.$this->person_id.' '
              .'AND (   item1 = '.$checkdiv->getID().' '
                   .'OR item2 = '.$checkdiv->getID().') '
            .'ORDER BY date DESC';

      $results = mysql_query($sql, $this->roster_db);

      if (mysql_num_rows($results) == 0) {

        return ($this->person_division == $checkdiv->GetID());

      }

      $return = array();

      $lastrecord = array();

      while ($row = mysql_fetch_array($results)) {

        $rowdate = new Date();

        $rowdate->setDate($row['date'], DATE_FORMAT_UNIXTIME);

        if (   $checkdiv->getID() == $row['item1']
            && $rowdate->before($to)
            && $rowdate->after($from)) {

          return true;

        } elseif (   $checkdiv->getID() == $row['item2']
                  && $rowdate->before($to)
                  && $rowdate->after($from)) {

          return true;

        } else {

          if (!isset($lastrecord[$row['person']])) {

            if ($checkdiv->getID() == $row['item1']) {

              if ($rowdate->after($to)) {

                $lastrecord[$row['person']] = 'endafter';

              } else {

                $lastrecord[$row['person']] = 'endbefore';

              }

            } elseif (   $checkdiv->getID() == $row['item2']
                      && $rowdate->before($from)) {

              return true;

            }

          } elseif ($lastrecord[$row['person']] == 'endafter') {

            if ($checkdiv->getID() == $row['item2']) {

              if ($rowdate->before($to)) {

                return true;

              }

              unset($lastrecord[$row['person']]);

            }

          } elseif ($lastrecord[$row['person']] == 'endbefore') {

            if ($checkdiv->getID() == $row['item2']) {

              unset($lastrecord[$row['person']]);

            }

          }

        }

      }
      
      return false;

    }

  }

  // }}}
  // {{{ IsCadreLeader()

  /**
   * Does this person lead the cadre they are in
   *
   * @access public
   * @param mixed Cadre Object or Cadre ID Number
   * @return boolean
   * @uses GetCadre()
   * @uses Cadre
   * @uses Cadre::GetLeader()
   */
  function IsCadreLeader($cadre = null) {

    if (is_null($cadre)) {

      $cadre = $this->GetCadre();

    }

    if (is_object($cadre)) {

      if ($cadre instanceof Cadre) {

      } else {

        $this->roster_error = 'Incorrect Object passed to '
          .'Person::IsCadreLeader().';

        return false;

      }

    } elseif (is_numeric($cadre)) {

      $cadre = new Cadre($cadre, $this->roster_coder);

    } else {

      $this->roster_error = 'Incorrect Parameter passed to '
        .'Person::IsCadreLeader().';

      return false;

    }

    if ($this->InCadre($cadre)) {

      $leader = $cadre->GetLeader();

      if ($leader->GetID() == $this->person_id) {

        return true;

      } else {

        return false;

      }

    } else {

      return false;

    }

  }

  // }}}
  // {{{ IsActive()

  /**
   * Is A Person Active?
   *
   * A Person is consider active if they have not been deleted, and are not 
   * currently residing in the Unassigned Pool or the Retirees
   *
   * @access public
   * @return boolean
   */
  function IsActive() {
    return (   $this->person_division != 16 
            && $this->person_division != 12 
            && $this->person_division != 11);
  }


  // }}}
  // {{{ IsDeleted()

  /**
   * Check Whether this person record has been deleted
   *
   * @access public
   * @return boolean 
   */
  function IsDeleted() {
    return ($this->person_division == 16);
  }


  // }}}
  // {{{ IsHunter()

  /**
   * Whether a Person is a Hunter or Not
   *
   * @access public
   * @return boolean
   * @uses Position
   * @uses Position::IsTrainee()
   */
  function IsHunter() {
    $position = $this->GetPosition();
    return (   ($this->person_ntcexam && $this->person_hasship) 
            || !$position->IsTrainee());
  }


  // }}}

  // Set Functions
  // {{{ SetName()

  /**
   * Set A Person's Name
   *
   * @access public
   * @param string name The New Name
   * @return boolean Whether Set Succed or Failed
   * @uses BHGObject::Allowed()
   */
  function SetName($name) {
    
    if ($this->Allowed('god')) {

      if ($name > "") {

        if ($name != $this->person_name) {
      
          // do it
          $sql = "UPDATE roster_roster "
                ."SET name = '".addslashes($name)."' "
                ."WHERE id = ".$this->person_id;

          if (mysql_query($sql, $this->roster_db)) {
  
            $oldname = $this->person_name;
  
            $this->person_name = $name;

            $GLOBALS['internalexecute'] = 'history';

            $this->RecordEvent(4, $oldname, $name);

            if ($message = $this->GetSetting('namechange') > "") {

              // send notice
  
              $replace = array();

              $replace['%new_name%'] = $this->person_name;
              $replace['%old_name%'] = $oldname;
              $replace['%member_idline%'] = $this->IDLine();
          
              $message = ParseEmailTemplate($message, $replace);

              $division = $this->GetDivision();

              if ($division->IsKabal()) {

                $kabal = new Kabal($division->GetID(), $this->roster_coder);

                $chief = $kabal->GetChief();

                if ($chief->GetID() != $this->GetID()) {
            
                  $chief->SendEmail("roster@thebhg.org",
                                    "[Roster] $oldname has changed their name.",
                                    $message);

                }

                unset($kabal, $chief);
            
              }

              unset($division);

            }
        
            return true;

          } else {

            $this->roster_error = "Could not set new Name";

            return false;

          }

        } else {

          return true;

        }

      } else {

        $this->roster_error = "Can not set Name to nothing";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ SetPosition()

  /**
   * Set A Person's Position
   *
   * @access public
   * @param int position The ID number of the position you wish to transfer
   *                      this person to. Can also take an object of type
   *                     Position.
   * @return boolean Whether Set Succed or Failed
   * @uses BHGObject::Allowed()
   * @uses BHGObject::GetSetting()
   * @uses UpdateRank()
   * @uses RecordEvent()
   * @uses SendEmail()
   * @uses IDLine()
   * @uses Position
   * @uses Position::GetID()
   * @uses Position::GetName()
   * @uses Position::GetAbbrev()
   * @uses Roster
   * @uses Roster::SearchPosition()
   * @uses Division
   * @uses Division::IsKabal()
   * @uses Division::IsWing()
   * @uses Kabal
   * @uses Kabal::GetChief()
   * @uses Wing
   * @uses Wing::GetWarden()
   * @uses ParseEmailTemplate()
   */
  function SetPosition($position) {
    
    if ($this->Allowed('god') || $GLOBALS['internalexecute'] == 'position') {
      
      // do it

      if (   is_object($position)
          && ($position instanceof Position)) {

        $positionid = $position->GetID();

      } elseif (is_numeric($position)) {

        $positionid = $position;

      } else {

        $this->roster_error = "Invalid Position passed to SetPosition";

        return false;

      }

      if ($positionid == $this->person_position) {

        return true;

      }

      $sql = "UPDATE roster_roster "
            ."SET position = ".$positionid." "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $oldposition = new Position($this->person_position);
        $newposition = new Position($positionid);

        if ($newposition->GetID() == 22) {
          return true;
        }

        $GLOBALS['internalexecute'] = 'history';

        $this->RecordEvent(2,
                           $oldposition->GetID(),
                           $newposition->GetID());

        $this->person_position = $positionid;

        if (!isset($GLOBALS['caller']) || $GLOBALS['caller'] != 'update') {
          $this->UpdateRank();
        }

        if ($newposition->GetID() == 14) {
          $message = $this->GetSetting('newhunter');
        } else {
          $message = $this->GetSetting('positionchange');
        }

        if ($message > "") {

          // send notice

          $replace = array();

          $replace['%member_name%'] = $this->person_name;
          $replace['%old_position_name%'] = $oldposition->GetName();
          $replace['%old_position_abbrev%'] = $oldposition->GetAbbrev();
          $replace['%new_position_name%'] = $newposition->GetName();
          $replace['%new_position_abbrev%'] = $newposition->GetAbbrev();
          $replace['%member_idline%'] = $this->IDLine();
          $roster = new Roster();
          $underlord = $roster->SearchPosition(2);
          $replace['%underlord_name%'] = $underlord[0]->GetName();
          $replace['%underlord_email%'] = $underlord[0]->GetEmail();
          
          $message = ParseEmailTemplate($message, $replace);

          if ($newposition->GetID() == 14) {
            $this->SendEmail("roster@thebhg.org",
                             "[Roster] ".$this->person_name
                             .", you are now a hunter.",
                             $message);
          } else {
            $this->SendEmail("roster@thebhg.org",
                             "[Roster] ".$this->person_name
                             .", you have been reassigned.",
                             $message);
          }

          $division = $this->GetDivision();

          if ($division->IsKabal()) {

            $kabal = new Kabal($division->GetID(), $this->roster_coder);

            $chief = $kabal->GetChief();

            if ($chief->GetID() != $this->GetID()) {
            
              $chief->SendEmail("roster@thebhg.org",
                                "[Roster] ".$this->person_name
                                .", you have been reassigned.",
                                $message);

            }

            unset($kabal, $chief);
            
          } elseif ($division->IsWing()) {

            $wing = new Wing($division->GetID(), $this->roster_coder);

            $warden = $wing->GetWarden();

            if ($warden->GetID() != $this->GetID()) {
              
              if ($newposition->GetID() == 14) {
                $this->SendEmail("roster@thebhg.org",
                                 "[Roster] ".$this->person_name
                                 .", you are now a hunter.",
                                 $message);
              } else {
                $this->SendEmail("roster@thebhg.org",
                                 "[Roster] ".$this->person_name
                                 .", you have been reassigned.",
                                 $message);
              }

            }

          }

          unset($division);

        }
        
        return true;

      } else {

        $this->roster_error = "Error updating Person's Record";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ SetRank()

  /**
   * Set A Person's Rank
   *
   * @access public
   * @param int rank The ID number of the rank you wish to assign to this
   *                 person. Can also be an object of type Rank.
   * @return boolean Whether Set Succed or Failed
   */
  function SetRank($rank) {
    
    if ($this->Allowed('god') || $GLOBALS['internalexecute'] == 'rank') {
      
      // do it

      if (   is_object($rank)
          && ($rank instanceof Rank)) {

        $rankid = $rank->GetID();

      } elseif (is_numeric($rank)) {

        $rankid = $rank;

      } else {

        $this->roster_error = "Invalid Rank passed to SetRank";

        return false;

      }

      if ($rankid == $this->person_rank) {

        return true;

      }

      $sql = "UPDATE roster_roster "
            ."SET rank = ".$rankid." "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $oldrank = new Rank($this->person_rank);
        $newrank = new Rank($rankid);

        $GLOBALS['internalexecute'] = 'history';

        $this->RecordEvent(1,
                           $oldrank->GetID(),
                           $newrank->GetID());

        $this->person_rank = $rankid;

        if ($GLOBALS['caller'] != 'update') {
          $this->UpdateRank();
        }

        $message = $this->GetSetting('promotion');

        if ($message > "") {

          // send notice

          $replace = array();

          $replace['%member_name%'] = $this->person_name;
          $replace['%old_rank_name%'] = $oldrank->GetName();
          $replace['%old_rank_abbrev%'] = $oldrank->GetAbbrev();
          $replace['%new_rank_name%'] = $newrank->GetName();
          $replace['%new_rank_abbrev%'] = $newrank->GetAbbrev();
          $replace['%member_idline%'] = $this->IDLine();
          
          $message = ParseEmailTemplate($message, $replace);

          $this->SendEmail("roster@thebhg.org",
                           "[Roster] Congratulations ".$this->person_name
                           .". You have been promoted.",
                           $message);

          $division = $this->GetDivision();

          if ($division->IsKabal()) {

            $kabal = new Kabal($division->GetID(), $this->roster_coder);

            $chief = $kabal->GetChief();

            if ($chief->GetID() != $this->GetID()) {
            
              $chief->SendEmail("roster@thebhg.org",
                                "[Roster] Congratulations ".$this->person_name
                                .". You have been promoted.",
                                $message);

            }

            unset($kabal, $chief);
            
          }

          unset($division);

        }
        
        return true;

      } else {

        $this->roster_error = "Error updating Person's Record";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ SetPassword()

  /**
   * Set A Person's Password
   *
   * @access public
   * @param string password New Password
   * @return boolean Whether Set Succed or Failed
   */
  function SetPassword($password) {
    
    if ($this->Allowed('god')) {
      
      // do it

      $sql = "UPDATE roster_roster "
            ."SET passwd = OLD_PASSWORD('".$password."') "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        if (($message = $this->GetSetting('passwordchange')) > "") {

          $replace = array();

          $replace['%personal_page_url%'] = 
              $this->GetSetting('changepasswordurl');
          $replace['%username%'] = $this->GetID();
          $replace['%new_password%'] = $password;

          $message = ParseEmailTemplate($message, $replace);

          $this->SendEmail("roster@thebhg.org",
                           "[Roster] Your New Password",
                           $message);

          unset($replace);

        }
       
        return true;

      } else {

        $this->roster_error = "Could not set new password";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}

  // {{{ SetCadre()

  /**
   * Change the Cadre a Person belongs to
   *
   * @access public
   * @param integer The ID number of the cadre to add a person to. Use 0 to 
   *                remove someone from a Cadre.
   * @return boolean Whether Set Succed or Failed
   */
  function SetCadre($cadre) {
    
    if ($this->Allowed('cadre')) {
      
      // do it

      if (   is_object($cadre)
          && ($cadre instanceof Cadre)) {

        $cadreid = $cadre->GetID();

      } elseif (is_numeric($cadre)) {

        $cadreid = $cadre;

      } else {

        $this->roster_error = "Invalid cadre passed to SetCadre().";

        return false;

      }

      if ($cadreid == $this->person_cadre) {

        return true;

      }

      $sql = "UPDATE roster_roster "
            ."SET cadre = ".$cadreid." "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $GLOBALS['internalexecute'] = 'history';

        if ($cadreid == 0) {
          $this->RecordEvent(12, $this->person_cadre);
        } else {
          $this->RecordEvent(11, $cadreid);
        }

        $this->person_cadre = $cadreid;

        return true;

      } else {

        $this->roster_error = "Error updating Person's Record";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ SetDivision()

  /**
   * Transfer a Person to a new Division
   *
   * @access public
   * @param int division The ID number of the division you wish to transfer a
   *                     person to. Can also take an object of type Division.
   * @return boolean Whether Set Succed or Failed
   */
  function SetDivision($division) {
    
    if ($this->Allowed('god')) {
      
      // do it

      if (   is_object($division)
          && ($division instanceof Division)) {

        $divisionid = $division->GetID();

      } elseif (is_numeric($division)) {

        $divisionid = $division;

      } else {

        $this->roster_error = "Invalid Division passed to SetDivision";

        return false;

      }

      if ($divisionid == $this->person_division) {

        return true;

      }

      $sql = "UPDATE roster_roster "
            ."SET division = ".$divisionid.", "
                ."previous_division = ".$this->person_division." "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->person_previousdivision = $this->person_division;
        $this->person_division = $divisionid;

        $GLOBALS['internalexecute'] = 'history';

        if ($divisionid == 16) {
          $this->RecordEvent(10);
        } else {
          $this->RecordEvent(3, 
                             $this->person_previousdivision,
                             $this->person_division);
        }

        $division = $this->GetDivision();
        $olddivision = $this->GetPreviousDivision();
        
        if ($division->GetID() == 11) {
          $message = $this->GetSetting('awoltransfer');
        } elseif ($division->IsKabal()) {
          $message = $this->GetSetting('transfertokabal');
        } elseif ($division->GetID() != 16) {
          $message = $this->GetSetting('transfer');
        } else {
          $message = "";
        }

        if ($message > "") {

          // send notice

          $replace = array();

          $replace['%member_name%'] = $this->person_name;
          $replace['%old_division_name%'] = $olddivision->GetName();
          $replace['%new_division_name%'] = $division->GetName();
          $replace['%member_idline%'] = $this->IDLine();
          
          if ($division->IsKabal()) {

            $kabal = new Kabal($division->GetID());

            $chief = $kabal->GetChief();
            $cra = $kabal->GetCRA();

            $replace['%new_division_chief_name%'] = $chief->GetName();
            $replace['%new_division_chief_email%'] = $chief->GetEmail();
            $replace['%new_division_cra_name%'] = $cra->GetName();
            $replace['%new_division_cra_email%'] = $cra->GetEmail();
            $replace['%new_division_homepage%'] = $kabal->GetURL();

            unset($kabal, $chief);
            
          }

          if ($olddivision->IsKabal()) {

            $kabal = new Kabal($division->GetID());

            $chief = $kabal->GetChief();
            $cra = $kabal->GetCRA();

            $replace['%old_division_chief_name%'] = $chief->GetName();
            $replace['%old_division_chief_name%'] = $chief->GetEmail();
            $replace['%old_division_cra_name%'] = $cra->GetName();
            $replace['%old_division_cra_name%'] = $cra->GetEmail();

            unset($kabal, $chief);

          }

          $message = ParseEmailTemplate($message, $replace);

          $this->SendEmail("roster@thebhg.org",
                           "[Roster] ".$this->person_name
                           .", you have been transferred.",
                           $message);


          if ($division->IsKabal()) {

            $kabal = new Kabal($division->GetID(), $this->roster_coder);

            $chief = $kabal->GetChief();

            if ($chief->GetID() != $this->GetID()) {

              $chief->SendEmail("roster@thebhg.org",
                                "[Roster] ".$this->person_name
                                .", you have been transferred.",
                                $message);

            }

            $welmessage = $kabal->GetWelcomeMessage();

            if ($welmessage > "") {

              $replace['%hunter_name%'] = $this->person_name;
              $replace['%chief_name%'] = $chief->GetName();
              $replace['%chief_email%'] = $chief->GetEmail();
              $replace['%chief_idline%'] = $chief->IDLine();

              $welmessage = ParseEmailTemplate($welmessage, $replace);

              $this->SendEmail("roster@thebhg.org",
                               "[Roster] ".$this->person_name.", welcome to "
                               .$kabal->GetName()." Kabal.",
                               $welmessage);

            }

            unset($kabal, $chief);
            
          }
          
          if ($olddivision->IsKabal()) {

            $kabal = new Kabal($olddivision->GetID(), $this->roster_coder);

            $chief = $kabal->GetChief();

            if ($chief->GetID() != $this->GetID()) {
            
              $chief->SendEmail("roster@thebhg.org",
                                "[Roster] ".$this->person_name
                                .", you have been transferred.",
                                $message);

            }

            unset($kabal, $chief);
            
          }

          unset($division);
          unset($oldivision);

        }
        
        return true;

      } else {

        $this->roster_error = "Error updating Person's Record";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}

  // {{{ SetAIM()

  /**
   * Set AIM
   *
   * @access public
   * @param string 
   * @return boolean Whether Set Succed or Failed
   */
  function SetAIM($s) {
    
    if ($this->Allowed('god')) {
      
      // do it

      $sql = "UPDATE roster_roster "
            ."SET aim = '".addslashes($s)."' "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->person_aim = $s;

        return true;

      } else {

        $this->roster_error = "Could not set new AIM";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ SetEmail()

  /**
   * Set A Person's Email Address
   *
   * @access public
   * @param string email The new email address
   * @return boolean Whether Set Succed or Failed
   */
  function SetEmail($email) {
    
    if ($this->Allowed('god')) {
      
      // do it

      if ($email > "") {

        if ($email != $this->person_email) {

          $sql = "UPDATE roster_roster "
                ."SET email = '".addslashes($email)."' "
                ."WHERE id = ".$this->person_id;

          if (mysql_query($sql, $this->roster_db)) {

            $oldemail = $this->person_email;

            $this->person_email = $email;

            $GLOBALS['internalexecute'] = 'history';

            $this->RecordEvent(5, $oldemail, $email);

            if ($message = $this->GetSetting('emailchange') > "") {

              // send notice

              $replace = array();

              $replace['%member_name%'] = $this->person_name;
              $replace['%old_email%'] = $oldemail;
              $replace['%new_email%'] = $this->person_email;
              $replace['%member_idline%'] = $this->IDLine();
          
              $message = ParseEmailTemplate($message, $replace);

              $division = $this->GetDivision();

              if ($division->IsKabal()) {

                $kabal = new Kabal($division->GetID(), $this->roster_coder);

                $chief = $kabal->GetChief();

                if ($chief->GetID() != $this->GetID()) {
            
                  $chief->SendEmail("roster@thebhg.org",
                                    "[Roster] ".$this->person_name
                                    ." has changed their e-mail address.",
                                    $message);
              
                }

                unset($kabal, $chief);
            
              }

              unset($division);

            }

            return true;

          } else {

            $this->roster_error = "Could not set new Email Address";

            return false;

          }

        } else {

          return true;

        }

      } else {

        $this->roster_error = "Can not set Email Address to nothing";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ SetHomePage()

  /**
   * Set A Person's Home Page
   *
   * @access public
   * @param string url URL for new Home Page
   * @return boolean Whether Set Succed or Failed
   */
  function SetHomePage($url) {
    
    if ($this->Allowed('god')) {
      
      // do it

      $sql = "UPDATE roster_roster "
            ."SET url = '".addslashes($url)."' "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->person_url = $url;

        return true;

      } else {

        $this->roster_error = "Could not set new home page";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ SetICQ()

  /**
   * Set ICQ
   *
   * @access public
   * @param string 
   * @return boolean Whether Set Succed or Failed
   */
  function SetICQ($s) {
    
    if ($this->Allowed('god')) {
      
      // do it

      $sql = "UPDATE roster_roster "
            ."SET icq = '".addslashes($s)."' "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->person_icq = $s;

        return true;

      } else {

        $this->roster_error = "Could not set new ICQ";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ SetIRCNicks()

  /**
   * Set A Person's Regularly Used IRC Nicks
   *
   * @access public
   * @param string nicks A string containing the new irc nicks
   * @return boolean Whether Set Succed or Failed
   */
  function SetIRCNicks($nicks) {
    
    if ($this->Allowed('god')) {
      
      // do it

      $sql = "UPDATE roster_roster "
            ."SET ircnicks = '".addslashes($nicks)."' "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->person_ircnicks = $nicks;

        return true;

      } else {

        $this->roster_error = "Could not set new IRC Nicks";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ SetJabber()

  /**
   * Set Jabber
   *
   * @access public
   * @param string 
   * @return boolean Whether Set Succed or Failed
   */
  function SetJabber($s) {
    
    if ($this->Allowed('god')) {
      
      // do it

      $sql = "UPDATE roster_roster "
            ."SET jabber = '".addslashes($s)."' "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->person_jabber = $s;

        return true;

      } else {

        $this->roster_error = "Could not set new Jabber";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ SetMSN()

  /**
   * Set MSN
   *
   * @access public
   * @param string 
   * @return boolean Whether Set Succed or Failed
   */
  function SetMSN($s) {
    
    if ($this->Allowed('god')) {
      
      // do it

      $sql = "UPDATE roster_roster "
            ."SET msn = '".addslashes($s)."' "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->person_msn = $s;

        return true;

      } else {

        $this->roster_error = "Could not set new MSN";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ SetYahoo()

  /**
   * Set Yahoo
   *
   * @access public
   * @param string 
   * @return boolean Whether Set Succed or Failed
   */
  function SetYahoo($s) {
    
    if ($this->Allowed('god')) {
      
      // do it

      $sql = "UPDATE roster_roster "
            ."SET yahoo = '".addslashes($s)."' "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->person_yahoo = $s;

        return true;

      } else {

        $this->roster_error = "Could not set new Yahoo";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}

  // {{{ AddCredits()

  /**
   * Add Credits to a Person's Account
   *
   * These Credits are added to both the account balance and to the rank credits
   *
   * @access public
   * @param int credits The number of credits to add
   * @param mixed awarder the id number or a string representing whoever is 
   *                      awarding these credits
   * @return boolean Whether Set Succed or Failed
   */
  function AddCredits($credits,
                      $awarder = '') {
    
    if ($this->Allowed('credits')) {

      if ($this->person_division == 16) {

        $this->roster_error = 'Can not modify Rank Credits of someone '
          .'in the Disavowed Group';

        return false;

      }
      
      // do it

      $sql = "UPDATE roster_roster "
            ."SET accountbalance = (accountbalance + ".$credits."), "
                ."rankcredits = (rankcredits + ".$credits.") "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $sql = "SELECT accountbalance, "
                     ."rankcredits "
              ."FROM roster_roster "
              ."WHERE id = ".$this->person_id;

        $result = mysql_query($sql, $this->roster_db);

        $this->person_accountbalance = mysql_result($result, 0, 'accountbalance');
        $this->person_rankcredits = mysql_result($result, 0, 'rankcredits');

        $GLOBALS['internalexecute'] = 'history';

        $this->RecordEvent(6, $awarder, $credits, $this->person_rankcredits);

        $this->UpdateRank();

        return true;

      } else {

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ RemoveCredits()

  /**
   * Remove Credits From A Person's Account
   *
   * This in reality just calls $this->AddCredits(), but is included for 
   * completeness.
   *
   * @access public
   * @param int credits Credits to remove
   * @return boolean Whether Set Succed or Failed
   */
  function RemoveCredits($credits) {
    
    if ($this->Allowed('credits')) {
      
      // do it
      return $this->AddCredits("-$credits");
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ MakePurchase()

  /**
   * Make A Purchase
   *
   * decrements the number of credits in the person's account
   *
   * @access public
   * @param int amount The amount in credits of the purchase
   * @param mixed from Either the id number of a person or a string representing
   *                   what it was purchased from
   * @param string item A description of what was purchased
   * @return boolean Whether Set Succed or Failed
   */
  function MakePurchase($amount, 
                        $from = '', 
                        $item = '') {
    
    if ($this->Allowed('purchase')) {

      if ($this->person_division == 16) {

        $this->roster_error = 'Can not modify the Account Balance of someone '
          .'in the Disavowed Group';

        return false;

      }
      
      $sql = "SELECT accountbalance "
            ."FROM roster_roster "
            ."WHERE id = ".$this->person_id;

      $this->person_accountbalance =
        mysql_result(mysql_query($sql, $this->roster_db), 0, 'accountbalance');
      
      if ($amount > $this->person_accountbalance) {
      
        $this->roster_error = "Not enough credits to make purchase.";
      
        return false;
      
      } else {

        $GLOBALS['internalexecute'] = 'history';

        $this->RecordEvent(7, $from, $item, $amount);
      
        $newbalance = $this->person_accountbalance - $amount;
      
        $sql = "UPDATE roster_roster "
              ."SET accountbalance = (accountbalance - ".$amount.") "
              ."WHERE id = ".$this->person_id;
      
        if (mysql_query($sql, $this->roster_db)) {
          
          $sql = "SELECT accountbalance "
                ."FROM roster_roster "
                ."WHERE id = ".$this->person_id;

          $this->person_accountbalance =
            mysql_result(mysql_query($sql, $this->roster_db), 0, 'accountbalance');
      
          return true;
        
        } else {
        
          $this->roster_error = "Error updating account balance.";
          
          return false;
        
        }
      
      }
    
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ MakeSale()

  /**
   * Make A Sale
   *
   * Increases the number of credits available in a person's account. ie They
   * are selling something to another entity for a cost.
   *
   * @access public
   * @param int amount The amount the person recieves for the sale
   * @param mixed to Either the id number of a person or a string representing
   *                 what it was sold to
   * @param string item A description of what was purchased
   * @return boolean Whether Set Succed or Failed
   */
  function MakeSale($amount,
                    $to = '',
                    $item = '') {
    
    if ($this->Allowed('purchase')) {
      
      return $this->MakePurchase("-$amount", $to, $item);
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  
  // {{{ SetQuote()

  /**
   * Set A Person's Quote
   *
   * @access public
   * @param string quote The New Quote
   * @return boolean Whether Set Succed or Failed
   */
  function SetQuote($quote) {
    
    if ($this->Allowed('god')) {
      
      // do it

      $sql = "UPDATE roster_roster "
            ."SET quote = '".addslashes($quote)."' "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->person_quote = $quote;

        return true;

      } else {

        $this->roster_error = "Could not set new Quote";

        return false;

      }
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }


  // }}}
  // {{{ SetHasShip()

  /**
   * Set the flag so a person has a ship
   *
   * Set the flag saying that they have bought a ship. We could query the SSL
   * but having this flag makes this much faster and easier
   *
   * @access public
   * @return boolean Whether the Update Succeded
   */
  function SetHasShip() {

    if ($this->Allowed('ssl')) {

      $sql = "UPDATE roster_roster "
            ."SET hasship = 1 "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->person_hasship = 1;

        $this->UpdateRank();

        return true;

      } else {

        return false;

      }

    } else {

      $this->roster_error = "The programmer does not have permissions to call "
        ."this function.";

      return false;

    }

  }


  // }}}
  // {{{ SetCompletedNTC()

  /**
   * Set the flag saying the person has completed the basic NTC course
   *
   * @access public
   * @return boolean Whether the Update Succeded
   */
  function SetCompletedNTC() {

    if ($this->Allowed('citadel')) {

      $sql = "UPDATE roster_roster "
            ."SET completed_ntc_exam = 1 "
            ."WHERE id = ".$this->person_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->person_completed_ntc_exam = 1;

        $this->UpdateRank();

        return true;

      } else {

        return false;

      }

    } else {

      $this->roster_error = "The programmer does not have permission to call "
        ."this function.";

      return false;

    }

  }


  // }}}

  // Utility Functions
  // {{{ UpdateRank()

  /**
   * Internal function to Update Rank
   *
   * This internal function is called everytime there is a major change done
   * to the info of this person. It updates their rank depending upon the
   * number of credits the person has earned and the position they are in.
   * This function should never be called directly by a programmer.
   *
   * @access protected
   * @return boolean whether it all worked
   */
  function UpdateRank() {

    $position = $this->GetPosition();

    $rank = $this->GetRank();

//    print "Current Position: ".$position->GetName()."<br>"
//      ."Current Rank: ".$rank->GetName()."<br>"
//      ."Completed NTC: ".$this->person_completed_ntc_exam.'<br>'
//      .'Has Ship: '.$this->person_hasship.'<br>';

    if ($position->IsTrainee()) {

//      print "Person is trainee<br>";

      if ($this->person_hasship == 1
          && $this->person_completed_ntc_exam == 1) {

//        print "Person has a ship and has completed the NTC<br>";

        $GLOBALS['internalexecute'] = 'position';

        $GLOBALS['caller'] = 'update';
        
        $test = $this->SetPosition(14);

        unset($GLOBALS['internalexecute']);

        unset($GLOBALS['caller']);

        unset($position);

        $position = $this->GetPosition();

//        print "New Position: ".$position->GetName()."<br>";

      }

    }

    if ($position->GetID() == 14) {

      $sql = "SELECT * "
            ."FROM mb_awarded_medals "
            ."WHERE recipientid = ".$this->person_id." "
              ."AND medal = 68";

      $fh = mysql_query($sql, $this->roster_db);

      if (mysql_num_rows($fh) > 0) {

        $this->SetPosition(28);

      } else {

        $sql = "SELECT * "
              ."FROM mb_awarded_medals "
              ."WHERE recipientid = ".$this->person_id." "
                ."AND medal = 4";

        $gh = mysql_query($sql, $this->roster_db);

        if (mysql_num_rows($gh) > 0) {

          $this->SetPosition(13);

        }

      }

    }

    if (!$rank->IsManuallySet()) {

//      print "This Current Rank is not manually set<Br>";

      if ($position->IsTrainee()) {

//        print "Current Position is Trainee<Br>";

        $sql = "SELECT id "
              ."FROM roster_rank "
              ."WHERE always_available = 1 "
                ."AND manual_set = 0 "
                ."AND credits_needed <= ".$this->person_rankcredits." "
              ."ORDER BY `order` ASC "
              ."LIMIT 1";

      } else {

//        print "Current Position is not Trainee<br>";

        $sql = "SELECT id "
              ."FROM roster_rank "
              ."WHERE manual_set = 0 "
                ."AND credits_needed <= ".$this->person_rankcredits." "
              ."ORDER BY `order` ASC "
              ."LIMIT 1";

      }

      $newrank = mysql_query($sql, $this->roster_db);

      $newrank = mysql_result($newrank, 0, 'id');

      $GLOBALS['internalexecute'] = 'rank';

      $GLOBALS['caller'] = 'update';
      
      $test = $this->SetRank($newrank);

      $rank = $this->getRank();

//      print 'New Rank: '.$rank->getName().'<br>';

      unset($GLOBALS['internalexecute']);

      unset($GLOBALS['caller']);

    }

  }


  // }}}
  // {{{ SendEmail()

  /**
   * Send an Email to this user
   *
   * Send an email notifying the user of something.
   *
   * @access public
   * @param string from The From Address of the email. Either an Email Address
   *                    or a formatted Email From 
   *                    (ie The Roster <roster@thebhg.org> )
   * @param string subject The Subject of the Email
   * @param string message The Main Message Body
   * @return boolean whether the email was sent
   */
  function SendEmail($from, $subject, $message) {

//    if ($this->Allowed('email')) {

      $to = $this->GetName()." <".$this->GetEmail().">";

      $headers = "From: $from\n"
                ."Reply-To: $from\r\n"
                ."X-Mailer: PHP/" . phpversion();

      if (mail($to, $subject, $message, $headers, "-f\"$from\"")) {

        return true;

      } else {

        return false;

      }

//    } else {

//      $this->roster_error = "The programmer did not have permission to call "
//        ."this function.";

//      return false;

//    }

  }

  // }}}
  // {{{ RecordEvent

  /**
   * Record a history event within the system
   *
   * Create an event within the history following these details
   *
   *<pre>
   * type | description |   item 1   |   item 2   |   item 3  
   *----------------------------------------------------------
   *  1   | rank        | old rank   | new rank   |           
   *  2   | position    | old pos    | new pos    |           
   *  3   | division    | old div    | new div    |           
   *  4   | name        | old name   | new name   |           
   *  5   | email       | old email  | new email  |           
   *  6   | credits     | awarder    | amount     | new total 
   *  7   | purchase    | from       | item       | cost      
   *  8   | medalaward  | awardid    |            |           
   *  9   | join        |            |            |           
   * 10   | deleted     |            |            |           
   * 11   | joincadre   | cadreid    |            |           
   * 12   | leftcadre   | cadreid    |            |           
   *</pre>
   *
   * @access public
   * @param integer type The Type of event
   * @param string item1
   * @param string item2
   * @param string item3
   * @return boolean success
   */
  function RecordEvent($type,
                       $item1 = '',
                       $item2 = '',
                       $item3 = '') {

    if ($this->Allowed('history') 
        || $GLOBALS['internalexecute'] == 'history') {

      unset($GLOBALS['internalexecute']);

      $sql = "INSERT INTO roster_history (`date`, "
                                        ."`person`, "
                                        ."`type`, "
                                        ."`item1`, "
                                        ."`item2`, "
                                        ."`item3`) "
            ."VALUES (".time().", "
                       .$this->person_id.", "
                       .$type.", "
                       ."'".addslashes($item1)."', "
                       ."'".addslashes($item2)."', "
                       ."'".addslashes($item3)."') ";

      if (mysql_query($sql, $this->roster_db)) {

        return true;

      } else {

        return false;

      }

    } else {

      $this->roster_error = "The programmer did not have permission to call "
        ."this function.";

      return false;

    }

  }

  // }}}

  // Delete Functions
  // {{{ Delete()

  /**
   * Delete A Person From the System
   *
   * Nothing is ever actually deleted. This transfers a person to the 'Deleted'
   * division and clears out other info.
   *
   * @access public
   * @return boolean Whether Set Succed or Failed
   */
  function Delete() {
    
    if ($this->Allowed('god')) {
     
      $this->SetDivision(16);
      $this->SetPosition(22);
      deleteitems($this->GetID());
      mysql_query('DELETE FROM mb_awarded_medals WHERE recipientid = '.$id,
          $this->roster_db);
      
    } else {
      
      $this->roster_error = "The Coder that created this object does not have "
        ."permission to call this function";

      return false;
      
    }
    
  }

  
  // }}}

}

/**
 * Include Support for clearing out Mall Subdivs
 */
include_once('deleteitems.inc');

/* vim: set ts=2 sw=2 fdm=marker: */

?>

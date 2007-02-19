<?php
/**
 * This file contains objects relating to the Citadel
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.28 $
 * @package Roster
 * @subpackage Citadel
 */

/**
 * Citadel Exam
 *
 * <pre>
 *  20030914  aa  fixed return status on bad parameter to RemoveMarker() and 
 *                AddMarker()
 *                added missing parameter to RemoveMarker()
 *  20030830  aa  return false from GetMedalAward() if there isnt one set
 *  20030826  aa  added GetAverageScore()
 *                fixed GetAbbrev()
 *                added sorting to result sets
 *                fixed return values of result sets
 *  20030825  aa  completed read functions, fleshed out api completly
 *                completed all functions
 *                added support for retrieving deleted questions
 *  20030819  aa  updated stubs from new design
 *  20030408  aa  Documentation Fixes
 *  20030317  aa  documentation fixes
 *  20030216  aa  created stub
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Citadel
 * @access public
 * @version $Revision: 1.28 $
 */
class Citadel_Exam extends BHGObject {

  // {{{ properties

  /**
   * The ID Number of this exam
   * 
   * @access private
   * @var integer exam_id
   * @see GetID()
   */
  var $exam_id;

  /**
   * The Name of the Exam
   *
   * @access private
   * @var string exam_name
   * @see GetName(), SetName()
   */
  var $exam_name;

  /**
   * The Abbreviation of the exam
   *
   * @access private
   * @var string exam_abbr
   * @see GetAbbrev(), SetAbbrev()
   */
  var $exam_abbr;

  /**
   * The Description of the exam
   *
   * @access private
   * @var string exam_description
   * @see GetDescription(), SetDescription()
   */
  var $exam_description;

  /**
   * The Number of Questions displayed when someone takes this exam
   *
   * @access private
   * @var integer exam_num_questions
   * @see GetNumberofQuestions(), SetNumberofQuestions()
   */
  var $exam_num_questions;

  /**
   * The Score out of 100 need to pass this exam
   *
   * @access private
   * @var float exam_passing_grade
   * @see GetPassGrade(), SetPassGrade()
   */
  var $exam_passing_grade;

  /**
   * The amount of credits awarded for passing this exam
   *
   * @access private
   * @var integer exam_credit_award
   * @see GetCreditAward(), SetCreditAward()
   */
  var $exam_credit_award;

  /**
   * The medal awarded for scoring 100% on this exam
   *
   * @access private
   * @var integer exam_medal_award
   * @see GetMedalAward(), SetMedalAward()
   */
  var $exam_medal_award;

  /**
   * The book in the library that contains the notes for this exam
   *
   * @access private
   * @var integer exam_notebook
   * @see GetNotebook(), SetNotebook()
   */
  var $exam_notebook;

  /**
   * The date this exam was deleted if at all
   *
   * @access private
   * @var integer exam_date_deleted
   * @see IsDeleted(), GetDateDeleted(), Delete()
   */
  var $exam_date_deleted;

  // }}}
  // {{{ Citadel_Exam()

  /**
   * Object Constructor
   *
   * @access public
   * @param string Identification Number of the Exam
   * @param string Coder Identification String
   */
  function Citadel_Exam($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $sql = 'SELECT id, '
                 .'name, '
                 .'abbr, '
                 .'description, '
                 .'num_questions, '
                 .'passing_grade, '
                 .'credit_award, '
                 .'medal_award, '
                 .'notebook, '
                 .'UNIX_TIMESTAMP(date_deleted) AS date_deleted '
          .'FROM ntc_exams '
          .'WHERE id = '.$id;

    $result = mysql_query($sql, $this->roster_db);

    if ($exam = @mysql_fetch_assoc($result)) {

      foreach ($exam as $key => $field) {

        $key = 'exam_'.$key;

        $this->$key = stripslashes($field);

      }

    } else {

      $this->roster_error = 'Could not load Exam details.';

    }

  }

  // }}}
  // {{{ GetID()

  /**
   * Retrieve the ID Number of this Exam
   *
   * @access public
   * @return integer
   */
  function GetID() {

    return $this->exam_id;

  }

  // }}}
  // {{{ GetName()

  /**
   * Return the Name of this Exam
   *
   * @access public
   * @return string
   */
  function GetName() {

    return $this->exam_name;

  }

  // }}}
  // {{{ GetAbbrev()

  /**
   * Return the Abbreviation for this exam
   *
   * @access public
   * @return string
   */
  function GetAbbrev() {

    return $this->exam_abbr;

  }

  // }}}
  // {{{ GetDescription()

  /**
   * Return the description of this exam
   *
   * @access public
   * @return string
   */
  function GetDescription() {

    return $this->exam_description;

  }

  // }}}
  // {{{ GetNumberofQuestions()

  /**
   * Return the number of questions we display by default for an exam
   *
   * @access public
   * @return integer
   */
  function GetNumberofQuestions() {

    return $this->exam_num_questions;

  }

  // }}}
  // {{{ GetPassGrade()

  /**
   * Return the grade required to pass this exam
   *
   * @access public
   * @return float
   */
  function GetPassGrade() {

    return $this->exam_passing_grade;

  }

  // }}}
  // {{{ GetCreditAward()

  /**
   * Return the amount of credits awarded for passing this exam
   *
   * @access public
   * @return integer
   */
  function GetCreditAward() {

    return $this->exam_credit_award;

  }

  // }}}
  // {{{ GetMedalAward()

  /**
   * Return the medal awarded for passing this exam
   *
   * @access public
   * @return object Medal
   * @uses Medal
   */
  function GetMedalAward() {

    if ($this->exam_medal_award == 0) {

      return false;

    } else {
      
      return new Medal($this->exam_medal_award, $this->roster_coder);

    }

  }

  // }}}
  // {{{ GetNotebookID()

  /**
   * Get the ID Number of the book containing the notes for this course
   *
   * @access public
   * @return integer
   */
  function GetNotebookID() {

    return $this->exam_notebook;

  }

  // }}}
  // {{{ IsDeleted()

  /**
   * Has this exam been deleted
   *
   * @access public
   * @return boolean
   */
  function IsDeleted() {

    return (   !is_null($this->exam_date_deleted)
            && $this->exam_date_deleted > 0);

  }

  // }}}
  // {{{ GetDateDeleted()

  /**
   * Get the Date this exam was deleted
   *
   * @access public
   * @return integer
   */
  function GetDateDeleted() {

    if ($this->IsDeleted()) {

      return $this->exam_date_deleted;

    } else {

      return false;

    }

  }

  // }}}
  // {{{ GetMarkers()

  /**
   * Get all the people that mark this exam
   *
   * @access public
   * @param boolean whether to return only their id numbers instead of Person
   *                Objects
   * @return array Array of Person Objects or of ID Numbers
   * @uses Person
   */
  function &GetMarkers($idsonly = false) {

    $sql = 'SELECT marker '
          .'FROM ntc_exam_markers '
          .'WHERE exam = '.$this->exam_id;

    $result = mysql_query($sql, $this->roster_db);

		$ids = array();
    $objects = array();

    while ($marker = @mysql_fetch_assoc($result)) {

			if (!in_array($marker['marker'], $ids)) {
	      $ids[] = $marker['marker'];
		    $objects[] = new Person($marker['marker'], $this->roster_coder);
			}

    }

		$warden = $GLOBALS['roster']->SearchPosition(10);

		if (count($warden) > 0) {

			if (!in_array($warden[0]->GetID(), $ids)) {
				$ids[] = $warden[0]->GetID();
				$objects[] = $warden[0];
			}

		}

		if ($idsonly)
			return $ids;
		else
			return $objects;

  }

  // }}}
  // {{{ GetQuestions()

  /**
   * Return all the questions within this exam
   *
   * @access public
   * @param boolean Whether to include deleted questions
   * @return array Question Objects
   * @uses Citadel_Question
   */
  function &GetQuestions($deleted = false) {

    if ($this->Allowed('citadel')) {

      $sql = 'SELECT id '
            .'FROM ntc_exam_questions '
            .'WHERE exam = '.$this->exam_id.' '
            .($deleted
                ? ''
                : 'AND date_deleted IS NULL ');

      $result = mysql_query($sql, $this->roster_db);

      $return = array();

      while ($question = @mysql_fetch_assoc($result)) {

        $return[] = new Citadel_Question($question['id'], $this->roster_coder);

      }

      return $return;

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ GetResults()

  /**
   * Return all the results for this exam
   *
   * @access public
   * @return array
   * @uses Citadel_CompletedExam
   */
  function &GetResults() {

    $sql = 'SELECT ntc_exam_completed.id '
          .'FROM ntc_exam_completed, '
               .'roster_roster '
          .'WHERE ntc_exam_completed.exam = '.$this->exam_id.' '
            .'AND ntc_exam_completed.date_taken IS NOT NULL '
            .'AND ntc_exam_completed.bhg_id = roster_roster.id '
            .'AND roster_roster.division != 16 '
          .'ORDER BY ntc_exam_completed.score DESC, '
                   .'ntc_exam_completed.date_taken ASC, '
                   .'roster_roster.name ASC';

    $result = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($ce = @mysql_fetch_assoc($result)) {

      $return[] = new Citadel_CompletedExam($ce['id'], $this->roster_coder);

    }

    return $return;

  }

  // }}}
  // {{{ GetPassed()

  /**
   * Return all passing results for this exam
   *
   * @access public
   * @return array
   * @uses Citadel_CompletedExam
   */
  function &GetPassed() {

    $sql = 'SELECT ntc_exam_completed.id '
          .'FROM ntc_exam_completed, '
               .'roster_roster '
          .'WHERE ntc_exam_completed.exam = '.$this->exam_id.' '
            .'AND ntc_exam_completed.has_passed = 1 '
            .'AND ntc_exam_completed.is_graded = 1 '
            .'AND ntc_exam_completed.date_taken IS NOT NULL '
            .'AND ntc_exam_completed.bhg_id = roster_roster.id '
            .'AND roster_roster.division != 16 '
          .'ORDER BY ntc_exam_completed.score DESC, '
                   .'ntc_exam_completed.date_taken ASC, '
                   .'roster_roster.name ASC';

    $result = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($ce = @mysql_fetch_assoc($result)) {

      $return[] = new Citadel_CompletedExam($ce['id'], $this->roster_coder);

    }

    return $return;

  }

  // }}}
  // {{{ GetFailed()

  /**
   * Return all failed results for this exam
   *
   * @access public
   * @return array
   * @uses Citadel_CompletedExam
   */
  function &GetFailed() {

    $sql = 'SELECT ntc_exam_completed.id '
          .'FROM ntc_exam_completed, '
               .'roster_roster '
          .'WHERE ntc_exam_completed.exam = '.$this->exam_id.' '
            .'AND ntc_exam_completed.has_passed = 0 '
            .'AND ntc_exam_completed.is_graded = 1 '
            .'AND ntc_exam_completed.date_taken IS NOT NULL '
            .'AND ntc_exam_completed.bhg_id = roster_roster.id '
            .'AND roster_roster.division != 16 '
          .'ORDER BY ntc_exam_completed.score DESC, '
                   .'ntc_exam_completed.date_taken ASC, '
                   .'roster_roster.name ASC';

    $result = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($ce = @mysql_fetch_assoc($result)) {

      $return[] = new Citadel_CompletedExam($ce['id'], $this->roster_coder);

    }

    return $return;

  }

  // }}}
  // {{{ GetPending()

  /**
   * Return all pending marking results for this exam
   *
   * @access public
   * @return array
   * @uses Citadel_CompletedExam
   */
  function &GetPending() {

    $sql = 'SELECT ntc_exam_completed.id '
          .'FROM ntc_exam_completed, '
               .'roster_roster '
          .'WHERE ntc_exam_completed.exam = '.$this->exam_id.' '
            .'AND ntc_exam_completed.has_passed = 0 '
            .'AND ntc_exam_completed.is_graded = 0 '
            .'AND ntc_exam_completed.date_taken IS NOT NULL '
            .'AND ntc_exam_completed.bhg_id = roster_roster.id '
            .'AND roster_roster.division != 16 '
          .'ORDER BY ntc_exam_completed.date_taken ASC, '
                   .'roster_roster.name ASC';

    $result = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($ce = @mysql_fetch_assoc($result)) {

      $return[] = new Citadel_CompletedExam($ce['id'], $this->roster_coder);

    }

    return $return;

  }

  // }}}
  // {{{ GetAverageScore()

  /**
   * Return the Average score for this exam
   *
   * @access public
   * @return float
   */
  function GetAverageScore() {

    $sql = 'SELECT AVG(ntc_exam_completed.score) AS avgscore '
          .'FROM ntc_exam_completed, '
               .'roster_roster '
          .'WHERE ntc_exam_completed.exam = '.$this->exam_id.' '
            .'AND ntc_exam_completed.is_graded = 1 '
            .'AND ntc_exam_completed.date_taken IS NOT NULL '
            .'AND ntc_exam_completed.bhg_id = roster_roster.id '
            .'AND roster_roster.division != 16';

    $result = mysql_query($sql, $this->roster_db);

    return mysql_result($result, 0, 'avgscore');

  }

  // }}}
  // {{{ CountTaken()

  /**
   * Return the number of times this exam has been taken
   *
   * @access public
   * @return integer
   */
  function CountTaken() {

    $sql = 'SELECT COUNT(*) AS count '
          .'FROM ntc_exam_completed, '
               .'roster_roster '
          .'WHERE ntc_exam_completed.exam = '.$this->exam_id.' '
            .'AND ntc_exam_completed.date_taken IS NOT NULL '
            .'AND ntc_exam_completed.bhg_id = roster_roster.id '
            .'AND roster_roster.division != 16';

    $result = mysql_query($sql, $this->roster_db);

    return mysql_result($result, 0, 'count');

  }

  // }}}
  // {{{ CountPassed()

  /**
   * Return the number of times this exam has been Passed
   *
   * @access public
   * @return integer
   */
  function CountPassed() {

    $sql = 'SELECT COUNT(*) AS count '
          .'FROM ntc_exam_completed, '
               .'roster_roster '
          .'WHERE ntc_exam_completed.exam = '.$this->exam_id.' '
            .'AND ntc_exam_completed.has_passed = 1 '
            .'AND ntc_exam_completed.is_graded = 1 '
            .'AND ntc_exam_completed.date_taken IS NOT NULL '
            .'AND ntc_exam_completed.bhg_id = roster_roster.id '
            .'AND roster_roster.division != 16';

    $result = mysql_query($sql, $this->roster_db);

    return mysql_result($result, 0, 'count');

  }

  // }}}
  // {{{ CountFailed()

  /**
   * Return the number of times this exam has been Failed
   *
   * @access public
   * @return integer
   */
  function CountFailed() {

    $sql = 'SELECT COUNT(*) AS count '
          .'FROM ntc_exam_completed, '
               .'roster_roster '
          .'WHERE ntc_exam_completed.exam = '.$this->exam_id.' '
            .'AND ntc_exam_completed.has_passed = 0 '
            .'AND ntc_exam_completed.is_graded = 1 '
            .'AND ntc_exam_completed.date_taken IS NOT NULL '
            .'AND ntc_exam_completed.bhg_id = roster_roster.id '
            .'AND roster_roster.division != 16';

    $result = mysql_query($sql, $this->roster_db);

    return mysql_result($result, 0, 'count');

  }

  // }}}
  // {{{ CountPending()

  /**
   * Return the number of exams awaiting marking
   *
   * @access public
   * @return integer
   */
  function CountPending() {

    $sql = 'SELECT COUNT(*) AS count '
          .'FROM ntc_exam_completed, '
               .'roster_roster '
          .'WHERE ntc_exam_completed.exam = '.$this->exam_id.' '
            .'AND ntc_exam_completed.has_passed = 0 '
            .'AND ntc_exam_completed.is_graded = 0 '
            .'AND ntc_exam_completed.date_taken IS NOT NULL '
            .'AND ntc_exam_completed.bhg_id = roster_roster.id '
            .'AND roster_roster.division != 16';

    $result = mysql_query($sql, $this->roster_db);

    return mysql_result($result, 0, 'count');

  }

  // }}}
  // {{{ SetName()

  /**
   * Set the Name of this Exam
   *
   * @access public
   * @param string the new name
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetName($name) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exams '
            .'SET name = \''.addslashes($name).'\' '
            .'WHERE id = '.$this->exam_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->exam_name = $name;

        return true;

      } else {

        $this->roster_error = 'Could not set new name.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ SetAbbrev()

  /**
   * Set the Abbreviation for this exam
   * 
   * @access public
   * @param string the new abbreviation
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetAbbrev($abbrev) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exams '
            .'SET abbr = \''.addslashes($abbrev).'\' '
            .'WHERE id = '.$this->exam_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->exam_abbr = $abbrev;

        return true;

      } else {

        $this->roster_error = 'Could not set new abbreviation.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ SetDescription()

  /**
   * Set the Description for this exam
   *
   * @access public
   * @param string the new description
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetDescription($desc) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exams '
            .'SET description = \''.addslashes($desc).'\' '
            .'WHERE id = '.$this->exam_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->exam_description = $desc;

        return true;

      } else {

        $this->roster_error = 'Could not set new description.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ SetNumberofQuestions()

  /**
   * Set the Number of Questions displayed for this exam
   * 
   * @access public
   * @param integer the number of questions
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetNumberofQuestions($num) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exams '
            .'SET num_questions = '.$num.' '
            .'WHERE id = '.$this->exam_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->exam_num_questions = $num;

        return true;

      } else {

        $this->roster_error = 'Could not set new number of questions.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ SetPassGrade()

  /**
   * Set the Passing Grade of this Exam
   *
   * @access public
   * @param float the new passing grade
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetPassGrade($grade) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exams '
            .'SET passing_grade = '.$grade.' '
            .'WHERE id = '.$this->exam_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->exam_passing_grade = $grade;

        return true;

      } else {

        $this->roster_error = 'Could not set new passing grade.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ SetCreditAward()

  /**
   * Set the credit award for this exam
   *
   * @access public
   * @param integer the new credit award amount
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetCreditAward($credits) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exams '
            .'SET credit_award = '.$credits.' '
            .'WHERE id = '.$this->exam_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->exam_credit_award = $credits;

        return true;

      } else {

        $this->roster_error = 'Could not set new credit award.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ SetMedalAward()

  /**
   * Set the Medal award for achieving 100%
   *
   * @access public
   * @param mixed Medal object or Medal ID integer
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   * @uses Medal
   */
  function SetMedalAward($medal) {

    if ($this->Allowed('citadel')) {
      
      if (is_object($medal)) {

        if ($medal instanceof Medal) {

          $medalid = $medal->GetID();

        } else {

          $this->roster_error = 'Invalid Object passed to SetMedalAward().';

          return false;

        }

      } elseif (is_numeric($medal)) {

        $medalid = $medal;

      } else {

        $this->roster_error = 'Invalid parameter passed to SetMedalAward().';

        return false;

      }

      $sql = 'UPDATE ntc_exams '
            .'SET medal_award = '.$medalid.' '
            .'WHERE id = '.$this->exam_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->exam_medal_award = $medalid;

        return true;

      } else {

        $tihs->roster_error = 'Could not set new medal award.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ SetNotebook()

  /**
   * Set which book in the library the notes point to
   *
   * @access public
   * @param integer the id number of the book in the library
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   * @uses Book
   */
  function SetNotebook($book) {

    if ($this->Allowed('citadel')) {

      if (is_object($book)) {

        if ($book instanceof Book) {

          $bookid = $book->GetID();

        } else {

          $this->roster_error = 'Invalid object passed to SetNotebook().';

          return false;

        }

      } elseif (is_numeric($book)) {

        $bookid = $book;

      } else {

        $this->roster_error = 'Invalid parameter passed to SetNotebook().';

        return false;

      }

      $sql = 'UPDATE ntc_exams '
            .'SET notebook = '.$book.' '
            .'WHERE id = '.$this->exam_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->exam_notebook = $book;

        return true;

      } else {

        $this->roster_error = 'Could not set new notebook.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ AddMarker()

  /**
   * Add someone to the list of markers for this exam
   *
   * @access public
   * @param mixed Person's ID Number of Person Object
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   * @uses Person
   */
  function AddMarker($person) {

    if ($this->Allowed('citadel')) {

      if (is_object($person)) {

        if ($person instanceof Person) {

          $personid = $person->GetID();

        } else {

          $this->roster_error = 'Invalid Object passed to AddMarker().';

          return false;

        }

      } elseif (is_numeric($person)) {

        $personid = $person;

      } else {

        $this->roster_error = 'Invalid parameter passed to AddMarker().';

        return false;

      }

      $sql = 'INSERT ntc_exam_markers (exam, '
                                     .'marker) '
            .'VALUES ('.$this->exam_id.', '
                       .$personid.') ';

      if (@mysql_query($sql, $this->roster_db)) {

        return true;

      } else {

        $this->roster_error = 'Could not add person to marker list.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ RemoveMarker()

  /**
   * Remove a marker from the list of markers for this exam
   *
   * @access public
   * @param mixed Person ID Number of Person Object
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   * @uses Person
   */
  function RemoveMarker($person) {

    if ($this->Allowed('citadel')) {

      if (is_object($person)) {

        if ($person instanceof Person) {

          $personid = $person->GetID();

        } else {

          $this->roster_error = 'Invalid Object passed to RemoveMarker().';

          return false;

        }

      } elseif (is_numeric($person)) {

        $personid = $person;

      } else {

        $this->roster_error = 'Invalid parameter passed to RemoveMarker().';

        return false;

      }

      $sql = 'DELETE FROM ntc_exam_markers '
            .'WHERE exam = '.$this->exam_id.' '
              .'AND marker = '.$personid;

      if (@mysql_query($sql, $this->roster_db)) {

        return true;

      } else {

        $this->roster_error = 'Could not remove person from the marker list.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ AddQuestion()

  /**
   * Add a question to this exam
   *
   * @access public
   * @param string The actual text of the question
   * @param string The offical answer/marking guide for this question
   * @param integer The number of points this question is worth
   * @param boolean Whether this question is mandatory
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function AddQuestion($question,
                       $answer,
                       $points = 1,
                       $mandatory = false) {

    if ($this->Allowed('citadel')) {

      $sql = 'INSERT INTO ntc_exam_questions (exam, '
                                            .'question, '
                                            .'answer, '
                                            .'points, '
                                            .'mandatory) '
            .'VALUES ('.$this->exam_id.', '
                    ."'".addslashes($question)."', "
                    ."'".addslashes($answer)."', "
                    .$points.', '
                    .($mandatory
                        ? '1'
                        : '0').') ';

      if (mysql_query($sql, $this->roster_db)) {

        return true;

      } else {

        $this->roster_error = 'Could not create new question.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ TakeExam()

  /**
   * Start the process of someone taking an exam
   *
   * This function creates and returns the CompletedExam object and chooses 
   * the questions to be displayed in the exam. They are entered into the 
   * database with blank answers. Once they person has completed the exam it 
   * is then available to be marked.
   *
   * If called multiple times before the user completes the exam it will always
   * return the same completed exam instance. So someone could close the browser
   * window, take the exam and again and will get the same set of questions.
   *
   * This function also creates all the Answer objects in the database. When
   * completing this exam the coder should store all answers into the relevant
   * answer objects then call Citadel_CompletedExam::Complete().
   *
   * @access public
   * @param integer the id number of the person
   * @return object Citadel_CompletedExam The instance of them taking the exam.
   * @uses BHGObject::Allowed() Coder Access Control
   * @uses Person
   * @uses Person::IsDeleted() To make sure Person is valid
   * @uses Person::GetID()
   * @uses Citadel_CompletedExam
   */
  function TakeExam($person) {

    if ($this->Allowed('citadel')) {

      if (is_object($person)) {

        if ($person instanceof Person) {

        } else {

          $this->roster_error = 'Invalid Object passed to TakeExam().';

          return false;

        }

      } elseif (is_numeric($person)) {

        $person = new Person($person, $this->roster_coder);

      } else {

        $this->roster_error = 'Invalid parameter passed to TakeExam().';

        return false;

      }

      if ($person->IsDeleted()) {

        $this->roster_error = 'Requested exam taker is invalid.';

        return false;

      }

      $sql = 'SELECT id '
            .'FROM ntc_exam_completed '
            .'WHERE exam = '.$this->exam_id.' '
              .'AND bhg_id = '.$person->GetID().' '
              .'AND date_taken IS NULL';

      $result = mysql_query($sql, $this->roster_db);

      if (mysql_num_rows($result) > 0) {

        // Already existing attempt at this exam that hasnt been completed
        
        return new Citadel_CompletedExam(mysql_result($result, 0, 'id'),
                                         $this->roster_coder);

      } else {

        // No existing attempt so create a new one

        $sql = 'INSERT INTO ntc_exam_completed (exam, '
                                              .'bhg_id) '
              .'VALUES ('.$this->exam_id.', '
                         .$person->GetID().') ';

        if (mysql_query($sql, $this->roster_db)) {

          $id = mysql_insert_id();

          // Now select our questions
          $sql = 'SELECT id, '
                       .'points '
                .'FROM ntc_exam_questions '
                .'WHERE exam = '.$this->exam_id.' '
                  .'AND date_deleted IS NULL '
                .'ORDER BY mandatory DESC, '
                         .'RAND() ASC '
                .'LIMIT 0,'.$this->exam_num_questions;

          $result = mysql_query($sql, $this->roster_db);

          if ($question = mysql_fetch_assoc($result)) {

            do {

              $sql = 'INSERT INTO ntc_exam_answers (result, '
                                                  .'question, '
                                                  .'possible) '
                    .'VALUES ('.$id.', '
                               .$question['id'].', '
                               .$question['points'].') ';

              if (!mysql_query($sql, $this->roster_db)) {

                // Couldnt create all the questions remove it all then return
                // error

                mysql_query('DELETE FROM ntc_exam_answers WHERE result = '.$id,
                    $this->roster_db);
                mysql_query('DELETE FROM ntc_exam_completed WHERE id = '.$id,
                    $this->roster_db);

                $this->roster_error = 'Could not save list of questions.';

                return false;

              }

            } while ($question = mysql_fetch_assoc($result));

            // Completed Creating return the new object so people can do there
            // stuff

            return new Citadel_CompletedExam($id, $this->roster_coder);

          } else {

            // Couldnt load questions so remove result record
            mysql_query('DELETE FROM ntc_exam_completed WHERE id = '.$id,
                $this->roster_db);
            
            $this->roster_error = 'Could not load selection of questions.';

            return false;

          }

        } else {

          $this->roster_error = 'Could not create new exam instance.';

          return false;

        }

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ Delete()

  /**
   * Delete this Exam
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function Delete() {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exams '
            .'SET date_deleted = NOW() '
            .'WHERE id = '.$this->exam_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->Citadel_Exam($this->exam_id, $this->roster_coder);

        return true;

      } else {

        $this->roster_error = 'Could not delete exam.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

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
 * Citadel - The entry point of the citadel
 *
 * <pre>
 *  20030914  aa  added GetQuestion()
 *  20030831  ah  fixed bug in GetPersonsResults() that was showing an error
 *                message if the hunter hadn't done any exams
 *  20030828  aa  added GetAllMarkers()
 *                fixed GetExamsMarkedBy()
 *  20030827  aa  fixed GetPersonsResults()
 *                added GetAnswer()
 *  20030826  aa  added GetExambyAbbrev()
 *                added GetResult()
 *  20030822  aa  completed first revision
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
class Citadel extends BHGObject {

  // {{{ properties

  // }}}
  // {{{ Citadel()

  /**
   * Object Constructor
   *
   * @access public
   * @param string Coder Identification String
   */
  function Citadel($coder = '') {
    BHGObject::BHGObject($coder);

  }

  // }}}
  // {{{ GetExams()

  /**
   * Return an array of all the defined Exams
   *
   * @access public
   * @param boolean Whether to include deleted exams in this query
   * @return array Exam Objects
   * @uses Citadel_Exam
   */
  function &GetExams($deleted = false) {

    $sql = 'SELECT id '
          .'FROM ntc_exams '
          .($deleted 
              ? ''
              : 'WHERE date_deleted IS NULL ')
          .'ORDER BY id';

    $result = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($exam = mysql_fetch_assoc($result)) {

      $return[] = new Citadel_Exam($exam['id'], $this->roster_coder);

    }

    return $return;

  }

  // }}}
  // {{{ GetExam()

  /**
   * Return a specific Exam
   *
   * @access public
   * @param integer the ID number of the exam to retrieve
   * @return object Exam
   * @uses Citadel_Exam
   */
  function GetExam($id) {

    return new Citadel_Exam($id, $this->roster_coder);

  }

  // }}}
  // {{{ GetExambyAbbr()

  /**
   * Return a specific Exam by its abbreviation
   *
   * @access public
   * @param string the abbreviation of the exam to retrieve
   * @return mixed Exam Object if found or False if no match found
   * @uses Citadel_Exam
   */
  function GetExambyAbbrev($abbrev) {

    $sql = 'SELECT id '
          .'FROM ntc_exams '
          .'WHERE UPPER(abbr) = UPPER(\''.addslashes($abbrev).'\') ';

    if ($result = mysql_query($sql, $this->roster_db)) {

      $id = mysql_result($result, 0, 'id');
        
      return new Citadel_Exam($id, $this->roster_coder);

    } else {

      return false;

    }

  }

  // }}}
  // {{{ GetExamsMarkedBy()

  /**
   * Get all the Exams marked by a specific person
   *
   * @access public
   * @param mixed the id number of the person or a person object
   * @param mixed include exams that have been deleted
   * @return array of Exam Objects
   * @uses Citadel_Exam
   * @uses Person
   */
  function &GetExamsMarkedBy($person, $deleted = false) {

    if (is_object($person)) {

      if (   get_class($person) == 'person'
          || is_subclass_of($person, 'person')) {

        $personid = $person->GetID();

      } else {

        $this->roster_error = 'Invalid Object Passed to GetExamsMarkedBy.';

        return false;

      }

    } elseif (is_numeric($person)) {

      $personid = $person;

    } else {

      $this->roster_error = 'Invalid parameter passed to GetExamsMarkedBy.';

      return false;

    }

    $sql = 'SELECT ntc_exams.id '
          .'FROM ntc_exam_markers, '
               .'ntc_exams '
          .'WHERE ntc_exam_markers.marker = '.$personid.' '
            .'AND ntc_exams.id = ntc_exam_markers.exam '
          .($deleted
              ? ''
              : 'AND ntc_exams.date_deleted IS NULL ')
          .'ORDER BY ntc_exams.id';

    $result = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($exam = mysql_fetch_assoc($result)) {

      $return[] = new Citadel_Exam($exam['id'], $this->roster_coder);

    }

    return $return;

  }

  // }}}
  // {{{ GetAllMarkers()

  /**
   * Get all the people that mark exams within the citadel
   *
   * @access public
   * @param boolean whether to return only their id numbers instead of Person
   *                Objects
   * @return array Array of Person Objects or of ID Numbers
   * @uses Person
   */
  function &GetAllMarkers($idsonly = false) {

    $sql = 'SELECT marker, '
                 .'COUNT(*) AS count '
          .'FROM ntc_exam_markers '
          .'GROUP BY marker';

    $result = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($marker = @mysql_fetch_assoc($result)) {

      if ($idsonly) {

        $return[] = $marker['marker'];

      } else {

        $return[] = new Person($marker['marker'], $this->roster_coder);

      }

    }

    return $return;

  }

  // }}}
  // {{{ GetQuestion()

  /**
   * Return a specific Question
   *
   * @access public
   * @param integer the ID number of the question to retrieve
   * @return object Citadel_Question
   * @uses Citadel_Question
   */
  function GetQuestion($id) {

    return new Citadel_Question($id, $this->roster_coder);

  }

  // }}}
  // {{{ GetResult()

  /**
   * Return a specific Result
   *
   * @access public
   * @param integer the ID number of the result to retrieve
   * @return object Citadel_CompltedExam
   * @uses Citadel_CompletedExam
   */
  function GetResult($id) {

    return new Citadel_CompletedExam($id, $this->roster_coder);

  }

  // }}}
  // {{{ GetAnswer()

  /**
   * Return a specific Submitted Answer
   *
   * @access public
   * @param integer the ID number of the answer to retrieve
   * @return object Citadel_Answer
   * @uses Citadel_Answer
   */
  function GetAnswer($id) {

    return new Citadel_Answer($id, $this->roster_coder);

  }

  // }}}
  // {{{ GetPersonsResults()

  /**
   * Return an array contain a person's results
   *
   * This function returns an array containing a persons results.
   * 
   * The second parameter specifies what type of results to return. The 
   * following 4 constants have been defined to represent these:
   *
   *<pre>
   *  CITADEL_ALL     - Return all results (default)
   *  CITADEL_PASSED  - Return all results where they passed
   *  CITADEL_FAILED  - Return all results where they failed
   *  CITADEL_PENDING - Return all results awaiting marking
   *</pre>
   *
   * @access public
   * @param mixed The Person's ID Number or a Person Object
   * @param integer The Type of results to return
   * @param boolean Whether to include deleted exams
   * @return array Result Objects
   * @uses Person
   * @uses Citadel_CompletedExam
   * @uses CITADEL_ALL Determine Type to Return
   * @uses CITADEL_PASSED Determine Type to Return
   * @uses CITADEL_FAILED Determine Type to Return
   * @uses CITADEL_PENDING Determine Type to Return
   */
  function &GetPersonsResults($person, $type = CITADEL_ALL, $deleted = false) {
    
    if (is_object($person)) {

      if (   get_class($person) == 'person'
          || is_subclass_of($person, 'person')) {

        $personid = $person->GetID();

      } else {

        $this->roster_error = 'Invalid Object Passed to GetExamsMarkedBy.';

        return false;

      }

    } elseif (is_numeric($person)) {

      $personid = $person;

    } else {

      $this->roster_error = 'Invalid parameter passed to GetExamsMarkedBy.';

      return false;

    }

    $sql = 'SELECT ntc_exam_completed.id '
          .'FROM ntc_exam_completed, '
               .'ntc_exams '
          .'WHERE ntc_exam_completed.exam = ntc_exams.id '
            .'AND ntc_exam_completed.bhg_id = '.$personid.' '
            .'AND ntc_exam_completed.date_taken IS NOT NULL '
          .($deleted
              ? ''
              : 'AND ntc_exams.date_deleted IS NULL ');

    switch ($type) {

      case CITADEL_PASSED:
        $sql .= 'AND ntc_exam_completed.has_passed = 1 '
               .'AND ntc_exam_completed.is_graded = 1 ';
        break;

      case CITADEL_FAILED:
        $sql .= 'AND ntc_exam_completed.has_passed = 0 '
               .'AND ntc_exam_completed.is_graded = 1 ';
        break;

      case CITADEL_PENDING:
        $sql .= 'AND ntc_exam_completed.has_passed = 0 '
               .'AND ntc_exam_completed.is_graded = 0 ';
        break;

      case CITADEL_ALL:
      default:
        break;

    }

    $sql .= 'ORDER BY ntc_exams.id ';

    $result = mysql_query($sql, $this->roster_db);

    $return = array();

    if ($result && mysql_num_rows($result)) {

      while ($e = mysql_fetch_assoc($result)) {

        $return[] = new Citadel_CompletedExam($e['id'], $this->roster_coder);

      }

    }

    return $return;

  }
  
  // }}}
  // {{{ CreateExam()

  /**
   * Create a new Exam
   *
   * @access public
   * @param string The Name of the New Exam
   * @param string Abbreviation for exam (what appear on the idline)
   * @param string Description of the exam
   * @param integer The ID number of the person that will be marking
   * @param integer The number of questions displayed in the exam
   * @param integer The score out of 100 required to pass this exam
   * @param integer The credit amount awarded for passing this exam
   * @return object Exam
   * @uses Person
   * @uses Citadel_Exam
   */
  function CreateExam($name,
                      $abbr,
                      $desc,
                      $marker,
                      $num_questions,
                      $passing_grade,
                      $credit_award) {

    if ($this->Allowed('citadel')) {

      $sql = 'INSERT INTO ntc_exams (name, '
                                   .'abbr, '
                                   .'description, '
                                   .'num_questions, '
                                   .'passing_grade, '
                                   .'credit_award) '
            ."VALUES ('".addslashes($name)."', "
                    ."'".addslashes($abbr)."', "
                    ."'".addslashes($desc)."', "
                    .$num_questions.', '
                    .$passing_grade.', '
                    .$credit_award.')';

      if (mysql_query($sql, $this->roster_db)) {

        $id = mysql_insert_id($this->roster_db);

        $sql = 'INSERT INTO ntc_exam_markers (exam, '
                                            .'marker) '
              .'VALUES ('.$id.', '
                         .$marker.') ';

        if (mysql_query($sql, $this->roster_db)) {

          return new Citadel_Exam($id, $this->roster_coder);

        } else {

          mysql_query('DELETE FROM ntc_exams WHERE id = '.$id,
              $this->roster_db);

          $this->roster_error = 'Could not create new Exam.';

          return false;

        }

      } else {

        $this->roster_error = 'Could not create new Exam.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder does not have permission.';

      return false;

    }

  }

  // }}}

}

// Define Constants used here
/** All Citadel Exam Submissions */
define('CITADEL_ALL',     0);
/** Only those Citadel Exam Submissions that Passed */
define('CITADEL_PASSED',  1);
/** Only those Citadel Exam Submissions that Failed */
define('CITADEL_FAILED',  2);
/** Only those Citadel Exam Submissions that have not been Marked Yet */
define('CITADEL_PENDING', 3);

/* vim: set ts=2 sw=2 fdm=marker: */

?>

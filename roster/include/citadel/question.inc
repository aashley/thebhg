<?php
/**
 * This file contains objects relating to the Citadel
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.17 $
 * @package Roster
 * @subpackage Citadel
 */

/**
 * Citadel Exam Question
 *
 * <pre>
 *  20030827  aa  fixed constructor
 *  20030825  aa  completed functions
 *  20030819  aa  updated stubs from new design enhancements
 *  20030408  aa  Documentation Fixes
 *  20030317  aa  documentation fixes
 *  20030216  aa  Created stubs
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Citadel
 * @access public
 * @version $Revision: 1.17 $
 */
class Citadel_Question extends BHGObject {

  // {{{ properties

  /**
   * The ID Number of this question
   *
   * @access private
   * @var integer question_id
   * @see GetID()
   */
  var $question_id;

  /**
   * The ID Number of the Exam this question belongs to
   *
   * @access private
   * @var integer question_exam
   * @see GetExam()
   */
  var $question_exam;

  /**
   * The Text of the Question
   *
   * @access private
   * @var string question_question
   * @see GetQuestionText(), SetQuestionText()
   */
  var $question_question;

  /**
   * The Offical Answer/Marking Guide for this question
   *
   * @access private
   * @var string question_answer
   * @see GetOfficalAnswer(), SetOfficalAnswer()
   */
  var $question_answer;

  /**
   * The Number of points available for this question
   *
   * @access private
   * @var integer question_points
   * @see GetPossibleMarks(), SetPossibleMarks()
   */
  var $question_points;

  /**
   * Whether this question is mandatory
   *
   * @access private
   * @var integer question_mandatory
   * @see IsMandatory(), SetMandatory()
   */
  var $question_mandatory;

  /**
   * Whether this question has been deleted
   *
   * @access private
   * @var integer question_date_deleted
   * @see IsDeleted(), Delete()
   */
  var $question_date_deleted;

  // }}}
  // {{{ Citadel_Question()

  /**
   * Object Constructor
   *
   * @access public
   * @param integer Question ID Number
   * @param string  Coder Identification String
   */
  function Citadel_Question ($id, $coder = '') {
    BHGObject::BHGObject($coder);

    if ($this->Allowed('citadel')) {

      $sql = 'SELECT id, '
                   .'exam, '
                   .'question, '
                   .'answer, '
                   .'points, '
                   .'mandatory, '
                   .'UNIX_TIMESTAMP(date_deleted) AS date_deleted '
            .'FROM ntc_exam_questions '
            .'WHERE id = '.$id;

      $result = mysql_query($sql, $this->roster_db);

      if ($question = @mysql_fetch_assoc($result)) {

        foreach ($question as $key => $value) {

          $key = 'question_'.$key;

          $this->$key = stripslashes($value);

        }

      } else {

        $this->roster_error = 'Could not load question details.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ GetID()

  /**
   * Get the ID Number of this exam
   *
   * @access public
   * @return integer
   */
  function GetID() {

    return $this->question_id;

  }

  // }}}
  // {{{ GetExam()

  /**
   * Retrieve the exam this question belongs to
   *
   * @access public
   * @return object Citadel_Exam
   * @uses Citadel_Exam
   */
  function GetExam() {

    return new Citadel_Exam($this->question_exam, $this->roster_coder);

  }

  // }}}
  // {{{ GetQuestionText()

  /**
   * Return the text of this question
   *
   * @access public
   * @return string
   */
  function GetQuestionText() {

    return $this->question_question;

  }

  // }}}
  // {{{ GetOfficalAnswer()

  /**
   * Return the offical answer/marking guide for this question
   * 
   * @access public
   * @return string
   */
  function GetOfficalAnswer() {

    // Make doubly sure they have permission to access this
    if ($this->Allowed('citadel')) {

      return $this->question_answer;

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ GetPossibleMarks()

  /**
   * Get the possible marks available for this question
   *
   * @access public
   * @return integer
   */
  function GetPossibleMarks() {

    return $this->question_points;

  }

  // }}}
  // {{{ IsMandatory()

  /**
   * Is this question mandatory?
   *
   * @access public
   * @return boolean
   */
  function IsMandatory() {

    return ($this->question_mandatory == 1);

  }

  // }}}
  // {{{ IsDeleted()

  /**
   * Has this question been deleted
   *
   * @access public
   * @return boolean
   */
  function IsDeleted() {

    return (   !is_null($this->question_date_deleted)
            && $this->question_date_deleted > 0);

  }

  // }}}
  // {{{ SetQuestionText()

  /**
   * Set the Text of the Question
   *
   * @access public
   * @param string the new question
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetQuestionText($question) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exam_questions '
            .'SET question = \''.addslashes($question).'\' '
            .'WHERE id = '.$this->question_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->question_question = $question;

        return true;

      } else {

        $this->roster_error = 'Could not set new question.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ SetOfficalAnswer()

  /**
   * Set the offical answer for this question
   *
   * @access public
   * @param string the new answer
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetOfficalAnswer($answer) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exam_questions '
            .'SET answer = \''.addslashes($answer).'\' '
            .'WHERE id = '.$this->question_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->question_answer = $answer;

        return true;

      } else {

        $this->roster_error = 'Could not set new answer.';

        return false;

      }

    } else {

      $this->roster = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ SetPossibleMarks()

  /**
   * Set the possible marks for this question
   *
   * @access public
   * @param integer the new number of marks
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetPossibleMarks($points) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exam_questions '
            .'SET points = '.$points.' '
            .'WHERE id = '.$this->question_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->question_points = $points;

        return true;

      } else {

        $this->roster_error = 'Could not set new possible marks.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ SetMandatory()

  /**
   * Set whether this question is mandatory
   *
   * @access public
   * @param boolean
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetMandatory($mandatory = true) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exam_questions '
            .'SET mandatory = '.($mandatory ? '1' : '0').' '
            .'WHERE id = '.$this->question_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->question_mandatory = ($mandatory ? 1 : 0);

        return true;

      } else {

        $this->roster_error = 'Could not set mandatory state for question.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ Delete()

  /**
   * Delete this Question
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function Delete() {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exam_questions '
            .'SET date_deleted = NOW() '
            .'WHERE id = '.$this->question_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->Citadel_Question($this->question_id, $this->roster_coder);

        return true;

      } else {

        $this->roster_error = 'Could not delete question.';

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

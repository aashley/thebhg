<?php
/**
 * This file contains objects relating to the Citadel
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.13 $
 * @package Roster
 * @subpackage Citadel
 */

/**
 * Citadel - Answer
 *
 * An Answer someone subbmited to an exam
 *
 * <pre>
 *  20030830  aa  fixed SetComments()
 *  20030827  aa  fixed constructor
 *  20030822  aa  first revision
 *  20030819  aa  created stub
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Citadel
 * @access public
 * @version $Revision: 1.13 $
 */
class Citadel_Answer extends BHGObject {

  // {{{ properties

  /**
   * The ID Number of the Answer
   *
   * @access private
   * @var integer answer_id
   * @see GetID()
   */
  var $answer_id;

  /**
   * The Completed Exam this answer belongs to
   *
   * @access private
   * @var integer answer_result
   * @see GetCompletedExam()
   */
  var $answer_result;

  /**
   * The Question this answer is to
   *
   * @access private
   * @var integer answer_question
   * @see GetQuestion()
   */
  var $answer_question;

  /**
   * The Actual answer submitted by the person
   *
   * @access private
   * @var string answer_answer
   * @see GetAnswer(), SetAnswer()
   */
  var $answer_answer;

  /**
   * Number of points awarded for this answer by the marker
   *
   * @access private
   * @var float answer_points
   * @see GetMark(), SetMark()
   */
  var $answer_points;

  /**
   * The possible number of points for this question. 
   *
   * This can be changed on a question in the future so we store it here
   * with the answer.
   *
   * @access private
   * @var integer answer_possible
   * @see GetPossibleMark()
   */
  var $answer_possible;

  /**
   * Comments from the marker to the exam taker
   *
   * @access private
   * @var string answer_comments
   * @see GetComments(), SetComments()
   */
  var $answer_comments;

  // }}}
  // {{{ Citadel_Answer()

  /**
   * Object Constructor
   *
   * @access public
   * @param integer the ID Number of the Answer to load
   * @param string Coder Identification String
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function Citadel_Answer($id, $coder = '') {
    BHGObject::BHGObject($coder);

    if ($this->Allowed('citadel')) {

      $sql = 'SELECT id, '
                   .'result, '
                   .'question, '
                   .'answer, '
                   .'points, '
                   .'possible, '
                   .'comment AS comments '
            .'FROM ntc_exam_answers '
            .'WHERE id = '.$id;

      $result = mysql_query($sql, $this->roster_db);

      if ($answer = @mysql_fetch_assoc($result)) {

        foreach ($answer as $key => $value) {

          $key = 'answer_'.$key;

          $this->$key = stripslashes($value);

        }

      } else {

        $this->roster_error = 'Invalid Answer ID. Could not create object.';

      }

    } else {

      $this->roster_error = 'The coder does not have permission to access '
        .'this object.';

    }

  }

  // }}}
  // {{{ GetID()

  /**
   * Return the id number of this answer
   *
   * @access public
   * @return integer
   */
  function GetID() {

    return $this->answer_id;

  }

  // }}}
  // {{{ GetCompletedExam()

  /**
   * Return the Completed Exam that this Answer belongs to
   *
   * @access public
   * @return object Citadel_CompletedExam
   * @uses Citadel_CompletedExam
   */
  function GetCompletedExam() {

    return new Citadel_CompletedExam($this->answer_result, $this->roster_coder);

  }

  // }}}
  // {{{ GetQuestion()

  /**
   * Return the question that this answer is to
   *
   * @access public
   * @return object Citadel_Question
   * @uses Citadel_Question
   */
  function GetQuestion() {

    return new Citadel_Question($this->answer_question, $this->roster_coder);

  }

  // }}}
  // {{{ GetAnswer()

  /**
   * Get the answer the person subbmited
   *
   * @access public
   * @return mixed String if success, False if coder denied
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function GetAnswer() {

    if ($this->Allowed('citadel')) {

      return $this->answer_answer;

    } else {

      $this->roster_error = 'Coder does not have permission to access this.';

      return false;

    }

  }

  // }}}
  // {{{ GetComments()

  /**
   * Get the comments added by the marker
   *
   * @access public
   * @return mixed String if success, False if coder denied
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function GetComments() {

    if ($this->Allowed('citadel')) {

      return $this->answer_comments;

    } else {

      $this->roster_error = 'Coder does not have permission to access this.';

      return false;

    }

  }

  // }}}
  // {{{ GetMark()

  /**
   * Retrieve the mark assigned by the marker
   *
   * @access public
   * @return float
   */
  function GetMark() {

    return $this->answer_points;

  }

  // }}}
  // {{{ GetPossibleMark()

  /**
   * Get the possible marks for this answer
   *
   * @access public
   * @return integer
   */
  function GetPossibleMark() {

    return $this->answer_possible;

  }

  // }}}
  // {{{ SetAnswer()

  /**
   * Set the answer submitted by the exam taker
   *
   * @access public
   * @param string The Answer
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetAnswer($answer) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exam_answers '
            .'SET answer = \''.addslashes($answer).'\' '
            .'WHERE id = '.$this->answer_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->answer_answer = $answer;

        return true;

      } else {

        $this->roster_error = 'Could not set answer.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted';

      return false;

    }

  }

  // }}}
  // {{{ SetComments()

  /**
   * Set the comments from the marker
   *
   * @access public
   * @param string The Comments
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetComments($comments) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exam_answers '
            .'SET comment = \''.addslashes($comments).'\' '
            .'WHERE id = '.$this->answer_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->answer_comments = $comments;

        return true;

      } else {

        $this->roster_error = 'Could not set comments.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted';

      return false;

    }

  }

  // }}}
  // {{{ SetMark()

  /**
   * Set the Mark for this Exam
   *
   * @access public
   * @param float The Mark
   * @return boolean
   * @uses BHGObject::Allowed() Coder Access Control
   */
  function SetMark($points) {

    if ($this->Allowed('citadel')) {

      $sql = 'UPDATE ntc_exam_answers '
            .'SET points = \''.addslashes($points).'\' '
            .'WHERE id = '.$this->answer_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->answer_points = $points;

        return true;

      } else {

        $this->roster_error = 'Could not set points.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted';

      return false;

    }

  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

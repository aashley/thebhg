<?php
/**
 * This file contains objects relating to the Citadel
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.19 $
 * @package Roster
 * @subpackage Citadel
 */

/**
 * Citadel - Completed Exam
 *
 * an exam that someone has completed
 *
 * <pre>
 *  20030830  aa  fixed Grade()
 *  20030827  aa  made sure queries go against correct db
 *                added sending of email notifications to Complete() and Grade()
 *  20030826  aa  fixed GetScore()
 *                added GetDateTaken()
 *                added GetCorrectAnswers(), GetIncorrectAnswers(),
 *                GetNumCorrect(), GetNumIncorrect()
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
 * @version $Revision: 1.19 $
 */
class Citadel_CompletedExam extends BHGObject {

  // {{{ properties

  /**
   * The ID Number of the completed Exam
   *
   * @access private
   * @var integer complete_id
   * @see GetID()
   */
  var $complete_id;

  /**
   * The ID Number of the Person that took this exam
   *
   * @access private
   * @var integer complete_bhg_id
   * @see GetPerson()
   */
  var $complete_bhg_id;

  /**
   * The exam that was taken
   *
   * @access private
   * @var integer complete_exam
   * @see GetExam()
   */
  var $complete_exam;

  /**
   * The score out of 100 the person got
   *
   * @access private
   * @var float complete_score
   * @see GetScore(), Grade()
   */
  var $complete_score;

  /**
   * Flag for whether exam has been graded
   *
   * @access private
   * @var integer complete_is_graded
   * @see IsGraded(), Grade()
   */
  var $complete_is_graded;

  /**
   * Flag for whether they passed the exam
   * 
   * @access private
   * @var integer complete_has_passed
   * @see HasPassed(), Grade()
   */
  var $complete_has_passed;

  /**
   * The date the exam was taken
   *
   * The date the exam was taken. 0 or NULL mean it hasnt been taken yet.
   *
   * @access private
   * @var integer complete_date_taken
   * @see HasCompleted(), Complete(), GetDateTaken()
   */
  var $complete_date_taken;

  // }}}
  // {{{ Citadel_CompletedExam()

  /**
   * Object Constructor
   *
   * @access public
   * @param integer the id number of the completed exam to load
   * @param string Coder Identification String
   */
  function Citadel_CompletedExam($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $sql = 'SELECT id, '
                 .'bhg_id, '
                 .'exam, '
                 .'score, '
                 .'is_graded, '
                 .'has_passed, '
                 .'date_taken '
          .'FROM ntc_exam_completed '
          .'WHERE id = '.$id;

    $result = mysql_query($sql, $this->roster_db);

    if ($exam = @mysql_fetch_assoc($result)) {

      foreach ($exam as $key => $value) {

        $key = 'complete_'.$key;

        $this->$key = stripslashes($value);

      } 

    } else {

      $this->roster_error = 'Could not load Completed Exam details.';

    }

  }

  // }}}
  // {{{ GetID()

  /**
   * Retrieve the ID of this Completed Exam
   *
   * @access public
   * @return integer
   */
  function GetID() {

    return $this->complete_id;

  }

  // }}}
  // {{{ GetPerson()

  /**
   * Retrieve the person that took this exam
   *
   * @access public
   * @return object Person
   * @uses Person
   */
  function GetPerson() {

    return new Person($this->complete_bhg_id, $this->roster_coder);

  }

  // }}}
  // {{{ GetExam()

  /**
   * Return the exam taken
   *
   * @access public
   * @return object Exam
   * @uses Citadel_Exam
   */
  function GetExam() {

    return new Citadel_Exam($this->complete_exam, $this->roster_coder);

  }

  // }}}
  // {{{ GetScore()

  /**
   * Return the score achieved on the exam
   *
   * @access public
   * @return float
   */
  function GetScore() {

    return $this->complete_score;

  }

  // }}}
  // {{{ GetDateTaken()

  /**
   * Retrieve the Date the user took this exam
   *
   * @access public
   * @return integer
   */
  function GetDateTaken() {

    return $this->complete_date_taken;

  }

  // }}}
  // {{{ IsGraded()

  /**
   * Has this exam been graded yet
   *
   * @access public
   * @return boolean
   */
  function IsGraded() {

    return ($this->complete_is_graded == 1);

  }

  // }}}
  // {{{ HasPassed()

  /**
   * Whether they passed this exam or not
   *
   * @access public
   * @return boolean
   */
  function HasPassed() {

    return ($this->complete_has_passed == 1);

  }

  // }}}
  // {{{ HasCompleted()

  /**
   * Has the person Completed taking this exam
   *
   * @access public
   * @return boolean
   */
  function HasCompleted() {

    return (   is_null($this->complete_date_taken)
            || $this->complete_date_taken == 0);

  }

  // }}}
  // {{{ GetAnswers()

  /**
   * Return the answers the person submitted
   *
   * @access public
   * @return array of Answer objects
   * @uses Citadel_Answer
   */
  function &GetAnswers() {

    if ($this->Allowed('citadel')) {

      $sql = 'SELECT id '
            .'FROM ntc_exam_answers '
            .'WHERE result = '.$this->complete_id;

      $result = mysql_query($sql, $this->roster_db);

      $return = array();

      while ($answer = mysql_fetch_assoc($result)) {

        $return[] = new Citadel_Answer($answer['id'], $this->roster_coder);

      }

      return $return;

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ GetCorrectAnswers()

  /**
   * Return the Correctanswers the person submitted
   *
   * @access public
   * @return array of Answer objects
   * @uses Citadel_Answer
   */
  function &GetCorrectAnswers() {

    if ($this->Allowed('citadel')) {

      $sql = 'SELECT id '
            .'FROM ntc_exam_answers '
            .'WHERE result = '.$this->complete_id.' '
              .'AND points >= possible';

      $result = mysql_query($sql, $this->roster_db);

      $return = array();

      while ($answer = mysql_fetch_assoc($result)) {

        $return[] = new Citadel_Answer($answer['id'], $this->roster_coder);

      }

      return $return;

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ GetIncorrectAnswers()

  /**
   * Return the answers the person submitted
   *
   * @access public
   * @return array of Answer objects
   * @uses Citadel_Answer
   */
  function &GetIncorrectAnswers() {

    if ($this->Allowed('citadel')) {

      $sql = 'SELECT id '
            .'FROM ntc_exam_answers '
            .'WHERE result = '.$this->complete_id.' '
              .'AND points < possible';

      $result = mysql_query($sql, $this->roster_db);

      $return = array();

      while ($answer = mysql_fetch_assoc($result)) {

        $return[] = new Citadel_Answer($answer['id'], $this->roster_coder);

      }

      return $return;

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ GetNumCorrect()

  /**
   * Return the number of Correctanswers the person submitted
   *
   * @access public
   * @return integer
   */
  function GetNumCorrect() {

    if ($this->Allowed('citadel')) {

      $sql = 'SELECT COUNT(*) as count '
            .'FROM ntc_exam_answers '
            .'WHERE result = '.$this->complete_id.' '
              .'AND points >= possible';

      $result = mysql_query($sql, $this->roster_db);

      $return = mysql_result($result, 0, 'count');

      return $return;

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ GetNumIncorrect()

  /**
   * Return the answers the person submitted
   *
   * @access public
   * @return array of Answer objects
   */
  function GetNumIncorrect() {

    if ($this->Allowed('citadel')) {

      $sql = 'SELECT COUNT(*) as count '
            .'FROM ntc_exam_answers '
            .'WHERE result = '.$this->complete_id.' '
              .'AND points < possible';

      $result = mysql_query($sql, $this->roster_db);

      return mysql_result($result, 0, 'count');

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ Complete()

  /**
   * Mark this exam as completed by the person taking it
   *
   * @access public
   * @return boolean
   * @uses Citadel_Exam
   * @uses Citadel_Exam::GetMarkers()
   * @uses Citadel_Exam::GetAbbrev()
   * @uses Citadel_Exam::GetName()
   * @uses Person
   * @uses Person::GetName()
   * @uses Person::SendEmail()
   */
  function Complete() {

    if ($this->Allowed('citadel')) {

      $time = time();

      $sql = 'UPDATE ntc_exam_completed '
            .'SET date_taken = '.$time.' '
            .'WHERE id = '.$this->complete_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->complete_date_taken = $time;

        $exam = $this->GetExam();

        $person = $this->GetPerson();

        $markers = $exam->GetMarkers();

        foreach ($markers as $marker) {

          $marker->SendEmail('citadel@thebhg.org',
              $person->GetName().' has submitted a '.$exam->GetName().' Exam',
              'To mark this exam go to: http://citadel.thebhg.org'
              .$GLOBALS['site']['file_root'].'admin/grade/'
              .strtolower($exam->GetAbbrev()).'/'.$this->GetID()
              ."\n\n"
              .'BHG Citadel');

        }

        return true;

      } else {

        $this->roster_error = 'Could not set status.';

        return false;

      }

    } else {

      $this->roster_error = 'Coder not permitted.';

      return false;

    }

  }

  // }}}
  // {{{ Grade()

  /**
   * Grade this exam and take care of any awards
   *
   * This function takes care of the grading of an exam. It calculates the final
   * score, updates the db, and awards any rewards for completing this exam.
   *
   * NOTE: This function should only be called after every single question's
   * final score has been recorded as it can only be called once.
   *
   * @access public
   * @param mixed ID Number of the person that graded or an object representing
   *              them
   * @return boolean
   * @uses Person
   * @uses Person::AddCredits()
   * @uses Person::SetCompletedNTC()
   * @uses Person::GetName()
   * @uses Person::SendEmail()
   * @uses Citadel_Answer
   * @uses Citadel_Answer::GetMark()
   * @uses Citadel_Answer::GetPossibleMark()
   * @uses Citadel_Exam
   * @uses Citadel_Exam::GetID()
   * @uses Citadel_Exam::GetPassGrade()
   * @uses Citadel_Exam::GetCreditAward()
   * @uses Citadel_Exam::GetMedalAward()
   * @uses MedalBoard
   * @uses MedalBoard::AwardMedal()
   */
  function Grade($grader) {

    if ($this->Allowed('citadel')) {

      if (is_object($grader)) {

        if (!($grader instanceof Person)) {

          $this->roster_error = 'Invalid Object Passed to Grade.';

          return false;

        }

      } elseif (is_numeric($grader)) {

        $grader = new Person($grader, $this->roster_coder);

      } else {

        $this->roster_error = 'Invalid Parameter passed to Grade.';

        return false;

      }

      $score = 0;
      $possible = 0;

      $answers = $this->GetAnswers();

      foreach ($answers as $answer) {

        $score += $answer->GetMark();
        $possible += $answer->GetPossibleMark();

      }

      unset($answers);

      $final_score = ($score / $possible) * 100;

      $exam = $this->GetExam();

      if ($final_score >= $exam->GetPassGrade()) {

        $passed = 1;

      } else {

        $passed = 0;

      }

      $sql = 'UPDATE ntc_exam_completed '
            .'SET score = '.$final_score.', '
                .'is_graded = 1, '
                .'has_passed = '.$passed.' '
            .'WHERE id = '.$this->complete_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->complete_score = $final_score;
        $this->complete_is_graded = 1;
        $this->complete_has_passed = $passed;

        $message = 'Your submission for the '.$exam->GetName().' Exam has '
          ."been marked by ".$grader->GetName().".\n\n"
          ."You scored ".number_format($final_score, 2)."%\n\n";

        if ($this->HasPassed()) {

          $person = $this->GetPerson();
          $person->AddCredits($exam->GetCreditAward(),
                              'Citadel');

          $message .= 'You have been awarded '
            .number_format($exam->GetCreditAward()).' Imperial Credits for '
            .'passing this exam.'."\n\n";

          if ($final_score >= 100) {

            $mb = new MedalBoard($this->roster_coder);

            $medal = $exam->GetMedalAward();

            if ($medal !== false) {

              $message .= 'You have also been awarded the '.$medal->GetName()
                .' for achieving a perfect score on this exam.'."\n\n";

              $mb->AwardMedal($person->GetID(),
                              $grader->GetID(),
                              $medal->GetID(),
                              'Getting 100% in the \''.$exam->GetName()
                              .'\' exam at the Citadel.');

            }

          }

          // Specially handling for CORE exam
          if ($exam->GetID() == 1) {

            $person->SetCompletedNTC();

          }

          $message .= 'BHG Citadel';

          $person->SendEmail('executor@thebhg.org',
              'You submission for the '.$exam->GetName()
              .' Exam has been marked',
              $message);

        }

        return true;

      } else {

        $this->roster_error = 'Could not save results.';

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

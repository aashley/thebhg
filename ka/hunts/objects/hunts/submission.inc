<?php
/**
 * Submission management
 *
 *  <pre>Date      Version        Summary
 *
 *  20031214  1.0.1          Fixed second constructor function call to initialize coder id instead of rewriting it..
 *  20031210  1.0.0          First official documentation release. Added in coder id security.</pre>
 *
 * @package KA
 * {@inheritdoc }
 */

/**
 * Note: Set functions are not availiable because submissions are not meant to be changed.
 *
 * <pre>Hierarchy
 *  KA
 *  |-- Hunt
 *  |   |--Grades
 *  |   `--<b><i>Submission</i></b>
 *  |-- Hunt Type
 *  `-- Season</pre>
 * @access public
 * {@inheritdoc }
 * @package KA
 */
class Submission extends Hunt {
    /**
     * @var int $submission_id
     * @access private
     */
    var $submission_id;
    /**
     * @var int $submission_hunt
     * @access private
     */
    var $submission_hunt;
    /**
     * @var int $submission_person
     * @access private
     */
    var $submission_person;
    /**
     * @var int $submission_answer
     * @access private
     */
    var $submission_answer;
    /**
     * @var int $submission_timestamp
     * @access private
     */
    var $submission_timestamp;
    /**
     * @var int $submission_ip
     * @access private
     */
    var $submission_ip;

    /**
     * The constructor for the Submission class. Calls the parent class constructors to set variables, then sets its own.
     * @param int $submission_id The Unique ID number of each submission.
     * @return void
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function Submission ($submission_id, $coder = '') {
        $this->KA($coder);
        $result = @mysql_query ("SELECT * FROM `hunt_submissions` WHERE `submission_id` = ".$submission_id, $this->ka_db);
        $this->submission_id = @mysql_result ($result, 0, "submission_id");
        $this->submission_hunt = @mysql_result ($result, 0, "submission_hunt");
        $this->submission_person = @mysql_result ($result, 0, "submission_person");
        $this->submission_answer = @mysql_result ($result, 0, "submission_answer");
        $this->submission_timestamp = @mysql_result ($result, 0, "submission_timestamp");
        $this->submission_ip = @mysql_result ($result, 0, "submission_ip");
        $this->Hunt($this->submission_hunt, $coder);
    }

    /**
     * Gets the Unique ID number of this submission
     * @return int The Unique ID number
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetID () {
        return $this->submission_id;
    }

    /**
     * Gets the parent Hunt object.
     * @return Hunt
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetHunt () {
        return new Hunt ($this->submission_hunt, $this->roster_coder);
    }

    /**
     * Gets the Person object of the person that submitted this submission
     * @param string $coder_id Optional coder id to use. Used only when credit awarding is needed.
     * @return Person Person object
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetPerson () {
        return new Person ($this->submission_person, $this->roster_coder);
    }

    /**
     * Gets the submitted answer(s).
     * @return array An array of all the answers.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetAnswer () {
        return unserialize(base64_decode($this->submission_answer));
    }

    /**
     * Gets the UNIX timestamp of when this submission was created.
     * @return int UNIX timestamp.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetTimestamp () {
        return $this->submission_timestamp;
    }

    /**
     * Gets the IP address of the person who created this submission.
     * @return string IP address.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetSubmissionIP () {
        return $this->submission_ip;
    }

    /**
     * Self explanitory
     * @return boolean True for successful, false otherwise
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function Delete () {
        $hunt_division = mysql_result(@mysql_query("SELECT `hunt_division` FROM `hunts` WHERE `hunt_id` = '$this->submission_hunt'", $this->ka_db), 0, 'hunt_division');
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            if (@mysql_query ("DELETE FROM `hunt_submissions` WHERE `submission_id` = ".$this->submission_id, $this->ka_db))
                return true;
            else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }
}

?>

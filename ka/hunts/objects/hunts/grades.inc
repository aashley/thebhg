<?php
/**
 * This contains all the functions needed to maintain Grades.
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
 * Grade functions
 *
 * <pre>Hierarchy
 *  KA
 *  |-- Hunt
 *  |   |--<b><i>Grades</i></b>
 *  |   `--Submission
 *  `-- Hunt Type</pre>
 * @access public
 * {@inheritdoc }
 * @package KA
 */
class Grades extends Hunt {
    /**
     * @var array $grades_arr An array of the grades row.
     */
    var $grades_arr;

    /**
     * Constructor for Grades class.
     *
     * Calls the KA and Hunt class constructors to set variables and then sets the class variable.
     * @param int $grade_id The Grade ID number to set this object as.
     * @param string $coder Coder ID. Required for some functions.
     * @return void
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function Grades ($grade_id, $coder = '') {
        $this->KA($coder);
        $result = @mysql_query ("SELECT * FROM `hunt_grades` WHERE `grade_id` = ".$grade_id, $this->ka_db);
        $this->grades_arr = @mysql_fetch_array($result);
        $this->Hunt($this->grades_arr['hunt_id'], $coder);
    }

    /**
     * Gets the Grade ID number that this grade is. This number should be unique.
     *
     * @return int Grade ID number.
     * @access public
     * @since Pre 1.0.0 Unknown Creation date.
     */
    function GetGradeID () {
        return $this->grades_arr['grade_id'];
    }

    /**
     * Gets the entire grades array or a part of it.
     * @param int $sub Only get the part of the array with the specified Submission ID
     * @return array An array of Grades.
     * @access public
     * @since Pre 1.0.0 Unknown Creation date.
     */
    function GetGrades ($sub = -1) {
        $grades = base64_decode($this->grades_arr['grades']);
        $grades = unserialize($grades);
        if ($sub == -1) {
            return $grades;
        } else {
            for ($i = 0; $i < $this->GetNumSubs(); $i++) {
                if ($grades[$i]['id'] == $sub) {
                    $theone = $i;
                }
            }
            if (!isset($theone)) return $grades;
            else return $grades[$theone];
        }
    }

    /**
     * Sets the Grades
     * @param array Full array of all graded information
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation date.
     */
    function SetGrades ($grades) {
        if ($this->Allowed('allhunts') || $this->Allowed('hunts')) {
            $grades_str = serialize($grades);
            if (@mysql_query ("UPDATE `hunt_grades` SET `grades` = '".$grades_str."' WHERE grade_id = ".$this->grades_arr['grade_id']." LIMIT 1", $this->ka_db)) {
                $this->Grades($this->grades_arr['grade_id']);
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Gets the number of submissions in this grade object of optional type.
     * @param int $type Type of submissions to check for. -1 for Not to be included. 0 for No effort. 1 for Valid. 2 for All.
     * @return int Number of Submissions of optional type in this grade object
     * @access public
     * @since Pre 1.0.0 Unknown Creation date.
     */
    function GetNumSubs($type = 2) {
        $grade_arr = $this->GetGrades();
        $count = 0;
        if ($type == 2) {
            return count($grade_arr);
        } else {
            for ($i = 0; $i < count($grade_arr); $i++) {
                if ($grades_arr[$i]['status'] == $type) {
                    $count++;
                }
            }
            return $count;
        }
    }

    /**
     * Gets the Submission object IDs of all submissions in the Grade object. Only sort order is date.
     * @todo Add more sort orders
     * @return array Array of Submission IDs
     * @access public
     * @since Pre 1.0.0 Unknown Creation date.
     */
    function GetSubIDs() {
        $grade_arr = $this->GetGrades();
        $return = array();
        $grades = $this->GetGrades();
        for ($i = 0; $i < $this->GetNumSubs(2); $i++) {
            $return[$i] = $grades[$i]['id'];
        }
        return $return;
    }

    /**
     * Gets all the submission objects of the grade object. Just adds onto the GetGradeSubs function.
     * @return array Array of Submission Objects
     * @access public
     * @since Pre 1.0.0 Unknown Creation date.
     */
    function GetGradeSubs() {
        $subids = $this->GetSubIDs();
        $grades = array();
        for ($i = 0; $i < count($subids); $i++) {
            $grades[$i] = new Submission($subids[$i], $this->roster_coder);
        }
        return $grades;
    }


    /**
     * Gets all the submissions that have the number correct specified
     * @param int $numcorrect Number of questions correct.
     * @param int $status Optional Status flag. Defaults to 1 for valid. Accepts 1, 0 or -1 for valid, no effort, not included, respectively.
     * @return array Array of submission objects with the number correct specified
     * @access protected
     * @since Pre 1.0.0 Unknown Creation date.
     */
    function GetCorrect($numcorrect, $status = 1) {
        $hunt_division = mysql_result(@mysql_query("SELECT `hunt_division` FROM `hunts` WHERE `hunt_id` = '".$this->grades_arr['hunt_id']."'", $this->ka_db), 0, 'hunt_division');
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            $grade_arr = $this->GetGrades();
            $subids = $this->GetSubIDs();
            $grades = array();
            if ($status == 1) {
                for ($i = 0; $i < count($subids); $i++) {
                    $count = 0;
                    for ($j = 0; $j < count($grade_arr[$i]['question']); $j++) {
                        if ($grade_arr[$i]['question'][$j] == 1) {
                            $count++;
                        }
                    }
                    if (($grade_arr[$i]['status'] == $status) && ($count == $numcorrect)) {
                        $grades[] = new Submission($subids[$i], $this->roster_coder);
                    }
                }
            } else { //Ignores number correct if its no effort or ignored
                for ($i = 0; $i < count($subids); $i++) {
                    if ($grade_arr[$i]['status'] == $status) {
                        $grades[] = new Submission($subids[$i], $this->roster_coder);
                    }
                }
            }
            return $grades;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }
}
?>
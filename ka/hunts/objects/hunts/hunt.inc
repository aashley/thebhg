<?php
/**
 * This contains all the functions needed to maintain a Hunt.
 *
 *  <pre>Date      Version        Summary
 *
 *  20031228  1.1.0          Completed Credit and Grade changing functions.
 *  20031210  1.0.0          First official documentation release. Added in coder id security.</pre>
 *
 * @package KA
 * {@inheritdoc }
 */

/**
 * Hunt functions
 *
 * <pre>Hierarchy
 *  KA
 *  |-- <b><i>Hunt</i></b>
 *  |   |--Grades
 *  |   `--Submission
 *  |-- Hunt Type
 *  `-- Season</pre>
 * @access public
 * {@inheritdoc }
 * @package KA
 */
class Hunt extends KA {
    /**
     * @var int $hunt_id Hunt ID Number
     * @access private
     */
    var $hunt_id;
    /**
     * @var int $hunt_num Hunt Number
     * @access private
     */
    var $hunt_num;
    /**
     * @var int $hunt_type Hunt Type ID that this hunt belongs to
     * @access private
     */
    var $hunt_type;
    /**
     * @var int $hunt_division Division ID that this hunt is available to.
     * @access private
     */
    var $hunt_division;
    /**
     * @var int $hunt_first Awards for first place.
     * @access private
     */
    var $hunt_first;
    /**
     * @var string $hunt_rewards Serialized array of rewards
     * @access private
     */
    var $hunt_rewards;
    /**
     * @var string $hunt_content Serialized array of contents of hunt
     * @access private
     */
    var $hunt_content;
    /**
     * @var int $hunt_start_timestamp UNIX timestamp for the start of the hunt
     * @access private
     */
    var $hunt_start_timestamp;
    /**
     * @var int $hunt_end_timestamp UNIX timestamp for the end of the hunt
     * @access private
     */
    var $hunt_end_timestamp;

    /**
     * Constructor for Hunt class. Calls the KA class to set variables and then sets the class variables.
     * @param int $hunt_id The Hunt ID number to set this object as.
     * @param string $coder Coder ID. Required for some functions.
     * @return void
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function Hunt ($hunt_id, $coder = '') {
        $this->KA($coder);
        $result = @mysql_query ("SELECT * FROM `hunts` WHERE `hunt_id` = '$hunt_id' LIMIT 1", $this->ka_db);

        //Start initializing class variables
        $this->hunt_id = @mysql_result ($result, 0, "hunt_id");
        $this->hunt_num = @mysql_result ($result, 0, "hunt_num");
        $this->hunt_type = @mysql_result ($result, 0, "hunt_type");
        $this->hunt_division = @mysql_result ($result, 0, "hunt_division");
        $this->hunt_first = @mysql_result ($result, 0, "hunt_first");
        $this->hunt_rewards = @mysql_result ($result, 0, "hunt_rewards");
        $this->hunt_content = @mysql_result ($result, 0, "hunt_content");
        $this->hunt_start_timestamp = @mysql_result ($result, 0, "hunt_start_timestamp");
        $this->hunt_end_timestamp = @mysql_result ($result, 0, "hunt_end_timestamp");
        //End initializing class variables
    }

    /**
     * Gets the Hunt ID number that this hunt is. This number should be unique.
     * @return int Hunt ID number.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetID () {
        return $this->hunt_id;
    }

    /**
     * Gets the Hunt Number that this hunt is.
     * @return int Hunt Number
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetHuntNum() {
        return $this->hunt_num;
    }

    /**
     * Gets the Hunt Type that this hunt is a part of.
     * @return Hunt_Type The Hunt Type object that this hunt belongs to.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetHuntType () {
        return new Hunt_Type ($this->hunt_type, $this->roster_coder);
    }

    /**
     * Gets the division object that this hunt is availiable to.
     * @return Division The division object that this hunt is availiable to.
     * @see Division::Division()
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetDivision () {
        return new Division ($this->hunt_division, $this->roster_coder);
    }

    /**
     * Gets the division ID that this hunt is availiable to.
     * @return int The division ID that this hunt is availiable to.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetDivisionID () {
        return $this->hunt_division;
    }

    /**
     * Gets amount to award to a first place.
     * @return int Amount to award for first place.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetHuntFirst () {
        return $this->hunt_first;
    }

    /**
     * Gets the rewards of the hunt. Should contain an array with keys ['1/num_answers'] through ['num_answers/num_answers']. Each being an int.
     * @return array An array of integers.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetHuntRewards () {
        return unserialize($this->hunt_rewards);
    }

    /**
     * Gets the content of the hunt. Should contain an array with keys ['questions'] and ['answers']. Each being another array.
     * @return array An array of a question array and a answer array.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetContent () {
        return unserialize(base64_decode($this->hunt_content));
    }

    /**
     * Gets the UNIX timestamp of when this hunt starts.
     * @return int Starting Timestamp
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetStartTimestamp () {
        return $this->hunt_start_timestamp;
    }

    /**
     * Gets the UNIX timestamp of when this hunt ends.
     * @return int Ending Timestamp
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetEndTimestamp () {
        return $this->hunt_end_timestamp;
    }

    /**
     * Sees if the Person has submitted for this hunt yet.
     * @param int $id Person's ID number to check.
     * @return boolean True for yes, false otherwise.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function HasSubmitted ($id) {
        if (@mysql_result(@mysql_query ("SELECT `submission_id` AS `sub_id` FROM `hunt_submissions` WHERE `submission_person` = $id AND `submission_hunt` = ".$this->hunt_id." LIMIT 1", $this->ka_db), 0, 'sub_id') != '') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sets the division(s) that this hunt will be availiable to.
     * @param int $hunt_division The division ID that this hunt should be availiable to.
     * @return boolean True for successful, false otherwise.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetDivision ($hunt_division) {
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            if (@mysql_query ("UPDATE `hunts` SET `hunt_division` = $hunt_division WHERE `hunt_id` = $this->hunt_id;", $this->ka_db)) {
                $this->hunt_division = $hunt_division;
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the credits the first place will recieve.
     * @param int $hunt_first The number of credits to award the first place.
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetHuntFirst ($hunt_first) {
        $hunt_division = mysql_result(@mysql_query("SELECT `hunt_division` FROM `hunts` WHERE `hunt_id` = '$this->hunt_id'", $this->ka_db), 0, 'hunt_division');
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            if (@mysql_query ("UPDATE `hunts` SET `hunt_first` = $hunt_first WHERE `hunt_id` = $this->hunt_id", $this->ka_db)) {
                $this->hunt_first = $hunt_first;
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the rewards for the hunt. This should include amounts for all positions
     * @param array Should be an array. Should contain ['0/num_answers'] through ['num_answers/num_answers'], each key containing an integer
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetHuntRewards ($hunt_rewards) {
        $hunt_division = mysql_result(@mysql_query("SELECT `hunt_division` FROM `hunts` WHERE `hunt_id` = '$this->hunt_id'", $this->ka_db), 0, 'hunt_division');
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            $rewards = serialize($hunt_rewards);
            if (@mysql_query ("UPDATE `hunts` SET `hunt_rewards` = '$rewards' WHERE `hunt_id` = $this->hunt_id", $this->ka_db)) {
                $this->hunt_rewards = $rewards;
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the content of the hunt. This should include all the questions and answers.
     * @param array Should be an array. Should contain keys ['questions'] and ['answers'], each an array.
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetContent ($hunt_content) {
        $hunt_division = mysql_result(@mysql_query("SELECT `hunt_division` FROM `hunts` WHERE `hunt_id` = '$this->hunt_id'", $this->ka_db), 0, 'hunt_division');
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            $content = serialize($hunt_content);
            $content = base64_encode($content);
            if (@mysql_query ("UPDATE `hunts` SET `hunt_content` = '$content' WHERE `hunt_id` = $this->hunt_id", $this->ka_db)) {
                $this->hunt_content = $content;
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the hunt's start timestamp
     * @param int $hunt_start_timestamp The UNIX timestamp of when this hunt should start.
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetStartTimestamp ($hunt_start_timestamp) {
        $hunt_division = mysql_result(@mysql_query("SELECT `hunt_division` FROM `hunts` WHERE `hunt_id` = '$this->hunt_id'", $this->ka_db), 0, 'hunt_division');
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            if (@mysql_query ("UPDATE `hunts` SET `hunt_start_timestamp` = '$hunt_start_timestamp' WHERE `hunt_id` = $this->hunt_id", $this->ka_db)) {
                $this->hunt_start_timestamp = $hunt_start_timestamp;
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the hunt's end timestamp
     * @param int $hunt_end_timestamp The UNIX timestamp of when this hunt should end.
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetEndTimestamp ($hunt_end_timestamp) {
        $hunt_division = mysql_result(@mysql_query("SELECT `hunt_division` FROM `hunts` WHERE `hunt_id` = '$this->hunt_id'", $this->ka_db), 0, 'hunt_division');
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            if (@mysql_query ("UPDATE `hunts` SET `hunt_end_timestamp` = '$hunt_end_timestamp' WHERE `hunt_id` = $this->hunt_id", $this->ka_db)) {
                $this->hunt_end_timestamp = $hunt_end_timestamp;
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Gets an array of all the submissions this hunt has
     * @return array An array of submission objects.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetSubmissions () {
        $array = array ();
        $result = @mysql_query ("SELECT `submission_id` FROM `hunt_submissions` WHERE `submission_hunt` = '".$this->hunt_id."' ORDER BY `submission_timestamp` ASC;", $this->ka_db);
        while ($row = @mysql_fetch_array ($result))
            $array [] = new Submission ($row["submission_id"], $this->roster_coder);
        return $array;
    }

    /**
     * Gets the number of submissions for this hunt
     * @return int Number of submissions this hunt has
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetSubmissionsCount () {
        return @mysql_result (@mysql_query ("SELECT COUNT(*) AS `num` FROM `hunt_submissions` WHERE `submission_hunt` = '".$this->hunt_id."'", $this->ka_db), 0, "num");
    }

    /**
     * Grades the hunt
     * @param array $grades An array of the grades. Should contain keys from 0 to GetSubmissionsCount - 1.
     * @return Grades|false The newly created Grades object or false if unsuccessful.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function Grade ($grades) {
        $hunt_division = mysql_result(@mysql_query("SELECT `hunt_division` FROM `hunts` WHERE `hunt_id` = '$this->hunt_id'", $this->ka_db), 0, 'hunt_division');
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            $grades_str = base64_encode(serialize($grades));
            if (@mysql_query ("INSERT INTO `hunt_grades` (`hunt_id`, `grades`) values ('".$this->hunt_id."', '$grades_str');", $this->ka_db))
                return new Grades (@mysql_insert_id ($this->ka_db), $this->roster_coder);
            else {
                return false;
            }
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Changes the Grades for the hunt
     * @param array $grades An array of the grades. Should contain keys from 0 to GetSubmissionsCount - 1.
     * @return Grades|false The updated Grades object or false if unsuccessful.
     * @access protected
     * @since v. 1.1.0
     */
    function ChangeGrades ($grades) {
        $hunt_division = mysql_result(@mysql_query("SELECT `hunt_division` FROM `hunts` WHERE `hunt_id` = '$this->hunt_id'", $this->ka_db), 0, 'hunt_division');
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            $grades_str = base64_encode(serialize($grades));
            if (@mysql_query ("UPDATE `hunt_grades` SET `grades`='$grades_str' WHERE `hunt_id`='".$this->hunt_id."' LIMIT 1", $this->ka_db))
                return $this->IsGraded();
            else {
                $this->roster_error = "Unsuccessful update query.";
                return false;
            }
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Renders the grades
     * @return void
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function RenderGrades () {
        if ($this->IsGraded()) {
            $grade_obj = $this->IsGraded();
            $grades_arr = $grade_obj->GetGrades();
            $roster_obj = new Roster($this->roster_coder);
            $hunt_type = new Hunt_Type($this->hunt_type, $this->roster_coder);
            $rewards = $this->GetHuntRewards();
            $center_attr = array('style' => 'text-align: center');
            if ($this->GetHuntFirst()) {
                $ftheader = array('<b><i>First Place ('.number_format($this->GetHuntFirst()).' ICs)</i></b>');
                //Find the first place submission in the grades array
                $full = $grade_obj->GetCorrect($hunt_type->GetNumAnswers());
                if (isset($full[0])) $first = $full[0]->GetID();
                if (!isset($first)) {
                    $table = new HTML_Table();
                    $table->addrow( $ftheader,
                                    array(),
                                    'TH');
                    $table->addrow(array('-None-'), $center_attr);
                    print $table->toHTML();
                } else {
                    //Make a submission object
                    $sub = new Submission($first, $this->roster_coder);
                    //Get the person object
                    $person_obj = $sub->GetPerson();
                    $ftbody = array('<a href="/hunts/index.php?site=display_sub&id='.$sub->GetID().'">'.$person_obj->IDLine(0).'</a>');
                    //$grades_arr = array_splice($grades_arr, $first, 1); // Remove first place from array
                    //sort($grades_arr); // Resort array
                    $table = new HTML_Table();
                    $table->addrow( $ftheader,
                                    array(),
                                    'TH');
                    $table->addrow($ftbody);
                    print $table->toHTML();
                }
            }
            //Recurses through all the grades. From full points (total/total) to no points (0/total)
            for($i = 0; $i <= $hunt_type->GetNumAnswers(); $i++) {
                $grbody = array();
                $position = ($hunt_type->GetNumAnswers() - $i)."/".$hunt_type->GetNumAnswers();
                $num = $hunt_type->GetNumAnswers() - $i;
                $grheader = array("<b><i>".$position." Correct (".number_format($rewards[$i])." ICs)</i></b><br />");
                $subs = $grade_obj->GetCorrect($num, 1);
                for ($j = 0; $j < count($subs); $j++) {
                    $sub = $subs[$j];
                    if ($sub->GetID() != $first) { //Make sure its not the first place submission
                        $person_obj = $sub->GetPerson();
                        $grbody[] = array('<a href="/hunts/index.php?site=display_sub&id='.$sub->GetID().'">'.$person_obj->IDLine(0).'</a>');
                    }
                }
                $table = new HTML_Table();
                $table->addrow( $grheader,
                                array(),
                                'TH');
                if (count($grbody) > 0) {
                    for ($j = 0; $j < count($grbody); $j++) {
                        $table->addrow($grbody[$j]);
                    }
                } else {
                    $table->addrow(array('-None-'), $center_attr);
                }
                print $table->toHTML();
            }
            //No efforts
            unset($grbody, $grheader);
            $grbody = array();
            $grheader = array('<b><i>No effort submissions (0 ICs)</i></b><br />');
            $subs = $grade_obj->GetCorrect(0, 0);
            for ($j = 0; $j < count($subs); $j++) {
                $sub = $subs[$j];
                $person_obj = $sub->GetPerson();
                $grbody[$j] = array('<a href="/hunts/index.php?site=display_sub&id='.$sub->GetID().'">'.$person_obj->IDLine(0).'</a>');
            }
            $table = new HTML_Table();
            $table->addrow( $grheader,
                            array(),
                            'TH');
            if (count($grbody) > 0) {
                for ($j = 0; $j < count($grbody); $j++) {
                    $table->addrow($grbody[$j]);
                }
            } else {
                $table->addrow(array('-None-'), $center_attr);
            }
            print $table->toHTML(); // End No efforts
        } else {
            echo "<b><i>This hunt is pending a grade</i></b><br />";
        }
    }

    /**
     * Checks to see if this hunt has been graded.
     * @return Grades|false The Grade Object if it has, false otherwise.
     */
    function IsGraded () {
        $grades = @mysql_result (@mysql_query ("SELECT `grade_id` AS `num` FROM `hunt_grades` WHERE `hunt_id` = '".$this->hunt_id."' LIMIT 1", $this->ka_db), 0, "num");
        if ($grades != '') {
            return new Grades($grades, $this->roster_coder);
        }
        else
            return false;
    }

    /**
     * Creates a submission for a person.
     *
     * @param int $submission_person The Person's ID Number to create a submission for.
     * @param array $submission_answer The Answer(s) that the person submitted.
     * @return Submission|false The newly created submission or false if unsuccessful.
     */
    function CreateSubmission ($submission_person, $submission_answer, $ip) {
        $submission = base64_encode(serialize($submission_answer));
        if (@mysql_query ("INSERT INTO `hunt_submissions` (`submission_hunt`, `submission_person`, `submission_answer`, `submission_ip`, `submission_timestamp`) VALUES ('".$this->hunt_id."', '".$submission_person."', '".$submission."', '".$ip."', '" . time() . "')", $this->ka_db))
            return new Submission (@mysql_insert_id ($this->ka_db), $this->roster_coder);
        else
            return false;
    }

    /**
     * Awards credits for the array
     * @param Grade $grade_obj Grades object to award credits for.
     * @access protected
     * @return false|string Returns any errors, if it returns false, then there was no errors.
     */
    function AwardCredits($grade_obj) {
        $hunt_division = mysql_result(@mysql_query("SELECT `hunt_division` FROM `hunts` WHERE `hunt_id` = '$this->hunt_id'", $this->ka_db), 0, 'hunt_division');
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            require_once 'HTML/Table.php';
            if (!$grade_obj) return "Error in Grade Object. Was not successfully graded or no grade object passed.";
            $error = false;
            $hunt_type = new Hunt_Type($this->hunt_type, $this->roster_coder);
            $rewards = $this->GetHuntRewards();
            if ($this->GetDivisionID() == -1) $div = "KA";
            else {
                //Gets the division name
                $div_obj = $this->GetDivision();
                $div = $div_obj->GetName();
            }
            $center_attr = array('style' => 'text-align: center');
            if ($this->GetHuntFirst()) {
                $ftheader = array('<b><i>First Place ('.number_format($this->GetHuntFirst()).' ICs)</i></b>');
                //Find the first place submission in the grades array
                $full = $grade_obj->GetCorrect($hunt_type->GetNumAnswers());
                if (isset($full[0])) $first = $full[0]->GetID();
                if (!isset($first)) {
                    $table = new HTML_Table();
                    $table->addrow( $ftheader,
                                    array(),
                                    'TH');
                    $table->addrow(array('-None-'), $center_attr);
                    print $table->toHTML();
                } else {
                    //Make a submission object
                    $sub = new Submission($first, $this->roster_coder);
                    //Get the person object
                    $person_obj = $sub->GetPerson();
                    if (!$person_obj->AddCredits($this->GetHuntFirst(), "First place in ".$div."'s ".$hunt_type->GetName()." ".$this->GetHuntNum())) $error = 'Error awarding credits. '.$person_obj->Error();
                    $ftbody = array($person_obj->GetName().' awarded '.number_format($this->GetHuntFirst()).' ICs for first place.');
                    $table = new HTML_Table();
                    $table->addrow( $ftheader,
                                    array(),
                                    'TH');
                    $table->addrow($ftbody);
                    print $table->toHTML();
                }
            }
            //Recurses through all the grades. From full points (total/total) to no points (0/total)
            for($i = 0; $i <= $hunt_type->GetNumAnswers(); $i++) {
                $grbody = array();
                $position = ($hunt_type->GetNumAnswers() - $i)."/".$hunt_type->GetNumAnswers();
                $num = $hunt_type->GetNumAnswers() - $i;
                $grheader = array("<b><i>".$position." Correct (".number_format($rewards[$i])." ICs)</i></b><br />");
                $subs = $grade_obj->GetCorrect($num, 1);
                for ($j = 0; $j < count($subs); $j++) {
                    $sub = $subs[$j];
                    if ($sub->GetID() != $first) { //Make sure its not the first place submission
                        $person_obj = $sub->GetPerson();
                        if (!$person_obj->AddCredits($rewards[$i], $position." in ".$div."'s ".$hunt_type->GetName()." ".$this->GetHuntNum())) $error = 'Error awarding credits. '.$person_obj->Error();
                        $grbody[$j] = array($person_obj->GetName().' awarded '.number_format($rewards[$i]).' ICs for a score of '.$position);
                    }
                }
                $table = new HTML_Table();
                $table->addrow( $grheader,
                                array(),
                                'TH');
                if (count($grbody) > 0) {
                    for ($j = 0; $j < count($grbody); $j++) {
                        $table->addrow($grbody[$j]);
                    }
                } else {
                    $table->addrow(array('-None-'), $center_attr);
                }
                print $table->toHTML();
            }
            //No efforts
            unset($grbody, $grheader);
            $grbody = array();
            $grheader = array('<b><i>No effort submissions (0 ICs)</i></b><br />');
            $subs = $grade_obj->GetCorrect(0, 0);
            for ($j = 0; $j < count($subs); $j++) {
                $sub = $subs[$j];
                $person_obj = $sub->GetPerson();
                $grbody[$j] = array($person_obj->GetName().' awarded nothing for his/her no effort submission.');
            }
            $table = new HTML_Table();
            $table->addrow( $grheader,
                            array(),
                            'TH');
            if (count($grbody) > 0) {
                for ($j = 0; $j < count($grbody); $j++) {
                    $table->addrow($grbody[$j]);
                }
            } else {
                $table->addrow(array('-None-'), $center_attr);
            }
            print $table->toHTML(); // End No efforts
            return $error;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return "No access to the function, coder id was not initialized.";
        }
    }

    /**
     * Changes credits for the array
     * @param Grade $prev_obj Old Grades object to compare credits to.
     * @param Grade $grade_obj New Grades object to compare credits to.
     * @access protected
     * @return false|string Returns any errors, if it returns false, then there was no errors.
     * @since v. 1.1.0
     */
    function ChangeCredits($prev_obj, $grade_obj) {
        $hunt_division = mysql_result(@mysql_query("SELECT `hunt_division` FROM `hunts` WHERE `hunt_id` = '$this->hunt_id'", $this->ka_db), 0, 'hunt_division');
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            require_once 'HTML/Table.php';
            if (!$prev_obj) return "Error in old Grade Object. Was not successfully graded or no grade object passed.";
            if (!$grade_obj) return "Error in new Grade Object. Was not successfully graded or no grade object passed.";
            $error = false;
            $hunt_type = new Hunt_Type($this->hunt_type, $this->roster_coder);
            $rewards = $this->GetHuntRewards();
            $center_attr = array('style' => 'text-align: center');
            if ($this->GetDivisionID() == -1) $div = "KA";
            else {
                //Gets the division name
                $div_obj = $this->GetDivision();
                $div = $div_obj->GetName();
            }

            /**
             * Operations performed:
             * 1 Finds old credit amounts for all submissions
             * 2 Finds new credit amounts for all submissions
             * 3 Compare old and new credits amounts to determine change
             * 4 Award change
             */

            /**--Sets credit amounts for old grades--*Start*/
            if ($this->GetHuntFirst()) {
                //Find the first place submission in the grades array
                $full = $prev_obj->GetCorrect($hunt_type->GetNumAnswers());
                if (isset($full[0])) $first = $full[0]->GetID();
                //Make a submission object
                $sub = new Submission($first, $this->roster_coder);
                //Get the person object
                $person_obj = $sub->GetPerson();
                $old_creds[$person_obj->GetID()] = $this->GetHuntFirst(); //Is not += because credits should only be set once
            }
            //Recurses through all the grades. From full points (total/total) to no points (0/total)
            for($i = 0; $i <= $hunt_type->GetNumAnswers(); $i++) {
                $num = $hunt_type->GetNumAnswers() - $i;
                $subs = $prev_obj->GetCorrect($num, 1);
                for ($j = 0; $j < count($subs); $j++) {
                    $sub = $subs[$j];
                    if ($sub->GetID() != $first) { //Make sure its not the first place submission
                        $person_obj = $sub->GetPerson();
                        $old_creds[$person_obj->GetID()] = $rewards[$i];
                    }
                }
            }
            //No efforts
            $subs = $prev_obj->GetCorrect(0, 0);
            for ($j = 0; $j < count($subs); $j++) {
                $sub = $subs[$j];
                $person_obj = $sub->GetPerson();
                $old_creds[$person_obj->GetID()] = 0;
            }
            /**--Sets credit amounts for old grades--*End*/

            /**--Sets credit amounts for new grades--*Start*/
            if ($this->GetHuntFirst()) {
                //Find the first place submission in the grades array
                $full = $grade_obj->GetCorrect($hunt_type->GetNumAnswers());
                if (isset($full[0])) $first = $full[0]->GetID();
                //Make a submission object
                $sub = new Submission($first, $this->roster_coder);
                //Get the person object
                $person_obj = $sub->GetPerson();
                $new_creds[$person_obj->GetID()] = $this->GetHuntFirst(); //Is not += because credits should only be set once
            }
            //Recurses through all the grades. From full points (total/total) to no points (0/total)
            for($i = 0; $i <= $hunt_type->GetNumAnswers(); $i++) {
                $num = $hunt_type->GetNumAnswers() - $i;
                $subs = $grade_obj->GetCorrect($num, 1);
                for ($j = 0; $j < count($subs); $j++) {
                    $sub = $subs[$j];
                    if ($sub->GetID() != $first) { //Make sure its not the first place submission
                        $person_obj = $sub->GetPerson();
                        $new_creds[$person_obj->GetID()] = $rewards[$i];
                    }
                }
            }
            //No efforts
            $subs = $grade_obj->GetCorrect(0, 0);
            for ($j = 0; $j < count($subs); $j++) {
                $sub = $subs[$j];
                $person_obj = $sub->GetPerson();
                $new_creds[$person_obj->GetID()] = 0;
            }
            /**--Sets credit amounts for new grades--*End*/

            /**--Finds change between old and new credit amounts--*Start*/
            $old_keys = array_keys($old_creds);
            $new_keys = array_keys($new_creds);
            foreach ($old_keys as $key) { //For all the old creds ids, finds change
                $change_creds[$key] = $new_creds[$key] - $old_creds[$key];
            }
            unset($key);
            foreach ($new_keys as $key) { //For all the new creds ids, finds change.
                                          //This round is done to prevent any keys from not being accounted for.
                $change_creds[$key] = $new_creds[$key] - $old_creds[$key];
            }
            unset($key);
            /**--Finds change between old and new credit amounts--*End*/

            /**--Awards change between old and new credit amounts--*Start*/
            $grbody = array();
            $grheader = array('<b><i>Credit Changes</i></b><br />');
            $change_keys = array_keys($change_creds);
            foreach ($change_keys as $key) {
                $person_obj = new Person($key, $this->roster_coder);
                if ($change_creds[$key] != 0) {
                    if (!$person_obj->AddCredits($change_creds[$key], 'Credit changes in '.$hunt_type->GetName()." ".$this->GetHuntNum())) {
                        $error = 'Error awarding credits. '.$person_obj->Error();
                    }
                    $grbody[] = array($person_obj->GetName().'\'s credits changed by '.number_format($change_creds[$key]).' ICs.');
                } else {
                    $grbody[] = array($person_obj->GetName().'\'s credits did not change.');
                }
            }
            $table = new HTML_Table();
            $table->addrow( $grheader,
                            array(),
                            'TH');
            if (count($grbody) > 0) {
                for ($j = 0; $j < count($grbody); $j++) {
                    $table->addrow($grbody[$j]);
                }
            } else {
                $table->addrow(array('-Nobody submitted, nobody was awarded anything-'), $center_attr);
            }
            print $table->toHTML(); //Print out changes
            /**--Awards change between old and new credit amounts--*End*/

            return $error;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return "No access to the function, coder id was not initialized.";
        }
    }

    /**
     * Deletes this hunt and its grades.
     * @return True|string True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function RemoveHunt () {
        $hunt_division = mysql_result(@mysql_query("SELECT `hunt_division` FROM `hunts` WHERE `hunt_id` = '$this->hunt_id'", $this->ka_db), 0, 'hunt_division');
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            $result = true;
            if (!@mysql_query("DELETE FROM `hunts` WHERE `hunt_id` = '".$this->hunt_id."' LIMIT 1", $this->ka_db)) $result = mysql_error($this->ka_db)." while deleting Hunt.";
            if (!@mysql_query("DELETE FROM `hunt_grades` WHERE `hunt_id` = '".$this->hunt_id."'", $this->ka_db)) $result = mysql_error($this->ka_db)." while deleting grades.";
            if (!@mysql_query("DELETE FROM `hunt_submissions` WHERE `submission_hunt` = '".$this->hunt_id."'", $this->ka_db)) $result = mysql_error($this->ka_db)." while deleting submissions.";
            return $result;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }
}

?>

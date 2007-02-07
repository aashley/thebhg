<?php
/**
 * Require code
 *
 * Includes all the required files and contains most of the main functions.
 *
 *  <pre>Date      Version        Summary
 *
 *  20031214  1.1.0          Completed Credit and Grade changing functions.
 *  20031214  1.0.1          Added Get functions, fixed argument order error in RenderStats().
 *  20031210  1.0.0          First official documentation release. Added in coder id security.</pre>
 *
 * @package KA
 * @version 1.1.0 Taste of Nirvana
 * @copyright Copyright © 2003 SyNthetiC PaRadoX. Licensed for use by
 *            the Emperor's Hammer.
 * @author Rewritten and completed by SyNthetiC PaRadoX <synthparadox@thebhg.org>
 * @author Code started by Khylari <Khylari@cox.net>
 * @since The Very Beginning. August 18, 2003.
 */

/**
 * KA class
 *
 * This is the main object to include, will automatically include all other needed files.
 *
 * <pre>Hierarchy
 *  <b><i>KA</i></b>
 *  |-- Hunt
 *  |   |--Grades
 *  |   `--Submission
 *  `-- Hunt Type</pre>
 * @package KA
 * @access public
 * @copyright Copyright © 2003 SyNthetiC PaRadoX. Licensed for use by
 *            the Emperor's Hammer.
 * @author SyNthetiC PaRadoX <synthparadox@thebhg.org>
 * @version 1.1.0 Taste of Nirvana
 * @since The Very Beginning. August 18, 2003.
 */
class KA extends BHGObject {
    /**
     * Global KA Database Resource
     *
     * @var resource $ka_db The Global KA database resource.
     * @access private
     */
    var $ka_db;

    /**
     * KA class constructor, connects to the KA database
     *
     * Makes initial connection to the KA MySQL database and calls the BHGObject constructor
     *
     * @param string $coder Coder id. Must be provided to use create and edit functions.
     * @return void
     * @access public
     * @since v. 1.0.0
     */
    function KA ($coder = '') {
        $this->BHGObject($coder); //Setting coder id
        $dbi["host"] = "localhost";   //MySQL host
        $dbi["user"] = "tactician";   //MySQL username
        $dbi["pass"] = "thidrithow";   //MySQL password
        $dbi["name"] = "tactician";   //MySQL database name
        $this->ka_db = @mysql_connect ($dbi["host"], $dbi["user"], $dbi["pass"]) or $this->roster_error = "Can't connect to database. ".mysql_error($this->ka_db);
        @mysql_select_db ($dbi["name"]) or $this->roster_error = "Can't select database. ".mysql_error($this->ka_db);
    }

    /**
     * Gets a hunt.
     *
     * Mostly used if coder id is not known or if use of coder id not wanted.
     *
     * @param int $hunt_id Hunt ID number
     * @return Hunt Hunt with the hunt id given.
     * @access public
     * @since v. 1.0.1
     */
    function GetHunt($hunt_id) {
        return new Hunt($hunt_id, $this->roster_coder);
    }

    /**
     * Gets a hunt type.
     *
     * Mostly used if coder id is not known or if use of coder id not wanted.
     *
     * @param int $type_id Hunt Type ID number
     * @return Hunt_Type Hunt Type with the type id given.
     * @access public
     * @since v. 1.0.1
     */
    function GetHuntType($type_id) {
        return new Hunt_Type($type_id, $this->roster_coder);
    }

    /**
     * Gets a submission.
     *
     * Mostly used if coder id is not known or if use of coder id not wanted.
     *
     * @param int $sub_id Submission ID number
     * @return Submission Submission with the submission id given.
     * @access public
     * @since v. 1.0.1
     */
    function GetSubmission($sub_id) {
        return new Submission($sub_id, $this->roster_coder);
    }

    /**
     * Creates a new hunt
     *
     * Requires coder id to have either 'allhunts' field, or the 'hunts' field and is adding a hunt for his/her own division
     *
     * @param int $hunt_type The Hunt Type ID number that this hunt is a part of
     * @param int $hunt_division The Division ID number that this hunt will be available for.
     * @param array $hunt_rewards An array of all the awards.
     * @param string $hunt_content A serialized array of hunt information
     * @param int $hunt_start_timestamp UNIX Timestamp of when this hunt starts
     * @param int $hunt_end_timestamp UNIX Timestamp of when this hunt ends
     * @param int $hunt_first First place award for a hunt. Optional, defaults to 0.
     * @return Hunt|false The newly created Hunt object or false if unsuccessful
     * @access protected
     * @since Pre-1.0.0
     * @uses BHGObject::Allowed()
     * @uses KA::CheckDivision()
     */
    function CreateHunt ($hunt_type, $hunt_division, $hunt_rewards, $hunt_content, $hunt_start_timestamp, $hunt_end_timestamp, $hunt_first = 0) {
        if (($this->Allowed('allhunts') == true) || (($this->Allowed('hunts') == true) && ($this->CheckDivision($hunt_division) == true))) {
            $rewards = serialize($hunt_rewards);
            $hunt_content = base64_encode($hunt_content);
            $next = (@mysql_result (@mysql_query ("SELECT MAX(`hunt_num`) AS `num` FROM `hunts` WHERE `hunt_type` = $hunt_type AND `hunt_division` = $hunt_division;", $this->ka_db), 0, "num") + 1);
            if (@mysql_query ("INSERT INTO `hunts` (`hunt_type`, `hunt_num`, `hunt_division`, `hunt_first`, `hunt_rewards`, `hunt_content`, `hunt_start_timestamp`, `hunt_end_timestamp`) VALUES ('$hunt_type', '$next', '$hunt_division', '$hunt_first', '$rewards', '$hunt_content', '$hunt_start_timestamp', '$hunt_end_timestamp');", $this->ka_db)) {
                return new Hunt (@mysql_insert_id ($this->ka_db), $this->roster_coder);
            } else {
                $this->roster_error = "Error adding hunt. ".mysql_error($this->ka_db);
                return false;
            }
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Creates a new Hunt type.
     *
     * Requires 'allhunts' access
     *
     * @param string $type_name The Name of the Hunt type.
     * @param string $type_abbr The Abbreviation for the hunt type. Used in naming files.
     * @param array $type_reward An array of rewards, from most rewards to least.
     * @param array $type_kabal_reward An array of kabal hunt rewards, from most rewards to least.
     * @param int $num_questions The number of questions this hunt type has.
     * @param int $num_answers The number of answers this hunt type has.
     * @param string $question_type Is a string describing the type of questions the hunt uses. Can be 'text' or 'picture'.
     * @param string $desc Description of the Hunt Type.
     * @param int $type_first_reward The reward for the optional first place.
     * @param int $type_kabal_first_reward The kabal hunts reward for the optional first place.
     * @return Hunt_Type|false Returns the newly created hunt type or false if unsuccessful.
     * @since Pre-1.0.0
     * @access protected
     * @uses BHGObject::Allowed()
     */
    function CreateHunt_Type ($type_name, $type_abbr, $type_reward, $type_kabal_reward, $num_questions, $num_answers, $question_type, $desc, $type_first_reward = 0, $type_kabal_first_reward = 0) {
        if ($this->Allowed('allhunts') == true) {
            $rewards = serialize($type_reward);
            $kabal_rewards = serialize($type_kabal_reward);
            if (@mysql_query ("INSERT INTO `hunt_types` (`type_name`, `type_abbr`, `type_first_reward`, `type_reward`, `num_questions`, `num_answers`, `question_type`, `desc`, `type_kabal_first_reward`, `type_kabal_reward`) VALUES ('$type_name', '$type_abbr', '$type_first_reward', '$rewards', '$num_questions', '$num_answers', '$question_type', '$desc', '$type_kabal_first_reward', '$kabal_rewards')", $this->ka_db)) {
                return new Hunt_Type (@mysql_insert_id ($this->ka_db), $this->roster_coder);
            } else {
                $this->roster_error = "Error adding hunt type. ".mysql_error($this->ka_db);
                return false;
            }
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Gets an array of Hunt Types in alphabetical order.
     *
     * @return array An array of Hunt Type objects.
     * @access public
     * @since Pre-1.0.0
     */
    function GetHuntTypes () {
        $hunttypes = array ();
        $result = @mysql_query ("SELECT `type_id` FROM `hunt_types` ORDER BY `type_name` ASC", $this->ka_db);
        while ($row = @mysql_fetch_array ($result))
            $hunttypes [] = new Hunt_Type ($row["type_id"], $this->roster_coder);
        return $hunttypes;
    }

    /**
     * Gets an array of Hunt objects that are currently active under the hunt type.
     * @param int $hunt_type The Hunt Type ID to check.
     * @param int $division Optional division to check.
     * @param boolean $no_all Don't add hunts that are availiable to everyone. Only applies when $division is specified.
     * @return array An array of hunts that matches the Hunt Type ID and optionally, the division and are still active.
     * @deprecated deprecated since 1.0.0, you should be using the GetHunts method
     * @see KA::GetHunts()
     */
    function GetActiveHunts ($hunt_type, $division = '-1', $no_all = false) {
        if (($division == 10) || ($division == 9)) $division = -1; //Sets division to all for commission and commission assistants
        $hunts = array ();

        $sql = "SELECT `hunt_id` FROM `hunts` WHERE ";
        if ($hunt_type != '-1') $sql .= "`hunt_type` = $hunt_type AND ";
        $sql .= "`hunt_start_timestamp` < " . time() . " AND `hunt_end_timestamp` > " . time();
        if ($division != '-1') {
            if ($no_all === false)
                $sql .= " AND (`hunt_division` = ".$division." OR `hunt_division` = -1)";
            else
                $sql .= " AND `hunt_division` = ".$division;
        }
        else $sql .= " AND `hunt_division` = -1";
        $sql .= " ORDER BY `hunt_end_timestamp` ASC, `hunt_start_timestamp` ASC, `hunt_num` ASC";

        $result = @mysql_query ($sql, $this->ka_db);
        while ($row = @mysql_fetch_array ($result)) {
            $hunts[] = new Hunt ($row["hunt_id"], $this->roster_coder);
        }
        return $hunts;
    }

    /**
     * Gets an array of Hunt objects that will take place in the future under the hunt type.
     * @param int $hunt_type The Hunt Type ID to check (-1 = all).
     * @param int $division Optional division to check.
     * @param boolean $no_all Don't add hunts that are availiable to everyone. Only applies when $division is specified.
     * @return array An array of hunts that matches the Hunt Type ID and optionally, the division and take place in the future.
     * @deprecated deprecated since 1.0.0, you should be using the GetHunts method
     * @see KA::GetHunts()
     */
    function GetFutureHunts ($hunt_type, $division = '-1', $no_all = false) {
        if (($division == 10) || ($division == 9)) $division = -1; //Sets division to all for commission and commission assistants
        $hunts = array ();

        $sql = "SELECT `hunt_id` FROM `hunts` WHERE ";
        if ($hunt_type != '-1') $sql .= "`hunt_type` = $hunt_type AND ";
        $sql .= "`hunt_start_timestamp` > " . time() . " AND `hunt_end_timestamp` > " . time();
        if ($division != '-1') {
            if ($no_all === false)
                $sql .= " AND (`hunt_division` = ".$division." OR `hunt_division` = -1)";
            else
                $sql .= " AND `hunt_division` = ".$division;
        }
        else $sql .= " AND `hunt_division` = -1";
        $sql .= " ORDER BY `hunt_end_timestamp` DESC, `hunt_start_timestamp` DESC, `hunt_num` DESC";

        $result = @mysql_query ($sql, $this->ka_db);
        while ($row = @mysql_fetch_array ($result)) {
            $hunts[] = new Hunt ($row["hunt_id"], $this->roster_coder);
        }
        return $hunts;
    }

    /**
     * Gets an array of Hunt objects that have all passed.
     * @param int $hunt_type The Hunt Type ID to check (-1 = all).
     * @param int $division Optional division to check.
     * @param boolean $no_all Don't add hunts that are availiable to everyone. Only applies when $division is specified.
     * @param int $start UNIX timestamp that limits the number of hunts returned by end date, must be after this timestamp.
     * @param int $end UNIX timestamp that limits the number of hunts returned by end date, must be before this timestamp.
     * @return array An array of hunts that matches the optional division and has passed.
     * @deprecated deprecated since 1.0.0, you should be using the GetHunts method
     * @see KA::GetHunts()
     */
    function GetPastHunts ($hunt_type, $division = -1, $no_all = false, $start = 0, $end = 0) {
        if (($division == 10) || ($division == 9)) $division = -1; //Sets division to all for commission and commission assistants
        $hunts = array ();

        $sql = "SELECT `hunt_id` FROM `hunts` WHERE ";
        if ($hunt_type != '-1') $sql .= "`hunt_type` = $hunt_type AND ";
        $sql .= "`hunt_start_timestamp` < '" . time() . "' AND `hunt_end_timestamp` < '" . time() . "'";
        if ($start != 0) $sql .= " AND `hunt_end_timestamp` > '" . $start . "'";
        if ($end != 0) $sql .= " AND `hunt_end_timestamp` < '" . $end . "'";
        if ($division != '-1') {
            if ($no_all === false)
                $sql .= " AND (`hunt_division` = ".$division." OR `hunt_division` = -1)";
            else
                $sql .= " AND `hunt_division` = ".$division;
        }
        else $sql .= " AND `hunt_division` = -1";
        $sql .= " ORDER BY `hunt_end_timestamp` DESC, `hunt_start_timestamp` DESC, `hunt_num` DESC";

        $result = @mysql_query ($sql, $this->ka_db);
        while ($row = @mysql_fetch_array ($result)) {
            $hunts[] = new Hunt ($row["hunt_id"], $this->roster_coder);
        }
        return $hunts;
    }

    /**
     * Gets an array of Hunt objects that match all the conditions.
     *
     * @param string $tstype Uses this to determine which timestamp to compare. One of the following values: 'start', 'end', 'none'. Case insensitive.
     * @param string $status One of the following: 'all' 'future' 'past' 'active'.
     * @param int $hunt_type The Hunt Type ID to check (-1 = all).
     * @param int $division Optional division to check. (-1 = all).
     * @param boolean $no_all Don't add hunts that are availiable to everyone. Only applies when $division is specified.
     * @param int $start Optional UNIX timestamp of start of interval to check
     * @param int $end Optional UNIX timestamp of end of interval to check
     * @return array An array of hunts that matches start time, end time, optionally the hunt type and the optional division.
     * @access public
     * @since 1.0.0
     */
    function GetHunts ($tstype = 'end', $status = 'all', $hunt_type = -1, $division = -1, $no_all = false, $start = 0, $end = 0) {
        if (($division == 10) || ($division == 9)) $division = -1; //Sets division to all for commission and commission assistants

        //Makes string options lowercase
        $tstype = strtolower($tstype); //Makes the timestamp type lowercase
        $status = strtolower($status); //Makes the status selector lowercase

        if (($tstype != 'start') && ($tstype != 'end')) {
            $start = 0;
            $end = 0;
        }

        $hunts = array(); //Final array to store hunts

        $sql = "SELECT `hunt_id` FROM `hunts` WHERE ";
        if ($hunt_type != '-1') {
            $sql .= "`hunt_type` = '$hunt_type' AND ";
        }
        switch ($status) {

            case 'active':
            $sql .= "`hunt_start_timestamp` < " . time() . " AND `hunt_end_timestamp` > " . time() . " AND ";
            break;

            case 'future':
            $sql .= "`hunt_start_timestamp` > " . time() . " AND `hunt_end_timestamp` > " . time() . " AND ";
            break;

            case 'past':
            $sql .= "`hunt_start_timestamp` < " . time() . " AND `hunt_end_timestamp` < " . time() . " AND ";
            break;

            default:
            $status = 'all';
        }

        if (($start != 0) && (($status == 'all') || ($status == 'past')))
            $sql .= "`hunt_".$tstype."_timestamp` >= '" . $start . "' AND ";
        if (($end != 0) && (($status == 'all') || ($status == 'past')))
            $sql .= "`hunt_".$tstype."_timestamp` <= '" . $end . "' AND ";
        if ($division != '-1') {
            if ($no_all === false)
                $sql .= "(`hunt_division` = ".$division." OR `hunt_division` = -1)";
            else
                $sql .= "`hunt_division` = ".$division;
        }
        else $sql .= "`hunt_id` > 0";
        $sql .= " ORDER BY `hunt_end_timestamp` DESC, `hunt_start_timestamp` DESC, `hunt_num` DESC";

        $result = @mysql_query ($sql, $this->ka_db);
        while ($row = @mysql_fetch_array ($result)) {
            $hunts[] = new Hunt ($row["hunt_id"], $this->roster_coder);
        }
        return $hunts;
    }

    /**
     * Gets an array of all the filenames matching a certain type in a certain path.
     *
     * Requires 'hunts' flag for the coder id.
     *
     * @param string $path The path to check
     * @param string $checktype The type of hunt picture to check.
     * @return array An array of filenames matching the type.
     * @access protected
     * @since Pre-1.0.0
     */
    function GetDirFiles($path, $checktype) {
        if ($this->Allowed('allhunts') || $this->Allowed('hunts')) {
            $files_arr = array();
            if ($handle = opendir($path)) {
                while ($file = readdir($handle)) {
                    $filearray = explode("-", $file);
                    $filecheck = $filearray[0];
                    if (($file != ".") AND ($file != "..") AND ($filecheck == $checktype))
                        $files_arr[] = trim($file);
                }

                closedir($handle);
            }

            return $files_arr;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Gets all the submissions the hunter's id has submitted.
     *
     * @param int $id Hunter's ID number to check
     * @param int $start Optional start interval to check. UNIX timestamp.
     * @param int $end Optional end interval to check. UNIX timestamp.
     * @return array An array of Submission objects belonging to the hunter specified.
     * @access public
     * @since Pre-1.0.0
     */
    function GetAllSubmissions($id, $start = 0, $end = 0) {
        $subs = array();

        $sql = "SELECT `submission_id` FROM `hunt_submissions` WHERE ";
        $sql .= "`submission_person` = '$id'";
        if ($start != 0)
            $sql .= " AND `submission_timestamp` > '" . $start . "'";
        if ($end != 0)
            $sql .= " AND `submission_timestamp` < '" . $end . "'";
        $sql .= " ORDER BY `submission_timestamp` DESC, `submission_hunt` DESC";

        $result = @mysql_query ($sql, $this->ka_db);
        while ($row = @mysql_fetch_array ($result)) {
            $subs[] = new Submission($row["submission_id"], $this->roster_coder);
        }

        return $subs;
    }

    /**
     * Checks to see if this person has access
     *
     * @param int $id ID number of person to check.
     * @return int 0 for no access, 1 for CH/CRA/WARD access, 2 for full admin access
     * @access public
     * @since Pre-1.0.0
     * @uses Person::GetPosition()
     * @uses Position::GetID()
     */
    function HasAccess ($id) {
        $person = new Person($id, $this->roster_coder);
        $position = $person->GetPosition();
        $sql = "SELECT `id` FROM `assistant` WHERE `person` = $id AND `date_deleted` = 0 AND `hunts` = 1";
        $query = mysql_query($sql, $this->ka_db);
        if (mysql_num_rows($query) > 0) return 2;
        if (in_array($position->GetID(), array (2, 3, 10)) || $id == 94) {
            return 2;
        }
				if (in_array($position->GetID(), array (11, 12))) {
            return 1;
        }
        return 0;
    }

    /**
     * Renders some stats.
     *
     * @param int $div_id Division ID
     * @param int $start Optional UNIX timestamp of start of interval to check
     * @param int $end Optional UNIX timestamp of end of interval to check
     * @return void
     * @access public
     * @uses Hunt::IsGraded()
     * @uses Roster::GetDivisions()
     * @uses Division::Division()
     * @uses Division::GetID()
     * @uses Division::IsKabal()
     * @uses Hunt::GetHuntType()
     * @uses Hunt::GetHuntFirst()
     * @uses Hunt::GetHuntRewards()
     * @uses Grades::GetCorrect()
     * @uses Hunt_Type::GetNumAnswers()
     * @uses Submission::GetID()
     * @uses Hunt::GetHuntFirst()
     * @uses Hunt::GetDivisionID()
     */
    function RenderStats($div_id, $start = 0, $end = 0) {
        if ($div_id == -1) {
            //Overall stats
            $roster = new Roster($this->roster_coder);
            $divisions = $roster->GetDivisions();
            $table = new HTML_Table();
            $tblcapt = "Total credits awarded per division";
            $table->AddRow(array("<b><i>For the month of ".date('M, Y', $end).":</i></b>"));
            foreach ($divisions as $division_obj) {
                if ($division_obj->IsKabal()) {
                    $hunts = $this->GetHunts("end", 'all', -1, $division_obj->GetID(), true, $start, $end);
                    $total = 0;
                    foreach ($hunts as $hunt) {
                        unset($first);
                        $grade_obj = $hunt->IsGraded();
                        if ($grade_obj != false) {
                            $hunt_type = $hunt->GetHuntType();
                            $rewards = $hunt->GetHuntRewards();
                            if ($hunt->GetHuntFirst()) {
                                //Find the first place submission in the grades array
                                $full = $grade_obj->GetCorrect($hunt_type->GetNumAnswers());
																if ($full === false)
																	print $grade_obj->roster_error.' '.$grade_obj->roster_coder;
                                if (count($full) > 0 && array_key_exists(0, $full)) {
                                    $first = $full[0]->GetID();
                                }
                                if (isset($first)) {
                                    $total += $hunt->GetHuntFirst();
                                }
                            }
                            //Recurses through all the grades. From full points (total/total) to no points (0/total)
                            for($i = 0; $i <= $hunt_type->GetNumAnswers(); $i++) {
                                $num = $hunt_type->GetNumAnswers() - $i;
                                $subs = $grade_obj->GetCorrect($num, 1);
                                for ($j = 0; $j < count($subs); $j++) {
                                    $sub = $subs[$j];
                                    if ($sub->GetID() != $first) { //Make sure its not the first place submission
                                        $total += $rewards[$i];
                                    }
                                }
                            }
                        }
                    }
                    $table->AddRow(array("Total credits awarded for ".$division_obj->GetName()." was: ".number_format($total)." ICs.<br />\n"));
                }
            }
            $table->SetCaption($tblcapt);
            echo $table->ToHTML();
            $table = new HTML_Table();
            $tblcapt = "Other Random Statistics";
            $sql = "SELECT `submission_id` FROM `hunt_submissions` WHERE 1";
            $result = @mysql_query($sql, $this->ka_db);
            $table->AddRow(array("There have been a total of ".number_format(mysql_num_rows($result))." summaries of the Tactician and Kabal bounties."));

            $table->SetCaption($tblcapt);
            echo $table->ToHTML();
        } else {
            $div = new Division($div_id, $this->roster_coder);
            $div = $div->GetName();

            //Variables for overall stats
            $hunts = array(); //Array of all hunts in this division
            $subs_counter = 0; //Submissions counter
            $hunt_counter = 0; //Hunts counter
            $total = 0; //Total ICs accumulator
            //Variables for monthly stats
            $s_month_count = 0;
            $h_month_count = 0;
            $month_total = 0;

            $sql = "SELECT * FROM `hunt_submissions` WHERE 1";
            $result = @mysql_query($sql, $this->ka_db);
            while ($row = @mysql_fetch_array($result)) {
                $hunt = new Hunt($row['submission_hunt'], $this->roster_coder);
                if ($hunt->GetDivisionID() == $div_id) {
                    $subs_counter++;
                    if (($row['submission_timestamp'] >= $start) && ($row['submission_timestamp'] <= $end)) $s_month_count++;
                }
            }
            $hunts = $this->GetHunts("none", 'all', -1, $div_id, 0, 0, true);
            foreach ($hunts as $hunt) {
                $hunt_counter++;
                if (($hunt->GetEndTimestamp() >= $start) && ($hunt->GetEndTimestamp() <= $end)) $h_month_count++;
                unset($first);
                $grade_obj = $hunt->IsGraded();
                if ($grade_obj != false) {
                    $hunt_type = $hunt->GetHuntType();
                    $rewards = $hunt->GetHuntRewards();
                    if ($hunt->GetHuntFirst()) {
                        //Find the first place submission in the grades array
                        $full = $grade_obj->GetCorrect($hunt_type->GetNumAnswers());
                        if (isset($full[0])) $first = $full[0]->GetID();
                        if (isset($first)) {
                            $total += $hunt->GetHuntFirst();
                            if (($hunt->GetEndTimestamp() >= $start) && ($hunt->GetEndTimestamp() <= $end)) $month_total += $hunt->GetHuntFirst();
                        }
                    }
                    //Recurses through all the grades. From full points (total/total) to no points (0/total)
                    for($i = 0; $i <= $hunt_type->GetNumAnswers(); $i++) {
                        $num = $hunt_type->GetNumAnswers() - $i;
                        $subs = $grade_obj->GetCorrect($num, 1);
                        for ($j = 0; $j < count($subs); $j++) {
                            $sub = $subs[$j];
                            if ($sub->GetID() != $first) { //Make sure its not the first place submission
                                $total += $rewards[$i];
                                if (($hunt->GetEndTimestamp() >= $start) && ($hunt->GetEndTimestamp() <= $end)) $month_total += $rewards[$i];
                            }
                        }
                    }
                }
            }

            //Per month stats
            $table = new HTML_Table();
            $table->SetCaption(date('M, Y', $start)." Statistics for ".$div);
            $table->AddRow(array("There were/have been: ".$s_month_count." summaries."));
            $table->AddRow(array($div." has a total of: ".$h_month_count." bounties."));
            if (($start <= time()) && (time() <= $end)) { //The month is this month
                $table->AddRow(array("&nbsp; &nbsp; ".count($this->GetHunts('none', 'active', -1, $div_id, true))." of them are active."));
                $table->AddRow(array("&nbsp; &nbsp; ".count($this->GetHunts('none', 'future', -1, $div_id, true))." of them haven't begun yet."));
                $table->AddRow(array("&nbsp; &nbsp; ".count($this->GetHunts('end', 'past', -1, $div_id, true, $start, $end))." of them are past bounties."));
            } elseif (($start >= time()) && (time() <= $end)) { //Future
                $table->AddRow(array("&nbsp; &nbsp; There are ".count($this->GetHunts("start", 'all', -1, $div_id, true, $start, $end))." bounties this month."));
            } elseif (($start <= time()) && (time() >= $end)) { //Past
                $table->AddRow(array("&nbsp; &nbsp; There were ".count($this->GetHunts("end", 'all', -1, $div_id, true, $start, $end))." bounties this month."));
            }
            $table->AddRow(array("Total credits awarded for ".$div." are: ".number_format($month_total)." ICs."));
            echo $table->ToHTML();

            //Overall stats
            $table = new HTML_Table();
            $table->SetCaption("Overall Statistics for ".$div);
            $table->AddRow(array("There have been: ".$subs_counter." summaries."));
            $table->AddRow(array($div." has a total of: ".$hunt_counter." bounties."));
            $table->AddRow(array("&nbsp; &nbsp; ".count($this->GetHunts('none', 'active', -1, $div_id, true))." of them are active."));
            $table->AddRow(array("&nbsp; &nbsp; ".count($this->GetHunts('none', 'future', -1, $div_id, true))." of them haven't begun yet."));
            $table->AddRow(array("&nbsp; &nbsp; ".count($this->GetHunts('none', 'past', -1, $div_id, true))." of them are past bounties."));
            $table->AddRow(array("Total credits awarded for ".$div." are: ".number_format($total)." ICs."));
            echo $table->ToHTML();
        }
    }

    /**
     * Compares the coder id with the division id given to check if they are the same division.
     *
     * Not available for public use.
     * @internal Be sure to update the division ids with the coder ids. Make sure to make them correspond.
     * @param int $div_id Division ID to check
     * @return boolean True or False
     * @access private
     * @since 1.0.0
     */
    function CheckDivision($div_id) {
        $rowid = $this->GetCoderID($this->roster_coder);
        $div_arr = array(     //Division id array
            0 => 17,
            1 => 3,
            2 => 4,
            3 => 8,
            4 => 15,
            5 => 2,
            6 => 13
        );
        $row_arr = array(     //Corresponding coder id row id array
            0 => 29,
            1 => 30,
            2 => 31,
            3 => 32,
            4 => 33,
            5 => 34,
            6 => 35
        );
        $tofind = array_search($div_id, $div_arr);
        if ($tofind === false) {
            return false; //The division id passed was not in division array
        }
        if ($row_arr[$tofind] == $rowid) {
            return true;  //The division id passed matches the coder id's division
        } else {
            return false; //The division id passed does not match the coder id's division
        }
    }
}

/**
 * The actual including of files.
 * @access private
 */
require_once('hunts/hunt.inc');
require_once('hunts/hunt_type.inc');
require_once('hunts/submission.inc');
require_once('hunts/grades.inc');

?>

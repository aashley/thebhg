<?php
/**
 * Defines functions to maintain the hunt types
 *
 *  <pre>Date      Version        Summary
 *
 *  20031210  1.0.0          First official documentation release. Added in coder id security.</pre>
 *
 * @package KA
 * {@inheritdoc }
 */

/**
 * Contains the Hunt Type functions
 *
 * <pre>Hierarchy
 *  KA
 *  |-- Hunt
 *  |   |--Grades
 *  |   `--Submission
 *  |-- <b><i>Hunt Type</i></b>
 *  `-- Season</pre>
 * @access public
 * {@inheritdoc }
 * @package KA
 */
class Hunt_Type extends KA {
    /**
     * @var int $type_id This is just the type ID number of the hunt type.
     * @access private
     */
    var $type_id;
    /**
     * @var array $hunttype_arr The array of all the variables concerning this hunt type.
     * @access private
     */
    var $hunttype_arr;
    /**
     * Constructor for Hunt Type class. Just sets the information array.
     * @param int $type_id ID number for the hunt type
     * @return void
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function Hunt_Type ($type_id, $coder) {
        $this->KA($coder);
        $result = @mysql_query ("SELECT * FROM `hunt_types` WHERE `type_id` = '".$type_id."'", $this->ka_db);
        $this->hunttype_arr = @mysql_fetch_array($result);
        $this->type_id = $this->hunttype_arr['type_id'];
    }

    /**
     * Gets the ID of the Hunt Type
     * @return int The ID number of the Hunt Type
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetID () {
        return $this->hunttype_arr['type_id'];
    }

    /**
     * Get the name of the Hunt Type
     * @return string The Hunt Type's name
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetName () {
        return $this->hunttype_arr['type_name'];
    }

    /**
     * Get the abbreviation of the Hunt Type
     * @return string The Hunt Type's abbreviation
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetAbbr () {
        return $this->hunttype_arr['type_abbr'];
    }

    /**
     * Gets the reward for first
     * @return int|false It'll either return false or a integer, depending on if this is set.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetFirstReward () {
        if ($this->hunttype_arr['type_first_reward'] != 0)
            return $this->hunttype_arr['type_first_reward'];
        else
            return false;
    }

    /**
     * Gets the array of rewards
     * @return array Array of rewards, in order of # correct, starts with all correct, ends with 0 correct (incorrect).
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetReward () {
        return unserialize($this->hunttype_arr['type_reward']);
    }

    /**
     * Gets the kabal reward for first
     * @return int|false It'll either return false or a integer, depending on if this is set.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetKabalFirstReward () {
        if ($this->hunttype_arr['type_kabal_first_reward'] != 0)
            return $this->hunttype_arr['type_kabal_first_reward'];
        else
            return false;
    }

    /**
     * Gets the array of rewards for kabal hunts
     * @return array Array of rewards, in order of # correct, starts with all correct, ends with 0 correct (incorrect).
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetKabalRewards () {
        return unserialize($this->hunttype_arr['type_kabal_reward']);
    }

    /**
     * Gets the number of questions this hunt type has
     * @return int Number of questions this hunt type has
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetNumQuestions() {
        return $this->hunttype_arr['num_questions'];
    }

    /**
     * Gets the number of answers this hunt type has
     * @return int Number of answers this hunt type has
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetNumAnswers() {
        return $this->hunttype_arr['num_answers'];
    }

    /**
     * Gets the question type this hunt type has
     * @return string A string describing the type of question this hunt type uses (picture or text)
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetQuestionType() {
        return $this->hunttype_arr['question_type'];
    }

    /**
     * Gets the description of the hunt type
     * @return string A string description of the hunt type.
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetDesc() {
        return $this->hunttype_arr['desc'];
    }

    /**
     * Gets an array of Hunts all belonging to this Hunt_Type
     * @return array An array of Hunt objects
     * @uses Hunt::Hunt()
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetAllHunts () {
        $hunts = array ();
        $result = @mysql_query ("SELECT `hunt_id` FROM `hunts` WHERE `hunt_type` = '".$this->type_id."' ORDER BY `hunt_end_timestamp` DESC", $this->ka_db);
        while ($row = @mysql_fetch_array ($result))
        $hunts[] = new Hunt ($row["hunt_id"], $this->roster_coder);
        return $hunts;
    }

    /**
     * Gets the number of hunts belonging to this Hunt_Type
     * @return int The number of hunts in this Hunt_Type
     * @access public
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function GetHuntsCount () {
        return @mysql_result (@mysql_query ("SELECT COUNT(*) AS `num` FROM `hunts` WHERE `hunt_type` = '".$this->type_id."'", $this->ka_db), 0, "num");
    }

    /**
     * Sets the name of the Hunt_Type
     * @param string $type_name New name of Hunt_Type
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetName ($type_name) {
        if ($this->Allowed('allhunts') == true) {
            if (@mysql_query ("UPDATE `hunt_types` SET `type_name` = '".$type_name."' WHERE `type_id` = '".$this->type_id."'", $this->ka_db)) {
                $this->Hunt_Type($this->hunttype_arr['type_id'], $this->roster_coder);
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the abbreviation of the Hunt_Type and attempts to rename all old files if the question type is picture.
     * @param string $type_abbr New abbreviation of Hunt_Type
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetAbbr ($type_abbr) {
        if ($this->Allowed('allhunts') == true) {
            if (@mysql_query ("UPDATE `hunt_types` SET `type_abbr` = '".$type_abbr."' WHERE `type_id` = '".$this->type_id."'", $this->ka_db)) {
                if ($this->hunttype_arr['question_type'] == 'picture') {
                    $path = '/home/virtual/thebhg.org/home/ka/public_html/hunts/hunt_images/';
                    $oldtypeabbr = $this->hunttype_arr['type_abbr'];
                    $this->Hunt_Type($this->hunttype_arr['type_id'], $this->roster_coder);
                    $files = $this->GetDirFiles($path, $oldtypeabbr);
                    foreach ($files as $file) {
                        $num = explode('-', $file);
                        $num = $num[1];
                        $newfile = $type_abbr."-".$num;
                        if (!rename($path.$file, $path.$newfile)) return false;
                    }
                }
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the first place reward of the Hunt_Type
     * @param int $type_first_reward Reward to set for this hunt type.
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetFirstReward ($type_first_reward) {
        if ($this->Allowed('allhunts') == true) {
            if (@mysql_query ("UPDATE `hunt_types` SET `type_first_reward` = '".$type_first_reward."' WHERE `type_id` = '".$this->type_id."'", $this->ka_db)) {
                $this->Hunt_Type($this->hunttype_arr['type_id'], $this->roster_coder);
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the rewards of the Hunt_Type
     * @param array $type_rewards New array of rewards for this hunt type.
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetRewards ($type_rewards) {
        if ($this->Allowed('allhunts') == true) {
            $rewards = serialize($type_rewards);
            if (@mysql_query ("UPDATE `hunt_types` SET `type_reward` = '".$rewards."' WHERE `type_id` = '".$this->type_id."'", $this->ka_db)) {
                $this->Hunt_Type($this->hunttype_arr['type_id'], $this->roster_coder);
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the first place kabal reward for the Hunt_Type
     * @param int $type_first_reward Reward to set for this hunt type.
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetKabalFirstReward ($type_first_reward) {
        if ($this->Allowed('allhunts') == true) {
            if (@mysql_query ("UPDATE `hunt_types` SET `type_kabal_first_reward` = '".$type_first_reward."' WHERE `type_id` = '".$this->type_id."'", $this->ka_db)) {
                $this->Hunt_Type($this->hunttype_arr['type_id'], $this->roster_coder);
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the kabal rewards of the Hunt_Type
     * @param array $type_rewards New array of kabal rewards for this hunt type.
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetKabalRewards ($type_rewards) {
        if ($this->Allowed('allhunts') == true) {
            $rewards = serialize($type_rewards);
            if (@mysql_query ("UPDATE `hunt_types` SET `type_kabal_reward` = '".$rewards."' WHERE `type_id` = '".$this->type_id."'", $this->ka_db)) {
                $this->Hunt_Type($this->hunttype_arr['type_id'], $this->roster_coder);
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the number of questions this Hunt Type should have.
     * @param int $num_questions The number of questions this Hunt Type should have.
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetNumQuestions ($num_questions) {
        if ($this->Allowed('allhunts') == true) {
            if (@mysql_query ("UPDATE `hunt_types` SET `num_questions` = '".$num_questions."' WHERE `type_id` = '".$this->type_id."'", $this->ka_db)) {
                $this->Hunt_Type($this->hunttype_arr['type_id'], $this->roster_coder);
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the number of answers this Hunt Type should have.
     * @param int $num_answers The number of answers this Hunt Type should have.
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetNumAnswers ($num_answers) {
        if ($this->Allowed('allhunts') == true) {
            if (@mysql_query ("UPDATE `hunt_types` SET `num_answers` = '".$num_answers."' WHERE `type_id` = '".$this->type_id."'", $this->ka_db)) {
                $this->Hunt_Type($this->hunttype_arr['type_id'], $this->roster_coder);
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the question type this Hunt Type should be.
     * @param string $question_type The question type this Hunt Type should be. (Either 'picture' or 'text')
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetQuestionType ($question_type) {
        if ($this->Allowed('allhunts') == true) {
            if (@mysql_query ("UPDATE `hunt_types` SET `question_type` = '".$question_type."' WHERE `type_id` = '".$this->type_id."'", $this->ka_db)) {
                $this->Hunt_Type($this->hunttype_arr['type_id'], $this->roster_coder);
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the description of the Hunt Type.
     * @param string $description The description of the Hunt Type
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function SetDesc ($description) {
        if ($this->Allowed('allhunts') == true) {
            if (@mysql_query ("UPDATE `hunt_types` SET `desc` = '".$description."' WHERE `type_id` = '".$this->type_id."'", $this->ka_db)) {
                $this->Hunt_Type($this->hunttype_arr['type_id'], $this->roster_coder);
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Deletes this hunt type.
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since Pre 1.0.0 Unknown Creation Date.
     */
    function Remove () {
        if ($this->Allowed('allhunts') == true) {
            $ok = true;
            $hunts = $this->GetAllHunts();
            foreach ($hunts as $hunt) {
                $ok = $hunt->RemoveHunt();
            }
            if (($ok === true)
             && (@mysql_query ("DELETE FROM `hunt_types` WHERE `type_id` = ".$this->type_id, $this->ka_db))) {
                    return true;
            }
            else return $ok;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }
}

?>

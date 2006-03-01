<?php
/**
 * Season management
 *
 *  <pre>Date      Version        Summary
 *
 *  20040907  1.0.0          First official documentation release. Added in coder id security.</pre>
 *
 * @package KA
 * {@inheritdoc }
 */

/**
 * Controls the Seasons on the KA Ladder.
 *
 * <pre>Hierarchy
 *  KA
 *  |-- Hunt
 *  |   |--Grades
 *  |   `--Submission
 *  |-- Hunt Type
 *  `-- <b><i>Season</b></i></pre>
 * @access public
 * {@inheritdoc }
 * @package KA
 */
class Season extends KA {
    /**
     * @var int $season_id Season ID
     * @access private
     */
    var $season_id;
    /**
     * @var int $season_start Season start timestamp
     * @access private
     */
    var $season_start;
    /**
     * @var int $season_person Season end timestamp
     * @access private
     */
    var $season_stop;
    /**
     * @var int $season_div Division (Kabal) that this season applies to
     * @access private
     */
    var $season_div;

    /**
     * The constructor for the season class. Calls the parent class constructors to set variables, then sets its own.
     * @param int $season_id The Unique ID number of each season.
     * @return void
     * @access public
     * @since v. 1.0.0
     */
    function Season ($season_id, $coder = '') {
        $this->KA($coder);
        $result = @mysql_query ("SELECT * FROM `hunt_seasons` WHERE `season_id` = ".$season_id, $this->ka_db);
        $this->season_id = @mysql_result ($result, 0, "season_id");
        $this->season_start = @mysql_result ($result, 0, "season_start");
        $this->season_stop = @mysql_result ($result, 0, "season_stop");
        $this->season_div = @mysql_result ($result, 0, "season_div");
    }

    /**
     * Gets the Unique ID number of this Season
     * @return int The Unique ID number
     * @access public
     * @since v. 1.0.0
     */
    function GetID () {
        return $this->season_id;
    }

    /**
     * Gets the start timestamp for this season.
     * @return int Start timestamp for this season
     * @access public
     * @since v. 1.0.0
     */
    function GetStart () {
        return $this->season_start;
    }

    /**
     * Gets the end timestamp for this season
     * @return int End timestamp for this season
     * @access public
     * @since v. 1.0.0
     */
    function GetStop () {
        return $this->season_stop;
    }

    /**
     * Gets the Division this season applies to
     * @return Division Division that this season applies to
     * @access public
     * @since v. 1.0.0
     */
    function GetDiv () {
        return new Division($this->season_div, $this->roster_coder);
    }
    
    /**
     * Sets the start time for this season.
     * @param int $start The start timestamp for this season
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since v. 1.0.0
     */
    function SetStart ($start) {
        if ($this->Allowed('allhunts') == true) {
            if (@mysql_query ("UPDATE `hunt_seasons` SET `season_start` = '".$start."' WHERE `season_id` = '".$this->season_id."'", $this->ka_db)) {
                $this->Season($this->season_id, $this->roster_coder);
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }

    /**
     * Sets the end time for this season.
     * @param int $stop The end timestamp for this season
     * @return boolean True for successful, false otherwise.
     * @access protected
     * @since v. 1.0.0
     */
    function SetStop ($stop) {
        if ($this->Allowed('allhunts') == true) {
            if (@mysql_query ("UPDATE `hunt_seasons` SET `season_stop` = '".$stop."' WHERE `season_id` = '".$this->season_id."'", $this->ka_db)) {
                $this->Season($this->season_id, $this->roster_coder);
                return true;
            } else
                return false;
        } else {
            $this->roster_error = "You do not have access to this function.";
            return false;
        }
    }
}

?>
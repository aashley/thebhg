<?php
/**
 * A block to display what happened on this day.
 *
 * @package MyBHG
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @access public
 */
class TimelineBlock extends Block {
	/**#@+
	 * @access private
	 */
	var $html;
	/**#@-*/
	
	function TimelineBlock($id, &$db) {
		global $my_tz;
		
		Block::Block($id, $db);
		$this->title = 'On This Day...';
		$cache_result = mysql_query('SELECT * FROM block_cache WHERE id=' . $id, $db);
		if ($cache_result && mysql_num_rows($cache_result)) {
			putenv('TZ=America/New_York');
			$cache_ymd = date('Ymd', mysql_result($cache_result, 0, 'time'));
			if (date('Ymd') != $cache_ymd) {
				$this->UpdateCache();
			}
			else {
				$this->html = stripslashes(mysql_result($cache_result, 0, 'data'));
			}
			putenv('TZ=' . $my_tz);
		}
		else {
			$this->UpdateCache();
		}
	}

	/**
	 * Returns the block's HTML output suitable for inserting into a MyBHG
	 * page.
	 *
	 * @access public
	 * @return string the HTML output.
	 */
	function GetHTML() {
		return $this->html;
	}

	/**
	 * Updates the block's cache, if it has one.
	 *
	 * @access public
	 */
	function UpdateCache() {
		$years = array();
		$year_output = array();
		$timeline = new Timeline();
		$events = $timeline->GetEventsByDay(date('d'), date('m'));
		$members = $this->GetNewMembers();
		if (count($events) || count($members)) {
			foreach ($events as $event) {
				$years[$event->GetYear()][] = '&bull;&nbsp;' . nl2br($event->GetContent());
			}
			foreach ($members as $year=>$member) {
				foreach ($member as $m) {
					$years[$year][] = $m;
				}
			}
			krsort($years);
			foreach ($years as $year=>$lines) {
				$year_output[] = '<b>' . $year . '</b><br />' . implode('<br />', $lines);
			}
			$this->html = implode('<br /><br />', $year_output);
		}
		else {
			$this->html = 'Nothing happened on this day.';
		}
		
		if (!mysql_query('INSERT INTO block_cache (id, time, data) VALUES (' . $this->id . ', UNIX_TIMESTAMP(), "' . addslashes($this->html) . '")', $this->db)) {
			mysql_query('UPDATE block_cache SET data="' . addslashes($this->html) . '", time=UNIX_TIMESTAMP() WHERE id=' . $this->id, $this->db);
		}
	}

	/**
	 * @access private
	 */
	function GetNewMembers() {
		$roster = new Roster();
		$members = array();
		$result = mysql_query('SELECT id, name, YEAR(date_joined) AS year FROM roster_roster WHERE DAYOFMONTH(date_joined)=DAYOFMONTH(NOW()) AND MONTH(date_joined)=MONTH(NOW()) AND division NOT IN (0,16)', $roster->roster_db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$members[$row['year']][] = '&bull;&nbsp;<a href="http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=' . $row['id'] . '">' . htmlspecialchars(stripslashes($row['name'])) . '</a> joined the BHG.';
			}
		}
		return $members;
	}

	/**
	 * Returns the title of the block.
	 *
	 * @access public
	 * @return string the title.
	 */
	function GetTitle() {
		return $this->title;
	}

	function GetLabel() {
		return '';
	}
}
?>

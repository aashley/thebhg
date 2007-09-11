<?php
/**
 * A class to interface with the BHG Timeline.
 *
 * @access public
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @package Timeline
 */
class Timeline {
	/**#@+
	 * @access private
	 */
	var $db;
	/**#@-*/

	/**
	 * Constructs a new Timeline class. This should be the only constructor
	 * called directly from client code.
	 *
	 * @access public
	 * @param resource db The database connection to use.
	 */
	function Timeline() {
		$this->db = mysql_connect('localhost', 'thebhg', '1IHfHTsAmILMwpP');
		mysql_select_db('holonet', $this->db);
	}

	/**
	 * Returns an array of all timeline categories.
	 *
	 * @access public
	 * @param string sort The order in which to sort the objects. Set to
	 *                    "name" or omit to sort by category name, or "id"
	 *                    to sort by ID.
	 * @return array An array of TLCategory objects.
	 */
	function GetCategories($sort = 'name', $parent = 0) {
		if (is_null($parent)) {
			$where = '';
		} else {
			$where = 'WHERE parent = '.$parent;
		}
		$result = mysql_query('SELECT id FROM timeline_categories ' . $where . ' ORDER BY ' . ($sort == 'id' ? 'id' : 'name') . ' ASC', $this->db);
		$categories = array();
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$categories[] = new TLCategory($row['id'], $this->db);
			}
		}
		return $categories;
	}

	/**
	 * Returns the given timeline category by ID.
	 *
	 * @access public
	 * @param int id The timeline category ID.
	 * @return object TLCategory The requested TLCategory object.
	 */
	function GetCategory($id) {
		return new TLCategory($id, $this->db);
	}

	/**
	 * Returns the given timeline event by ID.
	 *
	 * @access public
	 * @param int id The timeline event ID.
	 * @return object TLEvent The requested TLEvent object.
	 */
	function GetEvent($id) {
		return new TLEvent($id, $this->db);
	}

	/**
	 * Returns all the events in the timeline.
	 *
	 * @access public
	 * @return array An array of TLEvent objects.
	 */
	function GetAllEvents() {
		return $this->GetEventsByTime();
	}

	/**
	 * Returns all the events belonging to a specified category.
	 *
	 * @access public
	 * @param object TLCategory category The category to search for. The
	 *                                   category ID is also acceptable.
	 * @return array An array of TLEvent objects.
	 */
	function GetEventsByCategory($category) {
		$events = array();
		if (is_object($category)) {
			$category = $category->GetID();
		}
		else {
			$category = (int) $category;
		}

		$result = mysql_query("SELECT eid FROM timeline WHERE category LIKE '$category,%' OR category LIKE '%,$category' OR category LIKE '%,$category,%' OR category='$category' ORDER BY yid ASC, mid ASC, did ASC", $this->db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$events[] = new TLEvent($row['eid'], $this->db);
			}
		}
		return $events;
	}

	/**
	 * Returns all the events occuring on the given day.
	 *
	 * @access public
	 * @param int day The day of the month.
	 * @param int month The month.
	 * @return array An array of TLEvent objects.
	 */
	function GetEventsByDay($day, $month) {
		$events = array();
		$result = mysql_query('SELECT eid FROM timeline WHERE did=' . ((int) $day) . ' AND mid=' . ((int) $month), $this->db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$events[] = new TLEvent($row['eid'], $this->db);
			}
		}
		return $events;
	}
	
	/**
	 * Returns all the events between the given times. It should be noted
	 * that only events with a valid timestamp will be returned. Events
	 * occurring before or after the UNIX epoch will need to be returned
	 * with GetAllEvents and manually filtered.
	 *
	 * @access public
	 * @see GetAllEvents
	 * @param int start The timestamp for the start time.
	 * @param int end The timestamp for the end time, or 0 to return events
	 *                to infinity and beyond.
	 * @return array An array of TLEvent objects.
	 */
	function GetEventsByTime($start = 0, $end = 0) {
		$events = array();
		$sql = 'SELECT eid FROM timeline ';
		if ($start && $end) {
			$sql .= 'WHERE did BETWEEN ' . date('j', $start) . ' AND ' . date('j', $end) . ' ';
			$sql .= 'AND mid BETWEEN ' . date('n', $start) . ' AND ' . date('n', $end) . ' ';
			$sql .= 'AND yid BETWEEN ' . date('Y', $start) . ' AND ' . date('Y', $end) . ' ';
		}
		elseif ($start) {
			$sql .= 'WHERE did>=' . date('j', $start) . ' ';
			$sql .= 'AND mid>=' . date('n', $start) . ' ';
			$sql .= 'AND yid>=' . date('Y', $start) . ' ';
		}
		elseif ($end) {
			$sql .= 'WHERE did<=' . date('j', $start) . ' ';
			$sql .= 'AND mid<=' . date('n', $start) . ' ';
			$sql .= 'AND yid<=' . date('Y', $start) . ' ';
		}
		$sql .= 'ORDER BY yid ASC, mid ASC, did ASC';

		$result = mysql_query($sql, $this->db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$events[] = new TLEvent($row['eid'], $this->db);
			}
		}
		return $events;
	}

	/**
	 * Adds an event to the database.
	 *
	 * @access public
	 * @param int day The day of the month the event occurred.
	 * @param int month The month the event occurred.
	 * @param int year The year the event occurred.
	 * @param string content The text describing the event itself.
	 * @param array categories An array of TLCategory objects or category
	 *                         IDs for the category or categories the
	 *                         event falls into. This can be an empty array
	 *                         if no categories are applicable.
	 * @return object TLEvent A TLEvent object for the new event if
	 *                        successful, false on failure.
	 */
	function AddEvent($day, $month, $year, $content, $categories = array()) {
		$cats = array();
		if (count($categories)) {
			foreach ($categories as $cat) {
				if (is_object($cat)) {
					$cats[] = $cat->GetID();
				}
				else {
					$cats[] = (int) $cat;
				}
			}
		}
		if (mysql_query("INSERT INTO timeline (did, mid, yid, content, category) VALUES ($day, $month, $year, \"" . addslashes($content) . '", "' . implode(',', $cats) . '")', $this->db)) {
			return new TLEvent(mysql_insert_id($this->db), $this->db);
		}
		else {
			return false;
		}
	}

	/**
	 * Adds an event to the database with a UNIX timestamp.
	 *
	 * @access public
	 * @param int ts The timestamp the event occurred at.
	 * @param string content The text describing the event itself.
	 * @param array categories An array of TLCategory objects or category
	 *                         IDs for the category or categories the
	 *                         event falls into. This can be an empty array
	 *                         if no categories are applicable.
	 * @return object TLEvent A TLEvent object for the new event if
	 *                        successful, false on failure.
	 */
	function AddEventWithTimestamp($ts, $content, $categories = array()) {
		return $this->AddEvent(date('j', $ts), date('n', $ts), date('Y', $ts), $content, $categories);
	}

	/**
	 * Adds a category to the timeline.
	 *
	 * @access public
	 * @param string name The name of the category.
	 * @return object TLCategory A TLCategory object for the new category
	 *                           on success, false otherwise.
	 */
	function AddCategory($name, $parent) {
		if (mysql_query('INSERT INTO timeline_categories (name, parent) VALUES ("' . addslashes($name) . '", '.$parent.')', $this->db)) {
			return new TLCategory(mysql_insert_id($this->db), $this->db);
		}
		else {
			return false;
		}
	}
}
?>

<?php
/**
 * A timeline category.
 *
 * @access public
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @package Timeline
 */
class TLCategory {
	/**#@+
	 * @access private
	 */
	var $id;
	var $name;
	var $db;
	/**#@-*/

	/**
	 * Constructs a new category object. Generally speaking, shouldn't need
	 * to be called directly.
	 *
	 * @access public
	 * @param int id The category ID.
	 * @param resource db The database connection to use.
	 */
	function TLCategory($id, &$db) {
		$this->id = (int) $id;
		$this->db = $db;
		
		$result = mysql_query('SELECT * FROM timeline_categories WHERE id=' . $this->id, $this->db);
		if ($result && mysql_num_rows($result)) {
			$this->name = stripslashes(mysql_result($result, 0, 'name'));
		}
	}

	/**
	 * Returns the category ID.
	 *
	 * @access public
	 * @return int The category ID.
	 */
	function GetID() {
		return $this->id;
	}

	/**
	 * Returns the category name.
	 *
	 * @access public
	 * @return string The category's name.
	 */
	function GetName() {
		return $this->name;
	}

	/**
	 * Sets a new name for the category.
	 *
	 * @access public
	 * @param string name The new name.
	 * @return boolean True on success, false otherwise.
	 */
	function SetName($name) {
		if (mysql_query('UPDATE timeline_categories SET name="' . addslashes($name) . '" WHERE id=' . $this->id, $this->db)) {
			$this->name = $name;
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Deletes the category.
	 *
	 * @access public
	 * @return boolean True on success, false otherwise.
	 */
	function DeleteCategory() {
		return !!mysql_query('DELETE FROM timeline_categories WHERE id=' . $this->id, $this->db);
	}
}
?>

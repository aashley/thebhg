<?php
/**
 * The parent class for a Block. Not usually instantiated by itself.
 *
 * @package MyBHG
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @access public
 */
class Block {
	/**#@+
	 * @access private
	 */
	var $db;
	var $data;
	var $id;
	var $title;
	var $user;
	/**#@-*/
	
	/**
	 * The constructor for a block.
	 *
	 * @access public
	 * @param int id The block ID to load.
	 * @param resource db The database connection to use.
	 */
	function Block($id, &$db) {
		$this->db = $db;
		$this->id = $id;
		$this->user = $user;
		$result = mysql_query("SELECT data, title FROM blocks WHERE id=$id", $db);
		if ($result && mysql_num_rows($result)) {
			$row = mysql_fetch_array($result);
			$this->data = stripslashes($row['data']);
			$this->title = stripslashes($row['title']);
		}
		else {
			$this->data = '';
			$this->title = '';
		}
	}

	/**
	 * Returns the block's HTML output suitable for inserting into a MyBHG
	 * page.
	 *
	 * @access public
	 * @return string the HTML output.
	 */
	function GetHTML() {}

	/**
	 * Updates the block's cache, if it has one.
	 *
	 * @access public
	 */
	function UpdateCache() {}

	/**
	 * Saves the new data for the block.
	 *
	 * @access public
	 * @param string data The new data to save.
	 * @return boolean true on success, false otherwise.
	 */
	function SaveData($data) {
		if (mysql_query('UPDATE blocks SET data="' . addslashes($data) . '" WHERE id=' . $this->id, $this->db)) {
			$this->data = $data;
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Saves the new title for the block.
	 *
	 * @access public
	 * @param string title The new title.
	 * @return boolean true on success, false otherwise.
	 */
	function SaveTitle($title) {
		if (mysql_query('UPDATE blocks SET title="' . addslashes($title) . '" WHERE id=' . $this->id, $this->db)) {
			$this->title = $title;
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Returns the label to display in an administration interface when
	 * changing the block's data.
	 *
	 * @access public
	 * @return string the label to display.
	 */
	function GetLabel() {}

	/**
	 * Returns the title of the block.
	 *
	 * @access public
	 * @return string the title.
	 */
	function GetTitle() {
		return $this->title;
	}
}
?>

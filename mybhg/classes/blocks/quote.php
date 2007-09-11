<?php
/**
 * A block that displays a random quote from the IRC quotes archive.
 *
 * @package MyBHG
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @access public
 */
class QuoteBlock extends Block {
	/**#@+
	 * @access private
	 */
	var $html;
	/**#@-*/

	function QuoteBlock($id, &$db) {
		Block::Block($id, $db);
		$this->title = 'Random Quote';
		$cache_result = mysql_query('SELECT * FROM block_cache WHERE id=' . $id, $db);
		if ($cache_result && mysql_num_rows($cache_result)) {
			if ((time() - mysql_result($cache_result, 0, 'time')) > 86400) {
				$this->UpdateCache();
			}
			else {
				$this->html = stripslashes(mysql_result($cache_result, 0, 'data'));
			}
		}
		else {
			$this->UpdateCache();
		}
	}

	function GetHTML() {
		return $this->html;
	}

	function UpdateCache() {
		$db = mysql_connect('localhost', 'holonet', 'w0rdy');
		mysql_select_db('holonet', $db);
		$result = mysql_query('SELECT * FROM irc_quotes ORDER BY RAND() LIMIT 1', $db);
		$row = mysql_fetch_array($result);
		$this->html = nl2br(htmlspecialchars(stripslashes($row['quote'])));
		if (!mysql_query('INSERT INTO block_cache (id, time, data) VALUES (' . $this->id . ', UNIX_TIMESTAMP(), "' . addslashes($this->html) . '")', $this->db)) {
			mysql_query('UPDATE block_cache SET data="' . addslashes($this->html) . '", time=UNIX_TIMESTAMP() WHERE id=' . $this->id, $this->db);
		}
	}

	function GetLabel() {
		return '';
	}
}
?>

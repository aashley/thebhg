<?php
/**
 * A block to display some RSS headlines.
 *
 * @package MyBHG
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @access public
 */
class RSSBlock extends Block {
	/**#@+
	 * @access private
	 */
	var $html;
	/**#@-**/
	
	function RSSBlock($id, &$db) {
		Block::Block($id, $db);
		$cache_result = mysql_query('SELECT * FROM block_cache WHERE id=' . $id, $db);
		if ($cache_result && mysql_num_rows($cache_result)) {
			if ((time() - mysql_result($cache_result, 0, 'time')) > 3600) {
				$this->UpdateCache();
			}
			else {
				$this->title = stripslashes(mysql_result($cache_result, 0, 'title'));
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
		$backend = new Backend($this->data);
		$channel = $backend->GetChannel();
		
		$items = $channel->GetItems();
		if ($items) {
			$lines = array();
			foreach ($items as $item) {
				$lines[] = '<a href="' . $item->GetLink() . '">' . $item->GetTitle() . '</a>';
			}
			$this->html = implode('<br />', $lines);
		}
		else {
			$this->html = 'No headline data available.';
		}
		
		if ($channel->GetTitle()) {
			$this->title = '<a href="' . $channel->GetLink() . '">' . $channel->GetTitle() . '</a>';
		}

		if (!mysql_query('INSERT INTO block_cache (id, time, title, data) VALUES (' . $this->id . ', UNIX_TIMESTAMP(), "' . addslashes($this->title) . '", "' . addslashes($this->html) . '")', $this->db)) {
			mysql_query('UPDATE block_cache SET title="' . addslashes($this->title) . '", data="' . addslashes($this->html) . '", time=UNIX_TIMESTAMP() WHERE id=' . $this->id, $this->db);
		}
	}

	function GetLabel() {
		return 'URL:';
	}

	function GetTitle() {
		return $this->title;
	}
}

<?php
/**
 * A block to display the relevant BHG links.
 *
 * @package MyBHG
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @access public
 */
class LinksBlock extends Block {
	/**#@+
	 * @access private
	 */
	var $html;
	/**#@-**/
	
	function LinksBlock($id, &$db) {
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
		$links_result = mysql_query('SELECT * FROM links WHERE show_main=1 ORDER BY name', $this->db);
		if ($links_result && mysql_num_rows($links_result)) {
			$links = array();
			while ($links_row = mysql_fetch_array($links_result)) {
				$links[] = '<a href="' . htmlspecialchars(stripslashes($links_row['url'])) . '">' . str_replace(' ', '&nbsp;', stripslashes($links_row['name'])) . '</a>';
			}
			$this->html = implode('<br />', $links);
		}
		else {
			$this->html = 'No links found.';
		}
		$this->html .= '<br /><b><a href="links.php">View All Links</a></b>';
		
		if (!mysql_query('INSERT INTO block_cache (id, time, title, data) VALUES (' . $this->id . ', UNIX_TIMESTAMP(), "' . addslashes($this->title) . '", "' . addslashes($this->html) . '")', $this->db)) {
			mysql_query('UPDATE block_cache SET title="' . addslashes($this->title) . '", data="' . addslashes($this->html) . '", time=UNIX_TIMESTAMP() WHERE id=' . $this->id, $this->db);
		}
	}

	function GetLabel() {
		return '';
	}

	function GetTitle() {
		return $this->title;
	}
}

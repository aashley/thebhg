<?php
/**
 * An internal MyBHG article.
 *
 * @access public
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @package MyBHG
 */
class InternalArticle extends Article {
	/**#@+
	  * @access private
	  */
	var $db;
	/**#@-*/

	function InternalArticle($id, &$db) {
		$this->db = $db;
		$this->id = $id;
		$result = mysql_query('SELECT * FROM articles WHERE id=' . $id, $db);
		if ($result && mysql_num_rows($result)) {
			$row = mysql_fetch_array($result);
			$this->topic = $row['topic'];
			$this->time = $row['time'];
			$this->author = $row['author'];
			$this->title = stripslashes($row['title']);
			$this->text = nl2br(stripslashes($row['text']));
		}
	}

	function SetTopic($topic) {
		if (mysql_query('UPDATE articles SET topic=' . $topic->GetID() . ' WHERE id=' . $this->id, $this->db)) {
			$this->topic = $topic->GetID();
			return true;
		}
		else {
			return false;
		}
	}

	function SetTitle($title) {
		if (mysql_query('UPDATE articles SET title="' . addslashes($title) . '" WHERE id=' . $this->id, $this->db)) {
			$this->title = $title;
			return true;
		}
		else {
			return false;
		}
	}
	
	function SetText($text) {
		if (mysql_query('UPDATE articles SET `text`="' . addslashes($text) . '" WHERE id=' . $this->id, $this->db)) {
			$this->text = $text;
			return true;
		}
		else {
			return false;
		}
	}

	function DeleteArticle() {
		return (mysql_query('DELETE FROM articles WHERE id=' . $this->id, $this->db) != false);
	}
}
?>

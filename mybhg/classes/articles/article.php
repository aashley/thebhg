<?php
/**
 * The base class for articles.
 *
 * @access public
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @package MyBHG
 */
class Article {
	/**#@+
	 * @access private
	 */
	var $id;
	var $topic;
	var $time;
	var $author;
	var $title;
	var $text;
	/**#@-*/

	/**
	 * Returns the article ID.
	 *
	 * @access public
	 * @return int the article ID.
	 */
	function GetID() {
		return $this->id;
	}

	/**
	 * Returns the topic.
	 *
	 * @access public
	 * @return object Topic the Topic object.
	 */
	function GetTopic() {
		return new Topic($this->topic);
	}

	/**
	 * Returns the time the article was created.
	 *
	 * @access public
	 * @return int the time of the article's creation.
	 */
	function GetTime() {
		return $this->time;
	}

	/**
	 * Returns the author of the article.
	 *
	 * @access public
	 * @return int the author of the article.
	 */
	function GetAuthor() {
		return new Person($this->author);
	}

	/**
	 * Returns the title of the article.
	 *
	 * @access public
	 * @return string the title of the article.
	 */
	function GetTitle() {
		return $this->title;
	}
	
	/**
	 * Returns the text of the article.
	 *
	 * @access public
	 * @return string the text of the article.
	 */
	function GetText() {

	/**
	 * Sets the topic.
	 *
	 * @access public
	 * @param object Topic topic The new topic.
	 * @return boolean true on success, false otherwise.
	 */
	function SetTopic($topic) {}

	/**
	 * Sets the title of the article.
	 *
	 * @access public
	 * @access string title The new title.
	 * @return boolean true on success, false otherwise.
	 */
	function SetTitle($title) {}
	
	/**
	 * Sets the text of the article.
	 *
	 * @access public
	 * @access string text The new text.
	 * @return boolean true on success, false otherwise.
	 */
	function SetText($text) {}

	/**
	 * Deletes the article.
	 *
	 * @access public
	 * @return boolean true on success, false otherwise.
	 */
	function DeleteArticle() {}
}
?>

<?php
require_once 'DB.php';
require_once 'Auth.php';

require_once 'HTML/QuickForm.php';
require_once 'HTML/Table.php';

abstract class Page_Base {
	protected $board;
	protected $parts;
	protected $system;
	protected $topic;
	protected $user;
	protected $baseURL;

	protected function __construct($parts, $auth = false, $board = null, $topic = null) {
		$this->system = new BoardSystem;
		$this->parts = $parts;
		
		$this->baseURL = $_SERVER['REQUEST_URI'];
		if (($pos = strpos($this->baseURL, '?')) !== false) {
			$this->baseURL = substr($this->baseURL, 0, $pos);
		}

		if (is_null($board))
			$this->board = null;
		else
			$this->board = $this->system->GetBoard($board);

		if (is_null($topic))
			$this->topic = null;
		else
			$this->topic = $this->system->GetTopic($topic);

		if ($auth) {
			if (isset($_COOKIE['key']))
				$this->user = $this->system->LookupKey($_COOKIE['key']);
			else
				header('Location: /login' . $_SERVER['REQUEST_URI']);
		}
		else
			$this->user = new User_Default();
	}

	protected function Header($pageTitle = null) {
		$title = SDBOARD_TITLE;
		if ($pageTitle)
			$title .= ' :: ' . $pageTitle;
		
		ob_start('ob_tidyhandler');

		echo '<html><head><title>' . $title . '</title><link rel="stylesheet" type="text/css" href="/style" /></head><body>';
	}

	protected function Footer($showPlaylist = false) {
		echo '</body></html>';
		header('Content-Type: text/html; charset=UTF-8');
		ob_end_flush();
		exit;
	}

	abstract public function Render();
}
?>

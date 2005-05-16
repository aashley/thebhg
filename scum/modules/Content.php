<?php
include_once 'modules/Base.php';

class Module_Content extends Module_Base {
	private $data;
	private $page;
	private $title;

	public function __construct($path) {
		parent::__construct($path);

		$this->page = $GLOBALS['content']->getPage($path);
		if ($this->page === false)
			$this->notFound();

		if ($this->page->getType() == 'text/html')
			$this->updateTitle();
	}

	private function notFound() {
		$GLOBALS['module'] = $this;
		$this->title = 'Not Found';
		$this->header();
		header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');

?>
<h1>Not Found</h1>
<p>We're sorry, but the page you requested could not be found.</p>
<p><a href="/">Return to the front page.</a></p>
<?php

		$this->footer();
	}

	public function output() {
		$this->header($this->page->getType());
		if (strpos($this->path, 'static') !== false) {
			$etag = md5(ob_get_contents());
			
			if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $etag) {
				header($_SERVER['SERVER_PROTOCOL'].' 304 Not Modified');
				ob_end_clean();
				exit;
			}
			
			header('ETag: '.$etag);
			header('Cache-Control: max-age=604800, public');
			header('Pragma: cache');
		}
		echo $this->page->getContent();
		$this->footer();
	}

	public function title() {
		return $this->title;
	}

	private function updateTitle() {
		$doc = DOMDocument::loadHTML($this->page->getContent());
		$xp = new DOMXPath($doc);
		$titles = $xp->query('//body//h1');
		if ($titles->length > 0)
			$this->title = $titles->item(0)->textContent;
		else
			$this->title = '';
	}
}
?>

<?php
include_once 'roster.inc';

abstract class Module_Base extends Scum_Base {
	private $mime;
	protected $path;
	protected $roster;
	
	public function __construct($path) {
		parent::__construct();

		$this->path = $path;
		$this->roster = new Roster(SCUM_CODER);
	}

	protected function header($mime = 'text/html') {
		$this->mime = $mime;
		ob_start();
		header('Content-Type: '.$mime);
		
		if ($mime == 'text/html')
			include_once 'template/header.php';
	}

	protected function footer() {
		if ($this->mime == 'text/html')
			include_once 'template/footer.php';

		header('Content-Length: '.ob_get_length());
		ob_end_flush();
		exit;
	}

	abstract public function output();
	abstract public function title();
}
?>

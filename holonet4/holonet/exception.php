<?php

class page_holonet_exception extends holonet_page {

	private $e = null;

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Holonet Exception Caught');

		$this->addBodyContent('<p>An unhandled exception occured while trying to '
				.'access the page you requested. Please report this problem at the <a '
				.'href="http://bugs.thebhg.org/">Bug Tracker</a> under the Holonet 4 '
				.'module.</p>');

		if ($this->e instanceof Exception) {

			$this->addBodyContent($this->e->__toString());

		}

	}

	public function setException(Exception $e) {

		$this->e = $e;

	}

}

?>

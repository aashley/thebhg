<?php

class page_holonet_noauth extends holonet_page {

	public function buildPage() {

		$this->setTitle('Holonet Authentication');

		$this->addBodyContent('<p>You do not have permission to view the page you have requested.</p>');

	}

}

?>

<?php
class BlockTable extends Table {
	function BlockTable($title = '', $alternate = false) {
		$this->alternate = $alternate;
		$this->highlight = false;
		echo '<table class="fullwidth">' . "\n";
	}
}
?>

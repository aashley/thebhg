<?php
class BlockTable extends Table {
	function BlockTable($title = '', $alternate = false) {
		$this->alternate = $alternate;
		$this->highlight = false;
		echo '<table class="block">';
	}
	
	function AddCell($cell, $colspan = 1, $rowspan = 1, $width = -1) {
		echo '<td class="block" colspan=' . $colspan . ' rowspan=' . $rowspan . ($width != -1 ? ' width="' . $width . '%"' : '') . '>' . $cell . '</td>' . "\n";
	}

	function AddHeader($cell, $colspan = 1, $rowspan = 1, $width = -1) {
		echo '<th class="block" colspan=' . $colspan . ' rowspan=' . $rowspan . ($width != -1 ? ' width="' . $width . '%"' : '') . '>' . $cell . '</th>' . "\n";
	}
}
?>

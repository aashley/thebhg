<?php
class Table {
	var $alternate;
	var $highlight;
	
	function Table($title = '', $alternate = false) {
		$this->alternate = $alternate;
		$this->highlight = false;
		echo '<table>' . "\n";
		if ($title) {
			echo '<caption>' . $title . '</caption>';
		}
	}

	function EndTable() {
		echo '</table>' . "\n";
	}

	function StartRow() {
		if ($this->alternate) {
			if ($this->highlight) {
				$this->highlight = false;
			}
			else {
				$this->highlight = true;
			}
		}
		echo '<tr valign="top">';
	}

	function EndRow() {
		echo '</tr>' . "\n";
	}

	function AddRow() {
		$this->StartRow();
		$args = func_get_args();
		foreach ($args as $cell) {
			$this->AddCell($cell);
		}
		$this->EndRow();
	}

	function AddCell($cell, $colspan = 1, $rowspan = 1, $width = -1, $background = false) {
		echo '<td colspan="' . $colspan . '" rowspan="' . $rowspan . '"' . ($width != -1 ? ' width="' . $width . '%"' : '') . '>' . $cell . '</td>' . "\n";
	}

	function AddHeader($cell, $colspan = 1, $rowspan = 1, $width = -1) {
		echo '<th colspan="' . $colspan . '" rowspan="' . $rowspan . '"' . ($width != -1 ? ' width="' . $width . '%"' : '') . '>' . $cell . '</th>' . "\n";
	}
}
?>

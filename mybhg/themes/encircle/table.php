<?php
class Table {
	var $alternate;
	var $highlight;
	var $rows;
	var $crow;
	var $ccol;
	var $title;
	
	function Table($title = '', $alternate = false) {
		$this->title = $title;
		$this->crow = -1;
		$this->rows = array();
	}

	function GetCellHTML($cell, $class = false) {
		$html = '<t';
		if ($cell['header']) {
			$html .= 'h';
		}
		else {
			$html .= 'd';
		}
		if ($class !== false) {
			$html .= ' class="' . $class . '"';
		}
		$html .= ' colspan="' . $cell['colspan'] . '" rowspan="' . $cell['rowspan'] . '"';
		if (isset($cell['width'])) {
			$html .= ' width="' . $cell['width'] . '"';
		}
		$html .= '>' . $cell['cell'] . '</td>';
		return $html;
	}
	
	function EndTable($block = false) {
		echo '<table class="';
		if ($block) {
			echo 'block ';
		}
		echo 'tclass">';

		if ($this->title) {
			echo '<caption>' . $this->title . '</caption>';
		}
		
		$last = count($this->rows) - 1;
		$ridx = 0;
		foreach ($this->rows as $row) {
			echo '<tr>';
			$lcell = count($row) - 1;
			$cell = 0;
			foreach ($row as $col) {
				$class = false;
				if ($col['header']) {
					$tag = 'th';
				}
				else {
					$tag = 'td';
				}
				if ($cell == 0) {
					if ($ridx == 0) {
						echo '<' . $tag . ' class="top-left">&nbsp;</' . $tag . '>';
					}
					elseif ($ridx == $last) {
						echo '<' . $tag . ' class="bottom-left">&nbsp;</' . $tag . '>';
					}
					elseif ($cell == $lcell) {
						$col['colspan'] += 2;
					}
					else {
						$col['colspan']++;
						$class = 'no-left';
					}
				}
				elseif ($cell == $lcell) {
					$class = 'no-right';
					$col['colspan']++;
				}
				echo $this->GetCellHTML($col, $class);
				if ($cell == $lcell) {
					if ($ridx == 0) {
						echo '<' . $tag . ' class="top-right">&nbsp;</' . $tag . '>';
					}
					elseif ($ridx == $last) {
						echo '<' . $tag . ' class="bottom-right">&nbsp;</' . $tag . '>';
					}
				}
				$cell++;
			}
			echo '</tr>';
			$ridx++;
		}
		echo '</table>';
	}

	function StartRow() {
		$this->rows[++$this->crow] = array();
		$this->ccol = -1;
	}

	function EndRow() {
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
		$cell = array('cell'=>$cell);
		$cell['colspan'] = $colspan;
		$cell['rowspan'] = $rowspan;
		if ($width != -1) {
			$cell['width'] = $width;
		}
		$this->rows[$this->crow][++$this->ccol] = $cell;
	}

	function AddHeader($cell, $colspan = 1, $rowspan = 1, $width = -1) {
		$cell = array('cell'=>$cell);
		$cell['colspan'] = $colspan;
		$cell['rowspan'] = $rowspan;
		if ($width != -1) {
			$cell['width'] = $width;
		}
		$cell['header'] = true;
		$this->rows[$this->crow][++$this->ccol] = $cell;
	}
}
?>

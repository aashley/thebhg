<?php
class Form {
	var $select;
	var $options;
	var $table;
	
	function Form($page, $method = 'post', $name = '', $enctype = '', $title = '') {
		global $module;
		if ($name == '') {
			$name = $page;
		}
		echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="' . htmlspecialchars($method) . '" name="' . htmlspecialchars($name) . '"';
		if (strlen($enctype)) {
			echo ' enctype="' . htmlspecialchars($enctype) . '"';
		}
		echo '>';
		$this->AddHidden('module', $module);
		$this->AddHidden('page', $page);
		if (session_id()) {
			$this->AddHidden(session_name(), session_id());
		}
		$this->table = new Table($title);
	}

	function EndForm() {
		$this->table->EndTable();
		echo '</form>';
	}

	function AddTextBox($label, $name, $value = '', $size = 20, $maxsize = 0) {
		$this->table->StartRow();
		$this->table->AddCell('<label for="' . htmlspecialchars($name) . '">' . $label . '</label>');
		$tb = '<input type="text" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '" size="' . htmlspecialchars($size) . '"';
		if ($value) {
			$tb .= ' value="' . htmlspecialchars($value) . '"';
		}
		if ($maxsize) {
			$tb .= ' maxsize="' . htmlspecialchars($maxsize) . '"';
		}
		$this->table->AddCell($tb . '>');
		$this->table->EndRow();
	}

	function AddPasswordBox($label, $name, $value = '', $size = 20, $maxsize = 0) {
		$this->table->StartRow();
		$this->table->AddCell('<label for="' . htmlspecialchars($name) . '">' . $label . '</label>');
		$tb = '<input type="password" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '" size="' . htmlspecialchars($size) . '"';
		if ($value) {
			$tb .= ' value="' . htmlspecialchars($value) . '"';
		}
		if ($maxsize) {
			$tb .= ' maxsize="' . htmlspecialchars($maxsize) . '"';
		}
		$this->table->AddCell($tb . '>');
		$this->table->EndRow();
	}

	function AddCheckBox($label, $name, $value, $checked = false) {
		$this->table->StartRow();
		$this->table->AddCell('<label for="' . htmlspecialchars($name) . '">' . $label . '</label>');
		$cb = '<input type="checkbox" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '"';
		if ($checked) {
			$cb .= ' checked';
		}
		$this->table->AddCell($cb . '>');
		$this->table->EndRow();
	}

	function AddRadioButton($label, $name, $value, $checked = false) {
		$this->table->StartRow();
		$this->table->AddCell('<label for="' . htmlspecialchars($name) . '">' . $label . '</label>');
		$cb = '<input type="radio" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '"';
		if ($checked) {
			$cb .= ' checked';
		}
		$this->table->AddCell($cb . '>');
		$this->table->EndRow();
	}

	function AddHidden($name, $value) {
		echo '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '">';
	}

	function AddFile($label, $name) {
		$this->table->AddRow('<label for="' . htmlspecialchars($name) . '">' . $label . '</label>', '<input type="file" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '">');
	}

	function AddSubmitButton($name = '', $value = '', $resetText = 'Reset') {
		$this->table->StartRow();
		$sb = '<input type="submit"';
		if ($name) {
			$sb .= ' name="' . htmlspecialchars($name) . '"';
		}
		if ($value) {
			$sb .= ' value="' . htmlspecialchars($value) . '"';
		}
		$this->table->AddCell('<div style="text-align: right"><input type="reset" value="' . htmlspecialchars($resetText) .'">&nbsp;&nbsp;&nbsp;' . $sb . '></div>', 2);
		$this->table->EndRow();
	}

	function StartSelect($label, $name, $select = false, $size = 1, $multiple = false) {
		$this->table->StartRow();
		$this->table->AddCell('<label for="' . htmlspecialchars($name) . '">' . $label . '</label>');
		if (is_numeric($select)) {
			$this->select = "$select";
		}
		else {
			$this->select = $select;
		}
		$this->options = '<select id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '" size="' . htmlspecialchars($size) . '"';
		if ($multiple) {
			$this->options .= ' multiple';
		}
		$this->options .= '>';
	}

	function EndSelect() {
		$this->options .= '</select>';
		$this->table->AddCell($this->options);
		$this->table->EndRow();
	}

	function AddOption($name, $value) {
		if (is_numeric($name)) {
			$name = "$name";
		}
		$this->options .= '<option value="' . htmlspecialchars($name) . '"';
		if ((is_array($this->select) && in_array($name, $this->select)) || ($this->select !== false && $this->select == $name)) {
			$this->options .= ' selected';
		}
		$this->options .= '>' . str_replace(' ', '&nbsp;', htmlspecialchars($value)) . '</option>';
	}

	function AddTextArea($label, $name, $text = '', $rows = 5, $cols = 40) {
		$this->table->AddRow('<label for="' . htmlspecialchars($name) . '">' . $label . '</label>', '<textarea name="' . htmlspecialchars($name) . '" rows="' . htmlspecialchars($rows) . '" cols="' . htmlspecialchars($cols) . '">' . htmlspecialchars($text) . '</textarea>');
	}

	function AddDateBox($label, $name, $ts = 0, $show_time = false) {
		$this->table->StartRow();
		$this->table->AddCell('<label for="' . htmlspecialchars($name) . '">' . $label . '</label>');
		$df = '<input type="text" id="' . htmlspecialchars($name) . '_day" name="' . htmlspecialchars($name) . '_day" size="3" maxsize="2"';
		if ($ts) {
			$df .= ' value="' . date('j', $ts) . '">';
		}
		else {
			$df .= ' value="day" onFocus="if (this.value == \'day\') this.value = \'\'" onBlur="if (this.value == \'\') this.value = \'day\'">';
		}
		$df .= ' <select id="' . htmlspecialchars($name) . '_month" name="' . htmlspecialchars($name) . '_month" size="1">';
		for ($i = 1; $i <= 12; $i++) {
			$df .= '<option value="' . $i . '"';
			if ($ts && date('n', $ts) == $i) {
				$df .= ' selected';
			}
			$df .= '>' . date('F', mktime(0, 0, 0, $i)) . '</option>';
		}
		$df .= '</select> ';
		$df .= '<input type="text" id="' . htmlspecialchars($name) . '_year" name="' . htmlspecialchars($name) . '_year" size="5" maxsize="4"';
		if ($ts) {
			$df .= ' value="' . date('Y', $ts) . '">';
		}
		else {
			$df .= ' value="year" onFocus="if (this.value == \'year\') this.value = \'\'" onBlur="if (this.value == \'\') this.value = \'year\'">';
		}
		if ($show_time) {
			$df .= ' at ';
			$df .= '<input type="text" id="' . htmlspecialchars($name) . '_hour" name="' . htmlspecialchars($name) . '_hour" size="4" maxsize="2"';
			if ($ts) {
				$df .= ' value="' . date('G', $ts) . '">';
			}
			else {
				$df .= ' value="hour" onFocus="if (this.value == \'hour\') this.value = \'\'" onBlur="if (this.value == \'\') this.value = \'hour\'">';
			}
			$df .= ':<input type="text" id="' . htmlspecialchars($name) . '_min" name="' . htmlspecialchars($name) . '_min" size="4" maxsize="2"';
			if ($ts) {
				$df .= ' value="' . date('i', $ts) . '">';
			}
			else {
				$df .= ' value="min" onFocus="if (this.value == \'min\') this.value = \'\'" onBlur="if (this.value == \'\') this.value = \'min\'">';
			}
			$df .= ' ' . date('T');
		}
		$this->table->AddCell($df);
		$this->table->EndRow();
	}

	function AddSectionTitle($title) {
		$this->table->StartRow();
		$this->table->AddHeader(htmlspecialchars($title), 2);
		$this->table->EndRow();
	}
	
}

function parse_date_box($name) {
	if (isset($_REQUEST["{$name}_hour"])) {
		$hour = $_REQUEST["{$name}_hour"];
	}
	else {
		$hour = 0;
	}
	if (isset($_REQUEST["{$name}_min"])) {
		$min = $_REQUEST["{$name}_min"];
	}
	else {
		$min = 0;
	}
	$year = $_REQUEST["{$name}_year"];
	$month = $_REQUEST["{$name}_month"];
	$day = $_REQUEST["{$name}_day"];
	return mktime($hour, $min, 0, $month, $day, $year);
}
?>

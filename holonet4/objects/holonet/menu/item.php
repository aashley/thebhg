<?php

class holonet_menu_item {

	public $hasLink = true;
	public $link = null;
	public $text = null;

	public function __construct($text = null, $link = null) {

		$this->text = $text;
		$this->link = $link;

	}

	public function toHtml() {

		$output = '';

		if ($this->hasLink) 
			$output .= '<a href="'.$this->link.'">';

		$output .= $this->text;

		if ($this->hasLink)
			$output .= '</a>';

		return $output;

	}

}

?>

<?php

class holonet_menu {

	public $showTitle = true;
	public $title = null;

	private $items = array();

	public function __construct($filename = null) {

		if (!is_null($filename))
			$this->loadFromXML($filename);

	}

	public function addItem(holonet_menu_item $item) {

		$this->items[] = $item;

	}

	public function loadFromXML($filename) {

		$xml = simplexml_load_file($filename);

		$this->title = $xml->title;

		foreach ($xml->item as $i) {

			$item = new holonet_menu_item();
			$item->text = $i->text;
			if (isset($i->link)) {
				$item->hasLink = true;
				$item->link = $i->link;
			} else {
				$item->hasLink = false;
			}

			$this->addItem($item);

		}

	}

	public function toHtml() {

		$output = '';

		if ($this->showTitle && !is_null($this->title))
			$output .= '<h3>'.$this->title."</h3>\n";

		$output .= "<ul>\n";

		foreach ($this->items as $item) {

			$output .= '<li>'.$item->toHtml()."</li>\n";

		}

		$output .= "</ul>\n";

		return $output;

	}

}

?>

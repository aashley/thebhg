<?php

include_once 'objects/holonet/menu/item.php';

class holonet_menu {

	public $showTitle = true;
	public $title = null;
	public $class = null;
	public $id = null;

	private $items = array();

	public function __construct($filename = null) {

		if (!is_null($filename))
			$this->loadFromXML($filename);

	}

	public function addItem(holonet_menu_item $item) {

		$this->items[] = $item;

	}

	public function loadFromXML($filename) {
		
		if (!file_exists($filename))
			throw bhg_fatal_exception('Menu XML file does not exist');

		$xml = simplexml_load_file($filename);

		$this->title = (string)$xml->title;

		foreach ($xml->items->item as $i) {

			$item = new holonet_menu_item();
			$item->text = (string)$i->text;
			if (isset($i->link)) {
				$item->hasLink = true;
				$item->link = (string)$i->link;
			} else {
				$item->hasLink = false;
			}

			$this->addItem($item);

		}

	}

	public function toHtml() {

		$output = '';
		
		if ($this->showTitle) {

			$output .= '<div'.(is_null($this->class) ? '' : ' class="'.$this->class.'"').">\n";
			
			if (!is_null($this->title))
				$output .= '<h3>'.$this->title."</h3>\n";

		}

		$output .= "<ul".(is_null($this->id) ? '' : ' id="'.$this->id.'"').">\n";

		foreach ($this->items as $item) {

			$output .= '<li>'.$item->toHtml()."</li>\n";

		}

		$output .= "</ul>\n";

		if ($this->showTitle)
			$output .= "</div>\n";

		return $output;

	}

}

?>

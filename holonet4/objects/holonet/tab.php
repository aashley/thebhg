<?php

include_once 'HTML/Common2.php';
include_once 'HTML/Page2.php';

class holonet_tab extends HTML_Common2 {

	private $content = array();
	private $id = null;
	private $title = null;

	public function __construct($id = null, $title = null) {

		$this->id = $id;
		$this->title = $title;

	}

	public function addContent($content, $flag = HTML_PAGE2_APPEND) {

		if ($flag == HTML_PAGE2_APPEND) {

			$this->content[] = $content;

		} elseif ($flag == HTML_PAGE2_PREPEND) {

			$this->content = array_merge(array($content), $this->content);

		} else {

			$this->content = array($content);

		}

	}

	public function getID() {

		return $this->id;

	}

	public function getTitle() {

		return $this->title;

	}

	public function setID($id) {

		$this->id = $id;

	}

	public function setTitle($title) {

		$this->title = $title;

	}

	public function toHtml() {

		$html = '<div class="tab" id="'
					 .htmlspecialchars($this->id)
					 .'">';

		foreach ($this->content as $content) {

			if (is_string($content)) {

				$html .= $content;

			} elseif (is_object($content)) {

				if (method_exists($content, 'toHtml')) {

					$html .= $content->toHtml();

				} elseif (method_exists($content, 'toString')) {

					$html .= $content->toString();

				}

			}

		}

		$html .= '</div>';

		return $html;

	}

}

?>

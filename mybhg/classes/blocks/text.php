<?php
/**
 * A straight text block.
 *
 * @package MyBHG
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @access public
 */
class TextBlock extends Block {
	function TextBlock($id, &$db) {
		Block::Block($id, $db);
	}

	function GetHTML() {
		return $this->data;
	}

	function GetLabel() {
		return 'Text:';
	}
}

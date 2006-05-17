<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Library
 * @Version $Rev$ $Date$
 */

/**
 * Library Book Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Library
 * @Version $Rev$ $Date$
 */
class bhg_library_book extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('library_book', $id);
		$this->__addFieldMap(array(
					'shelf' => 'bhg_library_shelf',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getChapters()
	
	/**
	 * Get all the chapters in this book
	 *
	 * @param array Array of filters to select which chapters to return
	 * @return bhg_core_list
	 * @see bhg_library::getChapters()
	 */
	public function getChapters($filter = array()) {

		$filter['book'] = $this;

		return $GLOBALS['bhg']->library->getChapters($filter);

	}

	// }}}

}

?>

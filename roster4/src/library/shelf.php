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
 * Library Shelf Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Library
 * @Version $Rev$ $Date$
 */
class bhg_library_shelf extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('bhg_library_shelf', $id);
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getBooks()
	
	/**
	 * Get all the books on this shelf
	 *
	 * @param array Filters to select which books to return
	 * @return bhg_core_list
	 * @see bhg_library::getBooks()
	 */
	public function getBooks($filter = array()) {

		$filter['shelf'] = $this;

		return $GLOBALS['bhg']->library->getBooks($filter);

	}

	// }}}

}

?>

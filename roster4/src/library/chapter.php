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
 * Library Chapter Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Library
 * @Version $Rev$ $Date$
 */
class bhg_library_chapter extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('library_chapter', $id);
		$this->__addFieldMap(array(
					'book' => 'bhg_library_book',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	
	// {{{ getSections()
	
	/**
	 * Get all sections within this chapter
	 *
	 * @param array Filters to select which chapters to return
	 * @return bhg_core_list
	 */
	public function getSections($filter = array()) {

		$filter['chapter'] = $this;

		return $GLOBALS['bhg']->library->getSections($filter);

	}

	// }}}

}

?>

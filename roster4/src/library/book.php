<?php

class bhg_library_book extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('bhg_library_book', $id);
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
	 * @return bhg_core_list
	 */
	public function getChapters($filter = array()) {

		$filter['book'] = $this;

		return $GLOBALS['bhg']->library->getChapters($filter);

	}

	// }}}

}

?>

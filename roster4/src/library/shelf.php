<?php

class bhg_library_shelf extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('bhg_library_shelf', $id);
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getBooks()
	
	/**
	 * Get all the books on this shelf
	 *
	 * @return bhg_core_list
	 */
	public function getBooks($filter = array()) {

		$filter['shelf'] = $this;

		return $GLOBALS['bhg']->library->getBooks($filter);

	}

	// }}}

}

?>

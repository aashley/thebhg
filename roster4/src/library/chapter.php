<?php

class bhg_library_chapter extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('bhg_library_chapter', $id);
		$this->__addFieldMap(array(
					'book' => 'bhg_library_book',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

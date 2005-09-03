<?php

class bhg_college_exam extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('college_exam', $id);
		$this->__addFieldMap(array(
					'notebook' => 'bhg_library_book'
					));
		$this->__addDefaultCodePermissions('set', 'god');
		$this->__addDefaultCodePermissions('get', 'god');
	}

	// }}}

}

?>

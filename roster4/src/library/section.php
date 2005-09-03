<?php

class bhg_library_section extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('bhg_library_section', $id);
		$this->__addFieldMap(array(
					'chapter' => 'bhg_library_chapter',
					));
		$this->__addBooleanFields(array('html'));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

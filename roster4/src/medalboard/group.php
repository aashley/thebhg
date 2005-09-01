<?php

class bhg_medalboard_group extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('medalboard_medal', $id);
		$this->__addFieldMap(array(
					'category' => 'bhg_medalboard_category',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

<?php

class bhg_medalboard_medal extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('medalboard_medal', $id);
		$this->__addFieldMap(array(
					'group' => 'bhg_medalboard_group',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

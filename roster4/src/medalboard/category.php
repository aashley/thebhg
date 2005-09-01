<?php

class bhg_medalboard_category extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('medalboard_category', $id);
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

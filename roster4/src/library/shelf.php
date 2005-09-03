<?php

class bhg_library_shelf extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('bhg_library_shelf', $id);
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

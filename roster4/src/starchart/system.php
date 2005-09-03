<?php

class bhg_starchart_system extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('bhg_starchart_system', $id);
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

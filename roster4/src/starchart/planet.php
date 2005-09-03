<?php

class bhg_starchart_planet extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('bhg_starchart_planet', $id);
		$this->__addFieldMap(array(
					'system' => 'bhg_starchart_system',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

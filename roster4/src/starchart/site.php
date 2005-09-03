<?php

class bhg_starchart_site extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('bhg_starchart_site', $id);
		$this->__addFieldMap(array(
					'planet' => 'bhg_starchart_planet',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

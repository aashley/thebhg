<?php

class bhg_roster_division extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('roster_division', $id);
		$this->__addFieldMap(array(
					'category' => 'bhg_roster_division_category',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

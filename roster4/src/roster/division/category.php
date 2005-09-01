<?php

class bhg_roster_division_category extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('roster_division_category', $id);
		$this->__addBooleanFields(array('kabals'));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

<?php

class bhg_roster_new_person extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('roster_new_person', $id);
		$this->__addBooleanFields(array('underage', 'added'));
		$this->__addDefaultCodePermissions('set', 'god');
		$this->__addDefaultCodePermissions('get', 'god');
	}

	// }}}

}

?>

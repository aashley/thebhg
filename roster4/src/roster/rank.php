<?php

class bhg_roster_rank extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('roster_rank', $id);
		$this->__addBooleanFields(array('alwaysavailable', 'unlimitedcredits', 'manuallyset'));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

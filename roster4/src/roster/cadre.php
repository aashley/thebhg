<?php

class bhg_roster_cadre extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('roster_cadre', $id);
		$this->__addFieldMap(array(
					'leader' => 'bhg_roster_person',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

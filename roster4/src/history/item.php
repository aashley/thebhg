<?php

class bhg_history_item extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('roster_item', $id);
		$this->__addFieldMap(array(
					'person' => 'bhg_roster_person'
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

<?php

class bhg_history_event extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('history_event', $id);
		$this->__addFieldMap(array(
					'person' => 'bhg_roster_person'
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

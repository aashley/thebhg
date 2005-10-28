<?php

class bhg_medalboard_group extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('medalboard_group', $id);
		$this->__addFieldMap(array(
					'category' => 'bhg_medalboard_category',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getMedals()

	public function getMedals($filter = array()) {

		$filter['group'] = $this;

		return $GLOBALS['bhg']->medalboard->getMedals($filter);

	}

	// }}}

}

?>

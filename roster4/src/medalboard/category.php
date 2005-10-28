<?php

class bhg_medalboard_category extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('medalboard_category', $id);
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getGroups()

	public function getGroups($filter = array()) {

		$filter['category'] = $this;

		return $GLOBALS['bhg']->medalboard->getGroups($filter);

	}

	// }}}

}

?>

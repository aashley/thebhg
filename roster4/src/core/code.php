<?php

class bhg_cored_code extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('core_code', $id);
		$this->__addBooleanFields(array('god', 'credits', 'purchase', 'kabal', 'medalaward', 'citadel', 'ssl', 'history', 'email', 'news', 'allnews', 'library', 'cadre', 'hunts', 'allhunts'));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

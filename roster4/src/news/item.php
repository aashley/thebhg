<?php

class bhg_news_item extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('bhg_news_item', $id);
		$this->__addFieldMap(array(
					'section' => 'bhg_core_code',
					'poster' => 'bhg_roster_person',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage News
 * @Version $Rev$ $Date$
 */

/**
 * News Item Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage News
 * @Version $Rev$ $Date$
 */
class bhg_news_item extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 * 
	 * @param integer
	 * @return void
	 */
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

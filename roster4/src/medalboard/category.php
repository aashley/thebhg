<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage MedalBoard
 * @Version $Rev$ $Date$
 */

/**
 * Medal Board Category Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage MedalBoard
 * @Version $Rev$ $Date$
 */
class bhg_medalboard_category extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('medalboard_category', $id);
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getGroups()

	/**
	 * Get the Medal Groups that are within this category
	 *
	 * @param array Filter for which groups to return
	 * @return bhg_core_list
	 */
	public function getGroups($filter = array()) {

		$filter['category'] = $this;

		return $GLOBALS['bhg']->medalboard->getGroups($filter);

	}

	// }}}

}

?>

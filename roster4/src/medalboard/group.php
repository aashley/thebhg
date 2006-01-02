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
 * Medal Board Group Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage MedalBoard
 * @Version $Rev$ $Date$
 */
class bhg_medalboard_group extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('medalboard_group', $id);
		$this->__addFieldMap(array(
					'category' => 'bhg_medalboard_category',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getMedals()

	/**
	 * Get the Medals that are within this Medal Group
	 *
	 * @param array Filters to select which medals to return
	 * @return bhg_core_list
	 */
	public function getMedals($filter = array()) {

		$filter['group'] = $this;

		return $GLOBALS['bhg']->medalboard->getMedals($filter);

	}

	// }}}

}

?>

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
		$this->__addBooleanFields(array('multiple', 'displaytype'));
		$this->__addFieldMap(array(
					'category' => 'bhg_medalboard_category',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getAwards()
	
	/**
	 * Get the awarded instances of medals within this group
	 *
	 * @return bhg_core_list List of bhg_medalboard_award objects.
	 */
	public function getAwards($filter = array()) {

		$filter['group'] = $this;

		return $GLOBALS['bhg']->medalboard->getAwards($filter);

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

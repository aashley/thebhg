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
 * Medal Board Medal Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage MedalBoard
 * @Version $Rev$ $Date$
 */
class bhg_medalboard_medal extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('medalboard_medal', $id);
		$this->__addFieldMap(array(
					'group' => 'bhg_medalboard_group',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getAwards()
	
	/**
	 * Get the awarded instances of this medal
	 *
	 * @return bhg_core_list List of bhg_medalboard_award objects.
	 */
	public function getAwards($filter = array()) {

		$filter['medal'] = $this;

		return $GLOBALS['bhg']->medalboard->getAwards($filter);

	}

	// }}}

}

?>

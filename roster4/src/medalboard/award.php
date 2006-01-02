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
 * Medal Board Award Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage MedalBoard
 * @Version $Rev$ $Date$
 */
class bhg_medalboard_award extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('medalboard_award', $id);
		$this->__addFieldMap(array(
					'medal' => 'bhg_medalboard_medal',
					'recipient' => 'bhg_roster_person',
					'awarder' => 'bhg_roster_person',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev: 5524 $ $Date: 2007-08-20 08:49:27 -0400 (Mon, 20 Aug 2007) $
 */

/**
 * Roster Division Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev: 5524 $ $Date: 2007-08-20 08:49:27 -0400 (Mon, 20 Aug 2007) $
 */
class bhg_roster_biographical_data extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_biographical_data', $id);
		$this->__addFieldMap(array(
					'person' => 'bhg_roster_person',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

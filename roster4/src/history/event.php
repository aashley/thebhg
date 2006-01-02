<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage History
 * @Version $Rev$ $Date$
 */

/**
 * History Event Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage History
 * @Version $Rev$ $Date$
 */
class bhg_history_event extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('history_event', $id);
		$this->__addFieldMap(array(
					'person' => 'bhg_roster_person'
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

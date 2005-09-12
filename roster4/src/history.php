<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage History
 * @Version $Rev:$ $Date:$
 */

/**
 * History Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage History
 * @Version $Rev:$ $Date:$
 */
class bhg_history extends bhg_entry {

	// {{{ __construct()
	
	public function __construct() {

		parent::__construct();
		$this->__addCodePermissions(array('recordEvent' => 'history'));

	}

	// }}}

	// {{{ getEvent()

	static public function getEvent($id) {

		return bhg::loadObject('bhg_history_event', $id);

	}

	// }}}

	// {{{ recordEvent()

	public function recordEvent($type, bhg_roster_person $person, $item1 = null, $item2 = null, $item3 = null) {

		return $this->__recordHistoryEvent($type, $person, $item1, $item2, $item3);

	}

	// }}}

}

?>

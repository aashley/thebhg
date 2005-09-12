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

	// {{{ getEvent()

	static public function getEvent($id) {

		return bhg::loadObject('bhg_history_event', $id);

	}

	// }}}

}

?>

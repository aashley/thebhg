<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev:$ $Date:$
 */

/**
 * Roster Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev:$ $Date:$
 */
class bhg_roster extends bhg_entry {

	// {{{ getPerson()

	public function getPerson($id) {

		return $GLOBALS['bhg']->loadObject('bhg_roster_person', $id);

	}

	// }}}

}

?>

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

	// {{{ getCadre()

	static public function getCadre($id) {

		return bhg::loadObject('bhg_roster_cadre', $id);

	}

	// }}}
	// {{{ getDivision()

	static public function getDivision($id) {

		return bhg::loadObject('bhg_roster_division', $id);

	}
	
	// }}}
	// {{{ getDivisionCategory()

	static public function getDivisionCategory($id) {

		return bhg::loadObject('bhg_roster_division_category', $id);

	}

	// }}}
	// {{{ getNewPerson()

	static public function getNewPersion($id) {

		return bhg::loadObject('bhg_roster_new_person', $id);

	}

	// }}}
	// {{{ getPerson()

	static public function getPerson($id) {

		return bhg::loadObject('bhg_roster_person', $id);

	}

	// }}}
	// {{{ getPosition()

	static public function getPosition($id) {

		return bhg::loadObject('bhg_roster_position', $id);

	}

	// }}}
	// {{{ getRank()

	static public function getRank($id) {

		return bhg::loadObject('bhg_roster_rank', $id);

	}

	// }}}

}

?>

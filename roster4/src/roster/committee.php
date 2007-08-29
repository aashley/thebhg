<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev: 5532 $ $Date: 2007-08-23 15:17:07 -0400 (Thu, 23 Aug 2007) $
 */

/**
 * Roster Cadre Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev: 5532 $ $Date: 2007-08-23 15:17:07 -0400 (Thu, 23 Aug 2007) $
 */
class bhg_roster_committee extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 * 
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_committee', $id);
		$this->__addFieldMap(array(
					'chair'	=> 'bhg_roster_position',
					));
		$this->__addBooleanFields(array('standing', 'insession'));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getPeople()

	/**
	 * Get all people in this cadre
	 *
	 * @param array Filters to select which people to load
	 * @return bhg_core_list
	 */
	public function getPeople($filter = array()) {

		$filter['committee'] = $this;

		return $GLOBALS['bhg']->roster->getCommitteeMembers($filter);

	}

	// }}}

}

?>

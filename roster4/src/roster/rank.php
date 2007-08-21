<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */

/**
 * Roster Rank Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */
class bhg_roster_rank extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_rank', $id);
		$this->__addBooleanFields(array('alwaysavailable', 'unlimitedcredits', 'manuallyset', 'locked',
			'cadre', 'core', 'standard', 'initiate', 'inactive',
		));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

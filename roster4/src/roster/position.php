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
 * Roster Position Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */
class bhg_roster_position extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_position', $id);
		$this->__addBooleanFields(array('trainee', 'emailalias', 'cadreexempt', 'taxexempt', 'posdiv'));
		$this->__addFieldMap(array(
					'division' => 'bhg_roster_division',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{
	
	/**
	 * Checks to see if ths position has a division attachment
	 *
	 * @return void
	 */
	public function hasPosDiv(){
		return ($this->data['division'] != 0);
	}
	// }}}
}

?>

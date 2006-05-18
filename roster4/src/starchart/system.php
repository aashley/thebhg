<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage StarChart
 * @Version $Rev$ $Date$
 */

/**
 * Star Chart System Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage StarChart
 * @Version $Rev$ $Date$
 */
class bhg_starchart_system extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('starchart_system', $id);
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

	// {{{ getPlanets()

	/**
	 * Get all the planets within this system
	 *
	 * @param array Filters to select which planets to load
	 * @return bhg_core_list
	 */
	public function getPlanets($filter = array()) {

		$filter['system'] = $this;

		return $GLOBALS['bhg']->starchart->getPlanets($filter);

	}

	// }}}

}

?>

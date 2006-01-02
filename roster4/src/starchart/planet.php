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
 * Star Chart Planet Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage StarChart
 * @Version $Rev$ $Date$
 */
class bhg_starchart_planet extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('bhg_starchart_planet', $id);
		$this->__addFieldMap(array(
					'system' => 'bhg_starchart_system',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

	// {{{ getSites()

	/**
	 * Get all the sites on this planet
	 *
	 * @param array Filters to select which sites to load
	 * @return bhg_core_list
	 */
	public function getSites($filter = array()) {

		$filter['planet'] = $this;

		return $GLOBALS['bhg']->starchart->getSites($filter);

	}

	// }}}

}

?>

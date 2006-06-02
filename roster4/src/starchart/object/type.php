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
 * Star Chart Object Type Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage StarChart
 * @Version $Rev$ $Date$
 */
class bhg_starchart_object_type extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('starchart_object_type', $id);
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getAllowedAttributes()
	
	/**
	 * Get the list of attributes that are allowed on this object type
	 *
	 * @param array Filters
	 * @return bhg_core_list List of bhg_starchart_object_type_attributes
	 */
	public function getAllowedAttributes($filter = array()) {

		$filter['type'] = $this;

		return $GLOBALS['bhg']->starchart->getObjectTypeAttributes($filter);

	}

	// }}}
	// {{{ getInstances()
	
	/**
	 * Get all instances of this object type
	 *
	 * @param array Filters
	 * @return bhg_core_list List of bhg_starchart_objects
	 */
	public function getInstances($filter = array()) {

		$filter['type'] = $this;

		return $GLOBALS['bhg']->starchart->getObjects($filter);

	}

	// }}}

}

?>

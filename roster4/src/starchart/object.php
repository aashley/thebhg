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
 * Star Chart Object Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage StarChart
 * @Version $Rev$ $Date$
 */
class bhg_starchart_object extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('starchart_object', $id);
		$this->__addFieldMap(array(
					'parent'	=> 'bhg_starchart_object',
					'type'		=> 'bhg_starchart_type',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getAttributes()
	
	/**
	 * Get the Attributes of this object
	 *
	 * @param array Filters
	 * @return bhg_core_list List of bhg_starchart_object_attributes
	 */
	public function getAttributes($filter = array()) {

		$filter['object'] = $this;

		return $GLOBALS['bhg']->starchart->getObjectAttributes($filter);

	}

	// }}}
	// {{{ getChildren()
	
	/**
	 * Get the child objects of this object
	 *
	 * @param array Filters
	 * @return bhg_core_list list of bhg_starchart_objects
	 */
	public function getChildren($filter = array()) {

		$filter['parent'] = $this;

		return $GLOBALS['bhg']->starchart->getObjects($filter);

	}

	// }}}

}

?>

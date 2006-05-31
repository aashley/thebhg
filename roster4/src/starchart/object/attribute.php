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
 * Star Chart Object Attribute Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage StarChart
 * @Version $Rev$ $Date$
 */
class bhg_starchart_object_attribute extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('starchart_object_attribute', $id);
		$this->__addFieldMap(array(
					'type'		=> 'starchart_attribute_type',
					'object'	=> 'starchart_object',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

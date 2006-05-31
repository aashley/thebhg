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

}

?>

<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Library
 * @Version $Rev$ $Date$
 */

/**
 * Library Section Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Library
 * @Version $Rev$ $Date$
 */
class bhg_library_section extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 * 
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('bhg_library_section', $id);
		$this->__addFieldMap(array(
					'chapter' => 'bhg_library_chapter',
					));
		$this->__addBooleanFields(array('html'));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

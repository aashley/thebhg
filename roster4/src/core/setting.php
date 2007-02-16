<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Core
 * @Version $Rev: 4111 $ $Date: 2006-01-02 16:21:56 +0800 (Mon, 02 Jan 2006) $
 */

/**
 * Setting Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Core
 * @Version $Rev: 4111 $ $Date: 2006-01-02 16:21:56 +0800 (Mon, 02 Jan 2006) $
 */
class bhg_core_setting extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 * 
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('core_setting', $id);
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

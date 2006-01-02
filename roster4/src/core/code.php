<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage College
 * @Version $Rev$ $Date$
 */

/**
 * BHG Core Systems Code ID Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage College
 * @Version $Rev$ $Date$
 */
class bhg_core_code extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('core_code', $id);
		$this->__addBooleanFields(array('god', 'credits', 'purchase', 'kabal', 'medalaward', 'citadel', 'ssl', 'history', 'email', 'news', 'allnews', 'library', 'cadre', 'hunts', 'allhunts'));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

}

?>

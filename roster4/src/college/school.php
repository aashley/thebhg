<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage College
 * @Version $Rev: 4111 $ $Date: 2006-01-02 16:21:56 +0800 (Mon, 02 Jan 2006) $
 */

/**
 * College School Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage College
 * @Version $Rev: 4111 $ $Date: 2006-01-02 16:21:56 +0800 (Mon, 02 Jan 2006) $
 */
class bhg_college_school extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('college_school', $id);
		$this->__addDefaultCodePermissions('set', 'god');
		$this->__addDefaultCodePermissions('get', 'god');
	}

	// }}}
	// {{{ getExams()

	/**
	 * Get all the exams from within this school
	 *
	 * @param array Filters to select which exams to load
	 * @return bhg_core_list
	 */
	public function getExams($filter = array()) {

		$filter['school'] = $this;

		return $GLOBALS['bhg']->college->getExams($filter);

	}

	// }}}

}

?>

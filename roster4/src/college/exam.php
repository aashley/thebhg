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
 * College Exam Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage College
 * @Version $Rev$ $Date$
 */
class bhg_college_exam extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('college_exam', $id);
		$this->__addFieldMap(array(
					'notebook' => 'bhg_library_book'
					));
		$this->__addDefaultCodePermissions('set', 'god');
		$this->__addDefaultCodePermissions('get', 'god');
	}

	// }}}
	// {{{ getQuestions()

	/**
	 * Get all the questions related to this exam
	 *
	 * @param array Filters to select which questions to return
	 * @return bhg_core_list
	 */
	public function getQuestions($filter = array()) {

		$filter['exam'] = $this;

		return $GLOBALS['bhg']->college->getQuestions($filter);

	}

	// }}}
	// {{{ getSubmissions()

	/**
	 * Get all the submissions to this exam
	 *
	 * @param array Filters to select which submissions to return
	 * @return bhg_core_list
	 */
	public function getSubmissions($filter = array()) {

		$filter['exam'] = $this;

		return $GLOBALS['bhg']->college->getSubmissions($filter);

	}

	// }}}

}

?>

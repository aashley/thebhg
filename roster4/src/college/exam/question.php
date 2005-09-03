<?php

class bhg_college_exam_question extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('college_exam_question', $id);
		$this->__addFieldMap(array(
					'exam' => 'bhg_college_exam'
					));
		$this->__addBooleanFields(array('mandatory'));
		$this->__addDefaultCodePermissions('set', 'god');
		$this->__addDefaultCodePermissions('get', 'god');
	}

	// }}}

}

?>

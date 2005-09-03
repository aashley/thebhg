<?php

class bhg_college_submission_answer extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('college_submission_answer', $id);
		$this->__addFieldMap(array(
					'submission' => 'college_submission',
					'question' => 'college_exam_question',
					));
		$this->__addDefaultCodePermissions('set', 'god');
		$this->__addDefaultCodePermissions('get', 'god');
	}

	// }}}

}

?>

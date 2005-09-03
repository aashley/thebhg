<?php

class bhg_college_exam_reward extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('college_exam_reward', $id);
		$this->__addFieldMap(array(
					'exam' => 'bhg_college_exam'
					));
		$this->__addDefaultCodePermissions('set', 'god');
		$this->__addDefaultCodePermissions('get', 'god');
	}

	// }}}

}

?>

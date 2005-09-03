<?php

class bhg_college_submission extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('college_submission', $id);
		$this->__addFieldMap(array(
					'exam' => 'bhg_college_exam',
					'submitter' => 'bhg_roster_person',
					));
		$this->__addBooleanFields(array('graded', 'passed'));
		$this->__addDefaultCodePermissions('set', 'god');
		$this->__addDefaultCodePermissions('get', 'god');
	}

	// }}}

}

?>

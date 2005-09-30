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

	// {{{ getStatus()

	/**
	 * Returns the submission status as a human-readable string.
	 *
	 * @return string
	 */
	public function getStatus() {

		if ($this->isGraded())
			if ($this->isPassed())
				return 'Pass';
			else
				return 'Fail';
		else
			return 'Ungraded';
		
	}

	// }}}

}

?>

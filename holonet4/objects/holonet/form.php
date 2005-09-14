<?php

include_once 'HTML/QuickForm.php';

class holonet_form extends HTML_QuickForm {

	public function addButtons($submitText = null) {

		$elements = array();

		$elements[] = HTML_QuickForm::createElement('submit',
																								null,
																								$submitText);

		$elements[] = HTML_QuickForm::createElement('reset',
																								null,
																								'Reset');

		return $this->addGroup($elements,
													 null,
													 null,
													 ' ');

	}

}

?>

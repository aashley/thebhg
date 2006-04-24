<?php

include_once 'HTML/QuickForm.php';

class holonet_form extends HTML_QuickForm {

	public function __construct($formName='', $method='post', $action='', $target='', $attributes=null, $trackSubmit = true) {

		parent::HTML_QuickForm($formName, $method, $action, $target, $attributes, $trackSubmit);

		$this->removeAttribute('name');

	}

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

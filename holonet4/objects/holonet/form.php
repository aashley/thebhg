<?php

include_once 'HTML/QuickForm.php';

class holonet_form extends HTML_QuickForm {

	public function __construct($formName='', $method='post', $action='', $target='', $attributes=null, $trackSubmit = true) {

		parent::HTML_QuickForm($formName, $method, $action, $target, $attributes, $trackSubmit);

		$this->removeAttribute('name');
		$this->registerElementType('personselect', 'objects/holonet/form/person.php', 'holonet_form_person');

		$renderer = $this->defaultRenderer();

		$renderer->setHeaderTemplate("\n"
				."\t<tr>\n"
				."\t\t<th style=\"white-space: nowrap;\" colspan=\"2\">{header}</th>\n"
				."\t</tr>\n");

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<td align=\"right\" valign=\"top\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
				."\t\t<td valign=\"top\" align=\"left\"><!-- BEGIN error --><span style=\"color: #ff0000\">{error}</span><br /><!-- END error -->\t{element}</td>\n"
				."\t</tr>");

		$renderer->setFormTemplate("\n"
				."<form{attributes}>\n"
				."<div>\n"
				."{hidden}"
				."<table class=\"form\">\n"
				."{content}\n"
				."</table>\n"
				."</div>\n"
				."</form>");

		$renderer->setRequiredNoteTemplate("\n"
				."\t<tr>\n"
				."\t\t<td></td>\n"
				."\t\t<td align=\"left\" valign=\"top\">{requiredNote}</td>\n"
				."\t</tr>");

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

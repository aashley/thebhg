<?php

class page_roster_administration_members_reassign extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Reassign Members');

		$form = new holonet_form('reassign_members');
		$renderer =& $form->defaultRenderer();

		$form->addElement('static',
				'reassign_header',
				array(
					'&nbsp;',
					'Person',
					'New Division',
					'New Position',
					));

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<th class=\"label\">{label}</th>\n"
				."\t\t<th class=\"label_2\">{label_2}</th>\n"
				."\t\t<th class=\"label_3\">{label_3}</th>\n"
				."\t\t<th class=\"label_4\">{label_4}</th>\n"
				."\t</tr>",
				'reassign_header');

		$divisions = array(0 => 'No Change');

		foreach ($GLOBALS['bhg']->roster->getDivisionCategories() as $category) {

			foreach ($category->getDivisions() as $division) {

				$divisions[$division->getID()] = $division->getName();

			}

		}

		$positions = array(0 => 'No Change');

		foreach ($GLOBALS['bhg']->roster->getPositions() as $position) {

			$positions[$position->getID()] = $position->getName();

		}

		for ($i = 0; $i < 10; $i++) {

			$fields = array();

			$fields[] = $form->createElement('personselect',
					'person',
					null);

			$fields[] = $form->createElement('select',
					'division',
					null,
					$divisions);

			$fields[] = $form->createElement('select',
					'position',
					null,
					$positions);

			$form->addGroup($fields, 'reassign['.$i.']', ($i + 1));

			$renderer->setElementTemplate("\n"
					."\t<tr>\n"
					."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
					."\t\t{element}\n"
					."\t</tr>",
					'reassign['.$i.']');

			$renderer->setGroupTemplate("\n{content}", 'reassign['.$i.']');
			$renderer->setGroupElementTemplate("\n<td valign=\"top\">{element}</td>", 'reassign['.$i.']');

		}

		$form->addButtons('Reassign Members');

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
				."\t\t<td colspan=\"3\">{element}</td>\n"
				."\t</tr>",
				'__submit_group');

		if ($form->validate()) {

			$values = $form->exportValues();

			$this->addBodyContent('<pre>'.print_r($values, true).'</pre>');

			$this->addBodyContent('<p>');

			if (isset($values['reassign']) && is_array($values['reassign'])) {

				foreach ($values['reassign'] as $id => $data) {

				}

			}

			$this->addBodyContent('</p>');

		} else {

			$this->addBodyContent($form);

		}

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		if (	 $user->getID() == 94
				|| $user->getPosition()->isEqualTo(bhg_roster::getPosition(2))) {

			return true;

		} else {

			return false;

		}

	}

}

?>

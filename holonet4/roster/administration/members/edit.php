<?php

class page_roster_administration_members_edit extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Edit Hunter Details');

		$form = new holonet_form('edit_members', 'post', '/roster/administration/members/my');
		$renderer =& $form->defaultRenderer();

		$form->addElement('static',
				'edit_header',
				array(
					'&nbsp;',
					'Person',
					));

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<th class=\"label\">{label}</th>\n"
				."\t\t<th class=\"label_2\">{label_2}</th>\n"
				."\t</tr>",
				'edit_header');

		for ($i = 0; $i < 1; $i++) {

			$fields = array();

			$fields[] = $form->createElement('personselect',
					'person',
					null);

			$form->addGroup($fields, 'edit['.$i.']', ($i + 1));

			$renderer->setElementTemplate("\n"
					."\t<tr>\n"
					."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
					."\t\t{element}\n"
					."\t</tr>",
					'reassign['.$i.']');

			$renderer->setGroupTemplate("\n{content}", 'reassign['.$i.']');
			$renderer->setGroupElementTemplate("\n<td valign=\"top\">{element}</td>", 'reassign['.$i.']');

		}

		$form->addButtons('Edit Member');

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
				."\t\t<td colspan=\"3\">{element}</td>\n"
				."\t</tr>",
				'__submit_group');

		$this->addBodyContent($form);

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

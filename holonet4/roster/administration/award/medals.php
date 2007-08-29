<?php

class page_roster_administration_award_medals extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Award Medals');

		$user = $GLOBALS['bhg']->user;
		$form = new holonet_form('award_medals');
		$renderer =& $form->defaultRenderer();

		$defaults = array();

		if (	 $user->getID() == 94
				|| $user->getPosition()->isEqualTo(bhg_roster::getPosition(2))) {
			$form->addElement('personselect',
					'awarder',
					'Awarder:');
			$defaults['awarder'] = array($user->getDivision()->getID(), $user->getID());
			$renderer->setElementTemplate("\n"
					."\t<tr>\n"
					."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
					."\t\t<td colspan=\"3\">{element}</td>\n"
					."\t</tr>",
					'awarder');
		}

		$form->addElement('static',
				'medals_header',
				array(
					'&nbsp;',
					'Recipient',
					'Award',
					'Reason',
					));

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<th class=\"label\">{label}</th>\n"
				."\t\t<th class=\"label_2\">{label_2}</th>\n"
				."\t\t<th class=\"label_3\">{label_3}</th>\n"
				."\t\t<th class=\"label_4\">{label_4}</th>\n"
				."\t</tr>",
				'medals_header');

		for ($i = 0; $i < 10; $i++) {

			$fields = array();

			if ($user->getPosition()->isEqualTo(bhg_roster::getPosition(11)))
				$divisions = $user->getDivision();
			else
				$divisions = null;

			$fields[] = $form->createElement('personselect',
					'recipient',
					null,
					null,
					null,
					$divisions);
					
			$medals = array(0 => '-- Select Medal --');

			foreach ($GLOBALS['bhg']->medalboard->getGroups() as $group) {
	
				$medals[$group->getID()] = $group->getName();
	
			}
			
			$fields[] = $form->createElement('select',
					'award',
					null,
					$medals);
					
			$fields[] = $form->createElement('text',
					'reason',
					null,
					array(
						'size'		=> 40,
						'maxlength'	=> 150,
						));
			

			$form->addGroup($fields, 'medal['.$i.']', ($i + 1));

			$renderer->setElementTemplate("\n"
					."\t<tr>\n"
					."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
					."\t\t{element}\n"
					."\t</tr>",
					'medal['.$i.']');
					
			$renderer->setGroupTemplate("\n{content}", 'medal['.$i.']');
			$renderer->setGroupElementTemplate("\n<td valign=\"top\">{element}</td>", 'medal['.$i.']');
		}

		$form->addButtons('Award Medals');

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
				."\t\t<td colspan=\"3\">{element}</td>\n"
				."\t</tr>",
				'__submit_group');

		$form->setDefaults($defaults);

		if ($form->validate()) {

			$values = $form->exportValues();

			if (isset($values['awarder']) && is_array($values['awarder'])) {

				$awarder = bhg_roster::getPerson($values['awarder'][1]);

			} else {

				$awarder = $user;

			}

			$awards = array();

			foreach ($values['medal'] as $id => $data) {

				if ($data['award'] > 0) {

					$recipient = bhg_roster::getPerson($data['recipient'][1]);

					$awards[] = $recipient->requestMedalAward($awarder, $data['award'], $data['reason']);

				}

			}

			foreach ($awards as $award) {

				$this->addBodyContent('<p>');

				if (	 $user->getPosition()->isEqualTo(bhg_roster::getPosition(2))
						|| $user->getID() == 2650) {

					if ($award->approve()) {

						$this->addBodyContent('Awarded '.$award->getMedal()->getName().' to '.
								$award->getRecipient()->getName().' of '.$award->getRecipient()->getDivision()->getName()
								.'.');

					} else {

						$this->addBodyContent('Failed to awarded '.$award->getMedal()->getName().' to '.
								$award->getRecipient()->getName().' of '.$award->getRecipient()->getDivision()->getName()
								.'.');

					}
					
				} else {
					
					$this->addBodyContent('Requesting '.$award->getMedal()->getName().' for '.
								$award->getRecipient()->getName().' of '.$award->getRecipient()->getDivision()->getName()
								.'.');

				}

				$this->addBodyContent('</p>');

			}
				
		} else {

			$this->addBodyContent($form);

		}

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		if (	 $user->getID() == 2650
				|| $user->inDivision($GLOBALS['bhg']->roster->getDivision(10))) {

			return true;

		} else {

			return false;

		}

	}

}

?>

<?php

class page_roster_administration_cadre_members_manage extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Manage Members');

		$user = $GLOBALS['bhg']->user;
		
		$form = new holonet_form('reassign_members');
		$renderer =& $form->defaultRenderer();

		$form->addElement('static',
				'reassign_header',
				array(
					'&nbsp;',
					'Person',
					'New Division',
					'New Rank',
					));

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<th class=\"label\">{label}</th>\n"
				."\t\t<th class=\"label_2\">{label_2}</th>\n"
				."\t\t<th class=\"label_3\">{label_3}</th>\n"
				."\t\t<th class=\"label_4\">{label_4}</th>\n"
				."\t</tr>",
				'reassign_header');

		$division = bhg_roster::getDivision(25);
				
		$divisions = array(0 => 'No Change', $division->getID() => $division->getName());

		$ranks = array(0 => 'No Change');

		foreach ($GLOBALS['bhg']->roster->getRanks(array('division' => $user->getCadre())) as $rank) {

			$ranks[$rank->getID()] = $rank->getName();

		}

		$members = $user->getCadre()->getPeople();
		
		foreach ($members as $member) {

			if ($member->isEqualTo($user)) continue;
			
			$fields = array();

			$fields[] = $form->createElement('static',
					null,
					null,
					$member->getName());

			$fields[] = $form->createElement('select',
					'division',
					null,
					$divisions);
					
			$fields[] = $form->createElement('select',
					'rank',
					null,
					$ranks);

			$form->addGroup($fields, 'reassign['.$member->getID().']', ($i + 1));

			$renderer->setElementTemplate("\n"
					."\t<tr>\n"
					."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
					."\t\t{element}\n"
					."\t</tr>",
					'reassign['.$member->getID().']');

			$renderer->setGroupTemplate("\n{content}", 'reassign['.$member->getID().']');
			$renderer->setGroupElementTemplate("\n<td valign=\"top\">{element}</td>", 'reassign['.$member->getID().']');

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

			$this->addBodyContent('<p>');

			if (isset($values['reassign']) && is_array($values['reassign'])) {

				foreach ($values['reassign'] as $id => $data) {

					if (!($data['division'] == 0 && $data['rank'] == 0)) {

						$person = bhg_roster::getPerson($id);

						if ($data['rank'] != 0) {

							$rank = bhg_roster::getRank($data['rank']);

							$this->addBodyContent('Rank: '.$person->getName().' from '
									.$person->getRank()->getName().' to '
									.$rank->getName().'... ');

							if ($person->setCadreRank($rank)) {

								$this->addBodyContent('Success.<br/>');
								
							} else {

								$this->addBodyContent('Failure.<br/>');

							}

						}
						
						if ($data['division'] != 0) {

							$division = bhg_roster::getDivision($data['division']);

							$this->addBodyContent('Division: '.$person->getName().' from '
									.$person->getDivision()->getName().' to '
									.$division->getName().'... ');

							if ($person->transfer($division)) {

								$this->addBodyContent('Success.<br/>');
								
							} else {

								$this->addBodyContent('Failure.<br/>');

							}

						}

					}

				}

			}

			$this->addBodyContent('</p>');

		} else {

			$this->addBodyContent($form);

		}

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		return $user->isCadreLeader();

	}

}

?>

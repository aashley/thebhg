<?php

class page_roster_administration_vanguard_approve extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Approve Cadres and Confederations');

		$form = new holonet_form('approve_cadres');
		$renderer =& $form->defaultRenderer();

		$form->addElement('hidden', 'tabBar', 'credits_tab');

		$form->addElement('static',
				'cadres_header',
				array(
					'&nbsp;',
					'Leader',
					'Name',
					'Slogan',
					'Logo',
					'Welcome',
					'Approve',
					));

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<th class=\"label\">{label}</th>\n"
				."\t\t<th class=\"label_2\">{label_2}</th>\n"
				."\t\t<th class=\"label_3\">{label_3}</th>\n"
				."\t\t<th class=\"label_4\">{label_4}</th>\n"
				."\t\t<th class=\"label_5\">{label_5}</th>\n"
				."\t\t<th class=\"label_6\">{label_6}</th>\n"
				."\t\t<th class=\"label_7\">{label_7}</th>\n"
				."\t</tr>",
				'cadres_header');

		$pendingCadres = $GLOBALS['bhg']->roster->getPendingCadres();

		$defaults = array();

		foreach ($pendingCadres as $pendingCadre) {

			$fields = array();

			$fields[] = $form->createElement('static',
					null,
					null,
					$pendingCadre->getLeader()->getName());

			$fields[] = $form->createElement('text',
					'name',
					null,
					array(
						'size'		  => 15,
						'maxlength' => 150,
						));

			$fields[] = $form->createElement('text',
					'slogan',
					null,
					array(
						'size'		  => 20,
						'maxlength' => 150,
						));
						
			$fields[] = $form->createElement('text',
					'logo',
					null,
					array(
						'size'		  => 20,
						'maxlength' => 150,
						));

			$fields[] = $form->createElement('textarea',
					'welcome',
					null,
					array(
						'rows'	=> 10,
						'cols'	=> 40,
						));

			$fields[] = $form->createElement('select',
					'approve',
					null,
					array(
						'approve' => 'Approve',
						'hold'		=> 'Hold',
						'deny'		=> 'Deny',
						));

			$form->addGroup($fields, 'pendingCadre['.$pendingCadre->getID().']', $pendingCadre->getID());

			$renderer->setElementTemplate("\n"
					."\t<tr>\n"
					."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
					."\t\t{element}\n"
					."\t</tr>",
					'pendingCadre['.$pendingCadre->getID().']');
					
			$renderer->setGroupTemplate("\n{content}", 'pendingCadre['.$pendingCadre->getID().']');
			$renderer->setGroupElementTemplate("\n<td valign=\"top\">{element}</td>", 'pendingCadre['.$pendingCadre->getID().']');

			$defaults['pendingCadre['.$pendingCadre->getID().'][name]'] = $pendingCadre->getName();
			$defaults['pendingCadre['.$pendingCadre->getID().'][slogan]'] = $pendingCadre->getSlogan();
			$defaults['pendingCadre['.$pendingCadre->getID().'][logo]'] = $pendingCadre->getLogo();
			$defaults['pendingCadre['.$pendingCadre->getID().'][welcome]'] = $pendingCadre->getWelcome();
			$defaults['pendingCadre['.$pendingCadre->getID().'][approve]'] = 'hold';

		}

		$form->addButtons('Approve Credits');

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
				."\t\t<td colspan=\"6\">{element}</td>\n"
				."\t</tr>",
				'__submit_group');

		$form->setDefaults($defaults);

		if ($form->validate()) {

			$values = $form->exportValues();

			$this->addBodyContent('<p>');

			foreach ($values['pendingCadre'] as $id => $data) {

				$pendingCadre = bhg_roster::getpendingCadre($id);

				if ($data['approve'] == 'approve') {

					$pendingCadre->setName($data['name']);
					$pendingCadre->setSlogan($data['slogan']);
					$pendingCadre->setLogo($data['logo']);
					$pendingCadre->setWelcome($data['welcome']);

					$this->addBodyContent('Approving '.$pendingCadre->getName().'<br/>');

					$pendingCadre->approve();

				} elseif ($data['approve'] == 'deny') {

					$this->addBodyContent('Denying '.$pendingCadre->getName().'<br/>');
					$pendingCadre->deny();

				} else {

					$this->addBodyContent('Holding '.$pendingCadre->getName().'<br/>');

				}

			}

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

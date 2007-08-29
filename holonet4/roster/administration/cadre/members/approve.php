<?php

class page_roster_administration_cadre_members_approve extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Approve/Invite Applicants');

		$user = $GLOBALS['bhg']->user;
		
		if (!$user->isCadreLeader()){ $this->addBodyContent('You do not have authority to access this module.'); return; }
		
		$bar = new holonet_tab_bar();

		$bar->addTab($this->buildApproveTransfers());
		$bar->addTab($this->buildInvitePerson());

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function buildInvitePerson() {

		$tab = new holonet_tab('invite_tab', 'Invite Member');
		
		$user = $GLOBALS['bhg']->user;
		
		$this->pageBuilt = true;

		$form = new holonet_form('invite_members');
		$renderer =& $form->defaultRenderer();

		$form->addElement('hidden',	'tabBar', 'invite_tab');
		
		$form->addElement('static',
				'invite_header',
				array(
					'&nbsp;',
					'Person',
					));

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<th class=\"label\">{label}</th>\n"
				."\t\t<th class=\"label_2\">{label_2}</th>\n"
				."\t</tr>",
				'invite_header');

		for ($i = 0; $i < 10; $i++) {

			$fields = array();

			$fields[] = $form->createElement('personselect',
					'person',
					null);

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

		$form->addButtons('Invite Members');

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
				."\t\t<td colspan=\"2\">{element}</td>\n"
				."\t</tr>",
				'__submit_group');

		if ($form->validate()) {

			$values = $form->exportValues();

			if (isset($values['reassign']) && is_array($values['reassign'])) {

				$tab->addContent('<p>');
				
				foreach ($values['reassign'] as $id => $data) {

					if ($data['person'][0] == -1) continue;
					
					$person = bhg_roster::getPerson($data['person'][1]);

					$search = $GLOBALS['bhg']->roster->getPendingTransfers(array('person' => $person, 
						'target' => $user->getCadre(), 'invite' => -1));
					
					if ($search->count()){
						$tab->addContent($person->getName() . ' has a pending transfer for this Cadre. Ignoring.<br />');
						
						continue;
					}
					
					if ($person->getDivision()->isEqualTo($user->getCadre())){
						$tab->addContent($person->getName() . ' is in your Cadre already! Ignoring.<br />');
						
						continue;
					}
					
					try {
						$tab->addContent('Inviting '.$person->getName().' to join '
									.$user->getCadre()->getName().'... ');
					
						$person->requestTransfer($user->getCadre(), 1);
						
						$tab->addContent('Success.<br />');
					} catch (Exception $e){
						$tab->addContent('Failed.<br />');
					}
					
				}

				$tab->addContent('</p>');
			}
			
		} else {

			$tab->addContent($form);

		}
	
		return $tab;

	}
	
	public function buildApproveTransfers() {

		$tab = new holonet_tab('transfers_tab', 'Approve Applicants');

		$user = $GLOBALS['bhg']->user;
		
		$form = new holonet_form('approve_transfers');
		$renderer =& $form->defaultRenderer();

		$form->addElement('hidden', 'tabBar', 'transfers_tab');

		$form->addElement('static',
				'transfers_header',
				array(
					'&nbsp;',
					'Person',
					'From',
					'Accept as Rank',
					'Approve',
					));

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<th class=\"label\">{label}</th>\n"
				."\t\t<th class=\"label_2\">{label_2}</th>\n"
				."\t\t<th class=\"label_3\">{label_3}</th>\n"
				."\t\t<th class=\"label_4\">{label_4}</th>\n"
				."\t\t<th class=\"label_5\">{label_5}</th>\n"
				."\t</tr>",
				'transfers_header');

		$pendingTransfers = $GLOBALS['bhg']->roster->getPendingTransfers(array('target' => $user->getCadre()));

		$defaults = array();

		foreach ($pendingTransfers as $pendingTransfer) {

			$fields = array();

			$fields[] = $form->createElement('static',
					null,
					null,
					$pendingTransfer->getPerson()->getName());

			$fields[] = $form->createElement('static',
					null,
					null,
					$pendingTransfer->getPerson()->getDivision()->getName());

			$ranks = array();

			foreach ($GLOBALS['bhg']->roster->getRanks(array('division' => $user->getCadre())) as $rank) {
	
				$ranks[$rank->getID()] = $rank->getName();
	
			}
		
			$fields[] = $form->createElement('select',
					'rank',
					null,
					$ranks);
					
			$fields[] = $form->createElement('select',
					'approve',
					null,
					array(
						'approve' => 'Approve',
						'hold'		=> 'Hold',
						'deny'		=> 'Deny',
						));

			$form->addGroup($fields, 'pendingTransfer['.$pendingTransfer->getID().']', $pendingTransfer->getID());

			$renderer->setElementTemplate("\n"
					."\t<tr>\n"
					."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
					."\t\t{element}\n"
					."\t</tr>",
					'pendingTransfer['.$pendingTransfer->getID().']');
					
			$renderer->setGroupTemplate("\n{content}", 'pendingTransfer['.$pendingTransfer->getID().']');
			$renderer->setGroupElementTemplate("\n<td valign=\"top\">{element}</td>", 'pendingTransfer['.$pendingTransfer->getID().']');

			$defaults['pendingTransfer['.$pendingTransfer->getID().'][rank]'] = $user->getCadre()->getDefaultRank()->getID();
			$defaults['pendingTransfer['.$pendingTransfer->getID().'][approve]'] = 'approve';

		}

		$form->addButtons('Approve Applicants');

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
				."\t\t<td colspan=\"6\">{element}</td>\n"
				."\t</tr>",
				'__submit_group');

		$form->setDefaults($defaults);

		if ($form->validate()) {

			$values = $form->exportValues();

			$tab->addContent('<p>');

			if (isset($values['pendingTransfer']) && is_array($values['pendingTransfer'])) {

				foreach ($values['pendingTransfer'] as $id => $data) {

					$pendingTransfer = bhg_roster::getPendingTransfer($id);

					if ($data['approve'] == 'approve') {
						
						$rank = bhg_roster::getRank($data['rank']);
						
						$tab->addContent('Approving pending transfer #'.$pendingTransfer->getID().' of '
								.$pendingTransfer->getPerson()->getName().' from '
								.$pendingTransfer->getPerson()->getDivision()->getName().' to '
								.$pendingTransfer->getTarget()->getName().' as ' . $rank->getName() . '<br/>');

						$pendingTransfer->getPerson()->setCadreRank($rank);
								
						$pendingTransfer->approve();
						
					} elseif ($data['approve'] == 'deny') {

						$tab->addContent('Deny pending transfer #'.$pendingTransfer->getID().'<br/>');
						$pendingTransfer->deny();

					} else {

						$tab->addContent('Holding pending transfer #'.$pendingTransfer->getID().'<br/>');

					}

				}

			}

			$tab->addContent('<p>');

		} else {
			
			$tab->addContent($form);

		}

		return $tab;

	}

	public function canAccessPage(bhg_roster_person $user) {

		return $user->isCadreLeader();

	}

}

?>

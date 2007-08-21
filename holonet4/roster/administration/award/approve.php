<?php

class page_roster_administration_award_approve extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Approve Awards');

		$bar = new holonet_tab_bar();

		$bar->addTab($this->buildApproveCredits());
		$bar->addTab($this->buildApproveMedals());

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function buildApproveCredits() {

		$tab = new holonet_tab('credits_tab', 'Approve Credits');

		$form = new holonet_form('approve_credits');
		$renderer =& $form->defaultRenderer();

		$form->addElement('hidden', 'tabBar', 'credits_tab');

		$form->addElement('static',
				'credits_header',
				array(
					'&nbsp;',
					'Recipient',
					'Awarder',
					'Rank Credits',
					'Account Credits',
					'Reason',
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
				'credits_header');

		$pendingCredits = $GLOBALS['bhg']->roster->getPendingCredits();

		$defaults = array();

		foreach ($pendingCredits as $pendingCredit) {

			$fields = array();

			$fields[] = $form->createElement('static',
					null,
					null,
					$pendingCredit->getRecipient()->getName());

			$fields[] = $form->createElement('static',
					null,
					null,
					$pendingCredit->getAwarder()->getName());

			$fields[] = $form->createElement('text',
					'amount',
					null,
					array(
						'size'		  => 10,
						'maxlength' => 15,
						));
						
			$fields[] = $form->createElement('text',
					'account',
					null,
					array(
						'size'		  => 10,
						'maxlength' => 15,
						));

			$fields[] = $form->createElement('textarea',
					'reason',
					null,
					array(
						'rows'	=> 2,
						'cols'	=> 20,
						));

			$fields[] = $form->createElement('select',
					'approve',
					null,
					array(
						'approve' => 'Approve',
						'hold'		=> 'Hold',
						'deny'		=> 'Deny',
						));

			$form->addGroup($fields, 'pendingCredit['.$pendingCredit->getID().']', $pendingCredit->getID());

			$renderer->setElementTemplate("\n"
					."\t<tr>\n"
					."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
					."\t\t{element}\n"
					."\t</tr>",
					'pendingCredit['.$pendingCredit->getID().']');
					
			$renderer->setGroupTemplate("\n{content}", 'pendingCredit['.$pendingCredit->getID().']');
			$renderer->setGroupElementTemplate("\n<td valign=\"top\">{element}</td>", 'pendingCredit['.$pendingCredit->getID().']');

			$defaults['pendingCredit['.$pendingCredit->getID().'][recipient]'] = $pendingCredit->getRecipient();
			$defaults['pendingCredit['.$pendingCredit->getID().'][amount]'] = $pendingCredit->getAmount();
			$defaults['pendingCredit['.$pendingCredit->getID().'][account]'] = $pendingCredit->getAccount();
			$defaults['pendingCredit['.$pendingCredit->getID().'][reason]'] = $pendingCredit->getReason();
			$defaults['pendingCredit['.$pendingCredit->getID().'][approve]'] = 'approve';

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

			$tab->addContent('<p>');

			foreach ($values['pendingCredit'] as $id => $data) {

				$pendingCredit = bhg_roster::getPendingCredit($id);

				if ($data['approve'] == 'approve') {

					$pendingCredit->setAmount($data['amount']);
					$pendingCredit->setAccount($data['account']);
					$pendingCredit->setReason($data['reason']);

					$tab->addContent('Approving pending credit award #'.$pendingCredit->getID().' of '
							.number_format($pendingCredit->getAmount()).' rank, '
							.number_format($pendingCredit->getAmount()).' account  to '
							.$pendingCredit->getRecipient()->getName().'<br/>');

					$pendingCredit->approve();

				} elseif ($data['approve'] == 'deny') {

					$tab->addContent('Deny pending credit award #'.$pendingCredit->getID().'<br/>');
					$pendingCredit->deny();

				} else {

					$tab->addContent('Holding pending credit award #'.$pendingCredit->getID().'<br/>');

				}

			}

		} else {
			
			$tab->addContent($form);

		}

		return $tab;

	}

	public function buildApproveMedals() {

		$tab = new holonet_tab('medals_tab', 'Approve Medals');

		$form = new holonet_form('approve_medals');
		$renderer =& $form->defaultRenderer();

		$form->addElement('hidden', 'tabBar', 'medals_tab');

		$form->addElement('static',
				'medals_header',
				array(
					'&nbsp;',
					'Recipient',
					'Awarder',
					'Amount',
					'Reason',
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
				."\t</tr>",
				'medals_header');

		$pendingMedals = $GLOBALS['bhg']->roster->getPendingMedals();

		$defaults = array();

		foreach ($pendingMedals as $pendingMedal) {

			$fields = array();

			$fields[] = $form->createElement('static',
					null,
					null,
					$pendingMedal->getRecipient()->getName());

			$fields[] = $form->createElement('static',
					null,
					null,
					$pendingMedal->getAwarder()->getName());

			$fields[] = $form->createElement('text',
					'medal',
					null,
					array(
						'size'		  => 10,
						'maxlength' => 15,
						));

			$fields[] = $form->createElement('textarea',
					'reason',
					null,
					array(
						'rows'	=> 2,
						'cols'	=> 20,
						));

			$fields[] = $form->createElement('select',
					'approve',
					null,
					array(
						'approve' => 'Approve',
						'hold'		=> 'Hold',
						'deny'		=> 'Deny',
						));

			$form->addGroup($fields, 'pendingMedal['.$pendingMedal->getID().']', $pendingMedal->getID());

			$renderer->setElementTemplate("\n"
					."\t<tr>\n"
					."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
					."\t\t{element}\n"
					."\t</tr>",
					'pendingMedal['.$pendingMedal->getID().']');
					
			$renderer->setGroupTemplate("\n{content}", 'pendingMedal['.$pendingMedal->getID().']');
			$renderer->setGroupElementTemplate("\n<td valign=\"top\">{element}</td>", 'pendingMedal['.$pendingMedal->getID().']');

			$defaults['pendingMedal['.$pendingMedal->getID().'][recipient]'] = $pendingMedal->getRecipient();
			$defaults['pendingMedal['.$pendingMedal->getID().'][medal]'] = $pendingMedal->getMedal();
			$defaults['pendingMedal['.$pendingMedal->getID().'][reason]'] = $pendingMedal->getReason();
			$defaults['pendingMedal['.$pendingMedal->getID().'][approve]'] = 'approve';

		}

		$form->addButtons('Approve Medals');

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
				."\t\t<td colspan=\"5\">{element}</td>\n"
				."\t</tr>",
				'__submit_group');

		$form->setDefaults($defaults);

		if ($form->validate()) {

			$values = $form->exportValues();

			$tab->addContent('<p>');

			foreach ($values['pendingMedal'] as $id => $data) {

				$pendingMedal = bhg_roster::getPendingMedal($id);

				if ($data['approve'] == 'approve') {

					$pendingMedal->setAmount($data['amount']);
					$pendingMedal->setReason($data['reason']);

					$tab->addContent('Approving pending medal award #'.$pendingMedal->getID().' of '
							.number_format($pendingMedal->getAmount()).' to '
							.$pendingMedal->getRecipient()->getName().'<br/>');

					$pendingMedal->approve();

				} elseif ($data['approve'] == 'deny') {

					$tab->addContent('Deny pending medal award #'.$pendingMedal->getID().'<br/>');
					$pendingMedal->deny();

				} else {

					$tab->addContent('Holding pending medal award #'.$pendingMedal->getID().'<br/>');

				}

			}

		} else {
			
			$tab->addContent($form);

		}

		return $tab;

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

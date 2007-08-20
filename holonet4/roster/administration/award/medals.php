<?php

class page_roster_administration_award_credits extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Award Credits');

		$user = $GLOBALS['bhg']->user;
		$form = new holonet_form('award_credits');
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
					."\t\t<td colspan=\"2\">{element}</td>\n"
					."\t</tr>",
					'awarder');
		}

		$form->addElement('textarea',
				'reason',
				'Reason:',
				array(
					'rows' => 4,
					'cols' => 40,
					));

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
				."\t\t<td colspan=\"4\">{element}</td>\n"
				."\t</tr>",
				'reason');

		$form->addElement('static',
				'credits_header',
				array(
					'&nbsp;',
					'Recipient',
					'Rank Credits',
					'Rank -> Account',
					'Account Credits',
					));

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<th class=\"label\">{label}</th>\n"
				."\t\t<th class=\"label_2\">{label_2}</th>\n"
				."\t\t<th class=\"label_3\">{label_3}</th>\n"
				."\t\t<th class=\"label_4\">{label_4}</th>\n"
				."\t\t<th class=\"label_5\">{label_5}</th>\n"
				."\t</tr>",
				'credits_header');

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
					
			$fields[] = $form->createElement('text',
					'amount',
					null,
					array(
						'size'			=> 10,
						'maxlength'	=> 15,
						));
			
			$fields[] = $form->createElement('checkbox',
					'combine',
					null);
						
			$fields[] = $form->createElement('text',
					'account',
					null,
					array(
						'size'			=> 5,
						'maxlength'	=> 15,
						));

			$form->addGroup($fields, 'credit['.$i.']', ($i + 1));

			$renderer->setElementTemplate("\n"
					."\t<tr>\n"
					."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
					."\t\t{element}\n"
					."\t</tr>",
					'credit['.$i.']');
					
			$renderer->setGroupTemplate("\n{content}", 'credit['.$i.']');
			$renderer->setGroupElementTemplate("\n<td valign=\"top\">{element}</td>", 'credit['.$i.']');

			$defaults['credit['.$i.'][combine]'] = 0;
		}

		$form->addButtons('Award Credits');

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
				."\t\t<td colspan=\"2\">{element}</td>\n"
				."\t</tr>",
				'__submit_group');

		$form->setDefaults($defaults);

		if ($form->validate()) {

			$values = $form->exportValues();

			$reason = $values['reason'];

			if (isset($values['awarder']) && is_array($values['awarder'])) {

				$awarder = bhg_roster::getPerson($values['awarder'][1]);

			} else {

				$awarder = $user;

			}

			$awards = array();

			foreach ($values['credit'] as $id => $data) {

				if ($data['amount'] > 0 || $data['account'] > 1) {

					$recipient = bhg_roster::getPerson($data['recipient'][1]);

					$amount = $data['amount'];
					$account = $data['account'];
					
					if (isset($data['combine'])) $account = $amount;
					
					$awards[] = $recipient->requestCreditAward($awarder, $amount, $account, $reason);

				}

			}

			foreach ($awards as $award) {

				$this->addBodyContent('<p>');

				if (	 $user->getPosition()->isEqualTo(bhg_roster::getPosition(2))
						|| $user->getID() == 94) {

					if ($award->approve()) {

						$this->addBodyContent('Awarded '.number_format($award->getAmount())
								.' rank credits, '. number_format($award->getAccount()) .' credit to '.
								$award->getRecipient()->getName()
								.' of '.$award->getRecipient()->getDivision()->getName()
								.'.');

					} else {

						$this->addBodyContent('Failed to awarded credits to '.$award->getRecipient()->getName()
								.' of '.$award->getRecipient()->getDivision()->getName()
								.'.');

					}
					
				} else {
					
					$this->addBodyContent('Requested awarding of '.number_format($award->getAmount())
								.' rank credits, '. number_format($award->getAccount()) .' account credits to '.
								$award->getRecipient()->getName()
							.' of '.$award->getRecipient()->getDivision()->getName()
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

		if (	 $user->getID() == 94
				|| $user->getDivision()->getCategory()->isEqualTo(bhg_roster::getDivisionCategory(3))
				|| $user->getPosition()->isEqualTo(bhg_roster::getPosition(11))) {

			return true;

		} else {

			return false;

		}

	}

}

?>

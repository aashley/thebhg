<?php

include_once 'objects/holonet/tab/bar.php';

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
				'credits_header');

		$pendingCredits = $GLOBALS['bhg']->roster->getPendingCredits();

		$defaults = array();

		foreach ($pendingCredits as $pendingCredit) {

			$fields = array();

			$fields[] = $form->createElement('personselect',
					'recipient');

			$fields[] = $form->createElement('static',
					$pendingCredit->getAwarder()->getName());

			$fields[] = $form->createElement('text',
					'amount',
					null,
					array(
						'size'		  => 10,
						'maxlength' => 15,
						));

			$fields[] = $form->createElement('text',
					'reason',
					null,
					array(
						'size'			=> 30,
						'maxlength'	=> 250,
						));

			$form->addGroup($fields, 'pendingCredit['.$pendingCredit->getID().']', $pendingCredit->getID());

			$renderer->setGroupTemplate('{content}', 'pendingCredit['.$pendingCredit->getID().']');
			$renderer->setGroupElementTemplate('<td>{element}</td>', 'pendingCredit['.$pendingCredit->getID().']');

		}

		$form->addButtons('Approve Credits');

		if ($form->validate()) {

		}

		$tab->addContent($form);

		return $tab;

	}

	public function buildApproveMedals() {

		$tab = new holonet_tab('medals_tab', 'Approve Medals');

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

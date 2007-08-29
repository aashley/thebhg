<?php

class page_roster_administration_members_transfers extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Approve Transfers');

		$bar = new holonet_tab_bar();

		$bar->addTab($this->buildApproveTransfers());

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function buildApproveTransfers() {

		$tab = new holonet_tab('transfers_tab', 'Approve Transfers');

		$form = new holonet_form('approve_transfers');
		$renderer =& $form->defaultRenderer();

		$form->addElement('hidden', 'tabBar', 'transfers_tab');

		$form->addElement('static',
				'transfers_header',
				array(
					'&nbsp;',
					'Person',
					'From',
					'Destination',
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

		$pendingTransfers = $GLOBALS['bhg']->roster->getPendingTransfers();

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

			$fields[] = $form->createElement('static',
					null,
					null,
					$pendingTransfer->getTarget()->getName());

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

			$defaults['pendingTransfer['.$pendingTransfer->getID().'][approve]'] = 'approve';

		}

		$form->addButtons('Approve Transfers');

		$renderer->setElementTemplate("\n"
				."\t<tr>\n"
				."\t\t<td class=\"label\"><!-- BEGIN required --><span style=\"color: #ff0000\">*</span><!-- END required -->{label}</td>\n"
				."\t\t<td colspan=\"4\">{element}</td>\n"
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

						$tab->addContent('Approving pending transfer #'.$pendingTransfer->getID().' of '
								.$pendingTransfer->getPerson()->getName().' from '
								.$pendingTransfer->getPerson()->getDivision()->getName().' to '
								.$pendingTransfer->getTarget()->getName().'<br/>');

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

		if (	 $user->getID() == 94
				|| $user->getPosition()->isEqualTo(bhg_roster::getPosition(2))) {

			return true;

		} else {

			return false;

		}

	}

}

?>

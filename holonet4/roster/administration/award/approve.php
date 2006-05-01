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

		$form->addElement('hidden', 'tabBar', 'credits_tab');

		$renderer =& $form->defaultRenderer();

		$tab->addContent('<pre>'.htmlspecialchars(print_r($renderer, true)).'</pre>');

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

<?php

class page_medalboard_group extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$trail = $this->getTrailingElements();
		$id = $trail[0];

		$group = bhg_medalboard::getGroup($id);

		$this->setTitle('Medal :: '.$group->getName());

		$this->addBodyContent($group->getDescription());

		$table = new HTML_Table();

		$head = $table->getHeader();
		$body = $table->getBody();

		$head->addRow(
				array(
					'Date',
					'Recipient',
					'Awarder',
					'Medal',
					'Reason',
					),
				array(),
				'TH');

		$awards = $group->getAwards();

		foreach ($awards as $award) {

			$body->addRow(
					array(
						$award->getDateCreated(),
						holonet::output($award->getRecipient()),
						holonet::output($award->getAwarder()),
						holonet::output($award->getMedal()),
						htmlspecialchars($award->getReason()),
						)
					);

		}

		$this->addBodyContent($table);

		$this->addSideMenu($GLOBALS['holonet']->medalboard->getSideMenu());

	}

}

?>

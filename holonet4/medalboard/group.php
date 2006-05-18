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

			try {

				$recipient = holonet::output($award->getRecipient());

			} catch (bhg_not_found $e) {

				$recipient = 'MIA';

			}

			try {

				$awarder = holonet::output($award->getAwarder());

			} catch (bhg_not_found $e) {

				$awarder = 'MIA';

			}

			$body->addRow(
					array(
						$award->getDateCreated()->format('%d&nbsp;%B&nbsp;%Y'),
						$recipient,
						$awarder,
						holonet::output($award->getMedal()),
						htmlspecialchars($award->getReason()),
						),
					array(
						array(),
						array(),
						array(),
						array(),
						array('width' => '50%'),
						)
					);

		}

		$this->addBodyContent($table);

		$this->addSideMenu($GLOBALS['holonet']->medalboard->getSideMenu());

	}

}

?>

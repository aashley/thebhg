<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage History
 * @Version $Rev$ $Date$
 */

/**
 * History Event Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage History
 * @Version $Rev$ $Date$
 */
class bhg_history_event extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('history_event', $id);
		$this->__addFieldMap(array(
					'person' => 'bhg_roster_person'
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

	// {{{ toString()

	/**
	 * Produces a human-readable version of the history event in something
	 * vaguely resembling English.
	 *
	 * @return string
	 */
	public function toString() {

		switch ($this->data['type']) {

			// {{{ Type 1: Rank change
			case 1:
				$oldRank = bhg_roster::getRank($this->data['item1']);
				$newRank = bhg_roster::getRank($this->data['item2']);

				if ($oldRank->getSortOrder() <= $newRank->getSortOrder())
					$fmt = 'Promoted from %s to %s.';
				else
					$fmt = 'Demoted from %s to %s.';

				return sprintf($fmt, $oldRank->getName(), $newRank->getName());
			// }}}
			// {{{ Type 2: Position change
			case 2:
				$oldPos = bhg_roster::getPosition($this->data['item1']);
				$newPos = bhg_roster::getPosition($this->data['item2']);

				return sprintf('Changed position from %s to %s.', $oldPos->getName(), $newPos->getName());
			// }}}
			// {{{ Type 3: Division change
			case 3:
				$oldDiv = bhg_roster::getDivision($this->data['item1']);
				$newDiv = bhg_roster::getDivision($this->data['item2']);

				return sprintf('Transferred from %s to %s.', $oldDiv->getName(), $newDiv->getName());
			// }}}
			// {{{ Type 4: Name change
			case 4:
				return sprintf('Changed name from %s to %s.', $this->data['item1'], $this->data['item2']);
			// }}}
			// {{{ Type 5: E-mail change
			case 5:
				return sprintf('Changed e-mail address from %s to %s.', $this->data['item1'], $this->data['item2']);
			// }}}
			// {{{ Type 6: Credit award
			case 6:
				if (is_numeric($this->data['item1'])) {

					try {
						
						$awarder = bhg_roster::getPerson($this->data['item1']);
						return sprintf('Awarded %d credits by %s, bringing rank total to %d.', $this->data['item2'], $awarder->getName(), $this->data['item3']);

					}
					catch (bhg_fatal_exception $e) {

						return sprintf('Awarded %d credits, bringing rank total to %d.', $this->data['item2'], $this->data['item3']);

					}

				}

				if (strlen($this->data['item1']) > 0)
					return sprintf('Awarded %d credits for %s, bringing rank total to %d.', $this->data['item2'], $this->data['item1'], $this->data['item3']);

				return sprintf('Awarded %d credits, bringing rank total to %d.', $this->data['item2'], $this->data['item3']);
			// }}}
			// {{{ Type 7: Account transaction
			case 7:
				if (is_numeric($this->data['item1'])) {

					try {
						
						$otherParty = bhg_roster::getPerson($this->data['item1'])->getName();

					}
					catch (bhg_fatal_exception $e) {

						$otherParty = 'Unknown';

					}

				} else {

					$otherParty = $this->data['item1'];

				}

				if (strlen($this->data['item2']) > 0)
					$item = 'Memo: ' . $this->data['item2'] . '.';
				else
					$item = '';

				if (intval($this->data['item3']) < 0)
					$fmt = '%d credits withdrawn by %s. %s';
				else
					$fmt = '%d credits deposited by %s. %s';

				return sprintf($fmt, $this->data['item3'], $otherParty, $item);
			// }}}
			// {{{ Type 8: Medal award
			case 8:
				$award = bhg_medalboard::getAward($this->data['item1']);
				$medal = $award->getMedal();
				$awarder = $award->getAwarder();
				$reason = $award->getReason();

				if (strlen($reason) == 0)
					$reason = 'some reason';

				return sprintf('Awarded %s by %s for %s.', $medal->getName(), $awarder->getName(), $reason);
			// }}}
			// {{{ Type 9: Join
			case 9:
				if (intval($this->data['item1']) > 0)
					return sprintf('Joined the Bounty Hunter\'s Guild, entering %s.', bhg_roster::getDivision($this->data['item1'])->getName());

				return 'Joined the Bounty Hunter\'s Guild.';
			// }}}
			// {{{ Type 10: Roster deletion
			case 10:
				return 'Deleted from the roster.';
			// }}}
			// {{{ Type 11: Cadre join
			case 11:
				return sprintf('Joined %s cadre.', bhg_roster::getCadre($this->data['item1'])->getName());
			// }}}
			// {{{ Type 12: Cadre departure
			case 12:
				return sprintf('Departed %s cadre.', bhg_roster::getCadre($this->data['item1'])->getName());
			// }}}
				
			default:
				return 'Unknown event.';

		}

	}

	// }}}

}

?>

<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage History
 * @Version $Rev: 5526 $ $Date: 2007-08-20 20:00:24 -0400 (Mon, 20 Aug 2007) $
 */

/**
 * History Event Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage History
 * @Version $Rev: 5526 $ $Date: 2007-08-20 20:00:24 -0400 (Mon, 20 Aug 2007) $
 */
class bhg_bank_person_event extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_person_bank', $id);
		$this->__addFieldMap(array(
					'person' => 'bhg_roster_person',
					'cadre'	=> 'bhg_roster_division',
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

		if (is_numeric($this->data['source'])) {

			try {
				
				$otherParty = bhg_roster::getPerson($this->data['source'])->getName();

			}
			catch (bhg_fatal_exception $e) {

				$otherParty = 'Unknown';

			}

		} else {

			$otherParty = $this->data['source'];

		}

		if (strlen($this->data['reason']) > 0)
			$item = 'Memo: ' . $this->data['reason'] . '.';
		else
			$item = '';

		if ($this->data['cadre'] > 0){
			$otherParty = $this->getCadre()->getName() . "'s bank";
			
			if (intval($this->data['amount']) < 0)
				$fmt = '%d credits deposited into %s. %s';
			else
				$fmt = '%d credits withdrawn from %s. %s';
		} else
			if (intval($this->data['amount']) < 0)
				$fmt = '%d credits withdrawn by %s. %s';
			else
				$fmt = '%d credits deposited by %s. %s';

		return sprintf($fmt, number_format(abs($this->getAmount())), $otherParty, $item);

	}

	// }}}

}

?>

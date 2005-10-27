<?php

class bhg_roster_kabal extends bhg_roster_division {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('roster_division', $id);
		$this->__addFieldMap(array(
					'category' => 'bhg_roster_division_category',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getChief()
	
	/**
	 * Get the Chief of this Kabal
	 *
	 * @return bhg_roster_person
	 */
	public function getChief() {

		$filter = array(
				'division' = $this,
				'position' = bhg_roster::getPosition(11),
				);

		$p = $GLOBALS['bhg']->roster->getPeople($filter);

		return $p->getItem(0);

	}

	// }}}
	// {{{ getCRA()
	
	/**
	 * Get the CRA of this Kabal
	 *
	 * @return bhg_roster_person
	 */
	public function getCRA() {

		$filter = array(
				'division' = $this,
				'position' = bhg_roster::getPosition(12),
				);

		$p = $GLOBALS['bhg']->roster->getPeople($filter);

		return $p->getItem(0);

	}

	// }}}

}

?>

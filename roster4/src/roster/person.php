<?php

class bhg_roster_person extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('roster_person', $id);
		$this->__blackListVar('get', array('md5password', 'passwd', 'redoranks'));
		$this->__blackListVar('set', array('md5password', 'passwd', 'redoranks'));
		$this->__addFieldMap(array(
					'rank' => 'bhg_roster_rank',
					'division' => 'bhg_roster_division',
					'position' => 'bhg_roster_position',
					'cadre' => 'bhg_roster_cadre',
					'previousdivision' => 'bhg_roster_division',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}

	// {{{ getIDLine()

	/**
	 * Get the ID Line of this person
	 *
	 * @return string
	 */
	public function getIDLine() {

		$idline = $this->getRank()->getAbbrev()
			.'/'
			.$this->getName()
			.'/'
			.$this->getDivision()->getName()
			.'/BHG -'
			.$this->getPosition()->getAbbrev();

		return $idline;

	}

	// }}}

}

?>

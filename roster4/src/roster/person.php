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
	}

	// }}}

}

?>

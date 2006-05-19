<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage StarChart
 * @Version $Rev$ $Date$
 */

/**
 * Star Chart Site Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage StarChart
 * @Version $Rev$ $Date$
 */
class bhg_starchart_site extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('starchart_site', $id);
		$this->__addFieldMap(array(
					'planet'		=> 'bhg_starchart_planet',
					'position'	=> 'bhg_roster_position',
					'division'	=> 'bhg_roster_division',
					'person'		=> 'bhg_roster_person',
					));
		$this->__addBooleanFields(array('arena'));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getOwner()
	
	/**
	 * Returns the owner of this property
	 *
	 * @return string|bhg_roster_person
	 */
	public function getOwner() {

		if (	 $this->data['position'] == 0
				&& $this->data['division'] == 0
				&& $this->data['person'] == 0)
			return $this->data['owner'];

		if ($this->data['person'] > 0)
			return bhg_roster::getPerson($this->data['person']);

		$filters = array();

		if ($this->data['position'] > 0)
			$filters['position'] = bhg_roster::getPosition($this->data['position']);

		if ($this->data['division'] > 0)
			$filters['division'] = bhg_roster::getDivision($this->data['division']);

		$possibles = $GLOBALS['bhg']->roster->getPeople($filters);

		if ($possibles->count() > 0) {

			return $possibles->getItem();

		} else {

			return "Unknown Owner";

		}

	}

	// }}}

}

?>

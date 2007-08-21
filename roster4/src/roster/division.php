<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */

/**
 * Roster Cadre Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Roster
 * @Version $Rev$ $Date$
 */
class bhg_roster_division extends bhg_core_base {

	// {{{ __construct()

	/**
	 * Constructor
	 * 
	 * @param integer
	 * @return void
	 */
	public function __construct($id) {
		parent::__construct('roster_division', $id);
		$this->__addFieldMap(array(
					'category' => 'bhg_roster_division_category',
					'leader'	=> 'bhg_roster_person',
					'defaultrank' => 'bhg_roster_rank',
					));
		$this->__addBooleanFields(array('cadre'));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getPeople()

	/**
	 * Get all people in this cadre
	 *
	 * @param array Filters to select which people to load
	 * @return bhg_core_list
	 */
	public function getPeople($filter = array()) {

		$filter['cadre'] = $this;

		return $GLOBALS['bhg']->roster->getPeople($filter);

	}

	// }}}
	// {{{ withdrawAccount()

	/**
	 * Withdraw credits from account balance
	 *
	 * @param integer Cost of purchase
	 * @param string The reason for the withdrawl
	 * @param string The location that the withdrawl was done
	 * @return boolean
	 */
	public function withdrawAccount($credits, $from, $for) {

		return $this->depositAccount(-$credits, $from, $for);

	}

	// }}}
	// {{{ depositAccount()

	/**
	 * Make a deposit into the account
	 *
	 * @param integer amount of deposit
	 * @param string The reason for the deposit
	 * @param string The location that the deposit was done
	 * @return boolean
	 */
	public function depositAccount($credits, $from, $for) {

		if ($GLOBALS['bhg']->hasPerm('cadre')) {
			
			$result = $this->__createRecord('roster_cadre_bank', array(
						'cadre' => $this->data['id'],
						'amount' => $credits,
						'reason' => $for,
						'source' => $from,
						),
						false);

			return $result;

		} else {

			throw new bhg_coder_exception();

		}
		
	}

	// }}}
	// {{{ getAccountBalance()

	/**
	 * Returns the current credit amount in the cadre's bank
	 *
	 * @return boolean
	 */
	public function getAccountBalance(){
		$sql = 'SELECT SUM(`amount`) FROM `roster_cadre_bank` '
					.'WHERE cadre = "' . $this->data['id'] . '"';

		return $this->db->getOne($sql);
	}
	// }}}
	// {{{ getDonatedBy()

	/**
	 * Returns the current credit amount in the cadre's bank
	 *
	 * @return boolean
	 */
	public function getDonatedBy(bhg_roster_person $by){
		$sql = 'SELECT SUM(`amount`) FROM `roster_cadre_bank` '
					.'WHERE cadre = "' . $this->data['id'] . ' AND `source` = "' . $by->getID() . '"';

		return $this->db->getOne($sql);
	}
	// }}}
	// {{{ isCadre()
	
	/**
	 * Is this division a Cadre?
	 *
	 * @return boolean
	 */
	public function isCadre() {

		return $this->getCategory()->hasCadres();

	}

	// }}}

}

?>

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
 * Bank Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage History
 * @Version $Rev: 5526 $ $Date: 2007-08-20 20:00:24 -0400 (Mon, 20 Aug 2007) $
 */
class bhg_bank extends bhg_entry {

	// {{{ getEvent() [static]

	/**
	 * Load a specific History Event
	 *
	 * @param integer
	 * @return bhg_history_event
	 */
	static public function getPersonBook($id) {

		return bhg::loadObject('bhg_bank_person_event', $id);

	}

	// }}}
	// {{{ getEvent() [static]

	/**
	 * Load a specific History Event
	 *
	 * @param integer
	 * @return bhg_history_event
	 */
	static public function getCadreBook($id) {

		return bhg::loadObject('bhg_bank_cadre_event', $id);

	}

	// }}}
	// {{{ getEvents()

	/**
	 * Returns a set of history events events within the system.
	 *
	 * @param array Filters to select which history events to load. Filters available
	 * include person, type, before date, after date, offset and limit.
	 * @return bhg_core_list
	 */
	public function getEvents($filter = array()) {

		$sqlfilters = array();

		if (isset($filter['person'])
				&& $filter['person'] instanceof bhg_roster_person){
			$sqlfilters[] = '`person` = '.$filter['person']->getID().' ';
			$table = 'person';	
		}
		
		if (isset($filter['cadre'])
				&& $filter['cadre'] instanceof bhg_roster_division){
			$sqlfilters[] = '`cadre` = '.$filter['cadre']->getID().' ';
			$table = 'cadre';	
		}
		
		$sql = 'SELECT id '
					.'FROM roster_' . $table . '_bank ';

		if (isset($filter['before'])
				&& $filter['before'] instanceof Date)
			$sqlfilters[] = '`datecreated` < '.$filter['before']->getDate().' ';

		if (isset($filter['after'])
				&& $filter['after'] instanceof Date)
			$sqlfilters[] = '`datecreated` > '.$filter['after']->getDate().' ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `datecreated` DESC ';

		if (isset($filter['offset']) && isset($filter['limit'])) {

			$sql .= 'LIMIT '.$filter['offset'].', '.$filter['limit'].' ';

		} elseif (isset($filter['offset'])) {

			$sql .= 'LIMIT '.$filter['offset'].', 18446744073709551615 ';

		} elseif (isset($filter['limit'])) {

			$sql .= 'LIMIT '.$filter['limit'].' ';

		}

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of bank history events.', $results);

		} else {

			return new bhg_core_list('bhg_bank_' . $table . '_event', $results);

		}

	}

	// }}}

}

?>

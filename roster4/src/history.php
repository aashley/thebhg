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
 * History Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage History
 * @Version $Rev$ $Date$
 */
class bhg_history extends bhg_entry {

	// {{{ getEvent()

	/**
	 * Load a specific History Event
	 *
	 * @param integer
	 * @return bhg_history_event
	 */
	static public function getEvent($id) {

		return bhg::loadObject('bhg_history_event', $id);

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

		$sql = 'SELECT id '
					.'FROM history_event ';

		$sqlfilters = array();

		if (isset($filter['person'])
				&& $filter['person'] instanceof bhg_roster_person)
			$sqlfilters[] = '`person` = '.$filter['person']->getID().' ';

		if (isset($filter['type']))
			$sqlfilters[] = '`type` = '.$filter['type'].' ';

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

			throw new bhg_db_exception('Could not load list of history events.', $results);

		} else {

			return new bhg_core_list('bhg_history_event', $results);

		}

	}

	// }}}

}

?>

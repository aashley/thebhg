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
 * StarChart Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage StarChart
 * @Version $Rev$ $Date$
 */
class bhg_starchart extends bhg_entry {

	// {{{ getPlanet() [static]
	
	/**
	 * Load a specific planet
	 *
	 * @return bhg_starchart_planet
	 */
	static public function getPlanet($id) {

		return bhg::loadObject('bhg_startchart_planet', $id);

	}

	// }}}
	// {{{ getPlanets()
	
	/**
	 * Load a list of planets
	 *
	 * @return bhg_core_list
	 */
	public function getPlanets($filter = array()) {

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['system'])
				&& $filter['system'] instanceof bhg_startchart_system)
			$sqlfilters[] = '`system` = '.$this->db->quoteSmart($filter['system']->getID()).' ';

		if (isset($filter['name']))
			$sqlfilters[] = '`name` LIKE "%'.$this->db->escapeSimple($filter['name']).'%" ';

		if (isset($filter['description']))
			$sqlfilters[] = '`description` LIKE "%'.$this->db->escapeSimple($filter['description']).'%" ';

		$sql = 'SELECT id '
					.'FROM startchart_planet ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `name` ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of planets.', $results);

		} else {

			return new bhg_core_list('bhg_startchart_planet', $results);

		}

	}

	// }}}
	// {{{ getSite() [static]
	
	/**
	 * Load a specific site
	 *
	 * @return bhg_starchart_site
	 */
	static public function getSite($id) {

		return bhg::loadObject('bhg_startchart_site', $id);

	}

	// }}}
	// {{{ getSites()
	
	/**
	 * Load a list of sites
	 *
	 * @return bhg_core_list
	 */
	public function getSites($filter = array()) {

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['planet'])
				&& $filter['planet'] instanceof bhg_startchart_planet)
			$sqlfilters[] = '`planet` = '.$this->db->quoteSmart($filter['planet']->getID()).' ';

		if (isset($filter['name']))
			$sqlfilters[] = '`name` LIKE "%'.$this->db->escapeSimple($filter['name']).'%" ';

		if (isset($filter['description']))
			$sqlfilters[] = '`description` LIKE "%'.$this->db->escapeSimple($filter['description']).'%" ';

		$sql = 'SELECT id '
					.'FROM startchart_site ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `name` ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of sites.', $results);

		} else {

			return new bhg_core_list('bhg_startchart_site', $results);

		}

	}

	// }}}
	// {{{ getSystem() [static];
	
	/**
	 * Load a specific system
	 *
	 * @return bhg_starchart_system
	 */
	static public function getSystem($id) {

		return bhg::loadObject('bhg_startchart_system', $id);

	}

	// }}}
	// {{{ getSystems()
	
	/**
	 * Load a list of systems
	 *
	 * @return bhg_core_list
	 */
	public function getSystems($filter = array()) {

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['name']))
			$sqlfilters[] = '`name` LIKE "%'.$this->db->escapeSimple($filter['name']).'%" ';

		if (isset($filter['description']))
			$sqlfilters[] = '`description` LIKE "%'.$this->db->escapeSimple($filter['description']).'%" ';

		$sql = 'SELECT id '
					.'FROM startchart_system ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `name` ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of systems.', $results);

		} else {

			return new bhg_core_list('bhg_startchart_system', $results);

		}

	}

	// }}}

}

?>

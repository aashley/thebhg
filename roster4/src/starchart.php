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

	// {{{ getObject() [static]
	
	/**
	 * Load a specific object
	 *
	 * @return bhg_starchart_object
	 */
	static public function getObject($id) {

		return bhg::loadObject('bhg_starchart_object', $id);

	}

	// }}}
	// {{{ getObjects()
	
	/**
	 * Load a list of objects
	 *
	 * @return bhg_core_list
	 */
	public function getObjects($filter = array()) {

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['parent'])) {
			
			if ($filter['parent'] instanceof bhg_starchart_object)
				$sqlfilters[] = '`parent` = '.$this->db->quoteSmart($filter['system']->getID()).' ';

			if (is_null($filter['parent']))
				$sqlfilters[] = '`parent` IS NULL ';

		}

		if (isset($filter['type']) && $filter['type'] instanceof bhg_starchart_object_type)
			$sqlfilters[] = '`type` = '.$this->db->quoteSmart($filter['type']->getID()).' ';

		if (isset($filter['name']))
			$sqlfilters[] = '`name` LIKE "%'.$this->db->escapeSimple($filter['name']).'%" ';

		if (isset($filter['description']))
			$sqlfilters[] = '`description` LIKE "%'.$this->db->escapeSimple($filter['description']).'%" ';

		if (isset($filter['extendedtype']))
			$sqlfilters[] = '`typeextended` LIKE "%'.$this->db->escapeSimple($filter['extendedtype']).'%" ';

		$sql = 'SELECT id '
					.'FROM starchart_object ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `name` ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of objects.', $results);

		} else {

			return new bhg_core_list('bhg_starchart_objects', $results);

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

		return bhg::loadObject('bhg_starchart_site', $id);

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
				&& $filter['planet'] instanceof bhg_starchart_planet)
			$sqlfilters[] = '`planet` = '.$this->db->quoteSmart($filter['planet']->getID()).' ';

		if (isset($filter['name']))
			$sqlfilters[] = '`name` LIKE "%'.$this->db->escapeSimple($filter['name']).'%" ';

		if (isset($filter['description']))
			$sqlfilters[] = '`description` LIKE "%'.$this->db->escapeSimple($filter['description']).'%" ';

		$sql = 'SELECT id '
					.'FROM starchart_site ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `name` ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of sites.', $results);

		} else {

			return new bhg_core_list('bhg_starchart_site', $results);

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

		return bhg::loadObject('bhg_starchart_system', $id);

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
					.'FROM starchart_system ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `name` ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of systems.', $results);

		} else {

			return new bhg_core_list('bhg_starchart_system', $results);

		}

	}

	// }}}

}

?>

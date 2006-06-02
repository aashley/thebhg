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

	// {{{ getAttributeType() [static]
	
	/**
	 * Load a specific attribute type
	 *
	 * @return bhg_starchart_attribute_type
	 */
	static public function getAttributeType($id) {

		return bhg::loadObject('bhg_starchart_attribute_type', $id);

	}

	// }}}
	// {{{ getAttributeTypes()
	
	/**
	 * Load a list of attribute types
	 *
	 * @return bhg_core_list
	 */
	public function getAttributeTypes($filter = array()) {

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['name']))
			$sqlfilters[] = '`name` LIKE "%'.$this->db->escapeSimple($filter['name']).'%" ';

		$sql = 'SELECT id '
					.'FROM starchart_attribute_type ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `name` ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of attribute types.', $results);

		} else {

			return new bhg_core_list('bhg_starchart_attribute_type', $results);

		}

	}

	// }}}
	// {{{ getParentObjects()
	
	/**
	 * Get the top level parent objects
	 *
	 * @param array Filters
	 * @return bhg_core_list List of bhg_starchart_objects
	 */
	public function getParentObjects($filter = array()) {

		$filter['parent'] = NULL;

		return $this->getObjects($filter);

	}

	// }}}
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
	// {{{ getObjectAttribute() [static]
	
	/**
	 * Load a specific object attribute
	 *
	 * @return bhg_starchart_object_attribute
	 */
	static public function getObjectAttribute($id) {

		return bhg::loadObject('bhg_starchart_object_attribute', $id);

	}

	// }}}
	// {{{ getObjectAttributes()
	
	/**
	 * Load a list of object attributes
	 *
	 * @return bhg_core_list
	 */
	public function getObjectAttributes($filter = array()) {

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['object']) && $filter['object'] instanceof bhg_starchart_object)
			$sqlfilters[] = '`object` = '.$this->db->quoteSmart($filter['object']->getID()).' ';

		if (isset($filter['type']) && $filter['type'] instanceof bhg_starchart_attribute_type)
			$sqlfilters[] = '`type` = '.$this->db->quoteSmart($filter['type']->getID()).' ';

		if (isset($filter['value']))
			$sqlfilters[] = '`value` LIKE "%'.$this->db->escapeSimple($filter['value']).'%" ';

		$sql = 'SELECT id '
					.'FROM starchart_object_attribute ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of object attributes.', $results);

		} else {

			return new bhg_core_list('bhg_starchart_object_attribute', $results);

		}

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

			return new bhg_core_list('bhg_starchart_object', $results);

		}

	}

	// }}}
	// {{{ getObjectType() [static]
	
	/**
	 * Load a specific object type
	 *
	 * @return bhg_starchart_object_type
	 */
	static public function getObjectType($id) {

		return bhg::loadObject('bhg_starchart_object_type', $id);

	}

	// }}}
	// {{{ getObjectTypes()
	
	/**
	 * Load a list of object types
	 *
	 * @return bhg_core_list
	 */
	public function getObjectTypes($filter = array()) {

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['name']))
			$sqlfilters[] = '`name` LIKE "%'.$this->db->escapeSimple($filter['name']).'%" ';

		$sql = 'SELECT id '
					.'FROM starchart_object_type ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `name` ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of object types.', $results);

		} else {

			return new bhg_core_list('bhg_starchart_object_type', $results);

		}

	}

	// }}}
	// {{{ getObjectTypeAttribute() [static]
	
	/**
	 * Load a specific object type attribute
	 *
	 * @return bhg_starchart_object_type_attribute
	 */
	static public function getObjectTypeAttribute($id) {

		return bhg::loadObject('bhg_starchart_object_type_attribute', $id);

	}

	// }}}
	// {{{ getObjectTypeAttributes()
	
	/**
	 * Load a list of object type attributes
	 *
	 * @return bhg_core_list
	 */
	public function getObjectTypeAttributes($filter = array()) {

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['type']) && $filter['type'] instanceof bhg_starchart_object_type)
			$sqlfilters[] = '`type` = '.$this->db->quoteSmart($filter['type']->getID()).' ';

		if (isset($filter['attribute']) && $filter['attribute'] instanceof bhg_starchart_attribute_type)
			$sqlfilters[] = '`type` = '.$this->db->quoteSmart($filter['type']->getID()).' ';

		$sql = 'SELECT id '
					.'FROM starchart_object_type_attribute ';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of object type attributes.', $results);

		} else {

			return new bhg_core_list('bhg_starchart_object_type_attribute', $results);

		}

	}

	// }}}

}

?>

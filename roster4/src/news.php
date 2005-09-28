<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage News
 * @Version $Rev:$ $Date:$
 */

/**
 * News Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage News
 * @Version $Rev:$ $Date:$
 */
class bhg_news extends bhg_entry {

	// {{{ getItem()

	/**
	 * Retrieve a specific News Item
	 *
	 * @param integer
	 * @return bhg_news_item
	 */
	static public function getItem($id) {

		return bhg::loadObject('bhg_news_item', $id);

	}

	// }}}

	// {{{ getItems()

	/**
	 * Retrieve a selection of News Items
	 *
	 * @param array
	 * @return bhg_core_list
	 */
	public function getItems($filters = array()) {

		$sql = 'SELECT id '
					.'FROM news_item ';

		if ($GLOBALS['bhg']->hasPerm('allnews')) {

			if (isset($filters['channel'])) {

				if (is_array($filters['channel'])) {

					$sql .= 'WHERE section IN ('.implode(',', $filters['channel']).') ';

				} else {

					$sql .= 'WHERE section = '.$filters['channel'].' ';

				}

			} else {

				$sql .= 'WHERE 1 ';

			}

		} else {

			$sql .= 'WHERE section = '.$GLOBALS['bhg']->getCoder()->getID().' ';

		}

		if (isset($filter['before']) && $filter['before'] instanceof Date)
			$sql .= 'AND datecreated <= '.$filter['before']->getDate().' ';

		if (isset($filter['after']) && $filter['after'] instanceof Date)
			$sql .= 'AND datecreated >= '.$filter['after']->getDate().' ';

		$sql .= 'ORDER BY datecreated DESC ';

		if (isset($filter['number']))
			$sql .= 'LIMIT '.$filter['number'].' ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of news items.', $results);

		} else {

			return new bhg_core_list('bhg_news_item', $results);

		}

	}

	// }}}

}

?>

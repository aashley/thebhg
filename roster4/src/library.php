<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Library
 * @Version $Rev:$ $Date:$
 */

/**
 * Library Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Library
 * @Version $Rev:$ $Date:$
 */
class bhg_library extends bhg_entry {

	// {{{ getBook()
	
	/**
	 * Load a specific book
	 *
	 * @return bhg_library_book
	 */
	static public function getBook($id) {

		return bhg::loadObject('bhg_library_book', $id);

	}

	// }}}
	// {{{ getBooks()
	
	/**
	 * Load a list of books
	 *
	 * @return bhg_core_list
	 */
	public function getBooks($filter = array()) {

		if (isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL ';

		if (isset($filter['shelf'])
				&& $filter['shelf'] instanceof bhg_library_shelf)
			$sqlfilters[] = '`shelf` = '.$this->db->quoteSmart($filter['shelf']->getID()).' ';

		if (isset($filter['name']))
			$sqlfilters[] = '`name` LIKE "%'.$this->db->escapeSimple($filter['name']).'%" ';

		if (isset($filter['description']))
			$sqlfilters[] = '`description` LIKE "%'.$this->db->escapeSimple($filter['description']).'%" ';

		if (isset($filter['moderator']) && $filter['moderator'] instanceof bhg_roster_person) {

			$sql = 'SELECT id '
						.'FROM library_book, '
								 .'library_moderator '
						.'WHERE library_book.id = library_moderator.book '
							.'AND library_moderator.person = '.$this->db->quoteSmart($filter['moderator']->getID()).' ';

			if (sizeof($sqlfilters) > 0)
				$sql .= 'AND '.implode(' AND ', $sqlfilters).' ';

		} else {

			$sql = 'SELECT id '
						.'FROM library_book ';

			if (sizeof($sqlfilters) > 0)
				$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		}

		$sql .= 'ORDER BY `name` ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of books.', $results);

		} else {

			return new bhg_core_list('bhg_library_book', $results);

		}

	}

	// }}}
	// {{{ getChapter()
	
	/**
	 * Load a specific chapter
	 *
	 * @return bhg_library_chapter
	 */
	static public function getChapter($id) {

		return bhg::loadObject('bhg_library_chapter', $id);

	}

	// }}}
	// {{{ getSection()
	
	/**
	 * Load a specific section
	 *
	 * @return bhg_library_section
	 */
	static public function getSection($id) {

		return bhg::loadObject('bhg_library_section', $id);

	}

	// }}}
	// {{{ getShelf()
	
	/**
	 * Load a specific shelf
	 *
	 * @return bhg_library_shelf
	 */
	static public function getShelf($id) {

		return bhg::loadObject('bhg_library_shelf', $id);

	}

	// }}}

}

?>

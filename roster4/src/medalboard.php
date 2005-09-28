<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage MedalBoard
 * @Version $Rev:$ $Date:$
 */

/**
 * MedalBoard Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage MedalBoard
 * @Version $Rev:$ $Date:$
 */
class bhg_medalboard extends bhg_entry {

	// {{{ getAward()

	static public function getAward($id) {

		return bhg::loadObject('bhg_medalboard_award', $id);

	}

	// }}}
	// {{{ getCategory()

	static public function getCategory($id) {

		return bhg::loadObject('bhg_medalboard_category', $id);

	}

	// }}}
	// {{{ getCategories()

	public function getCategories() {

		$sql = 'SELECT id '
					.'FROM medalboard_category '
					.'ORDER BY sortorder ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of medal board categories.', $result);

		} else {

			return new bhg_core_list('bhg_medalboard_category', $results);

		}

	}

	// }}}
	// {{{ getGroup()

	static public function getGroup($id) {

		return bhg::loadObject('bhg_medalboard_group', $id);

	}

	// }}}
	// {{{ getMedal()

	static public function getMedal($id) {

		return bhg::loadObject('bhg_medalboard_medal', $id);

	}

	// }}}

}

?>

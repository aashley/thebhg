<?php

class bhg_medalboard_group extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('medalboard_group', $id);
		$this->__addFieldMap(array(
					'category' => 'bhg_medalboard_category',
					));
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getMedals()

	public function getMedals() {

		$sql = 'SELECT id '
					.'FROM medalboard_medal '
					.'WHERE `group` = ? '
					.'ORDER BY sortorder DESC ';

		$results = $this->db->getCol($sql, 0, array($this->getID()));

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of medal board medals.', $result);

		} else {

			return new bhg_core_list('bhg_medalboard_medal', $results);

		}

	}

	// }}}

}

?>

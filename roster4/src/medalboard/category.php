<?php

class bhg_medalboard_category extends bhg_core_base {

	// {{{ __construct()

	public function __construct($id) {
		parent::__construct('medalboard_category', $id);
		$this->__addDefaultCodePermissions('set', 'god');
	}

	// }}}
	// {{{ getGroups()

	public function getGroups() {

		$sql = 'SELECT id '
					.'FROM medalboard_group '
					.'WHERE category = '.$this->getID().' '
					.'ORDER BY sortorder ASC ';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of medal board groups.', $result);

		} else {

			return new bhg_core_list('bhg_medalboard_group', $results);

		}

	}

	// }}}

}

?>

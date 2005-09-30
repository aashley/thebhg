<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage College
 * @Version $Rev:$ $Date:$
 */

/**
 * College Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage College
 * @Version $Rev:$ $Date:$
 */
class bhg_college extends bhg_entry {
	 
	// {{{ getSubmissions()

	/**
	 * Retrieves all submissions made to the college.
	 *
	 * @param array Filters for the submission list.
	 * Valid filters include:
	 * <ul>
	 * <li><i>exam</i>: takes a bhg_college_exam object.</li>
	 * <li><i>failed</i>: true to restrict the list to failed submissions.</li>
	 * <li><i>graded</i>: true to restrict the list to graded submissions.</li>
	 * <li><i>passed</i>: true to restrict the list to passed submissions.</li>
	 * <li><i>submitter</i>: takes a bhg_roster_person object.</li>
	 * <li><i>ungraded</i>: true to restrict the list to ungraded
	 * submissions.</li>
	 * </ul>
	 * @return object bhg_core_list A list of bhg_college_submission objects.
	 */
	public function getSubmissions($filter = array()) {
		
		$sql = 'SELECT id '
					.'FROM college_submission ';

		$sqlfilters = array();

		if (isset($filter['exam']) && $filter['exam'] instanceof bhg_college_exam)
			$sqlfilters[] = 'exam = '.$this->db->quoteSmart($filter['exam']->getID());

		if (isset($filter['failed']) && $filter['failed'])
			$sqlfilters[] = 'passed = 0';

		if (isset($filter['graded']) && $filter['graded'])
			$sqlfilters[] = 'graded = 1';

		if (isset($filter['passed']) && $filter['passed'])
			$sqlfilters[] = 'passed = 1';

		if (isset($filter['submitter']) && $filter['submitter'] instanceof bhg_roster_person)
			$sqlfilters[] = 'submitter = '.$this->db->quoteSmart($filter['submitter']->getID());

		if (isset($filter['ungraded']) && $filter['ungraded'])
			$sqlfilters[] = 'graded = 0';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `datecreated` ASC';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of exam submissions.', $results);

		} else {

			return new bhg_core_list('bhg_college_submission', $results);

		}

	}

	// }}}

}

?>

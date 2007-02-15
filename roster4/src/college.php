<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage College
 * @Version $Rev$ $Date$
 */

/**
 * College Entry Object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage College
 * @Version $Rev$ $Date$
 */
class bhg_college extends bhg_entry {
	 
	// {{{ getExam() [static]

	/**
	 * Retrieve a specific exam.
	 *
	 * @param integer
	 * @return bhg_college_exam
	 */
	static public function getExam($id) {

		return bhg::loadObject('bhg_college_exam', $id);

	}

	// }}}
	// {{{ getExams()

	/**
	 * Retrieves all exams within the college
	 *
	 * @param array Filters for the list of exams.
	 * Valid filters include:
	 * <ul>
	 * <li><i>abbrevition</i>: exams that have exactly this abbreviation.</li>
	 * <li><i>deleted</i>: includes deleted exams.</li>
	 * <li><i>name</i>: exams that have a name containing this string.</li>
	 * <li><i>school</i>: exams belonging to a specific school.</li>
	 * <li><i>search_abbreviation</i>: exams that have an abbreviation containing this string.</li>
	 * </ul>
	 * @return object bhg_core_list A list of bhg_college_exam objects.
	 */
	public function getExams($filter = array()) {

		$sql = 'SELECT id '
					.'FROM college_exam ';
		
		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL';

		if (isset($filter['name']))
			$sqlfilters[] = 'name LIKE "%'
										 .$this->db->escapeSimple($filter['name'])
										 .'%"';

		if (isset($filter['abbreviation']))
			$sqlfilters[] = 'abbr = '.$this->db->quoteSmart($filter['abbreviation']);

		if (isset($filter['school']) && $filter['school'] instanceof bhg_college_school)
			$sqlfilters[] = 'school = '.$this->db->quoteSmart($filter['school']->getID());

		if (isset($filter['search_abbreviation']))
			$sqlfilters[] = 'abbr LIKE "%'
										 .$this->db->escapeSimple($filter['name'])
										 .'%"';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `datecreated` ASC';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of exams.', $results);

		} else {

			return new bhg_core_list('bhg_college_exam', $results);

		}

	}

	// }}}
	// {{{ getExamQuestion() [static]

	/**
	 * Retrieve a specific exam question.
	 *
	 * @param integer
	 * @return bhg_college_exam_question
	 */
	static public function getExamQuestion($id) {

		return bhg::loadObject('bhg_college_exam_question', $id);

	}

	// }}}
	// {{{ getExamQuestions()

	/**
	 * Retrieves a list of exam questions within the college
	 *
	 * @param array Filters for the list of exam questions.
	 * Valid filters include:
	 * <ul>
	 * <li><i>deleted</i>: includes deleted exams.</li>
	 * <li><i>exam</i>: bhg_college_exam.</li>
	 * </ul>
	 * @return object bhg_core_list A list of bhg_college_exam objects.
	 */
	public function getExamQuestions($filter = array()) {

		$sql = 'SELECT id '
					.'FROM college_exam_question ';
		
		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL';

		if (isset($filter['exam']) && $filter['exam'] instanceof bhg_college_exam)
			$sqlfilters[] = 'exam = '.$this->db->quoteSmart($filter['exam']);

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `datecreated` ASC';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of exam questions.', $results);

		} else {

			return new bhg_core_list('bhg_college_exam_question', $results);

		}

	}

	// }}}
	// {{{ getExamReward() [static]

	/**
	 * Retrieve a specific exam reward.
	 *
	 * @param integer
	 * @return bhg_college_exam_reward
	 */
	static public function getExamReward($id) {

		return bhg::loadObject('bhg_college_exam_reward', $id);

	}

	// }}}
	// {{{ getExamRewards()

	/**
	 * Retrieves a list of exam rewards within the college
	 *
	 * @param array Filters for the list of exam rewards.
	 * Valid filters include:
	 * <ul>
	 * <li><i>credit</i>: true to return credit type awards.</li>
	 * <li><i>deleted</i>: includes deleted exams.</li>
	 * <li><i>exam</i>: bhg_college_exam.</li>
	 * <li><i>medal</i>: true to return medal type awards.</li>
	 * <li><i>score</i>: float return any rewards that are given for this score.</li>
	 * </ul>
	 * @return object bhg_core_list A list of bhg_college_exam objects.
	 */
	public function getExamRewards($filter = array()) {

		$sql = 'SELECT id '
					.'FROM college_exam_reward ';
		
		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL';

		if (isset($filter['exam']) && $filter['exam'] instanceof bhg_college_exam)
			$sqlfilters[] = 'exam = '.$this->db->quoteSmart($filter['exam']);

		if (isset($filter['credit']) && $filter['credit'] == true)
			$sqlfilters[] = 'rewardtype = "credit"';

		if (isset($filter['medal']) && $filter['medal'] == true)
			$sqlfilters[] = 'rewardtype = "medal"';

		if (isset($filter['score']) && is_numeric($filter['score']))
			$sqlfilters[] = 'requiredscore <= '.$thid->db->quoteSmart($filter['score']);

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `datecreated` ASC';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of exam rewards.', $results);

		} else {

			return new bhg_core_list('bhg_college_exam_reward', $results);

		}

	}

	// }}}
	// {{{ getSchool() [static]

	/**
	 * Retrieve a specific school
	 *
	 * @param integer
	 * @return bhg_college_school
	 */
	static public function getSchool($id) {

		return bhg::loadObject('bhg_college_school', $id);

	}

	// }}}
	// {{{ getSchools()

	/**
	 * Retrieves all schools within the college.
	 *
	 * @param array Filters for the school list.
	 * Valid filters include:
	 * <ul>
	 * <li><i>deleted</i>: includes deleted submissions.</li>
	 * </ul>
	 * @return object bhg_core_list A list of bhg_college_school objects.
	 */
	public function getSchools($filter = array()) {
		
		$sql = 'SELECT id '
					.'FROM college_school ';

		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = '`datedeleted` IS NULL';

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `weight` ASC';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of exam submissions.', $results);

		} else {

			return new bhg_core_list('bhg_college_school', $results);

		}

	}

	// }}}
	// {{{ getSubmission() [static]

	/**
	 * Retrieve a specific submission
	 *
	 * @param integer
	 * @return bhg_college_submission
	 */
	static public function getSubmission($id) {

		return bhg::loadObject('bhg_college_submission', $id);

	}

	// }}}
	// {{{ getSubmissions()

	/**
	 * Retrieves all submissions made to the college.
	 *
	 * @param array Filters for the submission list.
	 * Valid filters include:
	 * <ul>
	 * <li><i>deleted</i>: includes deleted submissions.</li>
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

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL';

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
	// {{{ getSubmissionAnswer() [static]

	/**
	 * Retrieve a specific submission answer
	 *
	 * @param integer
	 * @return bhg_college_submission_answer
	 */
	static public function getSubmissionAnswer($id) {

		return bhg::loadObject('bhg_college_submission_answer', $id);

	}

	// }}}
	// {{{ getSubmissionAnswers()

	/**
	 * Retrieves a list of submission answers within the college
	 *
	 * @param array Filters for the list of submission answers.
	 * Valid filters include:
	 * <ul>
	 * <li><i>deleted</i>: includes deleted submissions.</li>
	 * <li><i>question</i>: bhg_college_exam_question return answers to this question.</li>
	 * <li><i>submission</i>: bhg_college_submission.</li>
	 * </ul>
	 * @return object bhg_core_list A list of bhg_college_submission objects.
	 */
	public function getSubmissionAnswers($filter = array()) {

		$sql = 'SELECT id '
					.'FROM college_submission_answer ';
		
		$sqlfilters = array();

		if (!isset($filter['deleted']) || $filter['deleted'] == false)
			$sqlfilters[] = 'datedeleted IS NULL';

		if (isset($filter['submission']) && $filter['submission'] instanceof bhg_college_submission)
			$sqlfilters[] = 'submission = '.$this->db->quoteSmart($filter['submission']->getID());

		if (isset($filter['question']) && $filter['question'] instanceof bhg_college_exam_question)
			$sqlfilters[] = 'question = '.$this->db->quoteSmart($filter['question']->getID());

		if (sizeof($sqlfilters) > 0)
			$sql .= 'WHERE '.implode(' AND ', $sqlfilters).' ';

		$sql .= 'ORDER BY `datecreated` ASC';

		$results = $this->db->getCol($sql);

		if (DB::isError($results)) {

			throw new bhg_db_exception('Could not load list of submission answers.', $results);

		} else {

			return new bhg_core_list('bhg_college_submission_answer', $results);

		}

	}

	// }}}

}

?>

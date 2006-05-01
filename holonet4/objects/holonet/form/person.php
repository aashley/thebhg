<?php

require_once 'HTML/QuickForm/hierselect.php';

class holonet_form_person extends HTML_QuickForm_hierselect {

	public function holonet_form_person($elementName=null, $elementLabel=null, $attributes=null, $separator=null, $divisions=null) {

		parent::HTML_QuickForm_hierselect($elementName, $elementLabel, $attributes, $separator);

		$this->_type = 'hierselect_person';
		$this->_appendName = true;

		if (is_null($divisions)) {

			$valid = null;

		} else {

			if ($divisions instanceof bhg_core_list) {

				$valid = $divisions->items;

			} elseif (is_array($divisions)) {

				foreach ($divisions as $division) {

					if ($division instanceof bhg_roster_division) {
						
						$valid[] = $division->getID();

					} elseif (is_numeric($division)) {

						$valid[] = $division;

					}

				}

			} else {

				$valid = null;

			}

		}

		if (is_array($valid) && sizeof($valid) == 0)
			$valid = null;

		$a = $b = array();

		foreach ($GLOBALS['bhg']->roster->getDivisionCategories() as $category) {

			foreach ($category->getDivisions() as $division) {

				if (	 is_null($valid)
						|| in_array($division->getID(), $valid)) {

					foreach ($division->getPeople() as $person) {

						$b[$division->getID()][$person->getID()] = $person->getName();

					}

					if (isset($b[$division->getID()]) && sizeof($b[$division->getID()]) > 0)
						$a[$division->getID()] = $division->getName();

				}

			}

		}

		$options[] = &$a;
		$options[] = &$b;

		$this->setOptions($options);

	}

	public function setValue($value) {

		if ($value instanceof bhg_roster_person) {

			$raw = array(
					$value->getDivision()->getID(),
					$value->getID(),
					);

			parent::setValue($raw);

		} else {

			parent::setValue($value);

		}

	}

}

?>

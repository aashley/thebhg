<?php

require_once 'HTML/QuickForm/hierselect.php';
require_once 'Cache/Lite.php';

class holonet_form_person extends HTML_QuickForm_hierselect {

	// {{{ properties

	protected $divisions = null;

	// }}}
	// {{{ holonet_form_person()

	public function holonet_form_person($elementName=null, $elementLabel=null, $attributes=null, $separator=null, $divisions=null) {

		parent::HTML_QuickForm_hierselect($elementName, $elementLabel, $attributes, $separator);

		$this->_type = 'hierselect_person';
		$this->_appendName = true;
		$this->_divisions = $divisions;

	}

	// }}}
	// {{{ setValue()

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

	// }}}
	// {{{ toHtml()

	public function toHtml() {

		$this->buildOptions();

		return parent::toHtml();

	}

	// }}}
	// {{{ accept()

	public function accept(&$renderer, $required = false, $error = null) {

		$this->buildOptions();

		return parent::accept($renderer, $required, $error);

	}

	// }}}
	// {{{ buildOptions [protected]

	protected function buildOptions() {

		if (is_null($this->divisions)) {

			$valid = null;

		} else {

			if ($this->divisions instanceof bhg_core_list) {

				$valid = $this->divisions->items;

			} elseif (is_array($this->divisions)) {

				$valid = array();

				foreach ($this->divisions as $division) {

					if ($division instanceof bhg_roster_division) {
						
						$valid[] = $division->getID();

					} elseif (is_numeric($division)) {

						$valid[] = $division;

					}

				}

			} elseif ($this->divisions instanceof bhg_roster_division) {

				$valid = array($division->getID());
				
			} else {

				$valid = null;

			}

		}

		if (is_array($valid) && sizeof($valid) == 0)
			$valid = null;

		$cacheKey = 'person-select';
		if (!is_null($valid))
			$cacheKey .= '-'.implode('-', sort($valid));

		$cache = new Cache_Lite(array(
					'cacheDir'	=> bhg::getSettingValue('imagecache_dir'),
					'lifeTime'	=> 180,
					));

		if ($data = $cache->get($cacheKey, 'person-select')) {

			$options = unserialize($data);

		} else {

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

			$cache->save(serialize($options));

		}

		$this->setOptions($options);

	}

	// }}}

}

?>

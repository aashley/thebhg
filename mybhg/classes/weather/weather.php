<?php
/**
 * The base class for access to weather information. If you're only looking up
 * the information for a particular station, just create a Station object: this
 * is for code which needs to iterate through all the available stations.
 *
 * @access public
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @package MyBHG
 */
class Weather {
	/**#@+
	 * @access private
	 */
	var $path;
	/**#@-*/

	function Weather($path) {
		$this->path = $path;
	}

	function GetCountries() {
		$countries = array();

		$xml = domxml_open_file($this->path . '/index.xml');
		foreach ($xml->get_elements_by_tagname('country') as $country) {
			$name = $country->get_attribute('name');
			$states = $country->get_elements_by_tagname('state');
			foreach ($states as $state) {
				$state_name = $state->get_attribute('name');
				$url = $state->get_attribute('url');
				if ($name != $state_name) {
					$countries[$url] = $name . ' (' . $state_name . ')';
				}
				else {
					$countries[$url] = $name;
				}
			}
		}
		
		asort($countries);
		return $countries;
	}

	function GetStationsByCountry($url) {
		$stations = array();
		
		$xml = domxml_open_file($this->path . '/' . $url);
		foreach ($xml->get_elements_by_tagname('city') as $station) {
			$stations[$station->get_attribute('url')] = $station->get_attribute('name');
		}
		
		asort($stations);
		return $stations;
	}
}
?>

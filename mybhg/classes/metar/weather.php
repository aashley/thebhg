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
	var $db;
	/**#@-*/

	function Weather(&$db) {
		$this->db = $db;
	}

	function GetCountries() {
		$countries = array();
		$result = mysql_query('SELECT country FROM weather_stations GROUP BY country ORDER BY country ASC', $this->db);
		while ($row = mysql_fetch_array($result)) {
			$countries[] = $row['country'];
		}
		return $countries;
	}

	function GetStationsByCountry($country) {
		$stations = array();
		$result = mysql_query('SELECT code, name, state FROM weather_stations WHERE country="' . $country . '" ORDER BY name, state', $this->db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$stations[$row['code']] = $row['name'] . ($row['state'] ? ', ' . $row['state'] : '');
			}
		}
		return $stations;
	}
}
?>

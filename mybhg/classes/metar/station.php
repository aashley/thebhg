<?php
/**
 * A class representing a METAR station.
 *
 * @access public
 * @package MyBHG
 * @author Jernai Teifsel <jernai@iinet.net.au>
 */
class Station {
	/**#@+
	 * @access private
	 */
	var $code;
	var $db;
	var $output;
	var $name;
	var $state;
	var $country;
	/**#@-*/

	function Station($code, &$db, $offline = false) {
		$this->code = $code;
		$this->db = $db;
		
		// Look up the details of the station.
		$result = mysql_query('SELECT * FROM weather_stations WHERE code="' . $code . '"', $db);
		$row = mysql_fetch_array($result);
		$this->name = $row['name'];
		$this->state = $row['state'];
		$this->country = $row['country'];

		// Check the cache and see if we need a reload.
		if (!$offline) {
			$result = mysql_query('SELECT * FROM weather_cache WHERE code="' . $code . '"', $db);
			if ($result && mysql_num_rows($result)) {
				$row = mysql_fetch_array($result);
				if ($row['time'] < (time() - 1800)) {
					$this->UpdateCache();
				}
				else {
					$this->output = stripslashes($row['content']);
				}
			}
			else {
				$this->UpdateCache();
			}
		}
	}

	function UpdateCache() {
		// Let's get the METAR information.
		$q = $this->code;
		$meth = 'html';
		include('phetar.php');
		if ($phetar['code'] == 'XXXX') {
			return false;
		}

		// Get the time of the last weather update.
		$last_update = gmmktime(substr($phetar['time'], 0, 2), substr($phetar['time'], 2, 2), 0, date('m'), $phetar['date']);
		$this->output = 'As at ' . date('G:i T', $last_update) . '<br />';

		// See if we have some conditions.
		if ($phetar['conditions']) {
			$this->output .= 'Conditions: ' . $phetar['conditions'] . '<br />';
		}
		
		// Now append the temperature and update the cache.
		$this->output .= 'Temperature: ' . $phetar['tempc'] . '&deg;C';

		if (!mysql_query('INSERT INTO weather_cache (code, time, content) VALUES ("' . $this->code . '", UNIX_TIMESTAMP(), "' . addslashes($this->output) . '")', $this->db)) {
			mysql_query('UPDATE weather_cache SET time=UNIX_TIMESTAMP(), content="' . addslashes($this->output) . '" WHERE code="' . $this->code . '"', $this->db);
		}
		return true;
	}

	function GetOutput() {
		return $this->output;
	}

	function GetName() {
		return $this->name;
	}

	function GetState() {
		return $this->state;
	}

	function GetCountry() {
		return $this->country;
	}
}
?>

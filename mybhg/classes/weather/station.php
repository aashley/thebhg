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
	var $url;
	var $cel;
	var $db;
	var $output;
	var $name;
	var $xml;
	/**#@-*/

	function Station($url, &$db) {
		$url_array = explode('%%', $url);

		$this->url = $url_array[0] . '&celsius=' . ((int) $url_array[1] ? 'true' : 'false');
		$this->cel = (int) $url_array[1];
		$this->db = $db;
		
		// Check the cache and see if we need a reload.
		$result = mysql_query('SELECT * FROM weather_cache WHERE code="' . addslashes($this->url) . '"', $db);
		if ($result && mysql_num_rows($result)) {
			$row = mysql_fetch_array($result);
			if ($row['time'] < (time() - 1800)) {
				$this->UpdateCache();
			}
			else {
				$carray = explode(';', stripslashes($row['content']), 2);
				$this->name = $carray[0];
				$this->output = $carray[1];
				$this->xml = stripslashes($row['xml']);
			}
		}
		else {
			$this->UpdateCache();
		}
	}

	function UpdateCache() {
		$raw = @file($this->url);
		if (count($raw)) {
			$raw[0] = '';
			$raw = implode('', $raw);
			$this->xml = $raw;
		}
		else {
			$raw = '';
		}
		if ($raw && $xml = domxml_open_mem($raw)) {
			$date = $xml->get_elements_by_tagname('date');
			$date = strtotime($date[0]->get_content());
			$this->output = 'As at ' . date('G:i T', $date) . '<br />';

			$sky = $xml->get_elements_by_tagname('sky');
			$this->output .= 'Conditions: ' . $sky[0]->get_content() . '<br />';

			$temp = $xml->get_elements_by_tagname('temp');
			$this->output .= 'Temperature: ' . round((double) $temp[0]->get_content(), 1) . '&deg;' . ($this->cel ? 'C' : 'F');

			$name = $xml->get_elements_by_tagname('city');
			$this->name = $name[0]->get_content();

			if (!mysql_query('INSERT INTO weather_cache (code, time, content, xml) VALUES ("' . addslashes($this->url) . '", UNIX_TIMESTAMP(), "' . addslashes($this->name . ';' . $this->output) . '", "' . addslashes($raw) . '")', $this->db)) {
				mysql_query('UPDATE weather_cache SET time=UNIX_TIMESTAMP(), content="' . addslashes($this->output) . '", xm="' . addslashes($raw) . '" WHERE code="' . addslashes($this->name . ';' . $this->code) . '"', $this->db);
			}
		}
		else {
			$this->output = 'Error getting weather information.';
		}
	}

	function GetOutput() {
		return $this->output;
	}

	function GetName() {
		return $this->name;
	}

	function GetXML() {
		return $this->xml;
	}
}
?>

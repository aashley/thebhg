<?php
$title = 'Weather Forecast';
include_once('header.php');

if ($my_weather{0} == '-') {
	$station = new Station(substr($my_weather, 1), $db);
}
else {
	$station = new Station($my_weather, $db);
}
$carray = explode('%%', $my_weather);

if ($xml = @domxml_open_mem($station->GetXML())) {
	$forecasts = $xml->get_elements_by_tagname('forecast');
	if (count($forecasts)) {
		$table = new Table();
		
		$table->StartRow();
		$table->AddHeader($station->GetName() . ' Forecast', 2);
		$table->EndRow();

		foreach ($forecasts as $forecast) {
			$day = $forecast->get_elements_by_tagname('day');
			$min = $forecast->get_elements_by_tagname('low');
			$max = $forecast->get_elements_by_tagname('high');
			$sky = $forecast->get_elements_by_tagname('sky');
			$rain = $forecast->get_elements_by_tagname('precipitation');

			$table->StartRow();
			$table->AddHeader($day[0]->get_content(), 2);
			$table->EndRow();

			$table->AddRow('Conditions:', $sky[0]->get_content());
			$table->AddRow('Minimum:', round((double) $min[0]->get_content(), 0) . '&deg;' . ($carray[1] == 1 ? 'C' : 'F'));
			$table->AddRow('Maximum:', round((double) $max[0]->get_content(), 0) . '&deg;' . ($carray[1] == 1 ? 'C' : 'F'));
			$table->AddRow('Chance of Rain:', number_format((int) $rain[0]->get_content()) . '%');
		}

		$table->EndTable();
	}
	else {
		echo 'There is no forecast information available for your weather station.';
	}
}
else {
	echo 'There was an error parsing weather information. Please try again later.';
}

$show_blocks = true;
include_once('footer.php');
?>

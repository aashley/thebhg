<?php
$title = 'Weather Preferences';
include('header.php');
$weather = new Weather('classes/weather/xml');
$carray = explode('%%', $my_weather);

if (empty($my_user)) {
	echo 'You must be logged in to edit your preferences.';
	include('footer.php');
}

if ($_REQUEST['submit']) {
	$url = addslashes($_REQUEST['url'] . '%%' . ($_REQUEST['unit'] == 'c' ? '1' : '0'));
	if (mysql_query('UPDATE prefs SET weather="' . $url . '" WHERE id=' . $my_user->GetID(), $db)) {
		echo 'Weather preferences saved.';
	}
	else {
		echo 'Error saving weather preferences: ' . mysql_error($db);
	}
}
elseif ($_REQUEST['country']) {
	$form = new Form($_SERVER['PHP_SELF']);

	$form->StartSelect('Station:', 'url', str_replace('-', '', $carray[0]));
	foreach ($weather->GetStationsByCountry($_REQUEST['country']) as $code=>$stat) {
		$form->AddOption($code, $stat);
	}
	$form->EndSelect();

	$cel = explode('%%', $my_weather);
	$form->StartSelect('Units:', 'unit', ((int) $cel[1] ? 'c' : 'f'));
	$form->AddOption('c', 'Celsius');
	$form->AddOption('f', 'Fahrenheit');
	$form->EndSelect();

	$form->AddSubmitButton('submit', 'Save Station');
	$form->EndForm();
}
else {
	$form = new Form($_SERVER['PHP_SELF']);

	$countries = $weather->GetCountries();
	$station = new Station(str_replace('-', '', $carray[0]), $db);
	if ($xml = @domxml_open_mem($station->GetXML())) {
		$country = $xml->get_elements_by_tagname('country');
		$country = trim($country[0]->get_content());
		$state = $xml->get_elements_by_tagname('state');
		$state = trim($state[0]->get_content());
		if ($state) {
			$country .= ' (' . $state . ')';
		}

		$select = false;
		foreach ($countries as $url=>$cname) {
			if ($country == $cname) {
				$select = $url;
				break;
			}
		}
		
		$form->StartSelect('Country:', 'country', $select);
	}
	else {
		$form->StartSelect('Country:', 'country');
	}
	foreach ($countries as $url=>$country) {
		$form->AddOption($url, $country);
	}
	$form->EndSelect();

	$form->AddSubmitButton('', 'Next >>');
	$form->EndForm();
}

include('footer.php');
?>

<?php
include('weather.php');
$weather = new Weather('xml');
print_r($weather->GetStationsByCountry('AN.xml'));
?>

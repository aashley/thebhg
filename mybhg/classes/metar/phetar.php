<?
/*
PHETAR is a script that parses a METAR string into an array of variables
which can then be used in any sort of way a being might desire.

This is version 1.3 of this code.

Copyright 2002-2003 Karl Bailey.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

view a simple working example at http://www.growlers.org/weather/phexample.php
view the current version of the source code at http://www.growlers.org/weather/phetar.phps
view the GNU Public License at http://www.growlers.org/weather/gpl.txt

view uses of this code at:
http://www.growlers.org/weather/metar.xml?q=kord
http://www.growlers.org/m9/
http://www.growlers.org/wml/kord (WAP-enabled devices only)

*/

// check for metar request. If no metar, set up default station (KORD)
if (!$q) {
$q = "kord";
}

// switch request string to upper case
$q = strtoupper($q);

/* The following code gets a METAR string using ftp as a default. This is a bit slower than html, so we'll
allow html if the user explicitly requests it.  This is bandwidth intensive (well, more than just a single
string of text, anyhow), and the html database lacks many international sites, so we'll always use
ftp as a default, and as a backup if html fails. */

if ($meth == "html") {
// build request string and get file
$wheretogo = "http://weather.noaa.gov/cgi-bin/mgetmetar.pl?cccc=" . $q;
$getpage = file($wheretogo);
// step through lines, looking for METAR-like code
foreach ($getpage as $wer => $uio) {
if (preg_match("/[A-Z]{4} [0-9]{6}Z/", $uio)) {

// that's the line number! remember it!
$mnb = $wer;
}
}
// get the first line of METAR code
$getlineone = str_replace("\n", " ", $getpage[$mnb]);
// get the second line.
$addlinetwo = $getlineone . trim($getpage[$mnb + 1]);
// The getdata[] fake array is a holdover from some other code. Heh.
// The following code sets up an array of units in the METAR string.
$getdata[1] = trim($addlinetwo);
$metar = split(" ", $getdata[1]);
if (!preg_match("/[A-Z]{4}/", $metar[0])) {
$metar[0] = "";
}
}
// If the user doesn't explicitly request an html source, or if no html source exists, run the following code.
if ($meth != "html" or !$metar[0]){

// get the METAR string by ftp.
$wheretogo = "ftp://weather.noaa.gov/data/observations/metar/stations/" . $q . ".TXT";
if ( $cf = @fopen("$wheretogo", "r") ) {
@fclose($cf);
$getdata = file($wheretogo);
} else {
@fclose($cf);
}
// Set up an array of units from the METAR string.
$metar = split(" ", $getdata[1]);
}
if (!preg_match("/[A-Z]{4}/", $metar[0])) {
$metar[0] = "";
}

// if a station exists, run the following code.
if ($metar[0]) {
/* store station code in phetar[] array
This will be of the form CCCC */
$phetar['station'] = $metar[0];
/* pull the time out of the array.
This will be of the form DDNNNNZ. I haven't included any code dealing with the date,
mostly because I'm lazy. Time is UTC and on 24 hour clock. */
preg_match("/([0-9]{0,2})([0-9]{4})Z/", $metar[1], $metime);
$phetar['date'] = $metime[1];
$phetar['time'] = $metime[2];

/* Now we'll set up a couple of variable that we'll be using a little later.
The first is $ccond which holds the current condition description.
The second, $lceil,  sets the ceiling to be really, really high. */
$ccond = ", ";
$lceil = "999999999";

/* here, for some bizarre reason, we'll capitalize a caplitalized string, and
then assign it to a new variable. It seemed like a good idea at the time.
*/
$qcaps = strtoupper($q);

// And off we go to get information about the station.
$word8 = file("http://www.nws.noaa.gov/dm-cgi-bin/nsd_lookup.pl?station=" . $qcaps);

// loop through the station information page (it's HTML), and grab info
foreach ($word8 as $r => $t) {

// here's a replacement for the html station info grabber using my own sql database. ha!
// the stupid NWS database was missing some small stations.
// conclusion: it's always better to do things yourself.
// I'm probably not going to make this database available anytime soon; it's too big to have people downloading constantly.
// Alas.
/*
[redacted]
*/


// get the station name
if (preg_match("/Station Name:/", $t)) {
$getstat = 1;
}
if ($getstat) {
if (preg_match("/<B>(.*)<\/B>/", $t, $ccmat)) {
// store the name in the phetar[] array
$phetar['name'] = $ccmat[1];

$getstat = 0;
}
}

// get US state, if it exists
if (preg_match("/State:/", $t)) {
$getstate = 1;
}
if ($getstate) {
if (preg_match("/<B>(.*)<\/B>/", $t, $ccmat)) {
// store the state in the phetar[] array
$phetar['state'] = $ccmat[1];

$getstate = 0;
}
}

// get the country in which the station is located
if (preg_match("/Country:/", $t)) {
$getctry = 1;
}
if ($getctry) {
if (preg_match("/<B>(.*)<\/B>/", $t, $ccmat)) {
// store the country in the phetar[] array
$phetar['country'] = $ccmat[1];

$getctry = 0;
}
}

// now we'll snatch the latitude and longitude for each station
// This data is in DDD-MM-SSX ([D]egrees, [M]inutes, [S]econds, [X] = NSEW)

if (preg_match("/Station Position:/", $t)) {
$getpos = 1;
}
if ($getpos) {
if (preg_match("/<B>([0-9]{2}-[0-9]{2}-{0,1}[0-9]{0,2}[NESW]).*([0-9]{3}-[0-9]{2}-{0,1}[0-9]{0,2}[NESW])<\/B>/", $t, $ccmat)) {
// store that latitude!
$phetar['latitude'] = $ccmat[1];

// store that longitude!
$phetar['longitude'] = $ccmat[2];

$getpos = 0;
}
}

// and the elevation in Meters.
if (preg_match("/Station Elevation/", $t)) {
$getelev = 1;
}
if ($getelev) {
if (preg_match("/<B>([0-9]+) Meters<\/B>/", $t, $ccmat)) {
// store the elevation
$phetar['elevation'] = $ccmat[1];

$getelev = 0;
}
}

}


/* And now, on to actually parsing the METAR string!
This probably isn't the best way to do this, and I'm working on a purely
regex script, but this works.  It is, however, not the most efficient code
in the world.
What we'll do is step through the array of METAR units, and check them against
a list of tests. Yikes.
*/

foreach($metar as $k => $v) {

/* If we've reached the remark section of the METAR string, set the $rmk variable to one
We'll use this variable to figure out where in the string we are, since some information
is always before the RMK section, and some is after.
*/
if ($v == "RMK") {
$rmk = 1;
}

/* Check for a windspeed string.
This will be of the form DDDSS[GSS]KT
([D]irection in degrees, [S]peed in knots)
The gust indication (GSS) may not be there.
We just test for the string "KT".
*/
if (strstr($v, "KT") && $k != 0 && $rmk == 0) {
// get wind direction
$winddir = substr($v, 0, 3);
// Now we convert the wind direction in degrees to a wind direction.
if (($winddir >=0 && $winddir < 23) OR ($winddir <=360 && $winddir >337)) {
$compass = "N";
}
if ($winddir >=23 && $winddir < 58) {
$compass = "NE";
}
if ($winddir >=58 && $winddir < 113) {
$compass = "E";
}
if ($winddir >=113 && $winddir < 158) {
$compass = "SE";
}
if ($winddir >=158 && $winddir < 203) {
$compass = "S";
}
if ($winddir >=203 && $winddir < 248) {
$compass = "SW";
}
if ($winddir >=248 && $winddir < 293) {
$compass = "W";
}
if ($winddir >=293 && $winddir < 337) {
$compass = "NW";
}
//get wind speed
$windspd = substr($v, 3, 2);
// convert to miles per hour.
$speedy = round($windspd / 0.8684);
// if there's no wind, set the compass to "C" for CALM
if ($speedy == "0") {
$compass = "C";
}
$phetar['windcompass'] = $compass;

$phetar['windspeed'] = $speedy;

// check for wind gusts
if (preg_match ("/G([0-9]+)/", $v, $windgust)) {
$gusty = round($windgust[1] / 0.8684);
// and store that.
$phetar['windgust'] = $gusty;
}
}

/* But some stations use meters per second (MPS). Wacky!
So, we'll include a test for this. See the comments above for more information.
*/
if (strstr($v, "MPS") && $k != 0 && $rmk == 0) {
// wind direction
$winddir = substr($v, 0, 3);
if (($winddir >=0 && $winddir < 23) OR ($winddir <=359 && $winddir >337)) {
$compass = "N";
}
if ($winddir >=23 && $winddir < 58) {
$compass = "NE";
}
if ($winddir >=58 && $winddir < 113) {
$compass = "E";
}
if ($winddir >=113 && $winddir < 158) {
$compass = "SE";
}
if ($winddir >=158 && $winddir < 203) {
$compass = "S";
}
if ($winddir >=203 && $winddir < 248) {
$compass = "SW";
}
if ($winddir >=248 && $winddir < 293) {
$compass = "W";
}
if ($winddir >=293 && $winddir < 337) {
$compass = "NW";
}
// wind speed
$windspd = substr($v, 3, 2);
$speedy = round($windspd * 3600 / 1610.3 * 1000) / 1000;
if ($speedy == "0") {
$compass = "C";
}
// store data
$phetar['windcompass'] = $compass;

$phetar['windspeed'] = $speedy;

// check for wind gusts
if (preg_match ("/G([0-9]+)/", $v, $windgust)) {
$gusty = round($windgust[1] * 3600 / 1610.3 * 1000) / 1000;
// and store that.
$phetar['windgust'] = $gusty;
}
}

/* This code checks for information about sky conditions.
As cloud cover is listed from higher to lower, looping allows
us to overwrite variables until we get the lowest cloud cover, which is,
of course, the one that matters for calculation of ceiling, and is the one
that all of us ground dwellers have to deal with.
We'll store descriptions in the variable $cloud and ceiling height in feet.
The cloud cover descriptions correspond to fraction of sky covered:
FEW (1/8 to 2/8); SCT (3/8 to 4/8); BKN (5/8 to 7/8); OVC (8/8)
VV indicates an indefinite ceiling (which occurs during precipitation). It is
followed by a number indicating how far into the ceiling you can see, but
I don't, currently do anything with the number.
 */
if (preg_match("/VV([0-9]+)/", $v)) {
$cloud = "Indefinite Ceiling";
}
if (strstr($v, "CLR") && $k != 0 && $rmk == 0) {
$cloud = "Clear";
}
if (strstr($v, "SKC") && $k != 0 && $rmk == 0) {
$cloud = "Clear";
}
if (strstr($v, "CAVOK") && $k != 0 && $rmk == 0) {
$cloud = "Clear";
}
if (strstr($v, "FEW") && $k != 0 && $rmk == 0) {
$cloud = "Few Clouds";
}
if (strstr($v, "SCT") && $k != 0 && $rmk == 0) {
$cloud = "Scattered Clouds";
}
if (strstr($v, "BKN") && $k != 0 && $rmk == 0) {
$cloud = "Broken Clouds";
// add a couple zeroes to the ceiling height
$ceiling = substr($v, 3, 5) . "00";
// if this is a lower ceiling than anything we've got, make it the new ceiling
// (the cloud cover must BKN or OVC for there to be a ceiling.)
if ($ceiling < $lceil) {
$lceil = $ceiling;
}
}
if (strstr($v, "OVC") && $k != 0 && $rmk == 0) {
$cloud = "Overcast";
// add a couple zeroes to the ceiling height
$ceiling = substr($v, 3, 5) . "00";
// if this is a lower ceiling than anything we've got, make it the new ceiling
// (the cloud cover must BKN or OVC for there to be a ceiling.)
if ($ceiling < $lceil) {
$lceil = $ceiling;
}
}
// we'll store this data after we've looped through every array element.



/* If there isn't a temperature reading already, get the temperature
reading. It'll be in celcius, so we'll need to convert it to fahrenheit.
This information is coded as [M]NN/[M]NN, where M indicates a negative value
and the first number is temperature, and the second is dew point. */
if (strstr($v, "/") && $k != 0 && $rmk == 0 && !$tempf) {
// split the unit into temp and dew point
$td = split("/", $v);
// change the M to a negative sign so we can do some math.
$td[0] = str_replace("M", "-", $td[0]);
$td[1] = str_replace("M", "-", $td[1]);
// change the case of the string.  We'll use this to test for the presence of letters.
// Letters shouldn't occur in the temperature/dew point string.
$testa = strtolower($td[0]);
$testb = strtolower($td[1]);
// see, here's the test.
if ($testa == $td[0] && $testb == $td[1]) {
// convert to fahernheit
$tempf = round(($td[0] * 1.8 + 32), 0);
$dewf = round(($td[1] * 1.8 + 32), 0);
// make sure that the string is treated as a number. I don't remember why this matters.
$td[0] = $td[0] / 1;
$td[1] = $td[1] / 1;

// store the temp/dewpt variables in phetar[]
$phetar['tempc'] = $td[0];
$phetar['tempf'] = $tempf;
$phetar['dewc'] = $td[1];
$phetar['dewf'] = $dewf;

/* calculate relative humidity (for Jeremy!)
Jeremy Rocks!

It's worth noting that relative humidity is temperature dependent, and
so dew point is a better measure of humidity, being independent of
temperature and whatnot. But it's also important to keep Jeremy happy, given
that he's a Falcon.
Relative humidity is in percent, and it's calculated off of the temp/dewpt numbers.
*/
$rh = (112 - (0.1 * $td[0] ) + $td[1]) / (112 + (0.9 * $td[0]));
$relh = round(100.0 * (pow($rh,8)));
// and store the RH.
$phetar['relhumidity'] = $relh;

/* calculate windchill, if the temperature is below 45 F and there is actually some wind.
This returns two windchills: one for celcius and one for fahrenheit. It's the new equation too!
*/
if ($tempf < 45 and $speedy > 0) {
$wcf = (35.74 + 0.6215 * $tempf - 35.75 * pow($speedy,0.16) + 0.4275 * $tempf * pow($speedy,0.16));
$wcc = round(($wcf - 32)/ 1.8);
// store data in phetar[]
$phetar['windchillc'] = $wcc;
$phetar['windchillf'] = round($wcf);
}

/* calculate heat index, if the temperature is above 80 F.
This is the how hot it feels thing that is used in the United States, so that
your local TV news can make fancy weather graphics with exploding thermometers.
*/
if ($tempf > 80) {
$hif = -42.379 + 2.04901523 * $tempf + 10.14333127 * $relh - 0.22475541 * $tempf * $relh - 0.00683783 * $tempf * $tempf - 0.05481717 * $relh * $relh + 0.00122874 * $tempf * $tempf * $relh  + 0.00085282 * $tempf * $relh * $relh - 0.00000199 * $tempf * $tempf * $relh * $relh;
$hic = round(($hif - 32)/ 1.8);
// store data in phetar[]
$phetar['heatindexc'] = $hic;
$phetar['headindexf'] = round($hif);
}

/* calculate humidex, if the temperature is above 80 F.
This is the equation used by the friendly Canadians, and tends to be much higher than
the American heat index. This indicates that Americans are insensitve relative to
Canadians. (No, it doesn't).
*/
if ($tempf >80) {
$humidex = $td[0] + (5/9) * ((6.112 * pow(10, (7.5 * $td[0] / (237.7 + $td[0]))) * ($relh/100)) - 10);
$humidef = round(($humidex * 1.8 + 32), 0);
// store data in phetar[]
$phetar['humidexc'] = round($humidex);
$phetar['humidexf'] = $humidef;
}
}
}

/* catch visibility. We do this by looking for the string SM, which represents statute miles.
We have to deal with fractions here, so I've set my kulge gun to stun. */
if (strstr($v, "SM") && $k != 0 && $rmk == 0) {
// if it's a fraction ...
if (preg_match("/M?([0-9]+)\/([0-9]+)/", $v, $visfrac)) {
// separate the numerator and denominator ...
$un = $visfrac[1];
$ud = $visfrac[2];
/* then get the whole number if it exists (if not, then the unit to the left (the previous unit)
will be the wind speed. So we can test for the absence of the string 'KT' in the previous
unit. */
if (!preg_match("/KT/", $metar[$k-1])) {
$addit = $metar[$k-1];
}
$g = $addit + $un/$ud;
}
else {
// of course, there might not be a fraction at all.
$g = substr($v, 0, (strlen($v)-2));
// and again, we're making sure that this is a number. again, I don't know why.
$g = $g / 1;
}
// store in phetar[]
$phetar['visibility'] = $g;
}

if (preg_match("/([0-9]{4})M/", $v, $intvis) && $k != 0) {
$g = $intvis[1];
$g = $g / 1000;
$g = round($g * 0.6214);
$phetar['visibility'] = $g;

}

if (preg_match("/([0-9]{4})/", $v, $intvis) && $k != 0 && preg_match("/KT/", $metar[$k-1])) {
$g = $intvis[1];
$g = $g / 1000;
$g = round($g * 0.6214);
$phetar['visibility'] = $g;

}

/* so what if there is not reduction of visibility?
Well, we'll just call this visibiltity 10 miles, as that's about as far as matters.
CAVOK is a code for no weather significant to aviation, and I'm interpreting it
liberally.
*/
if (strstr($v, "9999") && $k != 0 && $rmk == 0) {
$phetar['visibility'] = 10;
}
if (strstr($v, "CAVOK") && $k != 0 && $rmk == 0) {
$phetar['visibility'] = 10;
}

/* Pressure is a bit of a nightmare. It's reported in all sorts of ways.
How magical.  We'll start with SLP (sea level pressure) denoted in SLPNNN */
if (strstr($v, "SLP") && $k != 0) {
$prepre = str_replace("SLP", "", $v);
if ($prepre > 500) {
// if the number starts with 9, it's 900 odd millibars ...
$press = "9" . substr($prepre, 0, 2) . "." . substr($prepre, 2, 1);
}
else {
// otherwise it's 1000 odd millibars.
$press = "10" . substr($prepre, 0, 2) . "." . substr($prepre, 2, 1);
}
// store data in phetar[]
$phetar['pressure'] = $press;
// prevent further pressure calculations.
$nodef = 1;
}

/* sometimes there's no pressure reading because the pressure is falling
too rapidly to get a reading. Hurricanes cause this. Oh, those crazy hurricanes.
Anyhow, we'd better deal with this, cause it's in the METAR. (It's denoted
by PRESFR.)
*/

if (strstr($v, "PRESFR") && $k != 0) {
$press = "Falling Rapidly";
// store data in phetar[]
$phetar['pressure'] = $press;
// prevent further calculations
$nodef = 1;
}

// likewise for rapidly rising pressure
if (strstr($v, "PRESRR") && $k != 0) {
$press = "Rising Rapidly";
// store data in phetar[]
$phetar['pressure'] = $press;
// prevent further calculations
$nodef = 1;
}


// sometimes the pressure is just sitting there as a 4 digit number.
if (preg_match("/\b((09|10)[0-9]{2})\b/", $v, $fdpres) && $k != 0) {
$press = $fdpres[1];
// store data in phetar[]
$phetar['pressure'] = $press;
// prevent further calculation
$nodef = 1;
}

// and sometimes it's a five digit number, the last digit being tenths of a millibar
if (preg_match("/\b((09|10)[0-9]{3})\b/", $v, $sdpres) && $k != 0 && $rmk == 1) {
$press = $sdpres[1] / 10;
// store data in phetar[]
$phetar['pressure'] = $press;
// prevent further calculation
$nodef = 1;
}

/* finally, some unmanned stations report their pressure from the inches of
mercury in an altimeter. This is marked by A####, where the last two digit are tenths and
hundredths, respectively. We'll convert this to millibars. Manned stations may also
report this number, but it's less accurate, so we'll store it in a separate variable
and then check after we've looped through all elements and use it if there's
nothing else. */
if (preg_match("/\bA((2|3)[0-9]{3})\b/", $v, $sdpres) && $k != 0 && $rmk == 0) {

$press = round($sdpres[1] * 0.33864, 1);
$defpress = $press;

}



/* International types prefix the pressuree reading with a 'Q'
on occasion. The reading is still in millibars. */
if (preg_match("/Q([0-9]{4})/", $v, $intpres) && $k != 0) {
$press = $intpres[1];
$phetar['pressure'] = $press;
$nodef = 1;
}

/* Now we'll hunt through the pre-remark region for weather phenomena. 
We do this by looking for the appropriate letter strings, along with
any modifiers (- (light); + (heavy)). We also restrict the search to
the pre-remark region. 
This is followed by the translation of the letter strings into descriptions.
We then add this information to the current conditions ($ccond)
variable, along with a comma. 
Yay, regex!
*/

if (preg_match ("/\A(\+|-|VC){0,1}(MI|PR|BC|DR|BL|SH|TS|FZ|){0,1}(DZ|RA|SN|SG|IC|PE|PL|GR|GS|UP|BR|FG|FU|VA|DU|SA|HZ|PY|PO|SQ|FC|SS|RAPL|RASN|SNRA|SNPL)\Z/", $v, $pheno) && $rmk==0 && $k != 0) {

$prox = "";
$dscrp = "";
$wph = "";
$edscrp = "";

switch ($pheno[1]) {
    case "+":
        $prox = "Heavy ";
        break;
    case "-":
        $prox = "Light ";
        break;
    case "VC":
        $prox = "Nearby ";
        break;
}

switch ($pheno[3]) {
    case "DZ":
        $wph = "Drizzle";
        break;
    case "RA":
        $wph = "Rain";
        break;
    case "SN":
        $wph = "Snow";
        break;
    case "SG":
        $wph = "Snow Grains";
        break;
    case "IC":
        $wph = "Ice Crystals";
        break;
    case "PE":
        $wph = "Ice Pellets";
        break;
    case "PL":
        $wph = "Ice Pellets";
        break;
    case "GR":
        $wph = "Hail";
        break;
    case "GS":
        $wph = "Hail/Snow Pellets";
        break;
    case "UP":
        $wph = "Unknown Precipitation";
        break;
    case "BR":
        $wph = "Mist";
        break;
    case "FG":
        $wph = "Fog";
        break;
    case "FU":
        $wph = "Smoke";
        break;
    case "VA":
        $wph = "Volcanic Ash";
        break;
    case "DU":
        $wph = "Widespread Dust";
        break;
    case "SA":
        $wph = "Sand";
        break;
    case "HZ":
        $wph = "Haze";
        break;
    case "PY":
        $wph = "Spray";
        break;
    case "PO":
        $wph = "Sand Whirls";
        break;
    case "SQ":
        $wph = "Squalls";
        break;
    case "FC":
        $dscrp = "";
        $wph = "Tornado";
        break;
    case "SS":
        $wph = "Sandstorm";
        break;
    case "RAPL":
        $wph = "Rain/Ice Mix";
        break;
    case "RASN":
        $wph = "Rain/Snow Mix";
        break;
    case "SNRA":
        $wph = "Snow/Rain Mix";
        break;
    case "SNPL":
        $wph = "Snow/Ice Mix";
        break;
}

switch ($pheno[2]) {
    case "MI":
        $dscrp = "Shallow ";
        break;
    case "PR":
        $dscrp = "Partial ";
        break;
    case "BC":
        $dscrp = "Patches ";
        break;
    case "DR":
        $dscrp = "Low Drifting ";
        break;
    case "BL":
        $dscrp = "Blowing ";
        break;
    case "SH":
        $edscrp = " Showers";
        break;
    case "TS":
        $wph = "Thunderstorm ";
        break;
    case "FZ":
        $dscrp = "Freezing ";
        break;


}



$cconda = $prox . $dscrp . $wph . $edscrp . ", ";
if ($cconda != $ccondb) {
$ccond .= $cconda;
$ccondb = $cconda;
}
}

// That's it! We've finished looping. No more loopiness!
}

// Has a pressure been defined? If not, use the altimeter reading.
if (!$nodef) {
$phetar['pressure'] = $defpress;
}

/* The current conditions consist of the current conditions string,
less the first two characters, which we added as filler before the loop.
I have no idea why I did this this way, but it doesn't really matter. */
$f = strlen($ccond);
$scond = substr($ccond, 0, ($f-2));
// as long as there are sky conditions or weather phenomena, store the data.
if ($cloud || $scond) {
$phetar['conditions'] = $cloud . $scond;
}

// if there's a ceiling, store the data.
if ($lceil == "-1") {
$phetar['ceiling'] = "Indefinite";
} elseif ($lceil != 999999999) {
$phetar['ceiling'] = $lceil/1;
}

// now let's store the raw METAR string, just for the fun of it. Wheeee!
$phetar['rawdata'] = $getdata[1];

/* There are all sorts of things that are in the remark section that I haven't
yet dealt with.  I'll add things now and then as I have time. But for now, that's
it. */

}
else
{
/* if the station doesn't exist, indicate this by setting
the station code to 'XXXX'.
*/
$phetar['station'] = "XXXX";
}

/* well, now we'll need to do something this this data.
I do all sorts of things - an XML output, a weather panel log,
a WML output so that I can check the weather on my cellphone
while travelling. In the commented out example below, we print
the contents of the array. Now THAT is exciting.

echo ("<html>");
echo ("<head>");
echo ("<title>");
echo ("</title>");
echo ("</head>");
echo ("<body>");
echo ("<pre>");
print_r($parsed);
echo ("</pre>");
echo ("</body>");
echo ("</html>"); */

/* The best way to use this code is to set the variable $q to the station code
that you want, and then to include the phetar.php file. Setting $meth to 'html'
is optional. The three lines of code that you would use are below (assuming that
you've saved this file as phetar.php).

$meth = "html";
$q = "ktew";
include("phetar.php");

This would return the array $phetar[], which you could use as you deem fit.

*/

?>


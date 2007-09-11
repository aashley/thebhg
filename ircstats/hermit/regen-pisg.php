<?php
$db = mysql_connect('localhost', 'thebhg', '1IHfHTsAmILMwpP');
mysql_select_db('ircstats', $db);

ini_set('include_path', ini_get('include_path') . ':/var/www/html/include');
include('roster.inc');
$roster = new Roster();

header('Content-Type: text/plain');

$now = time();
$month = (int) date('m', $now);
$mstr = sprintf('%02u', $month);
$year = (int) date('Y');

echo <<<EOC
# Config file for pisg (set up all your channels/logfiles here)
#
# For a list of all configuration options, see docs/pisg-doc.txt or
# docs/html/index.html for a HTML version.
#
# Here is some basic examples, uncomment them to make them actually do
# something.
#
# <user nick="Joe" alias="Joe^away Joe^work" pic="joe.jpg" link="joe@joe.com">
#
# <set FoulWords="ass bitch fuck" Maintainer="SomeMaintainer">
#
# <channel="#channel">
#   Logfile="channel2.log"
#   Format="mIRC"
#   Network="SomeIRCNet"
#   OutputFile="index.html"
# </channel>
#
<channel="#bhg">
  LogDir="/home/thebhg/domains/ircstats.thebhg.org/irc/bhg/"
  LogPrefix="$year$mstr.."
  Format="eggdrop"
  Maintainer="Jernai Teifsel"
  OutputFile="/home/anya/public_html/current.php"
  Network="Undernet"
  ActiveNicks="75"
  ActiveNicks2="40"
  ShowWpl="1"
  ShowLastSeen="1"
  ShowWords="1"
  ShowLineTime="0"
  SortByWords="1"
  PageHead="id.php"
</channel>
<set FoulWords="ass fuck bitch shit arse cunt cock">
<set ViolentWords="slaps beats kicks rapes smacks belts beats kills whacks thwacks thwaps whaps whips">

<user nick="Timer" alias="Timer">
<user nick="Chetti" alias="*Chetti*">
<user nick="X" alias="X" ignore="y">
<user nick="Slade" alias="*Slade*">
<user nick="Shana" alias="shana">
<user nick="Saje" alias="*saje*">
<user nick="SSL-Rune" alias="SSL-Rune">
<user nick="Rich" alias="ElvenPub">
<user nick="Rea" alias="G-Rea-T">
<user nick="Chi-Long" alias="Chi-*">
<user nick="Raven" alias="[Raven] R[*]">
<user nick="Rapier" alias="FA_Rapier">
<user nick="Ramos (EH)" alias="*Ramos">
<user nick="Kraven" alias="*kraven*">
<user nick="Blazer" alias="Blazer">
<user nick="Orion" alias="*Orion*">
<user nick="Nightflier" alias="NF">
<user nick="Khaen" alias="Khaen">
<user nick="Moreco" alias="`Moreco">
<user nick="Jinx" alias="*JinX*">
<user nick="Daken" alias="Daken">
<user nick="Mallas" alias="Mallas">
<user nick="M0u53" alias="M0u53">
<user nick="Lodo" alias="Lodo">
<user nick="Locust" alias="*locust*">
<user nick="Motti (EH)" alias="*Motti MottiGone">
<user nick="Chi_Long (EH)" alias="Chi*Long">
<user nick="Caithne " alias="caithne">
<user nick="Marenta" alias="*Marenta* MarCode">
<user nick="Joba" alias="*Joba*">
<user nick="Bret" alias="*Bret*">
<user nick="Hearn" alias="*Hearn">
<user nick="Extream" alias="*Extream*">
<user nick="Astin" alias="*Astin*">
<user nick="Joe" alias="Joery*">
<user nick="Brad Tack" alias="Tack MajorTack">
<user nick="Manesh" alias="Manesh">
<user nick="Alex" alias="KAP_Alex *Alex N0one">
<user nick="Phillraiser" alias="Phillrais">
<user nick="DeathFyre" alias="*DeathFyre* *kumba*" ignore="y">
<user nick="Deacon Zander" alias="MF_Zander">
<user nick="NaNaKi (??)" alias="*NaNaKi*">
<user nick="Cavefish" alias="*Cavefish* Wildpig">
<user nick="Magnus Rezdar" alias="MRCGhost BHG_GHOST ASSTGhost GhostRez GhostRey JRNYGHOST GhostShip GHOSTAWAY *Rezdar* Moltar Ghost `Ghost Rez-HTML SGT_Rezdr ASAN_Rez LCM_Rez Snake` Rezzy Rez Rezzybop">
<user nick="Omega Guy (??)" alias="OmegaGuy Omega_Gu">
<user nick="Matti Kuokkanen (EH)" alias="Isojalka">
<user nick="Obi Wan (EH)" alias="*Legolas*">
<user nick="Dolemite (??)" alias="dolemite adrock">
<user nick="Mik (??)" alias="mik">

EOC;

$result = mysql_query('SELECT * FROM nicks ORDER BY person ASC', $db);
$last_pleb = 0;
while ($row = mysql_fetch_array($result)) {
	if ($row['person'] != $last_pleb) {
		if ($last_pleb) echo "\">\n";
		$last_pleb = $row['person'];
		echo "<user nick=\"<?php id($last_pleb); ?>\" alias=\"";
		$pleb = $roster->GetPerson($last_pleb);
		$nicks = explode(' ', str_replace(array(',', ';', '/', '='), ' ', $pleb->GetIRCNicks()));
		if (count($nicks)) {
			echo implode(' ', $nicks) . ' ';
		}
	}
	echo stripslashes($row['nick']) . ' ';
}
echo '">';

?>

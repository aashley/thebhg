<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>#bhg @ Undernet stats by Jernai Teifsel</title>
<style type="text/css">
a {
     text-decoration: none;
 }
 a:link {
     color: #0b407a;
 }
 a:visited {
     color: #0b407a;
 }
 
 a:hover {
     text-decoration: underline;
     color: #0b407a;
 }
 
 a.background {
     text-decoration: none;
 }
 
 a.background:link {
     color: #0b407a;
 }
 
 a.background:visited {
     color: #0b407a;
 }
 
 a.background:hover {
     text-decoration: underline;
     color: #0b407a;
 }
 
 body {
     background: #dedeee url("hermit/images/pisg-bg.gif") no-repeat fixed 0% 90%;
     font-family: Verdana, Arial, sans-serif;
     font-size: 13px;
     color: black;
 }
 
 td {
     font-family: Verdana, Arial, sans-serif;
     font-size: 13px;
     color: black;
     text-align: left;
 }
 
 .title {
     font-family: Tahoma, Arial, sans-serif;
     font-size: 16px;
     font-weight: bold;
 }
 
 .headtext {
     color: white;
     font-weight: bold;
     text-align: center;
     background-color: #666699;
 }
 
 .headlinebg {
     background-color: #000000;
 }
 
 .tdtop {
     background-color: #C8C8DD;
 }
 
 .hicell {
     background-color: #BABADD;
 }
 
 .hicell10 {
     background-color: #BABADD;
     font-size: 10px;
 }
 
 .rankc {
     background-color: #CCCCCC;
 }
 
 .hirankc {
     background-color: #AAAAAA;
     font-weight: bold;
 }
 
 .rankc10 {
     background-color: #CCCCCC;
     font-size: 10px;
 }
 
 .rankc10center {
     background-color: #CCCCCC;
     font-size: 10px;
     text-align: center;
 }
 
 .hirankc10center {
     background-color: #AAAAAA;
     font-weight: bold;
     font-size: 10px;
     text-align: center;
 }
 
 .small {
     font-family: Verdana, Arial, sans-serif;
     font-size: 10px;
 }
 
 
 .asmall {
       font-family: "Arial narrow", Arial, sans-serif;
       font-size: 10px;
       color: black;
       text-align: center;
 }

</style></head>
<body>
<div align="center">
<span class="title">#bhg @ Undernet stats by Jernai Teifsel</span><br />
<br />
Statistics generated on  Friday 13 June 2003 - 6:04:31
<br />During this 31-day reporting period, a total of <b>528</b> different nicks were represented on #bhg.<br /><br />
<?php

ini_set('include_path', ini_get('include_path') . ':/var/www/html/include');

include('roster.inc');



$roster = new Roster();



function id($id) {

	global $roster;

	$pleb = $roster->GetPerson($id);

	$rank = $pleb->GetRank();

	$div = $pleb->GetDivision();

	echo $rank->GetName() . ' ' . $pleb->GetName() . ' (' . $div->GetName() . ')';

}

?>

   <br />
   <table width="730" cellpadding="1" cellspacing="0" border="0">
    <tr>
     <td class="headlinebg">
      <table width="100%" cellpadding="2" cellspacing="0" border="0">
       <tr>
        <td class="headtext">Most active times</td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
<table border="0"><tr>

<td align="center" valign="bottom" class="asmall">4.4%<br /><img src="./blue-v.png" width="15" height="76.7336942510956" alt="4.4" /></td>

<td align="center" valign="bottom" class="asmall">5.3%<br /><img src="./blue-v.png" width="15" height="91.5699922660479" alt="5.3" /></td>

<td align="center" valign="bottom" class="asmall">4.4%<br /><img src="./blue-v.png" width="15" height="75.6896107244135" alt="4.4" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./blue-v.png" width="15" height="53.4287187419438" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">2.0%<br /><img src="./blue-v.png" width="15" height="34.7898943026553" alt="2.0" /></td>

<td align="center" valign="bottom" class="asmall">2.6%<br /><img src="./blue-v.png" width="15" height="44.9600412477443" alt="2.6" /></td>

<td align="center" valign="bottom" class="asmall">2.2%<br /><img src="./green-v.png" width="15" height="38.7857695282289" alt="2.2" /></td>

<td align="center" valign="bottom" class="asmall">2.4%<br /><img src="./green-v.png" width="15" height="41.1704047434906" alt="2.4" /></td>

<td align="center" valign="bottom" class="asmall">2.4%<br /><img src="./green-v.png" width="15" height="41.312193864398" alt="2.4" /></td>

<td align="center" valign="bottom" class="asmall">3.4%<br /><img src="./green-v.png" width="15" height="59.2549626192318" alt="3.4" /></td>

<td align="center" valign="bottom" class="asmall">3.5%<br /><img src="./green-v.png" width="15" height="61.2142304717711" alt="3.5" /></td>

<td align="center" valign="bottom" class="asmall">5.8%<br /><img src="./green-v.png" width="15" height="100" alt="5.8" /></td>

<td align="center" valign="bottom" class="asmall">5.3%<br /><img src="./yellow-v.png" width="15" height="91.6215519463779" alt="5.3" /></td>

<td align="center" valign="bottom" class="asmall">5.4%<br /><img src="./yellow-v.png" width="15" height="93.0652229956174" alt="5.4" /></td>

<td align="center" valign="bottom" class="asmall">5.4%<br /><img src="./yellow-v.png" width="15" height="93.9675174013921" alt="5.4" /></td>

<td align="center" valign="bottom" class="asmall">4.7%<br /><img src="./yellow-v.png" width="15" height="80.8069089971642" alt="4.7" /></td>

<td align="center" valign="bottom" class="asmall">4.5%<br /><img src="./yellow-v.png" width="15" height="78.8218613044599" alt="4.5" /></td>

<td align="center" valign="bottom" class="asmall">4.6%<br /><img src="./yellow-v.png" width="15" height="79.3890177880897" alt="4.6" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./red-v.png" width="15" height="66.0995101830369" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./red-v.png" width="15" height="72.2866718226347" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">3.9%<br /><img src="./red-v.png" width="15" height="67.5560711523589" alt="3.9" /></td>

<td align="center" valign="bottom" class="asmall">4.8%<br /><img src="./red-v.png" width="15" height="83.3720030935808" alt="4.8" /></td>

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./red-v.png" width="15" height="84.9445733436453" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./red-v.png" width="15" height="85.3054911059551" alt="4.9" /></td>

</tr><tr>
<td class="rankc10center" align="center">0</td>
<td class="rankc10center" align="center">1</td>
<td class="rankc10center" align="center">2</td>
<td class="rankc10center" align="center">3</td>
<td class="rankc10center" align="center">4</td>
<td class="rankc10center" align="center">5</td>
<td class="rankc10center" align="center">6</td>
<td class="rankc10center" align="center">7</td>
<td class="rankc10center" align="center">8</td>
<td class="rankc10center" align="center">9</td>
<td class="rankc10center" align="center">10</td>
<td class="hirankc10center" align="center">11</td>
<td class="rankc10center" align="center">12</td>
<td class="rankc10center" align="center">13</td>
<td class="rankc10center" align="center">14</td>
<td class="rankc10center" align="center">15</td>
<td class="rankc10center" align="center">16</td>
<td class="rankc10center" align="center">17</td>
<td class="rankc10center" align="center">18</td>
<td class="rankc10center" align="center">19</td>
<td class="rankc10center" align="center">20</td>
<td class="rankc10center" align="center">21</td>
<td class="rankc10center" align="center">22</td>
<td class="rankc10center" align="center">23</td>
</tr></table>
<table align="center" border="0" width="520"><tr>
<td align="center" class="asmall"><img src="./blue-h.png" width="40" height="15" align="middle" alt="0-5" /> = 0-5</td>
<td align="center" class="asmall"><img src="./green-h.png" width="40" height="15" align="middle" alt="6-11" /> = 6-11</td>
<td align="center" class="asmall"><img src="./yellow-h.png" width="40" height="15" align="middle" alt="12-17" /> = 12-17</td>
<td align="center" class="asmall"><img src="./red-h.png" width="40" height="15" align="middle" alt="18-23" /> = 18-23</td>
</tr></table>

   <br />
   <table width="730" cellpadding="1" cellspacing="0" border="0">
    <tr>
     <td class="headlinebg">
      <table width="100%" cellpadding="2" cellspacing="0" border="0">
       <tr>
        <td class="headtext">Most active nicks</td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
<table border="0" width="734"><tr>
<td>&nbsp;</td><td class="tdtop"><b>Nick</b></td><td class="tdtop"><b>Number of lines</b></td><td class="tdtop"><b>When?</b></td><td class="tdtop"><b>Number of Words</b></td><td class="tdtop"><b>Words per line</b></td><td class="tdtop"><b>Last seen</b></td><td class="tdtop"><b>Random quote</b></td>
</tr>
<tr><td class="hirankc" align="left">1</td>
<td style="background-color: #babadc"><?php id(747); ?></td><td style="background-color: #babadc">10854</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #babadc">46013</td><td style="background-color: #babadc">4.2</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"wee, tell your mom i said happy mothers day pwease!"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(331); ?></td><td style="background-color: #babadc">10397</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #babadc">43585</td><td style="background-color: #babadc">4.2</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"............!!!!!!!!!!.........."</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(2029); ?></td><td style="background-color: #babadc">5086</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="23" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #babadc">32715</td><td style="background-color: #babadc">6.4</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"my seat is oddly warm... why is that?"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(1247); ?></td><td style="background-color: #babadc">5320</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #babadc">28117</td><td style="background-color: #babadc">5.3</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"As that would screw the aircraft totally :P"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(57); ?></td><td style="background-color: #bbbbdb">3958</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bbbbdb">27521</td><td style="background-color: #bbbbdb">7.0</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"meh. school isnt worth caring about"</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(370); ?></td><td style="background-color: #bbbbdb">4322</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #bbbbdb">25221</td><td style="background-color: #bbbbdb">5.8</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"then i wont know what to do &gt;:-P"</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(1551); ?></td><td style="background-color: #bbbbdb">3696</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bbbbdb">20829</td><td style="background-color: #bbbbdb">5.6</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"Or Apocalyptica, but I doubt you meant them. :P"</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(1908); ?></td><td style="background-color: #bbbbdb">4349</td><td style="background-color: #bbbbdb"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bbbbdb">19103</td><td style="background-color: #bbbbdb">4.4</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"I think that the game on now will decide the other one..."</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(666); ?></td><td style="background-color: #bcbcda">1884</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #bcbcda">17619</td><td style="background-color: #bcbcda">9.4</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"anything braga describes as "really cool" disturbs me"</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(95); ?></td><td style="background-color: #bcbcda">2321</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #bcbcda">16231</td><td style="background-color: #bcbcda">7.0</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"kul koral, i know 4 (just about to be releaesd here) isn't wide"</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(168); ?></td><td style="background-color: #bcbcda">1679</td><td style="background-color: #bcbcda"><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #bcbcda">15387</td><td style="background-color: #bcbcda">9.2</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"and then stab him with a butterfly knife."</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(484); ?></td><td style="background-color: #bcbcda">2290</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #bcbcda">13724</td><td style="background-color: #bcbcda">6.0</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"isp's dns servers just went down"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(1803); ?></td><td style="background-color: #bdbdda">2291</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #bdbdda">12579</td><td style="background-color: #bdbdda">5.5</td><td style="background-color: #bdbdda">Today</td><td style="background-color: #bdbdda">"nirvana ruled until courtney love killed kurt ..."</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9"><?php id(1625); ?></td><td style="background-color: #bdbdd9">2327</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bdbdd9">12441</td><td style="background-color: #bdbdd9">5.3</td><td style="background-color: #bdbdd9">1 day ago</td><td style="background-color: #bdbdd9">"Just eat lunch or something?"</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(16); ?></td><td style="background-color: #bdbdd9">1459</td><td style="background-color: #bdbdd9"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #bdbdd9">12345</td><td style="background-color: #bdbdd9">8.5</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"... the l3t hurts cour... &gt;:P"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(141); ?></td><td style="background-color: #bdbdd9">1940</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #bdbdd9">10857</td><td style="background-color: #bdbdd9">5.6</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"he;s got carploads of mp3'"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(23); ?></td><td style="background-color: #bebed9">1571</td><td style="background-color: #bebed9"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #bebed9">10527</td><td style="background-color: #bebed9">6.7</td><td style="background-color: #bebed9">Today</td><td style="background-color: #bebed9">"no, they usually want swearing immunity."</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8"><?php id(1754); ?></td><td style="background-color: #bebed8">2042</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bebed8">9990</td><td style="background-color: #bebed8">4.9</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"she's got jungle fever, there might've been splash damage"</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(1772); ?></td><td style="background-color: #bebed8">2313</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #bebed8">9686</td><td style="background-color: #bebed8">4.2</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"Because... I'll be praying for that"</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(1583); ?></td><td style="background-color: #bebed8">1776</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #bebed8">9067</td><td style="background-color: #bebed8">5.1</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"hmm... that made me hungry..."</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8">FruitCak</td><td style="background-color: #bfbfd8">1080</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #bfbfd8">8987</td><td style="background-color: #bfbfd8">8.3</td><td style="background-color: #bfbfd8">1 day ago</td><td style="background-color: #bfbfd8">"why would she be in my stomach?"</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(1332); ?></td><td style="background-color: #bfbfd8">1984</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="24" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #bfbfd8">7741</td><td style="background-color: #bfbfd8">3.9</td><td style="background-color: #bfbfd8">9 days ago</td><td style="background-color: #bfbfd8">"have youever seen what a drunk can do?"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7"><?php id(14); ?></td><td style="background-color: #bfbfd7">1129</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="25" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #bfbfd7">7591</td><td style="background-color: #bfbfd7">6.7</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"You can be the drunk uncle. :P"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7"><?php id(1699); ?></td><td style="background-color: #bfbfd7">1472</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="30" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #bfbfd7">7334</td><td style="background-color: #bfbfd7">5.0</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"i'll pass, but thanks for the offer"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(473); ?></td><td style="background-color: #c0c0d7">1674</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c0c0d7">7106</td><td style="background-color: #c0c0d7">4.2</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"Which I doubt, because Ehart CCs me on most everything."</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(1187); ?></td><td style="background-color: #c0c0d7">958</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c0c0d7">6729</td><td style="background-color: #c0c0d7">7.0</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"oh, and Gen: Rocko was also good on Nick"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6">Walldawg</td><td style="background-color: #c0c0d6">1854</td><td style="background-color: #c0c0d6"><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c0c0d6">5859</td><td style="background-color: #c0c0d6">3.2</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"i pass core and have a ship"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6"><?php id(300); ?></td><td style="background-color: #c0c0d6">698</td><td style="background-color: #c0c0d6"><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="22" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c0c0d6">5297</td><td style="background-color: #c0c0d6">7.6</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"Still nothing new. Ah well. It can wait."</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6">BranMan</td><td style="background-color: #c0c0d6">979</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c0c0d6">5146</td><td style="background-color: #c0c0d6">5.3</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"I thought it was monkey muck"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6"><?php id(275); ?></td><td style="background-color: #c1c1d6">733</td><td style="background-color: #c1c1d6"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="23" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c1c1d6">5108</td><td style="background-color: #c1c1d6">7.0</td><td style="background-color: #c1c1d6">Today</td><td style="background-color: #c1c1d6">"hey, the ego comes with the job ;)"</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5">FruitCak_</td><td style="background-color: #c1c1d5">594</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="28" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c1c1d5">5060</td><td style="background-color: #c1c1d5">8.5</td><td style="background-color: #c1c1d5">6 days ago</td><td style="background-color: #c1c1d5">"out 1400 homes and, of course, one raccoon.""</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5">SanSri</td><td style="background-color: #c1c1d5">1024</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c1c1d5">4917</td><td style="background-color: #c1c1d5">4.8</td><td style="background-color: #c1c1d5">3 days ago</td><td style="background-color: #c1c1d5">"And it always makes me wonder...what if the matrix was real?"</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5"><?php id(1843); ?></td><td style="background-color: #c1c1d5">1099</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c1c1d5">4602</td><td style="background-color: #c1c1d5">4.2</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"RIS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!"</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5"><?php id(1068); ?></td><td style="background-color: #c2c2d5">637</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c2c2d5">4120</td><td style="background-color: #c2c2d5">6.5</td><td style="background-color: #c2c2d5">3 days ago</td><td style="background-color: #c2c2d5">"I've always wished the BHG would crack down on names like that."</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5">Felger</td><td style="background-color: #c2c2d5">565</td><td style="background-color: #c2c2d5"><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c2c2d5">3814</td><td style="background-color: #c2c2d5">6.8</td><td style="background-color: #c2c2d5">1 day ago</td><td style="background-color: #c2c2d5">"i thought we worked together during the whole minos thing"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4">^Fyre</td><td style="background-color: #c2c2d4">423</td><td style="background-color: #c2c2d4"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c2c2d4">3472</td><td style="background-color: #c2c2d4">8.2</td><td style="background-color: #c2c2d4">1 day ago</td><td style="background-color: #c2c2d4">"Most of my profit margin comes from the KA anyway. :P"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4"><?php id(242); ?></td><td style="background-color: #c2c2d4">453</td><td style="background-color: #c2c2d4"><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #c2c2d4">3096</td><td style="background-color: #c2c2d4">6.8</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"where do you live mara, we can arrange it :P"</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4"><?php id(1103); ?></td><td style="background-color: #c3c3d4">512</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="24" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c3c3d4">2944</td><td style="background-color: #c3c3d4">5.8</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"run free, little noodles!!"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4">Volo</td><td style="background-color: #c3c3d4">404</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c3c3d4">2901</td><td style="background-color: #c3c3d4">7.2</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"all he did was drool at the wall :P"</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3"><?php id(1281); ?></td><td style="background-color: #c3c3d3">477</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="32" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c3c3d3">2861</td><td style="background-color: #c3c3d3">6.0</td><td style="background-color: #c3c3d3">1 day ago</td><td style="background-color: #c3c3d3">"coursca, you enjoy yourself to much ya damn fool :-P"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3"><?php id(1762); ?></td><td style="background-color: #c3c3d3">550</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c3c3d3">2822</td><td style="background-color: #c3c3d3">5.1</td><td style="background-color: #c3c3d3">2 days ago</td><td style="background-color: #c3c3d3">"I kick my own ass well enough"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3"><?php id(2118); ?></td><td style="background-color: #c4c4d3">498</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="30" height="15" alt="" /></td><td style="background-color: #c4c4d3">2805</td><td style="background-color: #c4c4d3">5.6</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"you seriously have a death wish"</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3"><?php id(135); ?></td><td style="background-color: #c4c4d3">363</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c4c4d3">2670</td><td style="background-color: #c4c4d3">7.4</td><td style="background-color: #c4c4d3">1 day ago</td><td style="background-color: #c4c4d3">"you're damn right I want your pie!"</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(94); ?></td><td style="background-color: #c4c4d3">265</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="23" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #c4c4d3">2561</td><td style="background-color: #c4c4d3">9.7</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"blog can be used anywhere you like as far as i know"</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2"><?php id(494); ?></td><td style="background-color: #c4c4d2">460</td><td style="background-color: #c4c4d2"><img src="./yellow-h.png" border="0" width="22" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c4c4d2">2441</td><td style="background-color: #c4c4d2">5.3</td><td style="background-color: #c4c4d2">4 days ago</td><td style="background-color: #c4c4d2">"Who are you talking to, Reap?"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2"><?php id(1171); ?></td><td style="background-color: #c5c5d2">798</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c5c5d2">2290</td><td style="background-color: #c5c5d2">2.9</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"what is it that you worked on?"</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2"><?php id(1594); ?></td><td style="background-color: #c5c5d2">393</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c5c5d2">2274</td><td style="background-color: #c5c5d2">5.8</td><td style="background-color: #c5c5d2">5 days ago</td><td style="background-color: #c5c5d2">"like... right now, I lost interest and am ignoring you now. Ha."</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2"><?php id(1135); ?></td><td style="background-color: #c5c5d2">310</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c5c5d2">2246</td><td style="background-color: #c5c5d2">7.2</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"and that amount is being reduced"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1"><?php id(1627); ?></td><td style="background-color: #c5c5d1">373</td><td style="background-color: #c5c5d1"><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c5c5d1">2222</td><td style="background-color: #c5c5d1">6.0</td><td style="background-color: #c5c5d1">Today</td><td style="background-color: #c5c5d1">"i just had a big change in BHG Persona =p"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1"><?php id(1829); ?></td><td style="background-color: #c6c6d1">582</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c6c6d1">2218</td><td style="background-color: #c6c6d1">3.8</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"that'll give me something to do"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1"><?php id(2006); ?></td><td style="background-color: #c6c6d1">444</td><td style="background-color: #c6c6d1"><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c6c6d1">2061</td><td style="background-color: #c6c6d1">4.6</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"I just like to listen to Jazz every once in a while"</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1"><?php id(1218); ?></td><td style="background-color: #c6c6d1">394</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="22" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c6c6d1">2020</td><td style="background-color: #c6c6d1">5.1</td><td style="background-color: #c6c6d1">6 days ago</td><td style="background-color: #c6c6d1">"She's got a little junk going on. :P"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0">_Xar</td><td style="background-color: #c6c6d0">402</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c6c6d0">1908</td><td style="background-color: #c6c6d0">4.7</td><td style="background-color: #c6c6d0">1 day ago</td><td style="background-color: #c6c6d0">"I want to see Lara mud wrestle in the Dojo"</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0">Korbane</td><td style="background-color: #c6c6d0">231</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="28" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c6c6d0">1822</td><td style="background-color: #c6c6d0">7.9</td><td style="background-color: #c6c6d0">17 days ago</td><td style="background-color: #c6c6d0">"420 will be great I am sure :)"</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0">_Balt</td><td style="background-color: #c7c7d0">448</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="26" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c7c7d0">1807</td><td style="background-color: #c7c7d0">4.0</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"Chronas goto your startup menu"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0"><?php id(1656); ?></td><td style="background-color: #c7c7d0">378</td><td style="background-color: #c7c7d0"><img src="./green-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c7c7d0">1715</td><td style="background-color: #c7c7d0">4.5</td><td style="background-color: #c7c7d0">1 day ago</td><td style="background-color: #c7c7d0">"95% of alvaak stayed loyal :P"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0"><?php id(1489); ?></td><td style="background-color: #c7c7d0">269</td><td style="background-color: #c7c7d0"><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c7c7d0">1700</td><td style="background-color: #c7c7d0">6.3</td><td style="background-color: #c7c7d0">11 days ago</td><td style="background-color: #c7c7d0">"I like that Skylla Report: ======================"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf"><?php id(1700); ?></td><td style="background-color: #c7c7cf">507</td><td style="background-color: #c7c7cf"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="22" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c7c7cf">1698</td><td style="background-color: #c7c7cf">3.3</td><td style="background-color: #c7c7cf">Today</td><td style="background-color: #c7c7cf">"didn't know they made games..."</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf">Rlyeh1</td><td style="background-color: #c8c8cf">384</td><td style="background-color: #c8c8cf"><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c8c8cf">1635</td><td style="background-color: #c8c8cf">4.3</td><td style="background-color: #c8c8cf">2 days ago</td><td style="background-color: #c8c8cf">"Reap: poke it until it learns its lesson"</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf">^Ice</td><td style="background-color: #c8c8cf">278</td><td style="background-color: #c8c8cf"><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c8c8cf">1545</td><td style="background-color: #c8c8cf">5.6</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"I'm going to the Warped Tour with Xan"</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf">Fyre</td><td style="background-color: #c8c8cf">187</td><td style="background-color: #c8c8cf"><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="28" height="15" alt="" /></td><td style="background-color: #c8c8cf">1529</td><td style="background-color: #c8c8cf">8.2</td><td style="background-color: #c8c8cf">1 day ago</td><td style="background-color: #c8c8cf">"Going to be nice to have the Cup back in New Jeresy. :P"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce"><?php id(1943); ?></td><td style="background-color: #c8c8ce">471</td><td style="background-color: #c8c8ce"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c8c8ce">1521</td><td style="background-color: #c8c8ce">3.2</td><td style="background-color: #c8c8ce">Today</td><td style="background-color: #c8c8ce">"Zed, he is a playoff fan - you can't expect much from him."</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce"><?php id(2131); ?></td><td style="background-color: #c9c9ce">304</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #c9c9ce">1483</td><td style="background-color: #c9c9ce">4.9</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"no he said "salvation of zion""</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce"><?php id(45); ?></td><td style="background-color: #c9c9ce">210</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c9c9ce">1400</td><td style="background-color: #c9c9ce">6.7</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"moving from KA Hunts to OM's"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce">Adian</td><td style="background-color: #c9c9ce">267</td><td style="background-color: #c9c9ce"><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="25" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #c9c9ce">1229</td><td style="background-color: #c9c9ce">4.6</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"i saw the preview before the X2 movie and that by itself rocks"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce">Mal|away</td><td style="background-color: #c9c9ce">291</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c9c9ce">1210</td><td style="background-color: #c9c9ce">4.2</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"so it took me less than a second to hand her the phone :Þ"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd">Orphen</td><td style="background-color: #cacacd">132</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="30" height="15" alt="" /></td><td style="background-color: #cacacd">1156</td><td style="background-color: #cacacd">8.8</td><td style="background-color: #cacacd">14 days ago</td><td style="background-color: #cacacd">"That's what I'm sayin, wee. :P"</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd"><?php id(1085); ?></td><td style="background-color: #cacacd">247</td><td style="background-color: #cacacd"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #cacacd">1154</td><td style="background-color: #cacacd">4.7</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"Dammit deZ, I was about to say that &gt;:P"</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd"><?php id(1219); ?></td><td style="background-color: #cacacd">236</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #cacacd">1140</td><td style="background-color: #cacacd">4.8</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"the one that drove them into the water?"</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd">Necrolord</td><td style="background-color: #cacacd">268</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="24" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #cacacd">1129</td><td style="background-color: #cacacd">4.2</td><td style="background-color: #cacacd">2 days ago</td><td style="background-color: #cacacd">"and they caught them just before the elections too"</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc"><?php id(1133); ?></td><td style="background-color: #cbcbcc">233</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="27" height="15" alt="" /></td><td style="background-color: #cbcbcc">1083</td><td style="background-color: #cbcbcc">4.6</td><td style="background-color: #cbcbcc">6 days ago</td><td style="background-color: #cbcbcc">"You've got to be kidding me Elf"</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc"><?php id(1717); ?></td><td style="background-color: #cbcbcc">250</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #cbcbcc">966</td><td style="background-color: #cbcbcc">3.9</td><td style="background-color: #cbcbcc">2 days ago</td><td style="background-color: #cbcbcc">"what am i being quarantined?"</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc"><?php id(1711); ?></td><td style="background-color: #cbcbcc">127</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="27" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #cbcbcc">961</td><td style="background-color: #cbcbcc">7.6</td><td style="background-color: #cbcbcc">15 days ago</td><td style="background-color: #cbcbcc">"You could do that or... Yeah, I guess you'll just do that."</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc">XanIra`an</td><td style="background-color: #cbcbcc">163</td><td style="background-color: #cbcbcc"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #cbcbcc">956</td><td style="background-color: #cbcbcc">5.9</td><td style="background-color: #cbcbcc">20 days ago</td><td style="background-color: #cbcbcc">"WD, ANSWER ME IN THE OTHER CHAT ROOM!"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc">TradikBG</td><td style="background-color: #cccccc">183</td><td style="background-color: #cccccc"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #cccccc">941</td><td style="background-color: #cccccc">5.1</td><td style="background-color: #cccccc">28 days ago</td><td style="background-color: #cccccc">"yeah, but you suck, biatch"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10"><?php id(1732); ?> (907)</td>
<td class="rankc10">`JB (859)</td>
<td class="rankc10"><?php id(1873); ?> (851)</td>
<td class="rankc10">Arys (851)</td>
<td class="rankc10">Brandon (842)</td>
</tr><tr>
<td class="rankc10">B`thought (808)</td>
<td class="rankc10">Skor-Lit (721)</td>
<td class="rankc10"><?php id(1264); ?> (712)</td>
<td class="rankc10">^SyNthPHP (687)</td>
<td class="rankc10">CPT_Drax (677)</td>
</tr><tr>
<td class="rankc10"><?php id(264); ?> (663)</td>
<td class="rankc10">Dewulf (593)</td>
<td class="rankc10">Bran (578)</td>
<td class="rankc10">`Xan (571)</td>
<td class="rankc10">`Quack (569)</td>
</tr><tr>
<td class="rankc10"><?php id(2070); ?> (564)</td>
<td class="rankc10">`C0ur5c4 (561)</td>
<td class="rankc10"><?php id(374); ?> (535)</td>
<td class="rankc10">Q_essay (531)</td>
<td class="rankc10">TalraMUD (523)</td>
</tr><tr>
<td class="rankc10">Sayo (514)</td>
<td class="rankc10">`Dagger (493)</td>
<td class="rankc10">hazw00k (482)</td>
<td class="rankc10"><?php id(152); ?> (474)</td>
<td class="rankc10">CPT_Trent (461)</td>
</tr><tr>
<td class="rankc10"><?php id(158); ?> (449)</td>
<td class="rankc10">Jer-angel (444)</td>
<td class="rankc10"><?php id(1276); ?> (430)</td>
<td class="rankc10"><?php id(765); ?> (413)</td>
<td class="rankc10">Quack (409)</td>
</tr><tr>
<td class="rankc10">Ice-brb (407)</td>
<td class="rankc10"><?php id(1198); ?> (401)</td>
<td class="rankc10">`Obi-Wan (397)</td>
<td class="rankc10">SyNthAWAY (394)</td>
<td class="rankc10"><?php id(1413); ?> (391)</td>
</tr><tr>
<td class="rankc10">deathw (384)</td>
<td class="rankc10">Dagbert (381)</td>
<td class="rankc10"><?php id(3); ?> (369)</td>
<td class="rankc10">Trevelyan (368)</td>
<td class="rankc10">|Haz|- (359)</td>
</tr></table>
<br /><b>By the way, there were 410 other nicks.</b><br />
   <br />
   <table width="730" cellpadding="1" cellspacing="0" border="0">
    <tr>
     <td class="headlinebg">
      <table width="100%" cellpadding="2" cellspacing="0" border="0">
       <tr>
        <td class="headtext">Big numbers</td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
<table width="734">

<tr><td class="hicell">Is <b><?php id(494); ?></b> stupid or just asking too many questions?  21.7% lines contained a question!
<br /><span class="small"><b>SanSri</b> didn't know that much either.  17.5% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(1829); ?></b>, who yelled 42.9% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(1943); ?></b>, who shouted 40.3% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b><?php id(1219); ?></b>'s shift-key is hanging:  11.0% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[18:21] &lt;TLFVFTN&gt; F0D!!!!!!!!!!!!!!!!!!
</span><br />
<br /><span class="small"><b>Adian</b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 9.3% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> is a very aggressive person.  He/She attacked others <b>42</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[12:15] Action: `Conan kills Trevelyan
</span><br />
<br /><span class="small"><b><?php id(331); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>37</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(1198); ?></b>, nobody likes him/her.  He/She was attacked <b>35</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[04:52] Action: WalkerBoh smacks the line
</span><br />
<br /><span class="small"><b>conan</b> seems to be unliked too.  He/She got beaten <b>32</b> times.</span>
</td></tr>
<tr><td class="hicell"><b>Orphen</b> brings happiness to the world.  53.0% lines contained smiling faces.  :)
<br /><span class="small"><b><?php id(1908); ?></b> isn't a sad person either, smiling 47.1% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(16); ?></b> seems to be sad at the moment:  5.3% lines contained sad faces.  :(
<br /><span class="small"><b>Volo</b> is also a sad person, crying 1.4% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(94); ?></b> wrote the longest lines, averaging 49.9 letters per line.<br />
<span class="small">#bhg average was 27.2 letters per line.</span></td></tr>
<tr><td class="hicell"><b><?php id(2070); ?></b> wrote the shortest lines, averaging 10.9 characters per line.<br />
<span class="small"><b><?php id(1171); ?></b> was tight-lipped, too, averaging 13.6 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(747); ?></b> spoke a total of 46013 words!
<br /><span class="small"><?php id(747); ?>'s faithful follower, <b><?php id(331); ?></b>, didn't speak so much: 43585 words.</span>
</td></tr>
<tr><td class="hicell"><b>LegoMovie</b> wrote an average of 16.50 words per line.
<br /><span class="small">Channel average was 5.42 words per line.</span>
</td></tr>
</table>
   <br />
   <table width="730" cellpadding="1" cellspacing="0" border="0">
    <tr>
     <td class="headlinebg">
      <table width="100%" cellpadding="2" cellspacing="0" border="0">
       <tr>
        <td class="headtext">Most used words</td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
<table border="0" width="734"><tr>
<td>&nbsp;</td><td class="tdtop"><b>Word</b></td>
<td class="tdtop"><b>Number of Uses</b></td>
<td class="tdtop"><b>Last Used by</b></td></tr>
<tr><td class="hirankc">1</td>
<td class="hicell"><?php id(42); ?></td>
<td class="hicell">3458</td>
<td class="hicell"><?php id(1625); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell">about</td>
<td class="hicell">1532</td>
<td class="hicell"><?php id(242); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell">think</td>
<td class="hicell">1311</td>
<td class="hicell"><?php id(95); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell">there</td>
<td class="hicell">1231</td>
<td class="hicell"><?php id(242); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">people</td>
<td class="hicell">993</td>
<td class="hicell"><?php id(484); ?></td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">would</td>
<td class="hicell">914</td>
<td class="hicell"><?php id(95); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">really</td>
<td class="hicell">901</td>
<td class="hicell"><?php id(95); ?></td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">going</td>
<td class="hicell">849</td>
<td class="hicell"><?php id(1772); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">right</td>
<td class="hicell">820</td>
<td class="hicell"><?php id(57); ?></td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">licks</td>
<td class="hicell">815</td>
<td class="hicell"><?php id(1627); ?></td>
</tr>
</table>
   <br />
   <table width="730" cellpadding="1" cellspacing="0" border="0">
    <tr>
     <td class="headlinebg">
      <table width="100%" cellpadding="2" cellspacing="0" border="0">
       <tr>
        <td class="headtext">Most referenced nick</td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
<table border="0" width="734"><tr>
<td>&nbsp;</td><td class="tdtop"><b>Nick</b></td>
<td class="tdtop"><b>Number of Uses</b></td>
<td class="tdtop"><b>Last Used by</b></td></tr>
<tr><td class="hirankc">1</td>
<td class="hicell"><?php id(1198); ?></td>
<td class="hicell">37473</td>
<td class="hicell"><?php id(95); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(1085); ?></td>
<td class="hicell">19326</td>
<td class="hicell"><?php id(484); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(1281); ?></td>
<td class="hicell">3621</td>
<td class="hicell"><?php id(1247); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(331); ?></td>
<td class="hicell">2194</td>
<td class="hicell"><?php id(1908); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(1332); ?></td>
<td class="hicell">1972</td>
<td class="hicell"><?php id(747); ?></td>
</tr>
</table>
   <br />
   <table width="730" cellpadding="1" cellspacing="0" border="0">
    <tr>
     <td class="headlinebg">
      <table width="100%" cellpadding="2" cellspacing="0" border="0">
       <tr>
        <td class="headtext">Most referenced URLs</td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
<table border="0" width="734"><tr>
<td>&nbsp;</td><td class="tdtop"><b>URL</b></td>
<td class="tdtop"><b>Number of Uses</b></td>
<td class="tdtop"><b>Last Used by</b></td></tr>
<tr><td class="hirankc">1</td>
<td class="hicell"><a href="http://www...">http://www...</a></td>
<td class="hicell">25</td>
<td class="hicell"><?php id(747); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://www.thebhg.org">http://www.thebhg.org</a></td>
<td class="hicell">10</td>
<td class="hicell"><?php id(1247); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://holonet.thebhg.org/index.php?module=2&amp;page=quotes">http://holonet.thebhg.org/index.php?module=2&amp;page=quotes</a></td>
<td class="hicell">6</td>
<td class="hicell"><?php id(1699); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://beamsolutions.com/talra/music.html">http://beamsolutions.com/talra/music.html</a></td>
<td class="hicell">6</td>
<td class="hicell"><?php id(370); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://www.ehnet.org/sabacc/">http://www.ehnet.org/sabacc/</a></td>
<td class="hicell">5</td>
<td class="hicell">Necrolord</td>
</tr>
</table>
   <br />
   <table width="730" cellpadding="1" cellspacing="0" border="0">
    <tr>
     <td class="headlinebg">
      <table width="100%" cellpadding="2" cellspacing="0" border="0">
       <tr>
        <td class="headtext">Other interesting numbers</td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
<table width="734">

<tr><td class="hicell"><b><?php id(57); ?></b> wasn't very popular, getting kicked 20 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[15:36] Genno kicked from #bhg by Dalk:  Take that Averman ass of yours back across 8-mile :P
</span><br />
<br /><span class="small"><b><?php id(1247); ?></b> seemed to be hated too:  18 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> is either insane or just a fair op, kicking a total of 43 people!
<br /><span class="small">LawnGnome's faithful follower, <b><?php id(1625); ?></b>, kicked about 31 people.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> donated 46 ops in the channel...
<br /><span class="small"><b><?php id(1625); ?></b> was also very polite: 5 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(666); ?></b> is the channel sheriff with 5 deops.
<br /><span class="small"><b>LawnGnome</b> deoped 3 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(331); ?></b> always lets us know what he/she's doing: 1257 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[01:36] Action: `Lara licks Genny
</span><br />
<br /><span class="small">Also, <b><?php id(747); ?></b> tells us what's up with 1139 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(747); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 51 times!
<br /><span class="small">Another lonely one was <b><?php id(370); ?></b>, who managed to hit 31 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> couldn't decide whether to stay or go.  437 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>TheCap`n</b> has quite a potty mouth.  1.4% words were foul language.
<br /><span class="small"><b>digitMSTR</b> also makes sailors blush, 1.2% of the time.</span>
</td></tr>
</table>
   <br />
   <table width="730" cellpadding="1" cellspacing="0" border="0">
    <tr>
     <td class="headlinebg">
      <table width="100%" cellpadding="2" cellspacing="0" border="0">
       <tr>
        <td class="headtext">Latest Topics</td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
<table width="734">

<tr><td class="hicell"><i>ID Lines collate and send to the usual places</i></td>
<td class="hicell"><b>by <?php id(94); ?> on 11:06</b></td></tr>
<tr><td class="hicell"><i>Meeting Time</i></td>
<td class="hicell"><b>by <?php id(94); ?> on 11:00</b></td></tr>
<tr><td class="hicell"><i>(Genno) "Hey Sam, can I drive?" "Only if you don't mind me clawing at the dash and screaming like a cheerleader." "Is pronto a real word?"</i></td>
<td class="hicell"><b>by <?php id(45); ?> on 07:07</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 171 times.</td></tr>
</table>
Total number of lines: 132947.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 01 minutes and 03 seconds
</span>
</div>
</body>
</html>

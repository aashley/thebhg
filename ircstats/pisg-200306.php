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
Statistics generated on  Monday 18 August 2003 - 11:06:17
<br />During this 30-day reporting period, a total of <b>586</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">7.3%<br /><img src="./blue-v.png" width="15" height="100" alt="7.3" /></td>

<td align="center" valign="bottom" class="asmall">6.3%<br /><img src="./blue-v.png" width="15" height="86.2150220913108" alt="6.3" /></td>

<td align="center" valign="bottom" class="asmall">4.6%<br /><img src="./blue-v.png" width="15" height="63.6917034855179" alt="4.6" /></td>

<td align="center" valign="bottom" class="asmall">3.5%<br /><img src="./blue-v.png" width="15" height="48.8659793814433" alt="3.5" /></td>

<td align="center" valign="bottom" class="asmall">3.3%<br /><img src="./blue-v.png" width="15" height="45.7142857142857" alt="3.3" /></td>

<td align="center" valign="bottom" class="asmall">2.7%<br /><img src="./blue-v.png" width="15" height="37.1330387825233" alt="2.7" /></td>

<td align="center" valign="bottom" class="asmall">2.3%<br /><img src="./green-v.png" width="15" height="32.0765832106038" alt="2.3" /></td>

<td align="center" valign="bottom" class="asmall">2.0%<br /><img src="./green-v.png" width="15" height="28.3750613647521" alt="2.0" /></td>

<td align="center" valign="bottom" class="asmall">2.7%<br /><img src="./green-v.png" width="15" height="37.5552282768778" alt="2.7" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./green-v.png" width="15" height="42.9847815414826" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">3.7%<br /><img src="./green-v.png" width="15" height="51.0358370152185" alt="3.7" /></td>

<td align="center" valign="bottom" class="asmall">4.6%<br /><img src="./green-v.png" width="15" height="63.8684339715267" alt="4.6" /></td>

<td align="center" valign="bottom" class="asmall">5.2%<br /><img src="./yellow-v.png" width="15" height="71.9489445262641" alt="5.2" /></td>

<td align="center" valign="bottom" class="asmall">4.6%<br /><img src="./yellow-v.png" width="15" height="63.2596956308296" alt="4.6" /></td>

<td align="center" valign="bottom" class="asmall">4.4%<br /><img src="./yellow-v.png" width="15" height="60.1472754050074" alt="4.4" /></td>

<td align="center" valign="bottom" class="asmall">3.6%<br /><img src="./yellow-v.png" width="15" height="49.6416298478154" alt="3.6" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./yellow-v.png" width="15" height="43.1713303878252" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./yellow-v.png" width="15" height="42.8865979381443" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">2.9%<br /><img src="./red-v.png" width="15" height="40.9720176730486" alt="2.9" /></td>

<td align="center" valign="bottom" class="asmall">3.7%<br /><img src="./red-v.png" width="15" height="51.2125675012273" alt="3.7" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./red-v.png" width="15" height="57.5748649975454" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">4.3%<br /><img src="./red-v.png" width="15" height="59.6759941089838" alt="4.3" /></td>

<td align="center" valign="bottom" class="asmall">5.6%<br /><img src="./red-v.png" width="15" height="77.7810505645557" alt="5.6" /></td>

<td align="center" valign="bottom" class="asmall">7.3%<br /><img src="./red-v.png" width="15" height="99.8723613156603" alt="7.3" /></td>

</tr><tr>
<td class="hirankc10center" align="center">0</td>
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
<td class="rankc10center" align="center">11</td>
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
<td style="background-color: #babadc"><?php id(95); ?></td><td style="background-color: #babadc">8805</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #babadc">85817</td><td style="background-color: #babadc">9.7</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"hey there mr, that's called ban evasion or something :P"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(1551); ?></td><td style="background-color: #babadc">7278</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #babadc">44430</td><td style="background-color: #babadc">6.1</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Spiderman's girlfriend, Mary Jane..."</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(57); ?></td><td style="background-color: #babadc">7239</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #babadc">37879</td><td style="background-color: #babadc">5.2</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Keanu Reeves. you'd sex him up good"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(747); ?></td><td style="background-color: #babadc">6494</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #babadc">28866</td><td style="background-color: #babadc">4.4</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"well compared to you guys i am ... but for a girl, im normal :P"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(2029); ?></td><td style="background-color: #bbbbdb">4511</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="27" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #bbbbdb">28117</td><td style="background-color: #bbbbdb">6.2</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"and of course, that mofo leaves just as i'm getting here."</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(331); ?></td><td style="background-color: #bbbbdb">5960</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bbbbdb">25927</td><td style="background-color: #bbbbdb">4.4</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"Holo, is that why you're trying to get me to visit? ;P"</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(1754); ?></td><td style="background-color: #bbbbdb">3975</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bbbbdb">21037</td><td style="background-color: #bbbbdb">5.3</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"and on that note, i'm going to bed"</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(1247); ?></td><td style="background-color: #bbbbdb">3884</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #bbbbdb">19522</td><td style="background-color: #bbbbdb">5.0</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"&lt;aeris`&gt; ban conan? &lt;----Lets not"</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(1803); ?></td><td style="background-color: #bcbcda">3628</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="26" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #bcbcda">19433</td><td style="background-color: #bcbcda">5.4</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"and i just listend to it a few hours ago"</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(484); ?></td><td style="background-color: #bcbcda">3048</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #bcbcda">19240</td><td style="background-color: #bcbcda">6.3</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"you know the one... where the dead girl's head falls off :P"</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(168); ?></td><td style="background-color: #bcbcda">2113</td><td style="background-color: #bcbcda"><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #bcbcda">18517</td><td style="background-color: #bcbcda">8.8</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"1984 US accuse Iraq of using poison gas"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(1699); ?></td><td style="background-color: #bcbcda">3904</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #bcbcda">18233</td><td style="background-color: #bcbcda">4.7</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"ris, which one do you want?"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(666); ?></td><td style="background-color: #bdbdda">2042</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bdbdda">18137</td><td style="background-color: #bdbdda">8.9</td><td style="background-color: #bdbdda">Today</td><td style="background-color: #bdbdda">"obviously now fixed, since it works with firebird"</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9"><?php id(1197); ?></td><td style="background-color: #bdbdd9">3405</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #bdbdd9">16712</td><td style="background-color: #bdbdd9">4.9</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"I know, but I can still shank you in the face for it"</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(242); ?></td><td style="background-color: #bdbdd9">2475</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #bdbdd9">15847</td><td style="background-color: #bdbdd9">6.4</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"thanks for RPing with me last week, i had fun :P"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(1772); ?></td><td style="background-color: #bdbdd9">3128</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bdbdd9">13628</td><td style="background-color: #bdbdd9">4.4</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"I don't wanna deal with them asking 500 questions"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(2118); ?></td><td style="background-color: #bebed9">2288</td><td style="background-color: #bebed9"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="28" height="15" alt="" /></td><td style="background-color: #bebed9">12465</td><td style="background-color: #bebed9">5.4</td><td style="background-color: #bebed9">Today</td><td style="background-color: #bebed9">"or he wouldn't have stepped down"</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8"><?php id(135); ?></td><td style="background-color: #bebed8">1679</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #bebed8">11908</td><td style="background-color: #bebed8">7.1</td><td style="background-color: #bebed8">2 days ago</td><td style="background-color: #bebed8">"not my fault... I was kicked out! :P"</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(23); ?></td><td style="background-color: #bebed8">1511</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bebed8">11394</td><td style="background-color: #bebed8">7.5</td><td style="background-color: #bebed8">2 days ago</td><td style="background-color: #bebed8">"You live in Europe, Jude? Since when? Send me a french slave!"</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(14); ?></td><td style="background-color: #bebed8">1718</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="25" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #bebed8">11322</td><td style="background-color: #bebed8">6.6</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"That's how they can afford to campaign at all."</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8"><?php id(1187); ?></td><td style="background-color: #bfbfd8">1471</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bfbfd8">10984</td><td style="background-color: #bfbfd8">7.5</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"all the time. It keeps making me sneeze"</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(229); ?></td><td style="background-color: #bfbfd8">1233</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bfbfd8">9856</td><td style="background-color: #bfbfd8">8.0</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"Does bad shit with good intentions."</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7"><?php id(1264); ?></td><td style="background-color: #bfbfd7">1780</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #bfbfd7">9457</td><td style="background-color: #bfbfd7">5.3</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"and yet, I still got up at 10.30"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7"><?php id(16); ?></td><td style="background-color: #bfbfd7">1003</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bfbfd7">8846</td><td style="background-color: #bfbfd7">8.8</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"E"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(1356); ?></td><td style="background-color: #c0c0d7">1372</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="19" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c0c0d7">8611</td><td style="background-color: #c0c0d7">6.3</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"Kill the person who called about problems in life."</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(275); ?></td><td style="background-color: #c0c0d7">1085</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="24" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c0c0d7">7888</td><td style="background-color: #c0c0d7">7.3</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"thebhg.org isn't working, Fruity"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6">FruitCak</td><td style="background-color: #c0c0d6">886</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c0c0d6">7799</td><td style="background-color: #c0c0d6">8.8</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"bed? yes i lie on that and watch movies"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6"><?php id(370); ?></td><td style="background-color: #c0c0d6">1090</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c0c0d6">7177</td><td style="background-color: #c0c0d6">6.6</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"" But a horny Lara and aeris could.""</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(1583); ?></td><td style="background-color: #c0c0d6">1195</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c0c0d6">6452</td><td style="background-color: #c0c0d6">5.4</td><td style="background-color: #c0c0d6">5 days ago</td><td style="background-color: #c0c0d6">"behavorial health generations? :Þ"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6"><?php id(1908); ?></td><td style="background-color: #c1c1d6">1332</td><td style="background-color: #c1c1d6"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c1c1d6">5924</td><td style="background-color: #c1c1d6">4.4</td><td style="background-color: #c1c1d6">Today</td><td style="background-color: #c1c1d6">"you outbidded me, at the last minute &gt;:P"</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5"><?php id(1843); ?></td><td style="background-color: #c1c1d5">1477</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="20" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c1c1d5">5888</td><td style="background-color: #c1c1d5">4.0</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"usually gets through to them"</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5">Tnsumi</td><td style="background-color: #c1c1d5">826</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c1c1d5">5220</td><td style="background-color: #c1c1d5">6.3</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"anyways, I have to head out"</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5"><?php id(94); ?></td><td style="background-color: #c1c1d5">526</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c1c1d5">4703</td><td style="background-color: #c1c1d5">8.9</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"the new compaqs are quite nice"</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5">`Motti`</td><td style="background-color: #c2c2d5">681</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c2c2d5">4659</td><td style="background-color: #c2c2d5">6.8</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"you literally couldn't lose to him :P"</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5"><?php id(473); ?></td><td style="background-color: #c2c2d5">823</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c2c2d5">4508</td><td style="background-color: #c2c2d5">5.5</td><td style="background-color: #c2c2d5">3 days ago</td><td style="background-color: #c2c2d5">"When I see "Chapter I", I get ready to break out the red pen."</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(1198); ?></td><td style="background-color: #c2c2d4">828</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c2c2d4">4037</td><td style="background-color: #c2c2d4">4.9</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"at least you have Blue Man.  Have you heard there new album?"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4"><?php id(1103); ?></td><td style="background-color: #c2c2d4">522</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c2c2d4">3576</td><td style="background-color: #c2c2d4">6.9</td><td style="background-color: #c2c2d4">1 day ago</td><td style="background-color: #c2c2d4">"*retaliates for no good reason*"</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4">FruitCak_</td><td style="background-color: #c3c3d4">421</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="26" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c3c3d4">3429</td><td style="background-color: #c3c3d4">8.1</td><td style="background-color: #c3c3d4">11 days ago</td><td style="background-color: #c3c3d4">"fury you deserve the ban completly"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(1219); ?></td><td style="background-color: #c3c3d4">773</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="30" height="15" alt="" /></td><td style="background-color: #c3c3d4">3356</td><td style="background-color: #c3c3d4">4.3</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"it's cause of SS|Food as a common nick"</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3"><?php id(1700); ?></td><td style="background-color: #c3c3d3">744</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c3c3d3">2815</td><td style="background-color: #c3c3d3">3.8</td><td style="background-color: #c3c3d3">5 days ago</td><td style="background-color: #c3c3d3">"Pala hasn't beem around for a long time"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3"><?php id(1625); ?></td><td style="background-color: #c3c3d3">425</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="22" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c3c3d3">2585</td><td style="background-color: #c3c3d3">6.1</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"And Skor, it's almost 4 where he is, I'd guess he's in bed  :P"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3"><?php id(152); ?></td><td style="background-color: #c4c4d3">290</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c4c4d3">2582</td><td style="background-color: #c4c4d3">8.9</td><td style="background-color: #c4c4d3">1 day ago</td><td style="background-color: #c4c4d3">"But it was a military operation, at least."</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3"><?php id(141); ?></td><td style="background-color: #c4c4d3">498</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c4c4d3">2450</td><td style="background-color: #c4c4d3">4.9</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"it'sthe prime retirement grounds of the finest of the EH :P"</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(45); ?></td><td style="background-color: #c4c4d3">351</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c4c4d3">2427</td><td style="background-color: #c4c4d3">6.9</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"just one very special letter..."</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2">peer-gone</td><td style="background-color: #c4c4d2">289</td><td style="background-color: #c4c4d2"><img src="./blue-h.png" border="0" width="27" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c4c4d2">2228</td><td style="background-color: #c4c4d2">7.7</td><td style="background-color: #c4c4d2">5 days ago</td><td style="background-color: #c4c4d2">"They'll mistake you for one of their own"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2"><?php id(1135); ?></td><td style="background-color: #c5c5d2">299</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c5c5d2">2187</td><td style="background-color: #c5c5d2">7.3</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"I was more concerned with Fallout 3 coming out (if ever)..."</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2">SanSri</td><td style="background-color: #c5c5d2">360</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c5c5d2">2112</td><td style="background-color: #c5c5d2">5.9</td><td style="background-color: #c5c5d2">3 days ago</td><td style="background-color: #c5c5d2">"One day I'll walk up to you door and speak in a french accent"</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2"><?php id(1943); ?></td><td style="background-color: #c5c5d2">500</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c5c5d2">1717</td><td style="background-color: #c5c5d2">3.4</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"that would be cool, I would love to see a weekly gfx comp"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1">Korbane</td><td style="background-color: #c5c5d1">217</td><td style="background-color: #c5c5d1"><img src="./blue-h.png" border="0" width="37" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c5c5d1">1652</td><td style="background-color: #c5c5d1">7.6</td><td style="background-color: #c5c5d1">4 days ago</td><td style="background-color: #c5c5d1">"Hey you are in the same Timezone as me"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1">^SyNthPHP</td><td style="background-color: #c6c6d1">336</td><td style="background-color: #c6c6d1"><img src="./green-h.png" border="0" width="24" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c6c6d1">1572</td><td style="background-color: #c6c6d1">4.7</td><td style="background-color: #c6c6d1">3 days ago</td><td style="background-color: #c6c6d1">"like i said, it doesn't really exit"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1">^Xan</td><td style="background-color: #c6c6d1">252</td><td style="background-color: #c6c6d1"><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c6c6d1">1515</td><td style="background-color: #c6c6d1">6.0</td><td style="background-color: #c6c6d1">7 days ago</td><td style="background-color: #c6c6d1">"the fountain of infinite knowledge"</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1"><?php id(2006); ?></td><td style="background-color: #c6c6d1">319</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c6c6d1">1491</td><td style="background-color: #c6c6d1">4.7</td><td style="background-color: #c6c6d1">2 days ago</td><td style="background-color: #c6c6d1">"Because we're glad to see each other...or something..."</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0">Teachdair</td><td style="background-color: #c6c6d0">180</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="30" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c6c6d0">1470</td><td style="background-color: #c6c6d0">8.2</td><td style="background-color: #c6c6d0">7 days ago</td><td style="background-color: #c6c6d0">"I have had alot of negative thoughts about it from momst people"</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0">Talon-9</td><td style="background-color: #c6c6d0">363</td><td style="background-color: #c6c6d0"><img src="./green-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c6c6d0">1407</td><td style="background-color: #c6c6d0">3.9</td><td style="background-color: #c6c6d0">11 days ago</td><td style="background-color: #c6c6d0">"I just got back from holiday"</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0">Mal|away</td><td style="background-color: #c7c7d0">293</td><td style="background-color: #c7c7d0"><img src="./green-h.png" border="0" width="22" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c7c7d0">1347</td><td style="background-color: #c7c7d0">4.6</td><td style="background-color: #c7c7d0">5 days ago</td><td style="background-color: #c7c7d0">"<a href="http://www.raceworx.com/funnypics/you" target="_blank" title="Open in new window: http://www.raceworx.com/funnypics/you">http://www.raceworx.com/funnypics/you</a>'reahomo.jpg"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0">^Ice</td><td style="background-color: #c7c7d0">255</td><td style="background-color: #c7c7d0"><img src="./green-h.png" border="0" width="25" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c7c7d0">1325</td><td style="background-color: #c7c7d0">5.2</td><td style="background-color: #c7c7d0">2 days ago</td><td style="background-color: #c7c7d0">"i finished downloading microsoft word"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0"><?php id(1171); ?></td><td style="background-color: #c7c7d0">404</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c7c7d0">1301</td><td style="background-color: #c7c7d0">3.2</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"oi, only one more day of finals :)"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf"><?php id(1281); ?></td><td style="background-color: #c7c7cf">222</td><td style="background-color: #c7c7cf"><img src="./blue-h.png" border="0" width="30" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c7c7cf">1271</td><td style="background-color: #c7c7cf">5.7</td><td style="background-color: #c7c7cf">Today</td><td style="background-color: #c7c7cf">"just have to find the dang video"</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf"><?php id(300); ?></td><td style="background-color: #c8c8cf">171</td><td style="background-color: #c8c8cf"><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #c8c8cf">1267</td><td style="background-color: #c8c8cf">7.4</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"Krail is Old-As-Dirt-School :P"</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf">`peer</td><td style="background-color: #c8c8cf">171</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="19" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c8c8cf">1261</td><td style="background-color: #c8c8cf">7.4</td><td style="background-color: #c8c8cf">3 days ago</td><td style="background-color: #c8c8cf">"...I feel like I've died and been reincarnated into Mallrats"</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf"><?php id(1873); ?></td><td style="background-color: #c8c8cf">207</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c8c8cf">1242</td><td style="background-color: #c8c8cf">6.0</td><td style="background-color: #c8c8cf">19 days ago</td><td style="background-color: #c8c8cf">"it said what they do together in the bedroom"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce"><?php id(182); ?></td><td style="background-color: #c8c8ce">219</td><td style="background-color: #c8c8ce"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="37" height="15" alt="" /></td><td style="background-color: #c8c8ce">1212</td><td style="background-color: #c8c8ce">5.5</td><td style="background-color: #c8c8ce">1 day ago</td><td style="background-color: #c8c8ce">"Shocks kicked more arse in the comics"</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce">Prospero</td><td style="background-color: #c9c9ce">183</td><td style="background-color: #c9c9ce"><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c9c9ce">1174</td><td style="background-color: #c9c9ce">6.4</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"dont kill kylie minogue, shes hot"</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce">radikta</td><td style="background-color: #c9c9ce">242</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c9c9ce">1144</td><td style="background-color: #c9c9ce">4.7</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"wouldve been funnier if slice had kicked him..."</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce"><?php id(175); ?></td><td style="background-color: #c9c9ce">140</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c9c9ce">1127</td><td style="background-color: #c9c9ce">8.1</td><td style="background-color: #c9c9ce">13 days ago</td><td style="background-color: #c9c9ce">"and I don't trust Utah.  They're up to something"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce"><?php id(2131); ?></td><td style="background-color: #c9c9ce">238</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c9c9ce">1116</td><td style="background-color: #c9c9ce">4.7</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"what? jewish? yiddish?"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd">Naihtyx</td><td style="background-color: #cacacd">243</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #cacacd">1084</td><td style="background-color: #cacacd">4.5</td><td style="background-color: #cacacd">13 days ago</td><td style="background-color: #cacacd">".hack is good, but it'd be better if they sold the ENTIRE game."</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd">Eriatarka</td><td style="background-color: #cacacd">277</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="30" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #cacacd">1059</td><td style="background-color: #cacacd">3.8</td><td style="background-color: #cacacd">17 days ago</td><td style="background-color: #cacacd">"TRY me, you'll never go back."</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd">Dewulf</td><td style="background-color: #cacacd">131</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="30" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #cacacd">1022</td><td style="background-color: #cacacd">7.8</td><td style="background-color: #cacacd">5 days ago</td><td style="background-color: #cacacd">"She wouldn't though, it wasn't much."</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd"><?php id(1064); ?></td><td style="background-color: #cacacd">141</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="31" height="15" alt="" /></td><td style="background-color: #cacacd">1001</td><td style="background-color: #cacacd">7.1</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"territories aren't states in any way shape or form."</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc"><?php id(1717); ?></td><td style="background-color: #cbcbcc">251</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="29" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #cbcbcc">993</td><td style="background-color: #cbcbcc">4.0</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"sick is her just throwing up normally on a roller coaster"</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc">Rana</td><td style="background-color: #cbcbcc">220</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="33" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #cbcbcc">980</td><td style="background-color: #cbcbcc">4.5</td><td style="background-color: #cbcbcc">6 days ago</td><td style="background-color: #cbcbcc">"and I'm sure I could use a ship"</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc"><?php id(366); ?></td><td style="background-color: #cbcbcc">110</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #cbcbcc">974</td><td style="background-color: #cbcbcc">8.9</td><td style="background-color: #cbcbcc">18 days ago</td><td style="background-color: #cbcbcc">"Get going you. Catch you later, Deus."</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc">Volcanus</td><td style="background-color: #cbcbcc">248</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="26" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #cbcbcc">955</td><td style="background-color: #cbcbcc">3.9</td><td style="background-color: #cbcbcc">13 days ago</td><td style="background-color: #cbcbcc">"Skor is only flattery so no diff"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc">Slowie</td><td style="background-color: #cccccc">291</td><td style="background-color: #cccccc"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #cccccc">896</td><td style="background-color: #cccccc">3.1</td><td style="background-color: #cccccc">Today</td><td style="background-color: #cccccc">"it was fun but i need to go"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10"><?php id(1085); ?> (876)</td>
<td class="rankc10">`Nat (805)</td>
<td class="rankc10">Fyre (799)</td>
<td class="rankc10">DrunKrail (789)</td>
<td class="rankc10">Prosperos (764)</td>
</tr><tr>
<td class="rankc10">ThatMan (762)</td>
<td class="rankc10">^Phantom (739)</td>
<td class="rankc10">Necrolord (728)</td>
<td class="rankc10">`Xar (715)</td>
<td class="rankc10"><?php id(1594); ?> (697)</td>
</tr><tr>
<td class="rankc10">Xar_ (675)</td>
<td class="rankc10">SyNthBUSY (661)</td>
<td class="rankc10">_Balt (624)</td>
<td class="rankc10">peer-AFK (623)</td>
<td class="rankc10">Xar` (616)</td>
</tr><tr>
<td class="rankc10"><?php id(1627); ?> (612)</td>
<td class="rankc10"><?php id(374); ?> (576)</td>
<td class="rankc10">Felger (535)</td>
<td class="rankc10"><?php id(488); ?> (533)</td>
<td class="rankc10">Slag|UO (527)</td>
</tr><tr>
<td class="rankc10">Ender`` (527)</td>
<td class="rankc10">BlackHole (525)</td>
<td class="rankc10"><?php id(495); ?> (499)</td>
<td class="rankc10">Balt_ (498)</td>
<td class="rankc10">`Dagger (496)</td>
</tr><tr>
<td class="rankc10"><?php id(1798); ?> (492)</td>
<td class="rankc10">^Fyre (489)</td>
<td class="rankc10">Damn`BT (488)</td>
<td class="rankc10">`Mav` (479)</td>
<td class="rankc10">Arcangel (471)</td>
</tr><tr>
<td class="rankc10">DS|Arena (470)</td>
<td class="rankc10">outcasted (459)</td>
<td class="rankc10">basilisk (441)</td>
<td class="rankc10">skor-dev (441)</td>
<td class="rankc10">Pikaboo (437)</td>
</tr><tr>
<td class="rankc10">Re (436)</td>
<td class="rankc10">Branman (415)</td>
<td class="rankc10">nightwe-E (413)</td>
<td class="rankc10">deathw (398)</td>
<td class="rankc10">GenOberst (387)</td>
</tr></table>
<br /><b>By the way, there were 469 other nicks.</b><br />
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

<tr><td class="hicell">Is <b>Dewulf</b> stupid or just asking too many questions?  37.4% lines contained a question!
<br /><span class="small"><b>Necrolord</b> didn't know that much either.  28.1% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(488); ?></b>, who yelled 58.8% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(1943); ?></b>, who shouted 43.6% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b><?php id(1717); ?></b>'s shift-key is hanging:  14.3% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[04:34] &lt;`Sen&gt; CHRON!
</span><br />
<br /><span class="small"><b><?php id(1219); ?></b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 9.5% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1551); ?></b> is a very aggressive person.  He/She attacked others <b>43</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[23:12] Action: Chronas slaps Detori
</span><br />
<br /><span class="small"><b><?php id(57); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>41</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(57); ?></b>, nobody likes him/her.  He/She was attacked <b>27</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[08:47] Action: `Nat-RO thwaps Gen
</span><br />
<br /><span class="small"><b><?php id(1218); ?></b> seems to be unliked too.  He/She got beaten <b>22</b> times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1908); ?></b> brings happiness to the world.  51.2% lines contained smiling faces.  :)
<br /><span class="small"><b><?php id(1700); ?></b> isn't a sad person either, smiling 45.9% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(16); ?></b> seems to be sad at the moment:  4.1% lines contained sad faces.  :(
<br /><span class="small"><b>Xar`</b> is also a sad person, crying 3.1% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(95); ?></b> wrote the longest lines, averaging 48.2 letters per line.<br />
<span class="small">#bhg average was 30.0 letters per line.</span></td></tr>
<tr><td class="hicell"><b>Balt_</b> wrote the shortest lines, averaging 11.8 characters per line.<br />
<span class="small"><b>Slowie</b> was tight-lipped, too, averaging 14.4 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(95); ?></b> spoke a total of 85817 words!
<br /><span class="small"><?php id(95); ?>'s faithful follower, <b><?php id(1551); ?></b>, didn't speak so much: 44430 words.</span>
</td></tr>
<tr><td class="hicell"><b>`Thrawn`</b> wrote an average of 25.50 words per line.
<br /><span class="small">Channel average was 5.95 words per line.</span>
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
<td class="hicell"><?php id(1218); ?></td>
<td class="hicell">20861</td>
<td class="hicell"><?php id(1356); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(1332); ?></td>
<td class="hicell">2805</td>
<td class="hicell">DrunKrail</td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(42); ?></td>
<td class="hicell">2770</td>
<td class="hicell"><?php id(229); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell">about</td>
<td class="hicell">1818</td>
<td class="hicell"><?php id(95); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">think</td>
<td class="hicell">1766</td>
<td class="hicell"><?php id(95); ?></td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">there</td>
<td class="hicell">1520</td>
<td class="hicell"><?php id(95); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">people</td>
<td class="hicell">1330</td>
<td class="hicell"><?php id(1187); ?></td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">would</td>
<td class="hicell">1154</td>
<td class="hicell"><?php id(95); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">right</td>
<td class="hicell">995</td>
<td class="hicell"><?php id(1772); ?></td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">really</td>
<td class="hicell">979</td>
<td class="hicell"><?php id(95); ?></td>
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
<td class="hicell"><?php id(1085); ?></td>
<td class="hicell">23066</td>
<td class="hicell"><?php id(1908); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(1281); ?></td>
<td class="hicell">3919</td>
<td class="hicell"><?php id(1219); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(300); ?></td>
<td class="hicell">2656</td>
<td class="hicell"><?php id(1754); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(57); ?></td>
<td class="hicell">1685</td>
<td class="hicell"><?php id(14); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(95); ?></td>
<td class="hicell">1650</td>
<td class="hicell"><?php id(1772); ?></td>
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
<td class="hicell">12</td>
<td class="hicell"><?php id(331); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://specialist.thebhg.org/gallery/crikey.wav">http://specialist.thebhg.org/gallery/crikey.wav</a></td>
<td class="hicell">6</td>
<td class="hicell">skor-dev</td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://lawngnome.cernun.net/hara/cs.mp3">http://lawngnome.cernun.net/hara/cs.mp3</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(1171); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://boards.thebhg.org/index.php?op=view&amp;topic=5270">http://boards.thebhg.org/index.php?op=view&amp;topic=5270</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(2029); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://www....">http://www....</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(95); ?></td>
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

<tr><td class="hicell"><b><?php id(1551); ?></b> wasn't very popular, getting kicked 18 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[06:48] Chronas kicked from #bhg by LawnGnome: Everybody Wang Chung tonight! I said to watch your language! [Warning 2 of 2]
</span><br />
<br /><span class="small"><b><?php id(1803); ?></b> seemed to be hated too:  17 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> is either insane or just a fair op, kicking a total of 63 people!
<br /><span class="small">LawnGnome's faithful follower, <b><?php id(1699); ?></b>, kicked about 16 people.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> donated 37 ops in the channel...
<br /><span class="small"><b><?php id(1197); ?></b> was also very polite: 14 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1197); ?></b> is the channel sheriff with 2 deops.
<br /><span class="small"><b><?php id(275); ?></b> deoped 2 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(57); ?></b> always lets us know what he/she's doing: 1169 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[20:36] Action: Walldawg i ssupose the doggy
</span><br />
<br /><span class="small">Also, <b><?php id(747); ?></b> tells us what's up with 713 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1551); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 39 times!
<br /><span class="small">Another lonely one was <b><?php id(747); ?></b>, who managed to hit 35 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1264); ?></b> couldn't decide whether to stay or go.  858 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>Sailor_M</b> has quite a potty mouth.  3.5% words were foul language.
<br /><span class="small"><b>Grav|gfx</b> also makes sailors blush, 1.9% of the time.</span>
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

<tr><td class="hicell"><i>DS gets the ME and HM! Muahaahaa! || Dalk officially back from the funny farm. ||RO Graded, results posted! See y'all later! ~DS</i></td>
<td class="hicell"><b>by <?php id(1197); ?> on 22:00</b></td></tr>
<tr><td class="hicell"><i>DS gets the ME and HM! Muahaahaa! || Dalk officially back from the funny farm. ||RO Graded, will post results tonight!</i></td>
<td class="hicell"><b>by LawnGnome on 14:57</b></td></tr>
<tr><td class="hicell"><i> DS gets the ME and HM! Muahaahaa! || Dalk officially back from the farm||RO Graded, will post results tonight! </i></td>
<td class="hicell"><b>by <?php id(1197); ?> on 13:53</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 181 times.</td></tr>
</table>
Total number of lines: 139115.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 01 minutes and 20 seconds
</span>
</div>
</body>
</html>

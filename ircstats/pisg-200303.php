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
Statistics generated on  Tuesday 1 April 2003 - 22:08:32
<br />During this 31-day reporting period, a total of <b>579</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">5.5%<br /><img src="./blue-v.png" width="15" height="92.3237670660351" alt="5.5" /></td>

<td align="center" valign="bottom" class="asmall">5.9%<br /><img src="./blue-v.png" width="15" height="100" alt="5.9" /></td>

<td align="center" valign="bottom" class="asmall">4.3%<br /><img src="./blue-v.png" width="15" height="72.5968236277515" alt="4.3" /></td>

<td align="center" valign="bottom" class="asmall">3.5%<br /><img src="./blue-v.png" width="15" height="58.6653663973252" alt="3.5" /></td>

<td align="center" valign="bottom" class="asmall">2.5%<br /><img src="./blue-v.png" width="15" height="42.059069378657" alt="2.5" /></td>

<td align="center" valign="bottom" class="asmall">2.3%<br /><img src="./blue-v.png" width="15" height="39.2309835608805" alt="2.3" /></td>

<td align="center" valign="bottom" class="asmall">2.6%<br /><img src="./green-v.png" width="15" height="44.7757035385901" alt="2.6" /></td>

<td align="center" valign="bottom" class="asmall">2.3%<br /><img src="./green-v.png" width="15" height="39.1334633602675" alt="2.3" /></td>

<td align="center" valign="bottom" class="asmall">2.5%<br /><img src="./green-v.png" width="15" height="43.0342713847868" alt="2.5" /></td>

<td align="center" valign="bottom" class="asmall">2.1%<br /><img src="./green-v.png" width="15" height="36.3193089997214" alt="2.1" /></td>

<td align="center" valign="bottom" class="asmall">2.4%<br /><img src="./green-v.png" width="15" height="41.1395932014489" alt="2.4" /></td>

<td align="center" valign="bottom" class="asmall">3.5%<br /><img src="./green-v.png" width="15" height="60.1838952354416" alt="3.5" /></td>

<td align="center" valign="bottom" class="asmall">3.6%<br /><img src="./yellow-v.png" width="15" height="60.7272220674283" alt="3.6" /></td>

<td align="center" valign="bottom" class="asmall">3.7%<br /><img src="./yellow-v.png" width="15" height="62.1760936193926" alt="3.7" /></td>

<td align="center" valign="bottom" class="asmall">4.1%<br /><img src="./yellow-v.png" width="15" height="69.5458344942881" alt="4.1" /></td>

<td align="center" valign="bottom" class="asmall">5.8%<br /><img src="./yellow-v.png" width="15" height="98.2167734745054" alt="5.8" /></td>

<td align="center" valign="bottom" class="asmall">5.8%<br /><img src="./yellow-v.png" width="15" height="98.0495959877403" alt="5.8" /></td>

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./yellow-v.png" width="15" height="82.7807188631931" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./red-v.png" width="15" height="70.5210365004179" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">4.6%<br /><img src="./red-v.png" width="15" height="78.0440234048481" alt="4.6" /></td>

<td align="center" valign="bottom" class="asmall">4.8%<br /><img src="./red-v.png" width="15" height="81.5408191696852" alt="4.8" /></td>

<td align="center" valign="bottom" class="asmall">5.6%<br /><img src="./red-v.png" width="15" height="94.9568124825857" alt="5.6" /></td>

<td align="center" valign="bottom" class="asmall">5.7%<br /><img src="./red-v.png" width="15" height="96.9072164948454" alt="5.7" /></td>

<td align="center" valign="bottom" class="asmall">5.8%<br /><img src="./red-v.png" width="15" height="97.1301198105322" alt="5.8" /></td>

</tr><tr>
<td class="rankc10center" align="center">0</td>
<td class="hirankc10center" align="center">1</td>
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
<td style="background-color: #babadc">`Holo</td><td style="background-color: #babadc">4391</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="27" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #babadc">26653</td><td style="background-color: #babadc">6.1</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"c0r, what, a late-series one that didn't suck?"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(1247); ?></td><td style="background-color: #babadc">5147</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #babadc">25917</td><td style="background-color: #babadc">5.0</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Found some things that dont work for my writing style"</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(57); ?></td><td style="background-color: #babadc">3516</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #babadc">24681</td><td style="background-color: #babadc">7.0</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"well i kinda meant in the arena :P"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(331); ?></td><td style="background-color: #babadc">5740</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #babadc">24674</td><td style="background-color: #babadc">4.3</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"beds are not meant to be used as storage space"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(1551); ?></td><td style="background-color: #bbbbdb">3263</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="19" height="15" alt="" /><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #bbbbdb">20094</td><td style="background-color: #bbbbdb">6.2</td><td style="background-color: #bbbbdb">1 day ago</td><td style="background-color: #bbbbdb">"Or during the weekdays, huh?"</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(118); ?></td><td style="background-color: #bbbbdb">2174</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bbbbdb">18785</td><td style="background-color: #bbbbdb">8.6</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"Something along those lines, Furjon."</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(494); ?></td><td style="background-color: #bbbbdb">3455</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #bbbbdb">17639</td><td style="background-color: #bbbbdb">5.1</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"I wanna top of technology, then put some in knowledge."</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(1754); ?></td><td style="background-color: #bbbbdb">2916</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #bbbbdb">15900</td><td style="background-color: #bbbbdb">5.5</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"Old Dirty Bastard - Picky in Bed"</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(1187); ?></td><td style="background-color: #bcbcda">2131</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bcbcda">15690</td><td style="background-color: #bcbcda">7.4</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"The Nazi advance stops because I will it so"</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(135); ?></td><td style="background-color: #bcbcda">1890</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #bcbcda">14708</td><td style="background-color: #bcbcda">7.8</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"I want a pic of you Tuss... possible holding a pie..."</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(666); ?></td><td style="background-color: #bcbcda">1458</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #bcbcda">13122</td><td style="background-color: #bcbcda">9.0</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"`Conan: so it looks more like mr hankey"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(168); ?></td><td style="background-color: #bcbcda">1281</td><td style="background-color: #bcbcda"><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bcbcda">12716</td><td style="background-color: #bcbcda">9.9</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"Nah, Bloder's not good enough for his own DVD&gt;"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(16); ?></td><td style="background-color: #bdbdda">1204</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bdbdda">11427</td><td style="background-color: #bdbdda">9.5</td><td style="background-color: #bdbdda">Today</td><td style="background-color: #bdbdda">"fine! I'll use tranq darts instead of poison! ;P"</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9"><?php id(95); ?></td><td style="background-color: #bdbdd9">1512</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bdbdd9">10906</td><td style="background-color: #bdbdd9">7.2</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"um...i dont think i really want to know..."</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(1625); ?></td><td style="background-color: #bdbdd9">1565</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #bdbdd9">10143</td><td style="background-color: #bdbdd9">6.5</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"Umm... I thought it was because I won the Auction from Synth  :P"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9">^SyNth</td><td style="background-color: #bdbdd9">2412</td><td style="background-color: #bdbdd9"><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bdbdd9">10014</td><td style="background-color: #bdbdd9">4.2</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"i'm bored enough to go check :P"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(229); ?></td><td style="background-color: #bebed9">1164</td><td style="background-color: #bebed9"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #bebed9">9505</td><td style="background-color: #bebed9">8.2</td><td style="background-color: #bebed9">Today</td><td style="background-color: #bebed9">"MARL: Two weeks till a Tempy RO."</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8"><?php id(484); ?></td><td style="background-color: #bebed8">1710</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #bebed8">9363</td><td style="background-color: #bebed8">5.5</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"watch the simpsons in half an hour :P"</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8">Xar_</td><td style="background-color: #bebed8">1611</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="25" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #bebed8">8327</td><td style="background-color: #bebed8">5.2</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"but the music is all edited and the like"</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(473); ?></td><td style="background-color: #bebed8">2009</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #bebed8">8046</td><td style="background-color: #bebed8">4.0</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"Slicer's estate: "Jer shrugs""</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8"><?php id(1699); ?></td><td style="background-color: #bfbfd8">1169</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="30" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #bfbfd8">6497</td><td style="background-color: #bfbfd8">5.6</td><td style="background-color: #bfbfd8">2 days ago</td><td style="background-color: #bfbfd8">"no probs, happy to oblige :P"</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(1829); ?></td><td style="background-color: #bfbfd8">1902</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bfbfd8">6412</td><td style="background-color: #bfbfd8">3.4</td><td style="background-color: #bfbfd8">1 day ago</td><td style="background-color: #bfbfd8">"and since I run theRP now, i can ;)"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7">Reap</td><td style="background-color: #bfbfd7">1356</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bfbfd7">6063</td><td style="background-color: #bfbfd7">4.5</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"that could explain why his ping wasn't showing up :P"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7">FruitCak</td><td style="background-color: #bfbfd7">660</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bfbfd7">6060</td><td style="background-color: #bfbfd7">9.2</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"that will be discussed with the rest of the commission"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(11); ?></td><td style="background-color: #c0c0d7">775</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c0c0d7">5545</td><td style="background-color: #c0c0d7">7.2</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"the people that worked on the DB database need to be flayed"</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(1281); ?></td><td style="background-color: #c0c0d7">982</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="22" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c0c0d7">5543</td><td style="background-color: #c0c0d7">5.6</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"be back in awhile, goin to go get some food/"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6"><?php id(2118); ?></td><td style="background-color: #c0c0d6">884</td><td style="background-color: #c0c0d6"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="34" height="15" alt="" /></td><td style="background-color: #c0c0d6">5332</td><td style="background-color: #c0c0d6">6.0</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"or we could all be Xythian and complain till our ears bleed"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6"><?php id(1583); ?></td><td style="background-color: #c0c0d6">877</td><td style="background-color: #c0c0d6"><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c0c0d6">5321</td><td style="background-color: #c0c0d6">6.1</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"run around naked and see if that helps"</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(1413); ?></td><td style="background-color: #c0c0d6">982</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="29" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c0c0d6">5210</td><td style="background-color: #c0c0d6">5.3</td><td style="background-color: #c0c0d6">7 days ago</td><td style="background-color: #c0c0d6">"I'll stay as protoplasm if you wouldn't mind. ;)"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6">`MK</td><td style="background-color: #c1c1d6">998</td><td style="background-color: #c1c1d6"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c1c1d6">5191</td><td style="background-color: #c1c1d6">5.2</td><td style="background-color: #c1c1d6">Today</td><td style="background-color: #c1c1d6">"warm snow, i'd love to see the day"</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5"><?php id(94); ?></td><td style="background-color: #c1c1d5">550</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="22" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c1c1d5">5187</td><td style="background-color: #c1c1d5">9.4</td><td style="background-color: #c1c1d5">1 day ago</td><td style="background-color: #c1c1d5">"lisa macuine is using the word spanking a lot"</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5"><?php id(23); ?></td><td style="background-color: #c1c1d5">813</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="20" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c1c1d5">5180</td><td style="background-color: #c1c1d5">6.4</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"thats' a dirty lie Strander"</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5"><?php id(1332); ?></td><td style="background-color: #c1c1d5">1347</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c1c1d5">4940</td><td style="background-color: #c1c1d5">3.7</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"it's not like it's rocket science"</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5">^Fyre</td><td style="background-color: #c2c2d5">647</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c2c2d5">4748</td><td style="background-color: #c2c2d5">7.3</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"Really? So I'm only geting credits for one of my nicks?"</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5">Adian</td><td style="background-color: #c2c2d5">882</td><td style="background-color: #c2c2d5"><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c2c2d5">4669</td><td style="background-color: #c2c2d5">5.3</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"my LWF partner was a human speaking hutt?"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(1085); ?></td><td style="background-color: #c2c2d4">1078</td><td style="background-color: #c2c2d4"><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c2c2d4">4603</td><td style="background-color: #c2c2d4">4.3</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"It goes 100-200-500-1000-2000-4000-8000-1up, too. &gt;:P"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4">Furjon</td><td style="background-color: #c2c2d4">1190</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c2c2d4">4567</td><td style="background-color: #c2c2d4">3.8</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"have you ever seen a show named Freakazoid?"</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4"><?php id(242); ?></td><td style="background-color: #c3c3d4">688</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c3c3d4">4522</td><td style="background-color: #c3c3d4">6.6</td><td style="background-color: #c3c3d4">4 days ago</td><td style="background-color: #c3c3d4">"Lara what is your ring size! :P"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(1594); ?></td><td style="background-color: #c3c3d4">1217</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c3c3d4">4124</td><td style="background-color: #c3c3d4">3.4</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"sure he is...i'd be bitching too :P"</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3"><?php id(1843); ?></td><td style="background-color: #c3c3d3">976</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c3c3d3">3961</td><td style="background-color: #c3c3d3">4.1</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"yeah you can, you just can't post"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3"><?php id(747); ?></td><td style="background-color: #c3c3d3">1012</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c3c3d3">3885</td><td style="background-color: #c3c3d3">3.8</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"er... yeah. "retired", actually. ;P"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3">FruitCak_</td><td style="background-color: #c4c4d3">457</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c4c4d3">3730</td><td style="background-color: #c4c4d3">8.2</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"have you got the new ep down?"</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3">Goomba`</td><td style="background-color: #c4c4d3">491</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c4c4d3">3465</td><td style="background-color: #c4c4d3">7.1</td><td style="background-color: #c4c4d3">2 days ago</td><td style="background-color: #c4c4d3">"like the guy that blew up a tent cause he didnt like the guy "</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(370); ?></td><td style="background-color: #c4c4d3">520</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c4c4d3">3317</td><td style="background-color: #c4c4d3">6.4</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"bleh the PHP5 slideshow is borked"</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2">JackRippd</td><td style="background-color: #c4c4d2">649</td><td style="background-color: #c4c4d2"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c4c4d2">3185</td><td style="background-color: #c4c4d2">4.9</td><td style="background-color: #c4c4d2">3 days ago</td><td style="background-color: #c4c4d2">"i just paused Bring it on, and this chick looks so constipated!"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2"><?php id(1943); ?></td><td style="background-color: #c5c5d2">694</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c5c5d2">3074</td><td style="background-color: #c5c5d2">4.4</td><td style="background-color: #c5c5d2">5 days ago</td><td style="background-color: #c5c5d2">"why do indy results matter? It was a Kabal activity :P"</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2">ARCoursca</td><td style="background-color: #c5c5d2">605</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c5c5d2">2985</td><td style="background-color: #c5c5d2">4.9</td><td style="background-color: #c5c5d2">15 days ago</td><td style="background-color: #c5c5d2">"Chelsea Clinton looks like Hillary..."</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2">Necrolord</td><td style="background-color: #c5c5d2">586</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #c5c5d2">2949</td><td style="background-color: #c5c5d2">5.0</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"I could tell something was wrong by the spell grahik"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1">JoeFriday</td><td style="background-color: #c5c5d1">782</td><td style="background-color: #c5c5d1"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c5c5d1">2889</td><td style="background-color: #c5c5d1">3.7</td><td style="background-color: #c5c5d1">15 days ago</td><td style="background-color: #c5c5d1">"why go into dragon anyway? 'tis a dying kabal :P"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1"><?php id(275); ?></td><td style="background-color: #c6c6d1">459</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c6c6d1">2785</td><td style="background-color: #c6c6d1">6.1</td><td style="background-color: #c6c6d1">1 day ago</td><td style="background-color: #c6c6d1">"damnit Jer! my brain needs cleaning again now!"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1"><?php id(577); ?></td><td style="background-color: #c6c6d1">547</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c6c6d1">2703</td><td style="background-color: #c6c6d1">4.9</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"just my day job again, don't panic, Lara."</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1">UncleFord</td><td style="background-color: #c6c6d1">367</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c6c6d1">2603</td><td style="background-color: #c6c6d1">7.1</td><td style="background-color: #c6c6d1">6 days ago</td><td style="background-color: #c6c6d1">"Some, but not a whole lot, Holo."</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0"><?php id(14); ?></td><td style="background-color: #c6c6d0">391</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="24" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c6c6d0">2603</td><td style="background-color: #c6c6d0">6.7</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"I especially liked the protocol droid rearming Jay, too. :P"</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0"><?php id(1133); ?></td><td style="background-color: #c6c6d0">623</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c6c6d0">2500</td><td style="background-color: #c6c6d0">4.0</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"But they have the best trucks"</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0">Fyre</td><td style="background-color: #c7c7d0">342</td><td style="background-color: #c7c7d0"><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c7c7d0">2463</td><td style="background-color: #c7c7d0">7.2</td><td style="background-color: #c7c7d0">2 days ago</td><td style="background-color: #c7c7d0">"Yeah, just about. Why else would I spend so much time on IRC?"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0">NvM</td><td style="background-color: #c7c7d0">364</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c7c7d0">2439</td><td style="background-color: #c7c7d0">6.7</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"yep, a gambling racket to profit in."</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0">Goomba</td><td style="background-color: #c7c7d0">364</td><td style="background-color: #c7c7d0"><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c7c7d0">2348</td><td style="background-color: #c7c7d0">6.5</td><td style="background-color: #c7c7d0">12 days ago</td><td style="background-color: #c7c7d0">"fruity: the ex-md of this company has hijacked the domain name"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf">`S-Tiger</td><td style="background-color: #c7c7cf">416</td><td style="background-color: #c7c7cf"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="30" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c7c7cf">2290</td><td style="background-color: #c7c7cf">5.5</td><td style="background-color: #c7c7cf">1 day ago</td><td style="background-color: #c7c7cf">"better yet, throw him TO the incubi"</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf">MiniElf</td><td style="background-color: #c8c8cf">510</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="30" height="15" alt="" /></td><td style="background-color: #c8c8cf">2115</td><td style="background-color: #c8c8cf">4.1</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"Count me in if you need a supporter"</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf"><?php id(295); ?></td><td style="background-color: #c8c8cf">337</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c8c8cf">2088</td><td style="background-color: #c8c8cf">6.2</td><td style="background-color: #c8c8cf">3 days ago</td><td style="background-color: #c8c8cf">"I am not sure if I;m going to join in or not."</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf">Reapsta</td><td style="background-color: #c8c8cf">513</td><td style="background-color: #c8c8cf"><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c8c8cf">2058</td><td style="background-color: #c8c8cf">4.0</td><td style="background-color: #c8c8cf">17 days ago</td><td style="background-color: #c8c8cf">"have you heard of one, then? :P"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce">Sayo</td><td style="background-color: #c8c8ce">283</td><td style="background-color: #c8c8ce"><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c8c8ce">1946</td><td style="background-color: #c8c8ce">6.9</td><td style="background-color: #c8c8ce">3 days ago</td><td style="background-color: #c8c8ce">"which would require a lake"</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce"><?php id(182); ?></td><td style="background-color: #c9c9ce">249</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c9c9ce">1928</td><td style="background-color: #c9c9ce">7.7</td><td style="background-color: #c9c9ce">6 days ago</td><td style="background-color: #c9c9ce">"what the hell is the HARA show?"</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce">Ender88</td><td style="background-color: #c9c9ce">448</td><td style="background-color: #c9c9ce"><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c9c9ce">1906</td><td style="background-color: #c9c9ce">4.3</td><td style="background-color: #c9c9ce">8 days ago</td><td style="background-color: #c9c9ce">"Woah...no whippings for me"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce">Shadonyx</td><td style="background-color: #c9c9ce">328</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="22" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c9c9ce">1904</td><td style="background-color: #c9c9ce">5.8</td><td style="background-color: #c9c9ce">7 days ago</td><td style="background-color: #c9c9ce">"Yu-Gi-Oh is actually a pretty good show."</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce"><?php id(1103); ?></td><td style="background-color: #c9c9ce">332</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c9c9ce">1808</td><td style="background-color: #c9c9ce">5.4</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"what thing would that be, slice?"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd">deathw</td><td style="background-color: #cacacd">318</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #cacacd">1745</td><td style="background-color: #cacacd">5.5</td><td style="background-color: #cacacd">3 days ago</td><td style="background-color: #cacacd">"ohh oh my sister needs to ring mum oohh"</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd">SanSri</td><td style="background-color: #cacacd">397</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #cacacd">1703</td><td style="background-color: #cacacd">4.3</td><td style="background-color: #cacacd">2 days ago</td><td style="background-color: #cacacd">"But it won best animation so I was happy about that"</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd">GoombaPHP</td><td style="background-color: #cacacd">217</td><td style="background-color: #cacacd"><img src="./green-h.png" border="0" width="30" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #cacacd">1680</td><td style="background-color: #cacacd">7.7</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"i am gonna go back take some test and then prolly goto uni :-P"</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd"><?php id(1219); ?></td><td style="background-color: #cacacd">305</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #cacacd">1650</td><td style="background-color: #cacacd">5.4</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"and that just the main BHG board"</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc">TG_Cid</td><td style="background-color: #cbcbcc">211</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #cbcbcc">1593</td><td style="background-color: #cbcbcc">7.5</td><td style="background-color: #cbcbcc">4 days ago</td><td style="background-color: #cbcbcc">"actually, it should be 99 luftballons"</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc">Strander</td><td style="background-color: #cbcbcc">294</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #cbcbcc">1461</td><td style="background-color: #cbcbcc">5.0</td><td style="background-color: #cbcbcc">12 days ago</td><td style="background-color: #cbcbcc">"/me wants him to answer so he can rejoin"</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc"><?php id(2006); ?></td><td style="background-color: #cbcbcc">247</td><td style="background-color: #cbcbcc"><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="32" height="15" alt="" /></td><td style="background-color: #cbcbcc">1354</td><td style="background-color: #cbcbcc">5.5</td><td style="background-color: #cbcbcc">4 days ago</td><td style="background-color: #cbcbcc">"Isn't that a brand of alcoholic beverage?"</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc">h0lo</td><td style="background-color: #cbcbcc">205</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="35" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #cbcbcc">1305</td><td style="background-color: #cbcbcc">6.4</td><td style="background-color: #cbcbcc">12 days ago</td><td style="background-color: #cbcbcc">"skor, you'll be at the meeting, yes?"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc">`Goomba</td><td style="background-color: #cccccc">248</td><td style="background-color: #cccccc"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #cccccc">1290</td><td style="background-color: #cccccc">5.2</td><td style="background-color: #cccccc">26 days ago</td><td style="background-color: #cccccc">"Slicer: i tried the ASP course but got bored with it"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10"><?php id(1036); ?> (1234)</td>
<td class="rankc10">Skorbles (1230)</td>
<td class="rankc10">MaraHarle (1216)</td>
<td class="rankc10">HolyFord (1216)</td>
<td class="rankc10"><?php id(366); ?> (1155)</td>
</tr><tr>
<td class="rankc10">KiwiBS (1110)</td>
<td class="rankc10">Reapa (1088)</td>
<td class="rankc10">BLD_Ender (1040)</td>
<td class="rankc10">Kranberry (1026)</td>
<td class="rankc10">[Food] (1011)</td>
</tr><tr>
<td class="rankc10">GiantWang (984)</td>
<td class="rankc10"><?php id(1245); ?> (949)</td>
<td class="rankc10"><?php id(1722); ?> (943)</td>
<td class="rankc10">DF|Busy (930)</td>
<td class="rankc10"><?php id(1218); ?> (928)</td>
</tr><tr>
<td class="rankc10"><?php id(2070); ?> (845)</td>
<td class="rankc10">Sayo|Dead (834)</td>
<td class="rankc10"><?php id(1717); ?> (823)</td>
<td class="rankc10">Ninjenov (784)</td>
<td class="rankc10">`Dagger (769)</td>
</tr><tr>
<td class="rankc10"><?php id(45); ?> (763)</td>
<td class="rankc10">aewith (749)</td>
<td class="rankc10"><?php id(1627); ?> (743)</td>
<td class="rankc10">`Lama (743)</td>
<td class="rankc10"><?php id(175); ?> (739)</td>
</tr><tr>
<td class="rankc10"><?php id(1064); ?> (722)</td>
<td class="rankc10"><?php id(765); ?> (715)</td>
<td class="rankc10">Schoolin (714)</td>
<td class="rankc10">CPT_Trent (700)</td>
<td class="rankc10">Dash- (699)</td>
</tr><tr>
<td class="rankc10"><?php id(2131); ?> (669)</td>
<td class="rankc10"><?php id(1678); ?> (667)</td>
<td class="rankc10">Urban (641)</td>
<td class="rankc10">___ (633)</td>
<td class="rankc10">Ender` (603)</td>
</tr><tr>
<td class="rankc10">k0wDUM (577)</td>
<td class="rankc10">^Ice (570)</td>
<td class="rankc10">MK (560)</td>
<td class="rankc10"><?php id(1264); ?> (550)</td>
<td class="rankc10">`War-beer (543)</td>
</tr></table>
<br /><b>By the way, there were 463 other nicks.</b><br />
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

<tr><td class="hicell">Is <b>`War-beer</b> stupid or just asking too many questions?  22.8% lines contained a question!
<br /><span class="small"><b><?php id(366); ?></b> didn't know that much either.  21.4% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b>`War-beer</b>, who yelled 95.7% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(2070); ?></b>, who shouted 41.2% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b><?php id(1717); ?></b>'s shift-key is hanging:  11.3% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[01:26] &lt;`Sen&gt; HOLO!!
</span><br />
<br /><span class="small"><b><?php id(1843); ?></b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 10.5% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1187); ?></b> is a very aggressive person.  He/She attacked others <b>56</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[15:20] Action: Slagar kicks JF
</span><br />
<br /><span class="small"><b><?php id(1247); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>42</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(1198); ?></b>, nobody likes him/her.  He/She was attacked <b>42</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[14:01] Action: Slagar kicks the people dissing Community Colleges
</span><br />
<br /><span class="small"><b>Conan</b> seems to be unliked too.  He/She got beaten <b>31</b> times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1245); ?></b> brings happiness to the world.  53.2% lines contained smiling faces.  :)
<br /><span class="small"><b>[Food]</b> isn't a sad person either, smiling 49.2% of the time.</span>
</td></tr>
<tr><td class="hicell"><b>Urban</b> seems to be sad at the moment:  4.4% lines contained sad faces.  :(
<br /><span class="small"><b><?php id(1064); ?></b> is also a sad person, crying 3.6% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(168); ?></b> wrote the longest lines, averaging 51.8 letters per line.<br />
<span class="small">#bhg average was 28.7 letters per line.</span></td></tr>
<tr><td class="hicell"><b><?php id(2070); ?></b> wrote the shortest lines, averaging 13.2 characters per line.<br />
<span class="small"><b>JackWebb</b> was tight-lipped, too, averaging 13.6 characters.</span></td></tr>
<tr><td class="hicell"><b>`Holo</b> spoke a total of 26653 words!
<br /><span class="small">`Holo's faithful follower, <b><?php id(1247); ?></b>, didn't speak so much: 25917 words.</span>
</td></tr>
<tr><td class="hicell"><b>^SyNthBRB</b> wrote an average of 25.00 words per line.
<br /><span class="small">Channel average was 5.68 words per line.</span>
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
<td class="hicell"><?php id(1198); ?></td>
<td class="hicell">35149</td>
<td class="hicell">Motti (EH)</td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(1908); ?></td>
<td class="hicell">8348</td>
<td class="hicell"><?php id(1187); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(42); ?></td>
<td class="hicell">2835</td>
<td class="hicell"><?php id(57); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(300); ?></td>
<td class="hicell">1870</td>
<td class="hicell"><?php id(118); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">about</td>
<td class="hicell">1569</td>
<td class="hicell"><?php id(57); ?></td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">think</td>
<td class="hicell">1305</td>
<td class="hicell">Reap</td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">there</td>
<td class="hicell">1155</td>
<td class="hicell"><?php id(1187); ?></td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">would</td>
<td class="hicell">1082</td>
<td class="hicell"><?php id(1103); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">people</td>
<td class="hicell">864</td>
<td class="hicell"><?php id(57); ?></td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">going</td>
<td class="hicell">786</td>
<td class="hicell"><?php id(1103); ?></td>
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
<td class="hicell">16149</td>
<td class="hicell"><?php id(229); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(331); ?></td>
<td class="hicell">12982</td>
<td class="hicell">`MK</td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(1281); ?></td>
<td class="hicell">3083</td>
<td class="hicell">Kelric</td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(57); ?></td>
<td class="hicell">1327</td>
<td class="hicell"><?php id(14); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(1103); ?></td>
<td class="hicell">1317</td>
<td class="hicell"><?php id(1219); ?></td>
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
<td class="hicell">8</td>
<td class="hicell"><?php id(747); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://www.corporatedivision.com:8000">http://www.corporatedivision.com:8000</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(1264); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://lawngnome.cernun.net/lotto/main.php">http://lawngnome.cernun.net/lotto/main.php</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(1247); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://nightweaver.thebhg.org/roflolomgwtf/">http://nightweaver.thebhg.org/roflolomgwtf/</a></td>
<td class="hicell">4</td>
<td class="hicell"><?php id(484); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://underlord.thebhg.org/Complaint/Complaint.php?viewentry=133">http://underlord.thebhg.org/Complaint/Complaint.php?viewentr</a></td>
<td class="hicell">4</td>
<td class="hicell"><?php id(2118); ?></td>
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

<tr><td class="hicell"><b>Reap</b> wasn't very popular, getting kicked 19 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[16:21] Reap kicked from #bhg by `Coursca: *POW!*
</span><br />
<br /><span class="small"><b><?php id(1247); ?></b> seemed to be hated too:  17 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(473); ?></b> is either insane or just a fair op, kicking a total of 28 people!
<br /><span class="small"><?php id(473); ?>'s faithful follower, <b><?php id(1625); ?></b>, kicked about 28 people.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> donated 48 ops in the channel...
<br /><span class="small"><b><?php id(1625); ?></b> was also very polite: 6 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> is the channel sheriff with 5 deops.
<br /><span class="small"><b><?php id(488); ?></b> deoped 4 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(331); ?></b> always lets us know what he/she's doing: 750 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[17:53] Action: `Lara sniffles
</span><br />
<br /><span class="small">Also, <b><?php id(1247); ?></b> tells us what's up with 684 actions.</span>
</td></tr>
<tr><td class="hicell"><b>Xar_</b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 25 times!
<br /><span class="small">Another lonely one was <b><?php id(473); ?></b>, who managed to hit 18 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> couldn't decide whether to stay or go.  389 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>HoloWrite</b> has quite a potty mouth.  1.5% words were foul language.
<br /><span class="small"><b>NykTEMPY</b> also makes sailors blush, 1.5% of the time.</span>
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

<tr><td class="hicell"><i><a href="http://www.ehnet.org/mb/viewtopic.php?t=5538" target="_blank" title="Open in new window: http://www.ehnet.org/mb/viewtopic.php?t=5538">http://www.ehnet.org/mb/viewtopic.php?t=5538</a> &lt;-- Also view the DP's MB post about this</i></td>
<td class="hicell"><b>by <?php id(152); ?> on 23:35</b></td></tr>
<tr><td class="hicell"><i><a href="http://www.ehnet.org/mb/viewtopic.php?t=5538" target="_blank" title="Open in new window: http://www.ehnet.org/mb/viewtopic.php?t=5538">http://www.ehnet.org/mb/viewtopic.php?t=5538</a></i></td>
<td class="hicell"><b>by <?php id(473); ?> on 20:46</b></td></tr>
<tr><td class="hicell"><i>Cadre Games VII: <a href="http://boards.thebhg.org/devel/index.php?op=view&amp;topic=4958" target="_blank" title="Open in new window: http://boards.thebhg.org/devel/index.php?op=view&amp;topic=4958">http://boards.thebhg.org/devel/index.php?op=view&amp;topic=4958</a> || OM set 48: <a href="http://tactician.thebhg.org/" target="_blank" title="Open in new window: http://tactician.thebhg.org/">http://tactician.thebhg.org/</a> || Go inanimate carbon rod!</i></td>
<td class="hicell"><b>by <?php id(666); ?> on 05:28</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 168 times.</td></tr>
</table>
Total number of lines: 120114.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 00 minutes and 58 seconds
</span>
</div>
</body>
</html>

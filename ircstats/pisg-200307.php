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
Statistics generated on  Monday 18 August 2003 - 11:07:50
<br />During this 31-day reporting period, a total of <b>533</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">5.7%<br /><img src="./blue-v.png" width="15" height="97.173854808465" alt="5.7" /></td>

<td align="center" valign="bottom" class="asmall">5.1%<br /><img src="./blue-v.png" width="15" height="88.1730511652826" alt="5.1" /></td>

<td align="center" valign="bottom" class="asmall">3.3%<br /><img src="./blue-v.png" width="15" height="56.4157514063756" alt="3.3" /></td>

<td align="center" valign="bottom" class="asmall">3.9%<br /><img src="./blue-v.png" width="15" height="66.5282614519154" alt="3.9" /></td>

<td align="center" valign="bottom" class="asmall">3.0%<br /><img src="./blue-v.png" width="15" height="51.8081971604608" alt="3.0" /></td>

<td align="center" valign="bottom" class="asmall">2.2%<br /><img src="./blue-v.png" width="15" height="38.4007500669703" alt="2.2" /></td>

<td align="center" valign="bottom" class="asmall">1.6%<br /><img src="./green-v.png" width="15" height="28.5963032413608" alt="1.6" /></td>

<td align="center" valign="bottom" class="asmall">1.8%<br /><img src="./green-v.png" width="15" height="31.4492365389767" alt="1.8" /></td>

<td align="center" valign="bottom" class="asmall">2.7%<br /><img src="./green-v.png" width="15" height="45.9951781409054" alt="2.7" /></td>

<td align="center" valign="bottom" class="asmall">3.5%<br /><img src="./green-v.png" width="15" height="59.7374765604072" alt="3.5" /></td>

<td align="center" valign="bottom" class="asmall">3.7%<br /><img src="./green-v.png" width="15" height="64.4789713367265" alt="3.7" /></td>

<td align="center" valign="bottom" class="asmall">5.6%<br /><img src="./green-v.png" width="15" height="95.9951781409054" alt="5.6" /></td>

<td align="center" valign="bottom" class="asmall">5.1%<br /><img src="./yellow-v.png" width="15" height="88.2534154835253" alt="5.1" /></td>

<td align="center" valign="bottom" class="asmall">5.2%<br /><img src="./yellow-v.png" width="15" height="89.4320921510849" alt="5.2" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./yellow-v.png" width="15" height="72.91722475221" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">3.5%<br /><img src="./yellow-v.png" width="15" height="60.9027591749263" alt="3.5" /></td>

<td align="center" valign="bottom" class="asmall">4.6%<br /><img src="./yellow-v.png" width="15" height="78.9981248325743" alt="4.6" /></td>

<td align="center" valign="bottom" class="asmall">4.1%<br /><img src="./yellow-v.png" width="15" height="71.1090275917493" alt="4.1" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./red-v.png" width="15" height="65.6710420573265" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">4.3%<br /><img src="./red-v.png" width="15" height="74.5379051701045" alt="4.3" /></td>

<td align="center" valign="bottom" class="asmall">5.6%<br /><img src="./red-v.png" width="15" height="95.8478435574605" alt="5.6" /></td>

<td align="center" valign="bottom" class="asmall">4.7%<br /><img src="./red-v.png" width="15" height="80.5920171443879" alt="4.7" /></td>

<td align="center" valign="bottom" class="asmall">4.6%<br /><img src="./red-v.png" width="15" height="78.9311545673721" alt="4.6" /></td>

<td align="center" valign="bottom" class="asmall">5.8%<br /><img src="./red-v.png" width="15" height="100" alt="5.8" /></td>

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
<td class="hirankc10center" align="center">23</td>
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
<td style="background-color: #babadc"><?php id(168); ?></td><td style="background-color: #babadc">5063</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #babadc">41754</td><td style="background-color: #babadc">8.2</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"talk to you bums in the morning."</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(57); ?></td><td style="background-color: #babadc">5707</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #babadc">32964</td><td style="background-color: #babadc">5.8</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"&lt;Slagar&gt; NO im saying when the times comes you wont have to"</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(1551); ?></td><td style="background-color: #babadc">4796</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #babadc">30477</td><td style="background-color: #babadc">6.4</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Skor: Can you make me a pi icon if you can find a good original?"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(1247); ?></td><td style="background-color: #babadc">5627</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #babadc">30239</td><td style="background-color: #babadc">5.4</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Therefore, the need for a trilogy!!!"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(95); ?></td><td style="background-color: #bbbbdb">2637</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bbbbdb">22559</td><td style="background-color: #bbbbdb">8.6</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"means that lucas wrote the script that way :P"</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(242); ?></td><td style="background-color: #bbbbdb">3395</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bbbbdb">22423</td><td style="background-color: #bbbbdb">6.6</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"cause people are attracted to your hot body"</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(16); ?></td><td style="background-color: #bbbbdb">2276</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bbbbdb">21842</td><td style="background-color: #bbbbdb">9.6</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"cha: seen it before, and probably"</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(1625); ?></td><td style="background-color: #bbbbdb">3561</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bbbbdb">21546</td><td style="background-color: #bbbbdb">6.1</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"Damn, you've already passed it  :P"</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(2029); ?></td><td style="background-color: #bcbcda">3029</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="33" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bcbcda">21229</td><td style="background-color: #bcbcda">7.0</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"boh, you hadn't noticed? :P"</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda">`Motti`</td><td style="background-color: #bcbcda">2681</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #bcbcda">19626</td><td style="background-color: #bcbcda">7.3</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"i just don't know what it's like in the other provinces"</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(1197); ?></td><td style="background-color: #bcbcda">3803</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bcbcda">18925</td><td style="background-color: #bcbcda">5.0</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"Well, I'm liked by people in command"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(331); ?></td><td style="background-color: #bcbcda">4407</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #bcbcda">18129</td><td style="background-color: #bcbcda">4.1</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"i just got home from buying Magic cards :)"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(666); ?></td><td style="background-color: #bdbdda">1799</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #bdbdda">15580</td><td style="background-color: #bdbdda">8.7</td><td style="background-color: #bdbdda">Today</td><td style="background-color: #bdbdda">"i still want to do a sequel to gnomesville"</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9"><?php id(370); ?></td><td style="background-color: #bdbdd9">2397</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #bdbdd9">14661</td><td style="background-color: #bdbdd9">6.1</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"peer is 1 year older then i"</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(1699); ?></td><td style="background-color: #bdbdd9">2752</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="22" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #bdbdd9">13704</td><td style="background-color: #bdbdd9">5.0</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"Morose? When the need arises, yes."</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(1754); ?></td><td style="background-color: #bdbdd9">2292</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bdbdd9">13218</td><td style="background-color: #bdbdd9">5.8</td><td style="background-color: #bdbdd9">3 days ago</td><td style="background-color: #bdbdd9">"Chron, you're the laziest dominetrix ever"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(1908); ?></td><td style="background-color: #bebed9">2611</td><td style="background-color: #bebed9"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #bebed9">12885</td><td style="background-color: #bebed9">4.9</td><td style="background-color: #bebed9">1 day ago</td><td style="background-color: #bebed9">"Gen transfered from Cyclone to Thunder? :P"</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8"><?php id(229); ?></td><td style="background-color: #bebed8">1536</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #bebed8">12650</td><td style="background-color: #bebed8">8.2</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"I heard someone call it trip-hop."</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(484); ?></td><td style="background-color: #bebed8">1854</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #bebed8">12259</td><td style="background-color: #bebed8">6.6</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"well i get some ram as soon as i do some weeding"</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(1772); ?></td><td style="background-color: #bebed8">2476</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bebed8">11505</td><td style="background-color: #bebed8">4.6</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"Err... and I believe Scott Stevens is also."</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8"><?php id(2118); ?></td><td style="background-color: #bfbfd8">1778</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #bfbfd8">10101</td><td style="background-color: #bfbfd8">5.7</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"the Citadel members can participate in the KAGs  ?"</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(1198); ?></td><td style="background-color: #bfbfd8">1920</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bfbfd8">8966</td><td style="background-color: #bfbfd8">4.7</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"Zed: that'swhy I challenged Renia"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7"><?php id(1187); ?></td><td style="background-color: #bfbfd7">1214</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="23" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #bfbfd7">8097</td><td style="background-color: #bfbfd7">6.7</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"I know, it's what I call the Jar Jar effect"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7"><?php id(275); ?></td><td style="background-color: #bfbfd7">1134</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #bfbfd7">7999</td><td style="background-color: #bfbfd7">7.1</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"what a whore of a connection i have :)"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(1356); ?></td><td style="background-color: #c0c0d7">1228</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c0c0d7">7694</td><td style="background-color: #c0c0d7">6.3</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"He dared challeged me because I am a Nazi :P"</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(1803); ?></td><td style="background-color: #c0c0d7">1275</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c0c0d7">7324</td><td style="background-color: #c0c0d7">5.7</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"until it annoys you with its annoyingness"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6"><?php id(23); ?></td><td style="background-color: #c0c0d6">948</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c0c0d6">7182</td><td style="background-color: #c0c0d6">7.6</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"wanna be a Prm! Wanna have a magical goodies card!"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6"><?php id(747); ?></td><td style="background-color: #c0c0d6">1620</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c0c0d6">6941</td><td style="background-color: #c0c0d6">4.3</td><td style="background-color: #c0c0d6">1 day ago</td><td style="background-color: #c0c0d6">"and movies like dumb and dumberer too :P"</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(94); ?></td><td style="background-color: #c0c0d6">696</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="24" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c0c0d6">6410</td><td style="background-color: #c0c0d6">9.2</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"no, i think we'll fire thunder chief"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6">Tnsumi</td><td style="background-color: #c1c1d6">1087</td><td style="background-color: #c1c1d6"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c1c1d6">6388</td><td style="background-color: #c1c1d6">5.9</td><td style="background-color: #c1c1d6">Today</td><td style="background-color: #c1c1d6">"for one sweet moment, I was op. lol"</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5">FruitCak</td><td style="background-color: #c1c1d5">693</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="25" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c1c1d5">5921</td><td style="background-color: #c1c1d5">8.5</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"slice you really should of let the doctor cut that growth off"</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5"><?php id(141); ?></td><td style="background-color: #c1c1d5">1219</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c1c1d5">5670</td><td style="background-color: #c1c1d5">4.7</td><td style="background-color: #c1c1d5">1 day ago</td><td style="background-color: #c1c1d5">"Platinum is limited amount"</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5"><?php id(1264); ?></td><td style="background-color: #c1c1d5">990</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c1c1d5">5229</td><td style="background-color: #c1c1d5">5.3</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"if you don't like it, send it to me =P"</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5"><?php id(14); ?></td><td style="background-color: #c2c2d5">607</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c2c2d5">4076</td><td style="background-color: #c2c2d5">6.7</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"I'm evil, I'm crazy, I'm a badass, get away.  That's an album."</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5"><?php id(1843); ?></td><td style="background-color: #c2c2d5">871</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="26" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c2c2d5">4026</td><td style="background-color: #c2c2d5">4.6</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"will somebody grade WH 158 first?!"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(118); ?></td><td style="background-color: #c2c2d4">499</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c2c2d4">3907</td><td style="background-color: #c2c2d4">7.8</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"Eveyrthing looks the same now!"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4"><?php id(1583); ?></td><td style="background-color: #c2c2d4">579</td><td style="background-color: #c2c2d4"><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c2c2d4">3820</td><td style="background-color: #c2c2d4">6.6</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"african or european swallow?"</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4">^SyNthPHP</td><td style="background-color: #c3c3d4">784</td><td style="background-color: #c3c3d4"><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c3c3d4">3671</td><td style="background-color: #c3c3d4">4.7</td><td style="background-color: #c3c3d4">1 day ago</td><td style="background-color: #c3c3d4">"if you have directx, you have it"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(1722); ?></td><td style="background-color: #c3c3d4">896</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c3c3d4">3648</td><td style="background-color: #c3c3d4">4.1</td><td style="background-color: #c3c3d4">10 days ago</td><td style="background-color: #c3c3d4">"and Hamsters be- wait no thats not wierd"</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3">Xar_</td><td style="background-color: #c3c3d3">769</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="26" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c3c3d3">3548</td><td style="background-color: #c3c3d3">4.6</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"and i have a funny reason why i joined the BHG"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3">`Lonestar</td><td style="background-color: #c3c3d3">379</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c3c3d3">3478</td><td style="background-color: #c3c3d3">9.2</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"my MOHAA clan has it on it's website"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3"><?php id(1225); ?></td><td style="background-color: #c4c4d3">508</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c4c4d3">3420</td><td style="background-color: #c4c4d3">6.7</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"what's another way to test and see that?"</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3"><?php id(1135); ?></td><td style="background-color: #c4c4d3">394</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="30" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c4c4d3">3061</td><td style="background-color: #c4c4d3">7.8</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"the exact image was available at starwars.com anyway"</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(2131); ?></td><td style="background-color: #c4c4d3">516</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c4c4d3">2893</td><td style="background-color: #c4c4d3">5.6</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"EH Wargames will surpass Hawkeye"</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2"><?php id(45); ?></td><td style="background-color: #c4c4d2">420</td><td style="background-color: #c4c4d2"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c4c4d2">2797</td><td style="background-color: #c4c4d2">6.7</td><td style="background-color: #c4c4d2">Today</td><td style="background-color: #c4c4d2">"50 deducted for lack of effort"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2">Naiht</td><td style="background-color: #c5c5d2">646</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #c5c5d2">2786</td><td style="background-color: #c5c5d2">4.3</td><td style="background-color: #c5c5d2">4 days ago</td><td style="background-color: #c5c5d2">"You'd want Detori as an ally? rofl"</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2">FruitCak_</td><td style="background-color: #c5c5d2">275</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c5c5d2">2512</td><td style="background-color: #c5c5d2">9.1</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"i gradumacated high skool with 48% in english"</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2"><?php id(473); ?></td><td style="background-color: #c5c5d2">530</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c5c5d2">2447</td><td style="background-color: #c5c5d2">4.6</td><td style="background-color: #c5c5d2">4 days ago</td><td style="background-color: #c5c5d2">"Hell, all the textbook went over was politics...:P"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1">Sayo</td><td style="background-color: #c5c5d1">276</td><td style="background-color: #c5c5d1"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c5c5d1">2402</td><td style="background-color: #c5c5d1">8.7</td><td style="background-color: #c5c5d1">Today</td><td style="background-color: #c5c5d1">"Well....what is Ronin getting paid with from Ast?"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1">Errak</td><td style="background-color: #c6c6d1">310</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c6c6d1">2379</td><td style="background-color: #c6c6d1">7.7</td><td style="background-color: #c6c6d1">1 day ago</td><td style="background-color: #c6c6d1">"No we pretty much trashed the town"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1"><?php id(1219); ?></td><td style="background-color: #c6c6d1">476</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c6c6d1">2210</td><td style="background-color: #c6c6d1">4.6</td><td style="background-color: #c6c6d1">5 days ago</td><td style="background-color: #c6c6d1">"whatever you do DON'T see 28 days later"</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1"><?php id(1085); ?></td><td style="background-color: #c6c6d1">408</td><td style="background-color: #c6c6d1"><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="22" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c6c6d1">2201</td><td style="background-color: #c6c6d1">5.4</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"I've just had other things to do :P"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0"><?php id(1281); ?></td><td style="background-color: #c6c6d0">352</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c6c6d0">2012</td><td style="background-color: #c6c6d0">5.7</td><td style="background-color: #c6c6d0">2 days ago</td><td style="background-color: #c6c6d0">"illegally its already out ;-)"</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0">Renia</td><td style="background-color: #c6c6d0">669</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c6c6d0">1687</td><td style="background-color: #c6c6d0">2.5</td><td style="background-color: #c6c6d0">7 days ago</td><td style="background-color: #c6c6d0">"I wonder when I'll get my SCB :P"</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0"><?php id(258); ?></td><td style="background-color: #c7c7d0">233</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #c7c7d0">1627</td><td style="background-color: #c7c7d0">7.0</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"Tuss, do I talk to you about getting an SE builder?"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0"><?php id(1943); ?></td><td style="background-color: #c7c7d0">409</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="20" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #c7c7d0">1624</td><td style="background-color: #c7c7d0">4.0</td><td style="background-color: #c7c7d0">1 day ago</td><td style="background-color: #c7c7d0">"sadly, LG only appears in my scenario this time around :P"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0">Fyre</td><td style="background-color: #c7c7d0">208</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c7c7d0">1597</td><td style="background-color: #c7c7d0">7.7</td><td style="background-color: #c7c7d0">2 days ago</td><td style="background-color: #c7c7d0">"Greater Southern Northern Someplace"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf">Slowie</td><td style="background-color: #c7c7cf">466</td><td style="background-color: #c7c7cf"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #c7c7cf">1386</td><td style="background-color: #c7c7cf">3.0</td><td style="background-color: #c7c7cf">27 days ago</td><td style="background-color: #c7c7cf">"synth asked is he said that"</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf"><?php id(1594); ?></td><td style="background-color: #c8c8cf">164</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="30" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c8c8cf">1331</td><td style="background-color: #c8c8cf">8.1</td><td style="background-color: #c8c8cf">2 days ago</td><td style="background-color: #c8c8cf">"ooo... I should watch the Ninja Scroll TV series..."</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf"><?php id(135); ?></td><td style="background-color: #c8c8cf">189</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #c8c8cf">1196</td><td style="background-color: #c8c8cf">6.3</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"mmm.. beans... err.. beam... yeah.. beams.."</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf"><?php id(264); ?></td><td style="background-color: #c8c8cf">243</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c8c8cf">1194</td><td style="background-color: #c8c8cf">4.9</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"anyone know any Ehers that are on Galaxies NOW"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce"><?php id(1133); ?></td><td style="background-color: #c8c8ce">344</td><td style="background-color: #c8c8ce"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c8c8ce">1178</td><td style="background-color: #c8c8ce">3.4</td><td style="background-color: #c8c8ce">Today</td><td style="background-color: #c8c8ce">"What stae are you in Reav?"</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce">Prospero</td><td style="background-color: #c9c9ce">172</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c9c9ce">1160</td><td style="background-color: #c9c9ce">6.7</td><td style="background-color: #c9c9ce">2 days ago</td><td style="background-color: #c9c9ce">"reav: its probably because you dont see them for 2 months"</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce">peer-gone</td><td style="background-color: #c9c9ce">214</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="38" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c9c9ce">1091</td><td style="background-color: #c9c9ce">5.1</td><td style="background-color: #c9c9ce">6 days ago</td><td style="background-color: #c9c9ce">"the Inquisitors are merely a means to an end"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce">^Fyre</td><td style="background-color: #c9c9ce">143</td><td style="background-color: #c9c9ce"><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c9c9ce">1069</td><td style="background-color: #c9c9ce">7.5</td><td style="background-color: #c9c9ce">4 days ago</td><td style="background-color: #c9c9ce">"Why do you think he sugested it? :P"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce">peer-work</td><td style="background-color: #c9c9ce">158</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="34" height="15" alt="" /></td><td style="background-color: #c9c9ce">968</td><td style="background-color: #c9c9ce">6.1</td><td style="background-color: #c9c9ce">2 days ago</td><td style="background-color: #c9c9ce">"That's one freaking hairy bull. And the head is far too large :P"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd"><?php id(2006); ?></td><td style="background-color: #cacacd">149</td><td style="background-color: #cacacd"><img src="./red-h.png" border="0" width="39" height="15" alt="" /></td><td style="background-color: #cacacd">943</td><td style="background-color: #cacacd">6.3</td><td style="background-color: #cacacd">2 days ago</td><td style="background-color: #cacacd">"Last time I checked you could be smart and an idiot"</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd"><?php id(1717); ?></td><td style="background-color: #cacacd">232</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #cacacd">931</td><td style="background-color: #cacacd">4.0</td><td style="background-color: #cacacd">4 days ago</td><td style="background-color: #cacacd">"well you sure are a bitch of a grader =P"</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd">Shadow_Fa</td><td style="background-color: #cacacd">92</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #cacacd">916</td><td style="background-color: #cacacd">10.0</td><td style="background-color: #cacacd">12 days ago</td><td style="background-color: #cacacd">"Samuel L. made that movie methinks"</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd">Flash-6</td><td style="background-color: #cacacd">304</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="25" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #cacacd">887</td><td style="background-color: #cacacd">2.9</td><td style="background-color: #cacacd">3 days ago</td><td style="background-color: #cacacd">"which is in the process of undermining itself"</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc"><?php id(1656); ?></td><td style="background-color: #cbcbcc">181</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="29" height="15" alt="" /></td><td style="background-color: #cbcbcc">827</td><td style="background-color: #cbcbcc">4.6</td><td style="background-color: #cbcbcc">7 days ago</td><td style="background-color: #cbcbcc">"its a miracle we breed at all"</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc">Mal|away</td><td style="background-color: #cbcbcc">148</td><td style="background-color: #cbcbcc"><img src="./green-h.png" border="0" width="22" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #cbcbcc">825</td><td style="background-color: #cbcbcc">5.6</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"and then I have a pair that lights up in dark :Þ"</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc"><?php id(1332); ?></td><td style="background-color: #cbcbcc">159</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="27" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #cbcbcc">777</td><td style="background-color: #cbcbcc">4.9</td><td style="background-color: #cbcbcc">16 days ago</td><td style="background-color: #cbcbcc">"hmmm i shouldn't even still be in skylla:P"</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc">Zed||DEAD</td><td style="background-color: #cbcbcc">104</td><td style="background-color: #cbcbcc"><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #cbcbcc">739</td><td style="background-color: #cbcbcc">7.1</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"anyway I'm going to go to my brother's house."</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc">ShaydeFic</td><td style="background-color: #cccccc">191</td><td style="background-color: #cccccc"><img src="./blue-h.png" border="0" width="20" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #cccccc">729</td><td style="background-color: #cccccc">3.8</td><td style="background-color: #cccccc">Today</td><td style="background-color: #cccccc">"so close to finishing, yet so far"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10"><?php id(2217); ?> (719)</td>
<td class="rankc10">MottiAway (706)</td>
<td class="rankc10">NykARENA (693)</td>
<td class="rankc10">T20004X (681)</td>
<td class="rankc10">Jerspeare (660)</td>
</tr><tr>
<td class="rankc10">DamnSexy (655)</td>
<td class="rankc10"><?php id(1103); ?> (607)</td>
<td class="rankc10">T` (604)</td>
<td class="rankc10"><?php id(818); ?> (593)</td>
<td class="rankc10">ChroRant (575)</td>
</tr><tr>
<td class="rankc10">^Ice (522)</td>
<td class="rankc10">`Obi-Wan (518)</td>
<td class="rankc10">Con`Arena (516)</td>
<td class="rankc10">Talra-C (514)</td>
<td class="rankc10">Motti|RO (507)</td>
</tr><tr>
<td class="rankc10">CT2K (479)</td>
<td class="rankc10">`punks (477)</td>
<td class="rankc10"><?php id(1489); ?> (471)</td>
<td class="rankc10">`peer (470)</td>
<td class="rankc10">hi_u_bhg (456)</td>
</tr><tr>
<td class="rankc10">Mixa_reap (456)</td>
<td class="rankc10">peer-AFK (445)</td>
<td class="rankc10">rissy-lab (440)</td>
<td class="rankc10"><?php id(295); ?> (438)</td>
<td class="rankc10"><?php id(1036); ?> (437)</td>
</tr><tr>
<td class="rankc10">Prosperos (418)</td>
<td class="rankc10"><?php id(385); ?> (415)</td>
<td class="rankc10">DS|Arena (405)</td>
<td class="rankc10">Kat|AFK (402)</td>
<td class="rankc10">Abob (398)</td>
</tr><tr>
<td class="rankc10">DmnSxyAFK (395)</td>
<td class="rankc10"><?php id(1677); ?> (387)</td>
<td class="rankc10"><?php id(77); ?> (374)</td>
<td class="rankc10">AmunJer (370)</td>
<td class="rankc10">ris-hmwrk (359)</td>
</tr><tr>
<td class="rankc10">ArcTheLad (352)</td>
<td class="rankc10">SanSri (349)</td>
<td class="rankc10">Zed|WRITE (346)</td>
<td class="rankc10">`Curtis (338)</td>
<td class="rankc10">CorpseRot (338)</td>
</tr></table>
<br /><b>By the way, there were 418 other nicks.</b><br />
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

<tr><td class="hicell">Is <b><?php id(1198); ?></b> stupid or just asking too many questions?  22.0% lines contained a question!
<br /><span class="small"><b>Sayo</b> didn't know that much either.  20.2% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(1943); ?></b>, who yelled 28.3% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(135); ?></b>, who shouted 18.5% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b>Abob</b>'s shift-key is hanging:  25% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[15:12] &lt;Abob&gt;  10K
</span><br />
<br /><span class="small"><b>T20004X</b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 8.8% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(57); ?></b> is a very aggressive person.  He/She attacked others <b>37</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[16:34] Action: Genno kicks Krail in the shin anyway
</span><br />
<br /><span class="small"><b><?php id(1247); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>30</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(1198); ?></b>, nobody likes him/her.  He/She was attacked <b>16</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[12:34] Action: WD|SLEEP thwacks Inop wiht a 2x4
</span><br />
<br /><span class="small"><b><?php id(1218); ?></b> seems to be unliked too.  He/She got beaten <b>15</b> times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1908); ?></b> brings happiness to the world.  51.3% lines contained smiling faces.  :)
<br /><span class="small"><b><?php id(473); ?></b> isn't a sad person either, smiling 43.7% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1103); ?></b> seems to be sad at the moment:  4.1% lines contained sad faces.  :(
<br /><span class="small"><b><?php id(16); ?></b> is also a sad person, crying 1.9% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(16); ?></b> wrote the longest lines, averaging 49.1 letters per line.<br />
<span class="small">#bhg average was 30.4 letters per line.</span></td></tr>
<tr><td class="hicell"><b>Renia</b> wrote the shortest lines, averaging 11.7 characters per line.<br />
<span class="small"><b>Slowie</b> was tight-lipped, too, averaging 13.7 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(168); ?></b> spoke a total of 41754 words!
<br /><span class="small"><?php id(168); ?>'s faithful follower, <b><?php id(57); ?></b>, didn't speak so much: 32964 words.</span>
</td></tr>
<tr><td class="hicell"><b>t00bboj</b> wrote an average of 22.00 words per line.
<br /><span class="small">Channel average was 6.03 words per line.</span>
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
<td class="hicell">2888</td>
<td class="hicell">peer-work</td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell">about</td>
<td class="hicell">1618</td>
<td class="hicell">T20004X</td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell">think</td>
<td class="hicell">1552</td>
<td class="hicell"><?php id(370); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell">there</td>
<td class="hicell">1286</td>
<td class="hicell">FruitCak_</td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">would</td>
<td class="hicell">1156</td>
<td class="hicell">`Motti`</td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">people</td>
<td class="hicell">1074</td>
<td class="hicell"><?php id(242); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">right</td>
<td class="hicell">928</td>
<td class="hicell">FruitCak_</td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">going</td>
<td class="hicell">917</td>
<td class="hicell"><?php id(370); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">should</td>
<td class="hicell">899</td>
<td class="hicell">`Motti`</td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">really</td>
<td class="hicell">881</td>
<td class="hicell"><?php id(242); ?></td>
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
<td class="hicell">20680</td>
<td class="hicell"><?php id(1247); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(1218); ?></td>
<td class="hicell">19370</td>
<td class="hicell"><?php id(1247); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(1281); ?></td>
<td class="hicell">3377</td>
<td class="hicell"><?php id(370); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(300); ?></td>
<td class="hicell">2164</td>
<td class="hicell"><?php id(16); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(1332); ?></td>
<td class="hicell">1911</td>
<td class="hicell"><?php id(95); ?></td>
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
<td class="hicell">13</td>
<td class="hicell"><?php id(1197); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://www....">http://www....</a></td>
<td class="hicell">7</td>
<td class="hicell"><?php id(1198); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://specialist.thebhg.org/history/">http://specialist.thebhg.org/history/</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(94); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://specialist.thebhg.org/paradox/">http://specialist.thebhg.org/paradox/</a></td>
<td class="hicell">4</td>
<td class="hicell"><?php id(1699); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://holonet.thebhg.org/index.php?module=2&amp;page=quotes">http://holonet.thebhg.org/index.php?module=2&amp;page=quotes</a></td>
<td class="hicell">4</td>
<td class="hicell"><?php id(1699); ?></td>
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

<tr><td class="hicell"><b><?php id(1247); ?></b> wasn't very popular, getting kicked 34 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[21:50] `Conan kicked from #bhg by D_Shadow: aaaaaaaaaaaaaaaaand you're outta here!
</span><br />
<br /><span class="small"><b><?php id(57); ?></b> seemed to be hated too:  21 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1625); ?></b> is either insane or just a fair op, kicking a total of 67 people!
<br /><span class="small"><?php id(1625); ?>'s faithful follower, <b>LawnGnome</b>, kicked about 58 people.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> donated 42 ops in the channel...
<br /><span class="small"><b><?php id(1625); ?></b> was also very polite: 40 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1197); ?></b> is the channel sheriff with 36 deops.
<br /><span class="small"><b><?php id(1625); ?></b> deoped 21 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(57); ?></b> always lets us know what he/she's doing: 1156 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[21:36] Action: `Auron votes for Kitty
</span><br />
<br /><span class="small">Also, <b><?php id(1247); ?></b> tells us what's up with 783 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1551); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 23 times!
<br /><span class="small">Another lonely one was <b><?php id(168); ?></b>, who managed to hit 18 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1264); ?></b> couldn't decide whether to stay or go.  349 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>Grav|Site</b> has quite a potty mouth.  2.8% words were foul language.
<br /><span class="small"><b>BranMan</b> also makes sailors blush, 2.2% of the time.</span>
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

<tr><td class="hicell"><i>Pants: <a href="http://ars.userfriendly.org/cartoons/?id=20030731" target="_blank" title="Open in new window: http://ars.userfriendly.org/cartoons/?id=20030731">http://ars.userfriendly.org/cartoons/?id=20030731</a></i></td>
<td class="hicell"><b>by <?php id(94); ?> on 06:21</b></td></tr>
<tr><td class="hicell"><i>Dalk decides to give up the goat and retire from Executor || Applications for X open, check MB||Krail recieves a free kilted Lawn Gnome with vibrating function</i></td>
<td class="hicell"><b>by <?php id(1625); ?> on 23:25</b></td></tr>
<tr><td class="hicell"><i>Dalk decides to give up the goat and retire from Executor || Applications for X open, check MB || Krail recieves a free kilted Lawn Gnome... with vibrating func</i></td>
<td class="hicell"><b>by <?php id(1625); ?> on 23:25</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 412 times.</td></tr>
</table>
Total number of lines: 126870.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 01 minutes and 16 seconds
</span>
</div>
</body>
</html>

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
Statistics generated on  Friday 11 February 2005 - 0:00:45
<br />During this 11-day reporting period, a total of <b>124</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">6.0%<br /><img src="./blue-v.png" width="15" height="81.8965517241379" alt="6.0" /></td>

<td align="center" valign="bottom" class="asmall">4.1%<br /><img src="./blue-v.png" width="15" height="56.3218390804598" alt="4.1" /></td>

<td align="center" valign="bottom" class="asmall">4.6%<br /><img src="./blue-v.png" width="15" height="62.5478927203065" alt="4.6" /></td>

<td align="center" valign="bottom" class="asmall">1.9%<br /><img src="./blue-v.png" width="15" height="26.3409961685824" alt="1.9" /></td>

<td align="center" valign="bottom" class="asmall">1.7%<br /><img src="./blue-v.png" width="15" height="23.8505747126437" alt="1.7" /></td>

<td align="center" valign="bottom" class="asmall">0.8%<br /><img src="./green-v.png" width="15" height="12.1647509578544" alt="0.8" /></td>

<td align="center" valign="bottom" class="asmall">1.5%<br /><img src="./green-v.png" width="15" height="20.8812260536398" alt="1.5" /></td>

<td align="center" valign="bottom" class="asmall">2.3%<br /><img src="./green-v.png" width="15" height="31.992337164751" alt="2.3" /></td>

<td align="center" valign="bottom" class="asmall">2.9%<br /><img src="./green-v.png" width="15" height="39.9425287356322" alt="2.9" /></td>

<td align="center" valign="bottom" class="asmall">3.9%<br /><img src="./green-v.png" width="15" height="53.8314176245211" alt="3.9" /></td>

<td align="center" valign="bottom" class="asmall">2.3%<br /><img src="./green-v.png" width="15" height="32.088122605364" alt="2.3" /></td>

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./yellow-v.png" width="15" height="66.7624521072797" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">5.0%<br /><img src="./yellow-v.png" width="15" height="67.911877394636" alt="5.0" /></td>

<td align="center" valign="bottom" class="asmall">5.0%<br /><img src="./yellow-v.png" width="15" height="68.9655172413793" alt="5.0" /></td>

<td align="center" valign="bottom" class="asmall">4.1%<br /><img src="./yellow-v.png" width="15" height="55.8429118773946" alt="4.1" /></td>

<td align="center" valign="bottom" class="asmall">6.1%<br /><img src="./yellow-v.png" width="15" height="83.8122605363985" alt="6.1" /></td>

<td align="center" valign="bottom" class="asmall">4.3%<br /><img src="./yellow-v.png" width="15" height="58.5249042145594" alt="4.3" /></td>

<td align="center" valign="bottom" class="asmall">5.6%<br /><img src="./red-v.png" width="15" height="76.3409961685824" alt="5.6" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./red-v.png" width="15" height="42.6245210727969" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">5.6%<br /><img src="./red-v.png" width="15" height="76.6283524904215" alt="5.6" /></td>

<td align="center" valign="bottom" class="asmall">5.2%<br /><img src="./red-v.png" width="15" height="70.6896551724138" alt="5.2" /></td>

<td align="center" valign="bottom" class="asmall">4.5%<br /><img src="./red-v.png" width="15" height="61.3026819923372" alt="4.5" /></td>

<td align="center" valign="bottom" class="asmall">4.8%<br /><img src="./red-v.png" width="15" height="65.4214559386973" alt="4.8" /></td>

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
<td style="background-color: #babadc"><?php id(2122); ?></td><td style="background-color: #babadc">1004</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #babadc">10424</td><td style="background-color: #babadc">10.4</td><td style="background-color: #babadc">1 day ago</td><td style="background-color: #babadc">"Pfft.  Why would I need anything aside from #bhg, Min? :P"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(1625); ?></td><td style="background-color: #babadc">955</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #babadc">9110</td><td style="background-color: #babadc">9.5</td><td style="background-color: #babadc">1 day ago</td><td style="background-color: #babadc">"Jods, what's this Ali G person?"</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc">Balefire</td><td style="background-color: #babadc">638</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="26" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #babadc">5291</td><td style="background-color: #babadc">8.3</td><td style="background-color: #babadc">1 day ago</td><td style="background-color: #babadc">"Didn't you just transfer to become his CRA, Ris?"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(1197); ?></td><td style="background-color: #babadc">777</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #babadc">5271</td><td style="background-color: #babadc">6.8</td><td style="background-color: #babadc">1 day ago</td><td style="background-color: #babadc">"Yea, if it was Urick, I'd just 0 him out on principal. :P"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(168); ?></td><td style="background-color: #bbbbdb">514</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bbbbdb">4205</td><td style="background-color: #bbbbdb">8.2</td><td style="background-color: #bbbbdb">1 day ago</td><td style="background-color: #bbbbdb">"because a) our site sucks b) the news thing isn't updated enough"</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(1656); ?></td><td style="background-color: #bbbbdb">580</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #bbbbdb">4036</td><td style="background-color: #bbbbdb">7.0</td><td style="background-color: #bbbbdb">1 day ago</td><td style="background-color: #bbbbdb">"plus i can handle the motards :P"</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(108); ?></td><td style="background-color: #bbbbdb">486</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bbbbdb">2908</td><td style="background-color: #bbbbdb">6.0</td><td style="background-color: #bbbbdb">1 day ago</td><td style="background-color: #bbbbdb">"She's more tomboy than I am."</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(666); ?></td><td style="background-color: #bbbbdb">253</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #bbbbdb">2553</td><td style="background-color: #bbbbdb">10.1</td><td style="background-color: #bbbbdb">1 day ago</td><td style="background-color: #bbbbdb">"why wouldn't you want gnome-on-gnome porn?"</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(1551); ?></td><td style="background-color: #bcbcda">395</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bcbcda">2365</td><td style="background-color: #bcbcda">6.0</td><td style="background-color: #bcbcda">2 days ago</td><td style="background-color: #bcbcda">"what if it's like, 86°F out there today?"</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(1356); ?></td><td style="background-color: #bcbcda">356</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bcbcda">2248</td><td style="background-color: #bcbcda">6.3</td><td style="background-color: #bcbcda">1 day ago</td><td style="background-color: #bcbcda">"I got it all on record. =P "</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(2118); ?></td><td style="background-color: #bcbcda">306</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bcbcda">2189</td><td style="background-color: #bcbcda">7.2</td><td style="background-color: #bcbcda">1 day ago</td><td style="background-color: #bcbcda">"bananas in the mouth and everything?"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(1187); ?></td><td style="background-color: #bcbcda">209</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #bcbcda">2030</td><td style="background-color: #bcbcda">9.7</td><td style="background-color: #bcbcda">1 day ago</td><td style="background-color: #bcbcda">"bah, time for sleep so I don't get all sixxor"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(118); ?></td><td style="background-color: #bdbdda">251</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bdbdda">1800</td><td style="background-color: #bdbdda">7.2</td><td style="background-color: #bdbdda">1 day ago</td><td style="background-color: #bdbdda">"E and Slowie, sitting in a tree...Ka-aa-bal Au-thor-i-ty"</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9">`Prospero</td><td style="background-color: #bdbdd9">259</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #bdbdd9">1721</td><td style="background-color: #bdbdd9">6.6</td><td style="background-color: #bdbdd9">1 day ago</td><td style="background-color: #bdbdd9">"...that would blow, I don't know about that one."</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(1762); ?></td><td style="background-color: #bdbdd9">296</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bdbdd9">1559</td><td style="background-color: #bdbdd9">5.3</td><td style="background-color: #bdbdd9">2 days ago</td><td style="background-color: #bdbdd9">"No, so you should all probably go do that"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(747); ?></td><td style="background-color: #bdbdd9">246</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #bdbdd9">1483</td><td style="background-color: #bdbdd9">6.0</td><td style="background-color: #bdbdd9">4 days ago</td><td style="background-color: #bdbdd9">"shutup. just shutup. i don't need to hear any more maybe if's :p"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(1594); ?></td><td style="background-color: #bebed9">185</td><td style="background-color: #bebed9"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bebed9">1243</td><td style="background-color: #bebed9">6.7</td><td style="background-color: #bebed9">1 day ago</td><td style="background-color: #bebed9">"And thus Grav's HOMOSEXUAL AGENDA shows itself."</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8">Valhalla_Tyr</td><td style="background-color: #bebed8">134</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #bebed8">1092</td><td style="background-color: #bebed8">8.1</td><td style="background-color: #bebed8">3 days ago</td><td style="background-color: #bebed8">"E forgot to change something...it's been fixed now"</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(80); ?></td><td style="background-color: #bebed8">204</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="35" height="15" alt="" /></td><td style="background-color: #bebed8">1042</td><td style="background-color: #bebed8">5.1</td><td style="background-color: #bebed8">1 day ago</td><td style="background-color: #bebed8">"they used to have their warriors do it."</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8">FruitCak</td><td style="background-color: #bebed8">101</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="36" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bebed8">992</td><td style="background-color: #bebed8">9.8</td><td style="background-color: #bebed8">1 day ago</td><td style="background-color: #bebed8">"&lt;Jeedo&gt; Yes  Mrs.Miller.. :-/"</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8">`Mael</td><td style="background-color: #bfbfd8">177</td><td style="background-color: #bfbfd8"><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #bfbfd8">934</td><td style="background-color: #bfbfd8">5.3</td><td style="background-color: #bfbfd8">1 day ago</td><td style="background-color: #bfbfd8">"um...could you guys help me with outfitting my inflitrator?"</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8">GreaseMonkey</td><td style="background-color: #bfbfd8">158</td><td style="background-color: #bfbfd8"><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #bfbfd8">900</td><td style="background-color: #bfbfd8">5.7</td><td style="background-color: #bfbfd8">1 day ago</td><td style="background-color: #bfbfd8">"but it should be already in the menus"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7"><?php id(275); ?></td><td style="background-color: #bfbfd7">114</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bfbfd7">792</td><td style="background-color: #bfbfd7">6.9</td><td style="background-color: #bfbfd7">1 day ago</td><td style="background-color: #bfbfd7">"<a href="http://hometown.aol.com/herald1200/database/hodgecnvm.jpg" target="_blank" title="Open in new window: http://hometown.aol.com/herald1200/database/hodgecnvm.jpg">http://hometown.aol.com/herald1200/database/hodgecnvm.jpg</a>"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7">Velkro</td><td style="background-color: #bfbfd7">145</td><td style="background-color: #bfbfd7"><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bfbfd7">731</td><td style="background-color: #bfbfd7">5.0</td><td style="background-color: #bfbfd7">1 day ago</td><td style="background-color: #bfbfd7">"I still have to decide where I'm going too"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(1247); ?></td><td style="background-color: #c0c0d7">105</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c0c0d7">658</td><td style="background-color: #c0c0d7">6.3</td><td style="background-color: #c0c0d7">1 day ago</td><td style="background-color: #c0c0d7">"You gain inches in that too :P"</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(57); ?></td><td style="background-color: #c0c0d7">170</td><td style="background-color: #c0c0d7"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c0c0d7">620</td><td style="background-color: #c0c0d7">3.6</td><td style="background-color: #c0c0d7">1 day ago</td><td style="background-color: #c0c0d7">"be happy and move on with your life"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6"><?php id(1908); ?></td><td style="background-color: #c0c0d6">79</td><td style="background-color: #c0c0d6"><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #c0c0d6">608</td><td style="background-color: #c0c0d6">7.7</td><td style="background-color: #c0c0d6">1 day ago</td><td style="background-color: #c0c0d6">"Back now. "</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6">`Halc</td><td style="background-color: #c0c0d6">101</td><td style="background-color: #c0c0d6"><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #c0c0d6">593</td><td style="background-color: #c0c0d6">5.9</td><td style="background-color: #c0c0d6">1 day ago</td><td style="background-color: #c0c0d6">"Which total another like...6 hours of footage"</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(94); ?></td><td style="background-color: #c0c0d6">79</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c0c0d6">590</td><td style="background-color: #c0c0d6">7.5</td><td style="background-color: #c0c0d6">1 day ago</td><td style="background-color: #c0c0d6">"ooo And Now for somehting completely different is on tonight"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6"><?php id(331); ?></td><td style="background-color: #c1c1d6">84</td><td style="background-color: #c1c1d6"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c1c1d6">549</td><td style="background-color: #c1c1d6">6.5</td><td style="background-color: #c1c1d6">1 day ago</td><td style="background-color: #c1c1d6">"Pfft.  Sometimes quicker is good.  Otherwise my jaw gets sore."</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5"><?php id(366); ?></td><td style="background-color: #c1c1d5">57</td><td style="background-color: #c1c1d5"><img src="./green-h.png" border="0" width="35" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c1c1d5">540</td><td style="background-color: #c1c1d5">9.5</td><td style="background-color: #c1c1d5">1 day ago</td><td style="background-color: #c1c1d5">"So, you're stuck with whatever everyone else doesn't want."</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5"><?php id(1281); ?></td><td style="background-color: #c1c1d5">86</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c1c1d5">491</td><td style="background-color: #c1c1d5">5.7</td><td style="background-color: #c1c1d5">1 day ago</td><td style="background-color: #c1c1d5">"i aint never done either of them :-P"</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5">GradeMonkey</td><td style="background-color: #c1c1d5">39</td><td style="background-color: #c1c1d5"><img src="./green-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c1c1d5">482</td><td style="background-color: #c1c1d5">12.4</td><td style="background-color: #c1c1d5">6 days ago</td><td style="background-color: #c1c1d5">"my current favourite quote from an OM this time around:"</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5"><?php id(1036); ?></td><td style="background-color: #c2c2d5">48</td><td style="background-color: #c2c2d5"><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #c2c2d5">454</td><td style="background-color: #c2c2d5">9.5</td><td style="background-color: #c2c2d5">1 day ago</td><td style="background-color: #c2c2d5">"Well, I'm officially bored. Back to Halo 2 for me."</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5">^Mael</td><td style="background-color: #c2c2d5">71</td><td style="background-color: #c2c2d5"><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #c2c2d5">452</td><td style="background-color: #c2c2d5">6.4</td><td style="background-color: #c2c2d5">9 days ago</td><td style="background-color: #c2c2d5">"yea it was my latter statement that was more important :P"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4">`CC</td><td style="background-color: #c2c2d4">99</td><td style="background-color: #c2c2d4"><img src="./yellow-h.png" border="0" width="39" height="15" alt="" /></td><td style="background-color: #c2c2d4">407</td><td style="background-color: #c2c2d4">4.1</td><td style="background-color: #c2c2d4">1 day ago</td><td style="background-color: #c2c2d4">"banned from 2 chans he hangs in :p"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4">SweetLou</td><td style="background-color: #c2c2d4">38</td><td style="background-color: #c2c2d4"><img src="./red-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c2c2d4">403</td><td style="background-color: #c2c2d4">10.6</td><td style="background-color: #c2c2d4">8 days ago</td><td style="background-color: #c2c2d4">"Gotta love HBO...couple days ago, "The Goonies"...today, "Grind""</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4"><?php id(374); ?></td><td style="background-color: #c3c3d4">57</td><td style="background-color: #c3c3d4"><img src="./yellow-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c3c3d4">399</td><td style="background-color: #c3c3d4">7.0</td><td style="background-color: #c3c3d4">3 days ago</td><td style="background-color: #c3c3d4">"alrighty, off to class i go...joy, intro to religion..."</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(45); ?></td><td style="background-color: #c3c3d4">49</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #c3c3d4">372</td><td style="background-color: #c3c3d4">7.6</td><td style="background-color: #c3c3d4">1 day ago</td><td style="background-color: #c3c3d4">"there were some really good gfx this season"</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3"><?php id(229); ?></td><td style="background-color: #c3c3d3">41</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #c3c3d3">352</td><td style="background-color: #c3c3d3">8.6</td><td style="background-color: #c3c3d3">1 day ago</td><td style="background-color: #c3c3d3">"u r teh uberhomo roflmao pwned"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3">xelas</td><td style="background-color: #c3c3d3">49</td><td style="background-color: #c3c3d3"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="38" height="15" alt="" /></td><td style="background-color: #c3c3d3">321</td><td style="background-color: #c3c3d3">6.6</td><td style="background-color: #c3c3d3">4 days ago</td><td style="background-color: #c3c3d3">"I like john wayne more than eastwood, but either are good"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3">`xela</td><td style="background-color: #c4c4d3">37</td><td style="background-color: #c4c4d3"><img src="./yellow-h.png" border="0" width="36" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c4c4d3">291</td><td style="background-color: #c4c4d3">7.9</td><td style="background-color: #c4c4d3">6 days ago</td><td style="background-color: #c4c4d3">"Robro is lookin pretty good right now I guess... later all"</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3"><?php id(484); ?></td><td style="background-color: #c4c4d3">35</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="28" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c4c4d3">277</td><td style="background-color: #c4c4d3">7.9</td><td style="background-color: #c4c4d3">1 day ago</td><td style="background-color: #c4c4d3">"well, that didn't go too bad"</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(85); ?></td><td style="background-color: #c4c4d3">54</td><td style="background-color: #c4c4d3"><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c4c4d3">271</td><td style="background-color: #c4c4d3">5.0</td><td style="background-color: #c4c4d3">1 day ago</td><td style="background-color: #c4c4d3">"How's Phoenix these days, Cor?"</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2"><?php id(1219); ?></td><td style="background-color: #c4c4d2">48</td><td style="background-color: #c4c4d2"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c4c4d2">249</td><td style="background-color: #c4c4d2">5.2</td><td style="background-color: #c4c4d2">1 day ago</td><td style="background-color: #c4c4d2">"<a href="http://uploads.ungrounded.net/206000/206373_numanuma.swf" target="_blank" title="Open in new window: http://uploads.ungrounded.net/206000/206373_numanuma.swf">http://uploads.ungrounded.net/206000/206373_numanuma.swf</a>"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2"><?php id(1798); ?></td><td style="background-color: #c5c5d2">27</td><td style="background-color: #c5c5d2"><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c5c5d2">228</td><td style="background-color: #c5c5d2">8.4</td><td style="background-color: #c5c5d2">4 days ago</td><td style="background-color: #c5c5d2">"Dammit, Slag. Stop stealing my lines."</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2"><?php id(1699); ?></td><td style="background-color: #c5c5d2">36</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="31" height="15" alt="" /></td><td style="background-color: #c5c5d2">213</td><td style="background-color: #c5c5d2">5.9</td><td style="background-color: #c5c5d2">2 days ago</td><td style="background-color: #c5c5d2">"no, wait, i didn't mean it!"</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2">Thoth`</td><td style="background-color: #c5c5d2">25</td><td style="background-color: #c5c5d2"><img src="./red-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c5c5d2">194</td><td style="background-color: #c5c5d2">7.8</td><td style="background-color: #c5c5d2">4 days ago</td><td style="background-color: #c5c5d2">"It's unlikley you can do anything about it now."</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1"><?php id(2070); ?></td><td style="background-color: #c5c5d1">58</td><td style="background-color: #c5c5d1"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="37" height="15" alt="" /></td><td style="background-color: #c5c5d1">192</td><td style="background-color: #c5c5d1">3.3</td><td style="background-color: #c5c5d1">2 days ago</td><td style="background-color: #c5c5d1">"Love it or leave it I guess Dash..."</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1"><?php id(1843); ?></td><td style="background-color: #c6c6d1">17</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c6c6d1">191</td><td style="background-color: #c6c6d1">11.2</td><td style="background-color: #c6c6d1">1 day ago</td><td style="background-color: #c6c6d1">"i seriously need to rub Zed's face in it :P"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1">MARQ_Grandpa</td><td style="background-color: #c6c6d1">26</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c6c6d1">179</td><td style="background-color: #c6c6d1">6.9</td><td style="background-color: #c6c6d1">2 days ago</td><td style="background-color: #c6c6d1">"PARTY TIME!"</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1">Fayt`</td><td style="background-color: #c6c6d1">33</td><td style="background-color: #c6c6d1"><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #c6c6d1">171</td><td style="background-color: #c6c6d1">5.2</td><td style="background-color: #c6c6d1">3 days ago</td><td style="background-color: #c6c6d1">"I know you would figure i would hurry up and die already"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0">wkg</td><td style="background-color: #c6c6d0">23</td><td style="background-color: #c6c6d0"><img src="./green-h.png" border="0" width="38" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c6c6d0">168</td><td style="background-color: #c6c6d0">7.3</td><td style="background-color: #c6c6d0">5 days ago</td><td style="background-color: #c6c6d0">"Have Thunder ever come last ?"</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0"><?php id(1697); ?></td><td style="background-color: #c6c6d0">23</td><td style="background-color: #c6c6d0"><img src="./yellow-h.png" border="0" width="39" height="15" alt="" /></td><td style="background-color: #c6c6d0">165</td><td style="background-color: #c6c6d0">7.2</td><td style="background-color: #c6c6d0">8 days ago</td><td style="background-color: #c6c6d0">"or is that one of the IRC stats already?"</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0"><?php id(1829); ?></td><td style="background-color: #c7c7d0">32</td><td style="background-color: #c7c7d0"><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="33" height="15" alt="" /></td><td style="background-color: #c7c7d0">145</td><td style="background-color: #c7c7d0">4.5</td><td style="background-color: #c7c7d0">1 day ago</td><td style="background-color: #c7c7d0">"heh, buying a new one with it probably"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0"><?php id(242); ?></td><td style="background-color: #c7c7d0">18</td><td style="background-color: #c7c7d0"><img src="./green-h.png" border="0" width="34" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c7c7d0">133</td><td style="background-color: #c7c7d0">7.4</td><td style="background-color: #c7c7d0">6 days ago</td><td style="background-color: #c7c7d0">"she is here, doing all the tourist stuff"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0">JawaGrav`SVN</td><td style="background-color: #c7c7d0">24</td><td style="background-color: #c7c7d0"><img src="./red-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c7c7d0">132</td><td style="background-color: #c7c7d0">5.5</td><td style="background-color: #c7c7d0">3 days ago</td><td style="background-color: #c7c7d0">"What's the command line login for root?"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf"><?php id(1103); ?></td><td style="background-color: #c7c7cf">24</td><td style="background-color: #c7c7cf"><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c7c7cf">129</td><td style="background-color: #c7c7cf">5.4</td><td style="background-color: #c7c7cf">1 day ago</td><td style="background-color: #c7c7cf">"amazingly powerful power, that is."</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf">^Fyre</td><td style="background-color: #c8c8cf">11</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="27" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c8c8cf">127</td><td style="background-color: #c8c8cf">11.5</td><td style="background-color: #c8c8cf">1 day ago</td><td style="background-color: #c8c8cf">"He really is. He's a pompus ass, but very funny anyway."</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf"><?php id(123); ?></td><td style="background-color: #c8c8cf">22</td><td style="background-color: #c8c8cf"><img src="./red-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c8c8cf">126</td><td style="background-color: #c8c8cf">5.7</td><td style="background-color: #c8c8cf">1 day ago</td><td style="background-color: #c8c8cf">"yo"</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf"><?php id(495); ?></td><td style="background-color: #c8c8cf">15</td><td style="background-color: #c8c8cf"><img src="./yellow-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c8c8cf">116</td><td style="background-color: #c8c8cf">7.7</td><td style="background-color: #c8c8cf">3 days ago</td><td style="background-color: #c8c8cf">"RAWR!"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce">Xar`Kahn</td><td style="background-color: #c8c8ce">25</td><td style="background-color: #c8c8ce"><img src="./blue-h.png" border="0" width="37" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c8c8ce">114</td><td style="background-color: #c8c8ce">4.6</td><td style="background-color: #c8c8ce">1 day ago</td><td style="background-color: #c8c8ce">"Thats a cool Free JJ session"</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce">`Andre</td><td style="background-color: #c9c9ce">23</td><td style="background-color: #c9c9ce"><img src="./yellow-h.png" border="0" width="35" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c9c9ce">109</td><td style="background-color: #c9c9ce">4.7</td><td style="background-color: #c9c9ce">1 day ago</td><td style="background-color: #c9c9ce">"wow...the one after the one Orin just sent is awesome."</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce">Min|SB</td><td style="background-color: #c9c9ce">27</td><td style="background-color: #c9c9ce"><img src="./red-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c9c9ce">104</td><td style="background-color: #c9c9ce">3.9</td><td style="background-color: #c9c9ce">5 days ago</td><td style="background-color: #c9c9ce">"Don't get smug yet, you yankee bastard. =P"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce">`Webster</td><td style="background-color: #c9c9ce">14</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="36" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c9c9ce">101</td><td style="background-color: #c9c9ce">7.2</td><td style="background-color: #c9c9ce">1 day ago</td><td style="background-color: #c9c9ce">"What event ended tonight, IRC Hunt?"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce">Legion|Nyk</td><td style="background-color: #c9c9ce">13</td><td style="background-color: #c9c9ce"><img src="./yellow-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c9c9ce">100</td><td style="background-color: #c9c9ce">7.7</td><td style="background-color: #c9c9ce">5 days ago</td><td style="background-color: #c9c9ce">"well, my work is done here"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd">JawaRat</td><td style="background-color: #cacacd">10</td><td style="background-color: #cacacd"><img src="./red-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #cacacd">81</td><td style="background-color: #cacacd">8.1</td><td style="background-color: #cacacd">3 days ago</td><td style="background-color: #cacacd">"A little from column A, a little from Column B."</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd">Mael|AFK</td><td style="background-color: #cacacd">13</td><td style="background-color: #cacacd"><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="33" height="15" alt="" /></td><td style="background-color: #cacacd">58</td><td style="background-color: #cacacd">4.5</td><td style="background-color: #cacacd">1 day ago</td><td style="background-color: #cacacd">"its only the bad ones you cant forget"</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd"><?php id(494); ?></td><td style="background-color: #cacacd">16</td><td style="background-color: #cacacd"><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #cacacd">58</td><td style="background-color: #cacacd">3.6</td><td style="background-color: #cacacd">5 days ago</td><td style="background-color: #cacacd">"Yo."</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd">LunchBar</td><td style="background-color: #cacacd">5</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #cacacd">57</td><td style="background-color: #cacacd">11.4</td><td style="background-color: #cacacd">3 days ago</td><td style="background-color: #cacacd">"see, that's the beauty of it all. i don't want to be in film professionally, but i figured it'd be a kickarse course :P"</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc">`Xeon</td><td style="background-color: #cbcbcc">13</td><td style="background-color: #cbcbcc"><img src="./yellow-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #cbcbcc">49</td><td style="background-color: #cbcbcc">3.8</td><td style="background-color: #cbcbcc">1 day ago</td><td style="background-color: #cbcbcc">"Well, nevertheless, CC agreed with me :P"</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc"><?php id(1264); ?></td><td style="background-color: #cbcbcc">7</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="27" height="15" alt="" /></td><td style="background-color: #cbcbcc">42</td><td style="background-color: #cbcbcc">6.0</td><td style="background-color: #cbcbcc">1 day ago</td><td style="background-color: #cbcbcc">"rock on, dragon."</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc">Flash69</td><td style="background-color: #cbcbcc">15</td><td style="background-color: #cbcbcc"><img src="./green-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #cbcbcc">42</td><td style="background-color: #cbcbcc">2.8</td><td style="background-color: #cbcbcc">2 days ago</td><td style="background-color: #cbcbcc">"anything interesting happen?"</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc">Penishead</td><td style="background-color: #cbcbcc">2</td><td style="background-color: #cbcbcc"><img src="./red-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #cbcbcc">37</td><td style="background-color: #cbcbcc">18.5</td><td style="background-color: #cbcbcc">7 days ago</td><td style="background-color: #cbcbcc">"Life is endlessly entertaining in its daily absurdity."</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc"><?php id(1700); ?></td><td style="background-color: #cccccc">9</td><td style="background-color: #cccccc"><img src="./yellow-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #cccccc">32</td><td style="background-color: #cccccc">3.6</td><td style="background-color: #cccccc">3 days ago</td><td style="background-color: #cccccc">"moo"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10">Soup_Nazi (30)</td>
<td class="rankc10">jawaJodo (30)</td>
<td class="rankc10">OneEyedWilly (28)</td>
<td class="rankc10"><?php id(1636); ?> (23)</td>
<td class="rankc10">AFKal-Torak (21)</td>
</tr><tr>
<td class="rankc10">Legion| (21)</td>
<td class="rankc10"><?php id(16); ?> (19)</td>
<td class="rankc10">Huzzah_Jax (18)</td>
<td class="rankc10">Grease|ZzZ (18)</td>
<td class="rankc10"><?php id(370); ?> (16)</td>
</tr><tr>
<td class="rankc10">Neji` (15)</td>
<td class="rankc10">wolenstein (15)</td>
<td class="rankc10">Grav`HW (14)</td>
<td class="rankc10">Jer-Venkman (13)</td>
<td class="rankc10"><?php id(1198); ?> (12)</td>
</tr><tr>
<td class="rankc10">Mael|SOLO (12)</td>
<td class="rankc10">JawaProsp (11)</td>
<td class="rankc10"><?php id(1772); ?> (11)</td>
<td class="rankc10">Aitrus (10)</td>
<td class="rankc10"><?php id(1678); ?> (10)</td>
</tr><tr>
<td class="rankc10">Jorddyn (8)</td>
<td class="rankc10">Damnuvile (8)</td>
<td class="rankc10">taco_time (8)</td>
<td class="rankc10">Chro|Slave (8)</td>
<td class="rankc10">Slow-KA (7)</td>
</tr><tr>
<td class="rankc10">JawaRe (7)</td>
<td class="rankc10">JK|Working (6)</td>
<td class="rankc10"><?php id(1332); ?> (6)</td>
<td class="rankc10">`Nighty (6)</td>
<td class="rankc10">Chro|w3t (5)</td>
</tr><tr>
<td class="rankc10">Halc|Away (4)</td>
<td class="rankc10">`Jukers (4)</td>
<td class="rankc10">TalkyMeat (4)</td>
<td class="rankc10">`Zethy|busy (4)</td>
<td class="rankc10">Alomax (3)</td>
</tr><tr>
<td class="rankc10">jawaDet (3)</td>
<td class="rankc10">`Trent (2)</td>
<td class="rankc10">Halc|FW (2)</td>
<td class="rankc10">Fayt|Gone (2)</td>
<td class="rankc10">Necrolord (2)</td>
</tr></table>
<br /><b>By the way, there were 8 other nicks.</b><br />
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

<tr><td class="hicell">Is <b><?php id(1187); ?></b> stupid or just asking too many questions?  19.6% lines contained a question!
<br /><span class="small"><b><?php id(1356); ?></b> didn't know that much either.  18.2% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b>Valhalla_Tyr</b>, who yelled 19.4% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(118); ?></b>, who shouted 13.5% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b><?php id(80); ?></b>'s shift-key is hanging:  2.4% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[12:55] &lt;Jodo&gt; KK!
</span><br />
<br /><span class="small"><b><?php id(118); ?></b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 2.3% of the time.</span>
</td></tr>
<tr><td class="hicell"><b>GreaseMonkey</b> is a very aggressive person.  He/She attacked others <b>4</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[15:10] Action: GreaseMonkey smacks Xela
</span><br />
<br /><span class="small"><b><?php id(80); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>2</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(1218); ?></b>, nobody likes him/her.  He/She was attacked <b>2</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[17:54] Action: Krug kills the pink flesh monkeys!
</span><br />
<br /><span class="small"><b>Min</b> seems to be unliked too.  He/She got beaten <b>1</b> times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1356); ?></b> brings happiness to the world.  49.7% lines contained smiling faces.  :)
<br /><span class="small"><b><?php id(1625); ?></b> isn't a sad person either, smiling 40.5% of the time.</span>
</td></tr>
<tr><td class="hicell"><b>FruitCak</b> seems to be sad at the moment:  0.9% lines contained sad faces.  :(
<br /><span class="small"><b><?php id(1551); ?></b> is also a sad person, crying 0.7% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(2122); ?></b> wrote the longest lines, averaging 54.5 letters per line.<br />
<span class="small">#bhg average was 37.7 letters per line.</span></td></tr>
<tr><td class="hicell"><b><?php id(57); ?></b> wrote the shortest lines, averaging 17.0 characters per line.<br />
<span class="small"><b><?php id(80); ?></b> was tight-lipped, too, averaging 24.6 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(2122); ?></b> spoke a total of 10424 words!
<br /><span class="small"><?php id(2122); ?>'s faithful follower, <b><?php id(1625); ?></b>, didn't speak so much: 9110 words.</span>
</td></tr>
<tr><td class="hicell"><b>Penishead</b> wrote an average of 18.50 words per line.
<br /><span class="small">Channel average was 7.38 words per line.</span>
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
<td class="hicell"><?php id(1085); ?></td>
<td class="hicell">2803</td>
<td class="hicell"><?php id(2122); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(1218); ?></td>
<td class="hicell">2505</td>
<td class="hicell"><?php id(1197); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(300); ?></td>
<td class="hicell">299</td>
<td class="hicell"><?php id(1625); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(25); ?></td>
<td class="hicell">271</td>
<td class="hicell"><?php id(80); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">think</td>
<td class="hicell">233</td>
<td class="hicell"><?php id(80); ?></td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">about</td>
<td class="hicell">210</td>
<td class="hicell"><?php id(1625); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">really</td>
<td class="hicell">161</td>
<td class="hicell"><?php id(1625); ?></td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">there</td>
<td class="hicell">149</td>
<td class="hicell"><?php id(1356); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">actually</td>
<td class="hicell">146</td>
<td class="hicell"><?php id(1908); ?></td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">should</td>
<td class="hicell">144</td>
<td class="hicell"><?php id(2122); ?></td>
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
<td class="hicell"><?php id(1700); ?></td>
<td class="hicell">1239</td>
<td class="hicell"><?php id(168); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(1281); ?></td>
<td class="hicell">416</td>
<td class="hicell"><?php id(80); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(1332); ?></td>
<td class="hicell">278</td>
<td class="hicell"><?php id(80); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(45); ?></td>
<td class="hicell">175</td>
<td class="hicell"><?php id(108); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(1197); ?></td>
<td class="hicell">147</td>
<td class="hicell"><?php id(1656); ?></td>
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
<td class="hicell"><a href="http://www.vgcats.com/comics/?strip_id=110">http://www.vgcats.com/comics/?strip_id=110</a></td>
<td class="hicell">2</td>
<td class="hicell"><?php id(57); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://www.anakar.org/Kag.html">http://www.anakar.org/Kag.html</a></td>
<td class="hicell">2</td>
<td class="hicell">Valhalla_Tyr</td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://members.cox.net/dasrat/Bograt2.jpg">http://members.cox.net/dasrat/Bograt2.jpg</a></td>
<td class="hicell">2</td>
<td class="hicell"><?php id(2122); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://www.extraugly.com/shirt.php?design=0063">http://www.extraugly.com/shirt.php?design=0063</a></td>
<td class="hicell">2</td>
<td class="hicell"><?php id(1625); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://www.bash.org/?166956">http://www.bash.org/?166956</a></td>
<td class="hicell">2</td>
<td class="hicell"><?php id(666); ?></td>
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

<tr><td class="hicell"><b>FruitCak</b> wasn't very popular, getting kicked 3 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[00:57] FruitCak kicked from #bhg by Jernai: *pow*
</span><br />
<br /><span class="small"><b><?php id(57); ?></b> seemed to be hated too:  2 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> is either insane or just a fair op, kicking a total of 11 people!
<br /><span class="small">LawnGnome's faithful follower, <b><?php id(2122); ?></b>, kicked about 9 people.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(2122); ?></b> donated 6 ops in the channel...
<br /><span class="small"><b><?php id(1197); ?></b> was also very polite: 1 ops from him/her.</span>
</td></tr>
<tr><td class="hicell">Wow, no op was taken on #bhg!</td></tr>
<tr><td class="hicell"><b>Balefire</b> always lets us know what he/she's doing: 63 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[03:42] Action: Balefire also glares balefully at his timezone.
</span><br />
<br /><span class="small">Also, <b><?php id(1625); ?></b> tells us what's up with 32 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(2118); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 2 times!
<br /><span class="small">Another lonely one was <b><?php id(666); ?></b>, who managed to hit 2 times.</span>
</td></tr>
<tr><td class="hicell"><b>`Prospero</b> couldn't decide whether to stay or go.  119 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b><?php id(494); ?></b> has quite a potty mouth.  1.7% words were foul language.
<br /><span class="small"><b>FruitCak</b> also makes sailors blush, 1.0% of the time.</span>
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

<tr><td class="hicell"><i>Apply for TACT. Details on the MB. | Dragon win KAG XX with 2,315 points | <a href="http://boards.thebhg.org/index.php?op=view&amp;topic=8104" target="_blank" title="Open in new window: http://boards.thebhg.org/index.php?op=view&amp;topic=8104">http://boards.thebhg.org/index.php?op=view&amp;topic=8104</a></i></td>
<td class="hicell"><b>by <?php id(1197); ?> on 03:16</b></td></tr>
<tr><td class="hicell"><i>Apply for TACT. Details on the MB. | Dragon win KAG XX with 2,315 points</i></td>
<td class="hicell"><b>by <?php id(1197); ?> on 17:04</b></td></tr>
<tr><td class="hicell"><i>Apply for TACT. Details on the MB. | Dragon win KAG XX:  Dragon:1,946,Phoenix:1,591,Cyclone: 1,517, Skylla: 1,491, Daichi: 1,324, Omega: 889, Thunder: 782. | Fr</i></td>
<td class="hicell"><b>by <?php id(45); ?> on 16:53</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 27 times.</td></tr>
</table>
Total number of lines: 14155.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 00 minutes and 11 seconds
</span>
</div>
</body>
</html>

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
Statistics generated on  Tuesday 2 September 2003 - 1:33:46
<br />During this 31-day reporting period, a total of <b>590</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">5.5%<br /><img src="./blue-v.png" width="15" height="86.7333901192504" alt="5.5" /></td>

<td align="center" valign="bottom" class="asmall">5.0%<br /><img src="./blue-v.png" width="15" height="77.6937819420784" alt="5.0" /></td>

<td align="center" valign="bottom" class="asmall">4.0%<br /><img src="./blue-v.png" width="15" height="63.1814310051107" alt="4.0" /></td>

<td align="center" valign="bottom" class="asmall">3.5%<br /><img src="./blue-v.png" width="15" height="54.5357751277683" alt="3.5" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./blue-v.png" width="15" height="58.9224872231687" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">1.8%<br /><img src="./blue-v.png" width="15" height="29.3441226575809" alt="1.8" /></td>

<td align="center" valign="bottom" class="asmall">1.4%<br /><img src="./green-v.png" width="15" height="21.912265758092" alt="1.4" /></td>

<td align="center" valign="bottom" class="asmall">2.1%<br /><img src="./green-v.png" width="15" height="32.5596252129472" alt="2.1" /></td>

<td align="center" valign="bottom" class="asmall">2.4%<br /><img src="./green-v.png" width="15" height="37.4361158432709" alt="2.4" /></td>

<td align="center" valign="bottom" class="asmall">2.6%<br /><img src="./green-v.png" width="15" height="40.4173764906303" alt="2.6" /></td>

<td align="center" valign="bottom" class="asmall">3.7%<br /><img src="./green-v.png" width="15" height="58.677597955707" alt="3.7" /></td>

<td align="center" valign="bottom" class="asmall">5.0%<br /><img src="./green-v.png" width="15" height="77.5979557069847" alt="5.0" /></td>

<td align="center" valign="bottom" class="asmall">4.0%<br /><img src="./yellow-v.png" width="15" height="63.4369676320273" alt="4.0" /></td>

<td align="center" valign="bottom" class="asmall">3.9%<br /><img src="./yellow-v.png" width="15" height="60.9028960817717" alt="3.9" /></td>

<td align="center" valign="bottom" class="asmall">5.1%<br /><img src="./yellow-v.png" width="15" height="79.6954855195911" alt="5.1" /></td>

<td align="center" valign="bottom" class="asmall">4.5%<br /><img src="./yellow-v.png" width="15" height="70.8581771720613" alt="4.5" /></td>

<td align="center" valign="bottom" class="asmall">5.2%<br /><img src="./yellow-v.png" width="15" height="81.399063032368" alt="5.2" /></td>

<td align="center" valign="bottom" class="asmall">3.9%<br /><img src="./yellow-v.png" width="15" height="61.7120954003407" alt="3.9" /></td>

<td align="center" valign="bottom" class="asmall">4.4%<br /><img src="./red-v.png" width="15" height="69.1333049403748" alt="4.4" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./red-v.png" width="15" height="65.1831345826235" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">5.3%<br /><img src="./red-v.png" width="15" height="82.4318568994889" alt="5.3" /></td>

<td align="center" valign="bottom" class="asmall">5.4%<br /><img src="./red-v.png" width="15" height="84.7210391822828" alt="5.4" /></td>

<td align="center" valign="bottom" class="asmall">5.1%<br /><img src="./red-v.png" width="15" height="79.1737649063032" alt="5.1" /></td>

<td align="center" valign="bottom" class="asmall">6.4%<br /><img src="./red-v.png" width="15" height="100" alt="6.4" /></td>

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
<td style="background-color: #babadc"><?php id(57); ?></td><td style="background-color: #babadc">13006</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #babadc">72184</td><td style="background-color: #babadc">5.6</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"cause it's 9 in the morning"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(1625); ?></td><td style="background-color: #babadc">10446</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #babadc">63090</td><td style="background-color: #babadc">6.0</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"[21:30] &lt;D_Shadow&gt; you  too :D"</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(168); ?></td><td style="background-color: #babadc">6058</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #babadc">48475</td><td style="background-color: #babadc">8.0</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Don't correct me when I don't need correcting, egg boy :P"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(1551); ?></td><td style="background-color: #babadc">6380</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #babadc">40057</td><td style="background-color: #babadc">6.3</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"They have their periods on their guitars? Nasty."</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(1197); ?></td><td style="background-color: #bbbbdb">7798</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bbbbdb">38607</td><td style="background-color: #bbbbdb">5.0</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"she settled down fast too :P"</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(242); ?></td><td style="background-color: #bbbbdb">4461</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bbbbdb">28189</td><td style="background-color: #bbbbdb">6.3</td><td style="background-color: #bbbbdb">8 days ago</td><td style="background-color: #bbbbdb">"genno, they are no more slanted than the whore of babylon NBC :P"</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(95); ?></td><td style="background-color: #bbbbdb">3008</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bbbbdb">23838</td><td style="background-color: #bbbbdb">7.9</td><td style="background-color: #bbbbdb">1 day ago</td><td style="background-color: #bbbbdb">"so take advantage of her weakened state tal"</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(1247); ?></td><td style="background-color: #bbbbdb">3803</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="22" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #bbbbdb">23350</td><td style="background-color: #bbbbdb">6.1</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"anyway, im really going into the shower now"</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(331); ?></td><td style="background-color: #bcbcda">4809</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bcbcda">21606</td><td style="background-color: #bcbcda">4.5</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"more than one PHP god exists"</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(2029); ?></td><td style="background-color: #bcbcda">2501</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="35" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bcbcda">17687</td><td style="background-color: #bcbcda">7.1</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"for something completely different!"</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(370); ?></td><td style="background-color: #bcbcda">2635</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #bcbcda">16379</td><td style="background-color: #bcbcda">6.2</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"LPeacock: <a href="http://pc.ign.com/articles/128/128565p1.html?fromint=1" target="_blank" title="Open in new window: http://pc.ign.com/articles/128/128565p1.html?fromint=1">http://pc.ign.com/articles/128/128565p1.html?fromint=1</a>"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(1754); ?></td><td style="background-color: #bcbcda">3060</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #bcbcda">15710</td><td style="background-color: #bcbcda">5.1</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"there's no marl right now, so nobody, i guess"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(1187); ?></td><td style="background-color: #bdbdda">2172</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #bdbdda">15169</td><td style="background-color: #bdbdda">7.0</td><td style="background-color: #bdbdda">Today</td><td style="background-color: #bdbdda">"yes, and a fort isn't that"</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9">Sayo</td><td style="background-color: #bdbdd9">1606</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bdbdd9">13977</td><td style="background-color: #bdbdd9">8.7</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"Motti, I'm serious, screw off..."</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(1103); ?></td><td style="background-color: #bdbdd9">2166</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #bdbdd9">12916</td><td style="background-color: #bdbdd9">6.0</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"holo--you're still in-game, aren't you?"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(2118); ?></td><td style="background-color: #bdbdd9">2386</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #bdbdd9">12731</td><td style="background-color: #bdbdd9">5.3</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"Lars i was just playing with friends who are going to college"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(666); ?></td><td style="background-color: #bebed9">1411</td><td style="background-color: #bebed9"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bebed9">12237</td><td style="background-color: #bebed9">8.7</td><td style="background-color: #bebed9">Today</td><td style="background-color: #bebed9">"gee, that's an good question"</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8"><?php id(1762); ?></td><td style="background-color: #bebed8">2378</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #bebed8">11801</td><td style="background-color: #bebed8">5.0</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"Oooh spermie shaped things"</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(1908); ?></td><td style="background-color: #bebed8">2121</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bebed8">10322</td><td style="background-color: #bebed8">4.9</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"wtf? Don't stay on, all night. :P"</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(23); ?></td><td style="background-color: #bebed8">1435</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bebed8">10222</td><td style="background-color: #bebed8">7.1</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"That's what my ringtone should be!"</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8"><?php id(1699); ?></td><td style="background-color: #bfbfd8">2164</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #bfbfd8">9945</td><td style="background-color: #bfbfd8">4.6</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"sounds like mamamia by abba, only not :P"</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(135); ?></td><td style="background-color: #bfbfd8">1355</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #bfbfd8">9424</td><td style="background-color: #bfbfd8">7.0</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"you idiots just give me a headache, I needed a break :P"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7">FruitCak</td><td style="background-color: #bfbfd7">975</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #bfbfd7">8562</td><td style="background-color: #bfbfd7">8.8</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"your mind does not work like our human minds"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7"><?php id(1198); ?></td><td style="background-color: #bfbfd7">1506</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bfbfd7">7056</td><td style="background-color: #bfbfd7">4.7</td><td style="background-color: #bfbfd7">4 days ago</td><td style="background-color: #bfbfd7">"I won, didn't i?  I know I did."</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(94); ?></td><td style="background-color: #c0c0d7">771</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="27" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c0c0d7">6800</td><td style="background-color: #c0c0d7">8.8</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"it'll look pretty much identical but it'll work :)"</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(484); ?></td><td style="background-color: #c0c0d7">1084</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c0c0d7">6618</td><td style="background-color: #c0c0d7">6.1</td><td style="background-color: #c0c0d7">8 days ago</td><td style="background-color: #c0c0d7">"aww, damn... i thought he was gonna be disappointed :P"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6"><?php id(1772); ?></td><td style="background-color: #c0c0d6">1224</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="20" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c0c0d6">5795</td><td style="background-color: #c0c0d6">4.7</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"Brave New World wasn't that bad."</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6"><?php id(85); ?></td><td style="background-color: #c0c0d6">874</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c0c0d6">5271</td><td style="background-color: #c0c0d6">6.0</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"It'll end up like Slicer's monthly OMs :P"</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(258); ?></td><td style="background-color: #c0c0d6">836</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c0c0d6">5008</td><td style="background-color: #c0c0d6">6.0</td><td style="background-color: #c0c0d6">2 days ago</td><td style="background-color: #c0c0d6">"I am about to put a yahoo personal online"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6"><?php id(16); ?></td><td style="background-color: #c1c1d6">477</td><td style="background-color: #c1c1d6"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c1c1d6">4860</td><td style="background-color: #c1c1d6">10.2</td><td style="background-color: #c1c1d6">Today</td><td style="background-color: #c1c1d6">"ahh, I love the soound of thunder accomplanying lightning"</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5"><?php id(118); ?></td><td style="background-color: #c1c1d5">536</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c1c1d5">4663</td><td style="background-color: #c1c1d5">8.7</td><td style="background-color: #c1c1d5">3 days ago</td><td style="background-color: #c1c1d5">"yeah...I guess they just needed a guy who could act and was old."</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5"><?php id(275); ?></td><td style="background-color: #c1c1d5">656</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="24" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c1c1d5">4469</td><td style="background-color: #c1c1d5">6.8</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"you know what we need in the ROs? a recurring villain."</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5"><?php id(747); ?></td><td style="background-color: #c1c1d5">957</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c1c1d5">4170</td><td style="background-color: #c1c1d5">4.4</td><td style="background-color: #c1c1d5">2 days ago</td><td style="background-color: #c1c1d5">"yeah but why should a jackass take me in?"</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5"><?php id(1583); ?></td><td style="background-color: #c2c2d5">596</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c2c2d5">3925</td><td style="background-color: #c2c2d5">6.6</td><td style="background-color: #c2c2d5">2 days ago</td><td style="background-color: #c2c2d5">"just use the search option :Þ"</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5"><?php id(1722); ?></td><td style="background-color: #c2c2d5">914</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c2c2d5">3897</td><td style="background-color: #c2c2d5">4.3</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"i want you gen oh baby oh baby"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(473); ?></td><td style="background-color: #c2c2d4">758</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c2c2d4">3717</td><td style="background-color: #c2c2d4">4.9</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"Lets see how many n00bs will go to goatse.cx :P"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4">Tnsumi</td><td style="background-color: #c2c2d4">566</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c2c2d4">3430</td><td style="background-color: #c2c2d4">6.1</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"been reading me fight with Nyk?"</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4"><?php id(2006); ?></td><td style="background-color: #c3c3d4">569</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c3c3d4">3237</td><td style="background-color: #c3c3d4">5.7</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"How many points do you want to have in Sabacc? +/- 23?"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4">Prospero</td><td style="background-color: #c3c3d4">484</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c3c3d4">3055</td><td style="background-color: #c3c3d4">6.3</td><td style="background-color: #c3c3d4">4 days ago</td><td style="background-color: #c3c3d4">"hot and techie are mutually exclusive traits"</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3"><?php id(1264); ?></td><td style="background-color: #c3c3d3">588</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c3c3d3">2979</td><td style="background-color: #c3c3d3">5.1</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"and.. i found xp and office x"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3"><?php id(1627); ?></td><td style="background-color: #c3c3d3">626</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c3c3d3">2972</td><td style="background-color: #c3c3d3">4.7</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"and have sex with female wolfs"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3">Slowie</td><td style="background-color: #c4c4d3">1076</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c4c4d3">2816</td><td style="background-color: #c4c4d3">2.6</td><td style="background-color: #c4c4d3">20 days ago</td><td style="background-color: #c4c4d3">"the first appearence of the beamer is in FH2: Refugee"</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3"><?php id(1489); ?></td><td style="background-color: #c4c4d3">576</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c4c4d3">2680</td><td style="background-color: #c4c4d3">4.7</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"he would be shut down as soon as they thought he was a monopoly"</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(1219); ?></td><td style="background-color: #c4c4d3">612</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #c4c4d3">2620</td><td style="background-color: #c4c4d3">4.3</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"well you could just added "</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2">Utopiate</td><td style="background-color: #c4c4d2">403</td><td style="background-color: #c4c4d2"><img src="./blue-h.png" border="0" width="36" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c4c4d2">2574</td><td style="background-color: #c4c4d2">6.4</td><td style="background-color: #c4c4d2">19 days ago</td><td style="background-color: #c4c4d2">"it kind of goes nuts there at the end."</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2"><?php id(229); ?></td><td style="background-color: #c5c5d2">289</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c5c5d2">2572</td><td style="background-color: #c5c5d2">8.9</td><td style="background-color: #c5c5d2">11 days ago</td><td style="background-color: #c5c5d2">"i get about 800 every two weeks."</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2"><?php id(45); ?></td><td style="background-color: #c5c5d2">344</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #c5c5d2">2569</td><td style="background-color: #c5c5d2">7.5</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"we meet next sat for the scores ;P"</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2">Slow-guy</td><td style="background-color: #c5c5d2">971</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c5c5d2">2367</td><td style="background-color: #c5c5d2">2.4</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"they're all afraid of Thunder!"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1"><?php id(1803); ?></td><td style="background-color: #c5c5d1">472</td><td style="background-color: #c5c5d1"><img src="./blue-h.png" border="0" width="31" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c5c5d1">2277</td><td style="background-color: #c5c5d1">4.8</td><td style="background-color: #c5c5d1">2 days ago</td><td style="background-color: #c5c5d1">"you're meeting Sen this christmas?"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1">Reaply</td><td style="background-color: #c6c6d1">388</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c6c6d1">2275</td><td style="background-color: #c6c6d1">5.9</td><td style="background-color: #c6c6d1">6 days ago</td><td style="background-color: #c6c6d1">"Zed: what about the XBOX s controller?"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1">^Fyre</td><td style="background-color: #c6c6d1">238</td><td style="background-color: #c6c6d1"><img src="./yellow-h.png" border="0" width="25" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c6c6d1">2266</td><td style="background-color: #c6c6d1">9.5</td><td style="background-color: #c6c6d1">1 day ago</td><td style="background-color: #c6c6d1">"Well yeah, but he got all that magic and whatnot."</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1">`Lonestar</td><td style="background-color: #c6c6d1">255</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c6c6d1">2228</td><td style="background-color: #c6c6d1">8.7</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"shoot... 2500 isn't a square... is it"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0">DamnSexy</td><td style="background-color: #c6c6d0">390</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c6c6d0">2068</td><td style="background-color: #c6c6d0">5.3</td><td style="background-color: #c6c6d0">3 days ago</td><td style="background-color: #c6c6d0">"Det: and are you coming to be with me at U of A?"</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0"><?php id(141); ?></td><td style="background-color: #c6c6d0">411</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c6c6d0">2031</td><td style="background-color: #c6c6d0">4.9</td><td style="background-color: #c6c6d0">4 days ago</td><td style="background-color: #c6c6d0">"meh. im going to go find a movie to watch"</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0"><?php id(1873); ?></td><td style="background-color: #c7c7d0">402</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c7c7d0">2017</td><td style="background-color: #c7c7d0">5.0</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"dude most outstanding god? what for?"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0"><?php id(1085); ?></td><td style="background-color: #c7c7d0">364</td><td style="background-color: #c7c7d0"><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c7c7d0">1896</td><td style="background-color: #c7c7d0">5.2</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"Yeh, but I'm too lazy to do anything in TH anyhow. :P"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0"><?php id(14); ?></td><td style="background-color: #c7c7d0">306</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="25" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c7c7d0">1882</td><td style="background-color: #c7c7d0">6.2</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"Well... a little.  But no oral!"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf">FruitCak_</td><td style="background-color: #c7c7cf">205</td><td style="background-color: #c7c7cf"><img src="./blue-h.png" border="0" width="33" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c7c7cf">1863</td><td style="background-color: #c7c7cf">9.1</td><td style="background-color: #c7c7cf">11 days ago</td><td style="background-color: #c7c7cf">"lxg looks pretty forgettable"</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf"><?php id(1717); ?></td><td style="background-color: #c8c8cf">480</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c8c8cf">1862</td><td style="background-color: #c8c8cf">3.9</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"just tired only got 5 hours of sleep last night"</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf"><?php id(1594); ?></td><td style="background-color: #c8c8cf">497</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c8c8cf">1815</td><td style="background-color: #c8c8cf">3.7</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"it's 5% code, 95% suck... probably."</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf">`Sayo</td><td style="background-color: #c8c8cf">217</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="35" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c8c8cf">1776</td><td style="background-color: #c8c8cf">8.2</td><td style="background-color: #c8c8cf">7 days ago</td><td style="background-color: #c8c8cf">"Oh, shiznit, 4:20 AM...brb"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce"><?php id(2131); ?></td><td style="background-color: #c8c8ce">320</td><td style="background-color: #c8c8ce"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c8c8ce">1657</td><td style="background-color: #c8c8ce">5.2</td><td style="background-color: #c8c8ce">Today</td><td style="background-color: #c8c8ce">"no i mean normal accesses, are they also that ip?"</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce">Fyre</td><td style="background-color: #c9c9ce">192</td><td style="background-color: #c9c9ce"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #c9c9ce">1611</td><td style="background-color: #c9c9ce">8.4</td><td style="background-color: #c9c9ce">1 day ago</td><td style="background-color: #c9c9ce">"Well, the database is safe,"</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce"><?php id(1135); ?></td><td style="background-color: #c9c9ce">205</td><td style="background-color: #c9c9ce"><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="29" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c9c9ce">1493</td><td style="background-color: #c9c9ce">7.3</td><td style="background-color: #c9c9ce">1 day ago</td><td style="background-color: #c9c9ce">"I also have a Saracen blade and a few Moorish Daggers"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce">^SyNthPHP</td><td style="background-color: #c9c9ce">281</td><td style="background-color: #c9c9ce"><img src="./green-h.png" border="0" width="26" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c9c9ce">1490</td><td style="background-color: #c9c9ce">5.3</td><td style="background-color: #c9c9ce">4 days ago</td><td style="background-color: #c9c9ce">"i'm kinda recoding the entire KA hunts"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce">basilisk</td><td style="background-color: #c9c9ce">206</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c9c9ce">1451</td><td style="background-color: #c9c9ce">7.0</td><td style="background-color: #c9c9ce">19 days ago</td><td style="background-color: #c9c9ce">"you thinking maybe of slice, grav?"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd">SanSri</td><td style="background-color: #cacacd">290</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #cacacd">1421</td><td style="background-color: #cacacd">4.9</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"I stayed untill 7 in the morning once"</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd">AppleFish</td><td style="background-color: #cacacd">352</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="25" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #cacacd">1316</td><td style="background-color: #cacacd">3.7</td><td style="background-color: #cacacd">5 days ago</td><td style="background-color: #cacacd">"make it different and on land"</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd">Zed||REG</td><td style="background-color: #cacacd">177</td><td style="background-color: #cacacd"><img src="./yellow-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #cacacd">1244</td><td style="background-color: #cacacd">7.0</td><td style="background-color: #cacacd">26 days ago</td><td style="background-color: #cacacd">"I think I know what it means.  Will have to figure it out"</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd">`peer</td><td style="background-color: #cacacd">151</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="29" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #cacacd">1184</td><td style="background-color: #cacacd">7.8</td><td style="background-color: #cacacd">1 day ago</td><td style="background-color: #cacacd">"not really a town, it's actually riley township."</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc">DmSxyPrez</td><td style="background-color: #cbcbcc">291</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #cbcbcc">1168</td><td style="background-color: #cbcbcc">4.0</td><td style="background-color: #cbcbcc">10 days ago</td><td style="background-color: #cbcbcc">"i could kick your butt with kirby any day ;)"</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc"><?php id(264); ?></td><td style="background-color: #cbcbcc">248</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #cbcbcc">1091</td><td style="background-color: #cbcbcc">4.4</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"drive a freakin tank up Master Chief's ass"</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc">Motti|SSL</td><td style="background-color: #cbcbcc">137</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #cbcbcc">1077</td><td style="background-color: #cbcbcc">7.9</td><td style="background-color: #cbcbcc">27 days ago</td><td style="background-color: #cbcbcc">"remind me to smack the bejesus out of sayo."</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc"><?php id(34); ?></td><td style="background-color: #cbcbcc">157</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="23" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #cbcbcc">1068</td><td style="background-color: #cbcbcc">6.8</td><td style="background-color: #cbcbcc">5 days ago</td><td style="background-color: #cbcbcc">"bin ages since I've bin in here"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc"><?php id(1843); ?></td><td style="background-color: #cccccc">214</td><td style="background-color: #cccccc"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #cccccc">1025</td><td style="background-color: #cccccc">4.8</td><td style="background-color: #cccccc">Today</td><td style="background-color: #cccccc">"i aint going through every channel again today"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10">Darus77 (956)</td>
<td class="rankc10"><?php id(1133); ?> (903)</td>
<td class="rankc10">Pendragon (887)</td>
<td class="rankc10">Sl0w13 (836)</td>
<td class="rankc10">T20004X (835)</td>
</tr><tr>
<td class="rankc10">`Haz\w0k (826)</td>
<td class="rankc10"><?php id(1218); ?> (817)</td>
<td class="rankc10"><?php id(1225); ?> (813)</td>
<td class="rankc10">archie` (800)</td>
<td class="rankc10">NykRO (756)</td>
</tr><tr>
<td class="rankc10"><?php id(2070); ?> (745)</td>
<td class="rankc10">peer-AFK (731)</td>
<td class="rankc10">MKeeon (719)</td>
<td class="rankc10">Sayo|RO (710)</td>
<td class="rankc10"><?php id(374); ?> (655)</td>
</tr><tr>
<td class="rankc10">BJava (653)</td>
<td class="rankc10"><?php id(1356); ?> (650)</td>
<td class="rankc10">^Bean` (644)</td>
<td class="rankc10"><?php id(1561); ?> (630)</td>
<td class="rankc10"><?php id(1677); ?> (617)</td>
</tr><tr>
<td class="rankc10">JohnHyde (616)</td>
<td class="rankc10"><?php id(152); ?> (608)</td>
<td class="rankc10">Mal|away (605)</td>
<td class="rankc10">Kraide (604)</td>
<td class="rankc10">cerpntaxt (601)</td>
</tr><tr>
<td class="rankc10"><?php id(488); ?> (561)</td>
<td class="rankc10"><?php id(182); ?> (537)</td>
<td class="rankc10">T2Kevin (527)</td>
<td class="rankc10">Leventhal (517)</td>
<td class="rankc10"><?php id(1943); ?> (513)</td>
</tr><tr>
<td class="rankc10"><?php id(1276); ?> (506)</td>
<td class="rankc10">DonnyRoge (478)</td>
<td class="rankc10"><?php id(1036); ?> (476)</td>
<td class="rankc10"><?php id(80); ?> (442)</td>
<td class="rankc10">Sayo|IWAT (438)</td>
</tr><tr>
<td class="rankc10"><?php id(1332); ?> (435)</td>
<td class="rankc10">`Haztix` (426)</td>
<td class="rankc10">TheBadGuy (410)</td>
<td class="rankc10"><?php id(1700); ?> (409)</td>
<td class="rankc10">Naiht (406)</td>
</tr></table>
<br /><b>By the way, there were 475 other nicks.</b><br />
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

<tr><td class="hicell">Is <b>Sayo|RO</b> stupid or just asking too many questions?  30% lines contained a question!
<br /><span class="small"><b>Sayo</b> didn't know that much either.  23.7% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(488); ?></b>, who yelled 90.2% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(1943); ?></b>, who shouted 32.3% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b><?php id(1843); ?></b>'s shift-key is hanging:  10.7% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[06:24] &lt;Shayde&gt; G!
</span><br />
<br /><span class="small"><b><?php id(1717); ?></b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 8.1% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(57); ?></b> is a very aggressive person.  He/She attacked others <b>67</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[18:26] Action: Genno kills Sleuthe ded
</span><br />
<br /><span class="small"><b>DonnyRoge</b> can't control his/her aggressions, either.  He/She picked on others <b>26</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(1197); ?></b>, nobody likes him/her.  He/She was attacked <b>26</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[02:33] Action: `Motti` kicks Grav with a steel-toed boot
</span><br />
<br /><span class="small"><b><?php id(1218); ?></b> seems to be unliked too.  He/She got beaten <b>22</b> times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1700); ?></b> brings happiness to the world.  52.2% lines contained smiling faces.  :)
<br /><span class="small"><b><?php id(1908); ?></b> isn't a sad person either, smiling 45.6% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(16); ?></b> seems to be sad at the moment:  2.3% lines contained sad faces.  :(
<br /><span class="small"><b><?php id(1103); ?></b> is also a sad person, crying 2.0% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(16); ?></b> wrote the longest lines, averaging 52.0 letters per line.<br />
<span class="small">#bhg average was 29.5 letters per line.</span></td></tr>
<tr><td class="hicell"><b>Slow-guy</b> wrote the shortest lines, averaging 11.2 characters per line.<br />
<span class="small"><b>Sl0w13</b> was tight-lipped, too, averaging 11.8 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(57); ?></b> spoke a total of 72184 words!
<br /><span class="small"><?php id(57); ?>'s faithful follower, <b><?php id(1625); ?></b>, didn't speak so much: 63090 words.</span>
</td></tr>
<tr><td class="hicell"><b>`Pen|AFK</b> wrote an average of 22.00 words per line.
<br /><span class="small">Channel average was 5.86 words per line.</span>
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
<td class="hicell">3453</td>
<td class="hicell"><?php id(1625); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell">about</td>
<td class="hicell">2000</td>
<td class="hicell"><?php id(1873); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell">think</td>
<td class="hicell">1836</td>
<td class="hicell"><?php id(2118); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell">there</td>
<td class="hicell">1459</td>
<td class="hicell"><?php id(1197); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">would</td>
<td class="hicell">1297</td>
<td class="hicell"><?php id(57); ?></td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">people</td>
<td class="hicell">1249</td>
<td class="hicell"><?php id(1754); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">should</td>
<td class="hicell">1141</td>
<td class="hicell"><?php id(57); ?></td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">right</td>
<td class="hicell">1110</td>
<td class="hicell"><?php id(1754); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">going</td>
<td class="hicell">1095</td>
<td class="hicell"><?php id(57); ?></td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">still</td>
<td class="hicell">1049</td>
<td class="hicell"><?php id(85); ?></td>
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
<td class="hicell">23859</td>
<td class="hicell"><?php id(23); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(1218); ?></td>
<td class="hicell">21347</td>
<td class="hicell"><?php id(1625); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(1281); ?></td>
<td class="hicell">4057</td>
<td class="hicell"><?php id(1103); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(300); ?></td>
<td class="hicell">2615</td>
<td class="hicell">Det|work</td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(1332); ?></td>
<td class="hicell">2306</td>
<td class="hicell"><?php id(666); ?></td>
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
<td class="hicell"><?php id(135); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://blogs.thebhg.org/mygoalinlifeisworlddominatrix/">http://blogs.thebhg.org/mygoalinlifeisworlddominatrix/</a></td>
<td class="hicell">6</td>
<td class="hicell"><?php id(1551); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://www.dempire.org">http://www.dempire.org</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(331); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://citadel.thebhg.org/new/">http://citadel.thebhg.org/new/</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(94); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://homestarrunner.com/sbemail58.html">http://homestarrunner.com/sbemail58.html</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(370); ?></td>
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

<tr><td class="hicell"><b><?php id(57); ?></b> wasn't very popular, getting kicked 33 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[22:20] Walldawg kicked from #bhg by Tuss: Walldawg
</span><br />
<br /><span class="small"><b><?php id(1625); ?></b> seemed to be hated too:  27 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1625); ?></b> is either insane or just a fair op, kicking a total of 72 people!
<br /><span class="small"><?php id(1625); ?>'s faithful follower, <b>LawnGnome</b>, kicked about 69 people.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> donated 36 ops in the channel...
<br /><span class="small"><b><?php id(1247); ?></b> was also very polite: 24 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> is the channel sheriff with 10 deops.
<br /><span class="small"><b><?php id(1625); ?></b> deoped 7 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(57); ?></b> always lets us know what he/she's doing: 2334 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[22:54] Action: WD|SLEEP gets pellginS Award
</span><br />
<br /><span class="small">Also, <b><?php id(1625); ?></b> tells us what's up with 883 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(57); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 79 times!
<br /><span class="small">Another lonely one was <b><?php id(1625); ?></b>, who managed to hit 62 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(57); ?></b> couldn't decide whether to stay or go.  263 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>Necrolord</b> has quite a potty mouth.  2.5% words were foul language.
<br /><span class="small"><b>`Quack</b> also makes sailors blush, 1.8% of the time.</span>
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

<tr><td class="hicell"><i>New Citadel Site Up: <a href="http://citadel.thebhg.org/" target="_blank" title="Open in new window: http://citadel.thebhg.org/">http://citadel.thebhg.org/</a> | Post in your Arena Battles | Dont post if you want to make my life easy</i></td>
<td class="hicell"><b>by <?php id(1247); ?> on 08:17</b></td></tr>
<tr><td class="hicell"><i>New Citadel Site Up: <a href="http://citadel.thebhg.org/" target="_blank" title="Open in new window: http://citadel.thebhg.org/">http://citadel.thebhg.org/</a> || People post in your Arena Battles</i></td>
<td class="hicell"><b>by <?php id(275); ?> on 08:17</b></td></tr>
<tr><td class="hicell"><i>New Citadel Site Up: <a href="http://citadel.thebhg.org/" target="_blank" title="Open in new window: http://citadel.thebhg.org/">http://citadel.thebhg.org/</a> || People post in your Arena Battles || SSL hopefully unbroken, DSM now broke.</i></td>
<td class="hicell"><b>by LGnome on 05:15</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 213 times.</td></tr>
</table>
Total number of lines: 145526.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 02 minutes and 47 seconds
</span>
</div>
</body>
</html>

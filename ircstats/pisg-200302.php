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
Statistics generated on  Monday 10 March 2003 - 8:30:14
<br />During this 28-day reporting period, a total of <b>602</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./blue-v.png" width="15" height="74.6966019417476" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./blue-v.png" width="15" height="75.5339805825243" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">4.4%<br /><img src="./blue-v.png" width="15" height="67.2087378640777" alt="4.4" /></td>

<td align="center" valign="bottom" class="asmall">3.4%<br /><img src="./blue-v.png" width="15" height="51.8810679611651" alt="3.4" /></td>

<td align="center" valign="bottom" class="asmall">3.2%<br /><img src="./blue-v.png" width="15" height="49.5509708737864" alt="3.2" /></td>

<td align="center" valign="bottom" class="asmall">3.2%<br /><img src="./blue-v.png" width="15" height="49.4538834951456" alt="3.2" /></td>

<td align="center" valign="bottom" class="asmall">2.9%<br /><img src="./green-v.png" width="15" height="44.5145631067961" alt="2.9" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./green-v.png" width="15" height="48.4344660194175" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">3.9%<br /><img src="./green-v.png" width="15" height="60.5703883495146" alt="3.9" /></td>

<td align="center" valign="bottom" class="asmall">3.3%<br /><img src="./green-v.png" width="15" height="50.3398058252427" alt="3.3" /></td>

<td align="center" valign="bottom" class="asmall">3.0%<br /><img src="./green-v.png" width="15" height="46.2014563106796" alt="3.0" /></td>

<td align="center" valign="bottom" class="asmall">4.1%<br /><img src="./green-v.png" width="15" height="63.0218446601942" alt="4.1" /></td>

<td align="center" valign="bottom" class="asmall">2.9%<br /><img src="./yellow-v.png" width="15" height="45" alt="2.9" /></td>

<td align="center" valign="bottom" class="asmall">3.0%<br /><img src="./yellow-v.png" width="15" height="45.9587378640777" alt="3.0" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./yellow-v.png" width="15" height="58.3980582524272" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./yellow-v.png" width="15" height="64.1868932038835" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">4.8%<br /><img src="./yellow-v.png" width="15" height="73.7014563106796" alt="4.8" /></td>

<td align="center" valign="bottom" class="asmall">4.6%<br /><img src="./yellow-v.png" width="15" height="70.1334951456311" alt="4.6" /></td>

<td align="center" valign="bottom" class="asmall">4.6%<br /><img src="./red-v.png" width="15" height="70.254854368932" alt="4.6" /></td>

<td align="center" valign="bottom" class="asmall">4.7%<br /><img src="./red-v.png" width="15" height="72.2330097087379" alt="4.7" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./red-v.png" width="15" height="59.1504854368932" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">5.2%<br /><img src="./red-v.png" width="15" height="80.0242718446602" alt="5.2" /></td>

<td align="center" valign="bottom" class="asmall">6.5%<br /><img src="./red-v.png" width="15" height="100" alt="6.5" /></td>

<td align="center" valign="bottom" class="asmall">5.7%<br /><img src="./red-v.png" width="15" height="86.9053398058252" alt="5.7" /></td>

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
<td class="hirankc10center" align="center">22</td>
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
<td style="background-color: #babadc"><?php id(1551); ?></td><td style="background-color: #babadc">3876</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #babadc">23882</td><td style="background-color: #babadc">6.2</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Enter Sandman by Metallica, outcasty,"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(473); ?></td><td style="background-color: #babadc">4602</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #babadc">20398</td><td style="background-color: #babadc">4.4</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"I think I made Round 1 HTH too hard. :P"</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(57); ?></td><td style="background-color: #babadc">2893</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #babadc">19795</td><td style="background-color: #babadc">6.8</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"skor and DK took a bit too long getting back on track"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(1247); ?></td><td style="background-color: #babadc">3811</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="22" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #babadc">18818</td><td style="background-color: #babadc">4.9</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"cause of the sexual innuendo :P"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(370); ?></td><td style="background-color: #bbbbdb">2908</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #bbbbdb">18067</td><td style="background-color: #bbbbdb">6.2</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"have they stopped breathing yet?"</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(331); ?></td><td style="background-color: #bbbbdb">4186</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bbbbdb">17301</td><td style="background-color: #bbbbdb">4.1</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"Now, I could see Koral as intimidating."</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(168); ?></td><td style="background-color: #bbbbdb">1932</td><td style="background-color: #bbbbdb"><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #bbbbdb">17235</td><td style="background-color: #bbbbdb">8.9</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"About Wyatt Earp giving up the law and moving to Tombstone"</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(1754); ?></td><td style="background-color: #bbbbdb">2780</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bbbbdb">14330</td><td style="background-color: #bbbbdb">5.2</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"what's Keith David's name in the credits?"</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(484); ?></td><td style="background-color: #bcbcda">2313</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bcbcda">13917</td><td style="background-color: #bcbcda">6.0</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"and i think comforter is babyish :P"</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(666); ?></td><td style="background-color: #bcbcda">1420</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="28" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bcbcda">13475</td><td style="background-color: #bcbcda">9.5</td><td style="background-color: #bcbcda">1 day ago</td><td style="background-color: #bcbcda">"Only two action figures left! You'd better hurry!"</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(1829); ?></td><td style="background-color: #bcbcda">3166</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bcbcda">13009</td><td style="background-color: #bcbcda">4.1</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"aeris!!!!!!!!!!!!!!!!!!!!!!!!!!2"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(1594); ?></td><td style="background-color: #bcbcda">3226</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bcbcda">12862</td><td style="background-color: #bcbcda">4.0</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"c'mon... which would he say? :P"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(2029); ?></td><td style="background-color: #bdbdda">2045</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="27" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #bdbdda">12798</td><td style="background-color: #bdbdda">6.3</td><td style="background-color: #bdbdda">3 days ago</td><td style="background-color: #bdbdda">"krail has NO pants! liars!"</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9"><?php id(94); ?></td><td style="background-color: #bdbdd9">1280</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #bdbdd9">11685</td><td style="background-color: #bdbdd9">9.1</td><td style="background-color: #bdbdd9">7 days ago</td><td style="background-color: #bdbdd9">"you do realise anyone with 100 to 199 can just op themselves?"</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(747); ?></td><td style="background-color: #bdbdd9">3008</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="24" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #bdbdd9">11084</td><td style="background-color: #bdbdd9">3.7</td><td style="background-color: #bdbdd9">2 days ago</td><td style="background-color: #bdbdd9">"sorry, my computer froze on me as i was typing that. ;P"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(23); ?></td><td style="background-color: #bdbdd9">1636</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bdbdd9">10070</td><td style="background-color: #bdbdd9">6.2</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"until you apologize to the voices in your head"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(135); ?></td><td style="background-color: #bebed9">1513</td><td style="background-color: #bebed9"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #bebed9">9878</td><td style="background-color: #bebed9">6.5</td><td style="background-color: #bebed9">Today</td><td style="background-color: #bebed9">"it would appear Ender has a new nick :P"</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8">LuckyLep</td><td style="background-color: #bebed8">1988</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bebed8">9875</td><td style="background-color: #bebed8">5.0</td><td style="background-color: #bebed8">3 days ago</td><td style="background-color: #bebed8">"What's wrong with Lesbians? :P"</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(95); ?></td><td style="background-color: #bebed8">1068</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #bebed8">8643</td><td style="background-color: #bebed8">8.1</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"and we're nothing more than his testicles"</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(1187); ?></td><td style="background-color: #bebed8">1073</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bebed8">7970</td><td style="background-color: #bebed8">7.4</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"the creds I spent are still gone, but I have NO FREAKEN ARMOR"</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8"><?php id(1413); ?></td><td style="background-color: #bfbfd8">1673</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="27" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bfbfd8">7848</td><td style="background-color: #bfbfd8">4.7</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"You aren't like the others..."</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(242); ?></td><td style="background-color: #bfbfd8">1133</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #bfbfd8">7719</td><td style="background-color: #bfbfd8">6.8</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"that is me, even after 6 years of experience :P"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7"><?php id(11); ?></td><td style="background-color: #bfbfd7">978</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="22" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #bfbfd7">7535</td><td style="background-color: #bfbfd7">7.7</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"it was that little clown Nenshou who started the CS bashing"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7"><?php id(1762); ?></td><td style="background-color: #bfbfd7">1505</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bfbfd7">7483</td><td style="background-color: #bfbfd7">5.0</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"Grr...must string up Tuss by his toes"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7">NindoF</td><td style="background-color: #c0c0d7">1205</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="31" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c0c0d7">7374</td><td style="background-color: #c0c0d7">6.1</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"Jer, you have to be kidding."</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(1332); ?></td><td style="background-color: #c0c0d7">1884</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c0c0d7">7192</td><td style="background-color: #c0c0d7">3.8</td><td style="background-color: #c0c0d7">1 day ago</td><td style="background-color: #c0c0d7">"yay... more haphazard wee coding:p"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6">h0lo</td><td style="background-color: #c0c0d6">1203</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="22" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c0c0d6">7043</td><td style="background-color: #c0c0d6">5.9</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"that's the challenge, blodah"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6"><?php id(1625); ?></td><td style="background-color: #c0c0d6">1129</td><td style="background-color: #c0c0d6"><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c0c0d6">6337</td><td style="background-color: #c0c0d6">5.6</td><td style="background-color: #c0c0d6">3 days ago</td><td style="background-color: #c0c0d6">"yeah, no use bothering with it..."</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(1699); ?></td><td style="background-color: #c0c0d6">1298</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c0c0d6">6004</td><td style="background-color: #c0c0d6">4.6</td><td style="background-color: #c0c0d6">1 day ago</td><td style="background-color: #c0c0d6">"do it now, or face a temp ban :P"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6"><?php id(16); ?></td><td style="background-color: #c1c1d6">631</td><td style="background-color: #c1c1d6"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c1c1d6">5941</td><td style="background-color: #c1c1d6">9.4</td><td style="background-color: #c1c1d6">Today</td><td style="background-color: #c1c1d6">"that will enver stop everyone from doing it though"</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5"><?php id(118); ?></td><td style="background-color: #c1c1d5">781</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c1c1d5">5856</td><td style="background-color: #c1c1d5">7.5</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"FBAP had the Pressly Playboy pics on it..."</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5"><?php id(1843); ?></td><td style="background-color: #c1c1d5">1800</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c1c1d5">5832</td><td style="background-color: #c1c1d5">3.2</td><td style="background-color: #c1c1d5">1 day ago</td><td style="background-color: #c1c1d5">"cause i aint getting a replky"</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5">^SyNth</td><td style="background-color: #c1c1d5">1476</td><td style="background-color: #c1c1d5"><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #c1c1d5">5756</td><td style="background-color: #c1c1d5">3.9</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"er...i'll call you s.t. from now on, kay?"</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5"><?php id(229); ?></td><td style="background-color: #c2c2d5">645</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c2c2d5">5751</td><td style="background-color: #c2c2d5">8.9</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"the first Diablo was hard. ;P"</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5"><?php id(2118); ?></td><td style="background-color: #c2c2d5">986</td><td style="background-color: #c2c2d5"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="27" height="15" alt="" /></td><td style="background-color: #c2c2d5">5744</td><td style="background-color: #c2c2d5">5.8</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"he was in Of Mice and Men movie too"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(577); ?></td><td style="background-color: #c2c2d4">1136</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c2c2d4">5644</td><td style="background-color: #c2c2d4">5.0</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"he said use them as door stops"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4"><?php id(1085); ?></td><td style="background-color: #c2c2d4">1636</td><td style="background-color: #c2c2d4"><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c2c2d4">5614</td><td style="background-color: #c2c2d4">3.4</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"Take a cardboard tube the diameter of a plunger."</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4">FruitCak</td><td style="background-color: #c3c3d4">475</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c3c3d4">4804</td><td style="background-color: #c3c3d4">10.1</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"<a href="http://www.ehnet.org/mb/viewtopic.php?t=3849" target="_blank" title="Open in new window: http://www.ehnet.org/mb/viewtopic.php?t=3849">http://www.ehnet.org/mb/viewtopic.php?t=3849</a>"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(275); ?></td><td style="background-color: #c3c3d4">695</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="24" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c3c3d4">4379</td><td style="background-color: #c3c3d4">6.3</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"thank me once I actaully do it."</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3">^Fyre</td><td style="background-color: #c3c3d3">402</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c3c3d3">3453</td><td style="background-color: #c3c3d3">8.6</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"Ah ha! Knew I would get a real answer out of him!"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3">Adian</td><td style="background-color: #c3c3d3">537</td><td style="background-color: #c3c3d3"><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c3c3d3">3228</td><td style="background-color: #c3c3d3">6.0</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"give me a minute to get merc"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3"><?php id(1171); ?></td><td style="background-color: #c4c4d3">1003</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c4c4d3">3082</td><td style="background-color: #c4c4d3">3.1</td><td style="background-color: #c4c4d3">2 days ago</td><td style="background-color: #c4c4d3">"<a href="http://www.starwars.com/eu/news/2003/02/news20030220.html" target="_blank" title="Open in new window: http://www.starwars.com/eu/news/2003/02/news20030220.html">http://www.starwars.com/eu/news/2003/02/news20030220.html</a>"</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3"><?php id(1356); ?></td><td style="background-color: #c4c4d3">460</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c4c4d3">2952</td><td style="background-color: #c4c4d3">6.4</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"but still clothes being ripped off..."</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(182); ?></td><td style="background-color: #c4c4d3">434</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c4c4d3">2869</td><td style="background-color: #c4c4d3">6.6</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"so are you implying that IS's produce dumb people?"</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2">Kailani</td><td style="background-color: #c4c4d2">635</td><td style="background-color: #c4c4d2"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="28" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c4c4d2">2856</td><td style="background-color: #c4c4d2">4.5</td><td style="background-color: #c4c4d2">6 days ago</td><td style="background-color: #c4c4d2">"i like to play fighting games tho"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2">deathw</td><td style="background-color: #c5c5d2">501</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="28" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c5c5d2">2853</td><td style="background-color: #c5c5d2">5.7</td><td style="background-color: #c5c5d2">2 days ago</td><td style="background-color: #c5c5d2">"have to leave at the moment"</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2">JackRippd</td><td style="background-color: #c5c5d2">515</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="26" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c5c5d2">2786</td><td style="background-color: #c5c5d2">5.4</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"I need a better name for my armour tho"</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2">MaraHarle</td><td style="background-color: #c5c5d2">511</td><td style="background-color: #c5c5d2"><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c5c5d2">2717</td><td style="background-color: #c5c5d2">5.3</td><td style="background-color: #c5c5d2">1 day ago</td><td style="background-color: #c5c5d2">"why you always gotta pick on me"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1"><?php id(1943); ?></td><td style="background-color: #c5c5d1">801</td><td style="background-color: #c5c5d1"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c5c5d1">2634</td><td style="background-color: #c5c5d1">3.3</td><td style="background-color: #c5c5d1">Today</td><td style="background-color: #c5c5d1">"do I have to moon you again holo?"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1">`MK</td><td style="background-color: #c6c6d1">422</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c6c6d1">2628</td><td style="background-color: #c6c6d1">6.2</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"Genno it's called "regional dialect" :P"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1"><?php id(1218); ?></td><td style="background-color: #c6c6d1">456</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c6c6d1">2585</td><td style="background-color: #c6c6d1">5.7</td><td style="background-color: #c6c6d1">1 day ago</td><td style="background-color: #c6c6d1">"It was all a twisted, torrid triangle of lust."</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1">Necrolord</td><td style="background-color: #c6c6d1">548</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./green-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c6c6d1">2569</td><td style="background-color: #c6c6d1">4.7</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"so i guess I didn't get the web hunt right?"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0">Cruento</td><td style="background-color: #c6c6d0">249</td><td style="background-color: #c6c6d0"><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c6c6d0">2552</td><td style="background-color: #c6c6d0">10.2</td><td style="background-color: #c6c6d0">3 days ago</td><td style="background-color: #c6c6d0">"otherwise... not really..."</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0">_-Mage-_</td><td style="background-color: #c6c6d0">428</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c6c6d0">2547</td><td style="background-color: #c6c6d0">6.0</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"Technically, it's masked swearing, Ninj."</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0"><?php id(141); ?></td><td style="background-color: #c7c7d0">458</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="24" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c7c7d0">2545</td><td style="background-color: #c7c7d0">5.6</td><td style="background-color: #c7c7d0">3 days ago</td><td style="background-color: #c7c7d0">"kailani... your tal's gf right?"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0">Raithe</td><td style="background-color: #c7c7d0">236</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c7c7d0">2539</td><td style="background-color: #c7c7d0">10.8</td><td style="background-color: #c7c7d0">15 days ago</td><td style="background-color: #c7c7d0">"i'm not the one singing ghostbusters at least :P"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0">Sayo</td><td style="background-color: #c7c7d0">373</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c7c7d0">2505</td><td style="background-color: #c7c7d0">6.7</td><td style="background-color: #c7c7d0">2 days ago</td><td style="background-color: #c7c7d0">"I hope you mean happy in that context.."</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf">Reapster</td><td style="background-color: #c7c7cf">548</td><td style="background-color: #c7c7cf"><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c7c7cf">2483</td><td style="background-color: #c7c7cf">4.5</td><td style="background-color: #c7c7cf">6 days ago</td><td style="background-color: #c7c7cf">" JRNY/JediJawa/Disavowed/BHG -VET (SCB) {CORE-CH} "</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf">Xar_</td><td style="background-color: #c8c8cf">469</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="31" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c8c8cf">2345</td><td style="background-color: #c8c8cf">5.0</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"but you have to go island hopping"</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf"><?php id(1908); ?></td><td style="background-color: #c8c8cf">508</td><td style="background-color: #c8c8cf"><img src="./yellow-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c8c8cf">2160</td><td style="background-color: #c8c8cf">4.3</td><td style="background-color: #c8c8cf">10 days ago</td><td style="background-color: #c8c8cf">"alls I need is a bottle of wine, and a lighter :P *evil grin* :P"</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf">tammi</td><td style="background-color: #c8c8cf">396</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="38" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c8c8cf">2159</td><td style="background-color: #c8c8cf">5.5</td><td style="background-color: #c8c8cf">12 days ago</td><td style="background-color: #c8c8cf">"by the name of kadiatcha will appear on #bhg soon"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce">`Dagger</td><td style="background-color: #c8c8ce">335</td><td style="background-color: #c8c8ce"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="31" height="15" alt="" /></td><td style="background-color: #c8c8ce">1957</td><td style="background-color: #c8c8ce">5.8</td><td style="background-color: #c8c8ce">Today</td><td style="background-color: #c8c8ce">"oh...well that explains something"</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce">Brad Tack</td><td style="background-color: #c9c9ce">365</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="25" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c9c9ce">1894</td><td style="background-color: #c9c9ce">5.2</td><td style="background-color: #c9c9ce">7 days ago</td><td style="background-color: #c9c9ce">"I hate shifting, I really do."</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce">XenoFord</td><td style="background-color: #c9c9ce">296</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="29" height="15" alt="" /></td><td style="background-color: #c9c9ce">1878</td><td style="background-color: #c9c9ce">6.3</td><td style="background-color: #c9c9ce">9 days ago</td><td style="background-color: #c9c9ce">"Heya Nyk, Brackage"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce">Skorbles</td><td style="background-color: #c9c9ce">384</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c9c9ce">1862</td><td style="background-color: #c9c9ce">4.8</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"because his friends are psychos"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce"><?php id(1798); ?></td><td style="background-color: #c9c9ce">267</td><td style="background-color: #c9c9ce"><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c9c9ce">1835</td><td style="background-color: #c9c9ce">6.9</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"No, Zed. Go buy them for me. :P"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd">Reapsta</td><td style="background-color: #cacacd">395</td><td style="background-color: #cacacd"><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #cacacd">1742</td><td style="background-color: #cacacd">4.4</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"actually...I'm just gonna go find something to do "</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd"><?php id(1722); ?></td><td style="background-color: #cacacd">440</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #cacacd">1722</td><td style="background-color: #cacacd">3.9</td><td style="background-color: #cacacd">5 days ago</td><td style="background-color: #cacacd">"but i was writing as an Imp"</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd">MiniElf</td><td style="background-color: #cacacd">457</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #cacacd">1701</td><td style="background-color: #cacacd">3.7</td><td style="background-color: #cacacd">3 days ago</td><td style="background-color: #cacacd">"CB: I know that numbnuts :P"</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd"><?php id(14); ?></td><td style="background-color: #cacacd">274</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #cacacd">1698</td><td style="background-color: #cacacd">6.2</td><td style="background-color: #cacacd">1 day ago</td><td style="background-color: #cacacd">"Chicago was pretty damn good, actually."</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc"><?php id(1583); ?></td><td style="background-color: #cbcbcc">274</td><td style="background-color: #cbcbcc"><img src="./green-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #cbcbcc">1688</td><td style="background-color: #cbcbcc">6.2</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"and and then you got that baby robin"</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc">Fyre</td><td style="background-color: #cbcbcc">186</td><td style="background-color: #cbcbcc"><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="31" height="15" alt="" /></td><td style="background-color: #cbcbcc">1646</td><td style="background-color: #cbcbcc">8.8</td><td style="background-color: #cbcbcc">1 day ago</td><td style="background-color: #cbcbcc">"From their viewpoint, we split. From ours, they did."</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc">NvM</td><td style="background-color: #cbcbcc">202</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #cbcbcc">1549</td><td style="background-color: #cbcbcc">7.7</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">""One People, One Empire, One Leader!""</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc">rissybleh</td><td style="background-color: #cbcbcc">395</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="31" height="15" alt="" /></td><td style="background-color: #cbcbcc">1512</td><td style="background-color: #cbcbcc">3.8</td><td style="background-color: #cbcbcc">10 days ago</td><td style="background-color: #cbcbcc">"yay im getting red streaks in my hair next weekend!!!"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc">Ender`</td><td style="background-color: #cccccc">290</td><td style="background-color: #cccccc"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #cccccc">1414</td><td style="background-color: #cccccc">4.9</td><td style="background-color: #cccccc">Today</td><td style="background-color: #cccccc">"yeah 8 legged freaks....sucks"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10"><?php id(1133); ?> (1275)</td>
<td class="rankc10">`S-Tiger (1264)</td>
<td class="rankc10"><?php id(295); ?> (1247)</td>
<td class="rankc10">`Idaho (1211)</td>
<td class="rankc10"><?php id(80); ?> (1153)</td>
</tr><tr>
<td class="rankc10"><?php id(45); ?> (1102)</td>
<td class="rankc10"><?php id(366); ?> (1029)</td>
<td class="rankc10">SOSchlong (971)</td>
<td class="rankc10">EarloWang (945)</td>
<td class="rankc10"><?php id(1219); ?> (942)</td>
</tr><tr>
<td class="rankc10">tamz (939)</td>
<td class="rankc10">Also-Busy (913)</td>
<td class="rankc10">`Syde_sHo (893)</td>
<td class="rankc10">`STupid (883)</td>
<td class="rankc10"><?php id(183); ?> (824)</td>
</tr><tr>
<td class="rankc10">HolyFord (812)</td>
<td class="rankc10">TheThe (811)</td>
<td class="rankc10"><?php id(152); ?> (800)</td>
<td class="rankc10"><?php id(765); ?> (762)</td>
<td class="rankc10">M`aR`k (695)</td>
</tr><tr>
<td class="rankc10"><?php id(1276); ?> (692)</td>
<td class="rankc10"><?php id(1281); ?> (674)</td>
<td class="rankc10"><?php id(2131); ?> (674)</td>
<td class="rankc10">Trilliaon (667)</td>
<td class="rankc10">outcasted (645)</td>
</tr><tr>
<td class="rankc10">MK (642)</td>
<td class="rankc10">MrRCW (628)</td>
<td class="rankc10"><?php id(2070); ?> (618)</td>
<td class="rankc10"><?php id(1264); ?> (616)</td>
<td class="rankc10">Urban (614)</td>
</tr><tr>
<td class="rankc10">Jer-stump (601)</td>
<td class="rankc10">Jan-Dead (584)</td>
<td class="rankc10">`Cyrax (566)</td>
<td class="rankc10"><?php id(1064); ?> (560)</td>
<td class="rankc10">ArcAngel` (559)</td>
</tr><tr>
<td class="rankc10">[Food] (549)</td>
<td class="rankc10"><?php id(1627); ?> (545)</td>
<td class="rankc10">Conana (511)</td>
<td class="rankc10">____-away (502)</td>
<td class="rankc10">holobrb (483)</td>
</tr></table>
<br /><b>By the way, there were 487 other nicks.</b><br />
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

<tr><td class="hicell">Is <b>Raithe</b> stupid or just asking too many questions?  27.9% lines contained a question!
<br /><span class="small"><b>Sayo</b> didn't know that much either.  25.7% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(1943); ?></b>, who yelled 39.8% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(2070); ?></b>, who shouted 33.6% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b><?php id(1843); ?></b>'s shift-key is hanging:  11.8% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[05:38] &lt;Shayde&gt; SKOR!!!!!!!!!!!!!
</span><br />
<br /><span class="small"><b>MiniElf</b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 11.8% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> is a very aggressive person.  He/She attacked others <b>32</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[13:47] Action: `Conan kills Farscape
</span><br />
<br /><span class="small"><b><?php id(2029); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>32</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(1198); ?></b>, nobody likes him/her.  He/She was attacked <b>35</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[14:59] Action: `Conan kills the internet and replaces it with a system that works
</span><br />
<br /><span class="small"><b>conan</b> seems to be unliked too.  He/She got beaten <b>29</b> times.</span>
</td></tr>
<tr><td class="hicell"><b>Cruento</b> brings happiness to the world.  48.1% lines contained smiling faces.  :)
<br /><span class="small"><b><?php id(1908); ?></b> isn't a sad person either, smiling 44.8% of the time.</span>
</td></tr>
<tr><td class="hicell"><b>SOSchlong</b> seems to be sad at the moment:  2.2% lines contained sad faces.  :(
<br /><span class="small"><b>`MK</b> is also a sad person, crying 2.1% of the time.</span>
</td></tr>
<tr><td class="hicell"><b>`Idaho</b> wrote the longest lines, averaging 60.5 letters per line.<br />
<span class="small">#bhg average was 27.7 letters per line.</span></td></tr>
<tr><td class="hicell"><b><?php id(2070); ?></b> wrote the shortest lines, averaging 14.8 characters per line.<br />
<span class="small"><b>k0wDUM</b> was tight-lipped, too, averaging 15.0 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(1551); ?></b> spoke a total of 23882 words!
<br /><span class="small"><?php id(1551); ?>'s faithful follower, <b><?php id(473); ?></b>, didn't speak so much: 20398 words.</span>
</td></tr>
<tr><td class="hicell"><b>Whitneyy</b> wrote an average of 25.00 words per line.
<br /><span class="small">Channel average was 5.46 words per line.</span>
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
<td class="hicell">34002</td>
<td class="hicell"><?php id(1551); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(42); ?></td>
<td class="hicell">2998</td>
<td class="hicell"><?php id(370); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(300); ?></td>
<td class="hicell">1678</td>
<td class="hicell"><?php id(1754); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell">about</td>
<td class="hicell">1425</td>
<td class="hicell"><?php id(1551); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">think</td>
<td class="hicell">1178</td>
<td class="hicell"><?php id(118); ?></td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">there</td>
<td class="hicell">1090</td>
<td class="hicell"><?php id(1754); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">would</td>
<td class="hicell">862</td>
<td class="hicell">`S-Tiger</td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">people</td>
<td class="hicell">833</td>
<td class="hicell"><?php id(473); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">really</td>
<td class="hicell">746</td>
<td class="hicell"><?php id(331); ?></td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">something</td>
<td class="hicell">738</td>
<td class="hicell"><?php id(16); ?></td>
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
<td class="hicell">15610</td>
<td class="hicell">Sayo</td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(331); ?></td>
<td class="hicell">12681</td>
<td class="hicell"><?php id(1754); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(1908); ?></td>
<td class="hicell">8268</td>
<td class="hicell"><?php id(1594); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(1281); ?></td>
<td class="hicell">2889</td>
<td class="hicell"><?php id(1908); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(45); ?></td>
<td class="hicell">1183</td>
<td class="hicell">deathw</td>
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
<td class="hicell">11</td>
<td class="hicell"><?php id(1762); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://www.nationstates.net/">http://www.nationstates.net/</a></td>
<td class="hicell">10</td>
<td class="hicell">NvM</td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://ka.thebhg.org/kacup/">http://ka.thebhg.org/kacup/</a></td>
<td class="hicell">10</td>
<td class="hicell">Kelmut</td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://www.gamedesigner.net/news.phtml?id=41">http://www.gamedesigner.net/news.phtml?id=41</a></td>
<td class="hicell">6</td>
<td class="hicell"><?php id(1247); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://www.ehnet.org/sabacc">http://www.ehnet.org/sabacc</a></td>
<td class="hicell">6</td>
<td class="hicell">^Fyre</td>
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

<tr><td class="hicell"><b><?php id(1594); ?></b> wasn't very popular, getting kicked 38 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[22:23] Coranel kicked from #bhg by D_Shadow: Quiet Heathen!
</span><br />
<br /><span class="small"><b><?php id(1551); ?></b> seemed to be hated too:  17 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1625); ?></b> is either insane or just a fair op, kicking a total of 50 people!
<br /><span class="small"><?php id(1625); ?>'s faithful follower, <b>LawnGnome</b>, kicked about 47 people.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> donated 53 ops in the channel...
<br /><span class="small"><b><?php id(1625); ?></b> was also very polite: 5 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1625); ?></b> is the channel sheriff with 7 deops.
<br /><span class="small"><b><?php id(1829); ?></b> deoped 4 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(331); ?></b> always lets us know what he/she's doing: 698 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[22:28] Action: LY|away licks Cha
</span><br />
<br /><span class="small">Also, <b><?php id(1247); ?></b> tells us what's up with 542 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(473); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 42 times!
<br /><span class="small">Another lonely one was <b><?php id(1551); ?></b>, who managed to hit 19 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> couldn't decide whether to stay or go.  320 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>NFaraway</b> has quite a potty mouth.  2.3% words were foul language.
<br /><span class="small"><b>Herpes</b> also makes sailors blush, 1.5% of the time.</span>
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

<tr><td class="hicell"><i>Nevermind, go about your business  ||Last day for RO's and Solo fictions|| DS does the happy money dance! cha-cha-cha!|| Round II ends today...</i></td>
<td class="hicell"><b>by <?php id(1829); ?> on 17:46</b></td></tr>
<tr><td class="hicell"><i>Server's Down... sorry folks! ||Last day for RO's and Solo fictions|| DS does the happy money dance! cha-cha-cha!|| Round II ends today...</i></td>
<td class="hicell"><b>by <?php id(1829); ?> on 17:44</b></td></tr>
<tr><td class="hicell"><i>WOTD: Ithyphallophobia ||Last day for RO's and Solo fictions|| DS does the happy money dance! cha-cha-cha!|| Round II ends today...</i></td>
<td class="hicell"><b>by <?php id(1829); ?> on 17:22</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 151 times.</td></tr>
</table>
Total number of lines: 125186.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 01 minutes and 06 seconds
</span>
</div>
</body>
</html>

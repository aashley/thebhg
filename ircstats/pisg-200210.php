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
Statistics generated on  Monday 2 December 2002 - 8:09:01
<br />During this 31-day reporting period, a total of <b>422</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">4.4%<br /><img src="./blue-v.png" width="15" height="61.3662790697674" alt="4.4" /></td>

<td align="center" valign="bottom" class="asmall">4.6%<br /><img src="./blue-v.png" width="15" height="63.6821705426357" alt="4.6" /></td>

<td align="center" valign="bottom" class="asmall">2.7%<br /><img src="./blue-v.png" width="15" height="38.4496124031008" alt="2.7" /></td>

<td align="center" valign="bottom" class="asmall">2.0%<br /><img src="./blue-v.png" width="15" height="27.8294573643411" alt="2.0" /></td>

<td align="center" valign="bottom" class="asmall">2.2%<br /><img src="./blue-v.png" width="15" height="30.9883720930233" alt="2.2" /></td>

<td align="center" valign="bottom" class="asmall">2.3%<br /><img src="./blue-v.png" width="15" height="31.9573643410853" alt="2.3" /></td>

<td align="center" valign="bottom" class="asmall">2.3%<br /><img src="./green-v.png" width="15" height="32.4418604651163" alt="2.3" /></td>

<td align="center" valign="bottom" class="asmall">1.6%<br /><img src="./green-v.png" width="15" height="23.0329457364341" alt="1.6" /></td>

<td align="center" valign="bottom" class="asmall">2.0%<br /><img src="./green-v.png" width="15" height="27.781007751938" alt="2.0" /></td>

<td align="center" valign="bottom" class="asmall">3.0%<br /><img src="./green-v.png" width="15" height="42.2674418604651" alt="3.0" /></td>

<td align="center" valign="bottom" class="asmall">3.5%<br /><img src="./green-v.png" width="15" height="49.1279069767442" alt="3.5" /></td>

<td align="center" valign="bottom" class="asmall">4.0%<br /><img src="./green-v.png" width="15" height="55.4554263565891" alt="4.0" /></td>

<td align="center" valign="bottom" class="asmall">4.0%<br /><img src="./yellow-v.png" width="15" height="56.3372093023256" alt="4.0" /></td>

<td align="center" valign="bottom" class="asmall">3.4%<br /><img src="./yellow-v.png" width="15" height="46.812015503876" alt="3.4" /></td>

<td align="center" valign="bottom" class="asmall">4.1%<br /><img src="./yellow-v.png" width="15" height="56.8895348837209" alt="4.1" /></td>

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./yellow-v.png" width="15" height="67.8585271317829" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">4.6%<br /><img src="./yellow-v.png" width="15" height="64.312015503876" alt="4.6" /></td>

<td align="center" valign="bottom" class="asmall">5.7%<br /><img src="./yellow-v.png" width="15" height="78.672480620155" alt="5.7" /></td>

<td align="center" valign="bottom" class="asmall">5.5%<br /><img src="./red-v.png" width="15" height="75.8720930232558" alt="5.5" /></td>

<td align="center" valign="bottom" class="asmall">5.6%<br /><img src="./red-v.png" width="15" height="77.4806201550388" alt="5.6" /></td>

<td align="center" valign="bottom" class="asmall">5.6%<br /><img src="./red-v.png" width="15" height="78.265503875969" alt="5.6" /></td>

<td align="center" valign="bottom" class="asmall">6.3%<br /><img src="./red-v.png" width="15" height="87.3352713178295" alt="6.3" /></td>

<td align="center" valign="bottom" class="asmall">7.2%<br /><img src="./red-v.png" width="15" height="100" alt="7.2" /></td>

<td align="center" valign="bottom" class="asmall">6.6%<br /><img src="./red-v.png" width="15" height="91.046511627907" alt="6.6" /></td>

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
<td style="background-color: #babadc"><?php id(1625); ?></td><td style="background-color: #babadc">4140</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #babadc">38771</td><td style="background-color: #babadc">9.4</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"...I think that was quote worthy  :P"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(2122); ?></td><td style="background-color: #babadc">3323</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #babadc">37980</td><td style="background-color: #babadc">11.4</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"I repeat: That's two more hours than I've gotten. :P"</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(331); ?></td><td style="background-color: #babadc">8127</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #babadc">33845</td><td style="background-color: #babadc">4.2</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Gen, if you're a god, I'm a goddess ;P"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(1218); ?></td><td style="background-color: #babadc">4461</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #babadc">26139</td><td style="background-color: #babadc">5.9</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"DS, did you ever call Dalk's mystery number? :P"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(57); ?></td><td style="background-color: #bbbbdb">3672</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #bbbbdb">23866</td><td style="background-color: #bbbbdb">6.5</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"energy conservation is such a stupid idea :P"</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(168); ?></td><td style="background-color: #bbbbdb">2325</td><td style="background-color: #bbbbdb"><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bbbbdb">23369</td><td style="background-color: #bbbbdb">10.1</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"Genny, I don't have access anymore:P"</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(1551); ?></td><td style="background-color: #bbbbdb">4147</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #bbbbdb">22073</td><td style="background-color: #bbbbdb">5.3</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"<a href="http://ka.thebhg.org/index.php?site=kahunts/display_hunt&amp;id=182" target="_blank" title="Open in new window: http://ka.thebhg.org/index.php?site=kahunts/display_hunt&amp;id=182">http://ka.thebhg.org/index.php?site=kahunts/display_hunt&amp;id=182</a>"</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(23); ?></td><td style="background-color: #bbbbdb">2765</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #bbbbdb">21149</td><td style="background-color: #bbbbdb">7.6</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">""Bounty hunters LOOOVE Pez!""</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(14); ?></td><td style="background-color: #bcbcda">2971</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #bcbcda">20811</td><td style="background-color: #bcbcda">7.0</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"Well, the Marines have to regularly retrain with .223 weapons."</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(473); ?></td><td style="background-color: #bcbcda">3931</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bcbcda">18560</td><td style="background-color: #bcbcda">4.7</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"anyone know how to work a burner?"</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(1908); ?></td><td style="background-color: #bcbcda">4021</td><td style="background-color: #bcbcda"><img src="./yellow-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bcbcda">17968</td><td style="background-color: #bcbcda">4.5</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"at least not till about 7ish"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(1594); ?></td><td style="background-color: #bcbcda">4728</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bcbcda">17467</td><td style="background-color: #bcbcda">3.7</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"it was like, BOOM, out of nowhere, here come the condom!"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(118); ?></td><td style="background-color: #bdbdda">2059</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bdbdda">17432</td><td style="background-color: #bdbdda">8.5</td><td style="background-color: #bdbdda">Today</td><td style="background-color: #bdbdda">"My guess is probably a public reprimand and loss of creds"</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9"><?php id(1332); ?></td><td style="background-color: #bdbdd9">3728</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bdbdd9">17266</td><td style="background-color: #bdbdd9">4.6</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"since when does nice come into anything"</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(16); ?></td><td style="background-color: #bdbdd9">1709</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bdbdd9">17250</td><td style="background-color: #bdbdd9">10.1</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"all of you: get some sleep! :P"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9">Obi Wan (EH)</td><td style="background-color: #bdbdd9">3029</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="27" height="15" alt="" /></td><td style="background-color: #bdbdd9">15890</td><td style="background-color: #bdbdd9">5.2</td><td style="background-color: #bdbdd9">5 days ago</td><td style="background-color: #bdbdd9">"SW Episode IV Original Motion Picture Soundtrack"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(1699); ?></td><td style="background-color: #bebed9">3310</td><td style="background-color: #bebed9"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bebed9">14870</td><td style="background-color: #bebed9">4.5</td><td style="background-color: #bebed9">2 days ago</td><td style="background-color: #bebed9">"what's so strange about agreeing with orin?"</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8"><?php id(94); ?></td><td style="background-color: #bebed8">1649</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #bebed8">13872</td><td style="background-color: #bebed8">8.4</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"i prefer the small intimate shows at a pub"</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(577); ?></td><td style="background-color: #bebed8">2541</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #bebed8">13269</td><td style="background-color: #bebed8">5.2</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"we played a tournament to start out, got outscored like 40-4"</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(1829); ?></td><td style="background-color: #bebed8">3640</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bebed8">13173</td><td style="background-color: #bebed8">3.6</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"well, time to go get lunch.... "</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8"><?php id(229); ?></td><td style="background-color: #bfbfd8">1416</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #bfbfd8">13044</td><td style="background-color: #bfbfd8">9.2</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"Wonder if Guns n Roses has some tracks in Vice City."</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(141); ?></td><td style="background-color: #bfbfd8">2654</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bfbfd8">13031</td><td style="background-color: #bfbfd8">4.9</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"who said i was talking bout you?"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7"><?php id(370); ?></td><td style="background-color: #bfbfd7">2015</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #bfbfd7">12512</td><td style="background-color: #bfbfd7">6.2</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"which is much better then some Teleco deals of 30 to 1"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7"><?php id(666); ?></td><td style="background-color: #bfbfd7">918</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="23" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bfbfd7">8726</td><td style="background-color: #bfbfd7">9.5</td><td style="background-color: #bfbfd7">2 days ago</td><td style="background-color: #bfbfd7">"$serial = rand(100, 99999);"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(747); ?></td><td style="background-color: #c0c0d7">2046</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c0c0d7">8063</td><td style="background-color: #c0c0d7">3.9</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"how the hell do you take the chief test thingy??"</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(1562); ?></td><td style="background-color: #c0c0d7">2136</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="27" height="15" alt="" /></td><td style="background-color: #c0c0d7">8004</td><td style="background-color: #c0c0d7">3.7</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"<a href="http://groundzerothemepark.com/" target="_blank" title="Open in new window: http://groundzerothemepark.com/">http://groundzerothemepark.com/</a>"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6">MiniElf</td><td style="background-color: #c0c0d6">1497</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c0c0d6">7819</td><td style="background-color: #c0c0d6">5.2</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"I have a life, I'm just bored :P"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6">Conan257</td><td style="background-color: #c0c0d6">1738</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #c0c0d6">7575</td><td style="background-color: #c0c0d6">4.4</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"<a href="http://sexylosers.keenspace.com/046.html" target="_blank" title="Open in new window: http://sexylosers.keenspace.com/046.html">http://sexylosers.keenspace.com/046.html</a>"</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(275); ?></td><td style="background-color: #c0c0d6">1436</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="25" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c0c0d6">7207</td><td style="background-color: #c0c0d6">5.0</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"a bother that's related to you."</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6"><?php id(765); ?></td><td style="background-color: #c1c1d6">1220</td><td style="background-color: #c1c1d6"><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c1c1d6">6710</td><td style="background-color: #c1c1d6">5.5</td><td style="background-color: #c1c1d6">Today</td><td style="background-color: #c1c1d6">"<a href="http://www.boners.com/grub/381568.html" target="_blank" title="Open in new window: http://www.boners.com/grub/381568.html">http://www.boners.com/grub/381568.html</a>"</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5"><?php id(1036); ?></td><td style="background-color: #c1c1d5">831</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="29" height="15" alt="" /></td><td style="background-color: #c1c1d5">6560</td><td style="background-color: #c1c1d5">7.9</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"What is it that you have against vowels?"</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5"><?php id(1356); ?></td><td style="background-color: #c1c1d5">1132</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c1c1d5">6469</td><td style="background-color: #c1c1d5">5.7</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"but your boobies are so bouncy!"</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5"><?php id(1085); ?></td><td style="background-color: #c1c1d5">1784</td><td style="background-color: #c1c1d5"><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c1c1d5">6252</td><td style="background-color: #c1c1d5">3.5</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"can I ask how it's generated, or not? :P"</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5"><?php id(2029); ?></td><td style="background-color: #c2c2d5">962</td><td style="background-color: #c2c2d5"><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #c2c2d5">6199</td><td style="background-color: #c2c2d5">6.4</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"all i have is wounded eyes and a sailor's mouth..."</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5"><?php id(1754); ?></td><td style="background-color: #c2c2d5">1183</td><td style="background-color: #c2c2d5"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="27" height="15" alt="" /></td><td style="background-color: #c2c2d5">5762</td><td style="background-color: #c2c2d5">4.9</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"banging his wife, most likely, CB :P"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(135); ?></td><td style="background-color: #c2c2d4">945</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c2c2d4">5562</td><td style="background-color: #c2c2d4">5.9</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"be ashamed, be very ashamed"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4"><?php id(1762); ?></td><td style="background-color: #c2c2d4">1353</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c2c2d4">5514</td><td style="background-color: #c2c2d4">4.1</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"Gen it wasn't Space Lion either"</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4"><?php id(1798); ?></td><td style="background-color: #c3c3d4">730</td><td style="background-color: #c3c3d4"><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #c3c3d4">5458</td><td style="background-color: #c3c3d4">7.5</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"You mean, like IW Renn? :P"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(1413); ?></td><td style="background-color: #c3c3d4">1051</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="27" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c3c3d4">5455</td><td style="background-color: #c3c3d4">5.2</td><td style="background-color: #c3c3d4">1 day ago</td><td style="background-color: #c3c3d4">"You mustn't discount the improbable."</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3">Xar_</td><td style="background-color: #c3c3d3">1244</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="30" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c3c3d3">5387</td><td style="background-color: #c3c3d3">4.3</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"it would be just like Princess Diana's death"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3"><?php id(1171); ?></td><td style="background-color: #c3c3d3">1296</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c3c3d3">5008</td><td style="background-color: #c3c3d3">3.9</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"and...what does it say on the home page?"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3"><?php id(2208); ?></td><td style="background-color: #c4c4d3">891</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c4c4d3">5001</td><td style="background-color: #c4c4d3">5.6</td><td style="background-color: #c4c4d3">2 days ago</td><td style="background-color: #c4c4d3">"sounds like he left to watch ZIM"</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3"><?php id(1943); ?></td><td style="background-color: #c4c4d3">1013</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c4c4d3">4938</td><td style="background-color: #c4c4d3">4.9</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"man, 3 over 2000 now, I am going to give up!"</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3">_Sw0rD_</td><td style="background-color: #c4c4d3">511</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c4c4d3">4727</td><td style="background-color: #c4c4d3">9.3</td><td style="background-color: #c4c4d3">15 days ago</td><td style="background-color: #c4c4d3">"My frail mindset has been shattered again tonight. :P"</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2">`mephesto</td><td style="background-color: #c4c4d2">713</td><td style="background-color: #c4c4d2"><img src="./yellow-h.png" border="0" width="25" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c4c4d2">3888</td><td style="background-color: #c4c4d2">5.5</td><td style="background-color: #c4c4d2">Today</td><td style="background-color: #c4c4d2">"so is yours, but hey, who's counting that"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2"><?php id(1873); ?></td><td style="background-color: #c5c5d2">610</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c5c5d2">3862</td><td style="background-color: #c5c5d2">6.3</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"shes playing ajedi mind trick"</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2"><?php id(2206); ?></td><td style="background-color: #c5c5d2">761</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #c5c5d2">3856</td><td style="background-color: #c5c5d2">5.1</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"Calvin and Hobbes kicks ass!"</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2">FruitCak</td><td style="background-color: #c5c5d2">407</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="22" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c5c5d2">3437</td><td style="background-color: #c5c5d2">8.4</td><td style="background-color: #c5c5d2">8 days ago</td><td style="background-color: #c5c5d2">"(By Linus Torvalds, <a href="mailto:Linus.Torvalds@cs.helsinki.fi" title="Mail to Linus.Torvalds@cs.helsinki.fi">Linus.Torvalds@cs.helsinki.fi</a>)"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1"><?php id(1281); ?></td><td style="background-color: #c5c5d1">559</td><td style="background-color: #c5c5d1"><img src="./blue-h.png" border="0" width="28" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c5c5d1">2982</td><td style="background-color: #c5c5d1">5.3</td><td style="background-color: #c5c5d1">Today</td><td style="background-color: #c5c5d1">"laters, work calls.  or more work rather ;-)"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1">^SyNth</td><td style="background-color: #c6c6d1">639</td><td style="background-color: #c6c6d1"><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="29" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c6c6d1">2873</td><td style="background-color: #c6c6d1">4.5</td><td style="background-color: #c6c6d1">1 day ago</td><td style="background-color: #c6c6d1">"so.... jondolar.... u gonna answer my question?"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1"><?php id(85); ?></td><td style="background-color: #c6c6d1">509</td><td style="background-color: #c6c6d1"><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c6c6d1">2853</td><td style="background-color: #c6c6d1">5.6</td><td style="background-color: #c6c6d1">14 days ago</td><td style="background-color: #c6c6d1">"Bryan Adams - So Far So Good album"</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1"><?php id(1489); ?></td><td style="background-color: #c6c6d1">513</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c6c6d1">2572</td><td style="background-color: #c6c6d1">5.0</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"I don't want armor I was a trinch coat"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0"><?php id(1583); ?></td><td style="background-color: #c6c6d0">478</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c6c6d0">2526</td><td style="background-color: #c6c6d0">5.3</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"last week we had 23 degrees C"</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0"><?php id(2070); ?></td><td style="background-color: #c6c6d0">696</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="28" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c6c6d0">2501</td><td style="background-color: #c6c6d0">3.6</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"he used to be the CRA of Phoenix"</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0"><?php id(2118); ?></td><td style="background-color: #c7c7d0">472</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c7c7d0">2498</td><td style="background-color: #c7c7d0">5.3</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"intersection and minimum or maximium"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0"><?php id(1219); ?></td><td style="background-color: #c7c7d0">408</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c7c7d0">2148</td><td style="background-color: #c7c7d0">5.3</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"yeah lego go work on your teleporter"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0"><?php id(494); ?></td><td style="background-color: #c7c7d0">478</td><td style="background-color: #c7c7d0"><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c7c7d0">1976</td><td style="background-color: #c7c7d0">4.1</td><td style="background-color: #c7c7d0">4 days ago</td><td style="background-color: #c7c7d0">"Somone needs to teach Detori spanish."</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf"><?php id(1190); ?></td><td style="background-color: #c7c7cf">506</td><td style="background-color: #c7c7cf"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #c7c7cf">1908</td><td style="background-color: #c7c7cf">3.8</td><td style="background-color: #c7c7cf">Today</td><td style="background-color: #c7c7cf">"you're the one that does this all the time"</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf"><?php id(484); ?></td><td style="background-color: #c8c8cf">352</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="32" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c8c8cf">1871</td><td style="background-color: #c8c8cf">5.3</td><td style="background-color: #c8c8cf">4 days ago</td><td style="background-color: #c8c8cf">"you have crabs, you're crabby, or seafood's for dinner?"</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf"><?php id(1722); ?></td><td style="background-color: #c8c8cf">432</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c8c8cf">1779</td><td style="background-color: #c8c8cf">4.1</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"goodbye your beutiful DP Trench and yes your ass is very nice :p"</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf"><?php id(1561); ?></td><td style="background-color: #c8c8cf">375</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #c8c8cf">1770</td><td style="background-color: #c8c8cf">4.7</td><td style="background-color: #c8c8cf">7 days ago</td><td style="background-color: #c8c8cf">"I have to head for Fort Chafe in about 30 mins"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce">^Fyre</td><td style="background-color: #c8c8ce">216</td><td style="background-color: #c8c8ce"><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="31" height="15" alt="" /></td><td style="background-color: #c8c8ce">1762</td><td style="background-color: #c8c8ce">8.2</td><td style="background-color: #c8c8ce">Today</td><td style="background-color: #c8c8ce">"theres lots of chesse there"</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce">Brandl</td><td style="background-color: #c9c9ce">386</td><td style="background-color: #c9c9ce"><img src="./red-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c9c9ce">1685</td><td style="background-color: #c9c9ce">4.4</td><td style="background-color: #c9c9ce">1 day ago</td><td style="background-color: #c9c9ce">"oh we did motion last week"</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce"><?php id(45); ?></td><td style="background-color: #c9c9ce">246</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c9c9ce">1537</td><td style="background-color: #c9c9ce">6.2</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"is the BHG mail server down?"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce">Moondark</td><td style="background-color: #c9c9ce">369</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c9c9ce">1433</td><td style="background-color: #c9c9ce">3.9</td><td style="background-color: #c9c9ce">1 day ago</td><td style="background-color: #c9c9ce">"and then I'll steal it off you"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce">Ender`</td><td style="background-color: #c9c9ce">243</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c9c9ce">1324</td><td style="background-color: #c9c9ce">5.4</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"well Jet Li is like 90% sure"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd"><?php id(1861); ?></td><td style="background-color: #cacacd">179</td><td style="background-color: #cacacd"><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #cacacd">1252</td><td style="background-color: #cacacd">7.0</td><td style="background-color: #cacacd">1 day ago</td><td style="background-color: #cacacd">"I have the best story to tell"</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd"><?php id(1717); ?></td><td style="background-color: #cacacd">303</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #cacacd">1114</td><td style="background-color: #cacacd">3.7</td><td style="background-color: #cacacd">2 days ago</td><td style="background-color: #cacacd">"yea well it wouldnt matter either way"</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd">Sayo</td><td style="background-color: #cacacd">173</td><td style="background-color: #cacacd"><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #cacacd">1063</td><td style="background-color: #cacacd">6.1</td><td style="background-color: #cacacd">4 days ago</td><td style="background-color: #cacacd">"I must have missed something Orin, Kneepads? :P"</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd"><?php id(2213); ?></td><td style="background-color: #cacacd">179</td><td style="background-color: #cacacd"><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #cacacd">1050</td><td style="background-color: #cacacd">5.9</td><td style="background-color: #cacacd">4 days ago</td><td style="background-color: #cacacd">"somebody say hand and ill give them a cookie"</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc"><?php id(1678); ?></td><td style="background-color: #cbcbcc">187</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #cbcbcc">1043</td><td style="background-color: #cbcbcc">5.6</td><td style="background-color: #cbcbcc">3 days ago</td><td style="background-color: #cbcbcc">"no by saying that God would strike me down "</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc">_-Mage-_</td><td style="background-color: #cbcbcc">143</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #cbcbcc">1031</td><td style="background-color: #cbcbcc">7.2</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"As Bog is the 'it', I advise you to ask him."</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc"><?php id(1247); ?></td><td style="background-color: #cbcbcc">450</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #cbcbcc">1001</td><td style="background-color: #cbcbcc">2.2</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"i need about 250K really fast"</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc">`Sayo</td><td style="background-color: #cbcbcc">199</td><td style="background-color: #cbcbcc"><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="27" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #cbcbcc">972</td><td style="background-color: #cbcbcc">4.9</td><td style="background-color: #cbcbcc">4 days ago</td><td style="background-color: #cbcbcc">"There are no ships! The humanity! Jer has taken the humanity!!!"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc">Karrde|CL</td><td style="background-color: #cccccc">157</td><td style="background-color: #cccccc"><img src="./blue-h.png" border="0" width="29" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #cccccc">930</td><td style="background-color: #cccccc">5.9</td><td style="background-color: #cccccc">Today</td><td style="background-color: #cccccc">"nope, and ive been in the EH since i was 19"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10"><?php id(77); ?> (919)</td>
<td class="rankc10"><?php id(22); ?> (917)</td>
<td class="rankc10"><?php id(160); ?> (868)</td>
<td class="rankc10"><?php id(366); ?> (854)</td>
<td class="rankc10">Jer-owwie (845)</td>
</tr><tr>
<td class="rankc10"><?php id(1533); ?> (749)</td>
<td class="rankc10">LC|Karrde (737)</td>
<td class="rankc10"><?php id(2159); ?> (724)</td>
<td class="rankc10"><?php id(546); ?> (708)</td>
<td class="rankc10">RA_Janson (675)</td>
</tr><tr>
<td class="rankc10">Mik| (666)</td>
<td class="rankc10"><?php id(1264); ?> (625)</td>
<td class="rankc10">MAJZoron (595)</td>
<td class="rankc10">t00bdaed (572)</td>
<td class="rankc10"><?php id(1133); ?> (564)</td>
</tr><tr>
<td class="rankc10"><?php id(1656); ?> (529)</td>
<td class="rankc10"><?php id(47); ?> (527)</td>
<td class="rankc10"><?php id(796); ?> (522)</td>
<td class="rankc10"><?php id(1843); ?> (507)</td>
<td class="rankc10">`Slawter (503)</td>
</tr><tr>
<td class="rankc10">djdonki (493)</td>
<td class="rankc10"><?php id(2131); ?> (477)</td>
<td class="rankc10">Gaea^ (476)</td>
<td class="rankc10">deathofpx (454)</td>
<td class="rankc10"><?php id(1636); ?> (451)</td>
</tr><tr>
<td class="rankc10">Mal|away (441)</td>
<td class="rankc10"><?php id(1064); ?> (437)</td>
<td class="rankc10"><?php id(1187); ?> (411)</td>
<td class="rankc10"><?php id(175); ?> (403)</td>
<td class="rankc10">vN_PG2 (374)</td>
</tr><tr>
<td class="rankc10">Gen` (355)</td>
<td class="rankc10">EH_Talon (346)</td>
<td class="rankc10">Karrde|GB (344)</td>
<td class="rankc10">Mik_ (342)</td>
<td class="rankc10">Bar_Keep (335)</td>
</tr><tr>
<td class="rankc10">outcasted (334)</td>
<td class="rankc10"><?php id(260); ?> (328)</td>
<td class="rankc10"><?php id(1165); ?> (323)</td>
<td class="rankc10"><?php id(1627); ?> (309)</td>
<td class="rankc10">Icedemon (300)</td>
</tr></table>
<br /><b>By the way, there were 305 other nicks.</b><br />
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

<tr><td class="hicell">Is <b>Sayo</b> stupid or just asking too many questions?  34.1% lines contained a question!
<br /><span class="small"><b><?php id(1861); ?></b> didn't know that much either.  29.0% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(1829); ?></b>, who yelled 39.3% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(1247); ?></b>, who shouted 24.2% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b><?php id(2213); ?></b>'s shift-key is hanging:  21.2% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[17:56] &lt;Derius&gt; HI GENNO
</span><br />
<br /><span class="small"><b><?php id(1247); ?></b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 10.8% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(331); ?></b> is a very aggressive person.  He/She attacked others <b>113</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[16:18] Action: `Lara slaps Orin's ass
</span><br />
<br /><span class="small"><b><?php id(1625); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>68</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(1594); ?></b>, nobody likes him/her.  He/She was attacked <b>34</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[23:11] Action: CodeSlice smacks Coranel with the printed list of every useless post Jay has made on the MB!
</span><br />
<br /><span class="small"><b><?php id(2208); ?></b> seems to be unliked too.  He/She got beaten <b>33</b> times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(2122); ?></b> brings happiness to the world.  49.2% lines contained smiling faces.  :)
<br /><span class="small"><b>_-Mage-_</b> isn't a sad person either, smiling 43.3% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(796); ?></b> seems to be sad at the moment:  2.9% lines contained sad faces.  :(
<br /><span class="small"><b><?php id(1562); ?></b> is also a sad person, crying 1.5% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(2122); ?></b> wrote the longest lines, averaging 59.9 letters per line.<br />
<span class="small">#bhg average was 28.9 letters per line.</span></td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> wrote the shortest lines, averaging 10.3 characters per line.<br />
<span class="small"><b>Bar_Keep</b> was tight-lipped, too, averaging 11.5 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(1625); ?></b> spoke a total of 38771 words!
<br /><span class="small"><?php id(1625); ?>'s faithful follower, <b><?php id(2122); ?></b>, didn't speak so much: 37980 words.</span>
</td></tr>
<tr><td class="hicell"><b>t00bemag</b> wrote an average of 23.50 words per line.
<br /><span class="small">Channel average was 5.70 words per line.</span>
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
<td class="hicell">3324</td>
<td class="hicell"><?php id(1625); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell">about</td>
<td class="hicell">1947</td>
<td class="hicell"><?php id(23); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell">think</td>
<td class="hicell">1528</td>
<td class="hicell"><?php id(2122); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(1103); ?></td>
<td class="hicell">1475</td>
<td class="hicell"><?php id(2122); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">there</td>
<td class="hicell">1302</td>
<td class="hicell"><?php id(1873); ?></td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">really</td>
<td class="hicell">1129</td>
<td class="hicell"><?php id(2122); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">would</td>
<td class="hicell">1087</td>
<td class="hicell"><?php id(2122); ?></td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">people</td>
<td class="hicell">1005</td>
<td class="hicell"><?php id(2122); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">right</td>
<td class="hicell">995</td>
<td class="hicell">F`larbank</td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">going</td>
<td class="hicell">962</td>
<td class="hicell"><?php id(1873); ?></td>
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
<td class="hicell">43475</td>
<td class="hicell"><?php id(23); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(1085); ?></td>
<td class="hicell">20059</td>
<td class="hicell"><?php id(1533); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(331); ?></td>
<td class="hicell">15414</td>
<td class="hicell"><?php id(1218); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(1908); ?></td>
<td class="hicell">10234</td>
<td class="hicell"><?php id(1908); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(1281); ?></td>
<td class="hicell">3702</td>
<td class="hicell">^SyNth</td>
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
<td class="hicell"><a href="http://www.ebaumsworld.com/helicopter.html">http://www.ebaumsworld.com/helicopter.html</a></td>
<td class="hicell">19</td>
<td class="hicell"><?php id(1533); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://www.ehnet.org/sabacc">http://www.ehnet.org/sabacc</a></td>
<td class="hicell">11</td>
<td class="hicell"><?php id(1171); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://www...">http://www...</a></td>
<td class="hicell">8</td>
<td class="hicell">^SyNth</td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://www.snood.com">http://www.snood.com</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(1625); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://www.emode.com">http://www.emode.com</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(1594); ?></td>
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

<tr><td class="hicell"><b><?php id(2206); ?></b> wasn't very popular, getting kicked 13 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[21:34] Kefka kicked from #bhg by LawnGnome: You've been raped by the lawn gnome... I said to watch your language! [Warning 2 of 2]
</span><br />
<br /><span class="small"><b><?php id(1594); ?></b> seemed to be hated too:  13 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> is either insane or just a fair op, kicking a total of 86 people!
<br /><span class="small">LawnGnome's faithful follower, <b><?php id(473); ?></b>, kicked about 72 people.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> donated 43 ops in the channel...
<br /><span class="small"><b><?php id(229); ?></b> was also very polite: 22 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(229); ?></b> is the channel sheriff with 10 deops.
<br /><span class="small"><b><?php id(135); ?></b> deoped 3 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(57); ?></b> always lets us know what he/she's doing: 743 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[16:04] Action: Genno makes the death threats and Bog gets scolded :P
</span><br />
<br /><span class="small">Also, <b><?php id(331); ?></b> tells us what's up with 713 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(141); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 25 times!
<br /><span class="small">Another lonely one was <b><?php id(1218); ?></b>, who managed to hit 25 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1829); ?></b> couldn't decide whether to stay or go.  244 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>BiggieMik</b> has quite a potty mouth.  2.0% words were foul language.
<br /><span class="small"><b>Ender`</b> also makes sailors blush, 1.5% of the time.</span>
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

<tr><td class="hicell"><i>(Talra) Mourn for the Fro || (Cour) IKC results posted [except for Fiction]...:P</i></td>
<td class="hicell"><b>by <?php id(473); ?> on 18:46</b></td></tr>
<tr><td class="hicell"><i>(Talra) Mourn for the Fro || (Cour) IKC results posted [except for Fiction]...:P || Type !get ops ... It works!  Really!  It does!  I'm not kiddin'! ;)</i></td>
<td class="hicell"><b>by <?php id(473); ?> on 18:42</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 147 times.</td></tr>
</table>
Total number of lines: 142038.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 01 minutes and 11 seconds
</span>
</div>
</body>
</html>

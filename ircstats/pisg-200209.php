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
Statistics generated on  Friday 4 October 2002 - 8:33:01
<br />During this 30-day reporting period, a total of <b>488</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">4.3%<br /><img src="./blue-v.png" width="15" height="52.5446693200102" alt="4.3" /></td>

<td align="center" valign="bottom" class="asmall">3.4%<br /><img src="./blue-v.png" width="15" height="41.2397324074858" alt="3.4" /></td>

<td align="center" valign="bottom" class="asmall">2.8%<br /><img src="./blue-v.png" width="15" height="33.5422135659243" alt="2.8" /></td>

<td align="center" valign="bottom" class="asmall">1.8%<br /><img src="./blue-v.png" width="15" height="22.1017867728004" alt="1.8" /></td>

<td align="center" valign="bottom" class="asmall">2.3%<br /><img src="./blue-v.png" width="15" height="28.291980692692" alt="2.3" /></td>

<td align="center" valign="bottom" class="asmall">2.5%<br /><img src="./blue-v.png" width="15" height="30.4767550173596" alt="2.5" /></td>

<td align="center" valign="bottom" class="asmall">2.2%<br /><img src="./green-v.png" width="15" height="27.39436023372" alt="2.2" /></td>

<td align="center" valign="bottom" class="asmall">2.0%<br /><img src="./green-v.png" width="15" height="25.0486916758405" alt="2.0" /></td>

<td align="center" valign="bottom" class="asmall">2.4%<br /><img src="./green-v.png" width="15" height="29.6892200863748" alt="2.4" /></td>

<td align="center" valign="bottom" class="asmall">2.6%<br /><img src="./green-v.png" width="15" height="32.1111017020916" alt="2.6" /></td>

<td align="center" valign="bottom" class="asmall">3.3%<br /><img src="./green-v.png" width="15" height="39.859429248878" alt="3.3" /></td>

<td align="center" valign="bottom" class="asmall">4.3%<br /><img src="./green-v.png" width="15" height="52.4430519095605" alt="4.3" /></td>

<td align="center" valign="bottom" class="asmall">3.4%<br /><img src="./yellow-v.png" width="15" height="41.7054788720467" alt="3.4" /></td>

<td align="center" valign="bottom" class="asmall">3.4%<br /><img src="./yellow-v.png" width="15" height="40.8247946481497" alt="3.4" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./yellow-v.png" width="15" height="45.5245998814464" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">5.2%<br /><img src="./yellow-v.png" width="15" height="62.7826234228131" alt="5.2" /></td>

<td align="center" valign="bottom" class="asmall">5.8%<br /><img src="./yellow-v.png" width="15" height="70.1075450927259" alt="5.8" /></td>

<td align="center" valign="bottom" class="asmall">5.7%<br /><img src="./yellow-v.png" width="15" height="68.5155389956813" alt="5.7" /></td>

<td align="center" valign="bottom" class="asmall">6.3%<br /><img src="./red-v.png" width="15" height="76.0182911338809" alt="6.3" /></td>

<td align="center" valign="bottom" class="asmall">5.3%<br /><img src="./red-v.png" width="15" height="63.5362858836481" alt="5.3" /></td>

<td align="center" valign="bottom" class="asmall">5.2%<br /><img src="./red-v.png" width="15" height="62.5624523668388" alt="5.2" /></td>

<td align="center" valign="bottom" class="asmall">6.0%<br /><img src="./red-v.png" width="15" height="72.0552121263443" alt="6.0" /></td>

<td align="center" valign="bottom" class="asmall">8.3%<br /><img src="./red-v.png" width="15" height="100" alt="8.3" /></td>

<td align="center" valign="bottom" class="asmall">5.8%<br /><img src="./red-v.png" width="15" height="69.9635870945889" alt="5.8" /></td>

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
<td style="background-color: #babadc"><?php id(331); ?></td><td style="background-color: #babadc">10065</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #babadc">38229</td><td style="background-color: #babadc">3.8</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"I hate this goddamn weather"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(2122); ?></td><td style="background-color: #babadc">3329</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #babadc">36573</td><td style="background-color: #babadc">11.0</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Hell, kick him again, just for stihs and giggles. :P"</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(57); ?></td><td style="background-color: #babadc">4963</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #babadc">34095</td><td style="background-color: #babadc">6.9</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"but Min doesnt call that disabled kid cool! im cool! :P"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(16); ?></td><td style="background-color: #babadc">2390</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #babadc">26952</td><td style="background-color: #babadc">11.3</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"woot for drugs disguised as food! :P"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(1218); ?></td><td style="background-color: #bbbbdb">4161</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #bbbbdb">25576</td><td style="background-color: #bbbbdb">6.1</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"We just might have a future together. :P"</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(23); ?></td><td style="background-color: #bbbbdb">3230</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #bbbbdb">25007</td><td style="background-color: #bbbbdb">7.7</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"I never have problems connection :P"</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(168); ?></td><td style="background-color: #bbbbdb">2727</td><td style="background-color: #bbbbdb"><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #bbbbdb">24304</td><td style="background-color: #bbbbdb">8.9</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"<a href="http://www.ottawastart.com" target="_blank" title="Open in new window: http://www.ottawastart.com">http://www.ottawastart.com</a> - my brother's website.  Bite me:P"</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(1551); ?></td><td style="background-color: #bbbbdb">4294</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #bbbbdb">23090</td><td style="background-color: #bbbbdb">5.4</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"Bog, you are so lucky you're already f***ed up in the EH :P"</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(229); ?></td><td style="background-color: #bcbcda">2195</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #bcbcda">19271</td><td style="background-color: #bcbcda">8.8</td><td style="background-color: #bcbcda">6 days ago</td><td style="background-color: #bcbcda">"cus she underdstands me situation."</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda">D_Shadow</td><td style="background-color: #bcbcda">4397</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bcbcda">18815</td><td style="background-color: #bcbcda">4.3</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"timing belt and fly wheel..."</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(1625); ?></td><td style="background-color: #bcbcda">2399</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bcbcda">18296</td><td style="background-color: #bcbcda">7.6</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"just wait until they are, I'm sure you'll be number one :P"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(85); ?></td><td style="background-color: #bcbcda">3060</td><td style="background-color: #bcbcda"><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bcbcda">17557</td><td style="background-color: #bcbcda">5.7</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"Someone else may not know you're joking and take offense to it"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(14); ?></td><td style="background-color: #bdbdda">2589</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #bdbdda">17436</td><td style="background-color: #bdbdda">6.7</td><td style="background-color: #bdbdda">Today</td><td style="background-color: #bdbdda">"Pfft, like you did K1 so well, Cooch? :P"</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9"><?php id(118); ?></td><td style="background-color: #bdbdd9">2197</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bdbdd9">17261</td><td style="background-color: #bdbdd9">7.9</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"Oooo...Philly is a great city"</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(370); ?></td><td style="background-color: #bdbdd9">2436</td><td style="background-color: #bdbdd9"><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bdbdd9">15417</td><td style="background-color: #bdbdd9">6.3</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"<a href="http://www.gaijindesign.com/lawriemalen/jedi/anakin.jpg" target="_blank" title="Open in new window: http://www.gaijindesign.com/lawriemalen/jedi/anakin.jpg">http://www.gaijindesign.com/lawriemalen/jedi/anakin.jpg</a>"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(1594); ?></td><td style="background-color: #bdbdd9">3442</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bdbdd9">14125</td><td style="background-color: #bdbdd9">4.1</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"don't know what you talking about"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(577); ?></td><td style="background-color: #bebed9">2765</td><td style="background-color: #bebed9"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bebed9">13191</td><td style="background-color: #bebed9">4.8</td><td style="background-color: #bebed9">Today</td><td style="background-color: #bebed9">"he'd be dead by now if it was a lifestyle"</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8"><?php id(473); ?></td><td style="background-color: #bebed8">2438</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bebed8">12969</td><td style="background-color: #bebed8">5.3</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"Cricket doesn't spark my interest."</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(1908); ?></td><td style="background-color: #bebed8">2874</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bebed8">11727</td><td style="background-color: #bebed8">4.1</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"well...he had an MB topic....."</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(1754); ?></td><td style="background-color: #bebed8">2259</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="29" height="15" alt="" /></td><td style="background-color: #bebed8">11713</td><td style="background-color: #bebed8">5.2</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"well, not this very second"</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8"><?php id(484); ?></td><td style="background-color: #bfbfd8">1827</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="26" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #bfbfd8">11158</td><td style="background-color: #bfbfd8">6.1</td><td style="background-color: #bfbfd8">4 days ago</td><td style="background-color: #bfbfd8">"incast looks too much like incest"</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(1332); ?></td><td style="background-color: #bfbfd8">2483</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="23" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #bfbfd8">11117</td><td style="background-color: #bfbfd8">4.5</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"smarties embedded in mild chololate"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7"><?php id(1036); ?></td><td style="background-color: #bfbfd7">931</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #bfbfd7">8362</td><td style="background-color: #bfbfd7">9.0</td><td style="background-color: #bfbfd7">2 days ago</td><td style="background-color: #bfbfd7">"I remember Sam &amp; Max. And the short-lived cartoon."</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7"><?php id(666); ?></td><td style="background-color: #bfbfd7">874</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bfbfd7">8252</td><td style="background-color: #bfbfd7">9.4</td><td style="background-color: #bfbfd7">1 day ago</td><td style="background-color: #bfbfd7">"Q1: Where can you find the TC web site at the moment?"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7">dasb00t</td><td style="background-color: #c0c0d7">2397</td><td style="background-color: #c0c0d7"><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c0c0d7">8224</td><td style="background-color: #c0c0d7">3.4</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"Now, now, Reav, let's not be harsh with the language. ;P"</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(94); ?></td><td style="background-color: #c0c0d7">968</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="22" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c0c0d7">7976</td><td style="background-color: #c0c0d7">8.2</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"take the battery cover off, pull the battery out"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6"><?php id(141); ?></td><td style="background-color: #c0c0d6">1527</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="19" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c0c0d6">7558</td><td style="background-color: #c0c0d6">4.9</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"write back as soon as you can"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6"><?php id(1699); ?></td><td style="background-color: #c0c0d6">1511</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="28" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c0c0d6">7484</td><td style="background-color: #c0c0d6">5.0</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"damnit, internet deciding to drop on me"</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(765); ?></td><td style="background-color: #c0c0d6">1452</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="27" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #c0c0d6">7000</td><td style="background-color: #c0c0d6">4.8</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"hmm, wonder what the gf would say..."</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6">FruitCak</td><td style="background-color: #c1c1d6">741</td><td style="background-color: #c1c1d6"><img src="./blue-h.png" border="0" width="22" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c1c1d6">6626</td><td style="background-color: #c1c1d6">8.9</td><td style="background-color: #c1c1d6">5 days ago</td><td style="background-color: #c1c1d6">"france sucks because its full of french people"</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5"><?php id(1080); ?></td><td style="background-color: #c1c1d5">774</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c1c1d5">5974</td><td style="background-color: #c1c1d5">7.7</td><td style="background-color: #c1c1d5">18 days ago</td><td style="background-color: #c1c1d5">"good at taking it from big bubba backdoor?"</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5"><?php id(796); ?></td><td style="background-color: #c1c1d5">1062</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="27" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c1c1d5">5733</td><td style="background-color: #c1c1d5">5.4</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"thats a very good question"</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5"><?php id(747); ?></td><td style="background-color: #c1c1d5">1547</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="19" height="15" alt="" /><img src="./green-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c1c1d5">5622</td><td style="background-color: #c1c1d5">3.6</td><td style="background-color: #c1c1d5">2 days ago</td><td style="background-color: #c1c1d5">"well... mine just swears at me now."</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5"><?php id(2208); ?></td><td style="background-color: #c2c2d5">1074</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c2c2d5">5382</td><td style="background-color: #c2c2d5">5.0</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"that was right...wasn't it?"</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5"><?php id(108); ?></td><td style="background-color: #c2c2d5">1004</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c2c2d5">5071</td><td style="background-color: #c2c2d5">5.1</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"They don't call him the Specialist for nothing, I guess. =P"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(1562); ?></td><td style="background-color: #c2c2d4">1253</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c2c2d4">4944</td><td style="background-color: #c2c2d4">3.9</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"<a href="http://specialist.thebhg.org/kkbbgen_catfight.txt" target="_blank" title="Open in new window: http://specialist.thebhg.org/kkbbgen_catfight.txt">http://specialist.thebhg.org/kkbbgen_catfight.txt</a>"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4"><?php id(1264); ?></td><td style="background-color: #c2c2d4">1003</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="28" height="15" alt="" /></td><td style="background-color: #c2c2d4">4936</td><td style="background-color: #c2c2d4">4.9</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"that is a screwed up movie"</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4">_Sw0rD_</td><td style="background-color: #c3c3d4">674</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c3c3d4">4826</td><td style="background-color: #c3c3d4">7.2</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"I wanna transfer all my words from the #ehcoc b0t over. :P"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(1413); ?></td><td style="background-color: #c3c3d4">756</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="23" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c3c3d4">4723</td><td style="background-color: #c3c3d4">6.2</td><td style="background-color: #c3c3d4">13 days ago</td><td style="background-color: #c3c3d4">"Why would you have a cat in your toga?"</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3">Re_Eson</td><td style="background-color: #c3c3d3">1052</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="32" height="15" alt="" /></td><td style="background-color: #c3c3d3">4680</td><td style="background-color: #c3c3d3">4.4</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"No not a friend...I actually hate the person"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3"><?php id(494); ?></td><td style="background-color: #c3c3d3">1062</td><td style="background-color: #c3c3d3"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c3c3d3">4589</td><td style="background-color: #c3c3d3">4.3</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"Did you put up the moon Mom gave you?"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3"><?php id(2006); ?></td><td style="background-color: #c4c4d3">1129</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c4c4d3">4526</td><td style="background-color: #c4c4d3">4.0</td><td style="background-color: #c4c4d3">14 days ago</td><td style="background-color: #c4c4d3">"So i'll take that as a comment Lara"</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3"><?php id(2118); ?></td><td style="background-color: #c4c4d3">698</td><td style="background-color: #c4c4d3"><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="30" height="15" alt="" /></td><td style="background-color: #c4c4d3">4522</td><td style="background-color: #c4c4d3">6.5</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"My beautiful mullet of a hiarcut?"</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(2029); ?></td><td style="background-color: #c4c4d3">660</td><td style="background-color: #c4c4d3"><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c4c4d3">4114</td><td style="background-color: #c4c4d3">6.2</td><td style="background-color: #c4c4d3">16 days ago</td><td style="background-color: #c4c4d3">"Bloder - he must be stopped! :P"</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2"><?php id(22); ?></td><td style="background-color: #c4c4d2">781</td><td style="background-color: #c4c4d2"><img src="./blue-h.png" border="0" width="29" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c4c4d2">4084</td><td style="background-color: #c4c4d2">5.2</td><td style="background-color: #c4c4d2">4 days ago</td><td style="background-color: #c4c4d2">"why did you dudes feed Cow to Cow"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2"><?php id(135); ?></td><td style="background-color: #c5c5d2">621</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c5c5d2">4027</td><td style="background-color: #c5c5d2">6.5</td><td style="background-color: #c5c5d2">1 day ago</td><td style="background-color: #c5c5d2">"woah.. that won't last long :P"</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2"><?php id(275); ?></td><td style="background-color: #c5c5d2">805</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="23" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c5c5d2">3926</td><td style="background-color: #c5c5d2">4.9</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"they need some Sanity-in-a-Jar"</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2">LC|Karrde</td><td style="background-color: #c5c5d2">639</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c5c5d2">3685</td><td style="background-color: #c5c5d2">5.8</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"looks like a 17 hour day with standard gravity"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1"><?php id(1843); ?></td><td style="background-color: #c5c5d1">874</td><td style="background-color: #c5c5d1"><img src="./blue-h.png" border="0" width="20" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c5c5d1">3308</td><td style="background-color: #c5c5d1">3.8</td><td style="background-color: #c5c5d1">10 days ago</td><td style="background-color: #c5c5d1">"damn...i have holes burnt into my hand from it"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1">CM_Drak</td><td style="background-color: #c6c6d1">592</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #c6c6d1">3289</td><td style="background-color: #c6c6d1">5.6</td><td style="background-color: #c6c6d1">13 days ago</td><td style="background-color: #c6c6d1">"hi Chronas (late i know i was checking mail :P)"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1"><?php id(1219); ?></td><td style="background-color: #c6c6d1">750</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c6c6d1">3117</td><td style="background-color: #c6c6d1">4.2</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"www.geocities.com/sstrunks427/gene.gif"</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1">MiniReapa</td><td style="background-color: #c6c6d1">343</td><td style="background-color: #c6c6d1"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="30" height="15" alt="" /></td><td style="background-color: #c6c6d1">2953</td><td style="background-color: #c6c6d1">8.6</td><td style="background-color: #c6c6d1">4 days ago</td><td style="background-color: #c6c6d1">"Probably best if we didn't know. :P"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0"><?php id(2174); ?></td><td style="background-color: #c6c6d0">458</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c6c6d0">2817</td><td style="background-color: #c6c6d0">6.2</td><td style="background-color: #c6c6d0">2 days ago</td><td style="background-color: #c6c6d0">"waiting for my arena match to be marked"</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0"><?php id(1722); ?></td><td style="background-color: #c6c6d0">683</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c6c6d0">2756</td><td style="background-color: #c6c6d0">4.0</td><td style="background-color: #c6c6d0">24 days ago</td><td style="background-color: #c6c6d0">"just post the log when she comes home"</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0"><?php id(77); ?></td><td style="background-color: #c7c7d0">472</td><td style="background-color: #c7c7d0"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c7c7d0">2623</td><td style="background-color: #c7c7d0">5.6</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"n/m. i think i'm getting my channels mixed up"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0">MAN_DRAKE</td><td style="background-color: #c7c7d0">440</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c7c7d0">2360</td><td style="background-color: #c7c7d0">5.4</td><td style="background-color: #c7c7d0">1 day ago</td><td style="background-color: #c7c7d0">"so i can become a good hunter"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0"><?php id(2195); ?></td><td style="background-color: #c7c7d0">484</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c7c7d0">2326</td><td style="background-color: #c7c7d0">4.8</td><td style="background-color: #c7c7d0">15 days ago</td><td style="background-color: #c7c7d0">"i would go tofrance justto get some"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf"><?php id(1943); ?></td><td style="background-color: #c7c7cf">468</td><td style="background-color: #c7c7cf"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c7c7cf">2323</td><td style="background-color: #c7c7cf">5.0</td><td style="background-color: #c7c7cf">Today</td><td style="background-color: #c7c7cf">"It is always sad, but sometimes it is better for them :("</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf"><?php id(1627); ?></td><td style="background-color: #c8c8cf">402</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c8c8cf">2235</td><td style="background-color: #c8c8cf">5.6</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">":P i forgot to clear summin"</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf"><?php id(2206); ?></td><td style="background-color: #c8c8cf">480</td><td style="background-color: #c8c8cf"><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="28" height="15" alt="" /></td><td style="background-color: #c8c8cf">2110</td><td style="background-color: #c8c8cf">4.4</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"&lt;Lara_York&gt; a whore &lt;---*Doesnt see Ramos around here*"</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf">^SyNth</td><td style="background-color: #c8c8cf">461</td><td style="background-color: #c8c8cf"><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #c8c8cf">2073</td><td style="background-color: #c8c8cf">4.5</td><td style="background-color: #c8c8cf">2 days ago</td><td style="background-color: #c8c8cf">"[16:59] &lt;`Gen&gt; you missed the hookers and drinking"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce">`Malik</td><td style="background-color: #c8c8ce">364</td><td style="background-color: #c8c8ce"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c8c8ce">2042</td><td style="background-color: #c8c8ce">5.6</td><td style="background-color: #c8c8ce">Today</td><td style="background-color: #c8c8ce">"considering that she left."</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce">EH_Talon</td><td style="background-color: #c9c9ce">506</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c9c9ce">1890</td><td style="background-color: #c9c9ce">3.7</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"what is that, your cpu info?"</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce">TheReaper</td><td style="background-color: #c9c9ce">431</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c9c9ce">1859</td><td style="background-color: #c9c9ce">4.3</td><td style="background-color: #c9c9ce">17 days ago</td><td style="background-color: #c9c9ce">"how do you do that????????"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce">Holo</td><td style="background-color: #c9c9ce">344</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c9c9ce">1821</td><td style="background-color: #c9c9ce">5.3</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"no, no, no... I was dumb to begin with :P"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce"><?php id(1171); ?></td><td style="background-color: #c9c9ce">455</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c9c9ce">1765</td><td style="background-color: #c9c9ce">3.9</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"anyone have any ideas for a BHG realted gfx?"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd"><?php id(1281); ?></td><td style="background-color: #cacacd">313</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="24" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #cacacd">1694</td><td style="background-color: #cacacd">5.4</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"snow is alot better than sun"</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd">`Karrde`</td><td style="background-color: #cacacd">274</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #cacacd">1522</td><td style="background-color: #cacacd">5.6</td><td style="background-color: #cacacd">25 days ago</td><td style="background-color: #cacacd">"you wont ask, or he doesnt?"</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd">von_Ninj</td><td style="background-color: #cacacd">285</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #cacacd">1473</td><td style="background-color: #cacacd">5.2</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"in some Darth Maulie fic :P"</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd">`Xerxes</td><td style="background-color: #cacacd">238</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="30" height="15" alt="" /></td><td style="background-color: #cacacd">1435</td><td style="background-color: #cacacd">6.0</td><td style="background-color: #cacacd">9 days ago</td><td style="background-color: #cacacd">"And that great long stretch of beach that is Queensland..."</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc">Tavvi</td><td style="background-color: #cbcbcc">229</td><td style="background-color: #cbcbcc"><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="31" height="15" alt="" /></td><td style="background-color: #cbcbcc">1357</td><td style="background-color: #cbcbcc">5.9</td><td style="background-color: #cbcbcc">16 days ago</td><td style="background-color: #cbcbcc">"She's invited if she wants to come!"</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc">CAP_Drak</td><td style="background-color: #cbcbcc">272</td><td style="background-color: #cbcbcc"><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #cbcbcc">1320</td><td style="background-color: #cbcbcc">4.9</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"isnt ther a test version of Roster 3 out now..it could be that"</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc"><?php id(2172); ?></td><td style="background-color: #cbcbcc">259</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="27" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #cbcbcc">1210</td><td style="background-color: #cbcbcc">4.7</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"dont try .. for the sanity of an insane world"</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc">Bald_Mik</td><td style="background-color: #cbcbcc">367</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="23" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #cbcbcc">1197</td><td style="background-color: #cbcbcc">3.3</td><td style="background-color: #cbcbcc">1 day ago</td><td style="background-color: #cbcbcc">"A person who isIncompitant"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc"><?php id(1561); ?></td><td style="background-color: #cccccc">223</td><td style="background-color: #cccccc"><img src="./green-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #cccccc">1125</td><td style="background-color: #cccccc">5.0</td><td style="background-color: #cccccc">Today</td><td style="background-color: #cccccc">"yeah i remember when I used to be 5th on the stats"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10"><?php id(2213); ?> (1105)</td>
<td class="rankc10"><?php id(1165); ?> (1087)</td>
<td class="rankc10"><?php id(1247); ?> (1038)</td>
<td class="rankc10"><?php id(2131); ?> (983)</td>
<td class="rankc10"><?php id(182); ?> (943)</td>
</tr><tr>
<td class="rankc10">Wally-Dog (924)</td>
<td class="rankc10">Xar_Kahn (917)</td>
<td class="rankc10"><?php id(1064); ?> (876)</td>
<td class="rankc10">`Janson` (871)</td>
<td class="rankc10">_Zodiac (864)</td>
</tr><tr>
<td class="rankc10"><?php id(2217); ?> (812)</td>
<td class="rankc10">Troile (811)</td>
<td class="rankc10"><?php id(95); ?> (806)</td>
<td class="rankc10">Obi Wan (EH) (792)</td>
<td class="rankc10"><?php id(45); ?> (759)</td>
</tr><tr>
<td class="rankc10">`SupaReap (758)</td>
<td class="rankc10">holchron (758)</td>
<td class="rankc10">Mage (758)</td>
<td class="rankc10">Mik_ (744)</td>
<td class="rankc10"><?php id(1198); ?> (741)</td>
</tr><tr>
<td class="rankc10">KarrdeAFK (737)</td>
<td class="rankc10">`Vlad (723)</td>
<td class="rankc10"><?php id(366); ?> (720)</td>
<td class="rankc10">t00bdaed (719)</td>
<td class="rankc10">Dash- (717)</td>
</tr><tr>
<td class="rankc10">Hated_Mik (706)</td>
<td class="rankc10"><?php id(2181); ?> (681)</td>
<td class="rankc10"><?php id(1187); ?> (613)</td>
<td class="rankc10"><?php id(1717); ?> (608)</td>
<td class="rankc10"><?php id(1711); ?> (592)</td>
</tr><tr>
<td class="rankc10">Tal-Pack (581)</td>
<td class="rankc10"><?php id(80); ?> (571)</td>
<td class="rankc10">`Reaper (565)</td>
<td class="rankc10"><?php id(1190); ?> (550)</td>
<td class="rankc10"><?php id(2219); ?> (527)</td>
</tr><tr>
<td class="rankc10"><?php id(64); ?> (493)</td>
<td class="rankc10"><?php id(1861); ?> (481)</td>
<td class="rankc10">ReavNWN (423)</td>
<td class="rankc10">`Syd|math (420)</td>
<td class="rankc10">King_Re (407)</td>
</tr></table>
<br /><b>By the way, there were 372 other nicks.</b><br />
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

<tr><td class="hicell">Is <b><?php id(1198); ?></b> stupid or just asking too many questions?  22.9% lines contained a question!
<br /><span class="small"><b><?php id(1943); ?></b> didn't know that much either.  20.5% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(488); ?></b>, who yelled 97.2% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b>D_Shadow</b>, who shouted 29.7% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b>Dash-</b>'s shift-key is hanging:  10.5% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[13:03] &lt;Dash-&gt; SIMPSONS!!!!!
</span><br />
<br /><span class="small"><b><?php id(488); ?></b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 10% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(331); ?></b> is a very aggressive person.  He/She attacked others <b>84</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[22:25] Action: Lara` beats Bograt with a baseball bat
</span><br />
<br /><span class="small"><b><?php id(57); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>49</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(1218); ?></b>, nobody likes him/her.  He/She was attacked <b>40</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[14:05] Action: Sexy_L beats the snot out of ChroBar
</span><br />
<br /><span class="small"><b><?php id(57); ?></b> seems to be unliked too.  He/She got beaten <b>25</b> times.</span>
</td></tr>
<tr><td class="hicell"><b>MiniReapa</b> brings happiness to the world.  54.5% lines contained smiling faces.  :)
<br /><span class="small"><b>`Janson`</b> isn't a sad person either, smiling 52.8% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(2217); ?></b> seems to be sad at the moment:  3.7% lines contained sad faces.  :(
<br /><span class="small"><b>KarrdeAFK</b> is also a sad person, crying 2.4% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(2122); ?></b> wrote the longest lines, averaging 59.0 letters per line.<br />
<span class="small">#bhg average was 29.2 letters per line.</span></td></tr>
<tr><td class="hicell"><b><?php id(2181); ?></b> wrote the shortest lines, averaging 12.4 characters per line.<br />
<span class="small"><b>Firedemon</b> was tight-lipped, too, averaging 12.6 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(331); ?></b> spoke a total of 38229 words!
<br /><span class="small"><?php id(331); ?>'s faithful follower, <b><?php id(2122); ?></b>, didn't speak so much: 36573 words.</span>
</td></tr>
<tr><td class="hicell"><b>MottiAway</b> wrote an average of 23.00 words per line.
<br /><span class="small">Channel average was 5.72 words per line.</span>
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
<td class="hicell">4183</td>
<td class="hicell"><?php id(57); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell">about</td>
<td class="hicell">1957</td>
<td class="hicell"><?php id(1594); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell">think</td>
<td class="hicell">1574</td>
<td class="hicell"><?php id(1625); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell">there</td>
<td class="hicell">1425</td>
<td class="hicell">D_Shadow</td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">people</td>
<td class="hicell">1125</td>
<td class="hicell"><?php id(57); ?></td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">would</td>
<td class="hicell">1088</td>
<td class="hicell"><?php id(331); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">really</td>
<td class="hicell">1077</td>
<td class="hicell"><?php id(1699); ?></td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">right</td>
<td class="hicell">1010</td>
<td class="hicell"><?php id(1625); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">going</td>
<td class="hicell">893</td>
<td class="hicell">D_Shadow</td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">again</td>
<td class="hicell">881</td>
<td class="hicell"><?php id(1625); ?></td>
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
<td class="hicell"><?php id(1218); ?></td>
<td class="hicell">21863</td>
<td class="hicell"><?php id(331); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(300); ?></td>
<td class="hicell">2103</td>
<td class="hicell"><?php id(168); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(331); ?></td>
<td class="hicell">1766</td>
<td class="hicell"><?php id(331); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(57); ?></td>
<td class="hicell">1680</td>
<td class="hicell"><?php id(14); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(45); ?></td>
<td class="hicell">1532</td>
<td class="hicell">Lara_HW</td>
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
<td class="hicell">Misticalm</td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://specialist.thebhg.org/irc/cindy.jpg">http://specialist.thebhg.org/irc/cindy.jpg</a></td>
<td class="hicell">8</td>
<td class="hicell">Xar_Kahn</td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://boards.thebhg.org/index.php?op=view&amp;topic=4030">http://boards.thebhg.org/index.php?op=view&amp;topic=4030</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(473); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://www.thebhg.org/main/quotes3.php">http://www.thebhg.org/main/quotes3.php</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(85); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://specialist.thebhg.org/kkbbgen_catfight.txt">http://specialist.thebhg.org/kkbbgen_catfight.txt</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(1171); ?></td>
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

<tr><td class="hicell"><b><?php id(57); ?></b> wasn't very popular, getting kicked 33 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[22:44] `Gen kicked from #bhg by `TheBaron: *PONG*
</span><br />
<br /><span class="small"><b><?php id(331); ?></b> seemed to be hated too:  14 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(85); ?></b> is either insane or just a fair op, kicking a total of 95 people!
<br /><span class="small"><?php id(85); ?>'s faithful follower, <b>LawnGnome</b>, kicked about 78 people.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> donated 35 ops in the channel...
<br /><span class="small"><b><?php id(85); ?></b> was also very polite: 8 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> is the channel sheriff with 12 deops.
<br /><span class="small"><b><?php id(168); ?></b> deoped 8 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(57); ?></b> always lets us know what he/she's doing: 832 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[14:45] Action: `Gen nods..and pizza hot
</span><br />
<br /><span class="small">Also, <b><?php id(331); ?></b> tells us what's up with 596 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1551); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 35 times!
<br /><span class="small">Another lonely one was <b><?php id(1908); ?></b>, who managed to hit 23 times.</span>
</td></tr>
<tr><td class="hicell"><b>D_Shadow</b> couldn't decide whether to stay or go.  188 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>Mik|Away</b> has quite a potty mouth.  3.3% words were foul language.
<br /><span class="small"><b>Evil_Mik</b> also makes sailors blush, 2.4% of the time.</span>
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

<tr><td class="hicell"><i><a href="http://boards.thebhg.org/index.php?op=view&amp;topic=4108&amp;page=1" target="_blank" title="Open in new window: http://boards.thebhg.org/index.php?op=view&amp;topic=4108&amp;page=1">http://boards.thebhg.org/index.php?op=view&amp;topic=4108&amp;page=1</a> =-= <a href="http://www.reuters.co.uk/newsArticle.jhtml?type=oddlyEnoughNews&amp;storyID=1508314" target="_blank" title="Open in new window: http://www.reuters.co.uk/newsArticle.jhtml?type=oddlyEnoughNews&amp;storyID=1508314">http://www.reuters.co.uk/newsArticle.jhtml?type=oddlyEnoughNews&amp;storyID=1508314</a> &lt;-- Vote Third </i></td>
<td class="hicell"><b>by <?php id(85); ?> on 09:24</b></td></tr>
<tr><td class="hicell"><i>idlines collate and send to <a href="mailto:adam_ashley@softhome.net" title="Mail to adam_ashley@softhome.net">adam_ashley@softhome.net</a></i></td>
<td class="hicell"><b>by Fruity on 11:30</b></td></tr>
<tr><td class="hicell"><i>(fordprefect) When the revolution comes, Ford claims Michelle Branch as his spoil of war...and maybe Luxembourg too. || The HCI will be first against the wall.</i></td>
<td class="hicell"><b>by <?php id(666); ?> on 12:13</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 158 times.</td></tr>
</table>
Total number of lines: 141322.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 01 minutes and 05 seconds
</span>
</div>
</body>
</html>

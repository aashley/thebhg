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
Statistics generated on  Monday 12 May 2003 - 8:02:45
<br />During this 30-day reporting period, a total of <b>714</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">5.0%<br /><img src="./blue-v.png" width="15" height="74.4016382951491" alt="5.0" /></td>

<td align="center" valign="bottom" class="asmall">4.4%<br /><img src="./blue-v.png" width="15" height="66.4149494432356" alt="4.4" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./blue-v.png" width="15" height="57.8778958146679" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">2.6%<br /><img src="./blue-v.png" width="15" height="39.0630999616025" alt="2.6" /></td>

<td align="center" valign="bottom" class="asmall">2.1%<br /><img src="./blue-v.png" width="15" height="31.2555996416229" alt="2.1" /></td>

<td align="center" valign="bottom" class="asmall">1.3%<br /><img src="./blue-v.png" width="15" height="19.8643286829643" alt="1.3" /></td>

<td align="center" valign="bottom" class="asmall">1.7%<br /><img src="./green-v.png" width="15" height="26.4047100985537" alt="1.7" /></td>

<td align="center" valign="bottom" class="asmall">1.6%<br /><img src="./green-v.png" width="15" height="24.4976321515423" alt="1.6" /></td>

<td align="center" valign="bottom" class="asmall">1.7%<br /><img src="./green-v.png" width="15" height="26.2767182900294" alt="1.7" /></td>

<td align="center" valign="bottom" class="asmall">2.5%<br /><img src="./green-v.png" width="15" height="37.9751695891463" alt="2.5" /></td>

<td align="center" valign="bottom" class="asmall">2.7%<br /><img src="./green-v.png" width="15" height="40.7909893766799" alt="2.7" /></td>

<td align="center" valign="bottom" class="asmall">4.7%<br /><img src="./green-v.png" width="15" height="70.4466914117497" alt="4.7" /></td>

<td align="center" valign="bottom" class="asmall">4.5%<br /><img src="./yellow-v.png" width="15" height="67.118904390119" alt="4.5" /></td>

<td align="center" valign="bottom" class="asmall">5.2%<br /><img src="./yellow-v.png" width="15" height="78.2413925508767" alt="5.2" /></td>

<td align="center" valign="bottom" class="asmall">5.4%<br /><img src="./yellow-v.png" width="15" height="80.5580442851657" alt="5.4" /></td>

<td align="center" valign="bottom" class="asmall">5.8%<br /><img src="./yellow-v.png" width="15" height="87.0600281581979" alt="5.8" /></td>

<td align="center" valign="bottom" class="asmall">5.7%<br /><img src="./yellow-v.png" width="15" height="85.4473313707923" alt="5.7" /></td>

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./yellow-v.png" width="15" height="73.646486624856" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">4.5%<br /><img src="./red-v.png" width="15" height="68.2196339434276" alt="4.5" /></td>

<td align="center" valign="bottom" class="asmall">4.5%<br /><img src="./red-v.png" width="15" height="67.6564699859209" alt="4.5" /></td>

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./red-v.png" width="15" height="73.0705234864969" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">6.1%<br /><img src="./red-v.png" width="15" height="91.2069627543837" alt="6.1" /></td>

<td align="center" valign="bottom" class="asmall">6.7%<br /><img src="./red-v.png" width="15" height="100" alt="6.7" /></td>

<td align="center" valign="bottom" class="asmall">5.4%<br /><img src="./red-v.png" width="15" height="80.8268270830667" alt="5.4" /></td>

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
<td style="background-color: #babadc"><?php id(1247); ?></td><td style="background-color: #babadc">6227</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #babadc">31392</td><td style="background-color: #babadc">5.0</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"True, im a brit, and im silly"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(331); ?></td><td style="background-color: #babadc">7051</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #babadc">30282</td><td style="background-color: #babadc">4.3</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"not necessarily in that order"</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc">`Holo</td><td style="background-color: #babadc">4236</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="25" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #babadc">25214</td><td style="background-color: #babadc">6.0</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"you know what that means, right, conan?"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(57); ?></td><td style="background-color: #babadc">3354</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #babadc">22948</td><td style="background-color: #babadc">6.8</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"there's the address you want"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(370); ?></td><td style="background-color: #bbbbdb">3456</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bbbbdb">20698</td><td style="background-color: #bbbbdb">6.0</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"fruity: what about permissions to write to the directory?"</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(168); ?></td><td style="background-color: #bbbbdb">2077</td><td style="background-color: #bbbbdb"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="27" height="15" alt="" /></td><td style="background-color: #bbbbdb">18351</td><td style="background-color: #bbbbdb">8.8</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"Coranel: bots in other channels, ala LawnGnome"</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(1187); ?></td><td style="background-color: #bbbbdb">2258</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bbbbdb">15248</td><td style="background-color: #bbbbdb">6.8</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"some hunter has the entire 99 bottles of beer song as his quote"</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(666); ?></td><td style="background-color: #bbbbdb">1513</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bbbbdb">14655</td><td style="background-color: #bbbbdb">9.7</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"no. i borrowed the question mark from LG, who does"</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda">Reap</td><td style="background-color: #bcbcda">3053</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bcbcda">12773</td><td style="background-color: #bcbcda">4.2</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"Slag..there's a lot of boys here without @ :P"</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(1625); ?></td><td style="background-color: #bcbcda">2309</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="29" height="15" alt="" /></td><td style="background-color: #bcbcda">12151</td><td style="background-color: #bcbcda">5.3</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"I'm so tired and out of it"</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(1594); ?></td><td style="background-color: #bcbcda">3835</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bcbcda">11943</td><td style="background-color: #bcbcda">3.1</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"if only for a sec...then you aren't wb! :P"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(95); ?></td><td style="background-color: #bcbcda">1880</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bcbcda">10868</td><td style="background-color: #bcbcda">5.8</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"depends what your sucking :P"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda">FruitCak</td><td style="background-color: #bdbdda">934</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #bdbdda">8483</td><td style="background-color: #bdbdda">9.1</td><td style="background-color: #bdbdda">Today</td><td style="background-color: #bdbdda">"Fault:                  Improper bladder control."</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9"><?php id(16); ?></td><td style="background-color: #bdbdd9">923</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bdbdd9">7706</td><td style="background-color: #bdbdd9">8.3</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"DS: you haven't said 'art' yet &gt;:P"</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(23); ?></td><td style="background-color: #bdbdd9">1046</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #bdbdd9">6703</td><td style="background-color: #bdbdd9">6.4</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"don't make me stab you Gen :P"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(1754); ?></td><td style="background-color: #bdbdd9">1318</td><td style="background-color: #bdbdd9"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="34" height="15" alt="" /></td><td style="background-color: #bdbdd9">6695</td><td style="background-color: #bdbdd9">5.1</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"<a href="http://encarta.msn.com/list/10WordsYouSimplyMustKnow.asp" target="_blank" title="Open in new window: http://encarta.msn.com/list/10WordsYouSimplyMustKnow.asp">http://encarta.msn.com/list/10WordsYouSimplyMustKnow.asp</a>"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(494); ?></td><td style="background-color: #bebed9">1182</td><td style="background-color: #bebed9"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #bebed9">6692</td><td style="background-color: #bebed9">5.7</td><td style="background-color: #bebed9">Today</td><td style="background-color: #bebed9">"Who likes pictures of Lulu?"</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8">^SyNth</td><td style="background-color: #bebed8">1626</td><td style="background-color: #bebed8"><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bebed8">6510</td><td style="background-color: #bebed8">4.0</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"what? should I say excited?"</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(1281); ?></td><td style="background-color: #bebed8">1245</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="24" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bebed8">6462</td><td style="background-color: #bebed8">5.2</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"friggin viruses *muttermumble*"</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8">Furjon</td><td style="background-color: #bebed8">1587</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bebed8">6227</td><td style="background-color: #bebed8">3.9</td><td style="background-color: #bebed8">1 day ago</td><td style="background-color: #bebed8">"its just I don't know WHAT THE HECK anything means"</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8">FruitCak_</td><td style="background-color: #bfbfd8">705</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="22" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bfbfd8">5948</td><td style="background-color: #bfbfd8">8.4</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"`Down,' she said, `is in fact the other way.'"</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(473); ?></td><td style="background-color: #bfbfd8">1294</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bfbfd8">5879</td><td style="background-color: #bfbfd8">4.5</td><td style="background-color: #bfbfd8">1 day ago</td><td style="background-color: #bfbfd8">"Dear Slice...its Ramos and he's trying to be cool."</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7"><?php id(1583); ?></td><td style="background-color: #bfbfd7">987</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #bfbfd7">5785</td><td style="background-color: #bfbfd7">5.9</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"and purple Jers running around"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7">NvM</td><td style="background-color: #bfbfd7">847</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bfbfd7">5593</td><td style="background-color: #bfbfd7">6.6</td><td style="background-color: #bfbfd7">3 days ago</td><td style="background-color: #bfbfd7">"but not ninj4, cause his very name annoys me :P"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(1843); ?></td><td style="background-color: #c0c0d7">1674</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c0c0d7">5416</td><td style="background-color: #c0c0d7">3.2</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"Monster Bash is still the bestest"</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(135); ?></td><td style="background-color: #c0c0d7">858</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c0c0d7">5210</td><td style="background-color: #c0c0d7">6.1</td><td style="background-color: #c0c0d7">7 days ago</td><td style="background-color: #c0c0d7">"they're becoming Idols.. American Idols! :P"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6">S_the_C</td><td style="background-color: #c0c0d6">1010</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c0c0d6">5164</td><td style="background-color: #c0c0d6">5.1</td><td style="background-color: #c0c0d6">5 days ago</td><td style="background-color: #c0c0d6">"he had a position to start with?"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6"><?php id(1036); ?></td><td style="background-color: #c0c0d6">628</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c0c0d6">4631</td><td style="background-color: #c0c0d6">7.4</td><td style="background-color: #c0c0d6">15 days ago</td><td style="background-color: #c0c0d6">"*does that weird Catholic air-crossing thing*"</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(747); ?></td><td style="background-color: #c0c0d6">1125</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="20" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c0c0d6">4621</td><td style="background-color: #c0c0d6">4.1</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"like i could give it to you :P"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6"><?php id(141); ?></td><td style="background-color: #c1c1d6">891</td><td style="background-color: #c1c1d6"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c1c1d6">4610</td><td style="background-color: #c1c1d6">5.2</td><td style="background-color: #c1c1d6">Today</td><td style="background-color: #c1c1d6">"thus the ugh..."</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5"><?php id(1332); ?></td><td style="background-color: #c1c1d5">1128</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="20" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c1c1d5">4365</td><td style="background-color: #c1c1d5">3.9</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"just kill him virga, you'll feel better."</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5">`MK</td><td style="background-color: #c1c1d5">789</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c1c1d5">4299</td><td style="background-color: #c1c1d5">5.4</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"why do people have such crap on mp3..."</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5"><?php id(14); ?></td><td style="background-color: #c1c1d5">611</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c1c1d5">4145</td><td style="background-color: #c1c1d5">6.8</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"Wee*&amp;!"</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5">MiniElf</td><td style="background-color: #c2c2d5">972</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c2c2d5">4104</td><td style="background-color: #c2c2d5">4.2</td><td style="background-color: #c2c2d5">2 days ago</td><td style="background-color: #c2c2d5">"The town I live in is not so bad."</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5"><?php id(2118); ?></td><td style="background-color: #c2c2d5">828</td><td style="background-color: #c2c2d5"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="31" height="15" alt="" /></td><td style="background-color: #c2c2d5">4088</td><td style="background-color: #c2c2d5">4.9</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"your friend handed me my ass"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(1722); ?></td><td style="background-color: #c2c2d4">945</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c2c2d4">3742</td><td style="background-color: #c2c2d4">4.0</td><td style="background-color: #c2c2d4">15 days ago</td><td style="background-color: #c2c2d4">"well then ive got an action packed day ahead of me"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4"><?php id(275); ?></td><td style="background-color: #c2c2d4">503</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="22" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c2c2d4">3172</td><td style="background-color: #c2c2d4">6.3</td><td style="background-color: #c2c2d4">3 days ago</td><td style="background-color: #c2c2d4">"cour and his abuse of his ops"</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4"><?php id(484); ?></td><td style="background-color: #c3c3d4">525</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c3c3d4">3171</td><td style="background-color: #c3c3d4">6.0</td><td style="background-color: #c3c3d4">2 days ago</td><td style="background-color: #c3c3d4">"you're competing for the same guy/girl? :P"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(1829); ?></td><td style="background-color: #c3c3d4">768</td><td style="background-color: #c3c3d4"><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #c3c3d4">3128</td><td style="background-color: #c3c3d4">4.1</td><td style="background-color: #c3c3d4">1 day ago</td><td style="background-color: #c3c3d4">"Bah... i'm on the Holonet now..."</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3"><?php id(295); ?></td><td style="background-color: #c3c3d3">477</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c3c3d3">3045</td><td style="background-color: #c3c3d3">6.4</td><td style="background-color: #c3c3d3">24 days ago</td><td style="background-color: #c3c3d3">"Well, how else is he gonna figure anything out?"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3"><?php id(1085); ?></td><td style="background-color: #c3c3d3">745</td><td style="background-color: #c3c3d3"><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c3c3d3">3021</td><td style="background-color: #c3c3d3">4.1</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"If I had one, I would keep it, anyways. :P"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3"><?php id(1133); ?></td><td style="background-color: #c4c4d3">690</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="30" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c4c4d3">2890</td><td style="background-color: #c4c4d3">4.2</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"Gen, he's Holos new bitch in the BHG"</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3">Adian</td><td style="background-color: #c4c4d3">534</td><td style="background-color: #c4c4d3"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="33" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c4c4d3">2819</td><td style="background-color: #c4c4d3">5.3</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"i'd throw Lara in there but she'd like it "</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(94); ?></td><td style="background-color: #c4c4d3">288</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="22" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c4c4d3">2700</td><td style="background-color: #c4c4d3">9.4</td><td style="background-color: #c4c4d3">2 days ago</td><td style="background-color: #c4c4d3">"woohoo im back im back im back"</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2"><?php id(11); ?></td><td style="background-color: #c4c4d2">384</td><td style="background-color: #c4c4d2"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c4c4d2">2513</td><td style="background-color: #c4c4d2">6.5</td><td style="background-color: #c4c4d2">1 day ago</td><td style="background-color: #c4c4d2">"how's your internet been today, Jer?"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2">Sayo</td><td style="background-color: #c5c5d2">326</td><td style="background-color: #c5c5d2"><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #c5c5d2">2305</td><td style="background-color: #c5c5d2">7.1</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"New Your? havn't heard of that one Nyk..."</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2">CPT_Trent</td><td style="background-color: #c5c5d2">343</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="19" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c5c5d2">2228</td><td style="background-color: #c5c5d2">6.5</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"what are you doing at Lara's house anyway? :P"</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2"><?php id(45); ?></td><td style="background-color: #c5c5d2">286</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c5c5d2">2064</td><td style="background-color: #c5c5d2">7.2</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"just reading the MB, emails etc"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1">DF|Busy</td><td style="background-color: #c5c5d1">275</td><td style="background-color: #c5c5d1"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c5c5d1">2010</td><td style="background-color: #c5c5d1">7.3</td><td style="background-color: #c5c5d1">Today</td><td style="background-color: #c5c5d1">"also get the norton update"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1"><?php id(577); ?></td><td style="background-color: #c6c6d1">404</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c6c6d1">1990</td><td style="background-color: #c6c6d1">4.9</td><td style="background-color: #c6c6d1">6 days ago</td><td style="background-color: #c6c6d1">"but he can be shut down, it's just very difficult"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1">Arys</td><td style="background-color: #c6c6d1">461</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="35" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c6c6d1">1969</td><td style="background-color: #c6c6d1">4.3</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"Like, the one in your whois?"</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1">SanSri</td><td style="background-color: #c6c6d1">455</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="28" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c6c6d1">1927</td><td style="background-color: #c6c6d1">4.2</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"I didn't make it to the third disc"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0"><?php id(300); ?></td><td style="background-color: #c6c6d0">232</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="25" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c6c6d0">1926</td><td style="background-color: #c6c6d0">8.3</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"I generally just play with god mode on for giggles :P"</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0">MaraHarle</td><td style="background-color: #c6c6d0">365</td><td style="background-color: #c6c6d0"><img src="./green-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c6c6d0">1925</td><td style="background-color: #c6c6d0">5.3</td><td style="background-color: #c6c6d0">13 days ago</td><td style="background-color: #c6c6d0">"this sucks my toen is so damn small"</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0"><?php id(182); ?></td><td style="background-color: #c7c7d0">288</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c7c7d0">1915</td><td style="background-color: #c7c7d0">6.6</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"aye them kickass cars with little figs wearing... masks!"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0">StvDallas</td><td style="background-color: #c7c7d0">324</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="24" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c7c7d0">1875</td><td style="background-color: #c7c7d0">5.8</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"ok a BH who has a background in law :P"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0"><?php id(1699); ?></td><td style="background-color: #c7c7d0">391</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="22" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c7c7d0">1867</td><td style="background-color: #c7c7d0">4.8</td><td style="background-color: #c7c7d0">3 days ago</td><td style="background-color: #c7c7d0">"kept some choice emails (porn)"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf"><?php id(1803); ?></td><td style="background-color: #c7c7cf">301</td><td style="background-color: #c7c7cf"><img src="./blue-h.png" border="0" width="29" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c7c7cf">1776</td><td style="background-color: #c7c7cf">5.9</td><td style="background-color: #c7c7cf">Today</td><td style="background-color: #c7c7cf">"thats good, anything interesting happen recently?"</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf">_Xar</td><td style="background-color: #c8c8cf">234</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="30" height="15" alt="" /></td><td style="background-color: #c8c8cf">1775</td><td style="background-color: #c8c8cf">7.6</td><td style="background-color: #c8c8cf">3 days ago</td><td style="background-color: #c8c8cf">"Q: How is Bin Laden like Fred Flintstone?"</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf">HolyFord</td><td style="background-color: #c8c8cf">315</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c8c8cf">1600</td><td style="background-color: #c8c8cf">5.1</td><td style="background-color: #c8c8cf">3 days ago</td><td style="background-color: #c8c8cf">"District track meet's a week from tomorrow."</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf">Walldawg</td><td style="background-color: #c8c8cf">413</td><td style="background-color: #c8c8cf"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="34" height="15" alt="" /></td><td style="background-color: #c8c8cf">1539</td><td style="background-color: #c8c8cf">3.7</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"but thats wut they clal then fine"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce"><?php id(1413); ?></td><td style="background-color: #c8c8ce">341</td><td style="background-color: #c8c8ce"><img src="./blue-h.png" border="0" width="25" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c8c8ce">1527</td><td style="background-color: #c8c8ce">4.5</td><td style="background-color: #c8c8ce">13 days ago</td><td style="background-color: #c8c8ce">"Trading down is Brisbane to Canberra"</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce"><?php id(366); ?></td><td style="background-color: #c9c9ce">199</td><td style="background-color: #c9c9ce"><img src="./red-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #c9c9ce">1419</td><td style="background-color: #c9c9ce">7.1</td><td style="background-color: #c9c9ce">24 days ago</td><td style="background-color: #c9c9ce">"Web based chat applet, ne?"</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce">`StCT</td><td style="background-color: #c9c9ce">251</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c9c9ce">1390</td><td style="background-color: #c9c9ce">5.5</td><td style="background-color: #c9c9ce">6 days ago</td><td style="background-color: #c9c9ce">"is it on a planet, or in space:P"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce">Cap`n_C</td><td style="background-color: #c9c9ce">403</td><td style="background-color: #c9c9ce"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="33" height="15" alt="" /></td><td style="background-color: #c9c9ce">1366</td><td style="background-color: #c9c9ce">3.4</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"Everyone just calm down..."</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce">MK</td><td style="background-color: #c9c9ce">196</td><td style="background-color: #c9c9ce"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c9c9ce">1343</td><td style="background-color: #c9c9ce">6.9</td><td style="background-color: #c9c9ce">1 day ago</td><td style="background-color: #c9c9ce">"i never get enough occasions to wear mine"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd"><?php id(1103); ?></td><td style="background-color: #cacacd">267</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #cacacd">1339</td><td style="background-color: #cacacd">5.0</td><td style="background-color: #cacacd">7 days ago</td><td style="background-color: #cacacd">"looking forward to starting that ^_^"</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd">^SyNthPHP</td><td style="background-color: #cacacd">274</td><td style="background-color: #cacacd"><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #cacacd">1298</td><td style="background-color: #cacacd">4.7</td><td style="background-color: #cacacd">3 days ago</td><td style="background-color: #cacacd">"btw: she's supposedly naked and clinging to your leg :P"</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd">XanIra`an</td><td style="background-color: #cacacd">180</td><td style="background-color: #cacacd"><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="35" height="15" alt="" /></td><td style="background-color: #cacacd">1164</td><td style="background-color: #cacacd">6.5</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"shoudln't it be like, puff?"</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd">FurFreak</td><td style="background-color: #cacacd">263</td><td style="background-color: #cacacd"><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="27" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #cacacd">1134</td><td style="background-color: #cacacd">4.3</td><td style="background-color: #cacacd">8 days ago</td><td style="background-color: #cacacd">"hows it be goinging with you my (wo)man?"</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc">Schooling</td><td style="background-color: #cbcbcc">221</td><td style="background-color: #cbcbcc"><img src="./yellow-h.png" border="0" width="40" height="15" alt="" /></td><td style="background-color: #cbcbcc">1132</td><td style="background-color: #cbcbcc">5.1</td><td style="background-color: #cbcbcc">1 day ago</td><td style="background-color: #cbcbcc">"I kinda clicked the darn disconnect button"</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc">Mal|away</td><td style="background-color: #cbcbcc">213</td><td style="background-color: #cbcbcc"><img src="./green-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #cbcbcc">1131</td><td style="background-color: #cbcbcc">5.3</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"the kind of boots that reach all the way up to your boxers?"</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc"><?php id(1489); ?></td><td style="background-color: #cbcbcc">247</td><td style="background-color: #cbcbcc"><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #cbcbcc">1127</td><td style="background-color: #cbcbcc">4.6</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"i spell things the dang way I want to spell thengz"</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc">Dash-</td><td style="background-color: #cbcbcc">264</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="32" height="15" alt="" /></td><td style="background-color: #cbcbcc">1014</td><td style="background-color: #cbcbcc">3.8</td><td style="background-color: #cbcbcc">9 days ago</td><td style="background-color: #cbcbcc">"PIFFLE!!!!!!!!!!!!!!!!!!!!!!!!"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc">LY|hw</td><td style="background-color: #cccccc">207</td><td style="background-color: #cccccc"><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="36" height="15" alt="" /></td><td style="background-color: #cccccc">985</td><td style="background-color: #cccccc">4.8</td><td style="background-color: #cccccc">1 day ago</td><td style="background-color: #cccccc">"[17:57] &lt;Coranel&gt; battle of NO"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10">_FruitCak (967)</td>
<td class="rankc10">____-away (964)</td>
<td class="rankc10"><?php id(175); ?> (955)</td>
<td class="rankc10">`Dagger (950)</td>
<td class="rankc10"><?php id(152); ?> (943)</td>
</tr><tr>
<td class="rankc10">UncleFord (932)</td>
<td class="rankc10">Msgt_FJ (931)</td>
<td class="rankc10"><?php id(1772); ?> (919)</td>
<td class="rankc10">UltraFord (886)</td>
<td class="rankc10">Fyre (875)</td>
</tr><tr>
<td class="rankc10">Stilipoo (865)</td>
<td class="rankc10">Schoolin (856)</td>
<td class="rankc10"><?php id(242); ?> (837)</td>
<td class="rankc10">HoloBRB (831)</td>
<td class="rankc10">holodrunk (820)</td>
</tr><tr>
<td class="rankc10">^Ice (820)</td>
<td class="rankc10"><?php id(1219); ?> (811)</td>
<td class="rankc10"><?php id(1943); ?> (782)</td>
<td class="rankc10">^Fyre (776)</td>
<td class="rankc10"><?php id(2070); ?> (755)</td>
</tr><tr>
<td class="rankc10"><?php id(229); ?> (714)</td>
<td class="rankc10">Juke (697)</td>
<td class="rankc10">Kailani (693)</td>
<td class="rankc10"><?php id(1218); ?> (685)</td>
<td class="rankc10">l337ninj4 (671)</td>
</tr><tr>
<td class="rankc10"><?php id(1356); ?> (668)</td>
<td class="rankc10"><?php id(1717); ?> (656)</td>
<td class="rankc10">M`aR`k (647)</td>
<td class="rankc10"><?php id(1700); ?> (628)</td>
<td class="rankc10">Mako (625)</td>
</tr><tr>
<td class="rankc10"><?php id(1711); ?> (625)</td>
<td class="rankc10"><?php id(1225); ?> (615)</td>
<td class="rankc10"><?php id(765); ?> (607)</td>
<td class="rankc10">Skorbles (604)</td>
<td class="rankc10">CatDAn (572)</td>
</tr><tr>
<td class="rankc10">`Mav` (556)</td>
<td class="rankc10">Xar_ (549)</td>
<td class="rankc10"><?php id(1771); ?> (536)</td>
<td class="rankc10">UberFord (533)</td>
<td class="rankc10"><?php id(2029); ?> (524)</td>
</tr></table>
<br /><b>By the way, there were 597 other nicks.</b><br />
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

<tr><td class="hicell">Is <b>Sayo</b> stupid or just asking too many questions?  21.7% lines contained a question!
<br /><span class="small"><b><?php id(765); ?></b> didn't know that much either.  20.3% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(2070); ?></b>, who yelled 51.9% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(1829); ?></b>, who shouted 40.2% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b><?php id(1219); ?></b>'s shift-key is hanging:  11.4% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[11:29] &lt;TLFVFTN&gt; CCCCCCCCCCCCCCCCCCCCCCCCCCCCHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHEEEEEEEEEEEEEEEEEEEEEEEEEEEEEWWWWWWWWWWWWWWWWWWWWWWWWWIIIIIIIIIIIIIIIIIIIIIIIIIEEEEEEEEEEEEEEEEEE
</span><br />
<br /><span class="small"><b>Cap`n_C</b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 9.4% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(331); ?></b> is a very aggressive person.  He/She attacked others <b>42</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[22:36] Action: `Lara slaps Furjon
</span><br />
<br /><span class="small"><b><?php id(1247); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>41</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b>Conan</b>, nobody likes him/her.  He/She was attacked <b>44</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[09:50] Action: `Lara slaps Conan
</span><br />
<br /><span class="small"><b><?php id(1198); ?></b> seems to be unliked too.  He/She got beaten <b>37</b> times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1700); ?></b> brings happiness to the world.  50.7% lines contained smiling faces.  :)
<br /><span class="small"><b><?php id(135); ?></b> isn't a sad person either, smiling 45.3% of the time.</span>
</td></tr>
<tr><td class="hicell"><b>`Mav`</b> seems to be sad at the moment:  5.1% lines contained sad faces.  :(
<br /><span class="small"><b><?php id(747); ?></b> is also a sad person, crying 2.9% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(666); ?></b> wrote the longest lines, averaging 50.8 letters per line.<br />
<span class="small">#bhg average was 26.8 letters per line.</span></td></tr>
<tr><td class="hicell"><b><?php id(2070); ?></b> wrote the shortest lines, averaging 13.4 characters per line.<br />
<span class="small"><b><?php id(1700); ?></b> was tight-lipped, too, averaging 14.3 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> spoke a total of 31392 words!
<br /><span class="small"><?php id(1247); ?>'s faithful follower, <b><?php id(331); ?></b>, didn't speak so much: 30282 words.</span>
</td></tr>
<tr><td class="hicell"><b>SleepBlah</b> wrote an average of 39.50 words per line.
<br /><span class="small">Channel average was 5.34 words per line.</span>
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
<td class="hicell"><?php id(1908); ?></td>
<td class="hicell">7286</td>
<td class="hicell"><?php id(1219); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(42); ?></td>
<td class="hicell">2989</td>
<td class="hicell"><?php id(16); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell">about</td>
<td class="hicell">1313</td>
<td class="hicell"><?php id(95); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell">think</td>
<td class="hicell">1095</td>
<td class="hicell"><?php id(2118); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">there</td>
<td class="hicell">1006</td>
<td class="hicell">Cor-stuff</td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">would</td>
<td class="hicell">892</td>
<td class="hicell"><?php id(16); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">people</td>
<td class="hicell">744</td>
<td class="hicell"><?php id(1772); ?></td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">right</td>
<td class="hicell">728</td>
<td class="hicell"><?php id(57); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">really</td>
<td class="hicell">723</td>
<td class="hicell"><?php id(1219); ?></td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">Conan</td>
<td class="hicell">668</td>
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
<td class="hicell"><?php id(1198); ?></td>
<td class="hicell">30761</td>
<td class="hicell"><?php id(1332); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(1085); ?></td>
<td class="hicell">14321</td>
<td class="hicell">Schooling</td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(331); ?></td>
<td class="hicell">12465</td>
<td class="hicell">FruitCak_</td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(1281); ?></td>
<td class="hicell">3037</td>
<td class="hicell"><?php id(370); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(300); ?></td>
<td class="hicell">1550</td>
<td class="hicell"><?php id(331); ?></td>
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
<td class="hicell">9</td>
<td class="hicell"><?php id(1594); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://www.ehnet.org/sabacc/">http://www.ehnet.org/sabacc/</a></td>
<td class="hicell">6</td>
<td class="hicell">`MK</td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://www.outwar.com/page.php?x=755453">http://www.outwar.com/page.php?x=755453</a></td>
<td class="hicell">6</td>
<td class="hicell">_Xar</td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://www.thebhg.org">http://www.thebhg.org</a></td>
<td class="hicell">5</td>
<td class="hicell"><?php id(494); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://lawngnome.cernun.net/lotto/">http://lawngnome.cernun.net/lotto/</a></td>
<td class="hicell">4</td>
<td class="hicell">^SyNth</td>
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

<tr><td class="hicell"><b><?php id(1594); ?></b> wasn't very popular, getting kicked 31 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[18:42] Coranel kicked from #bhg by Dalk:  Bastard
</span><br />
<br /><span class="small"><b><?php id(57); ?></b> seemed to be hated too:  17 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1625); ?></b> is either insane or just a fair op, kicking a total of 49 people!
<br /><span class="small"><?php id(1625); ?>'s faithful follower, <b><?php id(57); ?></b>, kicked about 32 people.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> donated 51 ops in the channel...
<br /><span class="small"><b><?php id(1625); ?></b> was also very polite: 16 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1625); ?></b> is the channel sheriff with 14 deops.
<br /><span class="small"><b>LawnGnome</b> deoped 11 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(331); ?></b> always lets us know what he/she's doing: 978 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[14:12] Action: `Lara licks Holo
</span><br />
<br /><span class="small">Also, <b><?php id(1247); ?></b> tells us what's up with 927 actions.</span>
</td></tr>
<tr><td class="hicell"><b>Furjon</b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 26 times!
<br /><span class="small">Another lonely one was <b>FruitCak</b>, who managed to hit 17 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(370); ?></b> couldn't decide whether to stay or go.  273 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>`merz</b> has quite a potty mouth.  2.0% words were foul language.
<br /><span class="small"><b>CuttrJohn</b> also makes sailors blush, 1.8% of the time.</span>
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

<tr><td class="hicell"><i>Jer resigns, effective May 10. || Only the follow offically recognised bots are permitted in kabal channels: X, Lawngnome, dasb0t and Chewie</i></td>
<td class="hicell"><b>by FruitCak on 21:54</b></td></tr>
<tr><td class="hicell"><i>Jer resigns, effective May 10. || Only the follow offically recognised bots are permitted in kabal channels: X, Lawngnome, dasb00t and Chewie</i></td>
<td class="hicell"><b>by FruitCak on 21:53</b></td></tr>
<tr><td class="hicell"><i>Jer resigns, effective May 10. || ALL Eggdrops from Kabal Channels are to be removed until the Commission can decide on ONE eggdrop for the channels.</i></td>
<td class="hicell"><b>by Cap`n_C on 22:25</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 195 times.</td></tr>
</table>
Total number of lines: 115952.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 01 minutes and 31 seconds
</span>
</div>
</body>
</html>

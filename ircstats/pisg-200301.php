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
Statistics generated on  Saturday 1 February 2003 - 11:27:42
<br />During this 31-day reporting period, a total of <b>767</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">5.5%<br /><img src="./blue-v.png" width="15" height="82.4323191685525" alt="5.5" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./blue-v.png" width="15" height="62.9536501550582" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">3.3%<br /><img src="./blue-v.png" width="15" height="49.4174838655603" alt="3.3" /></td>

<td align="center" valign="bottom" class="asmall">2.2%<br /><img src="./blue-v.png" width="15" height="33.0399798843349" alt="2.2" /></td>

<td align="center" valign="bottom" class="asmall">2.8%<br /><img src="./blue-v.png" width="15" height="41.5472299052887" alt="2.8" /></td>

<td align="center" valign="bottom" class="asmall">2.4%<br /><img src="./blue-v.png" width="15" height="35.7723577235772" alt="2.4" /></td>

<td align="center" valign="bottom" class="asmall">2.9%<br /><img src="./green-v.png" width="15" height="43.7683345905624" alt="2.9" /></td>

<td align="center" valign="bottom" class="asmall">2.8%<br /><img src="./green-v.png" width="15" height="41.6645712848881" alt="2.8" /></td>

<td align="center" valign="bottom" class="asmall">3.9%<br /><img src="./green-v.png" width="15" height="58.4695331489397" alt="3.9" /></td>

<td align="center" valign="bottom" class="asmall">4.1%<br /><img src="./green-v.png" width="15" height="61.4952644371805" alt="4.1" /></td>

<td align="center" valign="bottom" class="asmall">3.9%<br /><img src="./green-v.png" width="15" height="58.896991031766" alt="3.9" /></td>

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./green-v.png" width="15" height="73.3970329394016" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">4.7%<br /><img src="./yellow-v.png" width="15" height="70.3629201240466" alt="4.7" /></td>

<td align="center" valign="bottom" class="asmall">4.0%<br /><img src="./yellow-v.png" width="15" height="60.0787863548739" alt="4.0" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./yellow-v.png" width="15" height="57.6984326544296" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./yellow-v.png" width="15" height="62.8279272483447" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./yellow-v.png" width="15" height="63.4481602547984" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">4.3%<br /><img src="./yellow-v.png" width="15" height="64.2611683848797" alt="4.3" /></td>

<td align="center" valign="bottom" class="asmall">3.9%<br /><img src="./red-v.png" width="15" height="58.058838320342" alt="3.9" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./red-v.png" width="15" height="63.6744614868829" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">5.3%<br /><img src="./red-v.png" width="15" height="79.8089011817953" alt="5.3" /></td>

<td align="center" valign="bottom" class="asmall">4.7%<br /><img src="./red-v.png" width="15" height="70.656273573045" alt="4.7" /></td>

<td align="center" valign="bottom" class="asmall">6.7%<br /><img src="./red-v.png" width="15" height="100" alt="6.7" /></td>

<td align="center" valign="bottom" class="asmall">5.3%<br /><img src="./red-v.png" width="15" height="79.5742184225966" alt="5.3" /></td>

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
<td style="background-color: #babadc"><?php id(473); ?></td><td style="background-color: #babadc">8545</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #babadc">40415</td><td style="background-color: #babadc">4.7</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Some of these Acros are funny."</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(577); ?></td><td style="background-color: #babadc">6515</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #babadc">33813</td><td style="background-color: #babadc">5.2</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"meaning that you slide the stone?"</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(168); ?></td><td style="background-color: #babadc">3922</td><td style="background-color: #babadc"><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #babadc">33596</td><td style="background-color: #babadc">8.6</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"I thought that was every member of GWB's staff, beanie."</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(1551); ?></td><td style="background-color: #babadc">6903</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #babadc">31776</td><td style="background-color: #babadc">4.6</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"aeris, i thought you weren't allowed to come anymore?"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(370); ?></td><td style="background-color: #bbbbdb">5282</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #bbbbdb">29427</td><td style="background-color: #bbbbdb">5.6</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"loser...i downloaded GB anyways :-P"</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(747); ?></td><td style="background-color: #bbbbdb">7707</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="25" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #bbbbdb">27628</td><td style="background-color: #bbbbdb">3.6</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"no wait ... not Halloween ... Friday the 13th."</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(331); ?></td><td style="background-color: #bbbbdb">5425</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bbbbdb">24169</td><td style="background-color: #bbbbdb">4.5</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"You don't have enough creds. ;P"</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb">NindoF</td><td style="background-color: #bbbbdb">3499</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="25" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #bbbbdb">22214</td><td style="background-color: #bbbbdb">6.3</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"that actually makes the whole business make a little more sense."</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(1762); ?></td><td style="background-color: #bcbcda">5237</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bcbcda">21261</td><td style="background-color: #bcbcda">4.1</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"At least horses don't need gas...maybe I should do it. :P"</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(1247); ?></td><td style="background-color: #bcbcda">4092</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bcbcda">18337</td><td style="background-color: #bcbcda">4.5</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"anyone know OZ$ to UK£ conversion?"</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(1594); ?></td><td style="background-color: #bcbcda">4280</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bcbcda">17577</td><td style="background-color: #bcbcda">4.1</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"kresh: tell the boss types off, and quit...:P"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(666); ?></td><td style="background-color: #bcbcda">1806</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="23" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #bcbcda">17135</td><td style="background-color: #bcbcda">9.5</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"i think i've been in the sun too much"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(1103); ?></td><td style="background-color: #bdbdda">2838</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #bdbdda">17102</td><td style="background-color: #bdbdda">6.0</td><td style="background-color: #bdbdda">Today</td><td style="background-color: #bdbdda">"or hub thing or whatever you call it"</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9"><?php id(1332); ?></td><td style="background-color: #bdbdd9">3751</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./green-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #bdbdd9">16793</td><td style="background-color: #bdbdd9">4.5</td><td style="background-color: #bdbdd9">3 days ago</td><td style="background-color: #bdbdd9">"hmmm how come you don't hug me anymore?"</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(23); ?></td><td style="background-color: #bdbdd9">2818</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bdbdd9">16617</td><td style="background-color: #bdbdd9">5.9</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"I can't be bothered picking a target. It's symbiosis"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(135); ?></td><td style="background-color: #bdbdd9">2303</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #bdbdd9">15830</td><td style="background-color: #bdbdd9">6.9</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"ooooooh, burn, Jer... burn :P"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(57); ?></td><td style="background-color: #bebed9">2084</td><td style="background-color: #bebed9"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bebed9">13817</td><td style="background-color: #bebed9">6.6</td><td style="background-color: #bebed9">Today</td><td style="background-color: #bebed9">"do you want a cookie, conan?"</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8">MiniElf</td><td style="background-color: #bebed8">3189</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #bebed8">13737</td><td style="background-color: #bebed8">4.3</td><td style="background-color: #bebed8">1 day ago</td><td style="background-color: #bebed8">"And nobody knows it but me."</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(229); ?></td><td style="background-color: #bebed8">1487</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #bebed8">13567</td><td style="background-color: #bebed8">9.1</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"Guess what came in the mail today, Ninj?"</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(141); ?></td><td style="background-color: #bebed8">1952</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #bebed8">10932</td><td style="background-color: #bebed8">5.6</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"naa, dont kill everyone see, killing is so... barbaric"</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8"><?php id(242); ?></td><td style="background-color: #bfbfd8">1704</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #bfbfd8">10335</td><td style="background-color: #bfbfd8">6.1</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"are any kag events due today?"</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8">`Sayo</td><td style="background-color: #bfbfd8">1592</td><td style="background-color: #bfbfd8"><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #bfbfd8">10244</td><td style="background-color: #bfbfd8">6.4</td><td style="background-color: #bfbfd8">8 days ago</td><td style="background-color: #bfbfd8">"Soda, Soda pop, Acid for your stomach...that kinda stuff :P"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7">_-Mage-_</td><td style="background-color: #bfbfd7">1378</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #bfbfd7">9184</td><td style="background-color: #bfbfd7">6.7</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"You don't want my newb name, begone. :P"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7"><?php id(1843); ?></td><td style="background-color: #bfbfd7">2642</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #bfbfd7">8698</td><td style="background-color: #bfbfd7">3.3</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"however, we are loosing profits due to these occurances"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(1908); ?></td><td style="background-color: #c0c0d7">1846</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="22" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c0c0d7">8388</td><td style="background-color: #c0c0d7">4.5</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"someone ban me from #omega_kabal :P"</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7">Urban</td><td style="background-color: #c0c0d7">1487</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c0c0d7">8198</td><td style="background-color: #c0c0d7">5.5</td><td style="background-color: #c0c0d7">3 days ago</td><td style="background-color: #c0c0d7">"dasboot is german for The Boat ;)"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6"><?php id(1625); ?></td><td style="background-color: #c0c0d6">1244</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c0c0d6">7731</td><td style="background-color: #c0c0d6">6.2</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"There, now this is one scary Op party  :P"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6">Xar_</td><td style="background-color: #c0c0d6">1340</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c0c0d6">7471</td><td style="background-color: #c0c0d6">5.6</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"well if in the next fifteen mins I may be able to read it"</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(1829); ?></td><td style="background-color: #c0c0d6">1937</td><td style="background-color: #c0c0d6"><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c0c0d6">7383</td><td style="background-color: #c0c0d6">3.8</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"then the answer in plain! :P"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6"><?php id(484); ?></td><td style="background-color: #c1c1d6">1162</td><td style="background-color: #c1c1d6"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="32" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c1c1d6">7342</td><td style="background-color: #c1c1d6">6.3</td><td style="background-color: #c1c1d6">Today</td><td style="background-color: #c1c1d6">"woo! i've found my new quit message"</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5">^SyNth</td><td style="background-color: #c1c1d5">1898</td><td style="background-color: #c1c1d5"><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c1c1d5">7194</td><td style="background-color: #c1c1d5">3.8</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"i'll give you a hint, its from a book"</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5"><?php id(1754); ?></td><td style="background-color: #c1c1d5">1245</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c1c1d5">6684</td><td style="background-color: #c1c1d5">5.4</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"true, but it's a nescessary evil at times"</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5"><?php id(2118); ?></td><td style="background-color: #c1c1d5">1052</td><td style="background-color: #c1c1d5"><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #c1c1d5">6230</td><td style="background-color: #c1c1d5">5.9</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"should put up the AFC/NFC probowl"</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5"><?php id(1085); ?></td><td style="background-color: #c2c2d5">1721</td><td style="background-color: #c2c2d5"><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c2c2d5">6166</td><td style="background-color: #c2c2d5">3.6</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"ShaydeShaydeShaydeShaydeShaydeShaydeShaaaaaaaaayde!"</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5"><?php id(1699); ?></td><td style="background-color: #c2c2d5">1270</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="32" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c2c2d5">5810</td><td style="background-color: #c2c2d5">4.6</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"i'll have words to it, never fear"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(94); ?></td><td style="background-color: #c2c2d4">665</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c2c2d4">5613</td><td style="background-color: #c2c2d4">8.4</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"the bhg is really good at chewing up and spitting out SPs"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4"><?php id(11); ?></td><td style="background-color: #c2c2d4">721</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c2c2d4">5296</td><td style="background-color: #c2c2d4">7.3</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"hmm, wonder if these tafe courses are any good"</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4"><?php id(182); ?></td><td style="background-color: #c3c3d4">831</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c3c3d4">5115</td><td style="background-color: #c3c3d4">6.2</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"zed: I just saw that Detori pic you mentioned"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(2131); ?></td><td style="background-color: #c3c3d4">908</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c3c3d4">5051</td><td style="background-color: #c3c3d4">5.6</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"i looked at the changelog..."</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3">`MK</td><td style="background-color: #c3c3d3">768</td><td style="background-color: #c3c3d3"><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c3c3d3">4574</td><td style="background-color: #c3c3d3">6.0</td><td style="background-color: #c3c3d3">1 day ago</td><td style="background-color: #c3c3d3">"and i had 17 bottles over the period of 5 hours"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3"><?php id(1943); ?></td><td style="background-color: #c3c3d3">1106</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c3c3d3">4549</td><td style="background-color: #c3c3d3">4.1</td><td style="background-color: #c3c3d3">2 days ago</td><td style="background-color: #c3c3d3">"kind of like LA to not quite are far as NYC"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3"><?php id(1583); ?></td><td style="background-color: #c4c4d3">857</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="23" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c4c4d3">4284</td><td style="background-color: #c4c4d3">5.0</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"now if only I had any writing talent :Þ"</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3">Ivalian</td><td style="background-color: #c4c4d3">642</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c4c4d3">4078</td><td style="background-color: #c4c4d3">6.4</td><td style="background-color: #c4c4d3">10 days ago</td><td style="background-color: #c4c4d3">"ask and I shall receive eh?"</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(1133); ?></td><td style="background-color: #c4c4d3">1071</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c4c4d3">3835</td><td style="background-color: #c4c4d3">3.6</td><td style="background-color: #c4c4d3">4 days ago</td><td style="background-color: #c4c4d3">"I think I have all of the books now"</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2"><?php id(16); ?></td><td style="background-color: #c4c4d2">395</td><td style="background-color: #c4c4d2"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c4c4d2">3758</td><td style="background-color: #c4c4d2">9.5</td><td style="background-color: #c4c4d2">Today</td><td style="background-color: #c4c4d2">"stupid midterms I must study for"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2">MaraHarle</td><td style="background-color: #c5c5d2">605</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c5c5d2">3746</td><td style="background-color: #c5c5d2">6.2</td><td style="background-color: #c5c5d2">10 days ago</td><td style="background-color: #c5c5d2">"ok you guys should know this if u were here"</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2"><?php id(1219); ?></td><td style="background-color: #c5c5d2">676</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c5c5d2">3599</td><td style="background-color: #c5c5d2">5.3</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"WHY!!!!!!!!!!!!!!!!!!&lt;------- Note not to you Ari"</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2">Adian</td><td style="background-color: #c5c5d2">782</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c5c5d2">3549</td><td style="background-color: #c5c5d2">4.5</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"alright im goin to play Xbox"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1">sayo</td><td style="background-color: #c5c5d1">647</td><td style="background-color: #c5c5d1"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c5c5d1">3519</td><td style="background-color: #c5c5d1">5.4</td><td style="background-color: #c5c5d1">4 days ago</td><td style="background-color: #c5c5d1">"I hope they lose!!! Badly!"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1">Ender`</td><td style="background-color: #c6c6d1">678</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c6c6d1">3417</td><td style="background-color: #c6c6d1">5.0</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"MEEEEEEEEEEEEEEOOOOOOOOOOOWWWWWWWWWWWWWWWWWW"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1">XenoFord</td><td style="background-color: #c6c6d1">527</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #c6c6d1">3351</td><td style="background-color: #c6c6d1">6.4</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"Bah, so it's not entirely accurate."</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1">`Dagger</td><td style="background-color: #c6c6d1">533</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c6c6d1">3254</td><td style="background-color: #c6c6d1">6.1</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"[13:09:34] &lt;CodeSlice&gt; ahh"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0">sdrawkcab</td><td style="background-color: #c6c6d0">303</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c6c6d0">3136</td><td style="background-color: #c6c6d0">10.3</td><td style="background-color: #c6c6d0">14 days ago</td><td style="background-color: #c6c6d0">"cour: giving random grades between 10 and 20 yet? :P"</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0">Cruento</td><td style="background-color: #c6c6d0">291</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c6c6d0">3064</td><td style="background-color: #c6c6d0">10.5</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"so, what's up? seems like a slow night"</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0"><?php id(80); ?></td><td style="background-color: #c7c7d0">631</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #c7c7d0">2984</td><td style="background-color: #c7c7d0">4.7</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"alright I'll go email him."</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0">FruitCak</td><td style="background-color: #c7c7d0">329</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c7c7d0">2983</td><td style="background-color: #c7c7d0">9.1</td><td style="background-color: #c7c7d0">1 day ago</td><td style="background-color: #c7c7d0">"but how to i get higher than godhood?"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0"><?php id(14); ?></td><td style="background-color: #c7c7d0">488</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c7c7d0">2981</td><td style="background-color: #c7c7d0">6.1</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"Maybe, Re.  Just maybe. :P"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf"><?php id(1187); ?></td><td style="background-color: #c7c7cf">390</td><td style="background-color: #c7c7cf"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c7c7cf">2934</td><td style="background-color: #c7c7cf">7.5</td><td style="background-color: #c7c7cf">Today</td><td style="background-color: #c7c7cf">""You're not fooling anyone""</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf"><?php id(1798); ?></td><td style="background-color: #c8c8cf">329</td><td style="background-color: #c8c8cf"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c8c8cf">2715</td><td style="background-color: #c8c8cf">8.3</td><td style="background-color: #c8c8cf">13 days ago</td><td style="background-color: #c8c8cf">"And just to make you work."</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf">^Fyre</td><td style="background-color: #c8c8cf">325</td><td style="background-color: #c8c8cf"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c8c8cf">2625</td><td style="background-color: #c8c8cf">8.1</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"The BHG does often get a raw deal."</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf">FruitGone</td><td style="background-color: #c8c8cf">286</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c8c8cf">2558</td><td style="background-color: #c8c8cf">8.9</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"mmm coffee milkshake using old english toffee ice cream"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce"><?php id(1356); ?></td><td style="background-color: #c8c8ce">353</td><td style="background-color: #c8c8ce"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c8c8ce">2407</td><td style="background-color: #c8c8ce">6.8</td><td style="background-color: #c8c8ce">13 days ago</td><td style="background-color: #c8c8ce">"I know small, but I don't gamble in sabacc :P"</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce">Skorbles</td><td style="background-color: #c9c9ce">570</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c9c9ce">2354</td><td style="background-color: #c9c9ce">4.1</td><td style="background-color: #c9c9ce">3 days ago</td><td style="background-color: #c9c9ce">"i was the 6th ever quote in the archive"</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce"><?php id(1171); ?></td><td style="background-color: #c9c9ce">698</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c9c9ce">2274</td><td style="background-color: #c9c9ce">3.3</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"Happy west coast new year!"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce">Jan-Dead</td><td style="background-color: #c9c9ce">307</td><td style="background-color: #c9c9ce"><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c9c9ce">2201</td><td style="background-color: #c9c9ce">7.2</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"Now go. I want my money. :P"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce"><?php id(1489); ?></td><td style="background-color: #c9c9ce">415</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c9c9ce">2128</td><td style="background-color: #c9c9ce">5.1</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"Mein Name ist spok4, f&uuml;rchten mich."</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd">Kailani</td><td style="background-color: #cacacd">462</td><td style="background-color: #cacacd"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #cacacd">2121</td><td style="background-color: #cacacd">4.6</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"awww there really wasn't a brown power ranger"</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd"><?php id(45); ?></td><td style="background-color: #cacacd">237</td><td style="background-color: #cacacd"><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #cacacd">2033</td><td style="background-color: #cacacd">8.6</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"i think i got 2 away scripts though..."</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd">D`Munz</td><td style="background-color: #cacacd">215</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #cacacd">1906</td><td style="background-color: #cacacd">8.9</td><td style="background-color: #cacacd">27 days ago</td><td style="background-color: #cacacd">"2002-11-21: [22:06] -`Coursca:@#bhg- He's pissin' me off"</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd"><?php id(1264); ?></td><td style="background-color: #cacacd">343</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #cacacd">1864</td><td style="background-color: #cacacd">5.4</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"shows the sick and twisted.. amusing"</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc"><?php id(1413); ?></td><td style="background-color: #cbcbcc">358</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #cbcbcc">1823</td><td style="background-color: #cbcbcc">5.1</td><td style="background-color: #cbcbcc">2 days ago</td><td style="background-color: #cbcbcc">"Don't hell mask your hell swearing, Aon."</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc">Orion</td><td style="background-color: #cbcbcc">300</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="27" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #cbcbcc">1686</td><td style="background-color: #cbcbcc">5.6</td><td style="background-color: #cbcbcc">1 day ago</td><td style="background-color: #cbcbcc">"I wanna see "Biker Boyz" when it comes out"</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc">The_Bard</td><td style="background-color: #cbcbcc">254</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #cbcbcc">1624</td><td style="background-color: #cbcbcc">6.4</td><td style="background-color: #cbcbcc">5 days ago</td><td style="background-color: #cbcbcc">"Find out at your own risk."</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc"><?php id(1135); ?></td><td style="background-color: #cbcbcc">227</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #cbcbcc">1614</td><td style="background-color: #cbcbcc">7.1</td><td style="background-color: #cbcbcc">5 days ago</td><td style="background-color: #cbcbcc">"yes I noticed that gnome too :P"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc">deathw</td><td style="background-color: #cccccc">307</td><td style="background-color: #cccccc"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="29" height="15" alt="" /></td><td style="background-color: #cccccc">1548</td><td style="background-color: #cccccc">5.0</td><td style="background-color: #cccccc">4 days ago</td><td style="background-color: #cccccc">"im am putting © on the ned of my name :P"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10"><?php id(1809); ?> (1542)</td>
<td class="rankc10"><?php id(554); ?> (1535)</td>
<td class="rankc10">Kresh (1531)</td>
<td class="rankc10"><?php id(77); ?> (1526)</td>
<td class="rankc10"><?php id(275); ?> (1518)</td>
</tr><tr>
<td class="rankc10"><?php id(1281); ?> (1464)</td>
<td class="rankc10"><?php id(250); ?> (1429)</td>
<td class="rankc10">Big_Pun (1429)</td>
<td class="rankc10"><?php id(1064); ?> (1385)</td>
<td class="rankc10">Fyre (1375)</td>
</tr><tr>
<td class="rankc10">MrD_Write (1363)</td>
<td class="rankc10"><?php id(2006); ?> (1342)</td>
<td class="rankc10">Sayo|JK2 (1320)</td>
<td class="rankc10">The_Skald (1294)</td>
<td class="rankc10">Jer-grade (1274)</td>
</tr><tr>
<td class="rankc10">Sayo|CS (1255)</td>
<td class="rankc10"><?php id(765); ?> (1250)</td>
<td class="rankc10"><?php id(494); ?> (1206)</td>
<td class="rankc10">Conana (1185)</td>
<td class="rankc10">M`aR`k (1178)</td>
</tr><tr>
<td class="rankc10">ReSick (1113)</td>
<td class="rankc10">`Falc (1095)</td>
<td class="rankc10">`Adian (1051)</td>
<td class="rankc10">`Falk (1043)</td>
<td class="rankc10"><?php id(1717); ?> (1028)</td>
</tr><tr>
<td class="rankc10"><?php id(2070); ?> (982)</td>
<td class="rankc10">`SydFF (961)</td>
<td class="rankc10"><?php id(2217); ?> (959)</td>
<td class="rankc10">Necrolord (948)</td>
<td class="rankc10">djdonki (937)</td>
</tr><tr>
<td class="rankc10"><?php id(488); ?> (917)</td>
<td class="rankc10">ShaydeFic (901)</td>
<td class="rankc10"><?php id(1289); ?> (871)</td>
<td class="rankc10"><?php id(1218); ?> (855)</td>
<td class="rankc10">ArcAngel (844)</td>
</tr><tr>
<td class="rankc10">Urban_ (832)</td>
<td class="rankc10">DasRat (812)</td>
<td class="rankc10">ReTarD (765)</td>
<td class="rankc10">muddyhaz (758)</td>
<td class="rankc10"><?php id(1722); ?> (748)</td>
</tr></table>
<br /><b>By the way, there were 651 other nicks.</b><br />
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

<tr><td class="hicell">Is <b><?php id(1695); ?></b> stupid or just asking too many questions?  26.1% lines contained a question!
<br /><span class="small"><b>Orion</b> didn't know that much either.  24.3% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(488); ?></b>, who yelled 98.0% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(1829); ?></b>, who shouted 39.2% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b>Dash-</b>'s shift-key is hanging:  22.7% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[11:54] &lt;Dash-&gt; RAAAAR
</span><br />
<br /><span class="small"><b><?php id(331); ?></b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 13.8% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> is a very aggressive person.  He/She attacked others <b>59</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[04:56] Action: `Conan smacks his forehead and sits down
</span><br />
<br /><span class="small"><b>NindoF</b> can't control his/her aggressions, either.  He/She picked on others <b>50</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(1198); ?></b>, nobody likes him/her.  He/She was attacked <b>56</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[07:49] Action: ^SyNth kicks the server, damn you, C'MON!
</span><br />
<br /><span class="small"><b>conan</b> seems to be unliked too.  He/She got beaten <b>27</b> times.</span>
</td></tr>
<tr><td class="hicell"><b>Cruento</b> brings happiness to the world.  48.1% lines contained smiling faces.  :)
<br /><span class="small"><b><?php id(135); ?></b> isn't a sad person either, smiling 46.7% of the time.</span>
</td></tr>
<tr><td class="hicell"><b>lil_snowb</b> seems to be sad at the moment:  4.9% lines contained sad faces.  :(
<br /><span class="small"><b>D`Munz</b> is also a sad person, crying 4.1% of the time.</span>
</td></tr>
<tr><td class="hicell"><b>Jer-grade</b> wrote the longest lines, averaging 64.0 letters per line.<br />
<span class="small">#bhg average was 26.5 letters per line.</span></td></tr>
<tr><td class="hicell"><b><?php id(2070); ?></b> wrote the shortest lines, averaging 13.9 characters per line.<br />
<span class="small"><b>Fat_Joe</b> was tight-lipped, too, averaging 15.2 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(473); ?></b> spoke a total of 40415 words!
<br /><span class="small"><?php id(473); ?>'s faithful follower, <b><?php id(577); ?></b>, didn't speak so much: 33813 words.</span>
</td></tr>
<tr><td class="hicell"><b>Motti (EH)</b> wrote an average of 31.00 words per line.
<br /><span class="small">Channel average was 5.26 words per line.</span>
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
<td class="hicell">4547</td>
<td class="hicell">Skorbles</td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell">about</td>
<td class="hicell">2043</td>
<td class="hicell"><?php id(141); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell">think</td>
<td class="hicell">1772</td>
<td class="hicell"><?php id(1754); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell">there</td>
<td class="hicell">1603</td>
<td class="hicell"><?php id(577); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(767); ?></td>
<td class="hicell">1306</td>
<td class="hicell"><?php id(765); ?></td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">would</td>
<td class="hicell">1306</td>
<td class="hicell"><?php id(1187); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">right</td>
<td class="hicell">1190</td>
<td class="hicell">XenoFord</td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">really</td>
<td class="hicell">1121</td>
<td class="hicell">XenoFord</td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">going</td>
<td class="hicell">1050</td>
<td class="hicell"><?php id(1187); ?></td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">something</td>
<td class="hicell">1050</td>
<td class="hicell"><?php id(331); ?></td>
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
<td class="hicell">49236</td>
<td class="hicell"><?php id(1187); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(1085); ?></td>
<td class="hicell">22740</td>
<td class="hicell">Sayo|JK2</td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(331); ?></td>
<td class="hicell">17379</td>
<td class="hicell"><?php id(484); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(1908); ?></td>
<td class="hicell">10705</td>
<td class="hicell"><?php id(1908); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(1281); ?></td>
<td class="hicell">4424</td>
<td class="hicell"><?php id(1551); ?></td>
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
<td class="hicell"><?php id(141); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://www.trollscantsing.com/">http://www.trollscantsing.com/</a></td>
<td class="hicell">9</td>
<td class="hicell"><?php id(1133); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://www.thebhg.org">http://www.thebhg.org</a></td>
<td class="hicell">8</td>
<td class="hicell">Urban_</td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://www.ehnet.org/sabacc">http://www.ehnet.org/sabacc</a></td>
<td class="hicell">6</td>
<td class="hicell"><?php id(1187); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://lawngnome.cernun.net/lotto/">http://lawngnome.cernun.net/lotto/</a></td>
<td class="hicell">6</td>
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

<tr><td class="hicell"><b><?php id(1594); ?></b> wasn't very popular, getting kicked 36 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[15:05] Coranel kicked from #bhg by D_Shadow: CB!!!!
</span><br />
<br /><span class="small"><b><?php id(1551); ?></b> seemed to be hated too:  21 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(473); ?></b> is either insane or just a fair op, kicking a total of 93 people!
<br /><span class="small"><?php id(473); ?>'s faithful follower, <b>LawnGnome</b>, kicked about 65 people.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> donated 48 ops in the channel...
<br /><span class="small"><b><?php id(1625); ?></b> was also very polite: 15 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(488); ?></b> is the channel sheriff with 8 deops.
<br /><span class="small"><b>LawnGnome</b> deoped 7 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1762); ?></b> always lets us know what he/she's doing: 1083 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[22:39] Action: Re_Eson wanders off for a while
</span><br />
<br /><span class="small">Also, <b><?php id(747); ?></b> tells us what's up with 874 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(473); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 58 times!
<br /><span class="small">Another lonely one was <b><?php id(1551); ?></b>, who managed to hit 36 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(370); ?></b> couldn't decide whether to stay or go.  277 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>NindoRena</b> has quite a potty mouth.  3.6% words were foul language.
<br /><span class="small"><b><?php id(169); ?></b> also makes sailors blush, 3.5% of the time.</span>
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

<tr><td class="hicell"><i>'OM45 up | X on temp LoA | All glory to the hypno-toad | New TH CH is Nindo Flast, New DW W is Mage | BACON!'|Sweet!</i></td>
<td class="hicell"><b>by <?php id(182); ?> on 20:16</b></td></tr>
<tr><td class="hicell"><i>Sweet!</i></td>
<td class="hicell"><b>by <?php id(182); ?> on 20:16</b></td></tr>
<tr><td class="hicell"><i>OM45 up |  X on temp LoA | All glory to the hypno-toad | New TH CH is Nindo Flast, New DW W is Mage | BACON!</i></td>
<td class="hicell"><b>by <?php id(23); ?> on 20:14</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 221 times.</td></tr>
</table>
Total number of lines: 177035.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 01 minutes and 56 seconds
</span>
</div>
</body>
</html>

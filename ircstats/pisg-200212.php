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
Statistics generated on  Thursday 2 January 2003 - 3:00:23
<br />During this 31-day reporting period, a total of <b>800</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">5.3%<br /><img src="./blue-v.png" width="15" height="73.7197178779516" alt="5.3" /></td>

<td align="center" valign="bottom" class="asmall">3.7%<br /><img src="./blue-v.png" width="15" height="51.4949402023919" alt="3.7" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./blue-v.png" width="15" height="42.8012879484821" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">2.6%<br /><img src="./blue-v.png" width="15" height="36.3845446182153" alt="2.6" /></td>

<td align="center" valign="bottom" class="asmall">2.1%<br /><img src="./blue-v.png" width="15" height="29.8911376878258" alt="2.1" /></td>

<td align="center" valign="bottom" class="asmall">1.6%<br /><img src="./blue-v.png" width="15" height="22.86875191659" alt="1.6" /></td>

<td align="center" valign="bottom" class="asmall">1.7%<br /><img src="./green-v.png" width="15" height="24.5016865992027" alt="1.7" /></td>

<td align="center" valign="bottom" class="asmall">2.5%<br /><img src="./green-v.png" width="15" height="35.6409076970255" alt="2.5" /></td>

<td align="center" valign="bottom" class="asmall">3.0%<br /><img src="./green-v.png" width="15" height="42.2953081876725" alt="3.0" /></td>

<td align="center" valign="bottom" class="asmall">2.9%<br /><img src="./green-v.png" width="15" height="40.7467034651947" alt="2.9" /></td>

<td align="center" valign="bottom" class="asmall">4.0%<br /><img src="./green-v.png" width="15" height="56.3707451701932" alt="4.0" /></td>

<td align="center" valign="bottom" class="asmall">5.3%<br /><img src="./green-v.png" width="15" height="73.8960441582337" alt="5.3" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./yellow-v.png" width="15" height="53.0282122048451" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./yellow-v.png" width="15" height="52.8058877644894" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./yellow-v.png" width="15" height="53.5188592456302" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">4.3%<br /><img src="./yellow-v.png" width="15" height="59.8129408157007" alt="4.3" /></td>

<td align="center" valign="bottom" class="asmall">4.4%<br /><img src="./yellow-v.png" width="15" height="60.7329040171727" alt="4.4" /></td>

<td align="center" valign="bottom" class="asmall">4.7%<br /><img src="./yellow-v.png" width="15" height="65.8616988653787" alt="4.7" /></td>

<td align="center" valign="bottom" class="asmall">5.0%<br /><img src="./red-v.png" width="15" height="68.8439129101503" alt="5.0" /></td>

<td align="center" valign="bottom" class="asmall">5.2%<br /><img src="./red-v.png" width="15" height="72.753756516406" alt="5.2" /></td>

<td align="center" valign="bottom" class="asmall">5.9%<br /><img src="./red-v.png" width="15" height="82.4900337319841" alt="5.9" /></td>

<td align="center" valign="bottom" class="asmall">5.9%<br /><img src="./red-v.png" width="15" height="81.8153940509046" alt="5.9" /></td>

<td align="center" valign="bottom" class="asmall">7.2%<br /><img src="./red-v.png" width="15" height="100" alt="7.2" /></td>

<td align="center" valign="bottom" class="asmall">6.0%<br /><img src="./red-v.png" width="15" height="83.8929776142288" alt="6.0" /></td>

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
<td style="background-color: #babadc"><?php id(370); ?></td><td style="background-color: #babadc">10141</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #babadc">55262</td><td style="background-color: #babadc">5.4</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"I love everything about NJ"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(473); ?></td><td style="background-color: #babadc">10962</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #babadc">52968</td><td style="background-color: #babadc">4.8</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"That's the only reason I'd put crap in my hair."</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(168); ?></td><td style="background-color: #babadc">4077</td><td style="background-color: #babadc"><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #babadc">36868</td><td style="background-color: #babadc">9.0</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Where did you get the impression that it's called Dune 2k?:P"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(1551); ?></td><td style="background-color: #babadc">6472</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #babadc">31313</td><td style="background-color: #babadc">4.8</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Say that the server is down again."</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(2122); ?></td><td style="background-color: #bbbbdb">2599</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #bbbbdb">30253</td><td style="background-color: #bbbbdb">11.6</td><td style="background-color: #bbbbdb">2 days ago</td><td style="background-color: #bbbbdb">"Don't even worry about it, Kail."</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(1908); ?></td><td style="background-color: #bbbbdb">6572</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #bbbbdb">29723</td><td style="background-color: #bbbbdb">4.5</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"yea...ChaB`s...when all the other EH is down.....Senate works :P"</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(1625); ?></td><td style="background-color: #bbbbdb">4709</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #bbbbdb">27484</td><td style="background-color: #bbbbdb">5.8</td><td style="background-color: #bbbbdb">3 days ago</td><td style="background-color: #bbbbdb">"that's the general consensus around here"</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(2029); ?></td><td style="background-color: #bbbbdb">3972</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="27" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #bbbbdb">25559</td><td style="background-color: #bbbbdb">6.4</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"melodramatic much, Tradik? :P"</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(331); ?></td><td style="background-color: #bcbcda">4942</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bcbcda">23392</td><td style="background-color: #bcbcda">4.7</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"You don't want to know. ;P"</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(1247); ?></td><td style="background-color: #bcbcda">5314</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bcbcda">21059</td><td style="background-color: #bcbcda">4.0</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"and dont even start on religion here....."</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(1762); ?></td><td style="background-color: #bcbcda">5104</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bcbcda">20630</td><td style="background-color: #bcbcda">4.0</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"I've never even listened to Merzbow, let alone own it :T"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(577); ?></td><td style="background-color: #bcbcda">4063</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bcbcda">20327</td><td style="background-color: #bcbcda">5.0</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"they won't understand why you're talking about 'yuo romm"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(1332); ?></td><td style="background-color: #bdbdda">4678</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bdbdda">20049</td><td style="background-color: #bdbdda">4.3</td><td style="background-color: #bdbdda">1 day ago</td><td style="background-color: #bdbdda">"heh, i wonder if she got any of that"</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9"><?php id(23); ?></td><td style="background-color: #bdbdd9">2510</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bdbdd9">16034</td><td style="background-color: #bdbdd9">6.4</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"or are they those small burrowing insects?"</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(1594); ?></td><td style="background-color: #bdbdd9">3961</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bdbdd9">15603</td><td style="background-color: #bdbdd9">3.9</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"that would be obscene word count :P"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(16); ?></td><td style="background-color: #bdbdd9">1514</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #bdbdd9">15162</td><td style="background-color: #bdbdd9">10.0</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"nyk: minimize and ignore the window ;P"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(1754); ?></td><td style="background-color: #bebed9">2586</td><td style="background-color: #bebed9"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #bebed9">13552</td><td style="background-color: #bebed9">5.2</td><td style="background-color: #bebed9">Today</td><td style="background-color: #bebed9">"and put all your saved stuff offline"</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8"><?php id(666); ?></td><td style="background-color: #bebed8">1233</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="25" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #bebed8">11403</td><td style="background-color: #bebed8">9.2</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"zed: the william shatner version? :P"</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(242); ?></td><td style="background-color: #bebed8">1989</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bebed8">11120</td><td style="background-color: #bebed8">5.6</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"not likely you'll get Trench :P"</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(747); ?></td><td style="background-color: #bebed8">3038</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="23" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bebed8">11000</td><td style="background-color: #bebed8">3.6</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"wanna know somethin weird?"</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8">^SyNth</td><td style="background-color: #bfbfd8">2492</td><td style="background-color: #bfbfd8"><img src="./green-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #bfbfd8">10786</td><td style="background-color: #bfbfd8">4.3</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"at 20 units of power / engine upgrade....61 more engine upgrades"</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(1699); ?></td><td style="background-color: #bfbfd8">2214</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="32" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #bfbfd8">10130</td><td style="background-color: #bfbfd8">4.6</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"i think i applied it about 4 times today"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7"><?php id(1085); ?></td><td style="background-color: #bfbfd7">2773</td><td style="background-color: #bfbfd7"><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bfbfd7">9448</td><td style="background-color: #bfbfd7">3.4</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"That's the URL I gave a few moments ago. :P"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7">_-Mage-_</td><td style="background-color: #bfbfd7">1329</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #bfbfd7">9330</td><td style="background-color: #bfbfd7">7.0</td><td style="background-color: #bfbfd7">1 day ago</td><td style="background-color: #bfbfd7">"When have I ever been a naughty little boy, Santa Cour? :P"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(94); ?></td><td style="background-color: #c0c0d7">1040</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #c0c0d7">9124</td><td style="background-color: #c0c0d7">8.8</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"wont be sleepin for a while"</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(229); ?></td><td style="background-color: #c0c0d7">911</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c0c0d7">9119</td><td style="background-color: #c0c0d7">10.0</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"Bleh. "Actual music" is highly based on perspective. :P"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6"><?php id(141); ?></td><td style="background-color: #c0c0d6">1599</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #c0c0d6">8793</td><td style="background-color: #c0c0d6">5.5</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"im thinking of starting on No. 1"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6"><?php id(57); ?></td><td style="background-color: #c0c0d6">1268</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c0c0d6">8612</td><td style="background-color: #c0c0d6">6.8</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"that's not a greeting...that's an act of love"</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(1829); ?></td><td style="background-color: #c0c0d6">2219</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c0c0d6">8401</td><td style="background-color: #c0c0d6">3.8</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"I think I'll ask Jer real nice for one :P"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6">MiniElf</td><td style="background-color: #c1c1d6">1832</td><td style="background-color: #c1c1d6"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c1c1d6">8120</td><td style="background-color: #c1c1d6">4.4</td><td style="background-color: #c1c1d6">Today</td><td style="background-color: #c1c1d6">"Directed by the same guy who did The Perfect Storm"</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5"><?php id(1356); ?></td><td style="background-color: #c1c1d5">1337</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c1c1d5">8002</td><td style="background-color: #c1c1d5">6.0</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"Lawngnome raped so many, so now the role is reversed :P"</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5">`Sayo</td><td style="background-color: #c1c1d5">1380</td><td style="background-color: #c1c1d5"><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c1c1d5">7781</td><td style="background-color: #c1c1d5">5.6</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"lol My parties are all on Saturday and sunday..."</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5">Xar_</td><td style="background-color: #c1c1d5">1649</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c1c1d5">7525</td><td style="background-color: #c1c1d5">4.6</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"weapons, location, rules, etc"</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5"><?php id(118); ?></td><td style="background-color: #c2c2d5">710</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c2c2d5">7026</td><td style="background-color: #c2c2d5">9.9</td><td style="background-color: #c2c2d5">12 days ago</td><td style="background-color: #c2c2d5">"it's Slice...of course he hasn't:P"</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5"><?php id(11); ?></td><td style="background-color: #c2c2d5">899</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c2c2d5">6357</td><td style="background-color: #c2c2d5">7.1</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"I actually put a copy of the old SSL online one time recently"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(135); ?></td><td style="background-color: #c2c2d4">888</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #c2c2d4">5865</td><td style="background-color: #c2c2d4">6.6</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"frankly, my virgin ears can't handle the language, Motti"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4"><?php id(275); ?></td><td style="background-color: #c2c2d4">941</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c2c2d4">5445</td><td style="background-color: #c2c2d4">5.8</td><td style="background-color: #c2c2d4">1 day ago</td><td style="background-color: #c2c2d4">"there are blind people in the world."</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4"><?php id(2118); ?></td><td style="background-color: #c3c3d4">774</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="28" height="15" alt="" /></td><td style="background-color: #c3c3d4">4596</td><td style="background-color: #c3c3d4">5.9</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"i liked the two old wrinkly ladies"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(1843); ?></td><td style="background-color: #c3c3d4">1494</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c3c3d4">4345</td><td style="background-color: #c3c3d4">2.9</td><td style="background-color: #c3c3d4">5 days ago</td><td style="background-color: #c3c3d4">"except a thong would be bigger"</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3"><?php id(484); ?></td><td style="background-color: #c3c3d3">644</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="29" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c3c3d3">3924</td><td style="background-color: #c3c3d3">6.1</td><td style="background-color: #c3c3d3">13 days ago</td><td style="background-color: #c3c3d3">"co diddy, sucky rapper extraordinaire"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3">MaraHarle</td><td style="background-color: #c3c3d3">738</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="6" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="26" height="15" alt="" /></td><td style="background-color: #c3c3d3">3910</td><td style="background-color: #c3c3d3">5.3</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"i would but i can't move much cuz i hurt"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3">FruitCak-</td><td style="background-color: #c4c4d3">404</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="24" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #c4c4d3">3788</td><td style="background-color: #c4c4d3">9.4</td><td style="background-color: #c4c4d3">4 days ago</td><td style="background-color: #c4c4d3">"1) Still on LoA, though I am answering more emails now."</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3">Coursca`</td><td style="background-color: #c4c4d3">881</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="32" height="15" alt="" /></td><td style="background-color: #c4c4d3">3444</td><td style="background-color: #c4c4d3">3.9</td><td style="background-color: #c4c4d3">2 days ago</td><td style="background-color: #c4c4d3">"You can't that's impersonation :p"</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3">Adian</td><td style="background-color: #c4c4d3">682</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="13" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c4c4d3">3362</td><td style="background-color: #c4c4d3">4.9</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"when have i ever been a stooge?"</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2"><?php id(765); ?></td><td style="background-color: #c4c4d2">683</td><td style="background-color: #c4c4d2"><img src="./green-h.png" border="0" width="22" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c4c4d2">3179</td><td style="background-color: #c4c4d2">4.7</td><td style="background-color: #c4c4d2">Today</td><td style="background-color: #c4c4d2">"so you have some time Slice"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2"><?php id(182); ?></td><td style="background-color: #c5c5d2">580</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #c5c5d2">3170</td><td style="background-color: #c5c5d2">5.5</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"Thats ok Bulbasaur, we believe youre active."</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2">^Fyre</td><td style="background-color: #c5c5d2">430</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c5c5d2">3160</td><td style="background-color: #c5c5d2">7.3</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"Ah well, now I must be going. "</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2"><?php id(1943); ?></td><td style="background-color: #c5c5d2">854</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c5c5d2">2872</td><td style="background-color: #c5c5d2">3.4</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"<a href="http://www.iwf.net/wrec/wrec.html" target="_blank" title="Open in new window: http://www.iwf.net/wrec/wrec.html">http://www.iwf.net/wrec/wrec.html</a>"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1"><?php id(1133); ?></td><td style="background-color: #c5c5d1">726</td><td style="background-color: #c5c5d1"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c5c5d1">2758</td><td style="background-color: #c5c5d1">3.8</td><td style="background-color: #c5c5d1">Today</td><td style="background-color: #c5c5d1">"Is Stone Cold still in jail?"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1"><?php id(2213); ?></td><td style="background-color: #c6c6d1">589</td><td style="background-color: #c6c6d1"><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c6c6d1">2740</td><td style="background-color: #c6c6d1">4.7</td><td style="background-color: #c6c6d1">1 day ago</td><td style="background-color: #c6c6d1">"it's more fun then shooting those smarter then me"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1"><?php id(1583); ?></td><td style="background-color: #c6c6d1">380</td><td style="background-color: #c6c6d1"><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c6c6d1">2652</td><td style="background-color: #c6c6d1">7.0</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"we kicked Monitors ass in some comp near the end of the NC"</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1"><?php id(80); ?></td><td style="background-color: #c6c6d1">487</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c6c6d1">2634</td><td style="background-color: #c6c6d1">5.4</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"something to be proud of Zed"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0"><?php id(1722); ?></td><td style="background-color: #c6c6d0">783</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c6c6d0">2569</td><td style="background-color: #c6c6d0">3.3</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"aaaah the innocence of youth"</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0">Motti (EH)</td><td style="background-color: #c6c6d0">193</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c6c6d0">2215</td><td style="background-color: #c6c6d0">11.5</td><td style="background-color: #c6c6d0">2 days ago</td><td style="background-color: #c6c6d0">"and that's not a bad thing."</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0"><?php id(2006); ?></td><td style="background-color: #c7c7d0">497</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c7c7d0">2168</td><td style="background-color: #c7c7d0">4.4</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"You're underage too Detori!"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0">Kailani</td><td style="background-color: #c7c7d0">562</td><td style="background-color: #c7c7d0"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c7c7d0">2118</td><td style="background-color: #c7c7d0">3.8</td><td style="background-color: #c7c7d0">1 day ago</td><td style="background-color: #c7c7d0">"what was wrong w/ saying sexy AND cowboy"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0">DearAbby</td><td style="background-color: #c7c7d0">314</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="19" height="15" alt="" /></td><td style="background-color: #c7c7d0">2114</td><td style="background-color: #c7c7d0">6.7</td><td style="background-color: #c7c7d0">20 days ago</td><td style="background-color: #c7c7d0">"Haven't you already huggled him/her/it?"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf">DaZMan</td><td style="background-color: #c7c7cf">438</td><td style="background-color: #c7c7cf"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="34" height="15" alt="" /></td><td style="background-color: #c7c7cf">2091</td><td style="background-color: #c7c7cf">4.8</td><td style="background-color: #c7c7cf">2 days ago</td><td style="background-color: #c7c7cf">"not until i know what it means :P"</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf"><?php id(45); ?></td><td style="background-color: #c8c8cf">271</td><td style="background-color: #c8c8cf"><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #c8c8cf">2046</td><td style="background-color: #c8c8cf">7.5</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"on that note i think i should leave"</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf">Kresh</td><td style="background-color: #c8c8cf">296</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #c8c8cf">2031</td><td style="background-color: #c8c8cf">6.9</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"dang, running low on loose change. Must go make more"</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf">JanetReno</td><td style="background-color: #c8c8cf">535</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="19" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c8c8cf">2010</td><td style="background-color: #c8c8cf">3.8</td><td style="background-color: #c8c8cf">2 days ago</td><td style="background-color: #c8c8cf">"Granted it's RPGing, it's basically campaigning and the like."</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce"><?php id(106); ?></td><td style="background-color: #c8c8ce">318</td><td style="background-color: #c8c8ce"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c8c8ce">1979</td><td style="background-color: #c8c8ce">6.2</td><td style="background-color: #c8c8ce">11 days ago</td><td style="background-color: #c8c8ce">"Really. Now that's interesting."</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce">aewis`</td><td style="background-color: #c9c9ce">549</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="32" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #c9c9ce">1861</td><td style="background-color: #c9c9ce">3.4</td><td style="background-color: #c9c9ce">8 days ago</td><td style="background-color: #c9c9ce">"dk... <a href="http://www.candystand.com/games/cs_shock_csmb.htm" target="_blank" title="Open in new window: http://www.candystand.com/games/cs_shock_csmb.htm">http://www.candystand.com/games/cs_shock_csmb.htm</a>"</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce"><?php id(1413); ?></td><td style="background-color: #c9c9ce">429</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c9c9ce">1843</td><td style="background-color: #c9c9ce">4.3</td><td style="background-color: #c9c9ce">17 days ago</td><td style="background-color: #c9c9ce">"Profound, yet understated."</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce"><?php id(22); ?></td><td style="background-color: #c9c9ce">310</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #c9c9ce">1787</td><td style="background-color: #c9c9ce">5.8</td><td style="background-color: #c9c9ce">2 days ago</td><td style="background-color: #c9c9ce">"how goes life in teh big world?"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce">SantaCour</td><td style="background-color: #c9c9ce">429</td><td style="background-color: #c9c9ce"><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #c9c9ce">1771</td><td style="background-color: #c9c9ce">4.1</td><td style="background-color: #c9c9ce">7 days ago</td><td style="background-color: #c9c9ce">"Hehehe...little does she know what I got her, though."</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd">E1vis</td><td style="background-color: #cacacd">346</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #cacacd">1759</td><td style="background-color: #cacacd">5.1</td><td style="background-color: #cacacd">15 days ago</td><td style="background-color: #cacacd">"You should make them eat cake."</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd"><?php id(1717); ?></td><td style="background-color: #cacacd">449</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #cacacd">1749</td><td style="background-color: #cacacd">3.9</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"I'll just root for you guys =P"</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd"><?php id(14); ?></td><td style="background-color: #cacacd">304</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #cacacd">1711</td><td style="background-color: #cacacd">5.6</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"Is there another setting? :P"</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd">Moreco</td><td style="background-color: #cacacd">238</td><td style="background-color: #cacacd"><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #cacacd">1629</td><td style="background-color: #cacacd">6.8</td><td style="background-color: #cacacd">8 days ago</td><td style="background-color: #cacacd">"the opinion isn´t the problem... the problem is HOW he voiced it"</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc">Ender`</td><td style="background-color: #cbcbcc">344</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #cbcbcc">1586</td><td style="background-color: #cbcbcc">4.6</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"w. h.a.t. i. a.m. s.a.y.i.n."</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc"><?php id(1103); ?></td><td style="background-color: #cbcbcc">237</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="30" height="15" alt="" /></td><td style="background-color: #cbcbcc">1558</td><td style="background-color: #cbcbcc">6.6</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"email for Sankter Claus is <a href="mailto:frigid@theNorthPole.kuq" title="Mail to frigid@theNorthPole.kuq">frigid@theNorthPole.kuq</a>"</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc"><?php id(152); ?></td><td style="background-color: #cbcbcc">193</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #cbcbcc">1532</td><td style="background-color: #cbcbcc">7.9</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"Only two people have ever been unanimously elected..."</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc"><?php id(1697); ?></td><td style="background-color: #cbcbcc">322</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #cbcbcc">1482</td><td style="background-color: #cbcbcc">4.6</td><td style="background-color: #cbcbcc">1 day ago</td><td style="background-color: #cbcbcc">"why do you say this to me?"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc"><?php id(1873); ?></td><td style="background-color: #cccccc">282</td><td style="background-color: #cccccc"><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #cccccc">1453</td><td style="background-color: #cccccc">5.2</td><td style="background-color: #cccccc">9 days ago</td><td style="background-color: #cccccc">"i can't type tonight.............."</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10">CharJer (1428)</td>
<td class="rankc10">dascr00ge (1416)</td>
<td class="rankc10">`sydbzy (1396)</td>
<td class="rankc10"><?php id(1276); ?> (1376)</td>
<td class="rankc10"><?php id(1627); ?> (1364)</td>
</tr><tr>
<td class="rankc10"><?php id(1218); ?> (1349)</td>
<td class="rankc10">Sayo (1307)</td>
<td class="rankc10"><?php id(1798); ?> (1288)</td>
<td class="rankc10">t00bdaed (1284)</td>
<td class="rankc10">`Blythe (1253)</td>
</tr><tr>
<td class="rankc10"><?php id(295); ?> (1247)</td>
<td class="rankc10">`MK (1197)</td>
<td class="rankc10">djdonki (1194)</td>
<td class="rankc10">Xanamis (1159)</td>
<td class="rankc10"><?php id(494); ?> (1159)</td>
</tr><tr>
<td class="rankc10">`sYDe_sHo (1141)</td>
<td class="rankc10"><?php id(1281); ?> (1140)</td>
<td class="rankc10">ArcAngel (1138)</td>
<td class="rankc10">freshjive (1131)</td>
<td class="rankc10">MrReavah (1112)</td>
</tr><tr>
<td class="rankc10"><?php id(1190); ?> (1110)</td>
<td class="rankc10">Icedemon (1104)</td>
<td class="rankc10"><?php id(1264); ?> (1088)</td>
<td class="rankc10">Xsinama (1070)</td>
<td class="rankc10">Necrolord (1031)</td>
</tr><tr>
<td class="rankc10">M`aR`k (1021)</td>
<td class="rankc10">Jerli (1021)</td>
<td class="rankc10">`Kresh (1008)</td>
<td class="rankc10">FruitCak (933)</td>
<td class="rankc10">Conan` (853)</td>
</tr><tr>
<td class="rankc10"><?php id(1036); ?> (852)</td>
<td class="rankc10"><?php id(160); ?> (848)</td>
<td class="rankc10">omg_wtf (830)</td>
<td class="rankc10"><?php id(1219); ?> (810)</td>
<td class="rankc10">KiwiBS (767)</td>
</tr><tr>
<td class="rankc10">NvM (732)</td>
<td class="rankc10"><?php id(2070); ?> (728)</td>
<td class="rankc10">Ssrithkar (722)</td>
<td class="rankc10">HappyW0k (678)</td>
<td class="rankc10">Re_WWE (676)</td>
</tr></table>
<br /><b>By the way, there were 682 other nicks.</b><br />
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

<tr><td class="hicell">Is <b>|Conan</b> stupid or just asking too many questions?  25.4% lines contained a question!
<br /><span class="small"><b>`Sayo</b> didn't know that much either.  20.2% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(488); ?></b>, who yelled 85.4% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(1829); ?></b>, who shouted 42.4% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b><?php id(331); ?></b>'s shift-key is hanging:  13.7% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[13:35] &lt;Lara`&gt; CS!!!!!!!!!!!
</span><br />
<br /><span class="small"><b><?php id(1798); ?></b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 13.4% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(370); ?></b> is a very aggressive person.  He/She attacked others <b>132</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[10:23] Action: Zarkana smacks Talra in his nerd-i-ness
</span><br />
<br /><span class="small"><b><?php id(1247); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>91</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(1198); ?></b>, nobody likes him/her.  He/She was attacked <b>71</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[02:48] Action: Cay slaps the Hutt
</span><br />
<br /><span class="small"><b><?php id(2029); ?></b> seems to be unliked too.  He/She got beaten <b>37</b> times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(2122); ?></b> brings happiness to the world.  54.4% lines contained smiling faces.  :)
<br /><span class="small"><b><?php id(135); ?></b> isn't a sad person either, smiling 53.9% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1943); ?></b> seems to be sad at the moment:  3.0% lines contained sad faces.  :(
<br /><span class="small"><b>djdonki</b> is also a sad person, crying 2.1% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(2122); ?></b> wrote the longest lines, averaging 61.2 letters per line.<br />
<span class="small">#bhg average was 26.8 letters per line.</span></td></tr>
<tr><td class="hicell"><b><?php id(2070); ?></b> wrote the shortest lines, averaging 11.9 characters per line.<br />
<span class="small"><b>dascr00ge</b> was tight-lipped, too, averaging 13.3 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(370); ?></b> spoke a total of 55262 words!
<br /><span class="small"><?php id(370); ?>'s faithful follower, <b><?php id(473); ?></b>, didn't speak so much: 52968 words.</span>
</td></tr>
<tr><td class="hicell"><b>Wmbgskip</b> wrote an average of 25.00 words per line.
<br /><span class="small">Channel average was 5.30 words per line.</span>
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
<td class="hicell">49950</td>
<td class="hicell"><?php id(2029); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(42); ?></td>
<td class="hicell">4476</td>
<td class="hicell"><?php id(2070); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(300); ?></td>
<td class="hicell">2466</td>
<td class="hicell"><?php id(331); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell">about</td>
<td class="hicell">2242</td>
<td class="hicell">Fyre</td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">think</td>
<td class="hicell">1712</td>
<td class="hicell"><?php id(2029); ?></td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">there</td>
<td class="hicell">1487</td>
<td class="hicell">Tuss|LWF</td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">really</td>
<td class="hicell">1281</td>
<td class="hicell"><?php id(2029); ?></td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell"><?php id(767); ?></td>
<td class="hicell">1259</td>
<td class="hicell"><?php id(2029); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">would</td>
<td class="hicell">1249</td>
<td class="hicell"><?php id(2029); ?></td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">going</td>
<td class="hicell">1239</td>
<td class="hicell"><?php id(1762); ?></td>
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
<td class="hicell">23465</td>
<td class="hicell">`Syd|pool</td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(331); ?></td>
<td class="hicell">18582</td>
<td class="hicell">Adian</td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(1908); ?></td>
<td class="hicell">11683</td>
<td class="hicell">Kailani</td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(1281); ?></td>
<td class="hicell">4724</td>
<td class="hicell"><?php id(1332); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(45); ?></td>
<td class="hicell">1852</td>
<td class="hicell"><?php id(229); ?></td>
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
<td class="hicell">23</td>
<td class="hicell"><?php id(14); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://64.251.66.48:8000">http://64.251.66.48:8000</a></td>
<td class="hicell">14</td>
<td class="hicell">MottiAway</td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://www.frognet.net/~teeps/playlist.html">http://www.frognet.net/~teeps/playlist.html</a></td>
<td class="hicell">10</td>
<td class="hicell">Motti (EH)</td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://proctor.thebhg.org">http://proctor.thebhg.org</a></td>
<td class="hicell">9</td>
<td class="hicell"><?php id(473); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://www.candystand.com">http://www.candystand.com</a></td>
<td class="hicell">9</td>
<td class="hicell">`sYDe_sHo</td>
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

<tr><td class="hicell"><b><?php id(1247); ?></b> wasn't very popular, getting kicked 62 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[03:34] `Conan kicked from #bhg by Skor-Away: quiet, infidel
</span><br />
<br /><span class="small"><b><?php id(473); ?></b> seemed to be hated too:  40 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1625); ?></b> is either insane or just a fair op, kicking a total of 137 people!
<br /><span class="small"><?php id(1625); ?>'s faithful follower, <b><?php id(473); ?></b>, kicked about 133 people.</span>
</td></tr>
<tr><td class="hicell"><b>LawnGnome</b> donated 40 ops in the channel...
<br /><span class="small"><b><?php id(1625); ?></b> was also very polite: 11 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1625); ?></b> is the channel sheriff with 9 deops.
<br /><span class="small"><b><?php id(473); ?></b> deoped 5 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(370); ?></b> always lets us know what he/she's doing: 2069 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[17:35] Action: TalraPHP is getting close to DUKE
</span><br />
<br /><span class="small">Also, <b><?php id(1247); ?></b> tells us what's up with 1238 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(473); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 67 times!
<br /><span class="small">Another lonely one was <b><?php id(1551); ?></b>, who managed to hit 35 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> couldn't decide whether to stay or go.  333 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>`Coursca`</b> has quite a potty mouth.  7.1% words were foul language.
<br /><span class="small"><b>Supastuff</b> also makes sailors blush, 2.7% of the time.</span>
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

<tr><td class="hicell"><i><a href="http://holonet.thebhg.org/index.php?module=roster&amp;page=survey" target="_blank" title="Open in new window: http://holonet.thebhg.org/index.php?module=roster&amp;page=survey">http://holonet.thebhg.org/index.php?module=roster&amp;page=survey</a> || 3 days left for solo missions and RO's, new Taliesin up for grabs || Cour isn't here today</i></td>
<td class="hicell"><b>by <?php id(473); ?> on 10:36</b></td></tr>
<tr><td class="hicell"><i><a href="http://holonet.thebhg.org/index.php?module=roster&amp;page=survey" target="_blank" title="Open in new window: http://holonet.thebhg.org/index.php?module=roster&amp;page=survey">http://holonet.thebhg.org/index.php?module=roster&amp;page=survey</a> || Archie goes bye bye|| 3 days left for solo missions and RO's, new Taliesin up for grabs || Cour</i></td>
<td class="hicell"><b>by <?php id(473); ?> on 10:36</b></td></tr>
<tr><td class="hicell"><i><a href="http://holonet.thebhg.org/index.php?module=roster&amp;page=survey" target="_blank" title="Open in new window: http://holonet.thebhg.org/index.php?module=roster&amp;page=survey">http://holonet.thebhg.org/index.php?module=roster&amp;page=survey</a> || Archie goes bye bye|| 3 days left for solo missions and RO's, new Taliesin up for grabs</i></td>
<td class="hicell"><b>by <?php id(1829); ?> on 07:28</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 301 times.</td></tr>
</table>
Total number of lines: 179471.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 01 minutes and 26 seconds
</span>
</div>
</body>
</html>

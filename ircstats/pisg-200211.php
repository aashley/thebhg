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
Statistics generated on  Monday 2 December 2002 - 8:10:30
<br />During this 30-day reporting period, a total of <b>573</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./blue-v.png" width="15" height="72.4420677361854" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">4.3%<br /><img src="./blue-v.png" width="15" height="63.3868092691622" alt="4.3" /></td>

<td align="center" valign="bottom" class="asmall">2.6%<br /><img src="./blue-v.png" width="15" height="37.9768270944742" alt="2.6" /></td>

<td align="center" valign="bottom" class="asmall">2.3%<br /><img src="./blue-v.png" width="15" height="33.716577540107" alt="2.3" /></td>

<td align="center" valign="bottom" class="asmall">2.5%<br /><img src="./blue-v.png" width="15" height="36.8894830659537" alt="2.5" /></td>

<td align="center" valign="bottom" class="asmall">2.7%<br /><img src="./blue-v.png" width="15" height="40.3743315508021" alt="2.7" /></td>

<td align="center" valign="bottom" class="asmall">3.0%<br /><img src="./green-v.png" width="15" height="43.8146167557932" alt="3.0" /></td>

<td align="center" valign="bottom" class="asmall">2.7%<br /><img src="./green-v.png" width="15" height="39.5811051693405" alt="2.7" /></td>

<td align="center" valign="bottom" class="asmall">3.0%<br /><img src="./green-v.png" width="15" height="44.8306595365419" alt="3.0" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./green-v.png" width="15" height="56.1051693404635" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./green-v.png" width="15" height="46.3814616755793" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./green-v.png" width="15" height="56.0695187165775" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./yellow-v.png" width="15" height="45.427807486631" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">3.6%<br /><img src="./yellow-v.png" width="15" height="53.2887700534759" alt="3.6" /></td>

<td align="center" valign="bottom" class="asmall">4.1%<br /><img src="./yellow-v.png" width="15" height="60.9625668449198" alt="4.1" /></td>

<td align="center" valign="bottom" class="asmall">5.4%<br /><img src="./yellow-v.png" width="15" height="79.8841354723708" alt="5.4" /></td>

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./yellow-v.png" width="15" height="72.4598930481284" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">5.4%<br /><img src="./yellow-v.png" width="15" height="79.8930481283422" alt="5.4" /></td>

<td align="center" valign="bottom" class="asmall">5.3%<br /><img src="./red-v.png" width="15" height="77.4420677361854" alt="5.3" /></td>

<td align="center" valign="bottom" class="asmall">4.0%<br /><img src="./red-v.png" width="15" height="58.49376114082" alt="4.0" /></td>

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./red-v.png" width="15" height="71.319073083779" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">6.1%<br /><img src="./red-v.png" width="15" height="89.2335115864528" alt="6.1" /></td>

<td align="center" valign="bottom" class="asmall">6.8%<br /><img src="./red-v.png" width="15" height="100" alt="6.8" /></td>

<td align="center" valign="bottom" class="asmall">5.6%<br /><img src="./red-v.png" width="15" height="82.0320855614973" alt="5.6" /></td>

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
<td style="background-color: #babadc"><?php id(370); ?></td><td style="background-color: #babadc">8225</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #babadc">45215</td><td style="background-color: #babadc">5.5</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"by Marylin manson or the original?"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(1625); ?></td><td style="background-color: #babadc">4780</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #babadc">38710</td><td style="background-color: #babadc">8.1</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Exactly Boggy, that's why I do it"</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(2122); ?></td><td style="background-color: #babadc">3133</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #babadc">32880</td><td style="background-color: #babadc">10.5</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Halle Berry is the worst Bond girl ever. :P"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(1551); ?></td><td style="background-color: #babadc">5565</td><td style="background-color: #babadc"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="6" height="15" alt="" /></td><td style="background-color: #babadc">30548</td><td style="background-color: #babadc">5.5</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Zed, it's not resucitation when you slip the tongue in :P"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(1332); ?></td><td style="background-color: #bbbbdb">6279</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #bbbbdb">27283</td><td style="background-color: #bbbbdb">4.3</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"short on plot but makes up for it in action"</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(1247); ?></td><td style="background-color: #bbbbdb">7329</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="1" height="15" alt="" /></td><td style="background-color: #bbbbdb">27125</td><td style="background-color: #bbbbdb">3.7</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"He isn't that high.....another Viagra argument coming on"</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(473); ?></td><td style="background-color: #bbbbdb">5240</td><td style="background-color: #bbbbdb"><img src="./green-h.png" border="0" width="7" height="15" alt="" /><img src="./yellow-h.png" border="0" width="16" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #bbbbdb">26672</td><td style="background-color: #bbbbdb">5.1</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"When I stopped taking it, I was sick ALL the time."</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(1594); ?></td><td style="background-color: #bbbbdb">5515</td><td style="background-color: #bbbbdb"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #bbbbdb">22929</td><td style="background-color: #bbbbdb">4.2</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"Gen, did you see my link to the Buster Sword you can buy?"</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(168); ?></td><td style="background-color: #bcbcda">2320</td><td style="background-color: #bcbcda"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bcbcda">21715</td><td style="background-color: #bcbcda">9.4</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"It's not on anymore anyway, is it?"</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(331); ?></td><td style="background-color: #bcbcda">5289</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #bcbcda">21540</td><td style="background-color: #bcbcda">4.1</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"that was an evil smile....."</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(16); ?></td><td style="background-color: #bcbcda">2288</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bcbcda">20422</td><td style="background-color: #bcbcda">8.9</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"it's up... just loading slower than the devil's diper"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(1908); ?></td><td style="background-color: #bcbcda">4347</td><td style="background-color: #bcbcda"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="19" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bcbcda">18602</td><td style="background-color: #bcbcda">4.3</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"and then each of them in half"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(57); ?></td><td style="background-color: #bdbdda">2820</td><td style="background-color: #bdbdda"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="20" height="15" alt="" /><img src="./red-h.png" border="0" width="14" height="15" alt="" /></td><td style="background-color: #bdbdda">17667</td><td style="background-color: #bdbdda">6.3</td><td style="background-color: #bdbdda">Today</td><td style="background-color: #bdbdda">"and yes, im satisfied skor"</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9">MiniElf</td><td style="background-color: #bdbdd9">3626</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #bdbdd9">17439</td><td style="background-color: #bdbdd9">4.8</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"What's HMSTR anyway? 12 mil?"</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(23); ?></td><td style="background-color: #bdbdd9">2354</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="13" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="8" height="15" alt="" /></td><td style="background-color: #bdbdd9">16282</td><td style="background-color: #bdbdd9">6.9</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"keep it up. they can't kick you :P"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(94); ?></td><td style="background-color: #bdbdd9">1777</td><td style="background-color: #bdbdd9"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #bdbdd9">15321</td><td style="background-color: #bdbdd9">8.6</td><td style="background-color: #bdbdd9">1 day ago</td><td style="background-color: #bdbdd9">""Oh" &gt;fiddle&lt; &gt;fiddle&lt; &gt;BZZZZZZZEEEEERT!&lt; &gt;THUD!&lt;"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(1699); ?></td><td style="background-color: #bebed9">3136</td><td style="background-color: #bebed9"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="28" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #bebed9">13966</td><td style="background-color: #bebed9">4.5</td><td style="background-color: #bebed9">Today</td><td style="background-color: #bebed9">"which isn't going to happen"</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8"><?php id(1218); ?></td><td style="background-color: #bebed8">2364</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="21" height="15" alt="" /></td><td style="background-color: #bebed8">13919</td><td style="background-color: #bebed8">5.9</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"minerva sanchez villa-lobos ramirez"</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(1762); ?></td><td style="background-color: #bebed8">3582</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #bebed8">13695</td><td style="background-color: #bebed8">3.8</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"I opened the damn door...remember? :p"</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(141); ?></td><td style="background-color: #bebed8">2625</td><td style="background-color: #bebed8"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="9" height="15" alt="" /></td><td style="background-color: #bebed8">13235</td><td style="background-color: #bebed8">5.0</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">""teamwork, i do a tremendous amount of teamwork.""</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8"><?php id(229); ?></td><td style="background-color: #bfbfd8">1437</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="7" height="15" alt="" /><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #bfbfd8">13123</td><td style="background-color: #bfbfd8">9.1</td><td style="background-color: #bfbfd8">2 days ago</td><td style="background-color: #bfbfd8">"Die Another Day had a buncha Bond references thrown in."</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(135); ?></td><td style="background-color: #bfbfd8">2024</td><td style="background-color: #bfbfd8"><img src="./blue-h.png" border="0" width="16" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #bfbfd8">12470</td><td style="background-color: #bfbfd8">6.2</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"I like your style, Boggo :P"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7"><?php id(1829); ?></td><td style="background-color: #bfbfd7">3261</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="4" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bfbfd7">12109</td><td style="background-color: #bfbfd7">3.7</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"when Koral can add to the roster"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7"><?php id(118); ?></td><td style="background-color: #bfbfd7">1197</td><td style="background-color: #bfbfd7"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #bfbfd7">11199</td><td style="background-color: #bfbfd7">9.4</td><td style="background-color: #bfbfd7">1 day ago</td><td style="background-color: #bfbfd7">"yay...I'm in the top 20 of both High Rollers and Time in Service"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(1036); ?></td><td style="background-color: #c0c0d7">1262</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="12" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c0c0d7">10122</td><td style="background-color: #c0c0d7">8.0</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"The main graphic on the opening mall page."</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(666); ?></td><td style="background-color: #c0c0d7">1078</td><td style="background-color: #c0c0d7"><img src="./blue-h.png" border="0" width="5" height="15" alt="" /><img src="./green-h.png" border="0" width="28" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c0c0d7">9813</td><td style="background-color: #c0c0d7">9.1</td><td style="background-color: #c0c0d7">2 days ago</td><td style="background-color: #c0c0d7">"so, is now a bad time to mention /clear?"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6"><?php id(275); ?></td><td style="background-color: #c0c0d6">1817</td><td style="background-color: #c0c0d6"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c0c0d6">9764</td><td style="background-color: #c0c0d6">5.4</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"ChaB: 12mil for my next, then I need to get to 100mil :p"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6"><?php id(1085); ?></td><td style="background-color: #c0c0d6">2444</td><td style="background-color: #c0c0d6"><img src="./green-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c0c0d6">8970</td><td style="background-color: #c0c0d6">3.7</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"Yes, but you're larger'n a person, nyk :P"</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6">^SyNth</td><td style="background-color: #c0c0d6">2295</td><td style="background-color: #c0c0d6"><img src="./green-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="23" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c0c0d6">8795</td><td style="background-color: #c0c0d6">3.8</td><td style="background-color: #c0c0d6">3 days ago</td><td style="background-color: #c0c0d6">"but they were all during changes in commish"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6">_-Mage-_</td><td style="background-color: #c1c1d6">1417</td><td style="background-color: #c1c1d6"><img src="./blue-h.png" border="0" width="8" height="15" alt="" /><img src="./yellow-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c1c1d6">8572</td><td style="background-color: #c1c1d6">6.0</td><td style="background-color: #c1c1d6">Today</td><td style="background-color: #c1c1d6">"Way to ruin the moment, dear. :P"</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5"><?php id(1356); ?></td><td style="background-color: #c1c1d5">1488</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c1c1d5">8327</td><td style="background-color: #c1c1d5">5.6</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"the pictures plan backfired thanks to b0t :P"</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5"><?php id(747); ?></td><td style="background-color: #c1c1d5">2315</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="17" height="15" alt="" /><img src="./green-h.png" border="0" width="16" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="3" height="15" alt="" /></td><td style="background-color: #c1c1d5">8172</td><td style="background-color: #c1c1d5">3.5</td><td style="background-color: #c1c1d5">1 day ago</td><td style="background-color: #c1c1d5">"hey ford did you see the boston-washington game? :P"</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5"><?php id(1187); ?></td><td style="background-color: #c1c1d5">993</td><td style="background-color: #c1c1d5"><img src="./blue-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #c1c1d5">7725</td><td style="background-color: #c1c1d5">7.8</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"that would be number five..."</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5"><?php id(577); ?></td><td style="background-color: #c2c2d5">1442</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c2c2d5">7484</td><td style="background-color: #c2c2d5">5.2</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"you don't have to be a hunter for the CH exam?"</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5"><?php id(2029); ?></td><td style="background-color: #c2c2d5">1168</td><td style="background-color: #c2c2d5"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c2c2d5">7475</td><td style="background-color: #c2c2d5">6.4</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"yeah, but i'd like them off my back now"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(1413); ?></td><td style="background-color: #c2c2d4">1413</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="29" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c2c2d4">7069</td><td style="background-color: #c2c2d4">5.0</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"And the residential area we live in is barely 5 years old."</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4"><?php id(14); ?></td><td style="background-color: #c2c2d4">1091</td><td style="background-color: #c2c2d4"><img src="./blue-h.png" border="0" width="6" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="20" height="15" alt="" /></td><td style="background-color: #c2c2d4">6553</td><td style="background-color: #c2c2d4">6.0</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"Opinions based on facts can be attacked."</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4"><?php id(1754); ?></td><td style="background-color: #c3c3d4">1151</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c3c3d4">5626</td><td style="background-color: #c3c3d4">4.9</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"something about lara making the pope horny, perhaps?"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(484); ?></td><td style="background-color: #c3c3d4">951</td><td style="background-color: #c3c3d4"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="34" height="15" alt="" /><img src="./red-h.png" border="0" width="2" height="15" alt="" /></td><td style="background-color: #c3c3d4">5512</td><td style="background-color: #c3c3d4">5.8</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"when it got a bit too stiff"</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3"><?php id(1943); ?></td><td style="background-color: #c3c3d3">1219</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="12" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c3c3d3">5349</td><td style="background-color: #c3c3d3">4.4</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"if you buy a hull and put stuff on it = ship"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3">Xar_</td><td style="background-color: #c3c3d3">733</td><td style="background-color: #c3c3d3"><img src="./blue-h.png" border="0" width="31" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c3c3d3">4576</td><td style="background-color: #c3c3d3">6.2</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"when your finished but hurry"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3"><?php id(1562); ?></td><td style="background-color: #c4c4d3">1152</td><td style="background-color: #c4c4d3"><img src="./blue-h.png" border="0" width="15" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #c4c4d3">4488</td><td style="background-color: #c4c4d3">3.9</td><td style="background-color: #c4c4d3">13 days ago</td><td style="background-color: #c4c4d3">"Zach stop singing, you're annoying."</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3"><?php id(1798); ?></td><td style="background-color: #c4c4d3">640</td><td style="background-color: #c4c4d3"><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c4c4d3">3931</td><td style="background-color: #c4c4d3">6.1</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"Anyways... go time for me."</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(765); ?></td><td style="background-color: #c4c4d3">784</td><td style="background-color: #c4c4d3"><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="26" height="15" alt="" /><img src="./red-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c4c4d3">3880</td><td style="background-color: #c4c4d3">4.9</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"you got it from a manish looking chick in the US senate"</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2"><?php id(2118); ?></td><td style="background-color: #c4c4d2">679</td><td style="background-color: #c4c4d2"><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c4c4d2">3877</td><td style="background-color: #c4c4d2">5.7</td><td style="background-color: #c4c4d2">Today</td><td style="background-color: #c4c4d2">"i feel some tension in here"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2"><?php id(1489); ?></td><td style="background-color: #c5c5d2">590</td><td style="background-color: #c5c5d2"><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c5c5d2">3218</td><td style="background-color: #c5c5d2">5.5</td><td style="background-color: #c5c5d2">1 day ago</td><td style="background-color: #c5c5d2">"everyone stop idling alai is here shhhhhh"</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2"><?php id(295); ?></td><td style="background-color: #c5c5d2">497</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="22" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c5c5d2">3165</td><td style="background-color: #c5c5d2">6.4</td><td style="background-color: #c5c5d2">2 days ago</td><td style="background-color: #c5c5d2">"Well it was fairly recently, after a long LOA."</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2">Necrolord</td><td style="background-color: #c5c5d2">694</td><td style="background-color: #c5c5d2"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c5c5d2">3104</td><td style="background-color: #c5c5d2">4.5</td><td style="background-color: #c5c5d2">1 day ago</td><td style="background-color: #c5c5d2">"well it seems the jedi kiddies are fast asleep"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1">Moreco</td><td style="background-color: #c5c5d1">334</td><td style="background-color: #c5c5d1"><img src="./yellow-h.png" border="0" width="7" height="15" alt="" /><img src="./red-h.png" border="0" width="32" height="15" alt="" /></td><td style="background-color: #c5c5d1">3088</td><td style="background-color: #c5c5d1">9.2</td><td style="background-color: #c5c5d1">Today</td><td style="background-color: #c5c5d1">"oh, so a genocide is smart?"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1">mirei{W^F</td><td style="background-color: #c6c6d1">548</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="25" height="15" alt="" /></td><td style="background-color: #c6c6d1">3040</td><td style="background-color: #c6c6d1">5.5</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"i have relatives that are but i aint"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1">Ender`</td><td style="background-color: #c6c6d1">506</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c6c6d1">2957</td><td style="background-color: #c6c6d1">5.8</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"yeah because i was overthrown :P"</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1">`Kerrigan</td><td style="background-color: #c6c6d1">569</td><td style="background-color: #c6c6d1"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="4" height="15" alt="" /></td><td style="background-color: #c6c6d1">2947</td><td style="background-color: #c6c6d1">5.2</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"i used to have really red hair :)"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0">^Fyre</td><td style="background-color: #c6c6d0">313</td><td style="background-color: #c6c6d0"><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /><img src="./red-h.png" border="0" width="22" height="15" alt="" /></td><td style="background-color: #c6c6d0">2490</td><td style="background-color: #c6c6d0">8.0</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"That MB page? I stoped reading as soon as I saw what its about."</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0"><?php id(1843); ?></td><td style="background-color: #c6c6d0">903</td><td style="background-color: #c6c6d0"><img src="./blue-h.png" border="0" width="18" height="15" alt="" /><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c6c6d0">2478</td><td style="background-color: #c6c6d0">2.7</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"i didn't even know who the hell challenged me"</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0"><?php id(45); ?></td><td style="background-color: #c7c7d0">299</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="6" height="15" alt="" /><img src="./red-h.png" border="0" width="11" height="15" alt="" /></td><td style="background-color: #c7c7d0">2420</td><td style="background-color: #c7c7d0">8.1</td><td style="background-color: #c7c7d0">2 days ago</td><td style="background-color: #c7c7d0">"k, fixed...   but what if i didn;t have a wheel ;p"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0"><?php id(1873); ?></td><td style="background-color: #c7c7d0">382</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c7c7d0">2416</td><td style="background-color: #c7c7d0">6.3</td><td style="background-color: #c7c7d0">4 days ago</td><td style="background-color: #c7c7d0">"owww my legs are locked up from all the standing i did today"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0">Conan`</td><td style="background-color: #c7c7d0">531</td><td style="background-color: #c7c7d0"><img src="./blue-h.png" border="0" width="3" height="15" alt="" /><img src="./green-h.png" border="0" width="10" height="15" alt="" /><img src="./yellow-h.png" border="0" width="21" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c7c7d0">2211</td><td style="background-color: #c7c7d0">4.2</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"its not that difficult to fly a plane"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf">CL|Karrde</td><td style="background-color: #c7c7cf">412</td><td style="background-color: #c7c7cf"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="5" height="15" alt="" /><img src="./yellow-h.png" border="0" width="14" height="15" alt="" /><img src="./red-h.png" border="0" width="5" height="15" alt="" /></td><td style="background-color: #c7c7cf">1950</td><td style="background-color: #c7c7cf">4.7</td><td style="background-color: #c7c7cf">5 days ago</td><td style="background-color: #c7c7cf">"trying to make enough money for some more parts..."</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf">MK</td><td style="background-color: #c8c8cf">356</td><td style="background-color: #c8c8cf"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="24" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #c8c8cf">1934</td><td style="background-color: #c8c8cf">5.4</td><td style="background-color: #c8c8cf">9 days ago</td><td style="background-color: #c8c8cf">"so, you answered your own question, no?"</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf"><?php id(494); ?></td><td style="background-color: #c8c8cf">371</td><td style="background-color: #c8c8cf"><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /><img src="./red-h.png" border="0" width="28" height="15" alt="" /></td><td style="background-color: #c8c8cf">1870</td><td style="background-color: #c8c8cf">5.0</td><td style="background-color: #c8c8cf">12 days ago</td><td style="background-color: #c8c8cf">"What did you do, play Sabacc 24/6/365?"</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf"><?php id(1583); ?></td><td style="background-color: #c8c8cf">200</td><td style="background-color: #c8c8cf"><img src="./green-h.png" border="0" width="20" height="15" alt="" /><img src="./yellow-h.png" border="0" width="18" height="15" alt="" /></td><td style="background-color: #c8c8cf">1850</td><td style="background-color: #c8c8cf">9.2</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"brb reboot"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce"><?php id(2206); ?></td><td style="background-color: #c8c8ce">354</td><td style="background-color: #c8c8ce"><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #c8c8ce">1816</td><td style="background-color: #c8c8ce">5.1</td><td style="background-color: #c8c8ce">Today</td><td style="background-color: #c8c8ce">"Especially if your evil and cool"</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce">Conan257</td><td style="background-color: #c9c9ce">489</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="4" height="15" alt="" /><img src="./green-h.png" border="0" width="17" height="15" alt="" /><img src="./yellow-h.png" border="0" width="17" height="15" alt="" /></td><td style="background-color: #c9c9ce">1766</td><td style="background-color: #c9c9ce">3.6</td><td style="background-color: #c9c9ce">24 days ago</td><td style="background-color: #c9c9ce">"bored with u all now......think ill go watch some porn"</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce"><?php id(1717); ?></td><td style="background-color: #c9c9ce">483</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="9" height="15" alt="" /><img src="./green-h.png" border="0" width="18" height="15" alt="" /><img src="./yellow-h.png" border="0" width="10" height="15" alt="" /></td><td style="background-color: #c9c9ce">1733</td><td style="background-color: #c9c9ce">3.6</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"i wonder which kabal is opening up"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce"><?php id(1281); ?></td><td style="background-color: #c9c9ce">315</td><td style="background-color: #c9c9ce"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #c9c9ce">1554</td><td style="background-color: #c9c9ce">4.9</td><td style="background-color: #c9c9ce">1 day ago</td><td style="background-color: #c9c9ce">"oh hell .... now we're scarred for lfie"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce"><?php id(1190); ?></td><td style="background-color: #c9c9ce">401</td><td style="background-color: #c9c9ce"><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="15" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #c9c9ce">1504</td><td style="background-color: #c9c9ce">3.8</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"hopefully you'll end up with a 9"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd">SlideShow</td><td style="background-color: #cacacd">215</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="11" height="15" alt="" /><img src="./yellow-h.png" border="0" width="4" height="15" alt="" /><img src="./red-h.png" border="0" width="23" height="15" alt="" /></td><td style="background-color: #cacacd">1500</td><td style="background-color: #cacacd">7.0</td><td style="background-color: #cacacd">2 days ago</td><td style="background-color: #cacacd">"well good night got to go see you all tommorrow"</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd"><?php id(1219); ?></td><td style="background-color: #cacacd">274</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="14" height="15" alt="" /><img src="./green-h.png" border="0" width="2" height="15" alt="" /><img src="./yellow-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="13" height="15" alt="" /></td><td style="background-color: #cacacd">1441</td><td style="background-color: #cacacd">5.3</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"[01:13] *** Ninj has quit IRC (Quit)"</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd"><?php id(2213); ?></td><td style="background-color: #cacacd">231</td><td style="background-color: #cacacd"><img src="./green-h.png" border="0" width="9" height="15" alt="" /><img src="./red-h.png" border="0" width="30" height="15" alt="" /></td><td style="background-color: #cacacd">1411</td><td style="background-color: #cacacd">6.1</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"4? i'm sure there's more than that"</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd"><?php id(2009); ?></td><td style="background-color: #cacacd">316</td><td style="background-color: #cacacd"><img src="./blue-h.png" border="0" width="21" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="15" height="15" alt="" /></td><td style="background-color: #cacacd">1402</td><td style="background-color: #cacacd">4.4</td><td style="background-color: #cacacd">1 day ago</td><td style="background-color: #cacacd">"heh ya especially around me"</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc">DaZMan</td><td style="background-color: #cbcbcc">335</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="23" height="15" alt="" /><img src="./yellow-h.png" border="0" width="3" height="15" alt="" /><img src="./red-h.png" border="0" width="12" height="15" alt="" /></td><td style="background-color: #cbcbcc">1244</td><td style="background-color: #cbcbcc">3.7</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"been around for like 6 months now :P"</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc">t00bdaed</td><td style="background-color: #cbcbcc">87</td><td style="background-color: #cbcbcc"><img src="./green-h.png" border="0" width="3" height="15" alt="" /><img src="./yellow-h.png" border="0" width="11" height="15" alt="" /><img src="./red-h.png" border="0" width="24" height="15" alt="" /></td><td style="background-color: #cbcbcc">1212</td><td style="background-color: #cbcbcc">13.9</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"that's 'deadb00t', Cour &gt;:P"</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc"><?php id(1289); ?></td><td style="background-color: #cbcbcc">157</td><td style="background-color: #cbcbcc"><img src="./green-h.png" border="0" width="14" height="15" alt="" /><img src="./yellow-h.png" border="0" width="8" height="15" alt="" /><img src="./red-h.png" border="0" width="16" height="15" alt="" /></td><td style="background-color: #cbcbcc">1121</td><td style="background-color: #cbcbcc">7.1</td><td style="background-color: #cbcbcc">3 days ago</td><td style="background-color: #cbcbcc">"you don't get a medal, for first"</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc">Adian</td><td style="background-color: #cbcbcc">191</td><td style="background-color: #cbcbcc"><img src="./blue-h.png" border="0" width="1" height="15" alt="" /><img src="./green-h.png" border="0" width="1" height="15" alt="" /><img src="./yellow-h.png" border="0" width="29" height="15" alt="" /><img src="./red-h.png" border="0" width="7" height="15" alt="" /></td><td style="background-color: #cbcbcc">1069</td><td style="background-color: #cbcbcc">5.6</td><td style="background-color: #cbcbcc">1 day ago</td><td style="background-color: #cbcbcc">"and who critizied me for oi"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc"><?php id(1809); ?></td><td style="background-color: #cccccc">196</td><td style="background-color: #cccccc"><img src="./blue-h.png" border="0" width="2" height="15" alt="" /><img src="./red-h.png" border="0" width="37" height="15" alt="" /></td><td style="background-color: #cccccc">1054</td><td style="background-color: #cccccc">5.4</td><td style="background-color: #cccccc">16 days ago</td><td style="background-color: #cccccc">"anyone want to see that LEGO PORN I was talking about?"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10">JanetReno (1037)</td>
<td class="rankc10"><?php id(1697); ?> (1030)</td>
<td class="rankc10"><?php id(1165); ?> (1011)</td>
<td class="rankc10"><?php id(1064); ?> (949)</td>
<td class="rankc10"><?php id(77); ?> (897)</td>
</tr><tr>
<td class="rankc10">aewis` (764)</td>
<td class="rankc10">`Syd|RO (753)</td>
<td class="rankc10">Talra-PHP (750)</td>
<td class="rankc10"><?php id(152); ?> (744)</td>
<td class="rankc10">FruitCak (738)</td>
</tr><tr>
<td class="rankc10">`Syd|GFX (726)</td>
<td class="rankc10"><?php id(47); ?> (720)</td>
<td class="rankc10">`Jahieden (697)</td>
<td class="rankc10"><?php id(2131); ?> (697)</td>
<td class="rankc10">Tradik_UT (695)</td>
</tr><tr>
<td class="rankc10">Vegito (660)</td>
<td class="rankc10"><?php id(11); ?> (616)</td>
<td class="rankc10">Sayo (604)</td>
<td class="rankc10"><?php id(796); ?> (598)</td>
<td class="rankc10">Jughead (579)</td>
</tr><tr>
<td class="rankc10">Karrde|GB (544)</td>
<td class="rankc10">Icedemon (528)</td>
<td class="rankc10"><?php id(160); ?> (502)</td>
<td class="rankc10"><?php id(2070); ?> (490)</td>
<td class="rankc10">`Sayo (478)</td>
</tr><tr>
<td class="rankc10"><?php id(182); ?> (462)</td>
<td class="rankc10">D_S|RO (447)</td>
<td class="rankc10">Bar_Keep (437)</td>
<td class="rankc10">Tal-mdk (436)</td>
<td class="rankc10">t00bd00f (409)</td>
</tr><tr>
<td class="rankc10">Hitman47 (392)</td>
<td class="rankc10"><?php id(374); ?> (386)</td>
<td class="rankc10">`ZL (378)</td>
<td class="rankc10">TradDIshs (352)</td>
<td class="rankc10">TradikHW (343)</td>
</tr><tr>
<td class="rankc10">SupaFugga (330)</td>
<td class="rankc10"><?php id(1627); ?> (328)</td>
<td class="rankc10">Zetar (317)</td>
<td class="rankc10"><?php id(1133); ?> (305)</td>
<td class="rankc10">CPL_Mark (302)</td>
</tr></table>
<br /><b>By the way, there were 455 other nicks.</b><br />
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

<tr><td class="hicell">Is <b>Necrolord</b> stupid or just asking too many questions?  24.2% lines contained a question!
<br /><span class="small"><b>mirei{W^F</b> didn't know that much either.  23.7% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(1829); ?></b>, who yelled 39.4% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(1943); ?></b>, who shouted 31.4% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b>MiniElf</b>'s shift-key is hanging:  13.7% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[11:43] &lt;MiniElf&gt; OW!
</span><br />
<br /><span class="small"><b><?php id(331); ?></b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 13.1% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1332); ?></b> is a very aggressive person.  He/She attacked others <b>84</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[19:03] Action: `Syd whaps cor
</span><br />
<br /><span class="small"><b><?php id(1247); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>70</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(1198); ?></b>, nobody likes him/her.  He/She was attacked <b>57</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[07:44] Action: CL|Karrde kicks the ssl
</span><br />
<br /><span class="small"><b><?php id(1594); ?></b> seems to be unliked too.  He/She got beaten <b>38</b> times.</span>
</td></tr>
<tr><td class="hicell"><b>Jughead</b> brings happiness to the world.  47.5% lines contained smiling faces.  :)
<br /><span class="small"><b><?php id(2122); ?></b> isn't a sad person either, smiling 44.8% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1165); ?></b> seems to be sad at the moment:  2.2% lines contained sad faces.  :(
<br /><span class="small"><b><?php id(1943); ?></b> is also a sad person, crying 1.8% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(2122); ?></b> wrote the longest lines, averaging 54.9 letters per line.<br />
<span class="small">#bhg average was 27.8 letters per line.</span></td></tr>
<tr><td class="hicell"><b><?php id(1843); ?></b> wrote the shortest lines, averaging 13.6 characters per line.<br />
<span class="small"><b><?php id(2070); ?></b> was tight-lipped, too, averaging 13.8 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(370); ?></b> spoke a total of 45215 words!
<br /><span class="small"><?php id(370); ?>'s faithful follower, <b><?php id(1625); ?></b>, didn't speak so much: 38710 words.</span>
</td></tr>
<tr><td class="hicell"><b>Motti (EH)</b> wrote an average of 25.29 words per line.
<br /><span class="small">Channel average was 5.44 words per line.</span>
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
<td class="hicell">46057</td>
<td class="hicell">MiniElf</td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(42); ?></td>
<td class="hicell">3840</td>
<td class="hicell"><?php id(331); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell">about</td>
<td class="hicell">1957</td>
<td class="hicell"><?php id(370); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell">think</td>
<td class="hicell">1645</td>
<td class="hicell"><?php id(331); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(1103); ?></td>
<td class="hicell">1582</td>
<td class="hicell">^SyNth</td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">there</td>
<td class="hicell">1401</td>
<td class="hicell"><?php id(1036); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">would</td>
<td class="hicell">1097</td>
<td class="hicell"><?php id(2122); ?></td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">people</td>
<td class="hicell">1088</td>
<td class="hicell"><?php id(2122); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">really</td>
<td class="hicell">1075</td>
<td class="hicell"><?php id(1843); ?></td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">going</td>
<td class="hicell">1054</td>
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
<td class="hicell">21691</td>
<td class="hicell"><?php id(1551); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(331); ?></td>
<td class="hicell">16978</td>
<td class="hicell"><?php id(1085); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(1908); ?></td>
<td class="hicell">11626</td>
<td class="hicell"><?php id(1594); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(1281); ?></td>
<td class="hicell">4320</td>
<td class="hicell"><?php id(1551); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(300); ?></td>
<td class="hicell">2300</td>
<td class="hicell"><?php id(1754); ?></td>
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
<td class="hicell"><a href="http://www.ehnet.org/sabacc">http://www.ehnet.org/sabacc</a></td>
<td class="hicell">23</td>
<td class="hicell"><?php id(1247); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://www...">http://www...</a></td>
<td class="hicell">10</td>
<td class="hicell"><?php id(135); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://lawngnome.cernun.net/lotto/">http://lawngnome.cernun.net/lotto/</a></td>
<td class="hicell">9</td>
<td class="hicell"><?php id(275); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://www.tekzoned.com/games/reflections/index.html">http://www.tekzoned.com/games/reflections/index.html</a></td>
<td class="hicell">7</td>
<td class="hicell"><?php id(1332); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://beamsolutions.net/talra/index.php">http://beamsolutions.net/talra/index.php</a></td>
<td class="hicell">6</td>
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

<tr><td class="hicell"><b><?php id(1594); ?></b> wasn't very popular, getting kicked 44 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[21:43] Coranel kicked from #bhg by `Coursca: Here's your damn ops.
</span><br />
<br /><span class="small"><b><?php id(1908); ?></b> seemed to be hated too:  21 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(473); ?></b> is either insane or just a fair op, kicking a total of 111 people!
<br /><span class="small"><?php id(473); ?>'s faithful follower, <b><?php id(1625); ?></b>, kicked about 58 people.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(473); ?></b> donated 37 ops in the channel...
<br /><span class="small"><b>LawnGnome</b> was also very polite: 36 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(275); ?></b> is the channel sheriff with 6 deops.
<br /><span class="small"><b><?php id(1625); ?></b> deoped 4 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(370); ?></b> always lets us know what he/she's doing: 1306 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[03:42] Action: Zarkana grabs her binkie too
</span><br />
<br /><span class="small">Also, <b><?php id(1762); ?></b> tells us what's up with 956 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 42 times!
<br /><span class="small">Another lonely one was <b><?php id(370); ?></b>, who managed to hit 38 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> couldn't decide whether to stay or go.  370 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>btl|chris</b> has quite a potty mouth.  4.0% words were foul language.
<br /><span class="small"><b>`Ixion</b> also makes sailors blush, 3.1% of the time.</span>
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

<tr><td class="hicell"><i>(fordprefect) A thousand curse upon you, Bob Stoops! || !quote 521 for a kick || Please notify Koral if Derius comes in when an @ isn't here...</i></td>
<td class="hicell"><b>by <?php id(473); ?> on 22:18</b></td></tr>
<tr><td class="hicell"><i>(fordprefect) A thousand curse upon you, Bob Stoops! || !quote 521 for QotW || Please notify Koral if Derius comes in when an @ isn't here...</i></td>
<td class="hicell"><b>by <?php id(473); ?> on 22:06</b></td></tr>
<tr><td class="hicell"><i>(fordprefect) A thousand curse upon you, Bob Stoops! || !quote 521 for QotW</i></td>
<td class="hicell"><b>by <?php id(1699); ?> on 21:09</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 320 times.</td></tr>
</table>
Total number of lines: 163097.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 01 minutes and 14 seconds
</span>
</div>
</body>
</html>

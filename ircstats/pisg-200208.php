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
Statistics generated on  Monday 2 September 2002 - 1:51:52
<br />During this 31-day reporting period, a total of <b>482</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">6.1%<br /><img src="./blue-v.png" width="15" height="89.0036335819468" alt="6.1" /></td>

<td align="center" valign="bottom" class="asmall">4.9%<br /><img src="./blue-v.png" width="15" height="70.7209791547141" alt="4.9" /></td>

<td align="center" valign="bottom" class="asmall">3.9%<br /><img src="./blue-v.png" width="15" height="56.6647542551157" alt="3.9" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./blue-v.png" width="15" height="45.7640084146108" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./blue-v.png" width="15" height="45.6683878370625" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">2.8%<br /><img src="./blue-v.png" width="15" height="41.1455345190285" alt="2.8" /></td>

<td align="center" valign="bottom" class="asmall">2.7%<br /><img src="./green-v.png" width="15" height="39.0801300439855" alt="2.7" /></td>

<td align="center" valign="bottom" class="asmall">2.4%<br /><img src="./green-v.png" width="15" height="35.8959648116275" alt="2.4" /></td>

<td align="center" valign="bottom" class="asmall">2.3%<br /><img src="./green-v.png" width="15" height="34.2034805890228" alt="2.3" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./green-v.png" width="15" height="44.7695544081086" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./green-v.png" width="15" height="60.5469497035762" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./green-v.png" width="15" height="61.5892139988526" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">3.5%<br /><img src="./yellow-v.png" width="15" height="50.9848919487474" alt="3.5" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./yellow-v.png" width="15" height="61.5127175368139" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./yellow-v.png" width="15" height="55.0392044367948" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./yellow-v.png" width="15" height="61.2545419774335" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">3.7%<br /><img src="./yellow-v.png" width="15" height="53.7387645821381" alt="3.7" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./yellow-v.png" width="15" height="55.1635111876076" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./red-v.png" width="15" height="55.7850449416714" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./red-v.png" width="15" height="61.5127175368139" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">5.0%<br /><img src="./red-v.png" width="15" height="72.5090839548671" alt="5.0" /></td>

<td align="center" valign="bottom" class="asmall">5.1%<br /><img src="./red-v.png" width="15" height="74.3449990437942" alt="5.1" /></td>

<td align="center" valign="bottom" class="asmall">6.9%<br /><img src="./red-v.png" width="15" height="100" alt="6.9" /></td>

<td align="center" valign="bottom" class="asmall">6.8%<br /><img src="./red-v.png" width="15" height="99.0151080512526" alt="6.8" /></td>

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
<td>&nbsp;</td><td class="tdtop"><b>Nick</b></td><td class="tdtop"><b>Number of lines</b></td><td class="tdtop"><b>Number of Credits</b></td><td class="tdtop"><b>Number of Words</b></td><td class="tdtop"><b>Words per line</b></td><td class="tdtop"><b>Last seen</b></td><td class="tdtop"><b>Random quote</b></td>
</tr>
<tr><td class="hirankc" align="left">1</td>
<td style="background-color: #babadc"><?php id(168); ?></td><td style="background-color: #babadc">3665</td><td style="background-color: #babadc">256535</td><td style="background-color: #babadc">35915</td><td style="background-color: #babadc">9.8</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"He-Man is back!  Unfortunately it's not back in Canada... :P"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(370); ?></td><td style="background-color: #babadc">6167</td><td style="background-color: #babadc">243442</td><td style="background-color: #babadc">34082</td><td style="background-color: #babadc">5.5</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"nah..just closed PS 6.0 down"</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(1771); ?></td><td style="background-color: #babadc">7649</td><td style="background-color: #babadc">239371</td><td style="background-color: #babadc">33512</td><td style="background-color: #babadc">4.4</td><td style="background-color: #babadc">1 day ago</td><td style="background-color: #babadc">"so hopfully it will go thru"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(95); ?></td><td style="background-color: #babadc">1662</td><td style="background-color: #babadc">191021</td><td style="background-color: #babadc">26743</td><td style="background-color: #babadc">16.1</td><td style="background-color: #babadc">21 days ago</td><td style="background-color: #babadc">"ahh you poor poor bastard, what made you learn french ?"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(16); ?></td><td style="background-color: #bbbbdb">2644</td><td style="background-color: #bbbbdb">189864</td><td style="background-color: #bbbbdb">26581</td><td style="background-color: #bbbbdb">10.1</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"eeeeeeewwww... I've got algea breathe..."</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(57); ?></td><td style="background-color: #bbbbdb">3391</td><td style="background-color: #bbbbdb">167271</td><td style="background-color: #bbbbdb">23418</td><td style="background-color: #bbbbdb">6.9</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"like Russia..they wouldnt notice"</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(94); ?></td><td style="background-color: #bbbbdb">2814</td><td style="background-color: #bbbbdb">167242</td><td style="background-color: #bbbbdb">23414</td><td style="background-color: #bbbbdb">8.3</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"so nothing to inappropriate"</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(473); ?></td><td style="background-color: #bbbbdb">2864</td><td style="background-color: #bbbbdb">163757</td><td style="background-color: #bbbbdb">22926</td><td style="background-color: #bbbbdb">8.0</td><td style="background-color: #bbbbdb">1 day ago</td><td style="background-color: #bbbbdb">"pizzaguy, I have a new name for you"</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(1218); ?></td><td style="background-color: #bcbcda">3707</td><td style="background-color: #bcbcda">161571</td><td style="background-color: #bcbcda">22620</td><td style="background-color: #bcbcda">6.1</td><td style="background-color: #bcbcda">1 day ago</td><td style="background-color: #bcbcda">"It was a pretty good flick."</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(1762); ?></td><td style="background-color: #bcbcda">4349</td><td style="background-color: #bcbcda">128978</td><td style="background-color: #bcbcda">18057</td><td style="background-color: #bcbcda">4.2</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"Because I'm to tired to ageree..."</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(2174); ?></td><td style="background-color: #bcbcda">3376</td><td style="background-color: #bcbcda">127735</td><td style="background-color: #bcbcda">17883</td><td style="background-color: #bcbcda">5.3</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"well noone seemed to be talking so i said something"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(666); ?></td><td style="background-color: #bcbcda">1846</td><td style="background-color: #bcbcda">127728</td><td style="background-color: #bcbcda">17882</td><td style="background-color: #bcbcda">9.7</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"we haven't done starcraft in a KAG for over two years, afaik"</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(1332); ?></td><td style="background-color: #bdbdda">3939</td><td style="background-color: #bdbdda">124407</td><td style="background-color: #bdbdda">17417</td><td style="background-color: #bdbdda">4.4</td><td style="background-color: #bdbdda">Today</td><td style="background-color: #bdbdda">"<a href="http://www.on-line.co.uk/iron_wolves/index.shtml" target="_blank" title="Open in new window: http://www.on-line.co.uk/iron_wolves/index.shtml">http://www.on-line.co.uk/iron_wolves/index.shtml</a>"</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9"><?php id(229); ?></td><td style="background-color: #bdbdd9">1925</td><td style="background-color: #bdbdd9">118228</td><td style="background-color: #bdbdd9">16552</td><td style="background-color: #bdbdd9">8.6</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"the opening cinema for FF6 is very cool."</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(1551); ?></td><td style="background-color: #bdbdd9">3313</td><td style="background-color: #bdbdd9">114785</td><td style="background-color: #bdbdd9">16070</td><td style="background-color: #bdbdd9">4.9</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"I'ma gonna go off and play some JKII"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(2122); ?></td><td style="background-color: #bdbdd9">1299</td><td style="background-color: #bdbdd9">114550</td><td style="background-color: #bdbdd9">16037</td><td style="background-color: #bdbdd9">12.3</td><td style="background-color: #bdbdd9">1 day ago</td><td style="background-color: #bdbdd9">"Damn, Blodes, you're still only an ASAN?  You lazy bastard. :P"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(23); ?></td><td style="background-color: #bebed9">1972</td><td style="background-color: #bebed9">110571</td><td style="background-color: #bebed9">15480</td><td style="background-color: #bebed9">7.8</td><td style="background-color: #bebed9">Today</td><td style="background-color: #bebed9">"if they have any axes, I'm getting one of them instead."</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8"><?php id(2118); ?></td><td style="background-color: #bebed8">2561</td><td style="background-color: #bebed8">110285</td><td style="background-color: #bebed8">15440</td><td style="background-color: #bebed8">6.0</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"oh its still good everytime"</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(1699); ?></td><td style="background-color: #bebed8">2988</td><td style="background-color: #bebed8">109557</td><td style="background-color: #bebed8">15338</td><td style="background-color: #bebed8">5.1</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"oops, i think i broke him..."</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(1829); ?></td><td style="background-color: #bebed8">3036</td><td style="background-color: #bebed8">104028</td><td style="background-color: #bebed8">14564</td><td style="background-color: #bebed8">4.8</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"since I'm close to thirty, it makes me think"</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8"><?php id(1803); ?></td><td style="background-color: #bfbfd8">2316</td><td style="background-color: #bfbfd8">103242</td><td style="background-color: #bfbfd8">14454</td><td style="background-color: #bfbfd8">6.2</td><td style="background-color: #bfbfd8">5 days ago</td><td style="background-color: #bfbfd8">"methinks i gots a good quit message"</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(14); ?></td><td style="background-color: #bfbfd8">2007</td><td style="background-color: #bfbfd8">100264</td><td style="background-color: #bfbfd8">14037</td><td style="background-color: #bfbfd8">7.0</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"That was just kinda.. sporadic. :P"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7"><?php id(767); ?></td><td style="background-color: #bfbfd7">2425</td><td style="background-color: #bfbfd7">95378</td><td style="background-color: #bfbfd7">13353</td><td style="background-color: #bfbfd7">5.5</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"Ask those cockroaches at Hiroshima about nuclear wars, Ari! :)"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7"><?php id(1036); ?></td><td style="background-color: #bfbfd7">1798</td><td style="background-color: #bfbfd7">90800</td><td style="background-color: #bfbfd7">12712</td><td style="background-color: #bfbfd7">7.1</td><td style="background-color: #bfbfd7">3 days ago</td><td style="background-color: #bfbfd7">"The brain on your computer."</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(85); ?></td><td style="background-color: #c0c0d7">1984</td><td style="background-color: #c0c0d7">88871</td><td style="background-color: #c0c0d7">12442</td><td style="background-color: #c0c0d7">6.3</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"Well, I have all of them in DOC format"</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(1697); ?></td><td style="background-color: #c0c0d7">2326</td><td style="background-color: #c0c0d7">87107</td><td style="background-color: #c0c0d7">12195</td><td style="background-color: #c0c0d7">5.2</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"7. TIE Fighters have no shields. "</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6"><?php id(2195); ?></td><td style="background-color: #c0c0d6">1954</td><td style="background-color: #c0c0d6">63735</td><td style="background-color: #c0c0d6">8923</td><td style="background-color: #c0c0d6">4.6</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"brb i am off to ruin my sims lives"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6"><?php id(118); ?></td><td style="background-color: #c0c0d6">1111</td><td style="background-color: #c0c0d6">60100</td><td style="background-color: #c0c0d6">8414</td><td style="background-color: #c0c0d6">7.6</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"Vlad--only if you're caught"</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(22); ?></td><td style="background-color: #c0c0d6">1515</td><td style="background-color: #c0c0d6">59850</td><td style="background-color: #c0c0d6">8379</td><td style="background-color: #c0c0d6">5.5</td><td style="background-color: #c0c0d6">1 day ago</td><td style="background-color: #c0c0d6">"but i don't see it being kicked alot"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6"><?php id(1264); ?></td><td style="background-color: #c1c1d6">1651</td><td style="background-color: #c1c1d6">54814</td><td style="background-color: #c1c1d6">7674</td><td style="background-color: #c1c1d6">4.6</td><td style="background-color: #c1c1d6">Today</td><td style="background-color: #c1c1d6">"i'm working for the rents in the morning.. answering phones"</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5"><?php id(108); ?></td><td style="background-color: #c1c1d5">1348</td><td style="background-color: #c1c1d5">51871</td><td style="background-color: #c1c1d5">7262</td><td style="background-color: #c1c1d5">5.4</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"Pass test, buy ship, join kabal, earn credits."</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5"><?php id(1722); ?></td><td style="background-color: #c1c1d5">1872</td><td style="background-color: #c1c1d5">47400</td><td style="background-color: #c1c1d5">6636</td><td style="background-color: #c1c1d5">3.5</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"thats my cousin not my clone"</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5"><?php id(275); ?></td><td style="background-color: #c1c1d5">1043</td><td style="background-color: #c1c1d5">42192</td><td style="background-color: #c1c1d5">5907</td><td style="background-color: #c1c1d5">5.7</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"oh, and we're 55 posts short of 50,000."</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5"><?php id(1561); ?></td><td style="background-color: #c2c2d5">1215</td><td style="background-color: #c2c2d5">41300</td><td style="background-color: #c2c2d5">5782</td><td style="background-color: #c2c2d5">4.8</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"hey I have Zalda for my calc"</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5"><?php id(141); ?></td><td style="background-color: #c2c2d5">1196</td><td style="background-color: #c2c2d5">41242</td><td style="background-color: #c2c2d5">5774</td><td style="background-color: #c2c2d5">4.8</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"actually im not part of the bird family am I?"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(1754); ?></td><td style="background-color: #c2c2d4">1030</td><td style="background-color: #c2c2d4">40735</td><td style="background-color: #c2c2d4">5703</td><td style="background-color: #c2c2d4">5.5</td><td style="background-color: #c2c2d4">3 days ago</td><td style="background-color: #c2c2d4">"before it crapped out, it was at 10 mbps"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4"><?php id(2131); ?></td><td style="background-color: #c2c2d4">1079</td><td style="background-color: #c2c2d4">39314</td><td style="background-color: #c2c2d4">5504</td><td style="background-color: #c2c2d4">5.1</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"So, Salo, what's wrong with me being in the roster? :)"</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4"><?php id(1711); ?></td><td style="background-color: #c3c3d4">634</td><td style="background-color: #c3c3d4">38521</td><td style="background-color: #c3c3d4">5393</td><td style="background-color: #c3c3d4">8.5</td><td style="background-color: #c3c3d4">2 days ago</td><td style="background-color: #c3c3d4">"I've really never watched anime much at all..."</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(1085); ?></td><td style="background-color: #c3c3d4">1111</td><td style="background-color: #c3c3d4">36950</td><td style="background-color: #c3c3d4">5173</td><td style="background-color: #c3c3d4">4.7</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"..I don't, in any case &gt;:P"</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3"><?php id(2029); ?></td><td style="background-color: #c3c3d3">924</td><td style="background-color: #c3c3d3">34585</td><td style="background-color: #c3c3d3">4842</td><td style="background-color: #c3c3d3">5.2</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"same diff. we're all assholes"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3"><?php id(1413); ?></td><td style="background-color: #c3c3d3">896</td><td style="background-color: #c3c3d3">34364</td><td style="background-color: #c3c3d3">4811</td><td style="background-color: #c3c3d3">5.4</td><td style="background-color: #c3c3d3">7 days ago</td><td style="background-color: #c3c3d3">"Suggestions would be nice."</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3"><?php id(1843); ?></td><td style="background-color: #c4c4d3">1392</td><td style="background-color: #c4c4d3">34292</td><td style="background-color: #c4c4d3">4801</td><td style="background-color: #c4c4d3">3.4</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"over in -------------------&gt;&gt;&gt;&gt; that window"</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3"><?php id(1625); ?></td><td style="background-color: #c4c4d3">548</td><td style="background-color: #c4c4d3">33171</td><td style="background-color: #c4c4d3">4644</td><td style="background-color: #c4c4d3">8.5</td><td style="background-color: #c4c4d3">2 days ago</td><td style="background-color: #c4c4d3">"Hence the reason I'm usually chipper and happy"</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(2208); ?></td><td style="background-color: #c4c4d3">904</td><td style="background-color: #c4c4d3">32757</td><td style="background-color: #c4c4d3">4586</td><td style="background-color: #c4c4d3">5.1</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"whooooooooo! I'm a newbie! "</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2"><?php id(494); ?></td><td style="background-color: #c4c4d2">920</td><td style="background-color: #c4c4d2">32528</td><td style="background-color: #c4c4d2">4554</td><td style="background-color: #c4c4d2">5.0</td><td style="background-color: #c4c4d2">Today</td><td style="background-color: #c4c4d2">"Does LG not work on the Wings, or something?"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2"><?php id(34); ?></td><td style="background-color: #c5c5d2">1114</td><td style="background-color: #c5c5d2">32242</td><td style="background-color: #c5c5d2">4514</td><td style="background-color: #c5c5d2">4.1</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"i like the GFX for it too...."</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2"><?php id(577); ?></td><td style="background-color: #c5c5d2">953</td><td style="background-color: #c5c5d2">30657</td><td style="background-color: #c5c5d2">4292</td><td style="background-color: #c5c5d2">4.5</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"ahh, so THAT'S how it works"</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2"><?php id(2206); ?></td><td style="background-color: #c5c5d2">907</td><td style="background-color: #c5c5d2">30542</td><td style="background-color: #c5c5d2">4276</td><td style="background-color: #c5c5d2">4.7</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"Nah, im White. Canadian descent"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1"><?php id(484); ?></td><td style="background-color: #c5c5d1">725</td><td style="background-color: #c5c5d1">30128</td><td style="background-color: #c5c5d1">4218</td><td style="background-color: #c5c5d1">5.8</td><td style="background-color: #c5c5d1">3 days ago</td><td style="background-color: #c5c5d1">"so find a hot horny old girl :P"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1"><?php id(1877); ?></td><td style="background-color: #c6c6d1">1021</td><td style="background-color: #c6c6d1">29421</td><td style="background-color: #c6c6d1">4119</td><td style="background-color: #c6c6d1">4.0</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"is there a way to have a hidden field in a form"</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1"><?php id(331); ?></td><td style="background-color: #c6c6d1">963</td><td style="background-color: #c6c6d1">27864</td><td style="background-color: #c6c6d1">3901</td><td style="background-color: #c6c6d1">4.1</td><td style="background-color: #c6c6d1">4 days ago</td><td style="background-color: #c6c6d1">"gotta go to some walking tour crap"</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1"><?php id(1656); ?></td><td style="background-color: #c6c6d1">844</td><td style="background-color: #c6c6d1">24878</td><td style="background-color: #c6c6d1">3483</td><td style="background-color: #c6c6d1">4.1</td><td style="background-color: #c6c6d1">1 day ago</td><td style="background-color: #c6c6d1">"and I keep sellin off ship for 1 ic and buyin em for that"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0"><?php id(1908); ?></td><td style="background-color: #c6c6d0">768</td><td style="background-color: #c6c6d0">24842</td><td style="background-color: #c6c6d0">3478</td><td style="background-color: #c6c6d0">4.5</td><td style="background-color: #c6c6d0">1 day ago</td><td style="background-color: #c6c6d0">"Yo momma so nasty she made speed stick slow down."</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0"><?php id(1356); ?></td><td style="background-color: #c6c6d0">654</td><td style="background-color: #c6c6d0">23692</td><td style="background-color: #c6c6d0">3317</td><td style="background-color: #c6c6d0">5.1</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"eh not many trainees come in here DJ"</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0"><?php id(1171); ?></td><td style="background-color: #c7c7d0">861</td><td style="background-color: #c7c7d0">22728</td><td style="background-color: #c7c7d0">3182</td><td style="background-color: #c7c7d0">3.7</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"I figured out that he was a captain"</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0"><?php id(2159); ?></td><td style="background-color: #c7c7d0">585</td><td style="background-color: #c7c7d0">22400</td><td style="background-color: #c7c7d0">3136</td><td style="background-color: #c7c7d0">5.4</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"oh hes not here wondered why it went quiet :P"</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0"><?php id(1105); ?></td><td style="background-color: #c7c7d0">491</td><td style="background-color: #c7c7d0">21800</td><td style="background-color: #c7c7d0">3052</td><td style="background-color: #c7c7d0">6.2</td><td style="background-color: #c7c7d0">1 day ago</td><td style="background-color: #c7c7d0">"then im free from this Hello hole"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf"><?php id(123); ?></td><td style="background-color: #c7c7cf">453</td><td style="background-color: #c7c7cf">20900</td><td style="background-color: #c7c7cf">2926</td><td style="background-color: #c7c7cf">6.5</td><td style="background-color: #c7c7cf">3 days ago</td><td style="background-color: #c7c7cf">"you too brought it down to....."</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf"><?php id(45); ?></td><td style="background-color: #c8c8cf">364</td><td style="background-color: #c8c8cf">20042</td><td style="background-color: #c8c8cf">2806</td><td style="background-color: #c8c8cf">7.7</td><td style="background-color: #c8c8cf">2 days ago</td><td style="background-color: #c8c8cf">"and there was me thnking he sucked yours ;p"</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf"><?php id(2181); ?></td><td style="background-color: #c8c8cf">802</td><td style="background-color: #c8c8cf">19628</td><td style="background-color: #c8c8cf">2748</td><td style="background-color: #c8c8cf">3.4</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"WHAT IS THE DAMN FEELING!!"</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf"><?php id(1004); ?></td><td style="background-color: #c8c8cf">399</td><td style="background-color: #c8c8cf">19378</td><td style="background-color: #c8c8cf">2713</td><td style="background-color: #c8c8cf">6.8</td><td style="background-color: #c8c8cf">1 day ago</td><td style="background-color: #c8c8cf">"that's about as ironclad as you can get."</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce"><?php id(1135); ?></td><td style="background-color: #c8c8ce">412</td><td style="background-color: #c8c8ce">18385</td><td style="background-color: #c8c8ce">2574</td><td style="background-color: #c8c8ce">6.2</td><td style="background-color: #c8c8ce">Today</td><td style="background-color: #c8c8ce">"I'm off to perform my evil deeds. be back letah"</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce"><?php id(2213); ?></td><td style="background-color: #c9c9ce">481</td><td style="background-color: #c9c9ce">17400</td><td style="background-color: #c9c9ce">2436</td><td style="background-color: #c9c9ce">5.1</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"so, everyone here's in the guild"</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce"><?php id(1247); ?></td><td style="background-color: #c9c9ce">748</td><td style="background-color: #c9c9ce">17064</td><td style="background-color: #c9c9ce">2389</td><td style="background-color: #c9c9ce">3.2</td><td style="background-color: #c9c9ce">7 days ago</td><td style="background-color: #c9c9ce">"The Nineth Great Wonder of the World"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce"><?php id(2006); ?></td><td style="background-color: #c9c9ce">661</td><td style="background-color: #c9c9ce">16964</td><td style="background-color: #c9c9ce">2375</td><td style="background-color: #c9c9ce">3.6</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"Because...he wants to hunt you down and kill you"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce"><?php id(2170); ?></td><td style="background-color: #c9c9ce">471</td><td style="background-color: #c9c9ce">16314</td><td style="background-color: #c9c9ce">2284</td><td style="background-color: #c9c9ce">4.8</td><td style="background-color: #c9c9ce">1 day ago</td><td style="background-color: #c9c9ce">"hey shadow i just read your post on run ons"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd"><?php id(295); ?></td><td style="background-color: #cacacd">369</td><td style="background-color: #cacacd">15728</td><td style="background-color: #cacacd">2202</td><td style="background-color: #cacacd">6.0</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"No? Then where you planning to ste it on fire or something?"</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd"><?php id(1943); ?></td><td style="background-color: #cacacd">359</td><td style="background-color: #cacacd">15571</td><td style="background-color: #cacacd">2180</td><td style="background-color: #cacacd">6.1</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"thus why I did them all at once:)"</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd"><?php id(796); ?></td><td style="background-color: #cacacd">354</td><td style="background-color: #cacacd">15500</td><td style="background-color: #cacacd">2170</td><td style="background-color: #cacacd">6.1</td><td style="background-color: #cacacd">1 day ago</td><td style="background-color: #cacacd">"so Fordio - what you got planned for us Gomega plebs?"</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd"><?php id(1219); ?></td><td style="background-color: #cacacd">475</td><td style="background-color: #cacacd">15278</td><td style="background-color: #cacacd">2139</td><td style="background-color: #cacacd">4.5</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"he ssaid baradur and orthanac"</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc"><?php id(1627); ?></td><td style="background-color: #cbcbcc">408</td><td style="background-color: #cbcbcc">15114</td><td style="background-color: #cbcbcc">2116</td><td style="background-color: #cbcbcc">5.2</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"who do i sent char sheets to now? :P"</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc"><?php id(1281); ?></td><td style="background-color: #cbcbcc">382</td><td style="background-color: #cbcbcc">14978</td><td style="background-color: #cbcbcc">2097</td><td style="background-color: #cbcbcc">5.5</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"where did you get that from?"</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc"><?php id(11); ?></td><td style="background-color: #cbcbcc">256</td><td style="background-color: #cbcbcc">14557</td><td style="background-color: #cbcbcc">2038</td><td style="background-color: #cbcbcc">8.0</td><td style="background-color: #cbcbcc">7 days ago</td><td style="background-color: #cbcbcc">"hi"</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc"><?php id(1497); ?></td><td style="background-color: #cbcbcc">218</td><td style="background-color: #cbcbcc">13064</td><td style="background-color: #cbcbcc">1829</td><td style="background-color: #cbcbcc">8.4</td><td style="background-color: #cbcbcc">25 days ago</td><td style="background-color: #cbcbcc">"and his site has been pretty much deleted"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc"><?php id(2162); ?></td><td style="background-color: #cccccc">422</td><td style="background-color: #cccccc">12921</td><td style="background-color: #cccccc">1809</td><td style="background-color: #cccccc">4.3</td><td style="background-color: #cccccc">Today</td><td style="background-color: #cccccc">"You do the testing, I'll do the laughing"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10"><?php id(747); ?> (1589)</td>
<td class="rankc10"><?php id(1562); ?> (1397)</td>
<td class="rankc10"><?php id(182); ?> (1397)</td>
<td class="rankc10"><?php id(152); ?> (1372)</td>
<td class="rankc10"><?php id(1533); ?> (1339)</td>
</tr><tr>
<td class="rankc10"><?php id(1489); ?> (1310)</td>
<td class="rankc10"><?php id(1861); ?> (1291)</td>
<td class="rankc10"><?php id(2172); ?> (1265)</td>
<td class="rankc10">Obi Wan (EH) (1257)</td>
<td class="rankc10"><?php id(765); ?> (1208)</td>
</tr><tr>
<td class="rankc10"><?php id(1165); ?> (1087)</td>
<td class="rankc10"><?php id(1133); ?> (1076)</td>
<td class="rankc10"><?php id(1064); ?> (1065)</td>
<td class="rankc10"><?php id(250); ?> (1054)</td>
<td class="rankc10">Chi-Long (914)</td>
</tr><tr>
<td class="rankc10"><?php id(1594); ?> (879)</td>
<td class="rankc10"><?php id(488); ?> (845)</td>
<td class="rankc10"><?php id(374); ?> (823)</td>
<td class="rankc10"><?php id(1583); ?> (819)</td>
<td class="rankc10"><?php id(2070); ?> (800)</td>
</tr><tr>
<td class="rankc10"><?php id(366); ?> (711)</td>
<td class="rankc10"><?php id(80); ?> (668)</td>
<td class="rankc10"><?php id(77); ?> (667)</td>
<td class="rankc10"><?php id(2219); ?> (636)</td>
<td class="rankc10"><?php id(264); ?> (625)</td>
</tr><tr>
<td class="rankc10"><?php id(2222); ?> (586)</td>
<td class="rankc10"><?php id(1798); ?> (570)</td>
<td class="rankc10">Dolemite (??) (551)</td>
<td class="rankc10"><?php id(1289); ?> (542)</td>
<td class="rankc10"><?php id(1198); ?> (537)</td>
</tr><tr>
<td class="rankc10"><?php id(257); ?> (498)</td>
<td class="rankc10"><?php id(2217); ?> (495)</td>
<td class="rankc10"><?php id(546); ?> (494)</td>
<td class="rankc10"><?php id(158); ?> (485)</td>
<td class="rankc10"><?php id(91); ?> (469)</td>
</tr><tr>
<td class="rankc10">Motti (EH) (457)</td>
<td class="rankc10"><?php id(1720); ?> (454)</td>
<td class="rankc10">Lechuza (421)</td>
<td class="rankc10"><?php id(818); ?> (421)</td>
<td class="rankc10"><?php id(64); ?> (420)</td>
</tr></table>
<br /><b>By the way, there were 367 other nicks.</b><br />
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

<tr><td class="hicell">Is <b><?php id(1861); ?></b> stupid or just asking too many questions?  37.8% lines contained a question!
<br /><span class="small"><b><?php id(295); ?></b> didn't know that much either.  21.4% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(488); ?></b>, who yelled 87.1% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(2070); ?></b>, who shouted 26.6% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b><?php id(370); ?></b>'s shift-key is hanging:  8.4% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[11:41] &lt;Talra&gt; :-P
</span><br />
<br /><span class="small"><b><?php id(2213); ?></b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 8.3% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1803); ?></b> is a very aggressive person.  He/She attacked others <b>41</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[05:54] Action: fury|g slaps Syd around with a pizza box
</span><br />
<br /><span class="small"><b><?php id(57); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>35</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b>the</b>, nobody likes him/her.  He/She was attacked <b>26</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[17:13] Action: `Gen kills the peacock..i need dinner
</span><br />
<br /><span class="small"><b>his</b> seems to be unliked too.  He/She got beaten <b>22</b> times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(158); ?></b> brings happiness to the world.  51.7% lines contained smiling faces.  :)
<br /><span class="small"><b><?php id(2122); ?></b> isn't a sad person either, smiling 48.4% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(2172); ?></b> seems to be sad at the moment:  3.0% lines contained sad faces.  :(
<br /><span class="small"><b><?php id(16); ?></b> is also a sad person, crying 2.0% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(95); ?></b> wrote the longest lines, averaging 80.7 letters per line.<br />
<span class="small">#bhg average was 29.7 letters per line.</span></td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> wrote the shortest lines, averaging 14.9 characters per line.<br />
<span class="small"><b><?php id(2181); ?></b> was tight-lipped, too, averaging 15.5 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(168); ?></b> spoke a total of 35915 words!
<br /><span class="small"><?php id(168); ?>'s faithful follower, <b><?php id(370); ?></b>, didn't speak so much: 34082 words.</span>
</td></tr>
<tr><td class="hicell"><b>MarStuff</b> wrote an average of 24.00 words per line.
<br /><span class="small">Channel average was 5.91 words per line.</span>
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
<td class="hicell">about</td>
<td class="hicell">1970</td>
<td class="hicell"><?php id(118); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell">there</td>
<td class="hicell">1714</td>
<td class="hicell"><?php id(229); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell">think</td>
<td class="hicell">1623</td>
<td class="hicell"><?php id(577); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell">would</td>
<td class="hicell">1242</td>
<td class="hicell"><?php id(168); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">people</td>
<td class="hicell">1221</td>
<td class="hicell"><?php id(1561); ?></td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">really</td>
<td class="hicell">1203</td>
<td class="hicell"><?php id(577); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">going</td>
<td class="hicell">1061</td>
<td class="hicell"><?php id(1561); ?></td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">right</td>
<td class="hicell">1055</td>
<td class="hicell"><?php id(577); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">thats</td>
<td class="hicell">971</td>
<td class="hicell"><?php id(1561); ?></td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">something</td>
<td class="hicell">918</td>
<td class="hicell"><?php id(57); ?></td>
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
<td class="hicell"><?php id(23); ?></td>
<td class="hicell">2179</td>
<td class="hicell"><?php id(370); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(57); ?></td>
<td class="hicell">1368</td>
<td class="hicell"><?php id(118); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(141); ?></td>
<td class="hicell">1355</td>
<td class="hicell"><?php id(1289); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(1218); ?></td>
<td class="hicell">800</td>
<td class="hicell"><?php id(1218); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(767); ?></td>
<td class="hicell">781</td>
<td class="hicell"><?php id(275); ?></td>
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
<td class="hicell"><a href="http://www2.b3ta.com/spidermanwillmakeyougay/">http://www2.b3ta.com/spidermanwillmakeyougay/</a></td>
<td class="hicell">17</td>
<td class="hicell"><?php id(473); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://ircstats.thebhg.org/meetings/">http://ircstats.thebhg.org/meetings/</a></td>
<td class="hicell">16</td>
<td class="hicell"><?php id(85); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://www...">http://www...</a></td>
<td class="hicell">14</td>
<td class="hicell"><?php id(16); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://www.thebhg.org">http://www.thebhg.org</a></td>
<td class="hicell">10</td>
<td class="hicell"><?php id(168); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://www.kweeky.net/">http://www.kweeky.net/</a></td>
<td class="hicell">8</td>
<td class="hicell"><?php id(2174); ?></td>
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

<tr><td class="hicell"><b><?php id(1771); ?></b> wasn't very popular, getting kicked 32 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[16:24] `MadVlad kicked from #bhg by Orin_Will: I'm a member of the Indian Nation, mook
</span><br />
<br /><span class="small"><b><?php id(1803); ?></b> seemed to be hated too:  18 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(95); ?></b> is either insane or just a fair op, kicking a total of 64 people!
<br /><span class="small"><?php id(95); ?>'s faithful follower, <b><?php id(168); ?></b>, kicked about 53 people.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(118); ?></b> donated 17 ops in the channel...
<br /><span class="small"><b><?php id(168); ?></b> was also very polite: 16 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(85); ?></b> is the channel sheriff with 8 deops.
<br /><span class="small"><b><?php id(666); ?></b> deoped 4 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1762); ?></b> always lets us know what he/she's doing: 823 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[18:20] Action: Re_Eson starts throwing rocks at Paxton
</span><br />
<br /><span class="small">Also, <b><?php id(370); ?></b> tells us what's up with 681 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1771); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 68 times!
<br /><span class="small">Another lonely one was <b><?php id(370); ?></b>, who managed to hit 43 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(2174); ?></b> couldn't decide whether to stay or go.  193 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>Bald_Mik</b> has quite a potty mouth.  1.7% words were foul language.
<br /><span class="small"><b>Mark-5</b> also makes sailors blush, 1.6% of the time.</span>
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

<tr><td class="hicell"><i>For hours of fun... add this to your Alias commands: /nov /say $replace($1-,a,-,e,-,i,-,o,-,u,-)</i></td>
<td class="hicell"><b>by <?php id(85); ?> on 19:46</b></td></tr>
<tr><td class="hicell"><i>No X, no PR.</i></td>
<td class="hicell"><b>by <?php id(108); ?> on 12:57</b></td></tr>
<tr><td class="hicell"><i>Meeting over. || IRC Hunt over: Jax 3. || HTH over: KK 2, CS 1, Gramps 1, Zed 1.</i></td>
<td class="hicell"><b>by <?php id(666); ?> on 12:00</b></td></tr>
<tr><td align="center" colspan="2" class="asmall">The topic was set 150 times.</td></tr>
</table>
Total number of lines: 150350.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 05 minutes and 12 seconds
</span>
</div>
</body>
</html>

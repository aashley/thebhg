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
Statistics generated on  Thursday 1 August 2002 - 2:18:29
<br />During this 30-day reporting period, a total of <b>385</b> different nicks were represented on #bhg.<br /><br />
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

<td align="center" valign="bottom" class="asmall">6.5%<br /><img src="./blue-v.png" width="15" height="90.0165623849834" alt="6.5" /></td>

<td align="center" valign="bottom" class="asmall">5.1%<br /><img src="./blue-v.png" width="15" height="71.4482885535517" alt="5.1" /></td>

<td align="center" valign="bottom" class="asmall">5.3%<br /><img src="./blue-v.png" width="15" height="73.3253588516746" alt="5.3" /></td>

<td align="center" valign="bottom" class="asmall">3.4%<br /><img src="./blue-v.png" width="15" height="47.7456753772543" alt="3.4" /></td>

<td align="center" valign="bottom" class="asmall">3.4%<br /><img src="./blue-v.png" width="15" height="47.8100846521899" alt="3.4" /></td>

<td align="center" valign="bottom" class="asmall">2.8%<br /><img src="./blue-v.png" width="15" height="38.8203901361796" alt="2.8" /></td>

<td align="center" valign="bottom" class="asmall">2.9%<br /><img src="./green-v.png" width="15" height="39.9797570850202" alt="2.9" /></td>

<td align="center" valign="bottom" class="asmall">2.7%<br /><img src="./green-v.png" width="15" height="37.3021715126978" alt="2.7" /></td>

<td align="center" valign="bottom" class="asmall">3.0%<br /><img src="./green-v.png" width="15" height="41.543982333456" alt="3.0" /></td>

<td align="center" valign="bottom" class="asmall">3.2%<br /><img src="./green-v.png" width="15" height="44.1203533308796" alt="3.2" /></td>

<td align="center" valign="bottom" class="asmall">3.8%<br /><img src="./green-v.png" width="15" height="53.018034596982" alt="3.8" /></td>

<td align="center" valign="bottom" class="asmall">5.8%<br /><img src="./green-v.png" width="15" height="81.0176665439823" alt="5.8" /></td>

<td align="center" valign="bottom" class="asmall">4.3%<br /><img src="./yellow-v.png" width="15" height="59.8546190651454" alt="4.3" /></td>

<td align="center" valign="bottom" class="asmall">3.9%<br /><img src="./yellow-v.png" width="15" height="54.1682002208318" alt="3.9" /></td>

<td align="center" valign="bottom" class="asmall">3.1%<br /><img src="./yellow-v.png" width="15" height="43.8995215311005" alt="3.1" /></td>

<td align="center" valign="bottom" class="asmall">3.3%<br /><img src="./yellow-v.png" width="15" height="46.8071402281929" alt="3.3" /></td>

<td align="center" valign="bottom" class="asmall">3.0%<br /><img src="./yellow-v.png" width="15" height="41.5071770334928" alt="3.0" /></td>

<td align="center" valign="bottom" class="asmall">3.3%<br /><img src="./yellow-v.png" width="15" height="45.5373573794626" alt="3.3" /></td>

<td align="center" valign="bottom" class="asmall">3.5%<br /><img src="./red-v.png" width="15" height="49.0062569009937" alt="3.5" /></td>

<td align="center" valign="bottom" class="asmall">3.7%<br /><img src="./red-v.png" width="15" height="51.0489510489511" alt="3.7" /></td>

<td align="center" valign="bottom" class="asmall">4.2%<br /><img src="./red-v.png" width="15" height="58.5204269414796" alt="4.2" /></td>

<td align="center" valign="bottom" class="asmall">5.1%<br /><img src="./red-v.png" width="15" height="71.5126978284873" alt="5.1" /></td>

<td align="center" valign="bottom" class="asmall">5.9%<br /><img src="./red-v.png" width="15" height="82.2874493927125" alt="5.9" /></td>

<td align="center" valign="bottom" class="asmall">7.2%<br /><img src="./red-v.png" width="15" height="100" alt="7.2" /></td>

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
<td>&nbsp;</td><td class="tdtop"><b>Nick</b></td><td class="tdtop"><b>Number of lines</b></td><td class="tdtop"><b>Number of Credits</b></td><td class="tdtop"><b>Number of Words</b></td><td class="tdtop"><b>Words per line</b></td><td class="tdtop"><b>Last seen</b></td><td class="tdtop"><b>Random quote</b></td>
</tr>
<tr><td class="hirankc" align="left">1</td>
<td style="background-color: #babadc"><?php id(168); ?></td><td style="background-color: #babadc">12055</td><td style="background-color: #babadc">725400</td><td style="background-color: #babadc">101556</td><td style="background-color: #babadc">8.4</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Bog - it's also a matter of motivation:P"</td>
</tr>
<tr><td class="rankc" align="left">2</td>
<td style="background-color: #babadc"><?php id(370); ?></td><td style="background-color: #babadc">9082</td><td style="background-color: #babadc">331078</td><td style="background-color: #babadc">46351</td><td style="background-color: #babadc">5.1</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"Isn't the whole website joke articles or something"</td>
</tr>
<tr><td class="rankc" align="left">3</td>
<td style="background-color: #babadc"><?php id(1551); ?></td><td style="background-color: #babadc">7764</td><td style="background-color: #babadc">250371</td><td style="background-color: #babadc">35052</td><td style="background-color: #babadc">4.5</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"i feel hyper, but tired all at the same time"</td>
</tr>
<tr><td class="rankc" align="left">4</td>
<td style="background-color: #babadc"><?php id(1699); ?></td><td style="background-color: #babadc">5496</td><td style="background-color: #babadc">219900</td><td style="background-color: #babadc">30786</td><td style="background-color: #babadc">5.6</td><td style="background-color: #babadc">Today</td><td style="background-color: #babadc">"its on my other hard drive, so i've got to transfer it sometime"</td>
</tr>
<tr><td class="rankc" align="left">5</td>
<td style="background-color: #bbbbdb"><?php id(94); ?></td><td style="background-color: #bbbbdb">3358</td><td style="background-color: #bbbbdb">196750</td><td style="background-color: #bbbbdb">27545</td><td style="background-color: #bbbbdb">8.2</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"you want to get to the getting on of it huh aeris? :)"</td>
</tr>
<tr><td class="rankc" align="left">6</td>
<td style="background-color: #bbbbdb"><?php id(1281); ?></td><td style="background-color: #bbbbdb">3495</td><td style="background-color: #bbbbdb">173107</td><td style="background-color: #bbbbdb">24235</td><td style="background-color: #bbbbdb">6.9</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"Re_Eson has just been violated! &gt;:P"</td>
</tr>
<tr><td class="rankc" align="left">7</td>
<td style="background-color: #bbbbdb"><?php id(1829); ?></td><td style="background-color: #bbbbdb">4424</td><td style="background-color: #bbbbdb">159057</td><td style="background-color: #bbbbdb">22268</td><td style="background-color: #bbbbdb">5.0</td><td style="background-color: #bbbbdb">Today</td><td style="background-color: #bbbbdb">"from the paladin's handbook"</td>
</tr>
<tr><td class="rankc" align="left">8</td>
<td style="background-color: #bbbbdb"><?php id(569); ?></td><td style="background-color: #bbbbdb">1867</td><td style="background-color: #bbbbdb">143421</td><td style="background-color: #bbbbdb">20079</td><td style="background-color: #bbbbdb">10.8</td><td style="background-color: #bbbbdb">9 days ago</td><td style="background-color: #bbbbdb">"I think I'm at about 3620 now.  Somewhere around there."</td>
</tr>
<tr><td class="rankc" align="left">9</td>
<td style="background-color: #bcbcda"><?php id(1843); ?></td><td style="background-color: #bcbcda">5002</td><td style="background-color: #bcbcda">134900</td><td style="background-color: #bcbcda">18886</td><td style="background-color: #bcbcda">3.8</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"it should make you feel young"</td>
</tr>
<tr><td class="rankc" align="left">10</td>
<td style="background-color: #bcbcda"><?php id(229); ?></td><td style="background-color: #bcbcda">2179</td><td style="background-color: #bcbcda">134628</td><td style="background-color: #bcbcda">18848</td><td style="background-color: #bcbcda">8.6</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"Yeah, please do. I wanna participate in an Irae comp."</td>
</tr>
<tr><td class="rankc" align="left">11</td>
<td style="background-color: #bcbcda"><?php id(767); ?></td><td style="background-color: #bcbcda">3398</td><td style="background-color: #bcbcda">130264</td><td style="background-color: #bcbcda">18237</td><td style="background-color: #bcbcda">5.4</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"I'd be at 5.8 million if Jer would gimmie my MB Credits. :T"</td>
</tr>
<tr><td class="rankc" align="left">12</td>
<td style="background-color: #bcbcda"><?php id(16); ?></td><td style="background-color: #bcbcda">1774</td><td style="background-color: #bcbcda">124292</td><td style="background-color: #bcbcda">17401</td><td style="background-color: #bcbcda">9.8</td><td style="background-color: #bcbcda">Today</td><td style="background-color: #bcbcda">"I should read dune sometime..."</td>
</tr>
<tr><td class="rankc" align="left">13</td>
<td style="background-color: #bdbdda"><?php id(118); ?></td><td style="background-color: #bdbdda">2065</td><td style="background-color: #bdbdda">119007</td><td style="background-color: #bdbdda">16661</td><td style="background-color: #bdbdda">8.1</td><td style="background-color: #bdbdda">Today</td><td style="background-color: #bdbdda">"Ah, okay, that's not so bad, Det."</td>
</tr>
<tr><td class="rankc" align="left">14</td>
<td style="background-color: #bdbdd9"><?php id(473); ?></td><td style="background-color: #bdbdd9">2233</td><td style="background-color: #bdbdd9">118064</td><td style="background-color: #bdbdd9">16529</td><td style="background-color: #bdbdd9">7.4</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"now my favorite marvel series so far has been Age of Apocolypse"</td>
</tr>
<tr><td class="rankc" align="left">15</td>
<td style="background-color: #bdbdd9"><?php id(1754); ?></td><td style="background-color: #bdbdd9">3018</td><td style="background-color: #bdbdd9">117114</td><td style="background-color: #bdbdd9">16396</td><td style="background-color: #bdbdd9">5.4</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"sailor moon went downhill after they iced JEdite"</td>
</tr>
<tr><td class="rankc" align="left">16</td>
<td style="background-color: #bdbdd9"><?php id(1771); ?></td><td style="background-color: #bdbdd9">3522</td><td style="background-color: #bdbdd9">101114</td><td style="background-color: #bdbdd9">14156</td><td style="background-color: #bdbdd9">4.0</td><td style="background-color: #bdbdd9">Today</td><td style="background-color: #bdbdd9">"I played for the first time last night"</td>
</tr>
<tr><td class="rankc" align="left">17</td>
<td style="background-color: #bebed9"><?php id(2118); ?></td><td style="background-color: #bebed9">2384</td><td style="background-color: #bebed9">94814</td><td style="background-color: #bebed9">13274</td><td style="background-color: #bebed9">5.6</td><td style="background-color: #bebed9">Today</td><td style="background-color: #bebed9">"we can't change the way the planet works"</td>
</tr>
<tr><td class="rankc" align="left">18</td>
<td style="background-color: #bebed8"><?php id(57); ?></td><td style="background-color: #bebed8">1802</td><td style="background-color: #bebed8">91942</td><td style="background-color: #bebed8">12872</td><td style="background-color: #bebed8">7.1</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"yeah...Vlad's right..learn your geography, Zed"</td>
</tr>
<tr><td class="rankc" align="left">19</td>
<td style="background-color: #bebed8"><?php id(1762); ?></td><td style="background-color: #bebed8">3357</td><td style="background-color: #bebed8">90635</td><td style="background-color: #bebed8">12689</td><td style="background-color: #bebed8">3.8</td><td style="background-color: #bebed8">1 day ago</td><td style="background-color: #bebed8">"Or 400...I can't remember right off"</td>
</tr>
<tr><td class="rankc" align="left">20</td>
<td style="background-color: #bebed8"><?php id(95); ?></td><td style="background-color: #bebed8">1242</td><td style="background-color: #bebed8">89714</td><td style="background-color: #bebed8">12560</td><td style="background-color: #bebed8">10.1</td><td style="background-color: #bebed8">Today</td><td style="background-color: #bebed8">"yeah i am, thanks for noticing"</td>
</tr>
<tr><td class="rankc" align="left">21</td>
<td style="background-color: #bfbfd8"><?php id(1332); ?></td><td style="background-color: #bfbfd8">3073</td><td style="background-color: #bfbfd8">88700</td><td style="background-color: #bfbfd8">12418</td><td style="background-color: #bfbfd8">4.0</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"apaerntly the scylla could bark like a dog"</td>
</tr>
<tr><td class="rankc" align="left">22</td>
<td style="background-color: #bfbfd8"><?php id(1264); ?></td><td style="background-color: #bfbfd8">2282</td><td style="background-color: #bfbfd8">82228</td><td style="background-color: #bfbfd8">11512</td><td style="background-color: #bfbfd8">5.0</td><td style="background-color: #bfbfd8">Today</td><td style="background-color: #bfbfd8">"i just sat in it for a while talking to Cat"</td>
</tr>
<tr><td class="rankc" align="left">23</td>
<td style="background-color: #bfbfd7"><?php id(666); ?></td><td style="background-color: #bfbfd7">1219</td><td style="background-color: #bfbfd7">77964</td><td style="background-color: #bfbfd7">10915</td><td style="background-color: #bfbfd7">9.0</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"Talrage: i don't want to know how slow win2k is on that"</td>
</tr>
<tr><td class="rankc" align="left">24</td>
<td style="background-color: #bfbfd7"><?php id(1218); ?></td><td style="background-color: #bfbfd7">1519</td><td style="background-color: #bfbfd7">77214</td><td style="background-color: #bfbfd7">10810</td><td style="background-color: #bfbfd7">7.1</td><td style="background-color: #bfbfd7">Today</td><td style="background-color: #bfbfd7">"But playing one-armed as a linebacker?  Skillz, yo. :P"</td>
</tr>
<tr><td class="rankc" align="left">25</td>
<td style="background-color: #c0c0d7"><?php id(141); ?></td><td style="background-color: #c0c0d7">2148</td><td style="background-color: #c0c0d7">71535</td><td style="background-color: #c0c0d7">10015</td><td style="background-color: #c0c0d7">4.7</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"oh the pain, oh the misery"</td>
</tr>
<tr><td class="rankc" align="left">26</td>
<td style="background-color: #c0c0d7"><?php id(1908); ?></td><td style="background-color: #c0c0d7">2274</td><td style="background-color: #c0c0d7">71514</td><td style="background-color: #c0c0d7">10012</td><td style="background-color: #c0c0d7">4.4</td><td style="background-color: #c0c0d7">Today</td><td style="background-color: #c0c0d7">"like i said u should tell him that"</td>
</tr>
<tr><td class="rankc" align="left">27</td>
<td style="background-color: #c0c0d6"><?php id(484); ?></td><td style="background-color: #c0c0d6">1747</td><td style="background-color: #c0c0d6">67428</td><td style="background-color: #c0c0d6">9440</td><td style="background-color: #c0c0d6">5.4</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"just copy that folder to your computer"</td>
</tr>
<tr><td class="rankc" align="left">28</td>
<td style="background-color: #c0c0d6"><?php id(23); ?></td><td style="background-color: #c0c0d6">1146</td><td style="background-color: #c0c0d6">60678</td><td style="background-color: #c0c0d6">8495</td><td style="background-color: #c0c0d6">7.4</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"or the lack of teaching parents put forth?"</td>
</tr>
<tr><td class="rankc" align="left">29</td>
<td style="background-color: #c0c0d6"><?php id(1803); ?></td><td style="background-color: #c0c0d6">1373</td><td style="background-color: #c0c0d6">59100</td><td style="background-color: #c0c0d6">8274</td><td style="background-color: #c0c0d6">6.0</td><td style="background-color: #c0c0d6">Today</td><td style="background-color: #c0c0d6">"i was suprised cause i got caught eating dirt"</td>
</tr>
<tr><td class="rankc" align="left">30</td>
<td style="background-color: #c1c1d6"><?php id(85); ?></td><td style="background-color: #c1c1d6">1605</td><td style="background-color: #c1c1d6">58735</td><td style="background-color: #c1c1d6">8223</td><td style="background-color: #c1c1d6">5.1</td><td style="background-color: #c1c1d6">2 days ago</td><td style="background-color: #c1c1d6">"How will I know? For this I have done. And I am Julius Caesar.""</td>
</tr>
<tr><td class="rankc" align="left">31</td>
<td style="background-color: #c1c1d5"><?php id(14); ?></td><td style="background-color: #c1c1d5">1119</td><td style="background-color: #c1c1d5">54100</td><td style="background-color: #c1c1d5">7574</td><td style="background-color: #c1c1d5">6.8</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"It's being fixed currently. :P"</td>
</tr>
<tr><td class="rankc" align="left">32</td>
<td style="background-color: #c1c1d5"><?php id(1413); ?></td><td style="background-color: #c1c1d5">1575</td><td style="background-color: #c1c1d5">53892</td><td style="background-color: #c1c1d5">7545</td><td style="background-color: #c1c1d5">4.8</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"on this once-in a lifetime event!"</td>
</tr>
<tr><td class="rankc" align="left">33</td>
<td style="background-color: #c1c1d5"><?php id(1085); ?></td><td style="background-color: #c1c1d5">1623</td><td style="background-color: #c1c1d5">53064</td><td style="background-color: #c1c1d5">7429</td><td style="background-color: #c1c1d5">4.6</td><td style="background-color: #c1c1d5">Today</td><td style="background-color: #c1c1d5">"fod - toss him on Kweek's MUD"</td>
</tr>
<tr><td class="rankc" align="left">34</td>
<td style="background-color: #c2c2d5"><?php id(275); ?></td><td style="background-color: #c2c2d5">1409</td><td style="background-color: #c2c2d5">50778</td><td style="background-color: #c2c2d5">7109</td><td style="background-color: #c2c2d5">5.0</td><td style="background-color: #c2c2d5">Today</td><td style="background-color: #c2c2d5">"aww, i only got to do one OM :P"</td>
</tr>
<tr><td class="rankc" align="left">35</td>
<td style="background-color: #c2c2d5"><?php id(1877); ?></td><td style="background-color: #c2c2d5">1596</td><td style="background-color: #c2c2d5">48971</td><td style="background-color: #c2c2d5">6856</td><td style="background-color: #c2c2d5">4.3</td><td style="background-color: #c2c2d5">1 day ago</td><td style="background-color: #c2c2d5">"drinking is like smoking or doing drugs"</td>
</tr>
<tr><td class="rankc" align="left">36</td>
<td style="background-color: #c2c2d4"><?php id(108); ?></td><td style="background-color: #c2c2d4">1144</td><td style="background-color: #c2c2d4">44371</td><td style="background-color: #c2c2d4">6212</td><td style="background-color: #c2c2d4">5.4</td><td style="background-color: #c2c2d4">Today</td><td style="background-color: #c2c2d4">"And go to the Bosch and Lomb one in person every year"</td>
</tr>
<tr><td class="rankc" align="left">37</td>
<td style="background-color: #c2c2d4"><?php id(1105); ?></td><td style="background-color: #c2c2d4">1317</td><td style="background-color: #c2c2d4">43821</td><td style="background-color: #c2c2d4">6135</td><td style="background-color: #c2c2d4">4.7</td><td style="background-color: #c2c2d4">3 days ago</td><td style="background-color: #c2c2d4">"did you watch the trailer yet Zed?"</td>
</tr>
<tr><td class="rankc" align="left">38</td>
<td style="background-color: #c3c3d4"><?php id(2131); ?></td><td style="background-color: #c3c3d4">1064</td><td style="background-color: #c3c3d4">41807</td><td style="background-color: #c3c3d4">5853</td><td style="background-color: #c3c3d4">5.5</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"would someone please op me so i can kick nyk? :P"</td>
</tr>
<tr><td class="rankc" align="left">39</td>
<td style="background-color: #c3c3d4"><?php id(1247); ?></td><td style="background-color: #c3c3d4">1801</td><td style="background-color: #c3c3d4">41021</td><td style="background-color: #c3c3d4">5743</td><td style="background-color: #c3c3d4">3.2</td><td style="background-color: #c3c3d4">Today</td><td style="background-color: #c3c3d4">"i cant be bothered to change it :P"</td>
</tr>
<tr><td class="rankc" align="left">40</td>
<td style="background-color: #c3c3d3"><?php id(374); ?></td><td style="background-color: #c3c3d3">1043</td><td style="background-color: #c3c3d3">39407</td><td style="background-color: #c3c3d3">5517</td><td style="background-color: #c3c3d3">5.3</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"probably too obnoxious, WB"</td>
</tr>
<tr><td class="rankc" align="left">41</td>
<td style="background-color: #c3c3d3"><?php id(1356); ?></td><td style="background-color: #c3c3d3">1008</td><td style="background-color: #c3c3d3">38542</td><td style="background-color: #c3c3d3">5396</td><td style="background-color: #c3c3d3">5.4</td><td style="background-color: #c3c3d3">Today</td><td style="background-color: #c3c3d3">"I was going to post but then the damn comp froze up! &gt;:P"</td>
</tr>
<tr><td class="rankc" align="left">42</td>
<td style="background-color: #c4c4d3"><?php id(765); ?></td><td style="background-color: #c4c4d3">1166</td><td style="background-color: #c4c4d3">37557</td><td style="background-color: #c4c4d3">5258</td><td style="background-color: #c4c4d3">4.5</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"I had one of those the other day"</td>
</tr>
<tr><td class="rankc" align="left">43</td>
<td style="background-color: #c4c4d3"><?php id(1171); ?></td><td style="background-color: #c4c4d3">1354</td><td style="background-color: #c4c4d3">35971</td><td style="background-color: #c4c4d3">5036</td><td style="background-color: #c4c4d3">3.7</td><td style="background-color: #c4c4d3">Today</td><td style="background-color: #c4c4d3">"if we could combine the two"</td>
</tr>
<tr><td class="rankc" align="left">44</td>
<td style="background-color: #c4c4d3"><?php id(160); ?></td><td style="background-color: #c4c4d3">951</td><td style="background-color: #c4c4d3">35764</td><td style="background-color: #c4c4d3">5007</td><td style="background-color: #c4c4d3">5.3</td><td style="background-color: #c4c4d3">17 days ago</td><td style="background-color: #c4c4d3">"He loses his power without ops."</td>
</tr>
<tr><td class="rankc" align="left">45</td>
<td style="background-color: #c4c4d2"><?php id(1627); ?></td><td style="background-color: #c4c4d2">939</td><td style="background-color: #c4c4d2">34485</td><td style="background-color: #c4c4d2">4828</td><td style="background-color: #c4c4d2">5.1</td><td style="background-color: #c4c4d2">Today</td><td style="background-color: #c4c4d2">"*** Real Name: For help type: /msg X help"</td>
</tr>
<tr><td class="rankc" align="left">46</td>
<td style="background-color: #c5c5d2"><?php id(1839); ?></td><td style="background-color: #c5c5d2">774</td><td style="background-color: #c5c5d2">32057</td><td style="background-color: #c5c5d2">4488</td><td style="background-color: #c5c5d2">5.8</td><td style="background-color: #c5c5d2">3 days ago</td><td style="background-color: #c5c5d2">"i hate it when my computer screws up"</td>
</tr>
<tr><td class="rankc" align="left">47</td>
<td style="background-color: #c5c5d2"><?php id(747); ?></td><td style="background-color: #c5c5d2">1294</td><td style="background-color: #c5c5d2">30078</td><td style="background-color: #c5c5d2">4211</td><td style="background-color: #c5c5d2">3.3</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"thank goodness for that too :P"</td>
</tr>
<tr><td class="rankc" align="left">48</td>
<td style="background-color: #c5c5d2"><?php id(45); ?></td><td style="background-color: #c5c5d2">575</td><td style="background-color: #c5c5d2">29414</td><td style="background-color: #c5c5d2">4118</td><td style="background-color: #c5c5d2">7.2</td><td style="background-color: #c5c5d2">Today</td><td style="background-color: #c5c5d2">"i though bobecc should have got it"</td>
</tr>
<tr><td class="rankc" align="left">49</td>
<td style="background-color: #c5c5d1"><?php id(577); ?></td><td style="background-color: #c5c5d1">838</td><td style="background-color: #c5c5d1">26992</td><td style="background-color: #c5c5d1">3779</td><td style="background-color: #c5c5d1">4.5</td><td style="background-color: #c5c5d1">Today</td><td style="background-color: #c5c5d1">"you got the name wrong but"</td>
</tr>
<tr><td class="rankc" align="left">50</td>
<td style="background-color: #c6c6d1"><?php id(1711); ?></td><td style="background-color: #c6c6d1">431</td><td style="background-color: #c6c6d1">25742</td><td style="background-color: #c6c6d1">3604</td><td style="background-color: #c6c6d1">8.4</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"And stole our fax machine on the way out the door."</td>
</tr>
<tr><td class="rankc" align="left">51</td>
<td style="background-color: #c6c6d1"><?php id(1489); ?></td><td style="background-color: #c6c6d1">627</td><td style="background-color: #c6c6d1">25114</td><td style="background-color: #c6c6d1">3516</td><td style="background-color: #c6c6d1">5.6</td><td style="background-color: #c6c6d1">Today</td><td style="background-color: #c6c6d1">"listion to the higer ranks, we wont stear you wrong"</td>
</tr>
<tr><td class="rankc" align="left">52</td>
<td style="background-color: #c6c6d1"><?php id(1943); ?></td><td style="background-color: #c6c6d1">616</td><td style="background-color: #c6c6d1">24600</td><td style="background-color: #c6c6d1">3444</td><td style="background-color: #c6c6d1">5.6</td><td style="background-color: #c6c6d1">5 days ago</td><td style="background-color: #c6c6d1">"so, just don't do that one?"</td>
</tr>
<tr><td class="rankc" align="left">53</td>
<td style="background-color: #c6c6d0"><?php id(1861); ?></td><td style="background-color: #c6c6d0">556</td><td style="background-color: #c6c6d0">23607</td><td style="background-color: #c6c6d0">3305</td><td style="background-color: #c6c6d0">5.9</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"We get to make fun of you :P"</td>
</tr>
<tr><td class="rankc" align="left">54</td>
<td style="background-color: #c6c6d0"><?php id(494); ?></td><td style="background-color: #c6c6d0">631</td><td style="background-color: #c6c6d0">22921</td><td style="background-color: #c6c6d0">3209</td><td style="background-color: #c6c6d0">5.1</td><td style="background-color: #c6c6d0">Today</td><td style="background-color: #c6c6d0">"Wonder if that would still hurt to touch."</td>
</tr>
<tr><td class="rankc" align="left">55</td>
<td style="background-color: #c7c7d0"><?php id(331); ?></td><td style="background-color: #c7c7d0">916</td><td style="background-color: #c7c7d0">21292</td><td style="background-color: #c7c7d0">2981</td><td style="background-color: #c7c7d0">3.3</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"I prefer to refer to it as a "bubble""</td>
</tr>
<tr><td class="rankc" align="left">56</td>
<td style="background-color: #c7c7d0"><?php id(1225); ?></td><td style="background-color: #c7c7d0">444</td><td style="background-color: #c7c7d0">20314</td><td style="background-color: #c7c7d0">2844</td><td style="background-color: #c7c7d0">6.4</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"Zed - yea.  It's got a table with all it's descriptions."</td>
</tr>
<tr><td class="rankc" align="left">57</td>
<td style="background-color: #c7c7d0"><?php id(1387); ?></td><td style="background-color: #c7c7d0">501</td><td style="background-color: #c7c7d0">20150</td><td style="background-color: #c7c7d0">2821</td><td style="background-color: #c7c7d0">5.6</td><td style="background-color: #c7c7d0">Today</td><td style="background-color: #c7c7d0">"That one is supposed to be online capable"</td>
</tr>
<tr><td class="rankc" align="left">58</td>
<td style="background-color: #c7c7cf"><?php id(1219); ?></td><td style="background-color: #c7c7cf">540</td><td style="background-color: #c7c7cf">19892</td><td style="background-color: #c7c7cf">2785</td><td style="background-color: #c7c7cf">5.2</td><td style="background-color: #c7c7cf">Today</td><td style="background-color: #c7c7cf">"you may all return you Dragonites to #Dragon_kabal you too steve"</td>
</tr>
<tr><td class="rankc" align="left">59</td>
<td style="background-color: #c8c8cf"><?php id(123); ?></td><td style="background-color: #c8c8cf">360</td><td style="background-color: #c8c8cf">18135</td><td style="background-color: #c8c8cf">2539</td><td style="background-color: #c8c8cf">7.1</td><td style="background-color: #c8c8cf">1 day ago</td><td style="background-color: #c8c8cf">"<a href="http://www.b3ta.com/spidermanwillmakeyougay/" target="_blank" title="Open in new window: http://www.b3ta.com/spidermanwillmakeyougay/">http://www.b3ta.com/spidermanwillmakeyougay/</a>"</td>
</tr>
<tr><td class="rankc" align="left">60</td>
<td style="background-color: #c8c8cf"><?php id(796); ?></td><td style="background-color: #c8c8cf">501</td><td style="background-color: #c8c8cf">18085</td><td style="background-color: #c8c8cf">2532</td><td style="background-color: #c8c8cf">5.1</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"what commish slot is open?"</td>
</tr>
<tr><td class="rankc" align="left">61</td>
<td style="background-color: #c8c8cf"><?php id(1722); ?></td><td style="background-color: #c8c8cf">638</td><td style="background-color: #c8c8cf">16485</td><td style="background-color: #c8c8cf">2308</td><td style="background-color: #c8c8cf">3.6</td><td style="background-color: #c8c8cf">Today</td><td style="background-color: #c8c8cf">"i dont need your authority"</td>
</tr>
<tr><td class="rankc" align="left">62</td>
<td style="background-color: #c8c8ce"><?php id(1697); ?></td><td style="background-color: #c8c8ce">447</td><td style="background-color: #c8c8ce">15350</td><td style="background-color: #c8c8ce">2149</td><td style="background-color: #c8c8ce">4.8</td><td style="background-color: #c8c8ce">1 day ago</td><td style="background-color: #c8c8ce">"Farlander Transport pics complete"</td>
</tr>
<tr><td class="rankc" align="left">63</td>
<td style="background-color: #c9c9ce"><?php id(144); ?></td><td style="background-color: #c9c9ce">210</td><td style="background-color: #c9c9ce">14750</td><td style="background-color: #c9c9ce">2065</td><td style="background-color: #c9c9ce">9.8</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"that doesn't sound cheaper then 120GB for $140 =P"</td>
</tr>
<tr><td class="rankc" align="left">64</td>
<td style="background-color: #c9c9ce">Marenta</td><td style="background-color: #c9c9ce">236</td><td style="background-color: #c9c9ce">13628</td><td style="background-color: #c9c9ce">1908</td><td style="background-color: #c9c9ce">8.1</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"Come on.. you could always have another CeReAl GiRl run it.. &gt;:P"</td>
</tr>
<tr><td class="rankc" align="left">65</td>
<td style="background-color: #c9c9ce"><?php id(300); ?></td><td style="background-color: #c9c9ce">232</td><td style="background-color: #c9c9ce">12842</td><td style="background-color: #c9c9ce">1798</td><td style="background-color: #c9c9ce">7.8</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"what guitar ya getting Shad?"</td>
</tr>
<tr><td class="rankc" align="left">66</td>
<td style="background-color: #c9c9ce"><?php id(25); ?></td><td style="background-color: #c9c9ce">401</td><td style="background-color: #c9c9ce">12200</td><td style="background-color: #c9c9ce">1708</td><td style="background-color: #c9c9ce">4.3</td><td style="background-color: #c9c9ce">Today</td><td style="background-color: #c9c9ce">"that Crossword Puzzle is tough"</td>
</tr>
<tr><td class="rankc" align="left">67</td>
<td style="background-color: #cacacd"><?php id(1036); ?></td><td style="background-color: #cacacd">203</td><td style="background-color: #cacacd">10607</td><td style="background-color: #cacacd">1485</td><td style="background-color: #cacacd">7.3</td><td style="background-color: #cacacd">Today</td><td style="background-color: #cacacd">"Oh, the Council was impressed of course."</td>
</tr>
<tr><td class="rankc" align="left">68</td>
<td style="background-color: #cacacd"><?php id(366); ?></td><td style="background-color: #cacacd">218</td><td style="background-color: #cacacd">10342</td><td style="background-color: #cacacd">1448</td><td style="background-color: #cacacd">6.6</td><td style="background-color: #cacacd">3 days ago</td><td style="background-color: #cacacd">"Either Cay or Trench, is my guess."</td>
</tr>
<tr><td class="rankc" align="left">69</td>
<td style="background-color: #cacacd"><?php id(1133); ?></td><td style="background-color: #cacacd">311</td><td style="background-color: #cacacd">9864</td><td style="background-color: #cacacd">1381</td><td style="background-color: #cacacd">4.4</td><td style="background-color: #cacacd">6 days ago</td><td style="background-color: #cacacd">"Oh hell I don't know, I just watched one here and there."</td>
</tr>
<tr><td class="rankc" align="left">70</td>
<td style="background-color: #cacacd"><?php id(135); ?></td><td style="background-color: #cacacd">194</td><td style="background-color: #cacacd">9864</td><td style="background-color: #cacacd">1381</td><td style="background-color: #cacacd">7.1</td><td style="background-color: #cacacd">1 day ago</td><td style="background-color: #cacacd">"<a href="http://www.ehnet.org/sabacc/" target="_blank" title="Open in new window: http://www.ehnet.org/sabacc/">http://www.ehnet.org/sabacc/</a>"</td>
</tr>
<tr><td class="rankc" align="left">71</td>
<td style="background-color: #cbcbcc"><?php id(1625); ?></td><td style="background-color: #cbcbcc">124</td><td style="background-color: #cbcbcc">9114</td><td style="background-color: #cbcbcc">1276</td><td style="background-color: #cbcbcc">10.3</td><td style="background-color: #cbcbcc">26 days ago</td><td style="background-color: #cbcbcc">"Hey DS, she sent me a birthday present and I got it today"</td>
</tr>
<tr><td class="rankc" align="left">72</td>
<td style="background-color: #cbcbcc">Brad Tack</td><td style="background-color: #cbcbcc">247</td><td style="background-color: #cbcbcc">8464</td><td style="background-color: #cbcbcc">1185</td><td style="background-color: #cbcbcc">4.8</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">""IIIIIIII dont care about anyone else but me" ?"</td>
</tr>
<tr><td class="rankc" align="left">73</td>
<td style="background-color: #cbcbcc"><?php id(1135); ?></td><td style="background-color: #cbcbcc">201</td><td style="background-color: #cbcbcc">7864</td><td style="background-color: #cbcbcc">1101</td><td style="background-color: #cbcbcc">5.5</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"what if the triceraptors weren't gay? :P"</td>
</tr>
<tr><td class="rankc" align="left">74</td>
<td style="background-color: #cbcbcc"><?php id(2162); ?></td><td style="background-color: #cbcbcc">204</td><td style="background-color: #cbcbcc">7571</td><td style="background-color: #cbcbcc">1060</td><td style="background-color: #cbcbcc">5.2</td><td style="background-color: #cbcbcc">Today</td><td style="background-color: #cbcbcc">"Looks like I have competition for the next ClownArse of the week"</td>
</tr>
<tr><td class="rankc" align="left">75</td>
<td style="background-color: #cccccc"><?php id(1656); ?></td><td style="background-color: #cccccc">202</td><td style="background-color: #cccccc">7321</td><td style="background-color: #cccccc">1025</td><td style="background-color: #cccccc">5.1</td><td style="background-color: #cccccc">2 days ago</td><td style="background-color: #cccccc">"very imaginative skor, now by it off me :)"</td>
</tr>
</table><br />
<br /><b><i>These didn't make it to the top:</i></b><table><tr>
<td class="rankc10"><?php id(816); ?> (970)</td>
<td class="rankc10"><?php id(264); ?> (968)</td>
<td class="rankc10"><?php id(152); ?> (911)</td>
<td class="rankc10"><?php id(182); ?> (857)</td>
<td class="rankc10"><?php id(22); ?> (819)</td>
</tr><tr>
<td class="rankc10"><?php id(77); ?> (766)</td>
<td class="rankc10"><?php id(11); ?> (674)</td>
<td class="rankc10"><?php id(1912); ?> (639)</td>
<td class="rankc10"><?php id(1917); ?> (571)</td>
<td class="rankc10"><?php id(2006); ?> (568)</td>
</tr><tr>
<td class="rankc10"><?php id(1064); ?> (565)</td>
<td class="rankc10"><?php id(1772); ?> (555)</td>
<td class="rankc10"><?php id(47); ?> (552)</td>
<td class="rankc10"><?php id(1909); ?> (534)</td>
<td class="rankc10">`Mark`` (511)</td>
</tr><tr>
<td class="rankc10"><?php id(244); ?> (505)</td>
<td class="rankc10"><?php id(1636); ?> (501)</td>
<td class="rankc10"><?php id(175); ?> (493)</td>
<td class="rankc10"><?php id(2029); ?> (427)</td>
<td class="rankc10">Tsukuyomi (398)</td>
</tr><tr>
<td class="rankc10"><?php id(356); ?> (397)</td>
<td class="rankc10"><?php id(2114); ?> (386)</td>
<td class="rankc10"><?php id(1242); ?> (385)</td>
<td class="rankc10"><?php id(1999); ?> (340)</td>
<td class="rankc10">Lechuza (323)</td>
</tr><tr>
<td class="rankc10"><?php id(295); ?> (306)</td>
<td class="rankc10"><?php id(1562); ?> (302)</td>
<td class="rankc10"><?php id(91); ?> (298)</td>
<td class="rankc10">Mama-Kin (297)</td>
<td class="rankc10">Ramos (EH) (294)</td>
</tr><tr>
<td class="rankc10">Omega_Man (288)</td>
<td class="rankc10">Mama_Kin (287)</td>
<td class="rankc10"><?php id(1165); ?> (273)</td>
<td class="rankc10"><?php id(1583); ?> (268)</td>
<td class="rankc10"><?php id(258); ?> (265)</td>
</tr><tr>
<td class="rankc10"><?php id(2082); ?> (251)</td>
<td class="rankc10"><?php id(1561); ?> (245)</td>
<td class="rankc10"><?php id(64); ?> (243)</td>
<td class="rankc10"><?php id(488); ?> (210)</td>
<td class="rankc10">DJKJaguar (197)</td>
</tr></table>
<br /><b>By the way, there were 268 other nicks.</b><br />
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

<tr><td class="hicell">Is <b><?php id(1861); ?></b> stupid or just asking too many questions?  23.5% lines contained a question!
<br /><span class="small"><b><?php id(2162); ?></b> didn't know that much either.  20.0% of his/her lines were questions.</span>
</td></tr>
<tr><td class="hicell">The loudest one was <b><?php id(1829); ?></b>, who yelled 31.1% of the time!
<br /><span class="small">Another <i>old yeller</i> was <b><?php id(135); ?></b>, who shouted 24.2% of the time!</span>
</td></tr>
<tr><td class="hicell">It seem that <b><?php id(1036); ?></b>'s shift-key is hanging:  9.3% of the time he/she wrote UPPERCASE.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[00:06] &lt;Lavar&gt; MIB2
</span><br />
<br /><span class="small"><b><?php id(767); ?></b> just forgot to deactivate his/her Caps-Lock.  He/She wrote UPPERCASE 8.6% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1843); ?></b> is a very aggressive person.  He/She attacked others <b>263</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[02:36] * Shayde slaps |-0-| around a bit with a large trout
</span><br />
<br /><span class="small"><b><?php id(1281); ?></b> can't control his/her aggressions, either.  He/She picked on others <b>49</b> times.</span>
</td></tr>
<tr><td class="hicell">Poor <b><?php id(229); ?></b>, nobody likes him/her.  He/She was attacked <b>136</b> times.<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[02:36] * Shayde slaps |-0-| around a bit with a large trout
</span><br />
<br /><span class="small"><b><?php id(1699); ?></b> seems to be unliked too.  He/She got beaten <b>103</b> times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(135); ?></b> brings happiness to the world.  56.7% lines contained smiling faces.  :)
<br /><span class="small"><b><?php id(14); ?></b> isn't a sad person either, smiling 50.7% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1803); ?></b> seems to be sad at the moment:  3.4% lines contained sad faces.  :(
<br /><span class="small"><b><?php id(25); ?></b> is also a sad person, crying 2.4% of the time.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(144); ?></b> wrote the longest lines, averaging 56.9 letters per line.<br />
<span class="small">#bhg average was 29.3 letters per line.</span></td></tr>
<tr><td class="hicell"><b><?php id(1247); ?></b> wrote the shortest lines, averaging 14.8 characters per line.<br />
<span class="small"><b>`Mark``</b> was tight-lipped, too, averaging 15.1 characters.</span></td></tr>
<tr><td class="hicell"><b><?php id(168); ?></b> spoke a total of 101556 words!
<br /><span class="small"><?php id(168); ?>'s faithful follower, <b><?php id(370); ?></b>, didn't speak so much: 46351 words.</span>
</td></tr>
<tr><td class="hicell"><b>More</b> wrote an average of 24.00 words per line.
<br /><span class="small">Channel average was 5.78 words per line.</span>
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
<td class="hicell">2152</td>
<td class="hicell">Marenta</td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell">think</td>
<td class="hicell">1689</td>
<td class="hicell"><?php id(168); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell">there</td>
<td class="hicell">1644</td>
<td class="hicell"><?php id(1771); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell">people</td>
<td class="hicell">1208</td>
<td class="hicell"><?php id(168); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell">would</td>
<td class="hicell">1181</td>
<td class="hicell"><?php id(1332); ?></td>
</tr>
<tr><td class="rankc">6</td>
<td class="hicell">right</td>
<td class="hicell">1155</td>
<td class="hicell"><?php id(168); ?></td>
</tr>
<tr><td class="rankc">7</td>
<td class="hicell">going</td>
<td class="hicell">1139</td>
<td class="hicell"><?php id(168); ?></td>
</tr>
<tr><td class="rankc">8</td>
<td class="hicell">really</td>
<td class="hicell">1100</td>
<td class="hicell"><?php id(168); ?></td>
</tr>
<tr><td class="rankc">9</td>
<td class="hicell">around</td>
<td class="hicell">1047</td>
<td class="hicell"><?php id(168); ?></td>
</tr>
<tr><td class="rankc">10</td>
<td class="hicell">something</td>
<td class="hicell">1035</td>
<td class="hicell"><?php id(168); ?></td>
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
<td class="hicell">1965</td>
<td class="hicell"><?php id(94); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><?php id(141); ?></td>
<td class="hicell">1513</td>
<td class="hicell"><?php id(168); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><?php id(370); ?></td>
<td class="hicell">1163</td>
<td class="hicell"><?php id(370); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><?php id(57); ?></td>
<td class="hicell">1100</td>
<td class="hicell"><?php id(2006); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><?php id(767); ?></td>
<td class="hicell">1025</td>
<td class="hicell"><?php id(1762); ?></td>
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
<td class="hicell"><a href="http://www.ehnet.org/sabacc/">http://www.ehnet.org/sabacc/</a></td>
<td class="hicell">22</td>
<td class="hicell"><?php id(370); ?></td>
</tr>
<tr><td class="rankc">2</td>
<td class="hicell"><a href="http://www...">http://www...</a></td>
<td class="hicell">14</td>
<td class="hicell"><?php id(747); ?></td>
</tr>
<tr><td class="rankc">3</td>
<td class="hicell"><a href="http://ircstats.thebhg.org/">http://ircstats.thebhg.org/</a></td>
<td class="hicell">12</td>
<td class="hicell"><?php id(229); ?></td>
</tr>
<tr><td class="rankc">4</td>
<td class="hicell"><a href="http://underlord.thebhg.org">http://underlord.thebhg.org</a></td>
<td class="hicell">11</td>
<td class="hicell"><?php id(1135); ?></td>
</tr>
<tr><td class="rankc">5</td>
<td class="hicell"><a href="http://www.pneumonoultramicroscopicsilicovolcanoconiosis.com/">http://www.pneumonoultramicroscopicsilicovolcanoconiosis.com</a></td>
<td class="hicell">10</td>
<td class="hicell"><?php id(160); ?></td>
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

<tr><td class="hicell"><b><?php id(168); ?></b> wasn't very popular, getting kicked 35 times!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[18:58] *** CheezCake was kicked by Orin_Will (Never...)
</span><br />
<br /><span class="small"><b><?php id(1551); ?></b> seemed to be hated too:  30 kicks were received.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(118); ?></b> is either insane or just a fair op, kicking a total of 180 people!
<br /><span class="small"><?php id(118); ?>'s faithful follower, <b><?php id(168); ?></b>, kicked about 129 people.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(118); ?></b> donated 50 ops in the channel...
<br /><span class="small"><b>Moscow.RU.EU.Undernet.ORG</b> was also very polite: 44 ops from him/her.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(168); ?></b> is the channel sheriff with 20 deops.
<br /><span class="small"><b><?php id(118); ?></b> deoped 16 users.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(168); ?></b> always lets us know what he/she's doing: 1509 actions!<br /><span class="small"><b>For example, like this:</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[14:33] * CheezCake is back from: Showering
</span><br />
<br /><span class="small">Also, <b><?php id(370); ?></b> tells us what's up with 1311 actions.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(370); ?></b> is talking to him/herself a lot.  He/She wrote over 5 lines in a row 67 times!
<br /><span class="small">Another lonely one was <b><?php id(1551); ?></b>, who managed to hit 54 times.</span>
</td></tr>
<tr><td class="hicell"><b><?php id(1829); ?></b> couldn't decide whether to stay or go.  208 joins during this reporting period!</td></tr>
<tr><td class="hicell"><b>dasb77t</b> has quite a potty mouth.  2.8% words were foul language.
<br /><span class="small"><b><?php id(144); ?></b> also makes sailors blush, 1.6% of the time.</span>
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

<tr><td class="hicell">A topic was never set on this channel.</td></tr>
</table>
Total number of lines: 149771.<br /><br />
<span class="small">
Stats generated by <a href="http://pisg.sourceforge.net/" title="Go to the pisg homepage" class="background">pisg</a> v0.39<br />
pisg by <a href="http://wtf.dk/hp/" title="Go to the authors homepage" class="background">Morten Brix Pedersen</a> and others<br />
Stats generated in 00 hours 04 minutes and 45 seconds
</span>
</div>
</body>
</html>

<?php
  $path_to_base = "";
  if (isset($_REQUEST['login'])) { include('functions/auth.php'); }
  include('functions/status.php');
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link rel="stylesheet" type="text/css" href="style.css" />
  <title>Kabal Authority Cup</title>
  <base target="kac_frame" />
</head>

<body style="background-color: rgb(112,128,144);">

<table style="background-color: rgb(119,136,153);" align="center" cellspacing="0" cellpadding="0">
<tr><td style="text-align: center;" colspan="2">
<p class="alt" style="font-size: xx-large; margin-top: 10px; margin-bottom: 0px;">The Kabal Authority Cup</p>
<p class="alt" style="margin-bottom: 10px;">Another Ehart Dak`Wind Enterprise&trade; for your enjoyment.</p>
</td></tr>
<tr>
<td style="width: 160px; height: 480px; vertical-align: top;"><ul class="nav">
<li class="nav" style="left: -16px; font-size: small;"><b><a class="alt" href="" target="_self">Home</a></b></li>
<?php
  if (isset($auth_level)) {
    if ($auth_level == 3) {
      echo "<li class=\"nav\">Welcome, Admin</li>\n";
      echo "<ul class=\"nav\">\n";
      if (cup_running()) { echo "<li class=\"nav\"><a class=\"alt\" href=\"grade/\">Grade events</a></li>\n"; }
      if (cup_pending() || cup_running()) {
        echo "<li class=\"nav\"><a class=\"alt\" href=\"admin/?modify=1\">Modify KAC</a></li>\n";
      } else {
        echo "<li class=\"nav\"><a class=\"alt\" href=\"admin/?new=1\">New KA Cup</a></li>\n";
      }
      echo "<li class=\"nav\"><a class=\"alt\" href=\"award/\">Awards</a></li>\n";
    } elseif ($auth_level == 2) {
      echo "<li class=\"nav\">Welcome, CH/CRA</li>\n";
      echo "<ul class=\"nav\">\n";
      if (cup_running()) { echo "<li class=\"nav\">Information</li>\n"; }
    } elseif ($auth_level == 1) {
      echo "<li class=\"nav\">Welcome, Hunter</li>\n";
      echo "<ul class=\"nav\">\n";
    }
    if ($auth_level < 3) {
      if (cup_running() && events_pending($id)) { echo "<li class=\"nav\"><a class=\"alt\" href=\"go/\">Do Events</a></li>\n"; }
    }
    echo "</ul>\n";
  } else {
    echo "<li class=\"nav\"><a class=\"alt\" href=\"?login=1\" target=\"_self\">Login</a></li>\n";
  }
?>
<li class="nav">Archive</li>
<ul class="nav">
<?php if(cup_running()) { echo "<li class=\"nav\"><a class=\"alt\" href=\"ladder/\">Curr. Results</a></li>"; } ?>
<li class="nav">By Cup</li>
<li class="nav">By Kabal</li>
<li class="nav">By Event</li>
<li class="nav">By Hunter</li>
</ul>
</ul></td>
<td style="background-color: rgb(47,79,79); width: 640px; height: 480px;"><iframe name="kac_frame" src="news/" style="width: 640px; height: 480px;"></iframe></td>
</tr>
</table>

<p class="alt" style="text-align: center;">
Code and layout by <a class="alt" href="mailto:nightweaver@thebhg.org">Nightweaver</a>.<br>
This site is part of the <a class="alt" href="http://www.emperorshammer.org/" target="_blank">Emperor's Hammer</a>, and is subject to their <a class="alt" href="http://www.emperorshammer.org/privacy.htm" target="_blank">privacy policies</a>, <a class="alt" href="http://www.emperorshammer.org/disclaim.htm" target="_blank">copyright disclaimers</a> and other guidelines.
</p>

</body>

</html>

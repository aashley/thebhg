<?php

$pagename = "Planets";

include("../header.php");
include("../functions/db.php");

if (isset($_REQUEST['id'])) {

  $planet = mysql_query("SELECT * FROM planets WHERE id=".$_REQUEST['id']);
  $planet_info = mysql_fetch_array($planet, MYSQL_ASSOC);

  unset($output);

  $layout = file("layout.php");
  for ($i = 0; $i < sizeof($layout); $i++) {
    $image = "<img class=\"icon\" src=\"".$planet_info['pic']."\" alt=\"".$planet_info['name']."\" />";
    
    $orb = orbits($_REQUEST['id']);
    $id = $orb['id'];
    $planet = $orb['name'];
	
    $layout[$i] = str_replace("%ORBIT%", (isMoon($_REQUEST['id']) ? '<tr><td class="contrast"><p><b>Orbits the Planet:</b></p></td><td class="contrast"><p>' . "<a class='alt' href='?id=$id'>$planet</a>" . '</p></td></tr>' : ''), $layout[$i]);
    $layout[$i] = str_replace("%IMG%", $image, $layout[$i]);
    $layout[$i] = str_replace("%NAME%", $planet_info['name'], $layout[$i]);
    $layout[$i] = str_replace("%TYPE%", $planet_info['type'], $layout[$i]);
    $layout[$i] = str_replace("%TEMP%", $planet_info['temp'], $layout[$i]);
    $layout[$i] = str_replace("%ATM%", $planet_info['atmo'], $layout[$i]);
    $layout[$i] = str_replace("%HYDRO%", $planet_info['hydro'], $layout[$i]);
    $layout[$i] = str_replace("%GRAV%", $planet_info['gravity'], $layout[$i]);
    $layout[$i] = str_replace("%TERRAIN%", $planet_info['terrain'], $layout[$i]);
    $layout[$i] = str_replace("%DAY%", (is_numeric($planet_info['day']) ? trim($planet_info['day']).' Standard Hours' : trim($planet_info['day'])), $layout[$i]);
    $layout[$i] = str_replace("%YEAR%", (is_numeric($planet_info['year']) ? trim($planet_info['year']).' Standard Days' : trim($planet_info['year'])), $layout[$i]);
    $layout[$i] = str_replace("%SPECIES%", $planet_info['species'], $layout[$i]);
    $layout[$i] = str_replace("%STARPORT%", $planet_info['starport'], $layout[$i]);
    $layout[$i] = str_replace("%POP%", $planet_info['pop'], $layout[$i]);
    $layout[$i] = str_replace("%TECH%", $planet_info['tech'], $layout[$i]);
    $layout[$i] = str_replace("%IMP%", $planet_info['imp'], $layout[$i]);
    $layout[$i] = str_replace("%EXP%", $planet_info['exp'], $layout[$i]);
    $layout[$i] = str_replace("%DESC%", nl2br($planet_info['misc']), $layout[$i]);
    unset($struct);
    $complexes = mysql_query("SELECT id, name FROM complex WHERE planet=".$_REQUEST['id']);
    while ($complex_info = mysql_fetch_array($complexes, MYSQL_ASSOC)) {
      $struct .= "<li><a class=\"alt\" href=\"../buildings/?type=complex&amp;id=".$complex_info['id']."\">".$complex_info['name']."</a></li>\n";
    }
    $estates = mysql_query("SELECT id, name FROM estate WHERE planet=".$_REQUEST['id']);
    while ($estate_info = mysql_fetch_array($estates, MYSQL_ASSOC)) {
      $struct .= "<li><a class=\"alt\" href=\"../buildings/?type=estate&amp;id=".$estate_info['id']."\">".$estate_info['name']."</a></li>\n";
    }
    $hqs = mysql_query("SELECT id, name FROM hq WHERE planet=".$_REQUEST['id']);
    while ($hq_info = mysql_fetch_array($hqs, MYSQL_ASSOC)) {
      $struct .= "<li><a class=\"alt\" href=\"../buildings/?type=hq&amp;id=".$hq_info['id']."\">".$hq_info['name']."</a></li>\n";
    }
    $personals = mysql_query("SELECT id, name FROM personal WHERE planet=".$_REQUEST['id']);
    while ($personal_info = mysql_fetch_array($personals, MYSQL_ASSOC)) {
      $struct .= "<li><a class=\"alt\" href=\"../buildings/?type=personal&amp;id=".$personal_info['id']."\">".$personal_info['name']."</a></li>\n";
    }
    $others = mysql_query("SELECT id, name FROM other WHERE planet=".$_REQUEST['id']);
    while ($other_info = mysql_fetch_array($others, MYSQL_ASSOC)) {
      $struct .= "<li><a class=\"alt\" href=\"../buildings/?type=other&amp;id=".$other_info['id']."\">".$other_info['name']."</a></li>\n";
    }
    
    $moon = '<tr><td class="contrast" colspan=2><b>Structures</b><ul>';
    
	$moon .= $struct . '</ul>';
    
	if (sizeof(getMoons($_REQUEST['id']))){
		$moon .= '<b>Satellites</b><ul>';
		foreach (getMoons($_REQUEST['id']) as $id => $name){
			$moon .= "<li><a class='alt' href='?id=$id'>$name</a></li>";
		}
		$moon .= '</ul>';
	}
	
	$moon .= '</td></tr>';
    
    
    $layout[$i] = str_replace("%SAT%", $moon, $layout[$i]);
    $output .= $layout[$i];
  }
  echo "<table align=\"center\">\n";
  echo $output;
  echo "</table>\n";

} else {

  echo "<table align=\"center\">\n";
  echo "<tr><th colspan=\"2\"><img src=\"http://specialist.thebhg.org/images/lyarna/lyarna.jpeg\" alt=\"The Lyarna System\" /></th></tr>\n";
  echo "<tr><td class=\"contrast\"><p><b>Star:</b></p></td><td class=\"contrast\"><p>Zahnis</p></td></tr>\n";
  echo "<tr><td class=\"contrast\"><p><b>Government:</b></p></td><td class=\"contrast\"><p><a class=\"alt\" href=\"http://www.thebhg.org/\" target=\"_blank\">The Bounty Hunters Guild</a></p></td></tr>\n";
  echo "<tr><td class=\"contrast\"><p><b>Governing Body:</b></p></td><td class=\"contrast\"><p>BHG Commission</p></td></tr>\n";
  echo "<tr><td class=\"contrast\"><p><b>Total Population:</b></p></td><td class=\"contrast\"><p>Approx. 628,628,600</p></td></tr>\n";
  echo "<tr>\n";
  echo "<td class=\"contrast\"><p><b>Planets:</b></p></td>\n";
  echo "<td class=\"contrast\"><ul>\n";
  foreach (getPlanets(1) as $id => $planet){
	  echo "<li><a class='alt' href='?id=$id'>$planet</a></li>";
	  	echo '<ul>';
	  foreach (getMoons($id) as $id => $moon){
		  echo "<li><a class='alt' href='?id=$id'>$moon</a></li>";
	  }
	  	echo '</ul>';
  }
  echo "</ul></td>\n";
  echo "</tr>\n";
  echo "</table>\n";

}

//echo "<p><a href=\"admin.php\">Admin</a></p>\n\n";

include("../footer.php");

?>

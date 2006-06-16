<?php

include("../functions/db.php");

if (isset($_REQUEST['type'])) {

  if ($_REQUEST['type'] == "complex") {
    $pagename = "BHG Locations";
  } elseif ($_REQUEST['type'] == "hq") {
    $pagename = "Kabal Complexes";
  } elseif ($_REQUEST['type'] == "estate") {
    $pagename = "Hunter Estates";
  } elseif ($_REQUEST['type'] == "personal") {
    $pagename = "Personal Sites";
  } elseif ($_REQUEST['type'] == "other") {
    $pagename = "Other Locations";
  }

  include("../header.php");

  if (isset($_REQUEST['id'])) {

    $building = mysql_query("SELECT * FROM ".$_REQUEST['type']." WHERE id=".$_REQUEST['id']);
    $building_info = mysql_fetch_array($building, MYSQL_ASSOC);

    $planet = mysql_query("SELECT id, name FROM planets WHERE id=".$building_info['planet']);
      $planet_info = mysql_fetch_array($planet, MYSQL_ASSOC);
    
    unset($output);

    $layout = file("layout.php");
    for ($i = 0; $i < sizeof($layout); $i++) {
      if (($building_info['pic'] == "") || ($building_info['pic'] == "notyet.php")) {
        $image = "";
      } else {
        if (substr($building_info['pic'], 0, 7) == "http://") {
          $pic = $building_info['pic'];
        } else {
          $pic = "images/".$building_info['pic'];
        }
        $image = "<img class=\"icon\" src=\"$pic\" alt=\"".$building_info['name']."\" />";
      }
      
       
      
 		include_once 'roster.inc';
     
 		$roster = new roster();
 		
      if ($building_info['bhg_id']){
	      $owner = '<a href="property.php?id='.$building_info['bhg_id'].'">'.$roster->getPerson($building_info['bhg_id'])->getName().'</a>';
      } elseif ($building_info['position'] && $building_info['division']){
	      $owner = 'The ' . $roster->getPosition($building_info['position'])->getName(). ' of ' . 
	      					$roster->getDivision($building_info['division'])->getName(). '.';
      } else {
	      $owner = 'Unknown';
      }
      
      $layout[$i] = str_replace("%IMG%", $image, $layout[$i]);
      $layout[$i] = str_replace("%OWN%", $owner, $layout[$i]);
      $layout[$i] = str_replace("%NAME%", $building_info['name'], $layout[$i]);
     
      $location = "<a class=\"alt\" href=\"../planets/?id=".$planet_info['id']."\">".$planet_info['name']."</a>: ".$building_info['location'];
      $layout[$i] = str_replace("%LOCATION%", $location, $layout[$i]);
      $layout[$i] = str_replace("%OWNER%", $building_info['owner'], $layout[$i]);
      $layout[$i] = str_replace("%TYPE%", $building_info['type'], $layout[$i]);
      $arena = ($building_info['arena'] == 1) ? "can" : "can't";
      $layout[$i] = str_replace("%ARENA%", $arena, $layout[$i]);
      $layout[$i] = str_replace("%DESC%", nl2br($building_info['misc']), $layout[$i]);
      $output .= $layout[$i];
    }

    echo "<table align=\"center\">\n";
    echo $output;
    echo "</table>\n";

  } else {

    echo "<table align=\"center\">\n";
    echo "<tr><td class=\"contrast\"><table>\n";
    echo "<tr><td></td><td><p><b>Legend:</b></p></td></tr>\n";
    echo "<tr>\n<td><img class=\"arena\" src=\"images/arena.png\" alt=\"Arena OK\" /></td>\n";
    echo "<td><p>You can have arena battles in this location.</p></td>\n</tr>\n";
    echo "<tr>\n<td><img class=\"arena\" src=\"images/no-arena.png\" alt=\"Arena OK\" /></td>\n";
    echo "<td><p>You can't have arena battles in this location.</p></td>\n</tr>\n";
    echo "</table></td></tr>\n";
    echo "<tr><td class=\"contrast\"><table>\n";
    $buildings_a = mysql_query("SELECT id, name, owner, planet, arena FROM ".$_REQUEST['type']." ORDER BY name");
    while ($building_info = mysql_fetch_array($buildings_a, MYSQL_ASSOC)) {
      $planet = mysql_query("SELECT name FROM planets WHERE id=".$building_info['planet']);
      $planet_info = mysql_fetch_array($planet, MYSQL_ASSOC);
      echo "<tr>\n<td>";
      echo "<p>\n";
      echo "<a class=\"alt\" href=\"?type=".$_REQUEST['type']."&amp;id=".$building_info['id']."\">".$building_info['name']."</a> ";
      echo "(<a class=\"alt\" href=\"../planets/?id=".$building_info['planet']."\">".$planet_info['name']."</a>)<br />\n";
      echo "Owned by ".trim($building_info['owner']).".\n";
      echo "</p>\n";
      echo "</td>\n<td class=\"right\">";
      echo "<img class=\"arena\" src=\"images/";
      if ($building_info['arena'] != 1) { echo "no-"; }
      echo "arena.png\" alt=\"Arena OK\" />";
      echo "</td>\n</tr>\n";
    }
    echo "</table></td></tr>\n";
    echo "</table>\n";
      
  }

}

// echo "<p><a href=\"admin.php\">Admin</a></p>\n\n";

include("../footer.php");

?>

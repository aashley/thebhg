<?php

$pagename = "Property Tracker";

include("../functions/db.php");

$types = array('complex', 'estate', 'hq', 'other', 'personal');

  include("../header.php");

    echo "<table align=\"center\">\n";
    echo "<tr><td class=\"contrast\"><table>\n";
    echo "<tr><td></td><td><p><b>Legend:</b></p></td></tr>\n";
    echo "<tr>\n<td><img class=\"arena\" src=\"images/arena.png\" alt=\"Arena OK\" /></td>\n";
    echo "<td><p>You can have arena battles in this location.</p></td>\n</tr>\n";
    echo "<tr>\n<td><img class=\"arena\" src=\"images/no-arena.png\" alt=\"Arena OK\" /></td>\n";
    echo "<td><p>You can't have arena battles in this location.</p></td>\n</tr>\n";
    echo "</table></td></tr>\n";
    echo "<tr><td class=\"contrast\"><table>\n";
    
    if ($_REQUEST['id']){
	    $where = "`bhg_id` = '".$_REQUEST['id']."'";
    } elseif ($_REQUEST['position'] && $_REQUEST['division']){
	    $where = "`position` = '".$_REQUEST['position']."' AND `division` = '".$_REQUEST['division']."'";
    } else {
	    echo "<tr>\n<td>No records found</td></tr></table></td></tr>\n</table>\n";
	    exit;
    }
    
    foreach ($types as $table){
	    $buildings_a = mysql_query("SELECT id, name, owner, planet, arena FROM ".$table." WHERE ".$where." ORDER BY name");
	    while ($building_info = mysql_fetch_array($buildings_a, MYSQL_ASSOC)) {
	      $planet = mysql_query("SELECT name FROM planets WHERE id=".$building_info['planet']);
	      $planet_info = mysql_fetch_array($planet, MYSQL_ASSOC);
	      echo "<tr>\n<td>";
	      echo "<p>\n";
	      echo "<a class=\"alt\" href=\"?type=".$_REQUEST['type']."&amp;id=".$building_info['id']."\">".$building_info['name']."</a> ";
	      echo "(<a class=\"alt\" href=\"../planets/?id=".$building_info['planet']."\">".$planet_info['name']."</a>)<br />\n";
	     // echo "Owned by ".trim($building_info['owner']).".\n";
	      echo "</p>\n";
	      echo "</td>\n<td class=\"right\">";
	      echo "<img class=\"arena\" src=\"images/";
	      if ($building_info['arena'] != 1) { echo "no-"; }
	      echo "arena.png\" alt=\"Arena OK\" />";
	      echo "</td>\n</tr>\n";
	    }
    }
    echo "</table></td></tr>\n";
    echo "</table>\n";

// echo "<p><a href=\"admin.php\">Admin</a></p>\n\n";

include("../footer.php");

?>

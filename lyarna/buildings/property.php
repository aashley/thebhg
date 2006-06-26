<?php

include_once 'roster.inc';

$roster = new roster();

if ($_REQUEST['id']){
    $where = "`bhg_id` = '".$_REQUEST['id']."'";
    $person = $roster->getPerson($_REQUEST['id']);
    $name = $person->getName();
    $where .= (isset($_REQUEST['count']) ? '' : " OR (`position` = '".$person->getPosition()->getID()."' AND `division` = '".$person->getDivision()->getID()."')");
    if ($person->getDivision()->isKabal() && $person->getPosition()->getID() != 11)
    	$divka = "`division` = '".$person->getDivision()->getID()."'";
    	
} elseif ($_REQUEST['position'] && $_REQUEST['division']){
    $where = "(`position` = '".$_REQUEST['position']."' AND `division` = '".$_REQUEST['division']."')";
    $name = "The ".$roster->getPosition($_REQUEST['position'])->getName()." of ".$roster->getDivision($_REQUEST['division'])->getName();
    foreach ($roster->searchPosition($_REQUEST['position']) as $person){
	    if ($person->getDivision()->getID() == $_REQUEST['division'])
		    $where .= " OR `bhg_id` = '".$person->getID()."'";
	}
} else {
    exit;
}

$pagename = "Property Tracker :: ".$name;

include("../functions/db.php");

$types = array('complex', 'estate', 'hq', 'other', 'personal');

  include("../header.php");
if ($_REQUEST['count']){
	$sql = "SELECT id, name, owner, planet, arena, bhg_id, position, division FROM `estate` WHERE ".$where." ORDER BY name";
	$query = mysql_query($sql, $GLOBALS['db']);
	echo mysql_num_rows($query);
	exit;
}
    echo "<table align=\"center\">\n";
    echo "<tr><td class=\"contrast\"><table>\n";
    echo "<tr><td></td><td><p><b>Legend:</b></p></td></tr>\n";
    echo "<tr>\n<td><img class=\"arena\" src=\"images/arena.png\" alt=\"Arena OK\" /></td>\n";
    echo "<td><p>You can have arena battles in this location.</p></td>\n</tr>\n";
    echo "<tr>\n<td><img class=\"arena\" src=\"images/no-arena.png\" alt=\"Arena OK\" /></td>\n";
    echo "<td><p>You can't have arena battles in this location.</p></td>\n</tr>\n";
    echo "</table></td></tr>\n";
    echo "<tr><td class=\"contrast\"><table>\n";
    
    foreach ($types as $table){
	    $sql = "SELECT id, name, owner, planet, arena, bhg_id, position, division FROM ".$table." WHERE ".$where." ORDER BY name";
	    $buildings_a = mysql_query($sql, $GLOBALS['db']);
	    while ($building_info = mysql_fetch_array($buildings_a, MYSQL_ASSOC)) {
	      $planet = mysql_query("SELECT name FROM planets WHERE id=".$building_info['planet'], $GLOBALS['db']);
	      $planet_info = mysql_fetch_array($planet, MYSQL_ASSOC);
	      echo "<tr>\n<td>";
	      echo "<p>\n";
	      echo "<a class=\"alt\" href=\"/buildings/?type=".$table."&amp;id=".$building_info['id']."\">".$building_info['name']."</a> ";
	      echo "(<a class=\"alt\" href=\"../planets/?id=".$building_info['planet']."\">".$planet_info['name']."</a>)<br />\n";
	      
	      $owner = false;
	      
	      if ($building_info['bhg_id']){
		      $owner = $roster->getPerson($building_info['bhg_id'])->getName();
	      } elseif ($building_info['position'] && $building_info['division']){
		      $owner = 'The '.$roster->getPosition($building_info['position'])->getName(). 
		      			' of ' . $roster->getDivision($building_info['division'])->getName();
	      }
	      
	      echo "Owned by ".($owner ? $owner : trim($building_info['owner'])).".\n";
	      echo "</p>\n";
	      echo "</td>\n<td class=\"right\">";
	      echo "<img class=\"arena\" src=\"images/";
	      if ($building_info['arena'] != 1) { echo "no-"; }
	      echo "arena.png\" alt=\"Arena OK\" />";
	      echo "</td>\n</tr>\n";
	    }
    }
    
    if ($divka){
	    echo '<tr><td><hr noshade />';
	    echo '<h3>Properties Owned By Kabal</h3></td></tr>';
	    foreach ($types as $table){
		    $sql = "SELECT id, name, owner, planet, arena, position, division FROM ".$table." WHERE ".$divka." ORDER BY name";
		    $buildings_b = mysql_query($sql, $GLOBALS['db']);
		    while ($building_info = mysql_fetch_array($buildings_b, MYSQL_ASSOC)) {
		      $planet = mysql_query("SELECT name FROM planets WHERE id=".$building_info['planet'], $GLOBALS['db']);
		      $planet_info = mysql_fetch_array($planet, MYSQL_ASSOC);
		      echo "<tr>\n<td>";
		      echo "<p>\n";
		      echo "<a class=\"alt\" href=\"/buildings/?type=".$table."&amp;id=".$building_info['id']."\">".$building_info['name']."</a> ";
		      echo "(<a class=\"alt\" href=\"../planets/?id=".$building_info['planet']."\">".$planet_info['name']."</a>)<br />\n";
		      
		      $owner = false;
		      
		      if ($building_info['division']){
			      $owner = 'The '.$roster->getPosition($building_info['position'])->getName(). 
			      			' of ' . $roster->getDivision($building_info['division'])->getName();
		      }
		      
		      echo "Owned by ".($owner ? $owner : trim($building_info['owner'])).".\n";
		      echo "</p>\n";
		      echo "</td>\n<td class=\"right\">";
		      echo "<img class=\"arena\" src=\"images/";
		      if ($building_info['arena'] != 1) { echo "no-"; }
		      echo "arena.png\" alt=\"Arena OK\" />";
		      echo "</td>\n</tr>\n";
		    }
	    }
    }
    echo "</table></td></tr>\n";
    echo "</table>\n";

// echo "<p><a href=\"admin.php\">Admin</a></p>\n\n";

include("../footer.php");

?>

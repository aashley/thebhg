<?php

  $pagename = "Buildings Admin";

  include("../functions/auth.php");
  
  if ($is_authorised) {

    include("../functions/db.php");
    include("../header.php");

    if (isset($_POST['add_building'])) { // Add a new building
      $bldg_type = $_POST['bldg_type'];
      $planet = $_POST['planet'];
      $name = $_POST['name'];
      $misc = nl2br($_POST['misc']);
      $pic = $_POST['pic'];
      $owner = $_POST['owner'];
      $location = $_POST['location'];
      $type = $_POST['type'];
      $arena = (isset($_POST['arena'])) ? $_POST['arena'] : 0;
      $add_query = "INSERT INTO $bldg_type VALUES (NULL, $planet, '$name', '$misc', '$pic', '$owner', '$location', '$type', $arena, 0, 0, 0)";
      if (mysql_query($add_query)) {
        echo "<p>The building was successfully created.</p>\n";
      } else {
        echo "<p>An error occured creating the building. Please <a href=\"http://bugs.thebhg.org/index.php?page=reportbug\" target=\"_blank\">report a bug</a>.</p>\n";
      }
    }

    if (isset($_POST['mod_building'])) { // Edit an existing building
      $id = $_POST['mod_building'];
      $old_type = $_POST['old_type'];
      $bldg_type = $_POST['bldg_type'];
      $planet = $_POST['planet'];
      $name = $_POST['name'];
      $misc = nl2br($_POST['misc']);
      $pic = $_POST['pic'];
      $owner = $_POST['owner'];
      $location = $_POST['location'];
      $type = $_POST['type'];
      $arena = (isset($_POST['arena'])) ? $_POST['arena'] : 0;
      if ($bldg_type == $old_type) {
        if (mysql_query("UPDATE $bldg_type SET planet=$planet, name='$name', misc='$misc', pic='$pic', owner='$owner', location='$location', type='$type', arena=$arena WHERE id=$id LIMIT 1")) {
          echo "<p>The building was successfully modified.</p>\n";
        } else {
          echo "<p>An error occured modifying the building. Please <a href=\"http://bugs.thebhg.org/index.php?page=reportbug\" target=\"_blank\">report a bug</a>.</p>\n";
        }
      } else {
        $add_query = "INSERT INTO $bldg_type VALUES (NULL, $planet, '$name', '$misc', '$pic', '$owner', '$location', '$type', $arena, 0, 0, 0)";
        $del_query = "DELETE FROM $old_type WHERE id=$id LIMIT 1";
        if (mysql_query($add_query) && mysql_query($del_query)) {
          echo "<p>The building was successfully modified.</p>\n";
        } else {
          echo "<p>An error occured modifying the building. Please <a href=\"http://bugs.thebhg.org/index.php?page=reportbug\" target=\"_blank\">report a bug</a>.</p>\n";
        }
      }
    }

    if (isset($_POST['del_building'])) { // Delete a building
      if (mysql_query("DELETE FROM ".$_POST['bldg_type']." WHERE id=".$_POST['del_building']." LIMIT 1")) {
        echo "<p>The building was successfully deleted.</p>\n";
      } else {
        echo "<p>An error occured deleting the building. Please <a href=\"http://bugs.thebhg.org/index.php?page=reportbug\" target=\"_blank\">report a bug</a>.</p>\n";
      }
    }

    if (isset($_REQUEST['delete'])) {
      $show_form = 0;
      $building = mysql_query("SELECT name FROM ".$_REQUEST['bldg_type']." WHERE id=".$_REQUEST['delete']);
      $building_info = mysql_fetch_array($building, MYSQL_ASSOC);
      echo "<p>Really delete the database entry for ".$building_info['name']."?</p>\n";
      echo "<table><tr>\n";
      echo "<td><form method=\"post\" action=\"$PHP_SELF\">\n";
      echo "<input type=\"hidden\" name=\"del_building\" value=\"".$_REQUEST['delete']."\" />\n";
      echo "<input type=\"hidden\" name=\"bldg_type\" value=\"".$_REQUEST['bldg_type']."\" />\n";
      echo "<input type=\"submit\" value=\"Yes\" />\n";
      echo "</form></td>\n";
      echo "<td><form method=\"post\" action=\"$PHP_SELF\">\n";
      echo "<input type=\"submit\" value=\"No\" />\n";
      echo "</form></td>\n";
      echo "</tr></table>\n";
    } elseif (isset($_REQUEST['edit'])) {
      $show_form = 1;
      $building = mysql_query("SELECT * FROM ".$_REQUEST['bldg_type']." WHERE id=".$_REQUEST['edit']);
      $building_info = mysql_fetch_array($building, MYSQL_ASSOC);
      $bldg_type = $_REQUEST['bldg_type'];
      $target = "mod_building";
      $value = $_REQUEST['edit'];
      echo "<p>Currently editing the database entry for ".$building_info['name'].".<br />\n";
      echo "<b>PRESS CANCEL IF YOU WISH TO ADD A NEW BUILDING INSTEAD!</b></p>\n";
      echo "<table><tr><td><form method=\"post\" action=\"$PHP_SELF\">\n";
      echo "<input type=\"submit\" value=\"Cancel\" />\n";
      echo "</form></td></tr></table>\n";
    } else {
      $show_form = 1;
      unset($building_info);
      unset($bldg_type);
      $target = "add_building";
      $value = 1;
      echo "<p>Creating a new building entry.</p>\n";
    }

    if ($show_form == 1) {
      echo "<form method=\"post\" action=\"$PHP_SELF\">\n";
      echo "<input type=\"hidden\" name=\"$target\" value=\"$value\" />\n";
      if (isset($bldg_type)) { echo "<input type=\"hidden\" name=\"old_type\" value=\"$bldg_type\" />\n"; }
      echo "<table>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Building type:</p></td>\n";
      echo "<td><select name=\"bldg_type\">\n";
      echo "<option value=\"complex\" ";
      echo (isset($bldg_type) && ($bldg_type == "complex")) ? "selected " : "";
      echo "/>BHG Location\n";
      echo "<option value=\"hq\" ";
      echo (isset($bldg_type) && ($bldg_type == "hq")) ? "selected " : "";
      echo "/>Kabal Complex\n";
      echo "<option value=\"estate\" ";
      echo (isset($bldg_type) && ($bldg_type == "estate")) ? "selected " : "";
      echo "/>Hunter Estate\n";
      echo "<option value=\"personal\" ";
      echo (isset($bldg_type) && ($bldg_type == "personal")) ? "selected " : "";
      echo "/>Personal Site\n";
      echo "<option value=\"other\" ";
      echo (isset($bldg_type) && ($bldg_type == "other")) ? "selected " : "";
      echo "/>Other Location\n";
      echo "</select></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Location (Planet):</p></td>\n";
      echo "<td><select name=\"planet\">\n";
      $planets = mysql_query("SELECT id, name FROM planets");
      while ($planet_info = mysql_fetch_array($planets, MYSQL_ASSOC)) {
        echo "<option value=\"".$planet_info['id']."\" ";
        echo (isset($building_info) && ($building_info['planet'] == $planet_info['id'])) ? "selected " : "";
        echo "/>".$planet_info['name']."\n";
      }
      echo "</select></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Name:</p></td>\n";
      echo "<td><input type=\"text\" name=\"name\" size=\"40\" ";
      echo (isset($building_info)) ? "value=\"".$building_info['name']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Description:</p></td>\n";
      echo "<td><textarea name=\"misc\" rows=\"10\" cols=\"40\">";
      echo (isset($building_info)) ? strip_tags($building_info['misc']) : "";
      echo "</textarea></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Image<a class=\"alt\" href=\"#notes\">*</a>:</p></td>\n";
      echo "<td><input type=\"text\" name=\"pic\" size=\"40\" ";
      echo (isset($building_info)) ? "value=\"".$building_info['pic']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Owner:</p></td>\n";
      echo "<td><input type=\"text\" name=\"owner\" size=\"40\" ";
      echo (isset($building_info)) ? "value=\"".$building_info['owner']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Location:</p></td>\n";
      echo "<td><input type=\"text\" name=\"location\" size=\"40\" ";
      echo (isset($building_info)) ? "value=\"".$building_info['location']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Structure Type:</p></td>\n";
      echo "<td><input type=\"text\" name=\"type\" size=\"40\" ";
      echo (isset($building_info)) ? "value=\"".$building_info['type']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Arena Battles here?</p></td>\n";
      echo "<td><input type=\"checkbox\" name=\"arena\" value=\"1\" size=\"20\" ";
      echo (isset($building_info) && ($building_info['arena'] == 1)) ? "checked " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr><td class=\"contrast\"><p>Submit:</p></td><td><input type=\"submit\" value=\"Go\" /><input type=\"reset\" value=\"Reset\" /></td></tr>\n";
      echo "<tr><td class=\"contrast\" style=\"vertical-align: top;\"><p><a name=\"notes\">Notes:</a></p></td>\n";
      echo "<td class=\"contrast\"><p>* Image URLS are relative to <i>http://lyarna.thebhg.org/buildings/images/</i> unless they start with <i>http://</i></p></td></tr>\n";
      echo "</table></form>\n";
    }

    // Building list
    unset($building_info);
    unset($bldg_type);
    array($bldg_type);
    $bldg_type[0]['db'] = "complex";
    $bldg_type[0]['desc'] = "BHG Location";
    $bldg_type[1]['db'] = "hq";
    $bldg_type[1]['desc'] = "Kabal Complex";
    $bldg_type[2]['db'] = "estate";
    $bldg_type[2]['desc'] = "Hunter Estate";
    $bldg_type[3]['db'] = "personal";
    $bldg_type[3]['desc'] = "Personal Site";
    $bldg_type[4]['db'] = "other";
    $bldg_type[4]['desc'] = "Other Location";
    echo "<table><tr>\n";
    echo "<th><p class=\"contrast\">Name</p></th>\n";
    echo "<th><p class=\"contrast\">Type</p></th>\n";
    echo "<th><p class=\"contrast\">Edit</p></th>\n";
    echo "<th><p class=\"contrast\">Delete</th>\n";
    echo "</tr>";
    for ($i = 0; $i < count($bldg_type); $i++) {
      $buildings = mysql_query("SELECT * FROM ".$bldg_type[$i]['db']." ORDER BY name ASC");
      while ($building_info = mysql_fetch_array($buildings, MYSQL_ASSOC)) {
        echo "<tr>\n";
        echo "<td class=\"contrast\"><p>".$building_info['name']."</p></td>\n";
        echo "<td class=\"contrast\"><p>".$bldg_type[$i]['desc']."</p></td>\n";
        echo "<td class=\"contrast\"><p><a class=\"alt\" href=\"".$PHP_SELF."?bldg_type=".$bldg_type[$i]['db']."&amp;edit=".$building_info['id']."\">Edit</a></p></td>\n";
        echo "<td class=\"contrast\"><p><a class=\"alt\" href=\"".$PHP_SELF."?bldg_type=".$bldg_type[$i]['db']."&amp;delete=".$building_info['id']."\">Delete</a></p></td>\n";
        echo "</tr>";
      }
    }
    echo "</table>\n";
    include("../footer.php");

    exit;

  }

?>

<?php

	$pagename = "Planets Admin";
	
	include("../functions/auth.php");
  
	 if ($is_authorised) {

	    include("../functions/db.php");
	    include("../header.php");

    	require_once "HTML/QuickForm.php";

    	if (isset($_REQUEST['submit'])){
	    	echo $_REQUEST['text'];
    	} else {
			$form = new HTML_QuickForm('planets', 'post');
			$form->addElement('header', 'Planets', 'Create New Planet');
			$form->addElement('text', 'name', 'Planet Name');
			$form->setDefaults(array(
			    'name' => 'Planet Name';
			));
			//$form->addElement('reset', 'btnClear', 'Clear');
			$form->addElement('submit', 'submit', 'Submit');
			$form->display();
		}

    exit;
    
    
    
    
    if (isset($_POST['mod_planet'])) { // Edit an existing planet
      $id = $_POST['mod_planet'];
      $name = addslashes($_POST['name']);
      $pic = $_POST['pic'];
      $type = addslashes($_POST['type']);
      $temp = addslashes($_POST['temp']);
      $atmo = addslashes($_POST['atmo']);
      $hydro = addslashes($_POST['hydro']);
      $gravity = addslashes($_POST['gravity']);
      $terrain = addslashes($_POST['terrain']);
      $day = addslashes($_POST['day']);
      $year = addslashes($_POST['year']);
      $species = addslashes($_POST['species']);
      $starport = addslashes($_POST['starport']);
      $pop = addslashes($_POST['pop']);
      $tech = addslashes($_POST['tech']);
      $imp = addslashes($_POST['imp']);
      $exp = addslashes($_POST['exp']);
      $misc = addslashes(nl2br($_POST['misc']));
      $query = "UPDATE planets SET name='$name', pic='$pic', type='$type', temp='$temp', atmo='$atmo', hydro='$hydro', gravity='$gravity', terrain='$terrain', day='$day', year='$year', species='$species', starport='$starport', pop='$pop', tech='$tech', imp='$imp', exp='$exp', misc='$misc' WHERE id=$id LIMIT 1";

      if (mysql_query($query)) {
        echo "<p>The planet was successfully modified.</p>\n";
      } else {
        echo '<p>An error occured modifying the planet. Please <a href="http://bugs.thebhg.org/index.php?page=reportbug" target="_blank">report a bug</a>.</p>'."\n";
      }
    }

    if (isset($_REQUEST['edit'])) {
      $show_form = 1;
      $planet = mysql_query("SELECT * FROM planets WHERE id=".$_REQUEST['edit']);
      $planet_info = mysql_fetch_array($planet, MYSQL_ASSOC);
      $target = "mod_planet";
      $value = $_REQUEST['edit'];
      echo "<p>Currently editing the database entry for ".$planet_info['name'].".<br />\n";
      echo "<table><tr><td><form method=\"post\" action=\"$PHP_SELF\">\n";
      echo "<input type=\"submit\" value=\"Cancel\" />\n";
      echo "</form></td></tr></table>\n";
    }

    if ($show_form == 1) {
      echo "<form method=\"post\" action=\"$PHP_SELF\">\n";
      echo "<input type=\"hidden\" name=\"$target\" value=\"$value\" />\n";
      echo "<table>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Name:</p></td>\n";
      echo "<td><input type=\"text\" name=\"name\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['name']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Image<a class=\"alt\" href=\"#notes\">*</a>:</p></td>\n";
      echo "<td><input type=\"text\" name=\"pic\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['pic']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Type:</p></td>\n";
      echo "<td><input type=\"text\" name=\"type\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['type']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Temperature:</p></td>\n";
      echo "<td><input type=\"text\" name=\"temp\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['temp']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Atmosphere:</p></td>\n";
      echo "<td><input type=\"text\" name=\"atmo\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['atmo']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Hydrosphere:</p></td>\n";
      echo "<td><input type=\"text\" name=\"hydro\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['hydro']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Gravity:</p></td>\n";
      echo "<td><input type=\"text\" name=\"gravity\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['gravity']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Terrain:</p></td>\n";
      echo "<td><input type=\"text\" name=\"terrain\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['terrain']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Length of Day:</p></td>\n";
      echo "<td><input type=\"text\" name=\"day\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['day']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Length of Year:</p></td>\n";
      echo "<td><input type=\"text\" name=\"year\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['year']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Sapient Species:</p></td>\n";
      echo "<td><input type=\"text\" name=\"species\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['species']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Starport:</p></td>\n";
      echo "<td><input type=\"text\" name=\"starport\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['starport']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Population:</p></td>\n";
      echo "<td><input type=\"text\" name=\"pop\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['pop']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Tech Level:</p></td>\n";
      echo "<td><input type=\"text\" name=\"tech\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['tech']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Major Imports:</p></td>\n";
      echo "<td><input type=\"text\" name=\"imp\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['imp']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Major Exports:</p></td>\n";
      echo "<td><input type=\"text\" name=\"exp\" size=\"40\" ";
      echo (isset($planet_info)) ? "value=\"".$planet_info['exp']."\" " : "";
      echo "/></td>\n</tr>\n";
      echo "<tr>\n<td class=\"contrast\"><p>Description:</p></td>\n";
      echo "<td><textarea name=\"misc\" rows=\"10\" cols=\"40\">";
      echo (isset($planet_info)) ? strip_tags($planet_info['misc']) : "";
      echo "</textarea></td>\n</tr>\n";
      echo "<tr><td class=\"contrast\"><p>Submit:</p></td><td><input type=\"submit\" value=\"Go\" /><input type=\"reset\" value=\"Reset\" /></td></tr>\n";
      echo "<tr><td class=\"contrast\" style=\"vertical-align: top;\"><p><a name=\"notes\">Notes:</a></p></td>\n";
      echo "<td class=\"contrast\"><p>* Image URLS are relative to <i>http://lyarna.thebhg.org/planets/images/</i> unless they start with <i>http://</i></p></td></tr>\n";
      echo "</table></form>\n";
    }

    // Building list
    unset($planet_info);
    echo "<table><tr>\n";
    echo "<th><p class=\"contrast\">Name</p></th>\n";
    echo "<th><p class=\"contrast\">Edit</p></th>\n";
    echo "</tr>";
    $planets = mysql_query("SELECT * FROM planets ORDER BY name ASC");
    while ($planet_info = mysql_fetch_array($planets, MYSQL_ASSOC)) {
      echo "<tr>\n";
      echo "<td class=\"contrast\"><p>".$planet_info['name']."</p></td>\n";
      echo "<td class=\"contrast\"><p><a class=\"alt\" href=\"".$PHP_SELF."?edit=".$planet_info['id']."\">Edit</a></p></td>\n";
      echo "</tr>";
    }
    echo "</table>\n";
    include("../footer.php");

    exit;

  }

?>

<?php

	$pagename = "Planets Admin";
	
	include("../functions/auth.php");
  
	 if ($is_authorised) {

	    include("../functions/db.php");
	    include("../header.php");

    	require_once "HTML/QuickForm.php";

    	if (isset($_REQUEST['submit'])){
	    	if ($_REQUEST['op'] == 'Edit Planet'){
		    	$array = array();
		    	
		    	foreach ($_REQUEST['return'] as $name => $value)
		    		$array[] = "`$name` = '" . addslashes($value) . "'";
		    		
		    	if (updatePlanet($_REQUEST['id'], $array))
		    		echo $_REQUEST['return']['name'] . ' edited successfully.';
		    	else
		    		echo 'Error updating planet: ' . mysql_error($GLOBALS['db']);
		    	
	    	} elseif ($_REQUEST['op'] == 'New Planet'){
		    	$array = array();
		    	$values = array();
		    	
		    	foreach ($_REQUEST['return'] as $name => $value){
		    		$array[] = "'" . addslashes($value) . "'";
		    		$values[] = "`$name`";
	    		}
		    		
		    	if (createPlanet($values, $array))
		    		echo $_REQUEST['return']['name'] . ' created successfully.';
		    	else
		    		echo 'Error creating planet: ' . mysql_error($GLOBALS['db']);
	    	}
    	}
    	
    	if (isset($_REQUEST['moon'])){	
	    	if (makeMoon($_REQUEST['moonof'], $_REQUEST['planet']))
	    		echo 'Successfully declared orbital satellite.';
	    	else
	    		echo 'Error declaring orbital satellite: ' . mysql_error($GLOBALS['db']);
    	}
    	
    	if (isset($_REQUEST['op']) && !isset($_REQUEST['submit'])){
	    	
	    	$form = new HTML_QuickForm('planets', 'post');
	    	
	    	$display = 'Create New Planet';
	    	
	    	if (isset($_REQUEST['planet']) && $_REQUEST['op'] == 'Edit Planet'){
		    	$planet = getPlanetForm($_REQUEST['planet']);
		    	$display = 'Edit ' . $planet['return[name]'];
		    	
		    	$form->setDefaults($planet);
	    	}
	    	
	    	$txt = array('size' => 60);
	    	$txta = array('rows' => 20, 'cols'=>50);
	    	
			$form->addElement('header', 'Planets', $display);
			$form->addElement('text', 'return[name]', 'Planet Name', $txt);
			$form->addElement('text', 'return[pic]', 'Image', $txt);
			$form->addElement('text', 'return[type]', 'Type', $txt);
			$form->addElement('text', 'return[temp]', 'Temperature', $txt);
			$form->addElement('text', 'return[atmo]', 'Atmosphere', $txt);
			$form->addElement('text', 'return[hydro]', 'Hydrosphere', $txt);
			$form->addElement('text', 'return[gravity]', 'Gravity', $txt);
			$form->addElement('text', 'return[terrain]', 'Terrain', $txt);
			$form->addElement('text', 'return[day]', '<a href=# title="Interger only, number of hours">Rotational Period</a>', $txt);
			$form->addElement('text', 'return[year]', '<a href=# title="Interger only, number of days">Orbital Period</a>', $txt);
			$form->addElement('text', 'return[species]', 'Sapient Species', $txt);
			$form->addElement('text', 'return[starport]', 'Starport', $txt);
			$form->addElement('text', 'return[pop]', 'Population', $txt);
			$form->addElement('text', 'return[tech]', 'Tech Level', $txt);
			$form->addElement('text', 'return[imp]', 'Major Imports', $txt);
			$form->addElement('text', 'return[exp]', 'Major Exports', $txt);
			$form->addElement('textarea', 'return[misc]', 'Description', $txta);
			$form->addElement('hidden', 'op', $_REQUEST['op']);
			$form->addElement('hidden', 'id', $_REQUEST['planet']);
			//$form->addElement('reset', 'btnClear', 'Clear');
			$form->addElement('submit', 'submit', 'Submit', 'id="button"');
			

			$form->display();
		}
		
		echo '<hr noshade />';
		$form = new HTML_QuickForm('planets', 'post');
		$form->addElement('header', 'Administration', 'Choose Action');
		$form->addElement('submit', 'op', 'New Planet', 'id="button"');
		$form->addElement('select', 'planet', 'Planet:', getPlanets(0, 1));
		$form->addElement('submit', 'op', 'Edit Planet', 'id="button"');
		$form->addElement('select', 'moonof', ' is a satellite of:', getPlanets(1));
		$form->addElement('submit', 'moon', 'Declare Satellite', 'id="button"');
		$form->display();

	echo '<div style="height: 50"></div>';
		
    include("../footer.php");

    exit;

  }

?>

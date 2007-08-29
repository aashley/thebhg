<?php

  $pagename = "Buildings Admin";

  include("../functions/auth.php");
  
  if ($is_authorised) {

    include("../functions/db.php");
    include("../header.php");

    require_once "HTML/QuickForm.php";

	if (isset($_REQUEST['submit'])){
		if ($_REQUEST['own_person'] > 0)
			$_REQUEST['return']['bhg_id'] = $_REQUEST['own_person'];
			
    	if ($_REQUEST['op'] == 'Edit Location'){
	    	$array = array();
	    	
	    	$exp = explode('_', $_REQUEST['id']);
			$id = $exp[1];
			$table = $exp[0];
	    	
			if ($table != $_REQUEST['type']){
				
				$array = array();
		    	$values = array();
		    	
		    	foreach ($_REQUEST['return'] as $name => $value){
		    		$array[] = "'" . addslashes($value) . "'";
		    		$values[] = "`$name`";
	    		}
		    		
		    	if (createLocation($_REQUEST['type'], $values, $array)){
			    	if (deleteLocation($_REQUEST['id']))
		    			echo $_REQUEST['return']['name'] . ' updated successfully.';
		    		else
		    			echo 'Error updating: ' . mysql_error($GLOBALS['db']);
	    		} else
		    		echo 'Error updating location: ' . mysql_error($GLOBALS['db']);
				
			} else {
	    	
				if ($_REQUEST['return']['position'] != -1 && $_REQUEST['return']['position'] != -1)
					$_REQUEST['return']['bhg_id'] = 0;
				
		    	foreach ($_REQUEST['return'] as $name => $value)
		    		$array[] = "`$name` = '" . addslashes($value) . "'";
		    		
		    	if (updateLocation($_REQUEST['id'], $array))
		    		echo $_REQUEST['return']['name'] . ' edited successfully.';
		    	else
		    		echo 'Error updating location: ' . mysql_error($GLOBALS['db']);
		    		
    		}
    	} elseif ($_REQUEST['op'] == 'New Location'){
	    	$array = array();
	    	$values = array();
	    	
	    	foreach ($_REQUEST['return'] as $name => $value){
	    		$array[] = "'" . addslashes($value) . "'";
	    		$values[] = "`$name`";
    		}
	    		
	    	if (createLocation($_REQUEST['type'], $values, $array))
	    		echo $_REQUEST['return']['name'] . ' created successfully.';
	    	else
	    		echo 'Error creating location: ' . mysql_error($GLOBALS['db']);
    	}
	}
    
    if (isset($_REQUEST['op']) && !isset($_REQUEST['submit'])){
    
	    if ($_REQUEST['op'] == 'delete') {
	    	if (deleteLocation($_REQUEST['id']))
	    		echo 'Delete successful.';
	    	else
	    		echo 'Error deleting location: ' . mysql_error($GLOBALS['db']);
	    } else {
	    
		    if ($_REQUEST['op'] == 'Delete Location'){
		    	?><SCRIPT LANGUAGE="JavaScript">
				<!--
				function confirm_entry(link){
		
					progress = confirm("Are you SURE you want to delete this location?");
					
					if (progress == true){ 
					window.location = link;
					} else {
					alert ("Delete canceled.");
					}
				
				}
				
				confirm_entry('<?=$_SERVER['PHP_SELF']?>?id=<?=$_REQUEST['location']?>&op=delete');
		    	-->
		    	</script><?
	    	}
		    
		    $form = new HTML_QuickForm('locations', 'post');	
			$display = 'Create New Location';
			
			$planet = array('return[planet]'=>1, 'return[arena]'=>1);
			
			if (isset($_REQUEST['location']) && $_REQUEST['op'] == 'Edit Location'){
		    	$planet = getLocationForm($_REQUEST['location']);
		    	$display = 'Edit ' . $planet['return[name]'];
		    	
		    	$form->setDefaults($planet);
			}
			
			$txt = array('size' => 60);
			$txta = array('rows' => 20, 'cols'=>50);
			
			$types = array('complex'=>'BHG Locations', 'estate'=>'Hunter Estates', 'hq'=>'Kabal Headquarters', 
							'other'=>'Other Locations', 'personal'=>'Personal Sites');
			
			$exp = explode('_', $_REQUEST['location']);
			$table = $exp[0];
			
			$form->addElement('header', 'Planets', $display);
			$form->addElement('text', 'return[name]', 'Name', $txt);
			$form->addElement('text', 'return[pic]', 'Image', $txt);
			$form->addElement('text', 'return[owner]', 'Owner', $txt);
			$form->addElement('text', 'return[location]', 'Location', $txt);
			$form->addElement('text', 'return[type]', 'Type', $txt);
			$form->addElement('text', 'return[value]', 'Monetary Value', array('size'=>10));
			$form->addElement('select', 'return[planet]', 'Planet:', getPlanets())->setSelected($planet['return[planet]']);
			$form->addElement('select', 'type', 'Location Type:', $types)->setSelected($table);
			$form->addElement('advcheckbox', 'return[arena]', 'Allow Arena?', '', ($planet['return[arena]'] ? 'checked' : ''), array(0,1));
			$form->addElement('textarea', 'return[misc]', 'Description', $txta);
			$form->addElement('hidden', 'op', $_REQUEST['op']);
			$form->addElement('hidden', 'id', $_REQUEST['location']);
			//$form->addElement('reset', 'btnClear', 'Clear');
			
			$GLOBALS['roster'] = new roster();
			$divi = array('-1'=>'');
			$posi = array('-1'=>'');
			foreach ($GLOBALS['roster']->getDivisions() as $division){
	            if ($division->GetID() != 16) {
	                $divi[$division->getID()] = $division->getName();
	            }
	        }
	        foreach ($GLOBALS['roster']->getPositions() as $division){
				$posi[$division->getID()] = $division->getName();
	        }
			?>
			<script language="Javascript" type="text/javascript">
			<!--
			function person(id, name) {
			    this.id = id;
			    this.name = name;
			}
			function swap_kabal(frm, type) {
			    var kabal_list = eval("frm." + type + "_kabal");
			    var person_list = eval("frm." + type + "_person");
			    var kabal = kabal_list.options[kabal_list.options.selectedIndex].value;
			    var kabal_array = eval("roster" + kabal);
			    var new_length = kabal_array.length;
			    person_list.options.length = new_length;

			    for (i = 1; i <= new_length; i++) {
			        person_list.options[i] = new Option(kabal_array[i].name, kabal_array[i].id, false, false);
			    }
			}
			
			<?php
			foreach ($GLOBALS['roster']->getDivisions() as $division) {
			    if ($division->GetID() != 16) {
			        $divtitle = "roster".$division->GetID();
			        echo $divtitle." = new Array();\n";
			        $members = $division->GetMembers("name");
print_r($members);
			        for($j = 0; $j < $division->GetMemberCount(); $j++) {
			            $person = $members[$j];
			            echo $divtitle."[".$j."] = new person(".$person->GetID().", '".str_replace("'", "\'", $person->GetName())."');\n";
			        }
			    }
			}
			?>
			
			// -->
			</script><?
			
			if (isset($planet['return[bhg_id]'])){
				$base = array($planet['return[bhg_id]']=>$GLOBALS['roster']->getPerson($planet['return[bhg_id]'])->getName());
			} else {
				$base = array(-1=>'Select Division');
			}
			
			$attrs = array('onchange' => "swap_kabal(this.form, 'own')");
			
			$form->addElement('select', 'own_kabal', 'Owner\'s Division:', $divi, $attrs);
			$form->addElement('select', 'own_person', 'Owner:', $base);
			
			$posi = $form->addElement('select', 'return[position]', 'Position', $posi);
			if (isset($planet['return[position]']))
				$posi->setSelected($planet['return[position]']);
			$divi = $form->addElement('select', 'return[division]', 'Division', $divi);
			if (isset($planet['return[division']))
				$divi->setSelected($planet['return[division]']);
				
			$form->addElement('submit', 'submit', 'Submit', 'id="button"');
			
			$form->display();
			
		}
		
	}
	
	echo '<hr noshade />';
	$form = new HTML_QuickForm('locations', 'post');
	$form->addElement('header', 'Administration', 'Choose Action');
	$form->addElement('submit', 'op', 'New Location', 'id="button"');
	$form->addElement('select', 'location', 'Location:', getLocations());
	$form->addElement('submit', 'op', 'Edit Location', 'id="button"');
	$form->addElement('submit', 'op', 'Delete Location', 'id="button"');
	$form->display();
	
	echo '<div style="height: 50"></div>';
	
    include("../footer.php");

    exit;

  }

?>

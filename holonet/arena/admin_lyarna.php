<?php
function title() {
    return 'Administration :: Overseer Utilities :: Property Management';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $sheet, $roster;

    $lyarna = $arena->LyarnaConnect();
    
    arena_header();

    echo '<a href="' . internal_link($page, array('table'=>'complex')) . '">Complexes</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'estate')) . '">Estates</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'hq')) . '">Headquarters</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'personal')) . '">Personal</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'other')) . '">Other</a>';

    hr();

    if (isset($_REQUEST['submit'])) {
	    $error = true;
	    for ($i = 0; $i < $_REQUEST['runs']; $i++){
		    if ($_REQUEST['process'.$i]){
			    if ($_REQUEST['position'.$i]){
				    $sets = "`position` = '".$_REQUEST['position'.$i]."', `division` = '".$_REQUEST['kabal'.$i]."'";
			    } elseif ($_REQUEST['person'.$i]) {
				    $sets = "`bhg_id` = '".$_REQUEST['person'.$i]."'";
			    }
			    
			    if ($sets){ 
		            if (!mysql_query("UPDATE " . $_REQUEST['table'] . " SET $sets WHERE `id` = '".$_REQUEST['property'.$i]."'", $lyarna)) {
		                $error = false;	                
		            }
	            }
            }
        }
        
        if ($error){
	        NEC(170);
        } else {
	        echo 'System property upgraded.';
        }
    }
    else {
	    if (isset($_REQUEST['table'])){
		    $table = $_REQUEST['table'];
	    } else {
		    $table = 'complex';
	    }
        $form = new Form($page);
        $form->AddHidden('table', $table);
        $locations = mysql_query('SELECT * FROM ' . $table . ' ORDER BY name', $lyarna);        
        $kabals_result = $roster->GetDivisions();
	    
			$kabals = array();
			$positions = implode('', $roster->GetPositions());
	    
			foreach ($kabals_result as $kabal) {
	      
			      if ($kabal->GetID() != 9 && $kabal->GetID() != 16) {
			        
			        $kabals[$kabal->GetName()] = "<option value=\"".$kabal->GetID()."\">"
			          .$kabal->GetName()."</option>\n";
			      }
	      
	    	}
	    
			$kabals = implode('', $kabals);
	
		?>
		<script language="JavaScript1.1" type="text/javascript">
		<!--
		function person(id, name) {
			this.id = id;
			this.name = name;
		}
	
		<?php
  
			reset($kabals_result);
	    
		  $commindex = 0;
	    
			foreach ($kabals_result as $kabal) {
	      
				if ($kabal->GetID() == 16) {
	        
					continue;
	        
				}
	      
				echo 'roster' . $kabal->GetID() . " = new Array();\n";
	      
				$plebs = $kabal->GetMembers('name');
	      
		    if (is_array($plebs)) {
	        
		      $plebindex = 0;
	        
	        foreach ($plebs as $pleb) {
	          
	          $div_peeps[$pleb->GetName().':'.$plebindex] = 
	            'roster'
	            .(($kabal->GetID() == 9) 
	              ? '10' 
	              : $kabal->GetID()) 
	            .'['.
	            (($kabal->GetID() == 9 || $kabal->GetID() == 10) 
	              ? $commindex++ 
	              : $plebindex++)
	            .'] = new person('.$pleb->GetID().', \''
	            .str_replace("'", "\\'", shorten_string($pleb->GetName(), 40))
	            ."');\n";
	            
	        }
	        
	        echo implode('', $div_peeps);
	        
	        unset($div_peeps);
	        
		    }
	      
			}
	    
		?>
	
		function swap_kabal(frm, id) {
		var kabal_list = eval("frm.kabal" + id);
		var person_list = eval("frm.person" + id);
		var kabal = kabal_list.options[kabal_list.options.selectedIndex].value;
			if (kabal > 0) {
				var kabal_array = eval("roster" + kabal);
				var new_length = kabal_array.length;
				person_list.options.length = new_length;
				for (i = 0; i < new_length; i++) {
					person_list.options[i] = new Option(kabal_array[i].name, kabal_array[i].id, false, false);
				}
			}
			else {
				person_list.options.length = 1;
				person_list.options[0] = new Option("N/A", -1, false, false);
			}
		}
	
		// -->
		</script>
		<noscript>
		This page requires JavaScript to function properly.
		</noscript>
	<?
		$form->table->AddRow('Mod', 'Current Owner', 'Name', 'Listed Owner', 'Division', 'Position', 'Hunter');
		$i = 0;
		
        while ($row = mysql_fetch_array($locations)) {
	        $form->table->StartRow();
	        if ($row['division']){
		        $divi = new Division($row['division']);
		        $position = new Position($row['position']);
		        $owner = $position->GetName().' of '.$divi->GetName();
	        } elseif ($row['bhg_id']){
		        $hunter = new Person($row['bhg_id']);
		        $owner = $hunter->GetName();
	        } else {
		        $owner = 'Not Listed in System';
	        }
	        $form->AddHidden('property'.$i, $row['id']);
		  	$form->table->AddCell('<input type="checkbox" name="process'.$i.'" value=1>');
	        $form->table->AddCell($owner);
	        $form->table->AddCell($row['name']);
	        $form->table->AddCell($row['owner']);
	        $form->table->AddCell("<select name=\"kabal$i\" "
	        ."onChange=\"swap_kabal(this.form)\">"
	        ."<option value=\"-1\">N/A</option>$kabals</select>");
	
	    	$cell = "<select name=\"person$i\">";
	    
				$cell .= "<option value=\"-1\" selected>N/A</option>\n";
	    
			$cell .= "</select>";

			$form->table->AddCell("<select name=\"position$i\">"
	        ."<option value=\"-1\">N/A</option>$positions</select>");
			$form->table->AddCell($cell);
			$form->table->EndRow();
			$i++;
        }
        $run = $i-1;
        $form->AddHidden('runs', $run);
        $form->table->StartRow();
        $form->table->AddCell('<input type="submit" name="submit" value="Updated Properties">', 7);
        $form->table->EndRow();
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>
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
	    $error = false;
	    for ($i = 0; $i < $_REQUEST['runs']; $i++){
		    if ($_REQUEST['process'.$i]){
			    if ($_REQUEST['position'.$i] > 0){
				    $sets = "`position` = '".$_REQUEST['position'.$i]."', `division` = '".$_REQUEST['kabal'.$i]."'";
			    } elseif ($_REQUEST['person'.$i]) {
				    $sets = "`bhg_id` = '".$_REQUEST['person'.$i]."'";
			    }
			    
			    if ($sets){ 
				    $sql = "UPDATE " . $_REQUEST['table'] . " SET $sets WHERE `id` = '".$_REQUEST['property'.$i]."'";
		            if (!mysql_query($sql, $lyarna)) {
		                $error = true;	                
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
        $locations = mysql_query('SELECT * FROM ' . $table . ' ORDER BY name', $lyarna);        
        $kabals_result = $roster->GetDivisions();
	    
			$kabals = array();
			$names = array();
			foreach ($roster->GetPositions() as $name){
				$names[] = '<option value="'.$name->GetID().'">'.$name->GetName().'</option>';
			}
			$positions = implode('', $names);
	    
			foreach ($kabals_result as $kabal) {
	      
			      if ($kabal->GetID() != 16) {
			        
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
	          
	          $div_peeps[$pleb->GetName().':'.$plebindex] = 'roster'.$kabal->GetID().'['.$plebindex++.'] = new person('.$pleb->GetID().', \''
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
		<form name="award" method="post" action="<?=$PHP_SELF?>">
	<input type="hidden" name="module" value="<?=$module?>">
	<input type="hidden" name="page" value="<?=$page?>">
	<input type="hidden" name="table" value="<?=$table?>">
	<?
		$table = new Table('', true);
		$table->AddRow('Mod', 'Current Owner', 'Name', 'Listed Owner', 'Division', 'Position', 'Hunter');
		$i = 0;
		
        while ($row = mysql_fetch_array($locations)) {
	        $table->StartRow();
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
	        echo '<input type="hidden" name="property'.$i.'" value="'.$row['id'].'">';
		  	$table->AddCell('<input type="checkbox" name="process'.$i.'" value=1>');
	        $table->AddCell($owner);
	        $table->AddCell($row['name']);
	        $table->AddCell($row['owner']);
	        $table->AddCell("<select name=\"kabal$i\" "
	        ."onChange=\"swap_kabal(this.form, $i)\">"
	        ."<option value=\"-1\">N/A</option>$kabals</select>");
	
	    	$cell = "<select name=\"person$i\">";
	    
				$cell .= "<option value=\"-1\" selected>N/A</option>\n";
	    
			$cell .= "</select>";

			$table->AddCell("<select name=\"position$i\">"
	        ."<option value=\"-1\">N/A</option>$positions</select>");
			$table->AddCell($cell);
			$table->EndRow();
			$i++;
        }
        $run = $i-1;
        echo '<input type="hidden" name="runs" value="'.$i.'">';
        $table->EndTable();
    }
    ?>
    <input type="submit" name="submit" value="Update Properties">
    </form>
    <?php

    admin_footer($auth_data);
}
?>
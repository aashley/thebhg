<?
		$kabals_result = $roster->GetDivisions();

		$kabals = array();		
		$plebsheet = array();
		$sheet = new Sheet();
		$run = array();
		if (is_array($bar_whore) && count($bar_whore)){
			$lists = array();
			$i = 0;
			foreach ($bar_whore as $list){
				foreach ($arena->Search(array('table'=>'ams_lists', 'search'=>array('date_deleted'=>'0', 'list'=>$list))) as $search){
					$lists[$i][] = $search->Get(bhg_id);
				}
				$i++;
			}
			$reduce = $lists[0];
			if (count($lists) > 1){
				for ($i = 1; $i < count($lists); $i++){
					$reduce = array_intersect($reduce, $lists[$i]);
				}
			}
			$run = $reduce;
		} else {
			$run = $sheet->SheetHolders();
		}
		
		if ($GLOBALS['property']){
			foreach ($kabals_result as $kabal){
				if ($kabal->GetID() != 9 && $kabal->GetID() != 16) {
			        foreach ($kabal->getMembers() as $person){
				        $plebsheet[$kabal->GetID()][] = $person;
			        }
			      }
		      }
	      } else {
	    	foreach ($run as $person){
		    	$person = new Person($person);
		    	$kabal = $person->GetDivision();
		    	$go = true;
				if (is_array($bar_slut) && count($bar_slut)){
					foreach ($bar_slut as $course){
						$sql = "SELECT * FROM `ntc_exam_completed` WHERE `bhg_id` = '".$person->GetID()."' AND `has_passed` = 1 AND `exam` = '$course'";
						if (!mysql_num_rows(mysql_query($sql, $roster->roster_db))){
							$go = false;
						}
					}					
				}
	    		if ($go){
		    		$plebsheet[$kabal->GetID()][] = $person;
	    		}
	    	}
    	}
    	
    	foreach ($kabals_result as $kabal) {

		      if ($kabal->GetID() != 9 && $kabal->GetID() != 16 && count($plebsheet[$kabal->GetID()])) {
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
      		$div_peeps = array();
			$plebs = $plebsheet[$kabal->GetID()];
      
	    if (is_array($plebs)) {
        
	      $plebindex = 0;
        
        foreach ($plebs as $pleb) {
	        if ($pleb->GetID() != $huid){
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
        }
        
        echo implode('', $div_peeps);
        
        unset($div_peeps);
        
	    }
      
		}
    
	?>

	function swap_kabal(frm) {
		var kabal_list = eval("frm.kabal");
		var person_list = eval("frm.bhg_id");
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
	
<?php 
	$form->table->StartRow();
	
	$bar_scum = "<select name=\"kabal\" onChange=\"swap_kabal(this.form)\"><option value=\"-1\">N/A</option>$kabals</select>";
	
    $form->table->AddCell(($ringa_ding ? $ringa_ding : $bar_scum));
    
	$cell = "<select name=\"bhg_id\">";
	$cell .= "<option value=\"-1\" selected>N/A</option>\n";
	$cell .= "</select>";
	
	$form->table->AddCell(($ringa_ding ? $bar_scum.str_repeat('&nbsp;', 3) : '').$cell);
	$form->table->EndRow();
?>
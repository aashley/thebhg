<?php
// Set the number of displayed fields here.
$fields = 20;

// The database prefix goes here.
$prefix = 'hn_';

function title() {
	return 'Administration :: Award Credits';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return ($auth_data['commission'] || $auth_data['chief'] || $auth_data['warden']);
}

function output() {
	global $auth_data, $pleb, $roster, $page, $mb, $fields, $prefix, $module;

	$pos = $pleb->GetPosition();
	$div = $pleb->GetDivision();

	// True if approval is required for this award, false otherwise.
	$approval_req = ($div->GetID() != 9 && $div->GetID() != 10);

	roster_header();
  
	if ($_REQUEST['submit']) {

    $sql = "INSERT INTO {$prefix}pending_reasons (reason, "
                                                ."person, "
                                                ."jud_pending) "
          ."VALUES ('".addslashes($_REQUEST['reason'])."', "
                   .$pleb->GetID().", "
                   .($approval_req ? "1" : "0").")";
    
		mysql_query($sql, $roster->roster_db) 
      or printf("Error: %s<br>", mysql_error($roster->roster_db));
      
		$reason_id = mysql_insert_id($roster->roster_db);
    
		for ($i = 0; $i < $fields; $i++) {
      
			$person = "person$i";
      
			$credits = "credits$i";
      
			if (   $_REQUEST[$person] <= 0 
          || empty($_REQUEST[$credits]) 
          || $_REQUEST[$credits] == 0) {
        
        continue;
        
			}
      
			$_REQUEST[$credits] = str_replace(',', '', $_REQUEST[$credits]);

      $sql = "INSERT INTO {$prefix}pending_credits (reason, "
                                                  ."person, "
                                                  ."credits) "
            ."VALUES ($reason_id, "
                     .$_REQUEST[$person].", " 
                     .$_REQUEST[$credits].")";
      
			mysql_query($sql, $roster->roster_db) 
        or printf("Error: %s<br>", mysql_error($roster->roster_db));
        
		}
    
		if ($approval_req) {
      
			$email = 'A new credit award has been made by '.$pos->GetName().' '
        .$pleb->GetName().". The details are as follows:\n\nActivity: " 
        .$_REQUEST['reason']."\nDate Range: $startdate to $enddate\n"
        ."Hunters Involved: ";
        
      if (count($_REQUEST['active'])) {
        
				foreach ($_REQUEST['active'] as $inv) {
          
					$inv = $roster->GetPerson($inv);
          
					$inv_array[] = $inv->GetName();
          
				}
        
				$email .= implode(', ', $inv_array);
        
			} else {
        
        $email .= 'None selected';
        
      }
      
			$email .= "\n\nBHG Roster";
      
			$jud = $roster->SearchPosition(10);
      
			if ($jud) {

        $jud[0]->SendEmail("BHG Roster <roster@thebhg.org>",
                           "[Roster] New Credit Award",
                           $email);
        
			} else {
        
        echo "There is no Warden, so you might be in for something of a "
          ."wait.<br>";
          
      }
      
		}
    
		echo "Credits added to the pending list for the Underlord"
      .($approval_req
        ? " and Warden" 
        : "") 
      . " to approve.<br><br>\n";
      
	}
  
	if ($pos->GetID() != 11) {
    
		$kabals_result = $roster->GetDivisions();
    
		$kabals = array();
    
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
  
	}	else {
    
		$division = $pleb->GetDivision();
    
		$plebs = $division->GetMembers('name');

		$plebOptions = array();
    
		foreach ($plebs as $pleb) {
      
			$plebOptions[$pleb->GetName()] = '<option value="'.$pleb->GetID().'">'
        .$pleb->GetName()."</option>\n";
        
		}
    
		ksort($plebOptions);
    
	}
	?>
	<form name="award" method="post" action="<?=$PHP_SELF?>">
	<input type="hidden" name="module" value="<?=$module?>">
	<input type="hidden" name="page" value="<?=$page?>">
	Reason: <input type="text" name="reason" size=25>
	<?php
	if ($pos->GetID() == 11) {
	?>
	<br>Dates: <input type="text" name="startdate" size=10>&nbsp;to&nbsp;<input type="text" name="enddate" size=10>
	<br><br>Hunters Involved: <select name="active[]" size=5 multiple><? echo implode("", $plebOptions); ?></select><br>(Hold Control to select more than one Hunter.)<br><br>
	<?php
	}
  
	$table = new Table('', true);
  
	$table->StartRow();
	if ($pos->GetID() != 11) {
		$table->AddHeader('Kabal');
	}
	$table->AddHeader('Person');
	$table->AddHeader('Credits');
	$table->EndRow();
  
	for ($i = 0; $i < $fields; $i++) {
    
    $table->StartRow();
    
		if ($pos->GetID() != 11) {
      
			$table->AddCell("<select name=\"kabal$i\" "
        ."onChange=\"swap_kabal(this.form, $i)\">"
        ."<option value=\"-1\">N/A</option>$kabals</select>");
      
    }
    
		$cell = "<select name=\"person$i\">";
    
		if ($pos->GetID() != 11) {
      
			$cell .= "<option value=\"-1\">N/A</option>";
      
		} else {
      
			$cell .= "<option value=\"-1\" selected>N/A</option>\n" 
        .implode("", $plebOptions);
        
		}
    
		$cell .= "</select>";
    
		$table->AddCell($cell);
    
		$table->AddCell("<input type=\"text\" name=\"credits$i\" value=\"0\" "
      ."size=7 onFocus=\"if (this.value == '0') this.value = ''\" "
      ."onBlur=\"if (this.value == '') this.value = '0'\">");
    
		$table->EndRow();
	}
  
	$table->EndTable();
  
	?>
	<input type="submit" value="Submit Credit Award" class="button" name="submit">&nbsp;<input type="reset" class="button">
	</form>
	<?php
	admin_footer($auth_data);
}
?>

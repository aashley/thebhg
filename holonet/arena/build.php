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
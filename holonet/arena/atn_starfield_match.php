<?php
if (isset($_REQUEST['id'])){
	$atn = $arena->StarfieldMatch($_REQUEST['id']);
}

function title() {
    global $atn;

    $return = 'AMS Tracking Network :: Starfield Arena :: Match Archive';
    
    if (is_object($atn)){
	    $return .= ' :: Match ' . $atn->GetMatchID();
    }
    
    return $return;
}

function output() {
    global $atn, $arena;

    arena_header();

    if (is_object($atn)){
	    $location = $atn->GetLocation();
	    $type = $atn->GetType();
	    $setting = $atn->GetSettings();
	
	    $table = new Table();
	    $table->StartRow();
	    $table->AddHeader('Starfield Arena Match Profile', 2);
	    $table->EndRow();
	    $table->AddRow('ID Number:', $atn->GetLink());
	    $table->AddRow('Name:', $atn->GetName());
	    $table->AddRow('Type:', '<a href="' . internal_link('atn_starfield_type', array('id'=>$type->GetID())) . '">' . $type->GetName() . '</a>');
	    $table->AddRow('Setting:', '<a href="' . internal_link('atn_starfield_setting', array('id'=>$setting->GetID())) . '">' . $setting->GetName() . '</a>');
	
	    if ($atn->HasLocation()){
	        $table->AddRow('Location:', '<a href="' . internal_link('atn_starfield_location', array('id'=>$location->GetID())) . '">' . $location->GetName() . '</a>');
	    }
	
	    $restrict = "";
	
	    foreach($atn->GetRestrictions() as $value){
	        $info = new Restriction($value);
	        $restrict .= '<a href="' . internal_link('atn_starfield_restriction', array('id'=>$info->GetID())) . '">' . $info->GetName() . '</a><br />';
	    }
	
	    if (count($atn->GetRestrictions()) == 0){
	        $restrict = "None";
	    }
	
	    $table->AddRow('Restrictions:', $restrict);
	    $table->AddRow('Start Date:', $atn->GetStart());
	    $table->AddRow('End Date:', $atn->GetEnd());
	    $table->AddRow('Match Posts:', $atn->GetPosts());
	    $table->EndTable();
	
	    if ($atn->GetComplete()){
	
	        $fighters = $atn->GetFighters();
	
	        foreach($fighters as $value){
	            hr();
	
	            echo '<a name="outcome"></a>';
	            $table = new Table();
	            $table->StartRow();
	            $table->AddHeader('Match results for <a href="' . internal_link('atn_general', array('id'=>$value->GetID())) . '">' . $value->GetName() . '</a>', 2);
	            $table->EndRow();
	            $table->AddRow('Ship Used:', $value->GetShipLink());
	            $table->AddRow('Result:', $value->GetResult());
	            $table->AddRow('Total Credits:', number_format($value->GetCredits()).' Imperial Credits');
	            $table->AddRow('Total Experience Points:', number_format($value->GetXP()));
	            $table->EndTable();
	        }
	
	    }
	    
    }

    arena_footer();
}
?>
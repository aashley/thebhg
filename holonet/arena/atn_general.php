<?php
if (isset($_REQUEST['id'])){
	$hunter = new Person($_REQUEST['id']);
}

function title() {
    global $hunter;

    $return = 'AMS Tracking Network';
    
    if (is_object($hunter)){
	    $return .= ' :: Hunter Information :: ' . $hunter->GetName();
    }
    
    return $return;
}

function output() {
	global $arena, $hunter, $sheet, $roster, $page;
	
	arena_header();
	
	if (is_object($hunter)){
		$properties = count($arena->MyProperties($hunter));
		
		echo '<table border=0 width="100%"><tr valign="top"><td>';
		
		echo '<a name="stats"></a>';

		$table = new Table();

		$table->StartRow();
		$table->AddHeader('Personal Profile', 2);
		$table->EndRow();

		$table->AddRow('Name:', '<a href="' . internal_link('hunter', array('id'=>$hunter->GetID()), 'roster') . '">' . $hunter->GetName() . '</a>');
		$table->AddRow('ID Line:', $hunter->IDLine(0));
		$table->AddRow('Stat Tracker:', '<a href="' . internal_link('atn_personal_stats', array('id'=>$hunter->GetID())) . '">View All Events</a>');
		$table->AddRow('Character History:', '<a href="' . internal_link('point_history', array('id'=>$hunter->GetID())) . '">Experience/BP History</a>');

		if ($properties)
			$table->AddRow('Property in Lyarna:', '<a href="'.internal_link('atn_lyarna', array('id'=>$hunter->GetID())).'">Owns '.pluralise('Piece', $properties).' of Property</a>');
		
		$table->EndTable();
	    
	  echo '</td><td align="center"><div style="text-align: left">';
		$search = $arena->Search(array('table'=>'ams_activities', 'search'=>array('ladder` > 0 AND `date_deleted'=>'0')));
		$lrs = array();
		foreach ($search as $obj){
			$ladr = $arena->Ladder($obj->Get('id'), $hunter->GetID());
			if ($ladr){
				$lrs[$obj->Get('name')][$obj->Get('id')] = $ladr;
			}
		}
		
		if (count($lrs)){
			$table = new Table();
			
			$table->StartRow();
			$table->AddHeader('Ladder Rankings', 2);
			$table->EndRow();
			
			$table->StartRow();
			$table->AddHeader('Event');
			$table->AddHeader('Place');
			$table->EndRow();
			
			foreach ($lrs as $name=>$array){
				foreach ($array as $id=>$place){
					$table->AddRow('<a href="'.internal_link('atn_activity', array('id'=>$id)).'">'.$name.'</a>', $place);
				}
			}
			
			$table->EndTable();
		}
		echo '</div></td></tr></table>';
		
		hr();
		
		$aux = new Saves($hunter->GetID());
		$saves = $aux->GetBackups(5);  
		
		if (count($saves)){
			$table = new Table('', true);
			$table->StartRow();
			$table->AddHeader('Most Current Sheet Backups', 5);
			$table->EndRow();
			
			$table->StartRow();
			$table->AddHeader('Save Name');
			$table->AddHeader('Date');
			$table->AddHeader('&nbsp;');
			$table->EndRow();
			
			foreach ($saves as $data){
				if (!$data['share']){
					$table->AddRow($data['name'], $data['date'], '<a href="'.internal_link('view_backup', array('sheet'=>$data['id'])).'">View Save</a>');
				}
			}
			
			$table->EndTable();
		}
		
		hr();
		
		$character = new Character($hunter->GetID());	    
		$character->ParseSheet();
		
	}
    
  arena_footer();

}
?>

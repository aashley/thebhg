<?php

if (isset($_REQUEST['id'])){
	$person = new Person($_REQUEST['id']);
}

function title() {
    global $person;

    $return = 'AMS Tracking Network';

    if (is_object($activity)){
	    $return .= ' :: All Activities :: '.$person->GetName();
    }
    
    return $return;
}

function output() {
    global $person, $arena, $page;

    $sheet = new Sheet();
    
    arena_header();

    if (is_object($person)){
		
		$table = new Table('', true);
	    $table->StartRow();
	    $table->AddCell('Topic ID');
	    $table->AddCell('Type');
	    $table->AddCell('Name');
	    $table->EndRow();
	    
	    if ($_REQUEST['nexter']){
		    $grtrt = $_REQUEST['last'];
		    $fst = 'id` > \''.$grtrt.'\' AND `';
	    } elseif ($_REQUEST['nextdw']){
		    $grtrt = $_REQUEST['first'];
		    $fst = 'id` < \''.$grtrt.'\' AND `';
	    } 
	    
	    $pending = $arena->Search(array('table'=>'ams_records', 'order'=>array('id'=>'desc'), 'search'=>array('bhg_id'=>$_REQUEST['id'], 'outcome` > 0 AND `date_deleted'=>0), 'limit'=>20));
	    $pendings = array();
	    foreach ($pending as $oba){
		    if (!count($pendings)){
			    $first = $oba->Get(id);
		    }
		    $obja = new Obj('ams_match', $oba->Get(match), 'holonet');
		    $pendings[$obja->Get(type)][] = $obja;
		    $last = $oba->Get(id);
	    }
	    
	    ksort($pendings);
	    
	    foreach ($pendings as $ja=>$jas){
		    foreach ($jas as $match){
			    $data = unserialize($match->Get(specifics));
			    $table->StartRow();
			    $table->AddCell(($match->Get(mbid) ? mb_link($match->Get(mbid)) : 'Unposted'));
			    $type = new Obj('ams_activities', $match->Get(type), 'holonet');
			    $table->AddCell($type->Get(name));
			    $table->AddCell('<a href="'.internal_link(atn_stats, array('id'=>$match->Get(id))).'">'.($match->Get(name) ? $match->Get(name) : 'No Name').'</a>');
			    $table->EndRow();
		    }
	    }
	    
	    $table->EndTable();
	    
	    $pending = $arena->Search(array('table'=>'ams_records', 'search'=>array('id` > \''.$last.'\' AND `outcome` > 0 AND `bhg_id'=>$_REQUEST['id'], 'date_deleted'=>0), 'limit'=>20), 0, 1);
	    print_r($pending);
	    $denbo = $arena->Search(array('table'=>'ams_records', 'search'=>array('id` < \''.$first.'\' AND `outcome` > 0 AND `bhg_id'=>$_REQUEST['id'], 'date_deleted'=>0), 'limit'=>20), 0, 1);
	    
	    $table->EndTable();
	    if ($pending || $denbo){
		    hr();
		    $form = new Form($page);
		    
		    $form->AddHidden('id', $_REQUEST['id']);
			$form->AddHidden('op', $_REQUEST['op']);
			$form->table->StartRow();
			
			if ($denbo){
				$form->AddHidden('first', $first);
				$form->table->AddCell('<input type="submit" name="nextdw" value="<< Last 20">');
			}
			
			if ($pending){
				$form->AddHidden('last', $last);
				$form->table->AddCell('<input type="submit" name="nexter" value="Next 20 >>">');
			} 
		    $form->table->EndRow();
		    $form->EndForm();
	    }
	    
    }

    arena_footer();
}

?>
<?php
include_once('roster.inc');
include_once('objects/arena.inc');
include_once('library.inc');
include_once('citadel.inc');
include_once 'gen_header.php';
include_once 'executions.php';

$roster = new Roster('fight-51-me');
$mb = new MedalBoard('fight-51-me');

$exp = explode('_', $page);

if ($page == 'admin'){
	include_once 'nav_admin.php';
} elseif ($exp[0] == 'admin' || $exp[0] == 'coder'){
	function admin_footer($auth){
		echo '</td><td style="border-left: solid 1px black">';
		echo '&nbsp;<a href="' . internal_link('admin') . '">Return&nbsp;To&nbsp;Admin</a><br />';
		echo '</small></td></tr></table>';
	}
} else {
	include_once 'navigation.php';
}

function get_auth_data($hunter) {
    $pos = $hunter->GetPosition();
    $div = $hunter->GetDivision();
    /*$tempy = new Tempy();
    $lw = new LW_Solo();
    $solo = new Solo();
    $ladder = new Ladder();
    $ro = new RO();
    $sheet = new Sheet();
    $starfield = new Starfield();
    $irca = new IRCA();
    $survival = new Survival();*/

    $auth_data['id'] = $hunter->GetID();

    if ($hunter->GetID() == 2650){
	    $auth_data['coder'] = true;
	    $auth_data['cadre'] = true;
    } else {
	    $auth_data['coder'] = false;
	    $auth_data['cadre'] = false;
    }
    
    if ($pos->GetID() == 29 || $hunter->GetID() == 2650){
    	$auth_data['overseer'] = true;
	} else {
		$auth_data['overseer'] = false;
	}
    
    if ($pos->GetID() == 9 || $pos->GetID() == 29 || $hunter->GetID() == 2650) {
        $auth_data['rp'] = true;
        $auth_data['solo'] = true;
        $auth_data['tempy'] = true;
        $auth_data['elite'] = true;
        $auth_data['tempy_mod'] = true;   
        $auth_data['lw'] = true;   
        $auth_data['citadel'] = true;
        $auth_data['star'] = true;
        $auth_data['dojo'] = true;
        $auth_data['sheet'] = true;
        $auth_data['ro'] = true;
        $auth_data['aa'] = true;
        $auth_data['arena'] = true;
        $auth_data['irc'] = true;
        $auth_data['survival'] = true;
        $auth_data['ch'] = true;
    } else {
        $auth_data['rp'] = false;
        $auth_data['solo'] = false;
        $auth_data['tempy'] = false;
        $auth_data['elite'] = false;
        $auth_data['tempy_mod'] = false; 
        $auth_data['lw'] = false;  
        $auth_data['citadel'] = false;
        $auth_data['star'] = false; 
        $auth_data['dojo'] = false;  
        $auth_data['sheet'] = false; 
        $auth_data['ro'] = false; 
        $auth_data['aa'] = false;
        $auth_data['arena'] = false;
        $auth_data['irc'] = false;
        $auth_data['survival'] = false;
        $auth_data['ch'] = false;
    }
    
    /*$cadre = $hunter->GetCadre();
    $auth_data['cadre'] = false;
    if ($cadre){
	    if ($hunter->IsCadreLeader($cadre)){
		    $auth_data['cadre'] = true;
	    }
    }
    
    if ($pos->GetID() == 11 || $pos->GetID() == 12){
	    $auth_data['ch'] = true;
    }
    
    if ($hunter->GetID() == $ladder->CurrentMaster()){
	    $auth_data['dojo'] = true;
	    $auth_data['aa'] = true;
    }
    
    if ($hunter->GetID() == $ladder->CurrentSteward()){
	    $auth_data['arena'] = true;
	    $auth_data['aa'] = true;
    }
    
    if ($hunter->GetID() == $survival->CurrentRanger()){
	    $auth_data['survival'] = true;
	    $auth_data['aa'] = true;
    }
    
    if ($hunter->GetID() == $starfield->CurrentSkipper()){
	    $auth_data['star'] = true;
	    $auth_data['aa'] = true;
    }
    
    if ($hunter->GetID() == $ro->CurrentMM()){
	    $auth_data['ro'] = true;
	    $auth_data['aa'] = true;
    }
    
    if ($hunter->GetID() == $sheet->CurrentRegistrar()){
	    $auth_data['sheet'] = true;
	    $auth_data['aa'] = true;
    }
    
    Elite RP nonsense.    
    if (in_array($hunter->GetID(), $tempy->ActiveMods())){
	    $auth_data['tempy_mod'] = true;
    }
    
    if (in_array($hunter->GetID(), $tempy->Members())){
	    $auth_data['tempy'] = true;
	    $auth_data['elite'] = true;
    }
    
    if (in_array($hunter->GetID(), $ttg->Winners())){
	    $auth_data['fin_ttg'] = true;
	    $auth_data['elite'] = true;
    }

    if (in_array($hunter->GetID(), $tempy->Solidified())){
	    $auth_data['tempy_sub'] = true;
	    $auth_data['elite'] = true;
    }
    
    if (in_array($hunter->GetID(), $lw->Members())){
	    $auth_data['lw'] = true;
    }
    
    if ($hunter->GetID() == $solo->CurrentComissioner()){
	    $auth_data['solo'] = true;
	    $auth_data['aa'] = true;
    }
    
    if ($hunter->GetID() == $irca->CurrentHC()){
	    $auth_data['irc'] = true;
	    $auth_data['aa'] = true;
    }*/
    
    return $auth_data;
}

?>
<?php
function title() {
    return 'Index';
}

function output() {
    global $arena;

    $ov = $arena->Overseer();
    $aj = $arena->Adjunct();
    
    $overseer = '<a href="'.internal_link('atn_general', array('id'=>$ov->GetID())).'">'.$ov->GetName().'</a>';
    $adjunct = '<a href="'.internal_link('atn_general', array('id'=>$aj->GetID())).'">'.$aj->GetName().'</a>';
    
    arena_header();

   echo "
The cold breeze blows around a lone fighter, who stands amidst of the
electric glow of the lights in the Gaea Lynn Stadium. With weapons in hand
he stands silently, waiting for his opponent to appear. Then, with a roar
from the crowd, his adversary appears, entering the arena from the other
side. From the middle of the field, the Overseer begins dictating the
stipulations of the match, the crowd listening intently. Finishing, the
Overseer walks quickly from the field, leaving only the two combatants and
the hushed crowd.<br />
This is the Arena.<p>

Welcome to the Arena Management System. The Arena Management System, or AMS,
is broken down into two differnt divisions: The AMS Challenge and AMS
Tracking Networks. The AMS Tracking Network, or ATN, is the all encompassing
system which keeps track of all Role Playing done in the Bounty Hunter's
Guild. The ATN tracks everything from Arena Matches to Solo Missions, and
all the information is available via the Guild Holonet. You can look up
stats from the individual Role Playing systems, or look them up all at once
in the General Tracker.<p>

The AMS Challenge Network, or ACN, is the complex holonet contact system
which allows you to quickly and easily challenge another member of the Guild
to a match in any of the Arenas, as well as sign up for Bounty Contracts.<p>

The Arena Management System is run jointly by the Guild Overseer $overseer
and Adjunct $adjunct. If you have any questions or
comments, please direct them there.
<br /><br />
- Overseer Signature<br />".
$arena->Signature(1)."<p>
- Adjunct Signature<br />".
$arena->Signature(0);
    hr();
    echo '<a href="'.internal_link('reports').'">View Latest Reports</a><br />';
    echo '<a href="'.internal_link('view_reports').'">View All Reports</a>';
    hr();
$arena->LatestReport('ov');
echo '<br />';
$arena->LatestReport('aj');
    arena_footer();
}
?>
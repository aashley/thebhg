<?php
function title() {
    return 'Index';
}

function output() {
    global $arena;

    $ov = $arena->Overseer();
    $aj = $arena->Adjunct();
    
    $overseer = $ov->GetName();
    $adjunct = $aj->GetName();
    
    arena_header();

   echo "
A cold breeze blows by a lone fighter, standing in the midst of the electric glow of the lights in the Gaea Lynn Stadium. He stands with weapons in hand, waiting for his opponent to appear. The crowd cheers his name as his adversary enters the arena from the other side. From the middle of the field, the Overseer begins dictating the stipulations of the match. They finish, and begin to walk off, leaving only the two combatants and a now silent crowd. This is the Arena.
<br /><br />
Welcome to the Arena Module System. The Arena Module System, or AMS, is broken down into two differnt divisions. The AMS Challenge and AMS Tracking Networks. The AMS Tracking Network, or ATN, is the all encoumpasing system which keeps track of all Role Playing done in the Bounty Hunter's Guild. The ATN tracks everything from Arena Matches to Solo Missions, and all that infomation is now available to you via the Guild Holonet. You may look up stats from the individual Role Playing systems, or look them up all at once in the General Tracker.
<br /><br />
The Arena Module System Challenge Network, or ACN, is the complex holonet contact system will allows you to quickly and easily challenge another member of the Guild to a match in any of the Arenas, as well as sign up for Bounty Contracts. 
<br /><br />
The Arena Module System is run jointly by the Guild Overseer $overseer and Adjunct $adjunct. If you have any questions or comments, please direct them there.
<br /><br />
- Overseer Signature<br />".
$arena->Signature(1)."<p>
- Adjunct Signature<br />".
$arena->Signature(0);
    hr();
$arena->LatestReport(1);
echo '<br />';
$arena->LatestReport(0);
    arena_footer();
}
?>
<?php
function title() {
    return 'AMS Tracking Network';
}

function output() {
    global $arena;

    arena_header();

   echo "Your PAL beeps with an incoming message. A transmission from the Overseer. The message informs you your last Arena Match has just been graded and your credits awarded to your account. You make a slight grin as you walk over to a Holonet Interface. Keying up the proper module, you slide your way over to the Arena Tracking Network. A network of stat-checkers, number-cruncher, and super computer compliers all work at blinding speed to calculate your current standings in comparison to you fellow hunters. Your last match, which you won by dismembering half of your opponent, netted you a nice win. Subsequently, your ranking in the ladder moved up a spot, brining you ever closer to the sweet success and demanded respect of those at the top of the ladder.";
    hr();
    echo "Navigation: <br />";
    atn_nav();
    hr();
    arena_footer();
}
?>
<?php
function title() {
    return 'AMS Tracking Network';
}

function output() {
    global $arena;

    arena_header();

   echo "Your PAL beeps with an incoming message - a transmission from the Overseer.
A quick glance at the message informs you your last Arena Match has been
graded, and your credits awarded to your account. You grin and put the PAL
away, as you walk over to a Holonet Interface to check your credit balance
and new Arena Ladder Ranking. Keying up the proper module, you quickly make
your way to the Arena Tracking Network - a network of stat-checkers,
number-crunching algorithms, and super computer compliers all working at
blinding speed to calculate each hunter's current standings in comparison to
their fellow Guildsmen. A quick check shows that your last match, which you
won by dismembering your opponent, netted you a nice win. As a result, your
ranking on the ladder had moved up a position, bringing you ever closer to
the sweet success and demanded respect of the ladder's upper echelons.";
    hr();
    echo "Navigation: <br />";
    atn_nav();
    hr();
    arena_footer();
}
?>
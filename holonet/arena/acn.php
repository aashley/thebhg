<?php
function title() {
    return 'AMS Challenge Network';
}

function output() {
    global $arena;

    arena_header();

   echo "Located admist a number of computer terminals, Holonet Uplinks, and PAL
Interfaces is a large durasteel plaque with the words 'Arena Challenge
Centre' embossed into it. Around it, hunters are standing at the various
terminals, issuing challenges to other hunters of the Guild, as others are
moving to the Boloball terminals, placing bets and wagers on some of the
higher end matches. You look around for an open spot, catching sight of a
hunter leaving a terminal out of the corner of your eye. You race over
there, bobbing and weaving between the other hunters, and finally secure
your space. You grin to yourself and take out your IPKC, swiping it through
the reader to identify yourself. The system beeps, and a list populated with
options is generated infront of you.";
    hr();
    echo "Navigation: <br />";
    acn_nav();
    hr();
    
    arena_footer();
}
?>
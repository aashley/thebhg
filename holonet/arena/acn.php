<?php
function title() {
    return 'AMS Challenge Network';
}

function output() {
    global $arena;

    arena_header();

   echo "Admist a number of computer terminals, Holonet Uplinks, and PAL Interfaces is a large titanium plaque with the words 'Arena Challenge Centre' embossed into it. Hunters are standing at the various terminals, making challenges to other hunters all around the Guild while others are moving to the Boloball terminals, placing bets on some of the higher end matches. You look around for an open spot, your eye catching a hunter leaving one out of the corner of your eye. You race there, bobbing and weaving inbetween the other hunters and finally secure your space. You grin to yourself and take out your IPKC, swiping it in the reader to acknowledge who you are. The system beeps and a list, populated with options, is generated infront of you.";
    hr();
    echo "Navigation: <br />";
    acn_nav();
    hr();
    arena_footer();
}
?>
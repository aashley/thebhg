<?php
function title() {
    return 'Arena Management System :: Version';
}

function output() {
    global $arena;

    arena_header();

    echo "Current version: v2.0";
    
    hr();
    
    echo "The Arena Management System (AMS) is an all inclusive system that monitors,
records, and processes activities dealing with Role-Playing in the Bounty
Hunter's Guild. The AMS is broken down into 2 main divisions: The Arena
Management System Tracking Network (ATN), which monitors and tabulates
ladder results and tracks all matches, and the Arena Management System
Challenge Network (ACN), which allows a Hunter to challenge another hunter
to a match via the BHG Holonet. The AMS is monitored and maintained by the
Overseer and the Adjunct. It is they who manage and maintain the functions
of the AMS, to ensure the RP world runs quickly and smoothly.";
    
    hr();
    
    echo "Version Comments: Edited the ATN and ACN navigation. The ACN has been condensed into a single page. Individual links are still available via the Arena Challenge Network quicklink on top. Contracts must be retired now, by YOU, instead of having the CBO DCO them. If they are DCOed, then you will be put on the DCO ban. The DCO ban is essentially a 10 day time period where you cannot request new or Dead contracts. Retiring your contract will NOT put you under the effects of the DCO ban. Added some CS notification functions, and a CS Ban period which is modifiable by the RP staff. Also, CSes which have no valid data will no longer be available in the ACN dropdown lists for hunters, to prevent DQing over the fact one of you has no sheet. You will also not be allowed to use the ACN unless you have a valid, approved sheet. The CS backup utility has also been added. You can now back up your character sheets so you have working access to any sheet or character you've had an wanted to keep.";
    
    hr();
    
    echo "Last Update: October 24, 2004";
    
    hr();
    
   	echo "The Arena Management System is &copy; Ric Gravant, 2004.";

   	hr();
   	
   	echo 'Did you find an NEC Error while using the AMS and want to know what it is? Check <a href="' . internal_link('nec') . '">here [NEC]</a> for more information on the error.';
   	
    arena_footer();
}
?>
<?php
function title() {
    return 'Arena Management System :: Version';
}

function output() {
    global $arena;

    arena_header();

    echo "Current version: v1.7";
    
    hr();
    
    echo "The Arena Management System (AMS) is an all inclusive system that monitors, records, and processes activities dealing with Bounty Hunter's Guild Role-Playing. The AMS is broken down into 2 main divisions. The Arena Management System Tracking Network (ATN) which monitors and tabulates ladder results and tracks all matches, and the Arena Management System Challenge Network (ACN) which allows a Hunter to challenge another hunter to a match via use of the BHG Roster. The AMS is monitored and maintained by the RP Staff, i.e. the Overseer and Adjunct. These two people utilize the functions of the AMS to keep the RP world running quickly and smoothly along. Everyting from Arena Tournaments to IRC Arena matches is tracked by the AMS. The system is revolutionary to the BHG RP System.";
    
    hr();
    
    echo "Version Comments: Updated a few features, namely the ACN and Dojo of Shadows. The AMS now runs exclusivly off the Character Sheet standard, meaning you can't challenge nor be challenged without a character sheet. Additionally, all challenges made will be in the Dojo of Shadows, unless you are a listed graduate of the Dojo. To check your status, check both the Graduate and Learner list in the ATN Dojo of Shadows.";
    
    hr();
    
    echo "Last Update: October 3, 2004";
    
    hr();
    
   	echo "The Arena Management System is &copy; Ric Gravant, 2004.";

   	hr();
   	
   	echo 'Did you find an NEC Error while using the AMS and want to know what it is? Check <a href="' . internal_link('nec') . '">here [NEC]</a> for more information on the error.';
   	
    arena_footer();
}
?>
<?php
function title() {
    return 'Arena Management System :: Version';
}

function output() {
    global $arena;

    arena_header();

    echo "Current version: v1.5.1";
    
    hr();
    
    echo "The Arena Management System (AMS) is an all inclusive system that monitors, records, and processes activities dealing with Bounty Hunter's Guild Role-Playing. The AMS is broken down into 2 main divisions. The Arena Management System Tracking Network (ATN) which monitors and tabulates ladder results and tracks all matches, and the Arena Management System Challenge Network (ACN) which allows a Hunter to challenge another hunter to a match via use of the BHG Roster. The AMS is monitored and maintained by the RP Staff, i.e. the Overseer and Adjunct. These two people utilize the functions of the AMS to keep the RP world running quickly and smoothly along. Everyting from Arena Tournaments to IRC Arena matches is tracked by the AMS. The system is revolutionary to the BHG RP System.";
    
    hr();
    
    echo "Version Comments: Some nice functions for the RP staff added. Also added an ACN Challenge Database which details all current challenges.";
    
    hr();
    
    echo "Last Update: Fixed credit award problems. Higher ups can award creds quickly to RP Aides, and added the ACNC. Also took away the ACN link to Starfield Arena Challenges. This will come back when the SSL is refit, and it is at this time the ACNC will be up for use.";
    
    hr();
    
   	echo "The Arena Management System is &copy; Ric Gravant, 2004.";

   	hr();
   	
   	echo 'Did you find an NEC Error while using the AMS and want to know what it is? Check <a href="' . internal_link('nec') . '">here [NEC]</a> for more information on the error.';
   	
    arena_footer();
}
?>
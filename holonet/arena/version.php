<?php
function title() {
    return 'Arena Management System :: Version';
}

function output() {
    global $arena;

    arena_header();

    echo "Current version: v1.2";
    
    hr();
    
    echo "The Arena Management System (AMS) is an all inclusive system that monitors, records, and processes activities dealing with Bounty Hunter's Guild Role-Playing. The AMS is broken down into 2 main divisions. The Arena Management System Tracking Network (ATN) which monitors and tabulates ladder results and tracks all matches, and the Arena Management System Challenge Network (ACN) which allows a Hunter to challenge another hunter to a match via use of the BHG Roster. The AMS is monitored and maintained by the RP Staff, i.e. the Overseer and Adjunct. These two people utilize the functions of the AMS to keep the RP world running quickly and smoothly along. Everyting from Arena Tournaments to IRC Arena matches is tracked by the AMS. The system is revolutionary to the BHG RP System.";
    
    hr();
    
    echo "Version Comments: The AMS Module has/is been/being debugged to meet PHP coding and BHG Holonet requirements and is currently awaiting approval.";
    
    hr();
    
    echo "Last Update: Updated the Tournament code to allow for Wild Cards, Registry Deletions (Yay!), Bracket Organization, Round Stat-Determination, and Double Elimination Tourneys. Updated CS code, namely, the writers for XP and BP history events, now linked off the ATN. Also added in Character Assassination buttons due to AT 5 (must be OV). Turned off Tempy Petitions and fixed some cosmetic stuff with the ladders that were kicking back errors.";
    
    hr();
    
   	echo "The Arena Management System is &copy; Ric Gravant, 2004.";

   	hr();
   	
   	echo 'Did you find an NEC Error while using the AMS and want to know what it is? Check <a href="' . internal_link('nec') . '">here [NEC]</a> for more information on the error.';
   	
   	hr();
   	
   	echo 'A nice side project, the Holonet Scanner is done! View it <a href="holonet_scanner.php">Here</a>. I promise it to be of no value to those of you without a base in coding and some understanding of the Holonet system.';
   	
    arena_footer();
}
?>
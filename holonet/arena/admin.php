<?php
function title() {
    return 'Administration';
}

function auth($person) {
    global $auth_data, $pleb, $roster;

    $auth_data = get_auth_data($person);
    $pleb = $roster->GetPerson($person->GetID());
    return $auth_data;
}

function output() {
    global $auth_data, $sheet_db, $page, $roster;

    arena_header();

    echo 'Welcome to Arena Management System Administration. To the right is a list of all the management options currently available to you.';

    if ($auth_data['coder']){
	    hr();
		if ($_REQUEST['show']){
		    echo "This is a guide for the OV/AJ to set up a new activity. First thing you have to do is ensure you have the".
		    	" correct type ready for the event. This is done in the '<a href='".internal_link(admin_types)."'>Activity Types</a>' section.<p></p>";
		    
		    echo "Requires Opponent: If this is set to yes, it will allow a hunter to challenge a fellow hunter.".
		    	"<br />Hunter Requests: This will determine if this is Admin Only run (like ROs) or if hunters request it.".
		    	"<br />Hunter Submits: If set, this will present the hunter a place for logs. Used for IRCA and the like.".
		    	"<br />Uses NPCs: Duh".
		    	"<br />Uses Creatures: If set, it will use the Creatures from Survivals. Do not set both NPC and Creature.".
		    	"<br />Players Added At End: This will have you put in who played at the end. Used in ROs and the like.";
		    
		    echo "Once you have constructed your new Activity Type for your new event, you are ready for actually setting".
		    	" the event. This is done via the '<a href='".internal_link(admin_activities)."'>Activities</a>' section.".
		    	" I have faith you can get by this part without help.<p></p>";
		    	
		    echo "The next step is creating Event Specifics categories. These are the hunter chosen options presented. For".
		    	 " the admin-only events, like ROs, just use a dummy category. Each event requires at least ONE event".
		    	 " specific, and one event specific grade. This process is fairly simple. You should be able to follow what".
		    	 " this system is used for, given the current options. Things like 'Number of Weapons', 'Restrictions', etc".
		    	 " are set via this system. You will add the actual options later. For now, just set these topics.";
		    	 
		    echo " (As a note, Location is a special thing. It only appears for events with 'Requires Opponent' turned on)<p></p>";
		    
		    echo "Alright, now that you have created your topics, time to set the actual options which hunters can choose. Now".
		    	 " if you set 'Multiple' to true, they will be presented with checkboxes of the options which they can use,".
		    	 " otherwise, they'll be given a dropdown box of all possible selections to chose one from. For this, go to".
		    	 " '<a href='".internal_link(admin_rulegrade)."'>Rules and Grades</a>'. The only question here is points. This".
		    	 " field is used for 2 things, one of which you can't access. The first, unaccessible one, sets the number of".
		    	 " points used for NPCs. This option is editable, and tied only to the Contract Difficulty and Contract Level".
		    	 " options. The first controls regualr contracts, and the number in points represents the max stat point for ".
		    	 "the NPCs. The second one, which you use when creating a new one, is for ladder points. Set in points the ".
		    	 "number of ladder points you want to award for a certain grade. Such as 5 for win, -5 for DQ, etc. This is ".
		    	 "called when putting together ladders. The 'Use Medal For First' is a gradeset combination used in ROs. Don't".
		    	 " touch this one, just leave it as no, as I forgot how it works. The final bar, actions, is for which Event ".
		    	 "Specific your are building the option into. Now we can move on.<p></p>";
		    	 
		    echo "Now that you have actually built your options for an event, you have to tie them to an event, so they are".
		    	 " called with the event. To do this, go to '<a href='".internal_link(admin_builder)."'>Event Builder</a>'.".
		    	 " This is where the event is put together. Event refers to the event you are building to, and Resource is".
		    	 " what Rules/Grade you are tying to it. As said before, every event requires at least one Grade and one Specifics".
		    	 ", so you do that here. You select the Specific you built for the grade first, set the 'Use as Grade' box to".
		    	 " true, and submit. Then, do the same for your specifics, but set the 'Use as Grade' box to No. Never put".
		    	 " more than one grade to an event, or the system will shit itself, and knife you in your sleep. Once you ".
		    	 "have finished, find your event, click the 'Show' button, and just confirm you see at least one event specific".
		    	 " and one and only one grade. Once this is done, the event is all set to go.<p></p>";
		    	 
		    echo "Now, the next step is to restrict your event. You have 2 ways of doing this. The first is by courses, ".
		    	 "and the second is by Membership Lists. We'll cover List Creation first. To do this, simply go to ".
		    	 "'<a href='".internal_link(admin_lists)."'>Member Lists</a>'. Just create the name and description, and ".
		    	 "the list is created on the system. Now, like with the specifics, you have to tie it to the event. Head ".
		    	 "over to '<a href='".internal_link(admin_restrict)."'>Activity Restrictions</a>'. Select your activity first.".
		    	 " Then, select any Citadel courses which you wish to use to restrict the event with. If you restrict via".
		    	 " a course, then only people who have passed the course can see or be challenged to the event. Next, select".
		    	 " any Member Lists you want to use to restrict the event. Done and done. Now, if you want to restrict to".
		    	 " a specific position, rank, or division, do it here. You can figure this out. Also, don't be dumb. I'll ".
		    	 "kill anyone who makes an event for Counts of the Commission in Phoenix. Honestly. The use of the division/rank/position".
		    	 " list is a throwback before I set up the lists, so use it less often if possible, as I'm not really sure ".
		    	 "I event hooked it up. Then, hit process, and you're done. If you want/need to add more course/list restriction".
		    	 " simply create another rule for the event by repeating the process. Just don't duplicate rules, as it".
		    	 " looks ugly.<p></p>";
		    	 
		    echo "Last, optional step, is creating an Aide position. This is recommended, as it gives you a reason to not do".
		    	 " work. To do this, go to '<a href='".internal_link(admin_aides)."'>Aide Positions</a>' and create a new Aide.".
		    	 " Be reasonable when setting salary, and don't add in any commas to split it up, the system does it automatically.".
		    	 " Now, once this is done, you have to, again, attach the aide to an activity. To do this, go to ".
		    	 "'<a href='".internal_link(admin_access)."'>System Access</a>'. From here, you can give any Aide or Position ".
		    	 "access to a specific event. You can use this system to grant temporary access to other Aides for another activity,".
		    	 " or if the mood strikes you, create backup aide positions, and grant them access to something. The 'Character Sheet".
				 " Access' dropdown give you the ability to grant any aide the ability to modify, approve, or administrate the CSes. ".
				 "Please don't abuse this and give it to your friends, as it will make baby Jesus happy, and that fuck needs to be".
				 " taken down a peg. Anyway, that's it for the help here. I'm not going over CS mods, as those are really only for ".
				 "me. So touch those, and I'll kill you in the fucking eye. Also, don't disappear, or I will so kill you in the ".
				 "face.";
		 } else {
			 echo '<a href="'.internal_link('admin', array('show'=>1)).'">View Help on Creating New Events.</a>';
		 }
	 }
    
    admin_footer($auth_data);
}
?>

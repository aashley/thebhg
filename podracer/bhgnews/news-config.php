<?php
// ---Web Site Configuration---

	$dbusername = "thebhg_ntc";
	$dbpassword = "6756b304";
	$dbname = "thebhg_ntc";
	
//   The Name of Your Web Site
$web_name = "The Citadel";

//   URL of Your Website
$web_url = "http://citadel.thebhg.org/";


// ---News Configuration---

//   What you wish the news system to call itself.
//   Mostly used in the admin page
$news_system_name = "The Citadel"; 

//   Set this to the method you want to select items by  
//   either, posts or days  
$select_by = "posts";    

//   Set this to the number of days u wish to display  
//   by default  
$default_days = 5;    

//   Date Format
//   The Date uses the php date command for more information visit:
//     http://www.php.net/manual/function.date.php
//     
//    These are the charaters recognised by the date command
//    Create a string using these to format the date how you wish.
//      a - "am" or "pm"
//      A - "AM" or "PM"
//      d - day of the month, 2 digits with leading zeros; i.e. "01" to "31"
//      D - day of the week, textual, 3 letters; i.e. "Fri"
//      F - month, textual, long; i.e. "January"
//      h - hour, 12-hour format; i.e. "01" to "12"
//      H - hour, 24-hour format; i.e. "00" to "23"
//      g - hour, 12-hour format without leading zeros; i.e. "1" to "12"
//      G - hour, 24-hour format without leading zeros; i.e. "0" to "23"
//      i - minutes; i.e. "00" to "59"
//      j - day of the month without leading zeros; i.e. "1" to "31"
//      l (lowercase 'L') - day of the week, textual, long; i.e. "Friday"
//      L - boolean for whether it is a leap year; i.e. "0" or "1"
//      m - month; i.e. "01" to "12"
//      n - month without leading zeros; i.e. "1" to "12"
//      M - month, textual, 3 letters; i.e. "Jan"
//      s - seconds; i.e. "00" to "59"
//      S - English ordinal suffix, textual, 2 characters; i.e. "th", "nd"
//      t - number of days in the given month; i.e. "28" to "31"
//      U - seconds since the epoch
//      w - day of the week, numeric, i.e. "0" (Sunday) to "6" (Saturday)
//      Y - year, 4 digits; i.e. "1999"
//      y - year, 2 digits; i.e. "99"
//      z - day of the year; i.e. "0" to "365"
//      Z - timezone offset in seconds (i.e. "-43200" to "43200")
//
//  Default is: "F jS Y, g:iA"
$date_format = "F jS Y, g:iA";


//     Who can post
//   To set who can post you create an array of position division pairs
//   ie:
//   $posters[1]['position'] = 11;
//   $posters[1]['division'] = 8;
//   will set poster 0 to anyone who holds the position of chief within
//   omega kabal.
//   
//   Setting either of the values to -1 will mean any value for that 
//   catageory will match ie:
//   $posters[0]['position'] = 11;
//   $posters[0]['division'] = -1;
//   will set poster 0 to anyone who holds the position of chief.
//   
//      Postions                 Divisions
//     1 = Dark Prince		  10 = Commission
//     2 = Underlord		   9 = Commission Assistants
//     3 = Tactician		   3 = Daichi
//     4 = Specialist		   4 = Dragon
//     5 = Executor		   8 = Omega
//     6 = Judicator		  15 = Phoenix
//     7 = Marshal		   2 = Skylla
//     8 = Proctor		  13 = Thunder
//     9 = Adjunct		  11 = Unassigned
//    11 = Chief			  12 = Retirees
//    12 = Chief's Assistant   -1 = Any Division
//    13 = Grand Hunter
//    14 = Hunter
//    15 = Neophyte
//    16 = Novitiate
//    17 = Initiate
//    18 = Trainee
//    19 = Veteran
//    -1 = Any Position
//   
//   A Specific Person can be set as a poster using the following:
//   $posters[0]['id'] = 94; Gives Koral permission to post.
//   
//   The array of posters must start at 0. So the first one must be
//   $posters[0] NOT $posters[1]. If it does not start at zero the
//   the last entry will not be able to login.
//
//   
//   The Board Admin should be set to the login number of the person
//   maintaining the news script, be careful as this person will
//   be able to edit and delete any and all message on the board.
//   Other posters can only edit their own posts.
//   Board Admin can also be set an exact position/division pair.
//   It does not take the -1 wildcard. ie:
//   Specific Person as admin:
//   $board_admin['id'] = 94;
//   
//   Specific Position/Division pair:
//   $board_admin['position'] = 2;
//   $board_admin['division'] = 10;
//   

//Default board admin is Underlord Koral
//$board_admin['id'] = 94; 
$board_admin['position'] = 5;
$board_admin['division'] = 10;

// Default is any commission member can post

$posters[0]['id']       = 230;
$posters[1]['position'] = -1;  //All  
$posters[1]['division'] = 10;  //Core Commish    
$posters[2]['position'] = -1;  //All  
$posters[2]['division'] = 9;   //Commish Assts



// ---Backend Configuration---

//   Full home URL of the news page
//   ie a url that will display the news page
//   place %id% where you want the news id number to be placed
//   The news script places a <a name=%postid%></a> at the beginning of each
//   article. So a normal link might be :
//   $news_home = "http://underlord.thebhg.org/#%id%";
//
//   However if your site is using frames this will not work so you may need
//   to set something else up, like this:
//   $news_home = "http://ssl.thebhg.org/?id=%id%";
$news_home = "http://www.thebhg.org/main/shownews.php#%id%";

//   Number of items to display in Backend
$backend_num = 5;


// ---Server Configuration---

//   If you are hosted on thebhg.org then you do not need to change this. 
//   If you are hosted on another server then you need to uncomment the 
//   "thebhg.org" line and comment the localhost line.

// $roster_host = "thebhg.org";

$roster_host = "localhost";
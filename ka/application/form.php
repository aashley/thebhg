<?php
##################################################
## Email sender by: Steve "Defender" Cunningham ##
##################################################
##												##
## Edit the proper variables to make the script ##
## work on your site.                           ##
##												##
##################################################
##												##
## If I'm not busy, you can email me at:        ##
## sc_99_99@yahoo.com and I can try to help     ##
## you with your problem.						##
##												##
##################################################
##												##
## Note that if the copyright info is deleted,  ##
## this script is no longer valid.              ##
##												##
##################################################

//Define some variables

$youremail="reports@thebhg.org"; // This is the address that the information submitted will be sent to.

$emailsubject="$Position Application"; // This will the email's subject

// The From field will be be where this email came from.
// Note on the from field. the text after the first " mark, until the < is what appears in "From" in your email program.
// So, you can put anything alpha numeric here. That would be any letters A-Z and a-z, as well as 0-9
$from_who="$name <$email>";

$pagetitle="Thank You for applying!"; // Title to be displayed on the sent info page.

// Enter the code that you want to appear before the information submitted.
// Make sure you put a / mark before all double quotation marks or the script won't work.
// the \n at the end of the line is to create a new line in the HTML SOURCE. It DOES NOT create a break or new line
// when viewing it on the internet. Put these at the end of each line in the header and footer if you wish.
// They aren't required.

$header = "<!-- Begin Header -->\n
<table>\n
 <tr>\n
  <td bgcolor=\"000000\"><font color=\"FFFFFF\" size=\"2\" face=\"verdana\">\n
<!-- End Header -->\n";

// Enter the code you'd like displayed after the information submitted.
// Make sure you put a / mark before all double quotation marks or the script won't work.
// the \n at the end of the line is to create a new line in the HTML SOURCE. It DOES NOT create a break or new line
// when viewing it on the internet. Put these at the end of each line in the header and footer if you wish.
// They aren't required.

$footer = "<!-- Begin Footer -->\n
</td></tr></table>\n
<!-- End Footer -->\n";

// Edit the following lines to customize how the email sent to you will look.
// To add more fields, just copy and paste the line, and edit the info between the " marks.
// The last 2 lines will send the users browser information and their ip number with the mail.
// Just in case. :)

$mailbody="Position Applying For:\n=================\n$Position\n\n";
$mailbody.="Requirements Met(Yes=all,no=none,some=some, not all):\n=================\n$r_yesno\n\n";
$mailbody.=stripslashes("Name:\n=================\n$name\n\n");
$mailbody.=stripslashes("ID Line:\n=================\n$idline\n\n");$mailbody.="Email:\n=================\n$email\n\n";
$mailbody.="IRC Nick:\n=================\n$ircnick\n\n";
$mailbody.="Has s/he taken the CH Test?\n=================\n$chtest\n\n";
$mailbody.="If YES, Score:\n=================\n$score\n\n";
$mailbody.="Other Citadel/IWATS Courses:\n=================\n$citadel\n\n";
$mailbody.="Experience:\n=================\n$experience\n\n";
$mailbody.="Other Skills:\n=================\n$skills\n\n";
$mailbody.="Why you want this position:\n=================\n$whyposition\n\n";


// This code gets the ip address of the person submiting the form.
// You shouldn't remove it if you want to use this feature.
if (getenv(HTTP_CLIENT_IP)){ 
$user_ip=getenv(HTTP_CLIENT_IP); 
} 
else { 
$user_ip=getenv(REMOTE_ADDR); 
}

mail("$youremail", "$emailsubject", "$mailbody", "From: $from_who");  // Send the email.

// Page HTML comes next.
?>
<html>
<head>
<title><?php $pagetitle ?></title>
</head>
<body>
<?php print $header;
// A note about the following.
// Each of the printed values here correspond to a field in the form.
// Change this area if you change what fields are in the form.
?>
Submitted information:<br><br>
Position Applying For: <?php print($Position); ?><br>
Requirements Met? <?php print($r_yesno); ?><br>
Name: <?php print stripslashes($name); ?><br>
Your email address is <a href="mailto:<?php print $email; ?>"><?php print $email; ?></a><br>
IRC Nick(s): <?php print($ircnick); ?><br>
ID Line: <?php print stripslashes($idline); ?><br>
Other Subgroup ID Lines: <?php print stripslashes($sgid); ?><br>
CH Test(yes/no)? <?php print($chtest); ?><br>
Score? <?php print($score); ?><br>
Other Citadel Courses: <?php print($citadel); ?><br>
Experience: <?php print($experience); ?><br>
Other Skills: <?php print($skills); ?><br>
Why they want the position: <?php print($whyposition); ?>
<?php print $footer; ?>

<!-- DO NOT EDIT BELOW THIS LINE. -->
<!-- DO NOT EDIT BELOW THIS LINE. -->

<?php
// This is a free script, PLEASE leave my copyright notice.
$date=date("Y");
if ($date==2001){
  echo "<br>\n<font size=\"1\" face=\"verdana\">\nThis script is Copyright &copy;";
  echo (date("Y"));
  echo "&nbsp;Steven \"<a href=\"mailto:defender@3dartisan.net\">Defender</a>\" Cunningham\n";
}
else
{
print "<br>\n<font size=\"1\" face=\"verdana\">\nThis script is Copyright &copy; 2001-";
print (date("Y"));
print "&nbsp;Steven \"<a href=\"mailto:defender@3dartisan.net\">Defender</a>\" Cunningham\n";
}
?>
<!-- DO NOT EDIT THE ABOVE LINES -->
<!-- DO NOT EDIT THE ABOVE LINES -->
</body>
</html>
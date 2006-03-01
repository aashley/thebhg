<div><h2>Section XIV: Choosing a Kabal</h2>
<p>Congratulations! You are almost done with your orientation into the BHG. Now comes the most important part of your tenure in the Citadel: choosing your Kabal. Once you have completed your graduation requirements, you will automatically be promoted to the position of Hunter. At this time, you will need to e-mail the Underlord with your Kabal of choice. If you don’t e-mail him, then he will place you where he sees fit. Therefore, it is very important that you know what Kabal you want to join by the time you graduate! Do whatever is necessary to make your decision an easy one. Visit Kabal websites, talk to Chiefs and other members, and basically see what they’re all about. Here is information about each Kabal to get you started:
</p>
<?php

include_once 'library.inc';

$roster = new Roster();
$kabals = $roster->GetKabals();

$chapter = 123;
foreach ($kabals as $kabal) {
	$name = $kabal->GetName();
	$ch = $kabal->GetChief();
	$ch_name = $ch->GetName();
	$ch_email = $ch->GetEmail();
	$cra = $kabal->GetCRA();
	$cra_name = $cra->GetName();
	$cra_email = $cra->GetEmail();
	$slogan = $kabal->GetSlogan();
	$url = $kabal->GetURL();
	$logo = $kabal->GetLogoURL();
	
	print "<p><table border=1 align=center width=90% cellpadding=4 cellspacing=0 style=\"border-collapse: collapse;\">";
	print "<tr class=\"tbl_head\"><td align=center>".$name." Kabal</td></tr>";
	print "<tr><td><p>";
	print "<img src=\"".$logo."\" align=left height=60>";
	print "<b>Chief:</b> <a href=\"mailto:".$ch_email."\">".$ch_name."</a>";
	print "<br><b>CRA:</b> <a href=\"mailto:".$cra_email."\">".$cra_name."</a>";
	print "<br><b>Slogan:</b> <i>".$slogan."</i>";
	print "<br><b>Homepage:</b> <a href=\"".$url."\">".$url."</a>";
	print "</p></td></tr>";
	print "<tr><td><p>".KabalInfo($chapter)."</p></td></tr>";
	print "</table></p>";
	
	$chapter++;
}

function KabalInfo($id) {
	$chapter = new Chapter($id);
	$sections = $chapter->GetSections();
	foreach ($sections as $section) {
		$text .= $section->GetBody();
	}
	if ($text) {
		return $text;
	} else {
		return "No information on this Kabal.";
	}
}
?></div>
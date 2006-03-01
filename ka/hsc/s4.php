<?php

$roster = new Roster();
$kabals = $roster->GetKabals();
$arr_count = count($kabals)-1;

foreach ($kabals as $i => $kabal) {
	$name = $kabal->GetName();
	$url = $kabal->GetURL();
	if ($i < $arr_count) {
		$kabal_list .= "<a href=\"".$url."\" target=\"_blank\">".$name."</a>, ";
	} else {
		$kabal_list .= "and <a href=\"".$url."\" target=\"_blank\">".$name."</a>";
	}
}

?>

<div><h2>Section IV: Structure of the BHG</h2>
<p>Since the founding of the Bounty Hunters Guild, numerous changes have been made to its <font color=#FF0000>Structure</font>. A few general constants have remained, but those have even changed, if just in name. We will now discuss the overall structure of the BHG and how each section works to define our Subgroup.
</p>
<p>All the active members of the BHG are split into three basic groups:
</p>
<blockquote><b><u>Commission:</u></b>
<br>This group is analogous to the Command Staff of the Emperor’s Hammer. It serves as the governing body over the members and activities that go on within the BHG. The head of the Commission is the <font color=#FF0000>Dark Prince [DP]</font>, who answers directly to the Fleet Commander of the EH. The Dark Prince has a team of peers who serve in various aspects of the BHG, and there is even a tier below those called the <font color=#FF0000>Commission Assistants</font> who take supporting roles and duties. Get to know who the members of the Commission are and you will be a giant step further in your career. Check the <a href="http://holonet.thebhg.org/" target="_blank">Holonet</a> for the current members.
</blockquote>
<blockquote><b><u>Kabal Authority [KA]:</u></b>
<br>Most of the active Hunters in the BHG fall into this Division. Once you graduate from the Citadel, this is where you will find yourself. Currently it houses the following Kabals: <?php echo $kabal_list; ?>. When you become a Hunter, you can choose one of these Kabals to join, and it will become your home until you leave the BHG or perhaps move on to higher positions. Each Kabal is run by a <font color=#FF0000>Chief [CH]</font> with the assistant help of his <font color=#FF0000>Chief’s Right Arm [CRA]</font>. Competition is commonplace among the Kabals, so be prepared.
</blockquote>	
<blockquote><b><u>The Citadel:</u></b>
<br>The Citadel is where you are currently housed. Once called the Nideavoot Tsayad College, the Citadel has replaced it as the training grounds for Trainees and even Hunters. While you are here and even after you move on to a Kabal, you will always have the opportunity to take numerous Courses at the Citadel. Simply visit the web site and browse the available tests.
</blockquote>
<p>Here are a few other groups within the BHG that you should be aware of:
</p>
<blockquote><b><u>Cadres:</u></b>
<br>Once a Hunter reaches the rank of <font color=#FF0000>Baron [BRN]</font>, he or she is allowed to have a cadre of other Hunters, forming a unique team that often works together. We will discuss the rank of Baron later, but know that Cadres exist. Not really contributing to the overall structure of the BHG, Cadres are used for role playing and activity purposes.
</blockquote>
<blockquote><b><u>Retirees:</u></b>
<br>Retirees are Hunters who have served out their time in the BHG and moved on to other things. They have ended their tenure honorably and thus are allowed to have their name placed in the Retirees list. Many famous Hunters are listed here.
</blockquote>
<blockquote><b><u>Unassigned Pool [UAP]:</u></b>
<br>Hunters in the Unassigned Pool have no Kabal affiliation; however, if they remain in the UAP for more than two weeks, they are automatically moved to the Disavowed List. When a Hunter is declared <font color=#FF0000>AWOL [Absent Without Leave]</font> he or she is moved here to be allotted the chance to rejoin their Kabal before being Disavowed.
</blockquote>
<blockquote><b><u>Disavowed:</u></b>
<br>You do not want to end up on this list. Disavowed Hunters lose all their medals as well as their ability to do anything within the BHG. Hunters who are AWOL or have been kicked out the EH/BHG are placed here. The list is unfortunately extensive, and little to no chance stands of a Hunter ever being allowed to return from Disavowed status.
</blockquote></div>
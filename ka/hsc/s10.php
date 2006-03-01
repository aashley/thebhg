<div><h2>Section X: The Citadel</h2>
<p>The <font color=#FF0000>Citadel</font> is the central training ground of the Bounty Hunters Guild. Its main focus is the training of new members; however, Hunters who have moved out of the Citadel can also find new things to learn there. <font color=#FF0000>Courses</font> are written to teach both new and old members skills and information important to the bounty hunter. Here is a current list of the courses currently offered by the Citadel:
</p>
<ul>
<?php

include_once "citadel.inc";

$citadel = new Citadel();
$exams = $citadel->GetExams();

foreach ($exams as $exam) {
	$name = $exam->GetName();
	$abbrev = $exam->GetAbbrev();
	
	print "<li>".$name." [".$abbrev."]</li>";
}

?>
</ul>
<p>To learn more about each course - or perhaps take an exam - then visit the <a href="http://citadel.thebhg.org/" target="_blank">Citadel website</a>.
</p>
<p>As a Trainee, the Citadel will be your first "home" in the BHG. Here is where you will start out your career, creating the foundation of your bounty hunter persona. While remaining in the Citadel for an extended period of time is discouraged, you still want to take the necessary time to acquaint yourself with everything encompassed by the BHG. This way, when you do finally move on to a Kabal, you will be fully trained and a better asset to your team. You can read more about the Citadel in the <a href="http://holonet.thebhg.org/index.php?module=library&page=chapter&id=22" target="_blank">Hunter’s Manual, Chapter 9</a>.
</p>
<p>And remember... once you leave the Citadel, you can still take exams! They are a great way to improve yourself and increase your IC account in the meantime.
</p></div>
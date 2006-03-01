<div><h2>Section VIII: Commission</h2>
<p>In Section IV, you briefly learned about the Commission and what their role is in the Bounty Hunters Guild. Now you will learn about each Commission member: who currently holds the position and what their individual duties entail. Here is the list of the current Commission members and their e-mail addresses:
</p>
<hr size=1 width=90%>
<table border=1 align=center cellpadding=4 cellspacing=0 style="border-collapse: collapse;">
<?php

$roster = new Roster();

$divcat = $roster->GetDivisionCategory(3);
$div_objs = $divcat->GetDivisions();

foreach ($div_objs as $div) {
	$div_name = $div->GetName();
	
	print "<tr class=\"tbl_head\"><td colspan=3 align=center>".$div_name."</td></tr>";
	
	$plebs = $div->GetMembers('position');
	foreach ($plebs as $pleb) {
		$pos = $pleb->GetPosition();
		$pos_name = $pos->GetName();
		$pos_abbr = $pos->GetAbbrev();
		$email = $pleb->GetEmail();
		$name = $pleb->GetName();
		
		print "<tr>
		<td>".$pos_name." [".$pos_abbr."]</td>
		<td>".$name."</td>
		<td><a href=\"mailto:".$email."\">".$email."</a></td>
		</tr>";
	}
}

?>
</table>
<hr size=1 width=90%>
<p>To read about the duties of each position, visit the <a href="http://holonet.thebhg.org/index.php?module=library&page=chapter&id=2" target="_blank">Hunter’s Manual, Chapter 3</a>.
</p>
<p>Take the time to learn the members of the Commission and their duties. It will easily make your time in the BHG easier, especially if you have questions about certain aspects of the subgroup. Instead of searching around for the answer, you will know directly who to contact.
</p></div>
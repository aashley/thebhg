<?php
function title() {
	return 'Index';
}

function output() {
	global $roster;
	
	roster_header();
	
	$quote_result = mysql_query('SELECT id, name, quote FROM roster_roster WHERE quote<>"" ORDER BY RAND() LIMIT 1', $roster->roster_db);
	$quote = html_escape(stripslashes(mysql_result($quote_result, 0, 'quote')));
	$quoter = '<a href="' . internal_link('hunter', array('id'=>mysql_result($quote_result, 0, 'id'))) . '">' . html_escape(stripslashes(mysql_result($quote_result, 0, 'name'))) . '</a>';

	$underlord = $roster->SearchPosition(2);
	$koral = htmlspecialchars($roster->GetPerson(94)->GetName());
	if (count($underlord) > 0) {
		$uID = $underlord[0]->GetID();
		$uName = htmlspecialchars($underlord[0]->GetName());
	}
	else {
		$uID = 94;
		$uName = $koral;
	}

	echo <<<EOT
To a hunter in the Bounty Hunter's Guild, Imperial Credits are everything. They are the lifeblood of their very existence. To some, the accumulation of wealth is a means of bragging their superiority. To others, it is a mark of honor, that only definitive mark of a hunter's standing. However, to the select few - to the select best - Imperial Credits hold none of these meanings. ICs are simply a means to an end. They are nothing more than the only real and efficient way to completing a bounty hunt and tracking down your target.
<br><br>
Welcome to the always-updated and current roster of the BHG. The roster was created by former Underlord $koral and is maintained by Underlord $uName. This is the only place where you can gauge your worthiness and honor by seeing how many ICs you have earned and accumulated over your dubious BHG career as a bounty hunter, and is also the only place where you can wallow in self pity as your hunter brethren pass you by in rank and honor because of numerous failures, bumbles, and general inactivity you have shown.
<br><br>
Your IPKC has cleared the security check: you are who you claim to be.You have permission to proceed. View your status in the BHG, hunter. And always remember these words: <i>$quote</i> - $quoter 
EOT;
	
	hr();
	show_search_form();
	roster_footer();
}
?>

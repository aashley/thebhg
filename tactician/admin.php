<?php
include('header.php');
include('auth.php');

$pos = $login->GetPosition();
if ($login->GetID() == 666 || $pos->GetID() == 3 || $pos->GetID() == 7) {
	switch ($op) {
		case 'add':
			add();
			break;
		case 'save':
			save();
			break;
		case 'del':
			del();
			break;
		case 'zap':
			zap();
			break;
		case 'choose':
			choose();
			break;
		case 'edit':
			edit();
			break;
		case 'saveedit':
			saveedit();
			break;
		case 'choosemark':
			choosemark();
			break;
		case 'mark':
			mark();
			break;
		case 'savemark':
			savemark();
			break;
		case 'selectom':
			selectom();
			break;
		case 'omcredits':
			omcredits();
			break;
		case 'hide':
			hide();
			break;
		case 'unhide':
			unhide();
			break;
		case 'romulan':
			romulan();
			break;
		default:
			index();
	}
}
else {
	page_header('Administration');
	echo 'You are not authorised to administer this site.';
	page_footer();
}

function index() {
	global $PHP_SELF;

	page_header('Administration');

	echo <<<EOI
<UL>
<LI><A HREF="$PHP_SELF?op=add">Add New Mission</A>
<LI><A HREF="$PHP_SELF?op=del">Delete A Mission</A>
<LI><A HREF="$PHP_SELF?op=choose">Edit A Mission</A>
<LI><A HREF="$PHP_SELF?op=hide">Hide A Mission Set</A>
<LI><A HREF="$PHP_SELF?op=unhide">Unhide A Mission Set</A>
<LI><A HREF="mlist.php?complete=2">View Hidden Missions</A>
<LI><A HREF="$PHP_SELF?op=choosemark">Mark A Mission</A>
<LI><A HREF="$PHP_SELF?op=selectom">Get Credits For OM Set</A>
<LI><A HREF="news-admin.php">News Administration</A>
</UL>
EOI;

	page_footer();
}

function add() {
	global $PHP_SELF;
	
	page_header('Add New Mission');

	echo <<<EOA
<FORM NAME="add" METHOD="post" ACTION="$PHP_SELF">
<INPUT TYPE="hidden" NAME="op" VALUE="save">
<TABLE>
<TR VALIGN="top"><TD>Mission set:</TD><TD><INPUT TYPE="text" NAME="mset" SIZE="3"></TD></TR>
<TR VALIGN="top"><TD>Author:</TD><TD><SELECT NAME="author" SIZE="1">
EOA;
	hunter_dropdown();
	echo <<<EOA
</SELECT></TD></TR>
<TR VALIGN="top"><TD>Title:</TD><TD><INPUT TYPE="text" NAME="title" SIZE="30"></TD></TR>
<TR VALIGN="top"><TD>Mission:</TD><TD><TEXTAREA NAME="text" ROWS="10" COLS="60"></TEXTAREA><BR><SPAN STYLE="font-size: 8pt">This must be valid HTML. Remember that the mission page will provide the &lt;HTML&gt; and &lt;BODY&gt; tags, so they're not needed here.</SPAN></TD></TR>
<TR VALIGN="top"><TD>Is the mission complete:</TD><TD><INPUT TYPE="checkbox" NAME="complete" VALUE="on"></TD></TR>
<TR VALIGN="top"><TD>Answer:</TD><TD><TEXTAREA NAME="answer" ROWS="10" COLS="60"></TEXTAREA><BR><SPAN STYLE="font-size: 8pt">The answer to the mission, and usually the reasoning behind it too, goes here. This also must be valid HTML.</SPAM></TD></TR>
<TR VALIGN="top"><TD>Results:</TD><TD><TEXTAREA NAME="results" ROWS="10" COLS="60"></TEXTAREA><BR><SPAN STYLE="font-size: 8pt">The results of the mission for each hunter (usually just a copy of what you send the Underlord: who won what) go here. This doesn't need to be valid HTML, as line-breaks will be added at the end of each line, since this is normally plain text.</SPAN></TD></TR>
<TR VALIGN="top"><TD>Hidden:</TD><TD><INPUT TYPE="checkbox" NAME="hidden" VALUE="on" CHECKED></TD></TR>
</TABLE>
<INPUT TYPE="submit" VALUE="Add Mission">&nbsp;<INPUT TYPE="reset">
</FORM>
EOA;

	page_footer();
}

function save() {
	global $PHP_SELF, $db, $mset, $author, $title, $text, $answer, $results, $complete, $hidden;

	page_header('Add New Mission');

	$mset = (int) ($mset);
	$author = (int) ($author);
	$title = addslashes($title);
	$text = addslashes($text);
	$answer = addslashes($answer);
	$results = addslashes($results);
	$hidden = ($hidden == 'on' ? '1' : '0');
	$complete = ($complete == 'on' ? '1' : '0');

	if (mysql_query("INSERT INTO missions (mset, author, title, text, answer, complete, results, hidden) VALUES ($mset, $author, '$title', '$text', '$answer', $complete, '$results', $hidden)", $db)) {
		echo 'Mission added successfully.';
	}
	else {
		echo 'Error adding mission: ' . mysql_error($db);
	}

	page_footer();
}

function del() {
	global $db, $PHP_SELF;
	
	page_header('Delete Mission');

	echo "Select the mission to delete:<BR><BR>\n";
	$missions_result = mysql_query("SELECT * FROM missions ORDER BY mset DESC, title ASC", $db);
	if ($missions_result && mysql_num_rows($missions_result)) {
		while ($mission = mysql_fetch_array($missions_result)) {
			if (empty($lastset) || $mission['mset'] != $lastset) {
				if (isset($lastset)) {
					echo "</UL><BR><HR NOSHADE><BR>\n";
				}
				$lastset = $mission['mset'];
				echo "<U>Mission Set $lastset</U><BR><UL>\n";
			}
			echo "<LI><A HREF=\"$PHP_SELF?op=zap&amp;id=" . $mission['id'] . '">' . stripslashes($mission['title']) . "</A>\n";
		}
	}
	else {
		echo 'No missions found.';
	}
	echo '</UL>';

	page_footer();
}

function zap() {
	global $db, $PHP_SELF, $id;

	page_header('Delete Mission');

	if (mysql_query("DELETE FROM missions WHERE id=$id", $db)) {
		echo 'Mission deleted successfully.';
	}
	else {
		echo 'Error deleting mission: ' . mysql_error($db);
	}

	page_footer();
}

function choose() {
	global $db, $PHP_SELF;

	page_header('Edit Mission');

	echo "Select the mission to edit:<BR><BR>\n";
	$missions_result = mysql_query("SELECT * FROM missions ORDER BY mset DESC, title ASC", $db);
	if ($missions_result && mysql_num_rows($missions_result)) {
		while ($mission = mysql_fetch_array($missions_result)) {
			if (empty($lastset) || $mission['mset'] != $lastset) {
				if (isset($lastset)) {
					echo "</UL><BR><HR NOSHADE><BR>\n";
				}
				$lastset = $mission['mset'];
				echo "<U>Mission Set $lastset</U><BR><UL>\n";
			}
			echo "<LI><A HREF=\"$PHP_SELF?op=edit&amp;id=" . $mission['id'] . '">' . stripslashes($mission['title']) . "</A>\n";
		}
	}
	else {
		echo 'No missions found.';
	}
	echo '</UL>';

	page_footer();
}

function edit() {
	global $db, $PHP_SELF, $id;

	page_header('Edit Mission');

	$mission_result = mysql_query("SELECT * FROM missions WHERE id=$id", $db);

	if ($mission_result && mysql_num_rows($mission_result)) {
		$mission = mysql_fetch_array($mission_result);
		$mset = $mission['mset'];
		$author = $mission['author'];
		$title = stripslashes($mission['title']);
		$text = stripslashes($mission['text']);
		$answer = stripslashes($mission['answer']);
		$results = stripslashes($mission['results']);
		
		echo <<<EOA
<FORM NAME="edit" METHOD="post" ACTION="$PHP_SELF">
<INPUT TYPE="hidden" NAME="op" VALUE="saveedit">
<INPUT TYPE="hidden" NAME="id" VALUE="$id">
<TABLE>
<TR VALIGN="top"><TD>Mission set:</TD><TD><INPUT TYPE="text" NAME="mset" VALUE="$mset" SIZE="3"></TD></TR>
<TR VALIGN="top"><TD>Author:</TD><TD><SELECT NAME="author" SIZE="1">
EOA;
	hunter_dropdown(array(0, 16), $author);
	echo <<<EOA
</SELECT></TD></TR>
<TR VALIGN="top"><TD>Title:</TD><TD><INPUT TYPE="text" NAME="title" VALUE="$title" SIZE="30"></TD></TR>
<TR VALIGN="top"><TD>Mission:</TD><TD><TEXTAREA NAME="text" ROWS="10" COLS="60">$text</TEXTAREA><BR><SPAN STYLE="font-size: 8pt">This must be valid HTML. Remember that the mission page will provide the &lt;HTML&gt; and &lt;BODY&gt; tags, so they're not needed here.</SPAN></TD></TR>
<TR VALIGN="top"><TD>Is the mission complete:</TD><TD>
EOA;
		echo '<INPUT TYPE="checkbox" NAME="complete" VALUE="on"' . ($mission['complete'] == 1 ? ' CHECKED' : '') . "></TD></TR>\n";
		echo <<<EOA
<TR VALIGN="top"><TD>Answer:</TD><TD><TEXTAREA NAME="answer" ROWS="10" COLS="60">$answer</TEXTAREA><BR><SPAN STYLE="font-size: 8pt">The answer to the mission, and usually the reasoning behind it too, goes here. This also must be valid HTML.</SPAM></TD></TR>
<TR VALIGN="top"><TD>Results:</TD><TD><TEXTAREA NAME="results" ROWS="10" COLS="60">$results</TEXTAREA><BR><SPAN STYLE="font-size: 8pt">The results of the mission for each hunter (usually just a copy of what you send the Underlord: who won what) go here. This doesn't need to be valid HTML, as line-breaks will be added at the end of each line, since this is normally plain text.</SPAN></TD></TR>
EOA;
		echo '<TR><TD>Hidden:</TD><TD><INPUT TYPE="checkbox" NAME="hidden" VALUE="on"' . ($mission['hidden'] == 1 ? ' CHECKED' : '') . "></TD></TR>\n";
		echo <<<EOA
</TABLE>
<INPUT TYPE="submit" VALUE="Save Mission">&nbsp;<INPUT TYPE="reset">
</FORM>
EOA;
	}
	else {
		echo 'Cannot find that mission.';
	}

	page_footer();
}

function saveedit() {
	global $db, $PHP_SELF, $id, $mset, $author, $title, $text, $complete, $answer, $results, $hidden;

	page_header('Edit Mission');

	$id = (int) $id;
	$mset = (int) $mset;
	$author = (int) $author;
	$title = addslashes($title);
	$text = addslashes($text);
	$complete = (isset($complete) && $complete == 'on' ? 1 : 0);
	$answer = addslashes($answer);
	$results = addslashes($results);
	$hidden = ($hidden == 'on' ? '1' : '0');

	if (mysql_query("UPDATE missions SET mset=$mset, author=$author, complete=$complete, title='$title', text='$text', answer='$answer', results='$results', hidden=$hidden WHERE id=$id", $db)) {
		echo 'Mission updated successfully.';
	}
	else {
		echo 'Error updating mission: ' . mysql_error($db);
	}

	page_footer();
}

function hide() {
	global $db, $PHP_SELF;

	page_header('Hide A Mission Set');

	$set_result = mysql_query('SELECT mset FROM missions GROUP BY mset ORDER BY mset DESC', $db);
	if ($set_result && mysql_num_rows($set_result)) {
		echo "<FORM NAME=\"hide\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n<INPUT TYPE=\"hidden\" NAME=\"op\" VALUE=\"romulan\"><INPUT TYPE=\"hidden\" NAME=\"hide\" VALUE=\"1\">\nOM Set: <SELECT NAME=\"set\">\n";
		while ($set = mysql_fetch_array($set_result)) {
			$om_set = $set['mset'];
			echo "<OPTION VALUE=\"$om_set\">OM Set $om_set</OPTION>\n";
		}
		echo "</SELECT><BR><BR>\n<INPUT TYPE=\"submit\" VALUE=\"Activate Cloaking Device\">\n</FORM>\n";
	}

	page_footer();
}

function unhide() {
	global $db, $PHP_SELF;

	page_header('Reveal A Mission Set');

	$set_result = mysql_query('SELECT mset FROM missions GROUP BY mset ORDER BY mset DESC', $db);
	if ($set_result && mysql_num_rows($set_result)) {
		echo "<FORM NAME=\"hide\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n<INPUT TYPE=\"hidden\" NAME=\"op\" VALUE=\"romulan\"><INPUT TYPE=\"hidden\" NAME=\"hide\" VALUE=\"0\">\nOM Set: <SELECT NAME=\"set\">\n";
		while ($set = mysql_fetch_array($set_result)) {
			$om_set = $set['mset'];
			echo "<OPTION VALUE=\"$om_set\">OM Set $om_set</OPTION>\n";
		}
		echo "</SELECT><BR><BR>\n<INPUT TYPE=\"submit\" VALUE=\"Disable Cloaking Device\">\n</FORM>\n";
	}

	page_footer();
}

function romulan() {
	global $hide, $set, $db, $PHP_SELF;

	page_header('(De-)Cloak');

	if (mysql_query("UPDATE missions SET hidden=$hide WHERE mset=$set", $db)) {
		echo 'Those damned Romulans have done something with their cloaking device.';
	}
	else {
		echo 'Crap. The cloaking device won\'t change state.';
	}

	page_footer();
}

function choosemark() {
	global $db, $PHP_SELF;

	page_header('Mark Mission');

	$missions_result = mysql_query('SELECT * FROM missions WHERE complete=0 ORDER BY mset, title', $db);
	if ($missions_result && mysql_num_rows($missions_result)) {
		$last_mset = 0;
		while ($mission = mysql_fetch_array($missions_result)) {
			if ($mission['mset'] != $last_mset) {
				$last_mset = $mission['mset'];
				echo "<U>Mission Set $last_mset</U><BR><BR>\n";
			}
			echo "<A HREF=\"$PHP_SELF?op=mark&amp;id=" . $mission['id'] . '">' . stripslashes($mission['title']) . "</A><BR>\n";
		}
	}
	else {
		echo "<BR><HR NOSHADE><BR>\nNo active missions found.<BR>\n" . mysql_error($db);
	}

	page_footer();
}

function mark() {
	global $db, $PHP_SELF, $id, $roster;

	$mission_result = mysql_query("SELECT * FROM missions WHERE id=$id", $db);
	if ($mission_result && mysql_num_rows($mission_result)) {
		$mission = mysql_fetch_array($mission_result);
		page_header('Mark Mission' . stripslashes($mission['title']));
		$answers_result = mysql_query("SELECT * FROM answers WHERE mission=$id ORDER BY id ASC", $db);
		if ($answers_result && mysql_num_rows($answers_result)) {
			echo "<FORM NAME=\"mark\" METHOD=\"post\" ACTION=\"$PHP_SELF\">\n<INPUT TYPE=\"hidden\" NAME=\"op\" VALUE=\"savemark\">\n<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"$id\">\n";
			echo '<TABLE BORDER="0"><TR VALIGN="top"><TD>Answer:</TD><TD><TEXTAREA NAME="answer" COLS="60" ROWS="10">' . stripslashes($mission['answer']) . "</TEXTAREA></TD></TR></TABLE><BR><BR>\n";
			echo "<TABLE BORDER=\"1\">\n";
			while ($answer = mysql_fetch_array($answers_result)) {
				$pleb = $roster->GetPerson($answer['person']);
				echo '<TR VALIGN="top"><TD>' . $pleb->GetName() . '</TD><TD>' . nl2br(htmlspecialchars(stripslashes($answer['answer'])));
				if (strlen($answer['reason'])) {
					echo '<HR NOSHADE>' . nl2br(htmlspecialchars(stripslashes($answer['reason'])));
				}
				echo '</TD><TD><INPUT TYPE="radio" NAME="result[' . $answer['id'] . ']" VALUE="1">&nbsp;Correct<BR><INPUT TYPE="radio" NAME="result[' . $answer['id'] . ']" VALUE="0" CHECKED>&nbsp;Incorrect<BR><INPUT TYPE="radio" NAME="result[' . $answer['id'] . ']" VALUE="2">&nbsp;No Effort<BR><INPUT TYPE="checkbox" NAME="bonus[' . $answer['id'] . "]\" VALUE=\"on\">&nbsp;50k&nbsp;Bonus</TD></TR>\n";
			}
			echo "</TABLE><BR>\n<INPUT TYPE=\"submit\" VALUE=\"Mark Mission\">&nbsp;&nbsp;<INPUT TYPE=\"reset\">\n<BR>";
		}
		else {
			echo 'No answers submitted.<BR>' . mysql_error($db);
		}
	}
	else {
		page_header('Mark Mission');
		echo 'Mission not found.<BR>' . mysql_error($db);
	}

	page_footer();
}

function savemark() {
	global $db, $PHP_SELF, $id, $result, $bonus, $roster, $answer;

	$mission_result = mysql_query("SELECT * FROM missions WHERE id=$id", $db);
	if ($mission_result && mysql_num_rows($mission_result)) {
		$mission = mysql_fetch_array($mission_result);
		page_header('Mark Mission' . stripslashes($mission['title']));
		$first_correct = true;
		foreach ($result as $aid=>$correct) {
			if ($correct == 1) {
				$ans = mysql_query("SELECT * FROM answers WHERE id=$aid", $db);
				$pleb = $roster->GetPerson(mysql_result($ans, 0, 'person'));
				if ($first_correct) {
					$first_correct = false;
					$results .= "<U>First correct answer (75k + HP)</U>\n\n";
					$results .= $pleb->IDLine(0) . "\n\n<U>Correct answers (50k)</U>\n\n";
				}
				else {
					$results .= $pleb->IDLine(0) . "\n";
				}
				mysql_query("UPDATE answers SET correct=1 WHERE id=$aid", $db);
			}
		}
		reset($result);
		$results .= "\n<U>Incorrect answers (15k)</U>\n\n";
		foreach ($result as $aid=>$correct) {
			if ($correct == 0) {
				$ans = mysql_query("SELECT * FROM answers WHERE id=$aid", $db);
				$pleb = $roster->GetPerson(mysql_result($ans, 0, 'person'));
				$results .= $pleb->IDLine(0) . "\n";
				mysql_query("UPDATE answers SET correct=0 WHERE id=$aid", $db);
			}
		}
		reset($result);
		$results .= "\n<U>No effort</U>\n\n";
		foreach ($result as $aid=>$correct) {
			if ($correct == 2) {
				$ans = mysql_query("SELECT * FROM answers WHERE id=$aid", $db);
				$pleb = $roster->GetPerson(mysql_result($ans, 0, 'person'));
				$results .= $pleb->IDLine(0) . "\n";
				mysql_query("UPDATE answers SET correct=2 WHERE id=$aid", $db);
			}
		}
		$results .= "\n<U>Bonus for good report (30k)</U>\n\n";
		foreach ($bonus as $aid=>$on) {
			$ans = mysql_query("SELECT * FROM answers WHERE id=$aid", $db);
			$pleb = $roster->GetPerson(mysql_result($ans, 0, 'person'));
			$results .= $pleb->IDLine(0) . "\n";
			mysql_query("UPDATE answers SET bonus=1 WHERE id=$aid", $db);
		}
		
		$results = addslashes($results);
		$answer = addslashes($answer);
		mysql_query("UPDATE missions SET answer='$answer', results='$results', complete=1 WHERE id=$id", $db);
		echo nl2br($results);
	}
	
	page_footer();
}

function selectom() {
	global $db, $PHP_SELF;

	page_header('OM Credits');

	$set_result = mysql_query('SELECT mset FROM missions GROUP BY mset ORDER BY mset DESC', $db);
	if ($set_result && mysql_num_rows($set_result)) {
		echo "<FORM NAME=\"om\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n<INPUT TYPE=\"hidden\" NAME=\"op\" VALUE=\"omcredits\">\nOM Set: <SELECT NAME=\"set\">\n";
		while ($set = mysql_fetch_array($set_result)) {
			$om_set = $set['mset'];
			echo "<OPTION VALUE=\"$om_set\">OM Set $om_set</OPTION>\n";
		}
		echo "</SELECT><BR><INPUT TYPE=\"checkbox\" NAME=\"add_ics\" VALUE=\"on\"> Automatically add credits<BR><INPUT TYPE=\"checkbox\" NAME=\"add_medals\" VALUE=\"on\"> Automatically add medals<BR><BR>\n<INPUT TYPE=\"submit\" VALUE=\"Go, go, gadgetmobile!\">\n</FORM>\n";
	}

	page_footer();
}

function omcredits() {
	global $db, $roster, $set, $add_ics, $add_medals, $tactician, $mb;

	page_header('OM Set ' . $set . ' Credits');

	$mission_result = mysql_query("SELECT answers.mission, answers.person, answers.correct, answers.bonus FROM answers, missions WHERE answers.mission=missions.id AND missions.mset=$set ORDER BY answers.mission ASC, answers.id ASC", $db);
	if ($mission_result && mysql_num_rows($mission_result)) {
		$last_mission = 0;
		$new_mission = 1;
		while ($answer = mysql_fetch_array($mission_result)) {
			if ($last_mission != $answer['mission']) {
				$last_mission = $answer['mission'];
				$new_mission = 1;
			}
			if ($answer['correct'] == 1) {
				if ($new_mission) {
					$new_mission = 0;
					$add = 75000;
					$hp[] = $answer['person'];
				}
				else {
					$add = 50000;
				}
				$plebs[$answer['person']] += $add;
			}
			elseif ($answer['correct'] == 0) {
				$plebs[$answer['person']] += 15000;
			}
			if ($answer['bonus']) {
				$plebs[$answer['person']] += 30000;
			}
		}
		echo "[OM Set $set]<BR>\n";
		foreach ($plebs as $rid=>$creds) {
			$pleb = $roster->GetPerson($rid);
			$div = $pleb->GetDivision();
			$divs[$div->GetName()][$pleb->GetName()] = $pleb->IDLine(0) . '/' . number_format($creds) . "<BR>\n";
			if ($add_ics) {
				echo 'I would try to add ' . number_format($creds) . ' ICs to ' . $pleb->GetName() . '\'s account here.<BR>';
				$pleb->AddCredits($creds, 'OM set ' . $set);
			}
		}
		ksort($divs);
		foreach ($divs as $div) {
			ksort($div);
			foreach ($div as $pleb) {
				echo $pleb;
			}
			echo "<BR>\n";
		}
		echo "<BR>[Hunter's Prides]<BR>\n";
		foreach ($hp as $rid) {
			$pleb = $roster->GetPerson($rid);
			echo $pleb->IDLine(0) . "<BR>\n";
			if ($add_medals) {
				$hp = next_medal($pleb, 12);
				echo 'I would try to award ' . $pleb->GetName() . ' with a ' . $hp->GetName() . ' here.<BR>';
				echo 'Old ID Line: ' . $pleb->IDLine() . '<BR>';
				if ($mb->AwardMedal($pleb, $tactician, $hp, 'OM set ' . $set)) {
					echo 'Medal awarded. New ID Line: ' . $pleb->IDLine() . '<BR><BR>';
				}
				else {
					echo 'Error adding medal: ' . $mb->Error() . '<BR><BR>';
				}
			}
		}
	}
	else {
		echo 'No missions found.';
	}

	page_footer();
}
?>

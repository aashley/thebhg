<?php
function title() {
	return 'Frequently Asked Questions';
}

function output() {
	global $db, $prefix;
	
	$sec_result = mysql_query('SELECT * FROM '.$prefix.'faq_sections ORDER BY after ASC', $db);
	if ($sec_result && mysql_num_rows($sec_result)) {
		echo '<OL>';
		while ($sec = mysql_fetch_array($sec_result)) {
			echo '<LI><A HREF="' . internal_link('faq_section', array('id'=>$sec['id'])) . '">' . htmlspecialchars(stripslashes($sec['name'])) . '</A>';
			$q_result = mysql_query('SELECT * FROM '.$prefix.'faq WHERE section=' . $sec['id'] . ' ORDER BY after ASC', $db);
			if ($q_result && mysql_num_rows($q_result)) {
				echo '<SMALL><OL TYPE="a">';
				while ($q = mysql_fetch_array($q_result)) {
					echo '<LI><A HREF="' . internal_link('faq_section', array('id'=>$sec['id']), false, $q['id']) . '">' . htmlspecialchars(stripslashes($q['question'])) . '</A>';
				}
				echo '</OL></SMALL>';
			}
		}
		echo '</OL>';
	}
	else {
		echo 'No questions found.';
	}
}
?>

<?php
function cover($year, $week) {
	global $roster, $db;
	
	issue_header();

	$dates = get_dates($year, $week);
	echo 'Released ' . date('j F Y', $dates['end'] + 1) . '.';

	$cover_result = mysql_query('SELECT * FROM aq_articles WHERE time ' . $dates['between'] . ' AND cover=1 ORDER BY title ASC', $db);
	if ($cover_result && mysql_num_rows($cover_result)) {
		while ($cover_row = mysql_fetch_array($cover_result)) {
			hr();
			
			$table = new Table();
			$table->AddRow('Title:', html_escape(stripslashes($cover_row['title'])));
			if (isset($column_row)) {
				$table->AddRow('Column:', html_escape(stripslashes($column_row['name'])));
			}
			$author = $roster->GetPerson($cover_row['author']);
			$table->AddRow('Author:', '<a href="' . internal_link('hunter', array('id'=>$author->GetID()), 'roster') . '">' . html_escape($author->GetName()) . '</a>');
			$table->EndTable();
			
			echo '<br>';
			
			echo nl2br(stripslashes($cover_row['content']));
		}
	}

	hr();

	$table = new Table('The Week That Was: Roster Statistics');
	$tca_result = mysql_query('SELECT SUM(item2) AS credits FROM roster_history WHERE date ' . $dates['between'] . ' AND type=6', $roster->roster_db);
	$table->AddRow('Total Credits Awarded:', number_format(mysql_result($tca_result, 0, 'credits')));
	$promo_result = mysql_query('SELECT COUNT(*) AS promotions FROM roster_history WHERE date ' . $dates['between'] . ' AND type=1 AND item1 != item2', $roster->roster_db);
	$table->AddRow('Promotions:', number_format(mysql_result($promo_result, 0, 'promotions')));
	$medal_result = mysql_query('SELECT COUNT(*) AS awards FROM roster_history WHERE date ' . $dates['between'] . ' AND type=8', $roster->roster_db);
	$table->AddRow('Medal Awards:', number_format(mysql_result($medal_result, 0, 'awards')));
	$nm_result = mysql_query('SELECT COUNT(*) AS members FROM roster_history WHERE date ' . $dates['between'] . ' AND type=9', $roster->roster_db);
	$table->AddRow('New Members:', number_format(mysql_result($nm_result, 0, 'members')));
	$awol_result = mysql_query('SELECT COUNT(*) AS members FROM roster_history WHERE date ' . $dates['between'] . ' AND type=10', $roster->roster_db);
	$table->AddRow('AWOLed Members:', number_format(mysql_result($awol_result, 0, 'members')));
	$name_result = mysql_query('SELECT COUNT(*) AS changes FROM roster_history WHERE date ' . $dates['between'] . ' AND type=4', $roster->roster_db);
	$table->AddRow('Name Changes:', number_format(mysql_result($name_result, 0, 'changes')));
	$table->EndTable();

	issue_footer($year, $week);
}
?>

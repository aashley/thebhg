<?php
include('header.php');

page_header();

function do_form($item) {
	// I too shall be directly accessing thebhg_roster here, since I need
	// the same functionality used in roster/hunt_list.php.
	$roster = new Roster('roster-69god');
	
	// Make divisions list
	$div_disp = '<SELECT NAME="division">';
	$divisions = mysql_db_query('thebhg_roster', 'SELECT * FROM roster_divisions ORDER BY name ASC', $roster->roster_db);
	if (mysql_num_rows($divisions)) {
		while ($div = mysql_fetch_array($divisions)) {
			$div_disp .= '<OPTION VALUE=' . $div['id'] . ($item->GetRestriction() == 3 && $item->GetMin() == $div['id'] ? ' SELECTED' : '') . ' NAME="' . $div['name'] . '">' . $div['name'] . '</OPTION>';
		}
	}
	$div_disp .= '</SELECT>';

	// Make rank lists
	$rank_disp_min = '<SELECT NAME="rank_min"><OPTION VALUE="-1" NAME="No minimum" ' . ($item->GetRestriction() == 1 && $item->GetMin == -1 ? ' SELECTED' : '') . '>No minimum</OPTION>';
	$rank_disp_max = '<SELECT NAME="rank_max"><OPTION VALUE="-1" NAME="No maximum" ' . ($item->GetRestriction() == 1 && $item->GetMin == -1 ? ' SELECTED' : '') . '>No maximum</OPTION>';
	$ranks = mysql_db_query('thebhg_roster', 'SELECT * FROM roster_rank ORDER BY roster_rank.order ASC', $roster->roster_db);
	if (mysql_num_rows($ranks)) {
		while ($rank = mysql_fetch_array($ranks)) {
			$rank_disp_min .= '<OPTION VALUE=' . $rank['id'] . ($item->GetRestriction() == 1 && $item->GetMin() == $rank['id'] ? ' SELECTED' : '') . ' NAME="' . $rank['name'] . '">' . $rank['name'] . '</OPTION>';
			$rank_disp_max .= '<OPTION VALUE=' . $rank['id'] . ($item->GetRestriction() == 1 && $item->GetMax() == $rank['id'] ? ' SELECTED' : '') . ' NAME="' . $rank['name'] . '">' . $rank['name'] . '</OPTION>';
		}
	}
	$rank_disp_min .= '</SELECT>';
	$rank_disp_max .= '</SELECT>';
	
	// Make position lists
	$position_disp_min = '<SELECT NAME="position_min"><OPTION VALUE="-1" NAME="No minimum" ' . ($item->GetRestriction() == 2 && $item->GetMin() == -1 ? ' SELECTED' : '') . '>No minimum</OPTION>';
	$position_disp_max = '<SELECT NAME="position_max"><OPTION VALUE="-1" NAME="No maximum" ' . ($item->GetRestriction() == 2 && $item->GetMin() == -1 ? ' SELECTED' : '') . '>No maximum</OPTION>';
	$positions = mysql_db_query('thebhg_roster', 'SELECT * FROM roster_position ORDER BY roster_position.order ASC', $roster->roster_db);
	if (mysql_num_rows($positions)) {
		while ($position = mysql_fetch_array($positions)) {
			$position_disp_min .= '<OPTION VALUE=' . $position['id'] . ($item->GetRestriction() == 2 && $item->GetMin() == $position['id'] ? ' SELECTED' : '') . ' NAME="' . $position['name'] . '">' . $position['name'] . '</OPTION>';
			$position_disp_max .= '<OPTION VALUE=' . $position['id'] . ($item->GetRestriction() == 2 && $item->GetMax() == $position['id'] ? ' SELECTED' : '') . ' NAME="' . $position['name'] . '">' . $position['name'] . '</OPTION>';
		}
	}
	$position_disp_min .= '</SELECT>';
	$position_disp_max .= '</SELECT>';

	$id = $item->GetID();
	$name = $item->GetName();
	$price = $item->GetPrice();
	$limit = $item->GetLimit();
	$description = $item->GetDescription();
	echo <<<EOF1
<FORM NAME="edit_item" METHOD="post" ACTION="$PHP_SELF">
<INPUT TYPE="hidden" NAME="id" VALUE="$id">
<TABLE BORDER=0>
<TR><TD>Type:</TD><TD><SELECT NAME="type">
EOF1;
	$store = new Store();
	$types = $store->GetTypes();
	$cur_type = $item->GetType();
	if ($types) for ($i = 0; $i < count($types); $i++) echo '<OPTION VALUE=' . $types[$i]->GetID() . ($types[$i]->GetID() == $cur_type->GetID() ? ' SELECTED' : '') . ' NAME="' . $types[$i]->GetName() . '">' . $types[$i]->GetName() . '</OPTION>';
	echo <<<EOF2
</SELECT>
<TR><TD>Name:</TD><TD><INPUT TYPE="text" NAME="name" SIZE=20 VALUE="$name"></TD></TR>
<TR><TD>Price:</TD><TD><INPUT TYPE="text" NAME="price" SIZE=10 VALUE="$price"> ICs</TD></TR>
<TR><TD>Sales Limit:</TD><TD><INPUT TYPE="text" NAME="limit" SIZE=5 VALUE="$limit"> (0 = unlimited)</TD></TR>
<TR VALIGN="top"><TD>Description:</TD><TD><TEXTAREA NAME="description" ROWS=10 COLS=60>$description</TEXTAREA></TD></TR>
<TR VALIGN="top"><TD>Restrictions:</TD><TD>
EOF2;
	echo '<INPUT TYPE="radio" NAME="restriction" VALUE=4' . ($item->GetRestriction() == 4 ? ' CHECKED' : '') . '> No restrictions<BR>';
	echo '<INPUT TYPE="radio" NAME="restriction" VALUE=1' . ($item->GetRestriction() == 1 ? ' CHECKED' : '') . "> Restrict to ranks from $rank_disp_min to $rank_disp_max<BR>";
	echo '<INPUT TYPE="radio" NAME="restriction" VALUE=2' . ($item->GetRestriction() == 2 ? ' CHECKED' : '') . "> Restrict to positions from $position_disp_min to $position_disp_max<BR>";
	echo '<INPUT TYPE="radio" NAME="restriction" VALUE=3' . ($item->GetRestriction() == 3 ? ' CHECKED' : '') . "> Restrict to the following division: $div_disp";
	echo <<<EOF3
</TD></TR>
</TABLE>
<INPUT TYPE="submit" VALUE="Edit Item"> <INPUT TYPE="reset">
</FORM>
EOF3;
}

if (isset($name)) {
	$item = new Item($id);
	switch ($restriction) {
		case 1:
			$min = $rank_min;
			$max = $rank_max;
			break;
		case 2:
			$min = $position_min;
			$max = $position_max;
			break;
		case 3:
			$min = $division;
			$max = $division;
			break;
		default:
			$min = -1;
			$max = -1;
			$restriction = 4;
	}
/*	if ($item->SetName($name)) echo 'Name saved.<BR>'; else echo 'Error saving Name.<BR>';
	if ($item->SetDescription($description)) echo 'Description saved.<BR>'; else echo 'Error saving Description.<BR>';
	if ($item->SetType($type)) echo 'Type saved.<BR>'; else echo 'Error saving Type.<BR>';
	if ($item->SetPrice($price)) echo 'Price saved.<BR>'; else echo 'Error saving Price.<BR>';
	if ($item->SetMin($min)) echo 'Min saved.<BR>'; else echo 'Error saving Min.<BR>';
	if ($item->SetMax($max)) echo 'Max saved.<BR>'; else echo 'Error saving Max.<BR>';
	if ($item->SetRestriction($restriction)) echo 'Restriction saved.<BR>'; else echo 'Error saving Restriction.<BR>';
	if ($item->SetLimit($limit)) echo 'Limit saved.<BR>'; else echo 'Error saving Limit.<BR>';*/
	if ($item->SetName($name) && $item->SetDescription($description) && $item->SetType($type) && $item->SetPrice($price) && $item->SetMin($min) && $item->SetMax($max) && $item->SetRestriction($restriction) && $item->SetLimit($limit)) echo 'Changes saved. Click <A HREF="index.php">here</A> to return to the main menu.';
	else echo 'Error saving changes.';
}
elseif (isset($id)) {
	$item = new Item($id);
	do_form($item);
}
else {
	$store = new Store();
	$items = $store->GetItems();
	echo "<FORM NAME=\"edit_item\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n";
	echo 'Item: <SELECT NAME="id" SIZE=1>';
	if ($items) {
		for ($i = 0; $i < count($items); $i++) echo '<OPTION VALUE=' . $items[$i]->GetID() . ' NAME="' . $items[$i]->GetName() . '">' . $items[$i]->GetName() . '</OPTION>';
	}
	echo '</SELECT><BR><BR>';
	echo '<INPUT TYPE="submit" VALUE="Edit">';
	echo '</FORM>';
}

page_footer();

?>

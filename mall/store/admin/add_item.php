<?php
include('header.php');

page_header();

function do_form() {
	// I too shall be directly accessing thebhg_roster here, since I need
	// the same functionality used in roster/hunt_list.php.
	$roster = new Roster('roster-69god');
	
	// Make divisions list
	$div_disp = '<SELECT NAME="division">';
	$divisions = mysql_db_query('thebhg_roster', 'SELECT * FROM roster_divisions ORDER BY name ASC', $roster->roster_db);
	if (mysql_num_rows($divisions)) {
		$first = true;
		while ($div = mysql_fetch_array($divisions)) {
			$div_disp .= '<OPTION VALUE=' . $div['id'] . ($first ? ' CHECKED' : '') . ' NAME="' . $div['name'] . '">' . $div['name'] . '</OPTION>';
			$first = false;
		}
	}
	$div_disp .= '</SELECT>';

	// Make rank lists
	$rank_disp_min = '<SELECT NAME="rank_min"><OPTION VALUE="-1" NAME="No minimum" CHECKED>No minimum</OPTION>';
	$rank_disp_max = '<SELECT NAME="rank_max"><OPTION VALUE="-1" NAME="No maximum" CHECKED>No maximum</OPTION>';
	$ranks = mysql_db_query('thebhg_roster', 'SELECT * FROM roster_rank ORDER BY roster_rank.order ASC', $roster->roster_db);
	if (mysql_num_rows($ranks)) {
		while ($rank = mysql_fetch_array($ranks)) {
			$row = '<OPTION VALUE=' . $rank['id'] . ' NAME="' . $rank['name'] . '">' . $rank['name'] . '</OPTION>';
			$rank_disp_min .= $row;
			$rank_disp_max .= $row;
		}
	}
	$rank_disp_min .= '</SELECT>';
	$rank_disp_max .= '</SELECT>';
	
	// Make position lists
	$position_disp_min = '<SELECT NAME="position_min"><OPTION VALUE="-1" NAME="No minimum" CHECKED>No minimum</OPTION>';
	$position_disp_max = '<SELECT NAME="position_max"><OPTION VALUE="-1" NAME="No maximum" CHECKED>No maximum</OPTION>';
	$positions = mysql_db_query('thebhg_roster', 'SELECT * FROM roster_position ORDER BY roster_position.order ASC', $roster->roster_db);
	if (mysql_num_rows($positions)) {
		while ($position = mysql_fetch_array($positions)) {
			$row = '<OPTION VALUE=' . $position['id'] . ' NAME="' . $position['name'] . '">' . $position['name'] . '</OPTION>';
			$position_disp_min .= $row;
			$position_disp_max .= $row;
		}
	}
	$position_disp_min .= '</SELECT>';
	$position_disp_max .= '</SELECT>';

		echo <<<EOF1
<FORM NAME="add_item" METHOD="post" ACTION="$PHP_SELF">
<TABLE BORDER=0>
<TR><TD>Type:</TD><TD><SELECT NAME="type">
EOF1;
	$store = new Store();
	$types = $store->GetTypes();
	if ($types) for ($i = 0; $i < count($types); $i++) echo '<OPTION VALUE=' . $types[$i]->GetID() . ' NAME="' . $types[$i]->GetName() . '">' . $types[$i]->GetName() . '</OPTION>';
	echo <<<EOF2
</SELECT>
<TR><TD>Name:</TD><TD><INPUT TYPE="text" NAME="name" SIZE=20></TD></TR>
<TR><TD>Price:</TD><TD><INPUT TYPE="text" NAME="price" SIZE=10> ICs</TD></TR>
<TR><TD>Sales Limit:</TD><TD><INPUT TYPE="text" NAME="limit" SIZE=5 VALUE="0"> (0 = unlimited)</TD></TR>
<TR VALIGN="top"><TD>Description:</TD><TD><TEXTAREA NAME="description" ROWS=10 COLS=60></TEXTAREA></TD></TR>
<TR VALIGN="top"><TD>Restrictions:</TD><TD>
<INPUT TYPE="radio" NAME="restriction" VALUE=4 CHECKED> No restrictions<BR>
<INPUT TYPE="radio" NAME="restriction" VALUE=1> Restrict to ranks from $rank_disp_min to $rank_disp_max<BR>
<INPUT TYPE="radio" NAME="restriction" VALUE=2> Restrict to positions from $position_disp_min to $position_disp_max<BR>
<INPUT TYPE="radio" NAME="restriction" VALUE=3> Restrict to the following division: $div_disp
</TD></TR>
</TABLE>
<INPUT TYPE="submit" VALUE="Add Item"> <INPUT TYPE="reset">
</FORM>
EOF2;
}

if (isset($name)) {
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
	$type = new Type($type);
	if ($type->AddItem($name, $price, $min, $max, $restriction, $description, $limit)) {
		echo 'Item added successfully. You may <A HREF="index.php">return to the main menu</A>, or add another item using the form below.<HR>';
		do_form();
	}
	else echo 'Error adding item.';
}
else do_form();

page_footer();

?>

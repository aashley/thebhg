<?php
include('header.php');

page_header();

function dust_me_selector($part) {
	$store = new Store();
	$parts = $store->GetParts();
	echo "<FORM NAME=\"edit_part\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n";
	echo 'Part: <SELECT NAME="id" SIZE=1>';
	if ($parts) {
		for ($i = 0; $i < count($parts); $i++) {
			$type = $parts[$i]->GetPartType();
			$part_list[$type->GetName()][$parts[$i]->GetName()] = '<OPTION VALUE=' . $parts[$i]->GetID() . ' NAME="' . $parts[$i]->GetName() . '"' . ($part->GetID() == $parts[$i]->GetID() ? ' SELECTED' : '') . '>' . $type->GetName() . ': ' . $parts[$i]->GetName() . '</OPTION>';
		}
		ksort($part_list);
		foreach ($part_list as $plist) {
			ksort($plist);
			foreach ($plist as $part) {
				echo $part;
			}
		}
	}
	echo '</SELECT><BR><BR>';
	echo '<INPUT TYPE="submit" VALUE="Edit">';
	echo '</FORM>';
}

function do_form($part) {
	// I too shall be directly accessing thebhg_roster here, since I need
	// the same functionality used in roster/hunt_list.php.
	$roster = new Roster('roster-69god');
	
	// Make divisions list
	$div_disp = '<SELECT NAME="division">';
	$divisions = mysql_db_query('thebhg_roster', 'SELECT * FROM roster_divisions ORDER BY name ASC', $roster->roster_db);
	if (mysql_num_rows($divisions)) {
		while ($div = mysql_fetch_array($divisions)) {
			$div_disp .= '<OPTION VALUE=' . $div['id'] . ($part->GetRestriction() == 3 && $part->GetMin() == $div['id'] ? ' SELECTED' : '') . ' NAME="' . $div['name'] . '">' . $div['name'] . '</OPTION>';
		}
	}
	$div_disp .= '</SELECT>';

	// Make rank lists
	$rank_disp_min = '<SELECT NAME="rank_min"><OPTION VALUE="-1" NAME="No minimum" ' . ($part->GetRestriction() == 1 && $part->GetMin == -1 ? ' SELECTED' : '') . '>No minimum</OPTION>';
	$rank_disp_max = '<SELECT NAME="rank_max"><OPTION VALUE="-1" NAME="No maximum" ' . ($part->GetRestriction() == 1 && $part->GetMin == -1 ? ' SELECTED' : '') . '>No maximum</OPTION>';
	$ranks = mysql_db_query('thebhg_roster', 'SELECT * FROM roster_rank ORDER BY roster_rank.order ASC', $roster->roster_db);
	if (mysql_num_rows($ranks)) {
		while ($rank = mysql_fetch_array($ranks)) {
			$rank_disp_min .= '<OPTION VALUE=' . $rank['id'] . ($part->GetRestriction() == 1 && $part->GetMin() == $rank['id'] ? ' SELECTED' : '') . ' NAME="' . $rank['name'] . '">' . $rank['name'] . '</OPTION>';
			$rank_disp_max .= '<OPTION VALUE=' . $rank['id'] . ($part->GetRestriction() == 1 && $part->GetMax() == $rank['id'] ? ' SELECTED' : '') . ' NAME="' . $rank['name'] . '">' . $rank['name'] . '</OPTION>';
		}
	}
	$rank_disp_min .= '</SELECT>';
	$rank_disp_max .= '</SELECT>';
	
	// Make position lists
	$position_disp_min = '<SELECT NAME="position_min"><OPTION VALUE="-1" NAME="No minimum" ' . ($part->GetRestriction() == 2 && $part->GetMin() == -1 ? ' SELECTED' : '') . '>No minimum</OPTION>';
	$position_disp_max = '<SELECT NAME="position_max"><OPTION VALUE="-1" NAME="No maximum" ' . ($part->GetRestriction() == 2 && $part->GetMin() == -1 ? ' SELECTED' : '') . '>No maximum</OPTION>';
	$positions = mysql_db_query('thebhg_roster', 'SELECT * FROM roster_position ORDER BY roster_position.order ASC', $roster->roster_db);
	if (mysql_num_rows($positions)) {
		while ($position = mysql_fetch_array($positions)) {
			$position_disp_min .= '<OPTION VALUE=' . $position['id'] . ($part->GetRestriction() == 2 && $part->GetMin() == $position['id'] ? ' SELECTED' : '') . ' NAME="' . $position['name'] . '">' . $position['name'] . '</OPTION>';
			$position_disp_max .= '<OPTION VALUE=' . $position['id'] . ($part->GetRestriction() == 2 && $part->GetMax() == $position['id'] ? ' SELECTED' : '') . ' NAME="' . $position['name'] . '">' . $position['name'] . '</OPTION>';
		}
	}
	$position_disp_min .= '</SELECT>';
	$position_disp_max .= '</SELECT>';

	$id = $part->GetID();
	$name = $part->GetName();
	$price = $part->GetPrice();
	$size = $part->GetSize();
	$bay = $part->GetBay();
	$external = $part->GetExternal() ? ' CHECKED' : '';
	$limit = $part->GetLimit();
	$description = $part->GetDescription();

	$stats = $part->GetStats();
	$consumables = $stats->GetConsumables();
	$hull = $stats->GetHull();
	$shields = $stats->GetShields();
	$speed = $stats->GetSpeed();
	$acceleration = $stats->GetAcceleration();
	$turnrate = $stats->GetTurnRate();
	$hyperdrive = $stats->GetHyperdrive();
	$power = $stats->GetPower();
	
	echo <<<EOF1
<FORM NAME="edit_part" METHOD="post" ACTION="$PHP_SELF">
<INPUT TYPE="hidden" NAME="id" VALUE="$id">
<TABLE BORDER=0>
<TR><TD>Type:</TD><TD><SELECT NAME="type">
EOF1;
	$store = new Store();
	$types = $store->GetPartTypes();
	$cur_type = $part->GetPartType();
	if ($types) for ($i = 0; $i < count($types); $i++) echo '<OPTION VALUE=' . $types[$i]->GetID() . ($types[$i]->GetID() == $cur_type->GetID() ? ' SELECTED' : '') . ' NAME="' . $types[$i]->GetName() . '">' . $types[$i]->GetName() . '</OPTION>';
	echo <<<EOF2
</SELECT>
<TR><TD>Name:</TD><TD><INPUT TYPE="text" NAME="name" SIZE=20 VALUE="$name"></TD></TR>
<TR><TD>Price:</TD><TD><INPUT TYPE="text" NAME="price" SIZE=10 VALUE="$price"> ICs</TD></TR>
<TR><TD>Size:</TD><TD><INPUT TYPE="text" NAME="size" SIZE=5 VALUE="$size"> $vol_plural</TD></TR>
<TR><TD>Bay:</TD><TD><SELECT NAME="bay" SIZE="1">
EOF2;
	echo '<OPTION VALUE="0"' . ($bay == 0 ? ' SELECTED' : '') . '>No restriction</OPTION>';
	$bays = $store->GetBays();
	foreach ($bays as $b) echo '<OPTION VALUE="' . $b->GetID() . '"' . (($bay && $b->GetID() == $bay->GetID()) ? ' SELECTED' : '') . '>' . htmlspecialchars($b->GetName()) . '</OPTION>';
	echo <<<EOF3
</SELECT></TD></TR>
<TR><TD>External Access:</TD><TD><INPUT TYPE="checkbox" NAME="external" VALUE="on"$external></TD></TR>
<TR><TD>Sales Limit:</TD><TD><INPUT TYPE="text" NAME="limit" SIZE=5 VALUE="$limit"> (0 = unlimited)</TD></TR>
<TR VALIGN="top"><TD>Description:</TD><TD><TEXTAREA NAME="description" ROWS=10 COLS=60>$description</TEXTAREA></TD></TR>
<TR VALIGN="top"><TD>Restrictions:</TD><TD>
EOF3;
	echo '<INPUT TYPE="radio" NAME="restriction" VALUE=4' . ($part->GetRestriction() == 4 ? ' CHECKED' : '') . '> No restrictions<BR>';
	echo '<INPUT TYPE="radio" NAME="restriction" VALUE=1' . ($part->GetRestriction() == 1 ? ' CHECKED' : '') . "> Restrict to ranks from $rank_disp_min to $rank_disp_max<BR>";
	echo '<INPUT TYPE="radio" NAME="restriction" VALUE=2' . ($part->GetRestriction() == 2 ? ' CHECKED' : '') . "> Restrict to positions from $position_disp_min to $position_disp_max<BR>";
	echo '<INPUT TYPE="radio" NAME="restriction" VALUE=3' . ($part->GetRestriction() == 3 ? ' CHECKED' : '') . "> Restrict to the following division: $div_disp";
	echo <<<EOF3
</TD></TR>
<TR><TD>Consumables:</TD><TD><INPUT TYPE="text" NAME="consumables" SIZE=5 VALUE="$consumables"></TD></TR>
<TR><TD>Hull:</TD><TD><INPUT TYPE="text" NAME="hull" SIZE=5 VALUE="$hull"></TD></TR>
<TR><TD>Shields:</TD><TD><INPUT TYPE="text" NAME="shields" SIZE=5 VALUE="$shields"></TD></TR>
<TR><TD>Speed:</TD><TD><INPUT TYPE="text" NAME="speed" SIZE=5 VALUE="$speed"></TD></TR>
<TR><TD>Acceleration:</TD><TD><INPUT TYPE="text" NAME="acceleration" SIZE=5 VALUE="$acceleration"></TD></TR>
<TR><TD>Maneuverability:</TD><TD><INPUT TYPE="text" NAME="turnrate" SIZE=5 VALUE="$turnrate"></TD></TR>
<TR><TD>Hyperdrive:</TD><TD><INPUT TYPE="text" NAME="hyperdrive" SIZE=5 VALUE="$hyperdrive"></TD></TR>
<TR><TD>Power:</TD><TD><INPUT TYPE="text" NAME="power" SIZE=5 VALUE="$power"></TD></TR>
</TABLE>
<INPUT TYPE="submit" VALUE="Edit Part"> <INPUT TYPE="reset">
</FORM>
EOF3;
}

if (isset($name)) {
	$part = new Part($id);
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
/*	if ($part->SetName($name)) echo 'Name saved.<BR>'; else echo 'Error saving Name.<BR>';
	if ($part->SetDescription($description)) echo 'Description saved.<BR>'; else echo 'Error saving Description.<BR>';
	if ($part->SetPartType($type)) echo 'Type saved.<BR>'; else echo 'Error saving Type.<BR>';
	if ($part->SetPrice($price)) echo 'Price saved.<BR>'; else echo 'Error saving Price.<BR>';
	if ($part->SetMin($min)) echo 'Min saved.<BR>'; else echo 'Error saving Min.<BR>';
	if ($part->SetMax($max)) echo 'Max saved.<BR>'; else echo 'Error saving Max.<BR>';
	if ($part->SetRestriction($restriction)) echo 'Restriction saved.<BR>'; else echo 'Error saving Restriction.<BR>';
	if ($part->SetLimit($limit)) echo 'Limit saved.<BR>'; else echo 'Error saving Limit.<BR>';
	if ($part->SetSize($size)) echo 'Size saved.<BR>'; else echo 'Error saving Size.<BR>';
	if ($part->SetExternal($external == 'on')) echo 'External saved.<BR>'; else echo 'Error saving External.<BR>';*/
	$stats = $part->GetStats();
	if (!$stats->SetConsumables($consumables)) echo 'Error setting consumables.<BR>';
	if (!$stats->SetHull($hull)) echo 'Error setting hull.<BR>';
	if (!$stats->SetShields($shields)) echo 'Error setting shields.<BR>';
	if (!$stats->SetSpeed($speed)) echo 'Error setting speed.<BR>';
	if (!$stats->SetAcceleration($acceleration)) echo 'Error setting acceleration.<BR>';
	if (!$stats->SetTurnRate($turnrate)) echo 'Error setting turnrate.<BR>';
	if (!$stats->SetHyperdrive($hyperdrive)) echo 'Error setting hyperdrive.<BR>';
	if (!$stats->SetPower($power)) echo 'Error setting power.<BR>';
	if ($part->SetName($name) && $part->SetDescription($description) && $part->SetPartType($type) && $part->SetPrice($price) && $part->SetSize($size) && $part->SetBay($bay) && $part->SetExternal($external == 'on') && $part->SetMin($min) && $part->SetMax($max) && $part->SetRestriction($restriction) && $part->SetLimit($limit)) echo 'Changes saved. Click <A HREF="index.php">here</A> to return to the main menu.';
	else echo 'Error saving changes.';
        echo '<hr>';
        dust_me_selector($part);
}
elseif (isset($id)) {
	$part = new Part($id);
	do_form($part);
}
else {
	$store = new Store();
	$parts = $store->GetParts();
	echo "<FORM NAME=\"edit_part\" METHOD=\"get\" ACTION=\"$PHP_SELF\">\n";
	echo 'Part: <SELECT NAME="id" SIZE=1>';
	if ($parts) {
		for ($i = 0; $i < count($parts); $i++) {
			$type = $parts[$i]->GetPartType();
			$part_list[$type->GetName()][$parts[$i]->GetName()] = '<OPTION VALUE=' . $parts[$i]->GetID() . ' NAME="' . $parts[$i]->GetName() . '">' . $type->GetName() . ': ' . $parts[$i]->GetName() . '</OPTION>';
		}
		ksort($part_list);
		foreach ($part_list as $plist) {
			ksort($plist);
			foreach ($plist as $part) {
				echo $part;
			}
		}
	}
	echo '</SELECT><BR><BR>';
	echo '<INPUT TYPE="submit" VALUE="Edit">';
	echo '</FORM>';
}

page_footer();

?>

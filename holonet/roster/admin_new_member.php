<?php
include_once('roster/dropdowns.php');
function title() {
	return 'Administration :: New Members';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['underlord'];
}

function output() {
	global $auth_data, $roster, $page;

	roster_header();

	if (   isset($_REQUEST['submit'])
	    && $_REQUEST['submit'] == 'Add Members') {

	  foreach ($_REQUEST['newmember'] as $id => $options) {

	    $error = false;

	    if ($options['wing'] != -1 && $options['action'] == 'add') {

	      if (!$roster->CreatePerson($options['name'],
					 $options['email'],
					 $options['wing'],
					 $options['pass'])) {

		print "Error adding '".$options['name']."'<br>";

		$error = true;

	      }

	    }

	    if (!$error) {

	      mysql_query("UPDATE roster_new_members SET added = 1 WHERE id = $id", $roster->roster_db);

	    }
	    
	  }
	 
	}

	$form = new Form($page, 'post');

	mysql_query('INSERT INTO roster_new_members (name, email, kabal, password, underage, parentemail, comments, added) SELECT new_member_name, new_member_email, new_member_kabal, new_member_password, new_member_underage, new_member_parentemail, new_member_comments, new_member_added FROM new_members WHERE added=0', $roster->roster_db);
	mysql_query('UPDATE new_members SET new_member_added=1', $roster->roster_db);
	$new_members = mysql_query("SELECT * FROM roster_new_members WHERE underage = 0 AND added = 0", $roster->roster_db);

	$form->table->StartRow();
	$form->table->AddHeader('Name');
	$form->table->AddHeader('Parent E-Mail');
	$form->table->AddHeader('Wing');
	$form->table->AddHeader('Comments');
	$form->table->AddHeader('Action');
	$form->table->EndRow();

	if ($new_member_row = mysql_fetch_array($new_members)) {
	  
	  do {

	    // Add some new dupe checking code. - Jer
	    $dupes_result = mysql_query("SELECT id, name FROM roster_roster WHERE name='" . $new_member_row["name"] . "' OR email='" . $new_member_row["email"] . "' OR email LIKE '" . preg_replace("/@.*/", "", $new_member_row["email"]) . "@%'", $roster->roster_db);
	    
	    $is_dupe = ($dupes_result && mysql_num_rows($dupes_result));
	    
	    $nmid = 'newmember[' . $new_member_row['id'] . ']';
	    $form->AddHidden($nmid . '[name]', stripslashes($new_member_row['name']));
	    $form->AddHidden($nmid . '[email]', stripslashes($new_member_row['email']));
	    $form->AddHidden($nmid . '[pass]', stripslashes($new_member_row['password']));
	    if ($is_dupe) {
	      $dupes = array();
	      while ($dupe_row = mysql_fetch_array($dupes_result)) {
		$dupes[$dupe_row["name"]] = ("<a href=\"" . internal_link('hunter', array('id'=>$dupe_row["id"])) . "\">" . stripslashes($dupe_row["name"]) . "</a>");
	      }
	    }
	    $form->table->StartRow();
	    $form->table->AddCell('<a href="mailto:' . stripslashes($new_member_row['email']) . '">' . stripslashes($new_member_row['name']) . '</a>', 1, ($is_dupe ? 2 : 1));
	    $form->table->AddCell('N/A');
	    $cell = '<select name="' . $nmid . '[wing]" size=1>';
	    $dc = $roster->GetDivisionCategory(1);
	    $wings = $dc->GetDivisions();
	    foreach ($wings as $wing) {
	      $cell .= '<option value="' . $wing->GetID() . '">' . html_escape($wing->GetName()) . '</option>';
	    }
	    $cell .= '</select>';
      $cell = DivisionDropDown($nmid.'[wing]',
                               1,
                               0,
                               1,
                               4);
	    $form->table->AddCell($cell);
	    $form->table->AddCell(stripslashes($new_member_row['comments']));
	    $form->table->AddCell('<select name="' . $nmid . '[action]" size=1><option value="add">Add</option><option value="remove">Remove</option></select>');
	    $form->table->EndRow();
	    if ($is_dupe) {
		    $form->table->StartRow();
		    $form->table->AddCell('Possible duplicates: ' . implode(', ', $dupes), 4);
		    $form->table->EndRow();
	    }
	    
	  } while ($new_member_row = mysql_fetch_array($new_members));
	  
	}

	unset($new_members);
	unset($new_member_row);

	$new_members = mysql_query("SELECT * FROM roster_new_members WHERE underage = 1 AND added = 0");

	if ($new_member_row = mysql_fetch_array($new_members)) {
	  
	  do {

	    // Add some new dupe checking code. - Jer
	    $dupes_result = mysql_query("SELECT id, name FROM roster_roster WHERE name='" . $new_member_row["name"] . "' OR email='" . $new_member_row["email"] . "' OR email LIKE '" . preg_replace("/@.*/", "", $new_member_row["email"]) . "@%'", $roster->roster_db);
	    
	    $is_dupe = ($dupes_result && mysql_num_rows($dupes_result));
	    
	    $nmid = 'newmember[' . $new_member_row['id'] . ']';
	    $form->AddHidden($nmid . '[name]', stripslashes($new_member_row['name']));
	    $form->AddHidden($nmid . '[email]', stripslashes($new_member_row['email']));
	    $form->AddHidden($nmid . '[pass]', stripslashes($new_member_row['password']));
	    if ($is_dupe) {
	      $dupes = array();
	      while ($dupe_row = mysql_fetch_array($dupes_result)) {
		$dupes[$dupe_row["name"]] = ("<a href=\"" . internal_link('hunter', array('id'=>$dupe_row["id"])) . "\">" . stripslashes($dupe_row["name"]) . "</a>");
	      }
	    }
	    $form->table->StartRow();
	    $form->table->AddCell('<a href="mailto:' . stripslashes($new_member_row['email']) . '">' . stripslashes($new_member_row['name']) . '</a>', 1, ($is_dupe ? 2 : 1));
	    $form->table->AddCell('<a href="mailto:' . stripslashes($new_member_row['parentemail']) . '">' . stripslashes($new_member_row['parentemail']) . '</a>');
	    $cell = '<select name="' . $nmid . '[wing]" size=1>';
	    $dc = $roster->GetDivisionCategory(1);
	    $wings = $dc->GetDivisions();
	    foreach ($wings as $wing) {
	      $cell .= '<option value="' . $wing->GetID() . '">' . html_escape($wing->GetName()) . '</option>';
	    }
	    $cell .= '</select>';
	    $form->table->AddCell($cell);
	    $form->table->AddCell(stripslashes($new_member_row['comments']));
	    $form->table->AddCell('<select name="' . $nmid . '[action]" size=1><option value="add">Add</option><option value="remove">Remove</option></select>');
	    $form->table->EndRow();
	    if ($is_dupe) {
		    $form->table->StartRow();
		    $form->table->AddCell('Possible duplicates: ' . implode(', ', $dupes), 4);
		    $form->table->EndRow();
	    }
	      

	  } while ($new_member_row = mysql_fetch_array($new_members));
	  
	}

	$form->table->StartRow();
	$form->table->AddCell('<center><input type="submit" name="submit" value="Add Members"></center>', 5);
	$form->table->EndRow();
	$form->EndForm();

	admin_footer($auth_data);
}
?>

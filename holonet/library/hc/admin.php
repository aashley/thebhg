<?php

include_once 'roster.inc';
include_once 'history.inc';

$login = new Login_HTTP();
$login_id = $login->GetID();
if (($login_id != '85') && ($login_id != '2650')) {
	die ("<p>You are not authorized to use this. Please return to the <a href=\"index.php\">Timeline</a>.</p>");
}

$history = new History('BHGhist85');

$months = array (
	1 => "January",
	2 => "February",
	3 => "March",
	4 => "April",
	5 => "May",
	6 => "June",
	7 => "July",
	8 => "August",
	9 => "September",
	10 => "October",
	11 => "November",
	12 => "December",
);


/* NAVIGATION */

print "<p>Admin:<br>
	<br><a href=\"{$PHP_SELF}?op=add_event\">Add an Event</a>
	<br><a href=\"{$PHP_SELF}?op=edit_events\">Edit Events</a>
	<br><a href=\"{$PHP_SELF}?op=add_cat\">Add a Category</a>
	<br><a href=\"{$PHP_SELF}?op=edit_cats\">Edit Categories</a>
	<br><br><a href=\"index.php\">Return to Timeline</a>
	</p>";


print "<hr>"; /* TEMPORARY SEPARATOR */


/* ADMIN CONTENT */

switch ($_GET['op']) {
	case 'add_event':
		if ($_POST['add']) {
			$date = mktime(0,0,0,$_POST['event_month'],$_POST['event_day'],$_POST['event_year']);
			$create = $history->CreateEvent($date,$_POST['category'],$_POST['event_info']);
			$verify = ($create ? "Event Successfully Added." : "Error Adding Event. Contact Admin.");
			print "<p>{$verify}</p><hr>";
		}
		
		print "<form method=\"post\" action=\"{$PHP_SELF}?op=add_event\">
			<p><b>Add an Event:</b>
			<br><br>Date:
			<br><input type=\"text\" name=\"event_day\" size=\"4\" value=\"Day\">
			<select name=\"event_month\">";
		
		foreach ($months as $m_id => $m_name){
			print "<option value=\"{$m_id}\">{$m_name}</option>";
		}
		
		print "</select>
			<input type=\"text\" name=\"event_year\" size=\"6\" value=\"Year\">
			<br><br>Event:
			<br><textarea name=\"event_info\" cols=\"50\" rows=\"3\"></textarea>
			<br><br>Select Category:
			<br><select name=\"category\">";
		
		$categories = $history->GetCategories(0);
		if ($categories) {
			foreach ($categories as $category) {
				$id = $category->GetID();
				$name = $category->GetName();
				
				print "<option value=\"{$id}\">{$name}</option>";
			}
		}
		
		print "</select>
			<br><br><input type=\"submit\" name=\"add\" value=\"Add Event\">
			</p></form>";
		break;
	
	case 'edit_events':
		switch (TRUE) {
			case $_GET['delete']:
				$event = $history->GetEvent($_GET['delete']);
				$verify = ($event->Delete() ? "Event Successfully Deleted." : "Error Deleting Event. Contact Admin.");
				print "<p>{$verify}</p>";
				
				print "<hr>";
				break;
				
			case $_GET['edit']:
				$event = $history->GetEvent($_GET['edit']);
				$event_id = $event->GetID();
				$date = getdate($event->GetEventDate());
				$day = $date['mday'];
				$month = $date['mon'];
				$year = $date['year'];
				$event_info = $event->GetEventInfo();
				$cat_ids = explode(",",$event->category);
				$cat_id = $cat_ids[0];
				
				print "<form method=\"post\" action=\"{$PHP_SELF}?op=edit_events\">
					<p><b>Edit Event:</b>
					<br><br>Date:
					<br><input type=\"text\" name=\"event_day\" size=\"4\" value=\"{$day}\">
					<select name=\"event_month\">";
				
				foreach ($months as $m_id => $m_name){
					$selected = ($m_id == $month ? "selected" : "");
					print "<option value=\"{$m_id}\" {$selected}>{$m_name}</option>";
				}
				
				print "</select>
					<input type=\"text\" name=\"event_year\" size=\"6\" value=\"{$year}\">
					<br><br>Event:
					<br><textarea name=\"event_info\" cols=\"50\" rows=\"3\">{$event_info}</textarea>
					<br><br>Select Category:
					<br><select name=\"category\">";
				
				$categories = $history->GetCategories(0);
				if ($categories) {
					foreach ($categories as $category) {
						$id = $category->GetID();
						$name = $category->GetName();
						$selected = ($id == $cat_id ? "selected" : "");
						
						print "<option value=\"{$id}\" {$selected}>{$name}</option>";
					}
				}
				
				print "</select>
					<input type=\"hidden\" name=\"id\" value=\"{$event_id}\">
					<br><br><input type=\"submit\" name=\"edit_event\" value=\"Edit Event\">
					</p></form>";
				
				print "<hr>";
				break;
			
			case $_POST['edit_event']:
				$event = $history->GetEvent($_POST['id']);
				$date = mktime(0,0,0,$_POST['event_month'],$_POST['event_day'],$_POST['event_year']);
				$cat_ids = explode(",",$event->category);
				$cat_id = $cat_ids[0];
				
				if ($date != $event->GetEventDate()) {
					$verify = ($event->SetDate($date) ? "Date Changed Successfully." : "Error Changing Date. Contact Admin.");
					print "<p>{$verify}</p>";
				}
				
				if ($_POST['event_info'] != $event->GetEventInfo()) {
					$verify = ($event->SetEventInfo($_POST['event_info']) ? "Event Information Changed Successfully." : "Error Changing Event Information. Contact Admin.");
					print "<p>{$verify}</p>";
				}
				
				if ($_POST['category'] != $cat_id) {
					$verify = ($event->SetCategory($_POST['category']) ? "Category Changed Successfully." : "Error Changing Category. Contact Admin.");
					print "<p>{$verify}</p>";
				}
				
				print "<hr>";
				break;
		}
		
		print "<form method=\"post\" action=\"{$PHP_SELF}?op=edit_events\"><p>
			<select name=\"filter\">
			<option value=\"0\">All Events</option>";
		
		$categories = $history->GetCategories(0);
		if ($categories) {
			foreach ($categories as $category) {
				$id = $category->GetID();
				$name = $category->GetName();
				
				print "<option value=\"{$id}\">{$name}</option>";
			}
		}
		
		print "</select>
			<br><br><input type=\"submit\" name=\"add_filter\" value=\"Apply Filter\">
			</p></form>
			<hr>";
		
		if ($_POST['add_filter'] && $_POST['filter'] != 0) {
			$filter_cat = $history->GetCategory($_POST['filter']);
			$events = $filter_cat->GetEvents();
		} else {
			$events = $history->GetEvents();
		}
		
		$date_format = "j F Y";

		print "<table align=center border=1 cellpadding=3 width=90%>";
		if ($events) {
			$date = '';
			
			print "<tr><td align=center width=20%><b>Date</b></td>
				<td align=center width=60%><b>Event</b></td>
				<td align=center colspan=2 width=20%><b>Admin</b></td></tr>";
			
			foreach ($events as $event) {
				$date = $event->GetEventDate();
				$info = $event->GetEventInfo();
				$id = $event->GetID();
				
				print "<tr><td width=20%>".date($date_format,$date)."</td>
					<td width=60%>{$info}</td>
					<td width=10% align=center><a href=\"{$PHP_SELF}?op=edit_events&edit={$id}\">Edit</a></td>
					<td width=10% align=center><a href=\"{$PHP_SELF}?op=edit_events&delete={$id}\">Delete</a></td></tr>";
			}
		} else {
			print "<tr><td align=center>There are no events at present.</td></tr>";
		}
		print "</table>";
		break;
	
	case 'add_cat':
		if ($_POST['add']) {
			$create = $history->CreateCategory($_POST['name'],$_POST['parent']);
			$verify = ($create ? "Category Successfully Added." : "Error Adding Category. Contact Admin.");
			print "<p>{$verify}</p><hr>";
		}
		
		print "<form method=\"post\" action=\"{$PHP_SELF}?op=add_cat\">
			<p><b>Add a Category:</b>
			<br><br>Name:
			<br><input type=\"text\" name=\"name\" size=\"50\">
			<br><br>Parent Category:
			<br><select name=\"parent\">
			<option value=\"0\">Not a Subcategory</option>";
		
		$categories = $history->GetCategories(0);
		if ($categories) {
			foreach ($categories as $category) {
				$id = $category->GetID();
				$name = $category->GetName();
				
				print "<option value=\"{$id}\">{$name}</option>";
			}
		}
		print "</select>
			<br><br><input type=\"submit\" name=\"add\" value=\"Add Category\">
			</p></form>";
		break;
	
	case 'edit_cats':
		switch (TRUE) {
			case $_GET['delete']:
				$category = $history->GetCategory($delete);
				$verify = ($category->Delete() ? "Category Successfully Deleted." : "Error Deleting Category. Contact Admin.");
				print "<p>{$verify}</p>";
				
				print "<hr>";
				break;
			
			case $_GET['edit']:
				$edit_category = $history->GetCategory($edit);
				$edit_id = $edit_category->GetID();
				$edit_name = $edit_category->GetName();
				$parent = $edit_category->GetParent();
				$parent_id = $parent->GetID();
				
				print "<form method=\"post\" action=\"{$PHP_SELF}?op=edit_cats\">
					<p><b>Edit Category:</b>
					<br><br>Name:
					<br><input type=\"text\" name=\"name\" size=\"50\" value=\"{$edit_name}\">
					<br><br>Parent Category:
					<br><select name=\"parent\">
					<option value=\"0\">Not a Subcategory</option>";
				
				$categories = $history->GetCategories(0);
				if ($categories) {
					foreach ($categories as $category) {
						$id = $category->GetID();
						$name = $category->GetName();
						$selected = ($parent_id == $id ? "selected" : "");
						
						print "<option value=\"{$id}\" {$selected}>{$name}</option>";
					}
				}
				print "</select>
					<input type=\"hidden\" name=\"id\" value=\"{$edit_id}\">
					<br><br><input type=\"submit\" name=\"edit_cat\" value=\"Edit Category\">
					</p></form>";
				
				print "<hr>";
				break;
			
			case $_POST['edit_cat']:
				$category = $history->GetCategory($_POST['id']);
				$parent_obj = $category->GetParent();
				
				if ($_POST['name'] != $category->GetName()) {
					$verify = ($category->SetName($_POST['name']) ? "Name Changed Successfully." : "Error Changing Name. Contact Admin.");
					print "<p>{$verify}</p>";
				}
				
				if ($_POST['parent'] != $parent_obj->GetID()) {
					$verify = ($category->SetParent($_POST['parent']) ? "Parent Changed Successfully." : "Error Changing Parent. Contact Admin.");
					print "<p>{$verify}</p>";
				}
				
				print "<hr>";
				break;
		}
		
		$categories = $history->GetCategories(0);

		print "<table align=center border=1 cellpadding=3 width=90%>";
		if ($categories) {
			$date = '';
			
			print "<tr><td align=center width=40%><b>Category</b></td>
				<td align=center width=40%><b>Parent</b></td>
				<td align=center colspan=2 width=20%><b>Admin</b></td></tr>";
			
			foreach ($categories as $category) {
				$name = $category->GetName();
				$id = $category->GetID();
				$parent = $category->GetParent();
				$parent_name = $parent->GetName();
				
				print "<tr><td width=40%>{$name}</td>
					<td width=40%>{$parent_name}</td>
					<td width=10% align=center><a href=\"{$PHP_SELF}?op=edit_cats&edit={$id}\">Edit</a></td>
					<td width=10% align=center><a href=\"{$PHP_SELF}?op=edit_cats&delete={$id}\">Delete</a></td></tr>";
			}
		} else {
			print "<tr><td align=center>There are no categories at present.</td></tr>";
		}
		print "</table>";
		break;
		
	default:
		print "<p>Select an option from the menu.</p>";
		break;
}

?>
<?php

include_once 'history.inc';
$history = new History();


/* NAVIGATION */

$categories = $history->GetCategories();

print "<p>Categories:<br>";
print "<br><a href=\"../hc/\">All</a>";
if ($categories) {
	foreach ($categories as $category) {
		$id = $category->GetID();
		$name = $category->GetName();
		
		print "<br><a href=\"{$PHP_SELF}?cat_id={$id}\">{$name}</a>";
	}
}

if ($_GET['cat_id']) {
	$category = $history->GetCategory($_GET['cat_id']);
	$cat_name = $category->GetName();
	if ($category->IsParent()) {
		print "<br><br><br>Subcategories:<br>";
		$subcategories = $category->GetSubcategories();
		foreach ($subcategories as $subcategory) {
			$id = $subcategory->GetID();
			$name = $subcategory->GetName();
			
			print "<br><a href=\"{$PHP_SELF}?cat_id={$id}\">{$name}</a>";
		}
	}
	
	$events = $category->GetEvents();
	$count = count($events);
	$title = "$cat_name<br>($count Events Archived)";
} else {
	$events = $history->GetEvents();
	$count = count($events);
	$title = "The BHG History<br>($count Events Archived)";
}

print "<br><br><br><a href=\"admin.php\">Admin</a></p>";


print "<hr>"; /* TEMPORARY SEPARATOR */


/* DISPLAYS EVENTS */

$date_format = "j F Y";

print "<table align=center border=1 cellpadding=3 width=90%>
	<tr><td colspan=2 align=center><b>{$title}</b></td></tr>";
if ($events) {
	$date = '';
	
	print "<tr><td width=20%><b>Date</b></td><td width=80%><b>Event</b></td></tr>\n";
	
	foreach ($events as $event) {
		if ($event->GetEventDate() != $date) {
			$date = $event->GetEventDate();
			print "<tr><td width=20%>".date($date_format,$date)."</td>";
		} else {
			print "<tr><td width=20%></td>";
		}
		
		$info = $event->GetEventInfo();
		print "<td width=80%>{$info}</td></tr>\n";
	}
} else {
	print "<tr><td colspan=2 align=center>There are no events in this category at present.</td></tr>";
}
print "</table>";

?>
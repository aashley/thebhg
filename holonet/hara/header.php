<?php
$prefix = 'hara_';

function admin_header() {
	echo '<table border=0 width="100%"><tr valign="top"><td width="90%">';
}

function admin_footer() {
	echo '</td><td style="border-left: solid 1px black">Administration&nbsp;Menu<small>';
	
	echo '<br><br><b>Show&nbsp;Administration</b><br>';
	echo '<br><a href="' . internal_link('admin_add_show') . '">Add&nbsp;Show</a>';
	echo '<br><a href="' . internal_link('admin_edit_show') . '">Edit&nbsp;Show</a>';
	echo '<br><a href="' . internal_link('admin_delete_show') . '">Delete&nbsp;Show</a>';

	echo '<br><br><b>Playlist&nbsp;Administration</b><br>';
	echo '<br><a href="' . internal_link('admin_add_playlist') . '">Add&nbsp;Playlist</a>';
/*	echo '<br><a href="' . internal_link('admin_edit_playlist') . '">Edit&nbsp;Playlist</a>';
	echo '<br><a href="' . internal_link('admin_delete_playlist') . '">Delete&nbsp;Playlist</a>';*/
	echo '<br><a href="' . internal_link('admin_request') . '">Show&nbsp;Requests</a>';

	echo '<br><br><b>Segment&nbsp;Administration</b><br>';
	echo '<br><a href="' . internal_link('admin_add_segment') . '">Add&nbsp;Segment</a>';
	echo '<br><a href="' . internal_link('admin_edit_segment') . '">Edit&nbsp;Segment</a>';
	echo '<br><a href="' . internal_link('admin_delete_segment') . '">Delete&nbsp;Segment</a>';

	echo '<br><br><b>FAQ&nbsp;Section&nbsp;Administration</b><br>';
	echo '<br><a href="' . internal_link('admin_add_faq_section') . '">Add&nbsp;FAQ&nbsp;Section</a>';
	echo '<br><a href="' . internal_link('admin_edit_faq_section') . '">Edit&nbsp;FAQ&nbsp;Section</a>';
	echo '<br><a href="' . internal_link('admin_delete_faq_section') . '">Delete&nbsp;FAQ&nbsp;Section</a>';

	echo '<br><br><b>FAQ&nbsp;Administration</b><br>';
	echo '<br><a href="' . internal_link('admin_add_faq') . '">Add&nbsp;FAQ</a>';
	echo '<br><a href="' . internal_link('admin_edit_faq') . '">Edit&nbsp;FAQ</a>';
	echo '<br><a href="' . internal_link('admin_delete_faq') . '">Delete&nbsp;FAQ</a>';

	echo '</small></td></tr></table>';
}

function is_admin($user) {
	return ($user->GetID() == 666 || $user->GetID() == 94 || $user->GetID() == 1699);
}

function is_global_admin($user) {
	return is_admin($user);
}
?>

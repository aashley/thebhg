<?php
function title() {
	return 'Index';
}

function output() {
	global $library;

	menu_header();

	echo '<p>Taking a deep breath, you step into the BHG Library, itself a part of the Citadel complex on Sol\'Rahl. Immediately, you notice the sheer scale of the place. The Library is massive, with high vaulted ceilings and rows upon rows of bookshelves. You know that within these walls, you can find information on almost anything you need to, from the structure of the BHG Commission to the mating habits of lawn gnomes.</p><p>You sit down at the nearest catalogue terminal and start typing in your request, secure in the knowledge that the answers you seek are somewhere within this building...</p>';

	echo '<p>Available Shelves:</p>';

	foreach ($library->GetShelves() as $shelf) {

		echo '<p><a href="'.internal_link('shelf', array('id'=>$shelf->GetID())).'">'.$shelf->GetName().'</a><small><br>'.$shelf->GetDescription().'</small></p>';

	}

	library_footer();
}
?>

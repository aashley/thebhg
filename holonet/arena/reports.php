<?php
function title() {
    return 'Latest Reports';
}

function output() {
    global $arena;

    arena_header();
	foreach ($arena->ArenaPositions() as $key=>$t){
		$arena->LatestReport($key);
	}
    arena_footer();
}
?>
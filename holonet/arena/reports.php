<?php
function title() {
    return 'Latest Reports';
}

function output() {
    global $arena;

    arena_header();
	$arena->LatestReport($arena->ArenaPositions());
    arena_footer();
}
?>
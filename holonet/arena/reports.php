<?php
function title() {
    return 'Latest Reports';
}

function output() {
    global $arena;

    echo '<a href="'.internal_link('view_reports').'">View All Reports</a><br />';
    
    hr();
    
    arena_header();
	$arena->LatestReport($arena->ArenaPositions());
    arena_footer();
}
?>
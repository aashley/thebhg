<?php

function title() {
    global $hunter;

    return 'General :: NPCs';
}

function output() {
    global $arena;

    arena_header();

    $npc = new Parse_NPC(3);
    $util = new NPC_Utilities();
    echo $npc->GetString();
    echo $util->Construct($npc->GetString());

    arena_footer();
}
?>
<?php

function title() {
    return 'Administration :: General :: Message Board Interface';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $hunter, $roster, $page, $auth_data;

    arena_header();

    $table = new Table();
    
    $table->StartRow();
    $table->AddHeader('Post New Topic', 2);
    $table->EndRow();
    echo '<FORM NAME="post" METHOD="post" ACTION="http://boards.thebhg.org/index.php">
    <INPUT TYPE="hidden" NAME="op" VALUE="post">
	<INPUT TYPE="hidden" NAME="board" VALUE="1">';
    $table->AddRow('Topic: ', '<INPUT TYPE="text" NAME="subject" SIZE=35 MAXLENGTH=85>');
    $table->AddRow('Message: ', '<TEXTAREA NAME="message" ROWS=9 COLS=65 WRAP="virtual"></TEXTAREA>');
    $table->StartRow();
    $table->AddCell('<INPUT TYPE="submit" VALUE="Post New Topic">', 2);
    $table->EndRow();
    echo '<INPUT TYPE="hidden" name="signature" value="1" CHECKED><INPUT TYPE="hidden" NAME="sticky" VALUE="1" CHECKED></FORM>';
    $table->EndTable();

    admin_footer($auth_data);

}
?>

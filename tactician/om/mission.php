<?php
include_once 'header.php';

$id = (int) $id;
$mission_result = mysql_query("SELECT * FROM missions WHERE id=$id", $db);
if ($mission_result && mysql_num_rows($mission_result)) {
	$mission = mysql_fetch_array($mission_result);
	
	if ($mission['hidden'] == 1 && !in_array($login->GetID(), array(666, 2650)) && $pos->GetID() != 3){
		echo '<div>You have no authority to view this mission</div>';
		page_footer();
		exit;
	}
	
	page_header('Mission :: ' . stripslashes(format($mission['title'])));
	
	$form = new Form('submit.php');
	
	if ($mission['hidden'] == 1){
		$form->table->addRow('Notice:', 'This mission has not yet been released.');
	}
	
	$form->AddSectionTitle(stripslashes(format($mission['title'])));
	
	$author = $roster->GetPerson($mission['author']);
	
	$form->table->addRow('Author', roster_link($author));
	$form->table->startRow();
	$form->table->addCell(stripslashes(format($mission['text'])), 2);
	$form->table->endRow();
	
	if ($mission['complete'] == 0 && $mission['hidden'] != 1) {
		if ($author->getID() != $login->getID()){
			$dupe = mysql_query("SELECT * FROM answers WHERE mission=$id AND person=" . $login->GetID(), $db);
			if ($dupe && !mysql_num_rows($dupe)) {
				$form->addHidden('id', $mission['id']);
				$form->addTextBox('Answer', 'answer');
				$form->addTextArea('Reasoning', 'reason');
				$form->AddSubmitButton('submit', 'Submit');
			}
		}
	} else {
	
		$form->table->addRow('Answer', stripslashes(format($mission['answer'])));
		
		$form->table->startRow();
		$form->table->addCell(stripslashes(nl2br($mission['results'])), 2);
		$form->table->endRow();
		
	}
	
	$form->EndForm();
} else {
	echo "<div>Unable to display mission ID $id.</div>";
}

page_footer();
?>

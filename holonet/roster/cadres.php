<?php
function title() {
	return 'Cadre Statistics';
}

function coders() {
	return array(666);
}

function output() {
	global $roster;
	
	roster_header();

	$table = new Table('', true);
	$table->StartRow();
	$table->AddHeader('Cadre');
	$table->AddHeader('Leader');
	$table->AddHeader('Members');
	$table->AddHeader('Points Used');
	$table->AddHeader('Points Left');
	$table->EndRow();

	foreach ($roster->GetCadres() as $cadre) {
		$leader = $cadre->GetLeader();
		
		$table->StartRow();
		$table->AddCell('<a href="' . internal_link('cadre', array('id'=>$cadre->GetID())) . '">' . html_escape($cadre->GetName()) . '</a>');
		$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$leader->GetID())) . '">' . html_escape($leader->GetName()) . '</a>');
		$table->AddCell('<div style="text-align: right">' . number_format($cadre->GetMemberCount()) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($cadre->GetMemberPoints()) . '</div>');
		$table->AddCell('<div style="text-align: right">' . number_format($cadre->GetAvailableMemberPoints()) . '</div>');
		$table->EndRow();
	}

	$table->EndTable();

	roster_footer();
}
?>

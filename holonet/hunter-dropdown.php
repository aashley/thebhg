<?php
function hunter_dropdown(&$form, $exclude = array(0, 16)) {
	global $roster;

	$divisions = $roster->GetDivisions('name');
	foreach ($divisions as $div) {
		if (in_array($div->GetID(), $exclude)) {
			continue;
		}
		if ($div->GetMemberCount()) {
			$members = $div->GetMembers('name');
			foreach ($members as $pleb) {
				$form->AddOption($pleb->GetID(), $div->GetName() . ': ' . $pleb->GetName());
			}
		}
	}
}
?>

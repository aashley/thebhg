<?php
$title = 'CSS Sandbox';
include('header.php');

class SandboxForm extends Form {
	function SandboxForm() {
		echo '<form method="post" name="sandbox" onsubmit="this.action = this.page.value; return true;">';
		if (session_id()) {
			$this->AddHidden(session_name(), session_id());
		}
		$this->table = new Table($title);
	}

	function AddPageSelector($label, $name) {
		$this->StartSelect($label, $name);
		$this->AddOption('/calendar.php', 'Calendar');
		$this->AddOption('/index.php', 'News');
		$this->AddOption('/prefs.php', 'Preferences');
		$this->AddOption('/search.php', 'Search');
		$this->AddOption('/sections.php', 'Sections');
		$this->EndSelect();
	}
}

$form = new SandboxForm();
$form->AddTextArea('CSS:', 'cssSandbox', '', 20, 60);
$form->AddPageSelector('Page:', 'page');
$form->AddSubmitButton('cssSandboxSubmit', 'Test CSS');
$form->EndForm();

include('footer.php');
?>

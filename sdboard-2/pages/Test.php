<?php
class Page_Test extends Page_Base {
	public function __construct($parts) {
		parent::__construct($parts, true);
	}

	public function Render() {
		$this->Header('Test');
		echo 'boards: ';
		var_dump($this->user->GetBoards());
		$this->Footer();
	}
}
?>

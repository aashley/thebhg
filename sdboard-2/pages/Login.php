<?php
class Page_Login extends Page_Base {
	public function __construct($parts) {
		parent::__construct($parts);
	}

	public function Render() {
		$this->Header('Log In');

		$form = new HTML_QuickForm('login', 'post', $_SERVER['REQUEST_URI']);

		$form->addElement('text', 'uid', 'User ID:', array('size' => 10, 'maxlength' => 10));
		$form->addElement('password', 'password', 'Password:', array('size' => 20, 'maxlength' => 255));
		$form->addElement('submit', null, 'Log In');

		$form->addRule('uid', 'The user ID must be entered.', 'required', null, 'client');
		$form->addRule('password', 'The password must be entered.', 'required', null, 'client');

		if ($form->validate())
			$this->LogIn($form);
		else
			$form->display();
		
		$this->Footer();
	}

	private function LogIn($form) {
		$values = $form->exportValues();
		$user = $this->system->GetUser($values['uid']);
		if ($user->CheckPassword($values['password'])) {
			setcookie('key', $user->GetKey(), time() + 31536000, '/', $_SERVER['HTTP_HOST'], 0);
			header('Location: '.substr($this->baseURL, 6));
		}
		else
			echo 'The user ID or password provided was incorrect. Please go back and try again.';
	}
}
?>

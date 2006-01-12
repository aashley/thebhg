<?php

class page_holonet_login extends holonet_page {

	public function buildPage() {

		$this->setTitle('Holonet Authentication');

		$form = new holonet_form();

		$form->addElement('text',
				'username',
				'ID Number:',
				array('size' => 20));

		$form->addElement('password',
				'password',
				'Password:',
				array('size' => 20));

		$form->addButtons('Login');

		$form->addRule('username',
				'You must enter your ID Number.',
				'required');

		$form->addRule('password',
				'You must enter your password.',
				'required');

		$form->addRule('username',
				'Your ID Number must be a number.',
				'numeric');

		$form->addFormRule('_authenticate_user');

		if ($form->validate()) {

			$values = $form->exportValues();

			$_SESSION['holonet'] = array(
					'active'	=> true,
					'user'		=> $GLOBALS['bhg']->roster->getPerson($values['username']),
					);

			header('Location: '.$_SERVER['REQUEST_URI']);

		} else {

			$this->addContent($form);

		}

	}

}

function _authenticate_user($values) {

	$errors = array();

	try {
		$user = $GLOBALS['bhg']->roster->getPerson($values['username']);
		
		if (!$user->checkPassword($values['password'])) {

			throw new bhg_not_found('Invalid password');

		}

	} catch (bhg_not_found $e) {
		$errors['username'] = 'Invalid ID Number/Password.';
  }

	return empty($errors) ? true : $errors;

}

?>

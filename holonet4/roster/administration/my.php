<?php

include_once 'objects/holonet/tab/bar.php';

class page_roster_administration_my extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('My Account');

		$bar = new holonet_tab_bar();

		$bar->addTab($this->buildDetails());
		$bar->addTab($this->buildPassword());

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		return true;

	}

	// {{{ buildDetails()

	public function buildDetails() {

		$user = $GLOBALS['bhg']->user;

		$tab = new holonet_tab('details_tab', 'My Details');

		$form = new holonet_form('my_details_'.$user->getID());

		$form->addElement('text',
				'name',
				'Name:',
				array(
					'maxlength'	=> 40,
					)
				);

		$form->addElement('text',
				'homepage',
				'Home Page:',
				array(
					'maxlength'	=> 200,
					)
				);

		$form->addElement('text',
				'email',
				'E-Mail Address:',
				array(
					'maxlength'	=> 150,
					)
				);

		$form->addElement('text',
				'aim',
				'AIM Screen Name:',
				array(
					'maxlength'	=> 250,
					)
				);

		$form->addElement('text',
				'icq',
				'ICQ Number:',
				array(
					'maxlength'	=> 15,
					)
				);

		$form->addElement('text',
				'irc',
				'IRC Nicknames:',
				array(
					'maxlength'	=> 5000,
					)
				);

		$form->addElement('text',
				'jabber',
				'Jabber ID:',
				array(
					'maxlength'	=> 250,
					)
				);

		$form->addElement('text',
				'msn',
				'MSN Passport Name:',
				array(
					'maxlength'	=> 250,
					)
				);

		$form->addElement('text',
				'yahoo',
				'Yahoo Messager ID:',
				array(
					'maxlength'	=> 250,
					)
				);

		$form->addElement('textarea',
				'quote',
				'Quote:',
				array(
					'rows'	=> 6,
					'cols'	=> 40,
					)
				);

		$form->addButtons('Save Changes');

		$form->addRule('name',
				'You must supply a name for your account.',
				'required');

		$form->addRule('email',
				'You must supply an e-mail address for your account.',
				'required');

		$form->addRule('email',
				'You must supply a valid e-mail address for your account.',
				'email');

		$form->addRule('icq',
				'Your ICQ number is not valid.',
				'numeric');

		$form->addRule('name',
				'Your name must be between 3 and 40 characters long.',
				'rangelength',
				array(3,40));

		$form->addRule('homepage',
				'Your home page URL must be between 10 and 200 characters long.',
				'rangelength',
				array(10,200));

		$form->addRule('email',
				'Your e-mail address must be between 8 and 150 characters long.',
				'rangelength',
				array(8,150));

		$form->addRule('icq',
				'Your ICQ number must be between 6 and 15 characters long.',
				'rangelength',
				array(6,15));

		$form->addRule('aim',
				'You AIM screen name can be no more than 250 characters long.',
				'maxlength',
				250);

		$form->addRule('jabber',
				'You Jabber ID can be no more than 250 characters long.',
				'maxlength',
				250);

		$form->addRule('msn',
				'You MSN Passport name can be no more than 250 characters long.',
				'maxlength',
				250);

		$form->addRule('yahoo',
				'You Yahoo Messager ID can be no more than 250 characters long.',
				'maxlength',
				250);

		$form->setDefaults(
				array(
					'name'			=> $user->getName(),
					'homepage'	=> $user->getURL(),
					'email'			=> $user->getEmail(),
					'aim'				=> $user->getAIM(),
					'icq'				=> $user->getICQ(),
					'irc'				=> $user->getIRCNicks(),
					'jabber'		=> $user->getJabber(),
					'msn'				=> $user->getMSN(),
					'yahoo'			=> $user->getYahoo(),
					'quote'			=> $user->getQuote(),
					)
				);

		if ($form->validate()) {

			$values = $form->exportValues();

			try {
				
				$tab->addContent('<p>Saving Changes...<br/>');
				$user->setName($values['name']);
				$tab->addContent('Name saved.<br/>');
				$user->setEmail($values['email']);
				$tab->addContent('Email saved.<br/>');
				$user->setURL($values['homepage']);
				$tab->addContent('Home Page saved.<br/>');
				$user->setQuote($values['quote']);
				$tab->addContent('Quote saved.<br/>');
				$user->setAIM($values['aim']);
				$tab->addContent('AIM Screen Name saved.');
				$user->setICQ($values['icq']);
				$tab->addContent('ICQ Number saved.');
				$user->setIRCNicks($values['irc']);
				$tab->addContent('IRC Nicknames saved.<br/>');
				$user->setJabber($values['jabber']);
				$tab->addContent('Jabber ID saved.<br/>');
				$user->setMSN($values['msn']);
				$tab->addContent('MSN Passport Name saved.<br/>');
				$user->setYahoo($values['yahoo']);
				$tab->addContent('Yahoo Messager ID saved.<br/>');
				$tab->addContent('</p>');

			} catch (bhg_fatal_exception $e) {

				$tab->addContent('</p>');
				$tab->addContent($e->__toString());

			}

		} else {

			$tab->addContent($form);

		}

		return $tab;

	}

	// }}}
	// {{{ buildPassword()

	public function buildPassword() {

		$user = $GLOBALS['bhg']->user;

		$tab = new holonet_tab('password_tab', 'Change Password');

		$form = new holonet_form('my_password_'.$user->getID());

		$form->addElement('password',
				'old_password',
				'Old Password:',
				array(
					'maxlength' => 20,
					)
				);

		$form->addElement('password',
				'password1',
				'New Password:',
				array(
					'maxlength' => 20,
					)
				);

		$form->addElement('password',
				'password2',
				'Confirm Password:',
				array(
					'maxlength' => 20,
					)
				);

		$form->addButtons('Change Password');

		$form->addRule('old_password',
				'You must enter your old password to validate your identity.',
				'required');

		$form->addRule('old_password',
				'Incorrect password.',
				'callback',
				'_checkOldPassword');

		$form->addRule('password1',
				'You must enter a new password.',
				'required');

		$form->addRule('password2',
				'You must confirm your new new password.',
				'required');

		$form->addRule(array('password1', 'password2'),
				'The passwords do not match.',
				'compare');

		$form->addRule('password1',
				'Password must be between include 6 and 20 characters long.',
				'rangelength',
				array(6,20));

		if ($form->validate()) {

			$values = $form->exportValues();

			try {
				
				$tab->addContent('<p>Changing Password... ');
				$user->savePassword($values['password1']);
				$tab->addContent('Success.</p>');

			} catch (bhg_fatal_exception $e) {

				$tab->addContent('Failure.</p>');
				$tab->addContent($e->__toString());

			}

		} else {

			$tab->addContent($form);

		}

		return $tab;

	}

	// }}}

}

function _checkOldPassword($value, $limit = null) {

	return $GLOBALS['bhg']->user->checkPassword($value);

}

?>

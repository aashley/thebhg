<?php

class page_roster_administration_members_my extends holonet_page {

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
		$bar->addTab($this->buildIPKC());

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		if (	 $user->getID() == 94
				|| $user->getPosition()->isEqualTo(bhg_roster::getPosition(2))) {
	
			return true;
	
		} else {
	
			return false;
	
		}

	}

	// {{{ buildDetails()

	public function buildDetails() {

		$user = $GLOBALS['bhg']->roster->getPerson(isset($_POST['editUser']) ? $_POST['editUser'] : $_POST['edit'][0]['person'][1]);

		$tab = new holonet_tab('details_tab', 'My Details');

		$form = new holonet_form('my_details_'.$user->getID());

		$form->addElement('hidden',	'tabBar', 'details_tab');
		$form->addElement('hidden',	'editUser', $_POST['edit'][0]['person'][1]);
		
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
					'homepage'		=> $user->getURL(),
					'email'			=> $user->getEmail(),
					'aim'			=> $user->getAIM(),
					'icq'			=> $user->getICQ(),
					'irc'			=> $user->getIRCNicks(),
					'jabber'		=> $user->getJabber(),
					'msn'			=> $user->getMSN(),
					'yahoo'			=> $user->getYahoo(),
					'quote'			=> $user->getQuote(),
					)
				);

		if ($form->validate()) {

			$values = $form->exportValues();

			try {
				
				$tab->addContent('<p>Saving Changes for ' . $user->getName() . '\'s ...</p><ul>');
				$user->setName($values['name']);
				$tab->addContent('<li>Name saved.</li>');
				$user->setEmail($values['email']);
				$tab->addContent('<li>Email saved.</li>');
				$user->setURL($values['homepage']);
				$tab->addContent('<li>Home Page saved.</li>');
				$user->setQuote($values['quote']);
				$tab->addContent('<li>Quote saved.</li>');
				$user->setAIM($values['aim']);
				$tab->addContent('<li>AIM Screen Name saved.</li>');
				$user->setICQ($values['icq']);
				$tab->addContent('<li>ICQ Number saved.</li>');
				$user->setIRCNicks($values['irc']);
				$tab->addContent('<li>IRC Nicknames saved.</li>');
				$user->setJabber($values['jabber']);
				$tab->addContent('<li>Jabber ID saved.</li>');
				$user->setMSN($values['msn']);
				$tab->addContent('<li>MSN Passport Name saved.</li>');
				$user->setYahoo($values['yahoo']);
				$tab->addContent('<li>Yahoo Messager ID saved.</li>');
				$tab->addContent('</ul>');

			} catch (bhg_fatal_exception $e) {

				$tab->addContent('</ul>');
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

		$user = $GLOBALS['bhg']->roster->getPerson(isset($_POST['editUser']) ? $_POST['editUser'] : $_POST['edit'][0]['person'][1]);

		$tab = new holonet_tab('password_tab', 'Change Password');

		$form = new holonet_form('my_password_'.$user->getID());

		$form->addElement('hidden',	'tabBar', 'password_tab');
		$form->addElement('hidden',	'editUser', $_POST['edit'][0]['person'][1]);
		
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
				
				$tab->addContent('<p>Changing ' . $user->getName() . '\'s Password... ');
				$user->setPassword($values['password1']);
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
	// {{{ buildIPKC()

	public function buildIPKC() {

		$user = $GLOBALS['bhg']->roster->getPerson(isset($_POST['editUser']) ? $_POST['editUser'] : $_POST['edit'][0]['person'][1]);

		$bio = $user->getBiographicalData();
		
		$tab = new holonet_tab('ipkc_tab', 'My IPKC');

		$form = new holonet_form('my_ipkc_'.$user->getID());

		$form->addElement('hidden',	'editUser', $_POST['edit'][0]['person'][1]);
		
		$form->addElement('hidden',	'tabBar', 'ipkc_tab');

		$form->addElement('text',
				'_home',
				'Homeworld:',
				array(
					'maxlength' => 250,
					)
				);

		$form->addElement('text',
				'_ages',
				'Age:',
				array(
					'maxlength' => 250,
					'size' 		=> 8,
					)
				);

		$form->addElement('text',
				'_specie',
				'Species:',
				array(
					'maxlength' => 250,
					)
				);

		$form->addElement('text',
				'_hei',
				'Height:',
				array(
					'maxlength' => 250,
					)
				);

		$form->addElement('text',
				'_sex',
				'Sex:',
				array(
					'maxlength' => 250,
					)
				);

		$form->addElement('text',
				'_image',
				'Image URL:',
				array(
					'maxlength' => 200,
					'size'		=> 35,
					)
				);

		$form->addRule('_ages',
				'Your Age must be a number.',
				'numeric');
				
		$form->setDefaults(
				array(
					'_home'		=> $bio->getHomeworld(),
					'_image'	=> $bio->getImageURL(),
					'_hei'		=> $bio->getHeight(),
					'_specie'	=> $bio->getSpecies(),
					'_sex'		=> $bio->getSex(),
					'_ages'		=> $bio->getAge(),
					)
				);
				
		$form->addButtons('Save Changes');

		if ($form->validate()) {

			$values = $form->exportValues();

			try {

				$tab->addContent('<p>Saving Changes...</p><ul>');
				$bio->setHomeworld($values['_home']);
				$tab->addContent('<li>Homeworld saved.</li>');
				$bio->setAge($values['_ages']);
				$tab->addContent('<li>Age saved.</li>');
				$bio->setSpecies($values['_specie']);
				$tab->addContent('<li>Species saved.</li>');
				$bio->setHeight($values['_hei']);
				$tab->addContent('<li>Height saved.</li>');
				$bio->setSex($values['_sex']);
				$tab->addContent('<li>Sex saved.</li>');
				$bio->setImageURL($values['_image']);
				$tab->addContent('<li>Image URL saved.</li>');
				$tab->addContent('</ul>');

			} catch (bhg_fatal_exception $e) {

				$tab->addContent('<p>Failure.</p>');
				$tab->addContent($e->__toString());

			}

		} else {

			$tab->addContent($form);

		}

		return $tab;

	}

	// }}}

}

?>

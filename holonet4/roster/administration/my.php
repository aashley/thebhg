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

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		return true;

	}

	public function buildDetails() {

		$user = $GLOBALS['bhg']->user;

		$tab = new holonet_tab('details', 'My Details');

		$form = new holonet_form();

		$form->addElement('text',
				'name',
				'Name:',
				array('width' 		=> 25,
							'maxlength'	=> 100,
					)
				);

		$form->addElement('text',
				'homePage',
				'Home Page:',
				array('width'			=> 25,
							'maxlength'	=> 200,
					)
				);

		$form->addElement('text',
				'emailAddress',
				'E-Mail Address:',
				array('width'			=> 25,
							'maxlength'	=> 150,
					)
				);

		$form->addElement('text',
				'aim',
				'AIM Screen Name:',
				array('width'			=> 25,
							'maxlength'	=> 250,
					)
				);

		$form->addElement('text',
				'icq',
				'ICQ Number:',
				array('width'			=> 25,
							'maxlength'	=> 15,
					)
				);

		$form->addElement('text',
				'irc',
				'IRC Nicknames:',
				array('width'			=> 25,
							'maxlength'	=> 5000,
					)
				);

		$form->addElement('text',
				'jabber',
				'Jabber ID:',
				array('width'			=> 25,
							'maxlength'	=> 250,
					)
				);

		$form->addElement('text',
				'msn',
				'MSN Passport Name:',
				array('width'			=> 25,
							'maxlength'	=> 250,
					)
				);

		$form->addElement('text',
				'yahoo',
				'Yahoo Messager ID:',
				array('width'			=> 25,
							'maxlength'	=> 250,
					)
				);

		$form->addElement('textarea',
				'quote',
				'Quote:',
				array('rows'	=> 6,
							'cols'	=> 40,
					)
				);

		$form->addButtons('Save Changes');

		if ($form->validate()) {

		} else {

			$tab->addContent($form);

		}

		return $tab;

	}

}

?>

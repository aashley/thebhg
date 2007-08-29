<?php

class page_roster_administration_cadre_details extends holonet_page {

	public function __construct($trail) {

		parent::__construct($trail);

		$this->secure = 1;

	}

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Cadre Management :: Details');

		$user = $GLOBALS['bhg']->user;
		
		if (!$user->isCadreLeader()){ $this->addBodyContent('You do not have authority to access this module.'); return; }
		
		$cadre = $user->getCadre();
		
		$form = new holonet_form('create_cadre');
		$renderer =& $form->defaultRenderer();
		
		$form->addElement('header', null, 'Cadre');
		$form->addElement('text', 'name', 'Name', array('size'=>15));
		$form->addElement('text', 'slogan', 'Slogan', array('size'=>25));
		$form->addElement('text', 'logo', 'URL of Logo', array('size'=>25));
		$form->addElement('text', 'homepageurl', 'URL of Homepage', array('size'=>25));
		$form->addElement('textarea', 'welcomemessage', 'Welcome Text for New Members<br /><br /><small>Text Replacements:<br />
			%N - Hunter\'s Name<br />
			%R - Hunter\'s Rank<br />
			%C - Cadre Name<br />
			%CR - Cadre Rank of User</small>', array('cols'=>45, 'rows'=>20));
		$filter['division'] = $cadre;
		$filter['threshold'] = -1;

		$elements = $GLOBALS['bhg']->roster->getRanks($filter);
		foreach ($elements as $element)
			$values[$element->getID()] = $element->getName() . ' ('.$element->getAbbrev().')';
		
		$wei =& $form->addElement('select', 'defaultrank', 'Default Rank', $values);
		
		$form->setDefaults(
			array(
				'name'				=> $cadre->getName(),
				'slogan'			=> $cadre->getSlogan(),
				'homepageurl'		=> $cadre->getHomePageURL(),
				'logo'				=> $cadre->getLogo(),
				'welcomemessage'	=> $cadre->getWelcomeMessage(),
				)
		);
		
		$wei->setSelected($cadre->getDefaultRank()->getID());
		
		$form->addButtons('Commit Changes');
		
		if ($form->validate()) {

			$values = $form->exportValues();

			try {

				$this->addBodyContent('<p>Attempting to update '. $cadre->getName() . '...<br />');
				
				$this->addBodyContent('Name...<br />');
				$cadre->setName($values['name']);
				$this->addBodyContent('Slogan...<br />');
				$cadre->setSlogan($values['slogan']);
				$this->addBodyContent('Home Page...<br />');
				$cadre->setHomePageURL($values['homepageurl']);
				$this->addBodyContent('Logo...<br />');
				$cadre->setLogo($values['logo']);
				$this->addBodyContent('Welcome Message...<br />');
				$cadre->setWelcomeMessage($values['welcomemessage']);
				$this->addBodyContent('Default Rank...<br />');
				$default = $GLOBALS['bhg']->roster->getRank($values['defaultrank']);

				if (!$cadre->getDefaultRank()->isEqualTo($default)){
					$cadre->getDefaultRank()->setLocked(false);
					$default->setLocked(true);
					$cadre->setDefaultRank($default);
				}
				
				$this->addBodyContent('Success.</p>');
				
			} catch (bhg_fatal_exception $e) {

				$this->addBodyContent('Failure.</p>');
				$this->addBodyContent($e->__toString());

			}

		} else {

			$this->addBodyContent($form);

		}

		$this->addSideMenu($GLOBALS['holonet']->roster->getAdministrationMenu());

	}

	public function canAccessPage(bhg_roster_person $user) {

		return $user->isCadreLeader();

	}

}

?>

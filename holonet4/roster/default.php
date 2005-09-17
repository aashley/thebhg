<?php

include_once 'objects/holonet/tab/bar.php';

class page_roster_default extends holonet_page {

	public function buildPage() {

		$this->setTitle('Roster');

		$bar = new holonet_tab_bar;

		$bar->addTab($this->buildWelcome());
		$bar->addTab($GLOBALS['holonet']->roster->buildSearch());

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->roster->getDivisionMenu());

	}

	public function buildWelcome() {

		// XXX Must be replaced with appropriate search call.
		$underlord = $GLOBALS['bhg']->roster->getPerson(666);

		$tab = new holonet_tab('welcome', 'Welcome');

		$tab->addContent('<p>To a hunter in the Bounty Hunter\'s Guild, Imperial Credits are everything. They are the lifeblood of their very existence. To some, the accumulation of wealth is a means of bragging their superiority. To others, it is a mark of honor, that only definitive mark of a hunter\'s standing. However, to the select few - to the select best - Imperial Credits hold none of these meanings. ICs are simply a means to an end. They are nothing more than the only real and efficient way to completing a bounty hunt and tracking down your target.</p>');

		$tab->addContent('<p>Welcome to the always-updated and current roster of the BHG. The roster was created and is maintained by '.htmlspecialchars($underlord->getPosition()->getName()).' <a href="/roster/person/'.$underlord->getID().'">'.htmlspecialchars($underlord->getName()).'</a>. This is the only place where you can gauge your worthiness and honor by seeing how many ICs you have earned and accumulated over your dubious BHG career, and is also the only place where you can wallow in self pity as your hunter brethren pass you by in rank and honor because of numerous failures, bumbles, and general inactivity you have shown.</p>');

		$tab->addContent('<p>Your IPKC has cleared the security check: you are who you claim to be.You have permission to proceed. View your status in the BHG, hunter. And always remember these words: <i>insert quote here</i>.</p>');

		return $tab;

	}

}

?>
<?php

class page_medalboard_default extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Medal Board');

		$bar = new holonet_tab_bar();

		$bar->addTab($this->buildWelcome());

		$this->addBodyContent($bar);

		$this->addSideMenu($GLOBALS['holonet']->medalboard->getSideMenu());

	}

	public function buildWelcome() {

		$tab = new holonet_tab('welcome', 'Welcome');

		$tab->addContent("<p>A cold wind nips at your skin as you approach the large "
				."teltic iron doors that lead in to one the most respected buildings on "
				."Planetoid Cernun, The Medals Hall. Like entering any other building "
				."your hunter training takes over and you look for the security system "
				."that surely must guard such a holy place, yet you notice no such "
				."system. Odd.</p>");
		
		$tab->addContent("<p>Upon your approach the iron doors silently swing open "
				."and you step into the foyer. You immediately notice the soothing "
				."warmth of the interior and that although no lighting tubes can be "
				."seen the room is brightly lit. Behind a small desk across from the "
				."entrance sits a young man whom you think you recognize but his name "
				."escapes you. He looks up from his desk and speaks in a firm but not "
				."overpowering voice. 'Your weapons please sir.' When he is satisfied "
				."that you are unarmed he allows you to pass through a door that you "
				."didn't know was there and into the main hall.</p>");
		
		$tab->addContent("<p>You stand at one end of a large rectangular hall with "
				."a ceiling so high that it escapes your vision. The hall has been "
				."constructed of Tengati Stone (Tengati stone can only be mined from the "
				."Black Hole in the Tegati sector, where it takes on the qualities of "
				."said black hole and absorbs all light and sound) and is relatively "
				."undecorated. The only obtrusions are the four doors and the eight "
				."foot tall mirror at the far end.</p>");
		
		$tab->addContent("<p>The doors are spaced ten feet apart, two on each side of "
				."the hall and are marked by brilliant red holographic symbols that only "
				."a trained hunter can decipher. If you can't decipher the symbols you "
				."will end up somewhere that your worst nightmares can't even touch, so "
				."be confident in your translation before entering. If you can decipher "
				."them you will come to no harm and may enter safely.</p>");
		
		$tab->addContent("<p>As you near the mirror you realize that it is no ordinary "
				."mirror, but a swirling mass of silver liquids that reflects a rough "
				."image of yourself. As you stare deeper into the mirror a new image of "
				."you begins to take form but, something isn't right, you look somewhat "
				."older. As the image settles into a vision of the future you, you can "
				."tell that your future will get much, much...</p>");

		$tab->addContent("<p>Welcome Text &copy; Reece Inc. &lt;barddoh@yahoo.com&gt; "
				."1999</p>");

		return $tab;

	}

}

?>

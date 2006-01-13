<?php

include_once 'HTML/Page2.php';
include_once 'Net/UserAgent/Detect.php';

class holonet_page extends HTML_Page2 {

	private $menus = array();
	
	private $trail = array();

	protected $pageBuilt = false;

	protected $secure = false;

	public function __construct($trail) {

		parent::__construct(array(
					'lineend'		=> 'unix',
					'tab'				=> '  ',
					'cache'			=> false,
					'charset'		=> 'utf-8'
					));

		$this->trail = $trail;
		
		if ( strpos($_SERVER['HTTP_ACCEPT'], 'application/xhtml+xml') ) {
			$this->setDoctype('XHTML 1.0 Strict');
			$this->setMimeEncoding('application/xhtml+xml');
		} else {
			// HTML that qualifies for XHTML 1.0 Strict automatically
			// also complies with XHTML 1.0 Transitional, so if the
			// requesting browser doesn't take the necessary mime type
			// for XHTML 1.0 Strict, let's give it what it can take.
			$this->setDoctype('XHTML 1.0 Transitional');
		}

		if (Net_UserAgent_Detect::getBrowser(array('ie')) == 'ie')
			$this->disableXmlProlog();

		$this->addStyleSheet('/style/holonet.css', 'text/css', 'screen');
		$this->addStyleSheet('/style/tab.css', 'text/css', 'screen');
		$this->addStyleSheet('/style/table.css', 'text/css', 'screen');

		$this->addScript('/js/overlib_mini.js');
		$this->addScript('/js/overlib_hideform_mini.js');

	}

	public function addSideMenu($menus) {

		if (!is_array($menus))
			$menus = array($menus);

		foreach ($menus as $menu) {
			if ($menu instanceof holonet_menu) {
				$this->menus[] = $menu;
			} else {
				throw bhg_validation_exception('Invalid menu added.');
			}
		}

	}

	public function buildPage() {

		$this->addBodyContent('<p>You should override buildPage() and actually add some content.</p>');

	}

	public function canAccessPage(bhg_roster_person $user) {

		return true;

	}

	public function getTrailingElements() {

		return $this->trail;

	}

	public function isSecure() {

		return $this->secure;

	}

	public function toHtml() {

		if (!$this->pageBuilt)
			$this->buildPage();

		$content = array();

		$content[] = '<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>';

		$content[] = '<div id="header">';

		$content[] = '<div id="logo"><div id="logo01"></div><div id="logo02"></div><div id="logo03"></div><div id="logo04"></div><div id="logo05"></div><div id="logo06"></div><div id="logo07"></div><div id="logo08"></div><div id="logo09"></div><div id="logo10"></div><div id="logo11"></div><div id="logo12"></div><div id="logo13"></div><div id="logo14"></div></div>';

		$content[] = $GLOBALS['holonet']->getMenu();
		$content[] = $GLOBALS['holonet']->current->getMenu();

		$content[] = '</div>';

		$content[] = '<div id="sidemenu">';

		foreach ($this->menus as $menu) {

			$menu->class = 'section';
			$content[] = $menu;

		}

		$content[] = '</div>';

		$content[] = '<div id="content">';

		$content[] = '<h1>'.$this->getTitle().'</h1>';

		$this->addBodyContent($content, HTML_PAGE2_PREPEND);

		$this->addBodyContent('</div>
				<div id="footer">
					<p>All rights reserved 1995-2005; original contents are protected by the 
					United States (US) Copyright Act in accordance with the Bounty Hunters 
					Guild <a href="http://www.thebhg.org/disclaimer">Disclaimers and 
					Copyrights</a> detailed herein. This site abides by the Bounty Hunters
					Guild <a href="http://www.thebhg.org/privacy">Privacy Policy</a>.</p>
				</div>');

		return parent::toHtml();

	}

}

?>

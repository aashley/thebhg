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
		
		if ( false ) { // strpos($_SERVER['HTTP_ACCEPT'], 'application/xhtml+xml') ) {
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
		$this->addStyleSheet('/style/form.css', 'text/css', 'screen');

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

		$content[] = '<div id="mainmenu_block">';
		$content[] = $GLOBALS['holonet']->getMenu();
		$content[] = '<br class="clear-left"/>';
		$content[] = '</div>';
		$content[] = '<div id="main_body">';
		$content[] = '<div id="header">';
		$content[] = '<img id="logo" src="/images/logo.png" />';

		$content[] = <<<EOSCRIPT
	<div id='headerAdd' style="display:none;"><script language='JavaScript' type='text/javascript'>
	<!--
	// Insert click tracking URL here
  document.phpAds_ct0 ='Insert_Clicktrack_URL_Here'

	var awrz_rnd = Math.floor(Math.random()*99999999999);
  var awrz_protocol = location.protocol.indexOf('https')>-1?'https:':'http:';
  if (!document.phpAds_used) document.phpAds_used = ',';
	document.write ("<" + "script language='JavaScript' type='text/javascript' src='");
	document.write (awrz_protocol+"//banner.thebhg.org/adjs.php?n=a3da495a");
	document.write ("&zoneid=20");
	document.write ("&exclude=" + document.phpAds_used);
	document.write ("&loc=" + escape(window.location));
	if (document.referrer)
    document.write ("&referer=" + escape(document.referrer));
	document.write ('&r=' + awrz_rnd);
	document.write ("&ct0=" + escape(document.phpAds_ct0));
	document.write ("'><" + "/script>");
//-->
</script></div>
EOSCRIPT;

		$content[] = '<div id="moduletitle"><h1 class="current_module">'.$GLOBALS['holonet']->current->title.'</h1></div>';

		$content[] = $GLOBALS['holonet']->current->getMenu();

		$content[] = '<br class="clear"/>';
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

		$this->addBodyContent('</div></div>
				<div id="footer">
					<p>All rights reserved 1995-2007; original contents are protected by the 
					United States (US) Copyright Act in accordance with the Bounty Hunters 
					Guild <a href="http://www.thebhg.org/disclaimer">Disclaimers and 
					Copyrights</a> detailed herein. This site abides by the Bounty Hunters
					Guild <a href="http://www.thebhg.org/privacy">Privacy Policy</a>.</p>
				</div>');

		return parent::toHtml();

	}

}

?>

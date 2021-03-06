<?php

include 'objects/holonet/menu.php';
include 'objects/holonet/module.php';
include 'objects/holonet/page.php';
include 'objects/holonet/form.php';
include 'objects/holonet/tab/bar.php';
include 'HTML/Table.php';

class holonet {

	private $entry = array();

	private $mainmenu = null;

	public $current = null;

	public function __construct() {

		$this->mainmenu = new holonet_menu('mainmenu.xml');
		$this->mainmenu->showTitle = false;
		$this->mainmenu->id = 'mainmenu';

		$parts = explode('/', $_SERVER['PATH_INFO']);

		$url = '';

		for ($i = 0; $i < sizeof($parts); $i++) {

			if (strlen($parts[$i]) > 0) {

				$this->current = $this->$parts[$i];

				$url = implode('/', array_slice($parts, $i + 1));

				break;

			}

		}

		if (is_null($this->current))
			$this->current = $this->holonet;

	}

	public function execute() {

		session_name('Holonet4');

		session_start();

		if (isset($_SESSION['holonet']['user']) && is_numeric($_SESSION['holonet']['user'])) {

			$GLOBALS['bhg']->user = $_SESSION['holonet']['user'];

		}

		$url = trim($_SERVER['PATH_INFO'], '/');
		$slash = strpos($url, '/');
		if ($slash !== false) {

			$url = substr($url, $slash + 1);
			
		}

		try {
			
			$page = $this->current->getPage($url);

			if ($page->isSecure()) {

				if (	 isset($_SESSION['holonet']['active']) 
						&& $_SESSION['holonet']['active'] == true
						&& $GLOBALS['bhg']->user instanceof bhg_roster_person) {

					if (   $page->canAccessPage($GLOBALS['bhg']->user)
							|| in_array($GLOBALS['bhg']->user->getID(), $GLOBALS['gods'])) {

						$page->display();

					} else {

						$page = $this->holonet->getPage('noauth');
						$page->display();

					}

				} else {

					$page = $this->holonet->getPage('login');
				
					$page->display();

				}

			} else {
			
				$page->display();

			}

		} catch (Exception $e) {

			$page = $this->holonet->getPage('exception');

			$page->setException($e);

			$page->display();

		}

	}

	public function getMenu() {
		return $this->mainmenu;
	}

	public function __get($e) {

		$e = strtolower($e);

		if (	 isset($this->entry[$e])
				&& $this->entry[$e] instanceof holonet_module) {

			return $this->entry[$e];

		} else {

			$filename = $e.'/module.php';

			if (!file_exists($filename))
				throw new bhg_fatal_exception('Can not location holonet module.');

			include_once $filename;

			$classname = 'holonet_module_'.$e;

			$this->entry[$e] = new $classname();

			if ($this->entry[$e] instanceof holonet_module) {

				return $this->entry[$e];

			} else {

				unset($this->entry[$e]);

				throw new bhg_fatal_exception('Invalid holonet module requested.');

			}

		}

	}

	static public function formatCredits($amount) {
		return self::pluralise('IC', $amount);
	}

	static public function formatDuration($seconds) {
		$then = time() - $seconds;

		$anniv = mktime(0, 0, 0, date('m', $then), date('d', $then), date('Y'));
		if ($anniv > time()) {
			$years = date('Y') - date('Y', $then) - 1;
		}
		else {
			$years = date('Y') - date('Y', $then);
		}
		
		$days = date('z') - date('z', $then);
		if (date('L', $then) == 1
		 && date('L') == 0
		 && date('z') > 60)
			$days++;
		if ($days < 0) {
			$days += (date('L', mktime(0, 0, 0, date('m'), date('d'), date('Y') - 1)) ? 366 : 365);
		}

		$weeks = floor($days / 7);
		$days %= 7;

		$seconds %= 86400;
		$hours = floor($seconds / 3600);
		$seconds %= 3600;
		$minutes = floor($seconds / 60);
		$seconds %= 60;

		if ($days) {
			$bits[] = self::pluralise('day', $days);
		}
		if ($weeks) {
			$bits[] = self::pluralise('week', $weeks);
		}
		if ($years) {
			$bits[] = self::pluralise('year', $years);
		}
		
		if (count($bits)) {
			$bits = array_reverse($bits, true);
			if (count($bits) > 2) {
				$last = $bits[0];
				unset($bits[0]);
				$str = implode(', ', $bits);
				$str .= ' and ' . $last;
			}
			else {
				$str = implode(' and ', $bits);
			}
		}
		else {
			$str = '0';
		}

		return $str;
	}

	static public function output($obj) {

		if ($obj instanceof bhg_roster_cadre) {

			return '<a href="/roster/cadre/'
						.$obj->getID()
						.'">'
						.htmlspecialchars($obj->getName())
						.'</a>';

		} elseif ($obj instanceof bhg_roster_division) {

			return '<a href="/roster/division/'
						.$obj->getID()
						.'">'
						.htmlspecialchars($obj->getName())
						.'</a>';

		} elseif ($obj instanceof bhg_roster_person) {

			return '<a href="/roster/person/'
						.$obj->getID()
						.'">'
						.htmlspecialchars($obj->getName())
						.'</a>';

		} elseif ($obj instanceof bhg_roster_position) {

			return '<a href="/roster/position/'
						.$obj->getID()
						.'">'
						.htmlspecialchars($obj->getName())
						.'</a>';

		} elseif ($obj instanceof bhg_roster_rank) {

			return '<a href="/roster/rank/'
						.$obj->getID()
						.'">'
						.htmlspecialchars($obj->getName())
						.'</a>';

		} elseif ($obj instanceof bhg_medalboard_group) {

			return '<a href="/medalboard/group/'
						.$obj->getID()
						.'">'
						.htmlspecialchars($obj->getName())
						.'</a>';

		} elseif ($obj instanceof bhg_medalboard_medal) {

			return '<a href="/medalboard/group/'
						.$obj->getGroup()->getID()
						.'">'
						.htmlspecialchars($obj->getName())
						.'</a>';

		} elseif ($obj instanceof bhg_library_book) {
			
			return '<a href="/library/'
				.$obj->getID()
				.'">'
				.htmlspecialchars($obj->getName())
				.'</a>';
			
		} elseif ($obj instanceof bhg_library_chapter) {
			
			return '<a href="/library/'
				.$obj->getBook()->getID()
				.'/'
				.$obj->getID()
				.'">'
				.htmlspecialchars($obj->getName())
				.'</a>';
			
		} elseif ($obj instanceof bhg_library_section) {
			
			return '<a href="/library/'
				.$obj->getChapter()->getBook()->getID()
				.'/'
				.$obj->getChapter()->getID()
				.'#'
				.$obj->getID()
				.'">'
				.htmlspecialchars($obj->getName())
				.'</a>';

		} elseif ($obj instanceof bhg_starchart_system) {

			return '<a href="/starchart/system/'
				.$obj->getID()
				.'">'
				.htmlspecialchars($obj->getName())
				.'</a>';

		} elseif ($obj instanceof bhg_starchart_planet) {

			return '<a href="/starchart/planet/'
				.$obj->getID()
				.'">'
				.htmlspecialchars($obj->getName())
				.'</a>';

		} elseif ($obj instanceof bhg_starchart_site) {

			return '<a href="/starchart/site/'
				.$obj->getID()
				.'">'
				.htmlspecialchars($obj->getName())
				.'</a>';
			
		} elseif (method_exists($obj, 'getName')) {

			return htmlspecialchars($obj->getName());

		} else {

			return (string) $obj;

		}

	}

	static public function pluralise($name, $amount) {

		$amount = number_format($amount);

		if ($amount != '1')
			return "$amount {$name}s";
		else
			return "$amount $name";

	}

	static public function buildList(bhg_core_list $obj, $ordered = false) {

		if ($obj->count() == 0)
			return '';

		if ($ordered) {
			
			$list = "<ol>\n";

		} else {

			$list = "<ul>\n";

		}

		foreach ($obj as $item) {

			$list .= "\t<li>".holonet::output($item)."</li>\n";

		}

		if ($ordered) {

			$list .= "</ol>\n";

		} else {

			$list .= "</ul>\n";

		}

		return $list;

	}
	
}

$GLOBALS['holonet'] = new holonet();

?>

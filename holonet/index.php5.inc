<?php
	foreach ($modules as $mod) {
		$GLOBALS['modtext'] = false;
		if ($mod->nodeName == 'link') {
			$url = $mod->getElementsByTagName('url')->item(0);
			$name = $mod->getElementsByTagName('name')->item(0);
			$GLOBALS['modtext'] = '<a href="' . $url->textContent . '">' . str_replace(' ', '&nbsp;', htmlspecialchars($name->textContent)) . '</a>';
		}
		elseif ($mod->nodeName == 'module' && !$mod->hasAttribute('hidden')) {
			$dir = $mod->getElementsByTagName('directory')->item(0);
			$name = $mod->getElementsByTagName('name')->item(0);
			if ($dir->textContent == $module) {
				$found = true;
				$GLOBALS['modtext'] = '<a href="' . $url->textContent . '">' . str_replace(' ', '&nbsp;', htmlspecialchars($name->textContent)) . '</a>';
			}
			else {
				if (!$found) {
					$before += 2;
				}
				$GLOBALS['modtext'] = '<a href="' . internal_link('index', array(), $dir->textContent) . '">' . str_replace(' ', '&nbsp;', htmlspecialchars($name->textContent)) . '</a>';
			}
		}

	if ($modtext) {
		$modarray[] = '<li>' . $modtext . "</li>";
	}
}
?>

<?php
	$modxml = new DomDocument();
	$modxml->load('modules.xml');
	$modules = $modxml->documentElement->childNodes;
	foreach ($modules as $mod) {
		if ($mod->nodeName == 'module') {
			$dir = $mod->getElementsByTagName('directory')->item(0);
			if ($dir->textContent == $module) {
				$name = $mod->getElementsByTagName('name')->item(0);
				$title = $name->textContent . ' :: ' . title();
				break;
			}
		}
	}
?>

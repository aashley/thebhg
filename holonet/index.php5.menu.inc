<?php
	if (file_exists($mdir . '/menu.xml')) {
		$menuxml = new DomDocument();
		$menuxml->load($mdir . '/menu.xml');
		$items = $menuxml->getElementsByTagName('item');
	}
	else {
		$items = false;
	}
	
	if ($items) {
		echo '<tr>';
		if ($before) {
			echo '<td colspan=' . $before . ' class="MODULE">&nbsp;</td>';
		}
		echo '<td colspan=' . $after . '><span class="SUBMENU">';
		$menuarray = array();
		foreach ($items as $item) {
			if (!$item->hasAttribute('hidden')) {
				$name = $item->getElementsByTagName('name')->item(0);
				$pg = $item->getElementsByTagName('page')->item(0);
				$menuarray[] = '<a href="' . internal_link($pg->textContent) . '">' . str_replace(' ', '&nbsp;', htmlspecialchars($name->textContent)) . '</a>';
			}
		}
		echo implode(' | ', $menuarray) . '</span></td></tr>';
	}
?>

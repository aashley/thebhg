<?php

include_once 'objects/holonet/tab.php';

class holonet_tab_bar extends HTML_Common2 {

	private $tabs = array();

	public function addTab(holonet_tab $tab) {

		$this->tabs[] = $tab;

	}

	public function toHtml() {

		$bar = '<div class="tabbar">';
		$html = <<<EOH
<script type="text/javascript">
<!--
function enableTabs() {

	var divs = document.getElementsByTagName('div');
	for (var i = 0; i < divs.length; i++) {

		if (divs[i].className == 'tabbar') {

			divs[i].style.display = 'block';

		}

	}
	
}

function switchTab(id) {

	var divs = document.getElementsByTagName('div');
	for (var i = 0; i < divs.length; i++) {

		if (divs[i].className == 'tab') {

			divs[i].style.display = 'none';

		} else if (divs[i].className == 'tabbar') {

			var tabs = divs[i].getElementsByTagName('a');

			for (var j = 0; j < tabs.length; j++) {

				tabs[j].className = '';

			}

		}
		
	}

	var tab = document.getElementById(id);
	if (tab) {

		tab.style.display = 'block';

	}

	var selectedTab = document.getElementById(id + '-tab');
	if (selectedTab) {

		selectedTab.className = 'selected';

	}
	
}
//-->
</script>
EOH;
		$tabHTML = '';

		foreach ($this->tabs as $tab) {

			$bar .= '<a id="'
						 .htmlspecialchars($tab->getID())
						 .'-tab" href="#" onclick="switchTab(\''
						 .htmlspecialchars($tab->getID())
						 .'\'); return false;">'
						 .htmlspecialchars($tab->getTitle())
						 .'</a>';

			$tabHTML .= $tab->toHtml();

		}
		
		$bar .= '</div>';
		$tabHTML .= '';

		$html .= $bar
						.$tabHTML;

		$id = $this->tabs[0]->getID();

		if (isset($_REQUEST['tabBar']) && strlen($_REQUEST['tabBar']) > 0) {

			foreach ($this->tabs as $tab) {

				if ($tab->getID() == $_REQUEST['tabBar']) {

					$id = $_REQUEST['tabBar'];

					break;

				}

			}

		}

		$html .= <<<EOH
<script type="text/javascript">
<!--
enableTabs();
switchTab('$id');
//-->
</script>
EOH;

		return $html;

	}

}

?>

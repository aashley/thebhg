<?php
include_once('table.php');
include_once('blocktable.php');

class Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		$pd = PARENT_DIR;
		return <<<EOS
a {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
table.navbar {
	border-top: solid 1px WindowText;
	border-bottom: solid 1px WindowText;
	border-left: 0;
	border-right: 0;
}
th.block, th.table {
	font-weight: bold;
	text-align: left;
	background: Window;
}
td.block, td.table {
	background: Window;
}
table.table {
	border-spacing: 1px;
	background: WindowText;
}
table.block {
	border-spacing: 1px;
	width: 100%;
	background: WindowText;
}
EOS;
	}

	function GetHeader($title) {
	}

	function GetAuthors() {
		return array(666);
	}
}
?>

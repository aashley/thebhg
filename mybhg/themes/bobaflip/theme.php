<?php
class Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		$pd = PARENT_DIR;
		return <<<EOS
body {
	background-color: white;
	background-image: url("{$pd}themes/boba/boba.jpg");
	background-repeat: no-repeat;
	background-attachment: fixed;
	background-position: center;
	font-family: Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 10pt;
	color: black;
	margin-top: 0;
}
a {
	text-decoration: none;
	font-weight: bold;
	color: black;
}
a:hover {
	text-decoration: underline;
}
th {
	background: url("{$pd}themes/boba/th.png");
	font-weight: bold;
	text-align: left;
	border: solid 1px black;
}
td {
	background: url("{$pd}themes/boba/td.png");
	border: solid 1px black;
}
table {
	border-collapse: collapse;
	border: solid 1px black;
}
table.block {
	width: 100%;
}
div#title-menu {
	z-index: 1;
	position: fixed;
	top: auto;
	left: 0;
	right: 0;
	bottom: 0;
	width: 100%;
	height: 14pt;
	background: url("{$pd}themes/boba/th.png");
	border-top: solid 1px black;
}
div#title {
	position: fixed;
	bottom: 0;
	left: 2px;
	width: 33%;
	height: 14pt;
	text-align: left;
	font-weight: bold;
}
div#menu {
	position: fixed;
	bottom: 0;
	right: 2px;
	width: 65%;
	height: 14pt;
	text-align: right;
}
div.menuitem {
	display: inline;
}
div.menuitem:before {
	content: " :: ";
}
div.menuitem:first-child:before {
	content: "";
}
div.menuitem-sep {
	display: none;
}
div#content {
	position: absolute;
	width: 78%;
	left: 0;
	top: 3px;
	margin-left: 3px;
	padding: 1px;
}
div#blocks {
	position: absolute;
	width: 20%;
	right: 0;
	top: 3px;
	margin-right: 3px;
	padding: 1px;
}
hr {
	border: 0;
	border-top: solid 1px black;
	color: transparent;
	background-color: transparent;
	height: 1px;
	margin-top: 1em;
	margin-bottom: 1em;
}
EOS;
	}

	function GetHeader($title) {
	}

	function GetAuthors() {
		return array(666);
	}

	function GetName() {
		return 'Boba';
	}
}
?>

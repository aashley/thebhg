<?php
class Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		return <<<EOS
body {
	background: #f7ffff;
	font-family: Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 10pt;
	color: black;
	margin: 0;
}
a {
	text-decoration: none;
	color: #0a37b3;
}
a:hover {
	text-decoration: underline;
}
table {
	border-collapse: collapse;
}
table.block {
	width: 100%;
}
tr {
	vertical-align: top;
}
td, th {
	border: solid 1px #000040;
	text-align: left;
}
td {
	background: #d8fcff;
}
th {
	background: #61a3b3;
	font-weight: bold;
}
div#title {
	position: absolute;
	width: auto;
	left: 0;
	top: 0;
	height: 20px;
	text-align: left;
	font-weight: bold;
	vertical-align: middle;
	background: #61a3b3;
	border: solid 1px #000040;
	border-right: 0;
	margin: 3px;
	z-index: 1;
}
div#menu {
	position: absolute;
	width: 97%;
	right: 0;
	top: 0;
	height: 20px;
	text-align: right;
	vertical-align: middle;
	background: #61a3b3;
	border: solid 1px #000040;
	border-left: 0;
	margin: 3px;
}
div.menuitem, div.menuitem-sep {
	display: inline;
}
div#content {
	position: absolute;
	width: 78%;
	left: 0;
	top: 33px;
	margin-left: 3px;
	padding: 1px;
}
div#blocks {
	position: absolute;
	width: 20%;
	right: 0;
	top: 33px;
	margin-right: 3px;
	padding: 1px;
}
hr {
	border: 0;
	border-top: solid 1px #000040;
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

	function GetName() {
		return 'Blue Monday';
	}

	function GetAuthors() {
		return array(666);
	}
}
?>

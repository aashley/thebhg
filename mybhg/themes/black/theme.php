<?php
class Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		return <<<EOS
body {
	background: black;
	font-family: Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 10pt;
	color: white;
	margin: 0;
}
a {
	text-decoration: none;
	color: #edd100;
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
	border: solid 1px #a88c00;
	text-align: left;
}
td {
	background: black;
}
th {
	background: #2b2b2b;
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
	margin: 3px;
	vertical-align: middle;
	border: solid 1px #a88c00;
	border-right: 0;
	background: #2b2b2b;
	z-index: 1;
}
div#menu {
	position: absolute;
	width: 97%;
	right: 0;
	top: 0;
	height: 20px;
	text-align: right;
	margin: 3px;
	vertical-align: middle;
	border: solid 1px #a88c00;
	border-left: 0;
	background: #2b2b2b;
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
		return 'Black Gold';
	}
}
?>

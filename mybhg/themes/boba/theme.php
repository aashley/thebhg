<?php
class Theme_Boba extends Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		return <<<EOS
body {
	background-color: white;
	background-image: url("/themes/boba/boba.jpg");
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
	background: url("/themes/boba/th-trans.png");
	font-weight: bold;
	text-align: left;
	border: solid 1px black;
}
td {
	background: url("/themes/boba/td-trans.png");
	border: solid 1px black;
}
table {
	border-collapse: collapse;
	border: solid 1px black;
}
table.fullwidth {
	width: 100%;
}
div#header {
	z-index: 1;
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	height: 14pt;
	background: url("/themes/boba/th-trans.png");
	border-bottom: solid 1px black;
}
div#title {
	position: fixed;
	top: 0;
	left: 2px;
	width: 33%;
	height: 14pt;
	text-align: left;
	font-weight: bold;
}
div#menu {
	position: fixed;
	top: 0;
	right: 2px;
	width: 65%;
	height: 14pt;
	text-align: right;
}
div#menu ul, div#menu ul li {
	display: inline;
	margin: 0;
	padding: 0;
}
div#menu ul li:before {
	content: " :: ";
}
div#menu ul li.first:before {
	content: "";
}
div.menuitem-sep {
	display: none;
}
div#content {
	position: absolute;
	width: 78%;
	left: 0;
	top: 16pt;
	margin-left: 3px;
	padding: 1px;
}
div#blocks {
	position: absolute;
	width: 20%;
	right: 0;
	top: 16pt;
	margin-right: 3px;
	padding: 1px;
}
div#blocks div.block div.header {
	background: url("/themes/boba/th-trans.png");
	font-weight: bold;
	text-align: left;
	border-bottom: solid 1px black;
}
div#blocks div.block {
	background: url("/themes/boba/td-trans.png");
	border: solid 1px black;
	margin-bottom: 14pt;
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

	function IECompliant() {
		return false;
	}
}
?>

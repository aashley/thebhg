<?php
class Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		return <<<EOS
body {
	background: white;
	font-family: Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 10pt;
	color: black;
	margin: 0;
}
a {
	font-weight: bold;
	text-decoration: none;
	color: black;
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
	border: solid 1px black;
	text-align: left;
}
td {
	background: #f0f0f0;
}
th {
	background: #c0c0c0;
	font-weight: bold;
}
div#title-menu {
	position: absolute;
	width: 100%;
	height: 145px;
	top: 0;
	background-image: url("/themes/default/header.png");
	background-position: top center;
	background-repeat: no-repeat;
}
div#title {
	position: absolute;
	width: auto;
	left: 0;
	top: 125px;
	height: 20px;
	text-align: left;
	border-top: solid 2px black;
	border-bottom: solid 2px black;
	font-weight: bold;
	margin-left: 3px;
	vertical-align: middle;
	z-index: 1;
}
div#menu {
	position: absolute;
	width: 97%;
	right: 0;
	top: 125px;
	height: 20px;
	text-align: right;
	border-top: solid 2px black;
	border-bottom: solid 2px black;
	margin-right: 3px;
	vertical-align: middle;
}
div.menuitem, div.menuitem-sep {
	display: inline;
}
div#content {
	margin: 3px;
	padding-top: 153px;
}
div#blocks {
	float: right;
	width: 20%;
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

	function GetAuthors() {
		return array(666, 1699);
	}

	function GetName() {
		return 'Holonet';
	}
}
?>

<?php
class Theme_Holonet extends Theme {
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
table.fullwidth {
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

div#header {
	position: absolute;
	height: 125px;
	top: 0;
	left: 0;
	width: 100%;
	vertical-align: middle;
	font-weight: bold;
	background-image: url("/themes/default/header.png");
	background-repeat: no-repeat;
	background-position: top center;
}
div#title {
	float: left;
	text-align: left;
	position: absolute;
	height: 20px;
	top: 125px;
	left: 0;
	width: 35%;
	padding-left: 3px;
	border-top: solid 2px black;
	border-bottom: solid 2px black;
}
div#menu {
	text-align: right;
	position: absolute;
	height: 20px;
	top: 125px;
	right: 0;
	width: 95%;
	border-top: solid 2px black;
	border-bottom: solid 2px black;
	z-index: 1;
}
div#menu ul {
	display: inline;
}
div#menu ul li {
	display: inline;
	line-height: 20px;
	border-left: solid 1px black;
	padding-left: 1em;
	padding-right: 1em;
}

div#content {
	position: absolute;
	top: 152px;
	left: 0;
	width: 79%;
	padding-left: 3px;
}

div#blocks {
	position: absolute;
	top: 152px;
	left: 80%;
	right: 0;
	width: 20%;
}
div.block {
	border: solid 1px black;
	margin-bottom: 2em;
	background: #f0f0f0;
}
div.block div.header {
	background: #c0c0c0;
	border-bottom: solid 1px black;
	font-weight: bold;
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

	function IECompliant() {
		return true;
	}
}
?>

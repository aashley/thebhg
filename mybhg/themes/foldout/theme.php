<?php
class Theme_FoldOut extends Theme {
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
.fullwidth {
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

#header {
	position: fixed;
	height: 40px;
	width: 26px;
	bottom: 0;
	left: 0;
	background-image: url("/themes/foldout/boba-trans.png");
	background-repeat: no-repeat;
	background-position: top left;
	z-index: 1;
}
#header:hover {
	border-top: solid 1px black;
	background-color: white;
	width: 100%;
}

div#title {
	display: none;
}
div#title:before {
	content: "Bounty Hunter's Guild :: ";
}
#header:hover div#title {
	display: block;
	position: absolute;
	left: 30px;
	top: 15px;
	height: 25px;
	font-size: 20px;
	font-weight: bold;
}

#menu {
	display: none;
}
#header:hover #menu {
	display: block;
	position: absolute;
	left: 30px;
	top: 0;
	height: 15px;
	font-size: 12px;
}
#menu ul {
	display: inline;
	margin: 0;
	padding: 0;
}
#menu ul li {
	display: inline;
	margin: 0;
	padding: 0;
}
#menu ul li:before {
	content: " :: ";
}
#menu ul li.first:before {
	content: "";
}

#content {
	position: absolute;
	top: 3px;
	left: 0;
	width: 79%;
	padding-left: 3px;
}

#blocks {
	position: absolute;
	top: 3px;
	left: 80%;
	right: 0;
	width: 20%;
}
.block {
	border: solid 1px black;
	margin-bottom: 2em;
	background: #f0f0f0;
}
.block .header {
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
		return array(666);
	}

	function GetName() {
		return 'Fold Out';
	}

	function IECompliant() {
		return false;
	}
}
?>

<?php
include_once('table.php');
include_once('blocktable.php');

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
}
span.title {
	font-size: 20pt;
	font-weight: bold;
}
table.navbar {
	border-top: solid 2px black;
	border-bottom: solid 2px black;
}
a {
	font-weight: bold;
	text-decoration: none;
	color: black;
}
a:hover {
	text-decoration: underline;
}
table.tclass {
	border-collapse: collapse;
}
table.block {
	width: 100%;
}
table.block td {
	background: #f0f0f0;
}
table.tclass th {
	background: #c0c0c0;
	border: solid 1px black;
	font-weight: bold;
	text-align: left;
}
table.tclass td {
	border: solid 1px black;
}
table.tclass caption {
	caption-side: top;
	font-weight: bold;
}
table.tclass *.top-left {
	border-top: solid 1px black;
	border-left: solid 1px black;
	border-right: 0;
	border-bottom: solid 1px black;
	background-color: #c0c0c0;
	background-image: url("/themes/encircle/images/top-left.png");
	background-repeat: no-repeat;
	background-position: top left;
}
table.tclass *.top-right {
	border-top: 0;
	border-left: 0;
	border-right: 0;
	border-bottom: solid 1px black;
	background-color: #c0c0c0;
	background-image: url("/themes/encircle/images/top-right.png");
	background-repeat: no-repeat;
	background-position: top right;
}
table.tclass *.bottom-left {
	border-top: solid 1px black;
	border-left: 0;
	border-right: 0;
	border-bottom: 0;
	background-color: #c0c0c0;
	background-image: url("/themes/encircle/images/bottom-left.png");
	background-repeat: no-repeat;
	background-position: bottom left;
}
table.tclass *.bottom-right {
	border-top: solid 1px black;
	border-left: 0;
	border-right: 0;
	border-bottom: 0;
	background-color: #c0c0c0;
	background-image: url("/themes/encircle/images/bottom-right.png");
	background-repeat: no-repeat;
	background-position: bottom right;
}
.no-left {
	border-left: 0;
}
.no-right {
	border-right: 0;
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

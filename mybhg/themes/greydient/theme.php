<?php
class Theme {
	function Theme() {
	}

	function GetStyleSheet() {
		$pd = PARENT_DIR;
		return <<<EOS
body {
	background: black;
	font-family: Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 10pt;
	color: #e7e7e7;
	margin: 0;
}
table.navbar {
	border: 0;
	background-color: #303030;
	background-image: url("{$pd}themes/greydient/images/navbar.png");
	background-repeat: repeat-x;
	background-position: center;
}
table.tclass {
	margin: 0;
	background: #303030;
	border-spacing: 0;
}
table.block {
	width: 100%;
}
table.tclass td {
	border: none;
}
table.tclass th {
	font-weight: bold;
	text-align: left;
	border: none;
}
table.tclass caption {
	caption-side: top;
	font-weight: bold;
}
th.first {
	background-image: url("{$pd}themes/greydient/images/upper-th.png");
	background-repeat: repeat-x;
	background-position: top left;
}
th.last {
	background-image: url("{$pd}themes/greydient/images/lower-th.png");
	background-repeat: repeat-x;
	background-position: bottom left;
}
a, input[type="submit"], input[type="reset"], input[type="button"] {
	border: 0;
	background-color: transparent;
	font-family: Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 10pt;
	font-weight: bold;
	color: white;
	cursor: pointer;
	text-decoration: none;
}
a:hover, input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover {
	text-decoration: underline;
}
EOS;
	}

	function GetHeader($title) {
	}

	function GetAuthors() {
		return array(666);
	}

	function GetName() {
		return 'Charcoal';
	}
}
?>

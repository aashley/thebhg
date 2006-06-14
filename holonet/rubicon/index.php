<?php
function title() {
    return 'Index';
}



function output() {

	echo '<script language="javascript" type="text/javascript" src="/rubicon/type.js"></script>';
   
	echo '<DIV style="width: 700; height: 500; background-color: black; color: green;" ID="textDestination"></DIV>';
	
	?><SCRIPT LANGUAGE="JavaScript">
<!--
var text = "<tt>Please Wait<form method='post' action='trace.php'><br />...<br />...<br />Please Input Trace Key<br /><input style='background: black; color: green; border: 0;' type='text'></form><blink>&lt;</blink>"
startTyping(text, 50, "textDestination");
//-->
	</script><?
}
?>

<?php
function title() {
    return 'Index';
}

function output() {

	echo '<script language="javascript" type="text/javascript" src="/rubicon/type.js"></script>';
   
	echo '<DIV style="width: 700; height: 500; background-color: black; color: green;" ID="textDestination"></DIV>';
	
	?><SCRIPT LANGUAGE="JavaScript">
<!--hide
var text = "<tt>holonet::__loadBootModule('/specialist/rubicon.ijc')<br />...<br />...<br />...<br />Done<br /><br />holonet::__cacheHold('/specialist/traceroute.iio', 'trcrt')<br /><br />...<br />...<br />...<br />Done<br /><br />execute rubiconTerminal.kib<br />...<br />Done<br /><br /><br /><br />Welcome to the Rubicon Terminal, root.<br /><br />executeCache('trcrt')<br /><br />Executing the TraceRoute Program.<br />...<br />...<br />Please Wait<form method='post' action='trace.php'><br />...<br />...<br /><input type='hidden'>Please hit return to continue<br />...<blink>..."
startTyping(text, 50, "textDestination");
//-->
	</script><?
}
?>

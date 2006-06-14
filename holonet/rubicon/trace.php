<?php
function title() {
    return 'Index';
}

function reject() {
        header('WWW-Authenticate: Basic realm="Rubicon Terminal :: Enter Passcode for root [xxxx-xxxx-xxxx]"');
        header('HTTP/1.1 401 Unauthorized');
	echo 'Your passcode was rejected by the rubicon server.';
	die();
}

function output() {

	echo '<script language="javascript" type="text/javascript" src="/rubicon/type.js"></script>';
   
	echo '<DIV style="width: 700; height: 500; background-color: black; color: green;" ID="textDestination"></DIV>';
	
	?><SCRIPT LANGUAGE="JavaScript">
<!--
var yes = 1;
<?

if (isset($_REQUEST['fiz'])){
	exit;
} elseif (isset($_REQUEST['kad'])){
	if (in_array($_REQUEST['kad'], array(2292, 2154, 1600, 2687))){
				
	} else {
		echo "var yes = 0\n";
		echo 'var text = "cannot resolve ping...<br />...<br />...<br /><br />Terminating<br />...<br />...<br />Connection Terminated"';
	}
} elseif (isset($_REQUEST['pxr'])){
	echo "var id=prompt('Please Enter Local Starting Point for Trace (xxxx)', '')\n";
	echo "var cernun = '&kad=' + id\n";
	echo 'var text = "ping resolve on id beginning"';
} else {
	if (empty($_SERVER['PHP_AUTH_USER']) || strlen($_SERVER['PHP_AUTH_USER']) == 0)
		reject();
	else {
		if ($_SERVER['PHP_AUTH_PW'] != 'K121-6234-AXJA' || $_SERVER['PHP_AUTH_USER'] != 'root')
			reject();
	}
	echo "var cernun = '&pxr'\n";
	echo 'var text = "entering passcode:<br />****-****-****<br />validating<br />...<br />...<br />...<br />approved<br /><br />Successfully logged in to RubicoNet Server 129K9 [LYARNA-GUILD]<br /><br />...<br />..."';
	
}

echo "\n";
?>
startTyping(text, 50, "textDestination");
//-->
	</script><?
}
?>

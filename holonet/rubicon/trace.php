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

<?

if (isset($_REQUEST['kad'])){
	
} elseif (isset($_REQUEST['pxr'])){
	echo "var id=prompt('Please Enter Local Starting Point for Trace (xxxx)', ' ')";
	echo "var cernun = '&kad=' + id";
	echo 'var text = "ping resolve on id beginning"';
} else {
	if (empty($_SERVER['PHP_AUTH_USER']) || strlen($_SERVER['PHP_AUTH_USER']) == 0)
		reject();
	else {
		if ($_SERVER['PHP_AUTH_PW'] != 'K121-6234-AXJA' || $_SERVER['PHP_AUTH_USER'] != 'root')
			echo $_SERVER['PHP_AUTH_PW'];
	}
	echo "var cernun = '&pxr'";
	echo 'var text = "entering passcode:<br />****-****-****<br />validating<br />...<br />...<br />...<br />approved<br /><br />Successfully logged in to RubicoNet Server 129K9 [LYARNA-GUILD]<br /><br />...<br />..."';
}
			
?>
startTyping(text, 50, "textDestination");
//-->
	</script><?
}
?>

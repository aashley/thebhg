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

	if (isset($_COOKIE["bhg_hashk"])){
	
		echo 'Cannot open terminal. Resource locked out by specialist for endangering guild holonet integrity.';
		exit;
		
	}
	
	echo '<script language="javascript" type="text/javascript" src="/rubicon/type.js"></script>';
   
	echo '<DIV style="width: 700; height: 500; background-color: black; color: green;" ID="textDestination"></DIV>';
	
	?><SCRIPT LANGUAGE="JavaScript">
<!--
var yes = 1;
var pause = 0;
var keep = 0;
var speed = 50;
<?

if (isset($_REQUEST['hhcbqa'])){
	echo "var speed = 0\n";
	echo "var yes = 0;\n";
	echo "var keep = 1;\n";
	echo 'var text = "#file <br /># local.trcrt.log<br /><br />[122.1239.1235.123] holonet_terminal{kasa}_solrahl<br />[127.0.0.1] routing_trml{asa}_pltalon<br />[12841.1231.21418.212] subspace_router{jha}_firrerre<br />[182.2125.231.1231] subspace_router{jga}_moorja<br />[12312.734.862.258] holonet_terminal{kkd}_duro<br />[127.215.1927.1952] holonet_terminal{rra}_kuat<br />[17123.1241.73245.1235] subspace_router{laa}_zeltros<br />[217.1285.123.731587] routing_trml{jha}_toydaria<br />[1581.1925.8341.8123:8322] server_core{KVA}_shadda"';
} elseif (isset($_REQUEST['yad'])){

	if ($_REQUEST['yad'] == '2552-1231-235-233'){
		echo "var cernun = '&hhcbqa'\n";
		echo 'var text = "passcode accepted<br /><br />Tracing route<br />...<br />...<br />...<br />...<br />...<br />[127.215.1927.1952] holonet_terminal{rra}_kuat<br />[17123.1241.73245.1235] subspace_router{laa}_zeltros<br />[217.1285.123.731587] routing_trml{jha}_toydaria<br />[1581.1925.8341.8123:8322] server_core{KVA}_shadda<br />...<br />...<br />...<br />trace complete<br /><br />holonet::__loadSpike(\'/specialist/spike4.spk\')<br /><br />spikeRout protocol initiated<br />...<br />...<br />...<br />Done<br /><br />holonet::__loadCache(\'/local.trcrt.log\')"';
	} else {
		$time = time() + (60 * 30);
		setcookie('bhg_hashk', md5(time()), $time);
		echo "var yes = 0\n";
		echo "var pause = 1\n";
		echo 'var text = "incorrect passcode<br />...<br />...possible slicing attempt<br />...<br />...spiking signal<br />...<br />...<br />traceback spike ping initiated<br />...<br />...<br />...<br />...<br >...<br />...ident invalid. Locking out resource ID<br />...Terminating<br />...<br />...<br />Connection Terminated<br />"';
	}
		
} elseif (isset($_REQUEST['fiz'])){
	echo "var id=prompt('Please Enter Administrator Passcode to continue on Hyperspace Route Node DURO', '')\n";
	echo "var cernun = '&yad=' + id\n";
	echo 'var text = "ping resolve on id beginning"';
} elseif (isset($_REQUEST['kad'])){
	if (in_array($_REQUEST['kad'], array(2292, 2154, 1600, 2687))){
		echo "var cernun = '&fiz'\n";
		echo 'var text = "id ping successful. Tracing route<br />...<br />...<br />...<br />...<br />...<br />[122.1239.1235.123] holonet_terminal{kasa}_solrahl<br />[127.0.0.1] routing_trml{asa}_pltalon<br />[12841.1231.21418.212] subspace_router{jha}_firrerre<br />[182.2125.231.1231] subspace_router{jga}_moorja<br />[12312.734.862.258] holonet_terminal{kkd}_duro<br /><br />...trace pause...<br /><br />...<br />...<br />system requires validation to continue traceroute<br />...<br />"';
		
	} else {
		echo "var yes = 0\n";
		echo 'var text = "cannot resolve ping...<br />...<br />...<br /><br />Terminating<br />...<br />...<br />Connection Terminated<br />"';
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
startTyping(text, speed, "textDestination");
//-->
	</script><?
}
?>

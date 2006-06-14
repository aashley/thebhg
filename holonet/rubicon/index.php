<?php
function title() {
    return 'Index';
}



function output() {

	echo '<script language="javascript" type="text/javascript" src="/javascript/type.js"></script>';
   
	echo '<DIV ID="textDestination"></DIV>';
	
	?><SCRIPT LANGUAGE="JavaScript">
<!--
startTyping(text, 50, "textDestination");
//-->
	</script><?
}
?>

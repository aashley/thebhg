<?php
if ($art) {
	$article = new Article($art);

	if ($article->GetID() > 0) {
		echo $article->LayoutParse();
	} else {
		echo "<center>Invalid Fiction ID number";
	} 
} 
} else {
echo "<center>Fiction ID required to proceed.";
} 

?>
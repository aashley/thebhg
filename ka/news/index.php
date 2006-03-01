<?php	
	require_once 'functions.inc';
	require_once '../Layout.inc';	
	
	$items = get_news('kabals-4ever');
	$items = array_merge($items, get_news('citadel-38learn'));
	
	usort($items, sort_by_date);

	if (count($items) < 10)
		$num = count($items);
	else
		$num = 10;

	$template = file_get_contents('news.tpl');
	reset($items);
	for ($i = 0; $i < $num; $i++) {
		$item = current($items);
		echo $item->Render($template);
		next($items);
	}
	
	ConstructLayout();
?>

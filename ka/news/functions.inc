<?php
	function sort_by_date($a, $b) {
		if ($a->GetTimestamp() < $b->GetTimestamp()) {
			return 1;
		}
		elseif ($a->GetTimestamp() > $b->GetTimestamp()) {
			return -1;
		}
		else {
			return 0;
		}
	}

	function get_news($id, $posts = 10) {
		$news = new News($id);
		$items = $news->GetNews($posts, 'posts');
		if ($items)
			return $items;
		else
			return array();
	}
?>

<?php
function internal_link($page, $args = array(), $mod = false, $anchor = '') {
	global $module;
	if ($mod === false) {
		$mod = $module;
	}
	if (session_id()) {
		$args[session_name()] = session_id();
	}
	$url = $_SERVER['PHP_SELF'] . '?module=' . $mod . '&amp;page=' . urlencode($page);
	if (count($args)) {
		foreach ($args as $key=>$value) {
			$url .= '&amp;' . urlencode($key);
			if (strlen($value) > 0) {
				$url .= '=' . urlencode($value);
			}
		}
	}
	if ($anchor) {
		$url .= '#' . $anchor;
	}
	return $url;
}
?>

<?php
// The blocks themselves.
include_once('blocks/block.php');
include_once('blocks/text.php');
include_once('blocks/rss.php');
include_once('blocks/timeline.php');
include_once('blocks/quote.php');
include_once('blocks/links.php');
include_once('blocks/calendar.php');

// A convenience function to identify the block type and return the correct
// object.
function get_block($id, &$db) {
	$result = mysql_query('SELECT type FROM blocks WHERE id=' . $id, $db);
	if ($result && mysql_num_rows($result)) {
		switch (strtolower(mysql_result($result, 0, 'type'))) {
			case 'text':
				return new TextBlock($id, $db);
			case 'rss':
				return new RSSBlock($id, $db);
			case 'timeline':
				return new TimelineBlock($id, $db);
			case 'quote':
				return new QuoteBlock($id, $db);
			case 'links':
				return new LinksBlock($id, $db);
			case 'calendar':
				return new CalendarBlock($id, $db);
		}
	}
	return false;
}

// Returns the possible block types and their labels.
function get_block_types() {
	return array(
		'Text'=>TextBlock::GetLabel(),
		'RSS'=>RSSBlock::GetLabel(),
		'Timeline'=>TimelineBlock::GetLabel(),
		'Quote'=>QuoteBlock::GetLabel(),
		'Links'=>LinksBlock::GetLabel(),
		'Calendar'=>CalendarBlock::GetLabel()
	);
}
?>

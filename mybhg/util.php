<?php
function hr() {
	echo '<hr />';
}

function display_articles($items) {
	if (count($items)) {
		foreach ($items as $item) {
			// Check if we need to put a "Read More" link on the page.
			$lines = explode("\n", $item->GetMessage(), 2);
			$read_more = (count($lines) > 1 && strlen($item->GetMessage()) > 512) || (count($lines) == 1 && strlen($item->GetMessage()) > 1024);
			if (count($lines) > 1 && strlen($item->GetMessage()) > 512) {
				$blurb = $lines[0];
			}
			elseif (count($lines) == 1 && strlen($item->GetMessage()) > 1024) {
				$blurb = substr($item->GetMessage(), 0, 1022) . '...';
			}
			else {
				if (stristr($item->GetMessage(), '<br />') !== false) {
					$blurb = $item->GetMessage();
				}
				else {
					$blurb = $item->Render('%message%');
				}
			}
			$blurb = autolink($blurb);
			$columns = ($read_more ? 3 : 2);
			
			echo '<a name="' . $item->GetID() . '"></a>';
			$article = new BlockTable();
			$article->StartRow();
			$article->AddHeader($item->GetTitle(), $columns);
			$article->EndRow();
			$article->StartRow();
			$article->AddCell($blurb, $columns);
			$article->EndRow();
			$article->StartRow();
			$article->AddHeader('<a href="section.php?id=' . $item->GetSectionID() . '">' . $item->GetSectionName() . '</a>', 1, 1, '20%');
			if ($read_more) {
				$article->AddHeader('<a href="article.php?id=' . $item->GetID() . '">Read More...</a> (' . number_format(strlen($item->GetMessage())) . ' bytes)', 1, 1, '25%');
			}
			$poster = $item->GetPoster();
			$article->AddHeader('<div align="right">Posted by <a href="http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=' . $poster->GetID() . '">' . $poster->GetName() . '</a> on ' . date('j F Y \a\t G:i:s T', $item->GetTimestamp()) . '</div>', 1, 1, ($read_more ? '55%' : '80%'));
			$article->EndRow();
			$article->EndTable();
			echo '<br />';
		}
	}
	else {
		echo 'No articles found.';
	}
}

function display_calendar_events($events, $show_sections = false) {
	$table = new Table();
	
	$table->StartRow();
	$table->AddHeader('Upcoming Events', $show_sections ? 3 : 2);
	$table->EndRow();

	$table->StartRow();
	if ($show_sections) {
		$table->AddHeader('Section');
	}
	$table->AddHeader('Time');
	$table->AddHeader('Title');
	$table->EndRow();

	foreach ($events as $event) {
		$table->StartRow();
		if ($show_sections) {
			$table->AddCell('<a href="section.php?id=' . $event->GetSection() . '">' . get_section_name($event->GetSection()) . '</a>');
		}
		$table->AddCell(date('j F Y \a\t G:i:s T', $event->GetTime()));
		$table->AddCell('<a href="event.php?id=' . $event->GetID() . '">' . htmlspecialchars($event->GetTitle()) . '</a>');
		$table->EndRow();
	}

	$table->EndTable();
}

function get_section_name($id) {
	global $news;

	foreach ($news->GetAvailableSections() as $sec) {
		if ($sec['id'] == $id) {
			return $sec['name'];
		}
	}
	return false;
}

function autolink($text) {
	return preg_replace(array('|http://(\\S+)|', '|(\\S+)@([A-Za-z0-9-]+)\\.([A-Za-z0-9-]+)|'), array('<a href="http://\\1">http://\\1</a>', '<a href="mailto:\\1@\\2.\\3">\\1@\\2.\\3</a>'), $text);
}
?>

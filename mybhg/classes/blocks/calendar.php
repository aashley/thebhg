<?php
/**
 * A block to display upcoming BHG events.
 *
 * @package MyBHG
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @access public
 */
class CalendarBlock extends Block {
	function CalendarBlock($id, &$db) {
		Block::Block($id, $db);
		
	}

	function GetHTML() {
		global $my_sections;
		
		$days = array();
		$output = array();
		$calendar = new Calendar($this->db);
		$events = $calendar->GetEventsByTime(0, $this->data, $my_sections);
		if ($events) {
			foreach ($events as $event) {
				$days[date('j F Y', $event->GetTime())][] = '<a href="/event.php?id=' . $event->GetID() . '">[' . date('G:i', $event->GetTime()) . '] ' . htmlspecialchars($event->GetTitle()) . '</a>';
			}
			foreach ($days as $day=>$content) {
				$output[] = '<b>' . $day . '</b><br />' . implode('<br />', $content);
			}
			return implode('<br /><br />', $output);
		}
		else {
			return 'There are no upcoming events.';
		}
	}

	function GetLabel() {
		return 'Days To Show:';
	}
}

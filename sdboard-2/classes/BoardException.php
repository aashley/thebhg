<?php
class BoardException extends Exception {
	public function __construct($message) {
		$message = "<b>Message: </b>$message<br /><br /><b>Debug Backtrace: </b>" . BoardException::FormatBacktrace() . '</ol>';
		parent::__construct($message);
	}

	static public function FormatBacktrace() {
		$message = '<ol>';
		foreach (debug_backtrace() as $frame) {
			if (isset($frame['class']) && strlen($frame['class']) > 0) {
				$call = $frame['class'] . $frame['type'] . $frame['function'];
			}
			else {
				$call = $frame['function'];
			}
			if (isset($frame['args'])) {
				$call .= '(<span style="color: #777">' . implode('</span>, <span style="color: #777">', $frame['args']) . '</span>)';
			}
			else {
				$call .= '()';
			}
			$message .= "<li>$call <span style='color: #aaa'>called from</span> {$frame['file']}:{$frame['line']}</li>";
		}
		$message .= '</ol>';
		return $message;
	}
}
?>

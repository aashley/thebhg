<?php

/**
 * Base exception.
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Core
 * @version $Rev$ $Date$
 */

/**
 * Base exception.
 *
 * @author Adam Ashley <aashley@optimiser.com>
 * @package BHG
 * @subpackage Core
 * @version $Rev$ $Date$
 */
abstract class bhg_core_exception extends Exception {

	// {{{ properties

	/**
	 * Render HTML Errors?
	 *
	 * @var boolean html_errors
	 */
	protected $html_errors = true;

	// }}}

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param string Error Message
	 * @param integer Error code
	 * @return void
	 */
	public function __construct($message = '', $code = 0) {

		parent::__construct($message, $code);

		$this->html_errors = (ini_get('html_errors') == 1);

	}

	// }}}

	// {{{ __toString()

	/**
	 * Render this exception.
	 *
	 * return string
	 */
	public function __toString($nohtml = false, $extra = null) {

		$output = '';

		if (!$nohtml && $this->html_errors) $output .= '<b>';

		$output .= 'Exception: ';

		if (!$nohtml && $this->html_errors) $output .= '</b>';

		$output .= $this->getMessage();

		if (!$nohtml && $this->html_errors) $output .= '<br/>';
		
		if (!is_null($extra))
			$output .= $extra;
		
		$output .= "\n";

		$output .= $this->renderTrace($nohtml);

		if (!$nohtml && $this->html_errors) $output .= '<br/>';

		$output .= "\n";

		return $output;

	}

	// }}}
	// {{{ renderTrace()

	/**
	 * Render the backtrace to a string
	 *
	 * @return string
	 */
	public function renderTrace($nohtml = false) {

		if (!$nohtml && $this->html_errors && class_exists('HTML_Table')) {

			include_once 'HTML/Table.php';

			$trace = $this->getTrace();

			$table = new HTML_Table();

			$table->setAttributes(array('class' => 'backtrace'));

			$table->setCaption('Backtrace');

			$head = $table->getHeader();
			
			$head->addRow(
					array('&nbsp;',
								'File',
								'Line',
								'Call'),
					array(),
					'TH');

			$body = $table->getBody();

			foreach ($trace as $step => $data) {

				$function = (isset($data['class']) ? htmlspecialchars($data['class'].$data['type']) : '').$data['function'].'(';

				$first = true;

				if (isset($data['args'])) {

					foreach ($data['args'] as $arg) {

						if ($first) {
							$first = false;
						} else {
							$function .= ', ';
						}

						if (is_array($arg)) {

							$argout = print_r($arg, true);
							$argout = strip_tags($argout);
							$argout = nl2br($argout);
							$argout = str_replace(array(' ', '"'), array('&nbsp;', ''), $argout);

							$function .= '<span onmouseover="return overlib(\'&lt;pre&gt;'.$argout.'&lt;/pre&gt;\');" onmouseout="return nd();">Array</span>';

						} elseif (is_object($arg)) {

							$argout = print_r($arg, true);
							$argout = strip_tags($argout);
							$argout = nl2br($argout);
							$argout = str_replace(' ', '&nbsp;', $argout);

							$function .= '<span onmouseover="return overlib(\'&lt;pre&gt;'.$argout.'&lt;/pre&gt;\');" onmouseout="return nd();">Object '.get_class($arg).'</span>';

						} elseif (is_numeric($arg)) {

							$function .= (string)$arg;

						} else {

							$function .= '\''.$arg.'\'';

						}

					}

				}

				$function .= ')';

				$body->addRow(
						array('#'.$step,
									'<span onmouseover="return overlib(\''.$data['file'].'\');" onmouseout="return nd();">'.basename($data['file']).'</span>',
									$data['line'],
									$function,
							));
			}

			return $table->toHtml();

		} else {

			return $this->getTraceAsString();

		}

	}

	// }}}
	
}

?>

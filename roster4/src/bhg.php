<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Core
 * @Version $Rev:$ $Date:$
 */

/** Include PEAR::Log */
include_once 'Log.php';

/**
 * BHG Data Systems Entry point object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Core
 * @Version $Rev:$ $Date:$
 */
class bhg {

	// {{{ properties

	/**
	 * Storage for entry point objects
	 *
	 * @var array
	 */
	private $entry = array();

	/**
	 * Database structure
	 *
	 * @var array
	 */
	private $database = array(
			'no_created' => array(),
			'no_updated' => array(),
			'no_deleted' => array(),
			'no_object' => array(),
			);

	/**
	 * PEAR::Log object
	 *
	 * @var object
	 */
	private $log = null;

	/**
	 * The BHG Code ID accessing this system
	 *
	 * @var object
	 */
	private $code = null;

	// }}}

	// {{{ __construct()

	public function __construct() {

		$this->log = &Log::singleton('file', 'out.log', 'bhg');

	}

	// }}}

	// {{{ __get()

	/**
	 * Access function
	 * 
	 * @param string Name of interface to access
	 * @return object
	 */
	public function __get($e) {

		$e = strtolower($e);

		if ($e == 'database')
			return $this->database;

		if (	 isset($this->entry[$e])
				&& $this->entry[$e] instanceof bhg_entry) {

			return $this->entry[$e];

		} else {

			$classname = 'bhg_'.$e;

			$this->entry[$e] = new $classname();

			if ($this->entry[$e] instanceof bhg_entry) {

				return $this->entry[$e];

			} else {

				unset($this->entry[$e]);

				return false;

			}

		}

	}

	// }}}
	// {{{ __set()

	/**
	 * Set function
	 *
	 * return false
	 */
	public function __set($name, $val) {

		return false;

	}

	// }}}

	// {{{ isError() [static]

	static public function isError($object) {

		return $object instanceof bhg_error;

	}

	// }}}
	// {{{ loadObject() [static]

	/**
	 * Load a BHG Object
	 *
	 * This is a singleton system to load a specific object from within
	 * the generation 3 system. It should be called as:
	 *
	 *	$member = &$GLOBALS['gen3']->loadObject('Gen3_Member', 1);
	 *
	 * @static
	 * @param string The name of the object to load
	 * @param string The reference we wish to load
	 * @param boolean Force the reloading of this object
	 * @return mixed An instance of the requested object
	 */
	static public function loadObject($classname, $ref, $force = false) {

		static $instances;
		if (!isset($instances)) $instances = array();

		$now = time();

		$error = false;

		if (class_exists($classname)) {

			if (!isset($instances[$classname][$ref]) 
					|| is_null($instances[$classname][$ref])
					|| $force
					|| (	 isset($instances[$classname][$ref]['time'])
							&& ($instances[$classname][$ref]['time'] + 30) <= $now)) {

				$GLOBALS['bhg']->log('Creating instance of '.$classname.' with #'.$ref, PEAR_LOG_DEBUG);

				$instances[$classname][$ref]['time'] = $now;
				$instances[$classname][$ref]['object'] = new $classname($ref);

				if ($instances[$classname][$ref]['object']->createFailure()) {

					$GLOBALS['bhg']->log('Creation failed.');

					$error = true;

				}				

			}

			$return = &$instances[$classname][$ref]['object'];

			if ($error) {

				unset($instances[$classname][$ref]);

				$GLOBALS['bhg']->log('Return failure', PEAR_LOG_DEBUG);
				return false;
				
			}

			$GLOBALS['bhg']->log('Returning object', PEAR_LOG_DEBUG);
			return $return;

		} else {

			$GLOBALS['bhg']->log('Return failure - could not find class', PEAR_LOG_DEBUG);
			return false;

		}

	}

	// }}}
	// {{{ log()

	/**
	 * log stuff to the data system log file
	 *
	 * @param string message
	 * @param int level
	 */
	public function log($message, $level = PEAR_LOG_INFO) {

		$this->log->log($message, $level);

	}

	// }}}
	// {{{ setCodeID()

	/**
	 * Set the Code ID that has been assigned to the code accessing the roster
	 *
	 * @param string The Code ID
	 * @return boolean
	 */
	public function setCodeID($code) {

		$this->code = new bhg_core_code(strtolower(md5($code)));

		if ($this->code->createFailure()) {

			$this->code = null;

			return false;

		} else {

			return true;

		}

	}

	// }}}
	// {{{ hasPerm()

	/**
	 * Does this code id have the requested permission
	 *
	 * @param string the permission name
	 * @return boolean
	 */
	public function hasPerm($perm) {

		$func = 'has'.strtolower($perm);

		if (is_null($this->code)) {

			return false;

		} elseif ($this->code->hasgod()) {

			return true;

		} else {
			
			return $this->code->$func();

		}

	}

	// }}}

}

/**
 * Dummy object to ensure that only certain ones are accessed thru the global
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Core
 * @version $Rev:$ $Date:$
 */
class bhg_entry {

}

class bhg_error {

	// {{{ __construct()

	public function __construct($error) {

		$this->errorMessage = $error;

	}

	// }}}

	// {{{ getMessage()

	public function getMessage() {

		return $this->errorMessage;

	}

	// }}}

}

// {{{ __autoload()

/**
 * BHG Roster Autoloader
 *
 * @param string Name of the Class to load
 */
function __autoload($className) {

	$name = explode('_', $className);

	if (strtolower($name[0]) == 'bhg') {

		unset($name[0]);

		$filename = implode('/', $name).'.php';

		@include_once $filename;
		
	}

}

// }}}

$GLOBALS['bhg'] = new bhg();

?>

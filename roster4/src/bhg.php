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

				throw new bhg_fatal_exception('Invalid entry point requested.');

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

		throw new bhg_fatal_exception('No parts of this object can be set');

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

			try {
				
				if (!isset($instances[$classname][$ref]) 
						|| is_null($instances[$classname][$ref])
						|| $force
						|| (	 isset($instances[$classname][$ref]['time'])
								&& ($instances[$classname][$ref]['time'] + 30) <= $now)) {

					$GLOBALS['bhg']->log('Creating instance of '.$classname.' with #'.$ref, PEAR_LOG_DEBUG);

					$instances[$classname][$ref]['time'] = $now;
					$instances[$classname][$ref]['object'] = new $classname($ref);

				}

				$return = &$instances[$classname][$ref]['object'];

				$GLOBALS['bhg']->log('Returning object', PEAR_LOG_DEBUG);
				return $return;

			} catch (bhg_fatal_exception $e) {

				unset($instances[$classname][$ref]);

				$GLOBALS['bhg']->log('Return failure', PEAR_LOG_DEBUG);
				throw $e;
				
			}

		} else {

			$GLOBALS['bhg']->log('Return failure - could not find class', PEAR_LOG_DEBUG);
			throw new bhg_fatal_exception('Class does not exist');

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

		try {
			
			$this->code = new bhg_core_code(strtolower(md5($code)));

			return true;

		} catch (bhg_fatal_exception $e) {

			$this->code = null;
			
			return false;

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
class bhg_entry {} extends bhg_core_base {}

class bhg_fatal_exception extends Exception {}

class bhg_db_exception extends bhg_fatal_exception {

	// {{{ __construct()

	public function __construct($msg = null, $dberror = null) {

		if (!is_null($dberror)) {

			$msg .= "\n Database Error: ".$dberror->getMessage();

			$msg .= "\n SQL: ".$dberror->getUserInfo();
		
		}

		parent::__construct($msg);

	}

	// }}}

}

class bhg_list_exception extends bhg_fatal_exception {}

class bhg_list_exception_badobject extends bhg_fatal_exception {}

class bhg_list_exception_badparameter extends bhg_fatal_exception {}

class bhg_list_exception_notfound extends bhg_fatal_exception {}

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

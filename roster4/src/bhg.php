<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Core
 * @Version $Rev$ $Date$
 */

/* First of fix up include path. */
$include = ini_get('include_path');
$bhg_dir = dirname(__FILE__);
ini_set('include_path', $bhg_dir.':'.$include);

/** Include PEAR::Log */
include_once 'Log.php';

/**
 * BHG Data Systems Entry point object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Core
 * @Version $Rev$ $Date$
 */
class bhg extends bhg_core_base {

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
	 * Current User
	 *
	 * @var object bhg_roster_person
	 */
	private $current_user = null;

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

	/**
	 * Constructor
	 * 
	 * @return void
	 */
	public function __construct() {

		parent::__construct();

		$this->log = &Log::singleton('file', '/tmp/roster4.log', 'bhg');

	}

	// }}}

	// {{{ __get()

	/**
	 * Access function
	 * 
	 * @param string Name of interface to access
	 * @return object
	 * @throws bhg_fatal_exception If an invalid entry point is requested
	 */
	public function __get($e) {

		$e = strtolower($e);

		if ($e == 'database')
			return $this->database;

		if ($e == 'current_user' || $e == 'user')
			return $this->current_user;

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
	 * @throws bhg_fatal_exception This object can not have extra parts set
	 */
	public function __set($name, $val) {

		if ($name == 'current_user' || $name == 'user') {

			if ($val instanceof bhg_roster_person) {

				$this->current_user = $val;

			} elseif (is_numeric($val)) {

				try {
					
					$this->current_user = $GLOBALS['bhg']->roster->getPerson($val);

				} catch (bhg_not_found $e) {

				}

			}

		} else {
			
			throw new bhg_fatal_exception('No parts of this object can be set');

		}

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

			$hash = strtolower(md5($code));

			$sql = 'SELECT id FROM core_code WHERE `hash` = ?';

			$result = $this->db->getOne($sql, array($hash));

			if (DB::isError($result)) {

				throw new bhg_db_exception('Could not load coder details.', $result);

			} else {
				
				$this->code = new bhg_core_code($result);

				return true;

			}

		} catch (bhg_fatal_exception $e) {

			$this->code = null;
			
			return false;

		}

	}

	// }}}
	// {{{ getCoder()

	public function getCoder() {

		return $this->code;

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
 * @version $Rev$ $Date$
 */
class bhg_entry extends bhg_core_base {}

/**
 * BHG Fatal Exception
 *
 * All other exceptions extend from this one
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Exceptions
 * @version $Rev$ $Date$
 */
class bhg_fatal_exception extends Exception {}

/**
 * BHG Not Found Exception
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Exceptions
 * @version $Rev$ $Date$
 */
class bhg_not_found extends bhg_fatal_exception {}

/**
 * BHG Validation Exception
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Exceptions
 * @version $Rev$ $Date$
 */
class bhg_validation_exception extends bhg_fatal_exception {}

/**
 * BHG Database Exception
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Exceptions
 * @version $Rev$ $Date$
 */
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

/**
 * BHG Coder Exception
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Exceptions
 * @version $Rev$ $Date$
 */
class bhg_coder_exception extends bhg_fatal_exception {}

/**
 * BHG List Exception
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Exceptions
 * @version $Rev$ $Date$
 */
class bhg_list_exception extends bhg_fatal_exception {}

/**
 * BHG List Bad Object Exception
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Exceptions
 * @version $Rev$ $Date$
 */
class bhg_list_exception_badobject extends bhg_fatal_exception {}

/**
 * BHG List Bad Parameter Exception
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Exceptions
 * @version $Rev$ $Date$
 */
class bhg_list_exception_badparameter extends bhg_fatal_exception {}

/**
 * BHG List Not Found Exception
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Exceptions
 * @version $Rev$ $Date$
 */
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

/**
 * The Global BHG Entry Point
 *
 * @global $bhg
 */
$GLOBALS['bhg'] = new bhg();

?>

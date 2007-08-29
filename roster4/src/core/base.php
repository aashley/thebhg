<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Core
 * @Version $Rev$ $Date$
 */

/** Include PEAR::DB */
include_once 'DB.php';
/** Include PEAR::Date */
include_once 'Date.php';

/**
 * BHG Data Systems Base object
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Core
 * @Version $Rev$ $Date$
 */
class bhg_core_base {

	// {{{ properties

	/**
	 * Database connection
	 *
	 * @var object db
	 */
	protected $db = null;

	/**
	 * The Table name this object loaded from
	 *
	 * @var string table
	 */
	protected $table = null;

	/**
	 * Data storage
	 *
	 * @var array data
	 */
	protected $data = array();

	/**
	 * Function blacklist
	 *
	 * data fields listed within this array will not be accessable thru the
	 * default get/set handlers
	 *
	 * @var array
	 */
	private $blacklist = array(
			'get' => array(),
			'set' => array('datecreated', 'dateupdated', 'datedeleted'),
			'is'  => array(),
			);

	/**
	 * field map
	 *
	 * This maps specific fields to objects within the system for the _call
	 * function
	 *
	 * @var array
	 */
	private $fieldmap = array();

	/**
	 * Code map
	 *
	 * This maps specific functions to requiring specific a Code ID permission
	 * 
	 * @var array
	 */
	private $codeMap = array();


	/**
	 * History Map
	 *
	 * Map specific fields that when changed should create a history event
	 *
	 * @var array
	 */
	private $historyMap = array();

	/**
	 * Boolean Fields
	 *
	 * This is a list of fields from this object that should be treated as booleans
	 *
	 * @var array
	 */
	private $booleans = array();

	// }}}

	// {{{ __construct()

	/**
	 * Constructor
	 *
	 * @param string The name of the table to load data from
	 * @param integer The ID number of the record to load
	 * @return void
	 * @throws bhg_db_exception When unable to connect to the database
	 * @throws bhg_fatal_exception When unable to load the relevant data from the database
	 */
	public function __construct($table = null, $id = null) {

		$this->db = DB::connect('mysql://root:G4rsid3@localhost/bhgdevel');

		if (DB::isError($this->db)) {

			if (isset($GLOBALS['bhg']))
				$GLOBALS['bhg']->log('Could not connect to database.', PEAR_LOG_ERR);

			throw new bhg_db_exception('Could not connect to database.', $this->db);

		} else {

			$this->db->setFetchMode(DB_FETCHMODE_ASSOC);
			
			$this->table = $table;

			if (!is_null($table) && !is_null($id)) {

				$sql = 'SELECT * FROM `'.$table.'` WHERE `id` = '.$this->db->quoteSmart($id);

				$this->data = $this->db->getRow($sql);

				if (DB::isError($this->data)) {

					$GLOBALS['bhg']->log('Could not load data from table '.$table.' with id = '.$id."\n$sql", PEAR_LOG_ERR);

					throw new bhg_fatal_exception('Could not load data from table '.$table.' with id = '.$id);

				}

				if (is_null($this->data) || (is_array($this->data) && sizeof($this->data) == 0)) {

					$GLOBALS['bhg']->log('Row not found in '.$table.' with id = '.$id, PEAR_LOG_ERR);

					throw new bhg_not_found('Record not found.');

				}

			}

		}

	}

	// }}}

  // {{{ isDeleted()

  /**
   * Is this object Deleted?
   *
   * @access public
   * @return boolean
   */
  public function isDeleted() {

    return (!is_null($this->data['datedeleted']));

  }

  // }}}
	// {{{ isEqualTo()

	/**
	 * Checks if the IREF is equal to the other object.
	 *
	 * @param object bhg_core_base
	 * @param boolean Count subclasses as being the same
	 * @return boolean
	 */

	public function isEqualTo(bhg_core_base $other, $subclass = false) {

		if ($subclass) {

			return (   (   get_class($this) == get_class($other)
									|| is_subclass_of($this, get_class($other))
									|| is_subclass_of($other, get_class($this)))
							&& $other->getID() == $this->getID());

		} else {

			return (get_class($this) == get_class($other)
					 && $other->getID() == $this->getID());

		}

	}
	
	// }}}
	
	// {{{ delete()

	/**
	 * Delete whatever this is from the database
	 *
	 * @return boolean
	 */
	public function delete() {

		return $this->__deleteRecord();

	}

	// }}}

	// {{{ __call()

	/**
	 * Handle Undefined function calls to this object
	 *
	 * This function implements a mapping of function name to database field. It
	 * implements the following function types:
	 * <ul>
	 * <li><i>getFieldName()</i>: Retrieve the value of this field. If the field
	 * name contains the string 'date' then the value is converted to a PEAR Date
	 * object. If the field is marked as having an object mapping then the value
	 * is used as the sole parameter to the constructor for that object and the
	 * object is returned.</li>
	 * <li><i>setFieldName($var)</i>: Set the value of this field to $var. If the 
	 * field name contains the string 'date' then $var must be an instance of PEAR
	 * Date. If the field is marked as having an object mapping then $var must be
	 * an instance of the object listed in the object mapping. This object must
	 * have the function getID() available and it is the value returned from this
	 * function that is saved to the field.</li>
	 * <li><i>isFieldName()</i>, <i>hasFieldName()</i>: If the field is marked as
	 * boolean then these two forms of function are available, they map a 1 and 0
	 * in the database to the PHP values true and false respectively. Either for
	 * is available simply to allow for which ever term flows better</li>
	 * </ul>
	 *
	 * @param string The name of the function that was called
	 * @param array An array of parameters passed to the function
	 * @return mixed
	 * @throws bhg_coder_exception If the current coder ID does not have
	 * permission to call the requested function.
	 * @throws bhg_fatal_exception If the called function can not be mapped back 
	 * to a field in the database.
	 * @throws bhg_validation_exception If the supplied function parameters are not
	 * appropriate for the called function.
	 */
	public function __call($function, $params) {

		$allowed = false;

		$lfunc = strtolower($function);

		if (isset($this->codeMap[$lfunc])) {

			if (!$GLOBALS['bhg']->hasPerm($this->codeMap[$lfunc])) {

				throw new bhg_coder_exception();

			} else {

				$allowed = true;

			}

		}
		
		if (substr($lfunc, 0, 3) == 'get') {

			$varname = substr($lfunc, 3);

			if (   !in_array($varname, $this->blacklist['get'])
					&& (	 isset($this->data[$varname])
							|| is_null($this->data[$varname]))) {

				if ($allowed === false && isset($this->codeMap['defaults']['get'])) {

					if (!$GLOBALS['bhg']->hasPerm($this->codeMap['defaults']['get'])) {

						throw new bhg_coder_exception();

					}

				}

				if (is_null($this->data[$varname])) {
					
					return NULL;
				
				} elseif (isset($this->fieldmap[$varname])) {

					return $GLOBALS['bhg']->loadObject($this->fieldmap[$varname], $this->data[$varname]);

				} elseif (false === strstr($varname, 'date')) {

					if (in_array($varname, $this->booleans)) {

						return ($this->data[$varname] == 1);

					} else {
						
						return stripslashes($this->data[$varname]);

					}

				} else {

					return new Date($this->data[$varname]);

				}

			} else {

				throw new bhg_fatal_exception('Method '.$function.' does not exist.');

			}

		} elseif (substr($lfunc, 0, 2) == 'is') {

			$varname = substr($lfunc, 2);

			if (   !in_array($varname, $this->blacklist['is'])
					&& isset($this->data[$varname])
					&& in_array($varname, $this->booleans)) {

				return ($this->data[$varname] == 1);

			} else {

				throw new bhg_fatal_exception('Method '.$function.' does not exist.');

			}

		} elseif (substr($lfunc, 0, 3) == 'has') {

			$varname = substr($lfunc, 3);

			if (   !in_array($varname, $this->blacklist['is'])
					&& isset($this->data[$varname])
					&& in_array($varname, $this->booleans)) {

				return ($this->data[$varname] == 1);

			} else {

				throw new bhg_fatal_exception('Method '.$function.' does not exist.');

			}

		} elseif (substr($lfunc, 0, 3) == 'set') {

			$doHistory = (sizeof($this->historyMap) > 0);

			$varname = substr($lfunc, 3);

			if (	 !in_array($varname, $this->blacklist['set'])
					&& (	 isset($this->data[$varname])
							|| is_null($this->data[$varname]))) {

				if ($allowed === false && isset($this->codeMap['defaults']['set'])) {

					if (!$GLOBALS['bhg']->hasPerm($this->codeMap['defaults']['set'])) {

						throw new bhg_coder_exception();

					}

				}

				if (is_null($params[0])) {

					$oldvalue = $this->data[$varname];
					if ($oldvalue == $params[0]->getID()) {
						return true;
					} else {
						$result = $this->__saveValue(array($varname => $params[0]));
						if ($doHistory)
							$this->__call_history($varname, $oldvalue);
						return $result;
					}

				} elseif (isset($this->fieldmap[$varname])) {

					if ($params[0] instanceof $this->fieldmap[$varname]) {

						$oldvalue = $this->data[$varname];
						if ($oldvalue == $params[0]->getID()) {
							return true;
						} else {
							$result = $this->__saveValue(array($varname => $params[0]->getID()));
							if ($doHistory)
								$this->__call_history($varname, $oldvalue);
							return $result;
						}

					} else {

						throw new bhg_validation_exception('Invalid object passed to '.$function.'. Only accepts '.$this->fieldmap[$varname].'.');

					}

				} elseif (false === strstr($varname, 'date')) {

					if (in_array($varname, $this->booleans)) {

						if ($params[0] == $this->data[$varname]) {
							return true;
						} else {
							if ($params[0] === true) {
								return $this->__saveValue(array($varname => 1));
							} else {
								return $this->__saveValue(array($varname => 0));
							}
						}

					} else {
						
						$oldvalue = $this->data[$varname];
						if ($oldvalue == $params[0]) {
							return true;
						} else {
							$result = $this->__saveValue(array($varname => $params[0]));
							if ($doHistory)
								$this->__call_history($varname, $oldvalue);
							return $result;
						}

					}

				} else {

					if ($params[0] instanceof Date) {
						
						$getFunction = 'get'.$varname;
						if ($params[0]->equals($this->$getFunction())) {
							return true;
						} else {
							return $this->__saveValue($this->table, array($varname => $params[0]->getDate(DATE_FORMAT_ISO)));
						}

					} else {

						throw new bhg_validation_exception('Invalid object passed to '.$function.'. Only accepts Date.');

					}

				}

			} else {

				throw new bhg_fatal_exception('Method '.$function.' does not exist.');

			}

		}

	}

	// }}}
	// {{{ __createRecord() [protected]

	/**
	 * Create a new entry in one of the tables
	 *
	 * @param string The name of the Table we are creating a record in
	 * @param array An associative array detailing the fields and their values
	 * @return mixed If a matching class for this table can be located then the
	 *							 object related to the new record is returned, else a boolean
	 *							 detailing whether creating succeded of failed is returned.
	 *							 On failure or an error condition an exception is thrown.
	 * @throws bhg_validation_exception If a bad table name or empty list of fields
	 * is passed.
	 * @throws bhg_db_exception If there is a failure while creating the record
	 * within the database.
	 * @throws bhg_fatal_exception If there is a failure while attempting to load
	 * the object that represents the table the record is created in.
	 */
	protected function &__createRecord($table,
			$fields,
			$loadObject = true) {

		if (strlen($table) == 0) {

			throw new bhg_validation_exception('Invalid table name passed.');

		}

		if (sizeof($fields) == 0) {

			throw new bhg_validation_exception('At least one field must be set to create a record.');

		}

		$table = strtolower($table);
		$fieldnames = array();
		$fieldvalues = array();

		// Add in our tracking fields as appropriate
		if (!in_array($table, $GLOBALS['bhg']->database['no_created'])) {

			$fieldnames[] = 'datecreated';
			$fieldvalues[] = 'NOW()';

		}

		if (!in_array($table, $GLOBALS['bhg']->database['no_updated'])) {

			$fieldnames[] = 'dateupdated';
			$fieldvalues[] = 'NOW()';

		}

		if (!in_array($table, $GLOBALS['bhg']->database['no_deleted'])) {

			$fieldnames[] = 'datedeleted';
			$fieldvalues[] = $this->db->quote(NULL);

		}

		// Convert passed in field value pairs to appropriate entries for 
		// submitting to the database
		foreach ($fields as $field => $value) {

			$fieldnames[] = $field;
			
			if (is_array($value) && isset($value[1]) && $value[1] == true) {
				
				$fieldvalues[] = $value[0];
				
			} else {
				
				if (preg_match('/^[a-zA-Z_]*\(.*\)$/', $value)) {
					
					$fieldvalues[] = $value;
					
				} else {
					
					$fieldvalues[] = $this->db->quote($value);
					
				}
				
			}

		}

		// Build the SQL string
		$sql = 'INSERT INTO `'.$table.'` (`'.implode('`, `', $fieldnames)."`) "
					."VALUES (".implode(', ', $fieldvalues).")";

		$result = $this->db->query($sql);

		if (DB::isError($result)) {

			throw new bhg_db_exception("Could not create new record in {$table}.", $result);

		} else {

			// Record was successfully created

			// Retrieve the IREF of the new record
			$id = $this->db->getOne("SELECT LAST_INSERT_ID();");

			// Just return the iref if thats what we've been told to do
			if (!$loadObject) return $id;
			
			// See if a class exists that relates to this table

			$classname = 'bhg_'.$table;

			try {
				
				$object = bhg::loadObject($classname, $id);

				return $object;

			} catch (bhg_fatal_exception $e) {

				$GLOBALS['bhg']->log('Could not load new object '.$classname.' with id '.$id, PEAR_LOG_ERR);

				throw $e;

			}

		}

	}

	// }}}
	// {{{ __deleteRecord() [protected]

	/**
	 * Mark a record in the database as deleted
	 * 
	 * This function works in two ways you can either specify a table and
	 * fields to delete by or provide no arguments and it will delete the
	 * record refered to by this object.
	 *
	 * @param string The name of the Table to delete the record from
	 * @param array	A named array of fields to select the record to delete from
	 * @return boolean
	 * @throws bhg_fatal_exception If a table is specified but no fields are. This
	 * function will not empty an entire table.
	 * @throws bhg_db_exception If the delete operation in the database fails.
	 */
	protected function __deleteRecord($table = null, $fields = null) {

		if ($table == null
				&& $fields == null) {

			$table = $this->table;

			$fields = array('id' => $this->data['id']);

		}

		if (sizeof($fields) == 0)
			throw new bhg_fatal_exception('No fields specified.  Will not delete entire table.');

		$sql = 'UPDATE `'.$table.'` '
					.'SET `datedeleted` = NOW() '
					.'WHERE `datedeleted` IS NULL ';

		foreach ($fields as $field => $value) {

			if (preg_match('/^[a-zA-Z_]*\(.*\)$/', $value)) {

				$sql .= 'AND `'.$field.'` = '.$value.' ';

			} else {

				if (is_array($value)) {

					if (sizeof($value) > 0) {

						$sql .= 'AND `'.$field."` IN (".implode(',', $value).') ';

					}

				} else {

					$sql .= 'AND `'.$field.'` = '.$this->db->quote($value).' ';

				}

			}

		}

		if (substr($sql, -8) != 'IS NULL ') {

			$result = $this->db->query($sql);

			if (DB::isError($result)) {

				throw new bhg_db_exception('Could not delete record.', $result);

			} else {

				return true;

			}

		} else {

			return false;

		}

	}

	// }}}
	// {{{ __purgeRecord() [protected]

	/**
	 * Purge a row from one of the tables in the database.
	 *
	 * Purge a row from one of the tables in the database. This is normally used
	 * to clean up rows that where created but later failures mean they need to 
	 * be removed. Would probably better to use proper transactions but we dont
	 * have them yet and I dont have time to setup MySQL to do it
	 *
	 * @param string The Name of the Table
	 * @param integer The IREF of the row to purge
	 * @return boolean
	 */
	protected function __purgeRecord($table = null, $iref = null) {

		if (	 is_null($table)
				&& is_null($iref)) {

			$table = $this->table;

			$iref = array($this->data['id']);

		}

		if (strlen($table) == 0) {

			throw new bhg_fatal_exception('You must specify the table to delete from.');

		}

		if (!is_array($iref)) {

			$iref = array($iref);

		}

		$sql = 'DELETE FROM `'.$table.'` '
					."WHERE id IN (".implode(',', $iref).')';

		$result = $this->db->query($sql);

		if (DB::isError($result)) {

			throw new bhg_db_exception("Could not purge record #{$iref}.", $result);

		} else {

			return true;

		}

	}

	// }}}
	// {{{ __saveValue() [protected]

	/**
	 * Save a value to a specific field in the Database
	 *
	 * As the vast majority of updates in the system follow the same format this 
	 * function handles the actual work. Any simple set functions should just
	 * call this function. Anything more complex should be done in the original
	 * function
	 *
	 * @param array A named array where the key represents the field to set 
	 *							and the value is the Value to set.
	 * @return boolean
	 */
	protected function __saveValue($fields, $table = null, $id = null) {

		if (is_null($table)) $table = $this->table;

		$iref_field = 'id';

		if (is_null($id)) $id = $this->data[$iref_field];

		$f = array();

		foreach ($fields as $field => $value) {

			if (is_array($value) && isset($value[1]) && $value[1] == true) {
				
				$f[] = '`'.$field.'` = '.$value[0];
				
			} else {
				
				if (preg_match('/^[a-zA-Z_]*\(.*\)$/', $value)) {
					
					$f[] = '`'.$field.'` = '.$value;
					
				} else {
					
					$f[] = '`'.$field.'` = '.$this->db->quoteSmart($value);
					
				}
				
			}

		}


		if (!in_array($table, $GLOBALS['bhg']->database['no_updated'])) {

			$f[] = '`dateupdated` = NOW()';

		}

		$sql = 'UPDATE `'.$table.'` '
					.'SET '
					.implode(', ', $f).' '
					.'WHERE `'.$iref_field.'` = '.$this->db->quoteSmart($id);

		$result = $this->db->query($sql);

		if (DB::isError($result)) {

			throw new bhg_db_exception("Could not save changes to {$table}.", $result);

		} else {

			// If the record we've just updated is the one represented by this
			// object update its local storage of values.
			if (	 $this->table == $table
					&& $id == $this->data[$iref_field]
					&& count($fields) > 0) {

				// Get the values from database so we get the evaluated value of
				// any SQL functions
				$sql = 'SELECT `'.implode('`, `', array_keys($fields)).'` '
							.'FROM `'.$table.'` '
							.'WHERE `'.$iref_field.'` = '.$id;

				$results = $this->db->getRow($sql);

				foreach ($results as $field => $value) {

					$this->data[$field] = $value;

				}

			}

			return true;

		}

	}

	// }}}
	// {{{ __blackListVar() [protected]

	/**
	 * Black list these vars from being accessed using __call
	 *
	 * @param string Either get or set
	 * @param array The Variable names to blacklist
	 * @return boolean
	 */
	protected function __blackListVar($type, $vars) {

		if ($type == 'set' || $type == 'get' || $type == 'is') {

			$this->blacklist[$type] = array_merge($this->blacklist[$type], $vars);

			return true;

		} else {

			return false;

		}

	}

	// }}}
	// {{{ __addFieldMap() [protected]

	/**
	 * Add a collection of mappings to the field map
	 *
	 * @param array
	 * @return boolean
	 */
	protected function __addFieldMap($newmaps) {

		$this->fieldmap = array_merge($this->fieldmap, $newmaps);

		return true;

	}

	// }}}
	// {{{ __addCodePermissions() [protected]

	/**
	 * Add required Code permissions for functions processed thru __call
	 *
	 * @param array
	 * @return boolean
	 */
	protected function __addCodePermMap($newmaps) {

		$this->codeMap = array_merge($this->codeMap, $newmaps);

		return true;

	}

	// }}}
	// {{{ __addDefaultCodePermissions() [protected]

	/**
	 * Set Default code id permissions for a class of functions
	 *
	 * Set the Defatul code id permission required to call a class of functions.
	 * Function specific code perms set with __addCodePermissions() overrights this.
	 *
	 * @param string The class of functions to set the default for 'get' or 'set'
	 * @param string The code id permission name required to call this class of functions
	 * @return boolean
	 */
	protected function __addDefaultCodePermissions($class, $perm) {

		$this->codeMap['defaults'][$class] = $perm;

		return true;

	}

	// }}}
	// {{{ __addBooleanFields() [protected]

	/**
	 * Add fields to the list that are treated as booleans
	 *
	 * @param array
	 * @return boolean
	 */
	protected function __addBooleanFields($fields) {

		$this->booleans = array_merge($this->booleans, $fields);

		return true;

	}

	// }}}
	// {{{ __recordHistoryEvent() [protected]

	/**
	 * Record a history event
	 *
	 * This function will record an event into the roster history system
	 *
	 * @param string The type of event
	 * @param bhg_core_base The object in the bhg system that the history event
	 * is about.
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return boolean
	 * @throws bhg_validation_exception If an invalid object is passed
	 */
	protected function __recordHistoryEvent($type, $object, $item1 = null, $item2 = null, $item3 = null, $item4 = null) {

		if (!$object instanceof bhg_core_base)
			throw new bhg_validation_exception('Invalid object passed to record history about.');

		return $this->__createRecord('history_event',
				array('person' => $object->getID(),
							'type' => $type,
							'item1' => $item1,
							'item2' => $item2,
							'item3' => $item3,
							'item4' => $item4));

	}

	// }}}
	// {{{ __addHistoryMap() [protected]

	/**
	 * Add mappings for fields that should create history events thru __call
	 *
	 * @param array
	 * @return boolean
	 */
	protected function __addHistoryMap($newmaps) {

		$this->historyMap = array_merge($this->historyMap, $newmaps);

		return true;

	}

	// }}}

	// {{{ __call_history() [private]

	/**
	 * Handle the creation of history events related to __call()
	 *
	 * @return boolean
	 */
	private function __call_history($field, $oldvalue) {

		if (isset($this->historyMap[$field])) {

			switch ($this->historyMap[$field]) {

				case BHG_HISTORY_RANK:
				case BHG_HISTORY_CADRE_RANK:
				case BHG_HISTORY_POSITION:
				case BHG_HISTORY_DIVISION:
				case BHG_HISTORY_NAME:
				case BHG_HISTORY_EMAIL:
					return $this->__recordHistoryEvent($this->historyMap[$field], $this, $oldvalue, $this->data[$field]);

				default:
					return true;

			}

		} else {

			return true;

		}

	}

	// }}}

}

/** History Event Type: Rank Change */
define('BHG_HISTORY_RANK', 1);
/** History Event Type: Position Change */
define('BHG_HISTORY_POSITION', 2);
/** History Event Type: Division Change */
define('BHG_HISTORY_DIVISION', 3);
/** History Event Type: Name Change */
define('BHG_HISTORY_NAME', 4);
/** History Event Type: Email Change */
define('BHG_HISTORY_EMAIL', 5);
/** History Event Type: Credit Award */
define('BHG_HISTORY_CREDIT', 6);
/** History Event Type: Account Transaction */
define('BHG_HISTORY_ACCOUNT', 7);
/** History Event Type: Medal Award */
define('BHG_HISTORY_MEDAL', 8);
/** History Event Type: Joined The BHG */
define('BHG_HISTORY_JOIN', 9);
/** History Event Type: Deleted */
define('BHG_HISTORY_DELETE', 10);
/** History Event Type: Joined Cadre */
define('BHG_HISTORY_JOIN_CADRE', 11);
/** History Event Type: Left Cadre */
define('BHG_HISTORY_LEFT_CADRE', 12);
/** History Event Type: Role Playing XP */
define('BHG_HISTORY_XP', 13);
/** History Event Type: Role Playing XP */
define('BHG_HISTORY_CADRE_RANK', 14);

?>

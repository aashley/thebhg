<?php

/**
 * BHG Data Systems
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package BHG
 * @subpackage Core
 * @Version $Rev:$ $Date:$
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
 * @Version $Rev:$ $Date:$
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
	 * Error Loading?
	 *
	 * @var boolean
	 */
	protected $error = false;

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
			'set' => array('datecreated', 'dateupdated', 'datedeleted')
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

	// }}}

	// {{{ __construct()

	public function __construct($table = null, $id = null) {

		$this->db = DB::connect('mysql://thebhg_rosedit:657cbf05@localhost/thebhg_roster');

		if (DB::isError($this->db)) {

			$GLOBALS['bhg']->log('Could not connect to database.', PEAR_LOG_ERR);

			$this->error = true;

		} else {

			$this->db->setFetchMode(DB_FETCHMODE_ASSOC);
			
			$this->table = $table;

			if (!is_null($table) && !is_null($id)) {

				$sql = 'SELECT * FROM `'.$table.'` WHERE `id` = '.$id;

				$this->data = $this->db->getRow($sql);

				if (DB::isError($this->data)) {

					$GLOBALS['bhg']->log('Could not load data from table '.$table.' with id = '.$id, PEAR_LOG_ERR);

					$this->error = true;

				}

			}

		}

	}

	// }}}
	// {{{ __call()

	public function __call($function, $params) {

		if (strtolower(substr($function, 0, 3)) == 'get') {

			$varname = strtolower(substr($function, 3));

			if (   !in_array($varname, $this->blacklist['get'])
					&& isset($this->data[$varname])) {

				if (isset($this->fieldmap[$varname])) {

					return $GLOBALS['bhg']->loadObject($this->fieldmap[$varname], $this->data[$varname]);

				} elseif (false === strstr($varname, 'date')) {

					return $this->data[$varname];

				} else {

					return new Date($this->data[$varname]);

				}

			} else {

				return new bhg_error('Method '.$function.' does not exist.');

			}

		} elseif (strtolower(substr($function, 0, 3)) == 'set') {

			$varname = strtolower(substr($function, 3));

			if (	 !in_array($varname, $this->blacklist['set'])
					&& isset($this->data[$varname])) {

				if (isset($this->fieldmap[$varname])) {

					if ($params[0] instanceof $this->fieldmap[$varname]) {

						return $this->__saveValue($table, array($varname => $params[0]->getID()));

					} else {

						return new bhg_error('Invalid object passed to '.$function.'. Only accepts '.$this->fieldmap[$varname].'.');

					}

				} elseif (false === strstr($varname, 'date')) {

					return $this->__saveValue($table, array($varname => $params[0]));

				} else {
					
					return $this->__saveValue($table, array($varname => $params[0]->getDate(DATE_FORMAT_ISO)));

				}

			} else {

				return new bhg_error('Method '.$function.' does not exist.');

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
	 *							 On failure or an error condition a boolean False is returned.
	 */
	protected function &__createRecord($table,
			$fields,
			$loadObject = true) {

		if (strlen($table) == 0) {

			return new bhg_error('Invalid table name passed.');

		}

		if (sizeof($fields) == 0) {

			return new bhg_error('At least one field must be set to create a record.');

		}

		$table = strtolower($table);
		$fieldnames = array();
		$fieldvalues = array();

		// Add in our tracking fields as appropriate
		if (!in_array($table, $GLOBALS['bhg']->database['no_created'])) {

			$fieldnames[] = 'date_created';
			$fieldvalues[] = 'NOW()';

		}

		if (!in_array($table, $GLOBALS['bhg']->database['no_updated'])) {

			$fieldnames[] = 'date_updated';
			$fieldvalues[] = 'NOW()';

		}

		if (!in_array($table, $GLOBALS['bhg']->database['no_deleted'])) {

			$fieldnames[] = 'date_deleted';
			$fieldvalues[] = $this->db->quote(NULL);

		}

		// Convert passed in field value pairs to appropriate entries for 
		// submitting to the database
		foreach ($fields as $field => $value) {

			$fieldnames[] = $field;
			
			if (preg_match('/^[a-zA-Z_]*\(.*\)$/', $value)) {

				$fieldvalues[] = $value;

			} else {

				$fieldvalues[] = $this->db->quote($value);

			}

		}

		// Build the SQL string
		$sql = 'INSERT INTO `'.$table.'` (`'.implode('`, `', $fieldnames)."`) "
					."VALUES (".implode(', ', $fieldvalues).")";

		$result = $this->db->query($sql);

		if (DB::isError($result)) {

			return new bhg_error("Could not create new record in {$table}.");

		} else {

			// Record was successfully created

			// Retrieve the IREF of the new record
			$id = $this->db->getOne("SELECT LAST_INSERT_ID();");

			// Just return the iref if thats what we've been told to do
			if (!$loadObject) return $id;
			
			// See if a class exists that relates to this table

			$classname = 'bhg_'.$table;

			$object = &$GLOBALS['gen3']->loadObject($classname, $id);

			if ($object instanceof bhg_error) {

				// Object could not be loaded, return the iref and let the caller
				// figure it out

				return $id;

			} else {

				return $object;

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
	 */
	protected function __deleteRecord($table = null, $fields = null) {

		if ($table == null
				&& $fields == null) {

			$table = $this->table;

			$fields = array('id' => $this->data['id']);

		}

		$sql = 'UPDATE `'.$table.'` '
					.'SET date_deleted = NOW() '
					.'WHERE date_deleted IS NULL ';

		foreach ($fields as $field => $value) {

			if (preg_match('/^[a-zA-Z_]*\(.*\)$/', $value)) {

				$sql .= 'AND '.$field.' = '.$value.' ';

			} else {

				if (is_array($value)) {

					if (sizeof($value) > 0) {

						$sql .= 'AND '.$field." IN (".implode(',', $value).') ';

					}

				} else {

					$sql .= 'AND '.$field.' = '.$this->db->quote($value).' ';

				}

			}

		}

		if (substr($sql, -8) != 'IS NULL ') {

			$result = $this->db->query($sql);

			if (DB::isError($result)) {

				return new bhg_error('Could not delete record.');

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
	protected function __purgeRecord($table, $iref) {

		if (strlen($table) == 0) {

			$this->setError('You must specify the table to delete from.');

			return false;

		}

		if (!is_array($iref)) {

			$iref = array($iref);

		}

		$sql = 'DELETE FROM `'.$table.'` '
					."WHERE id IN (".implode(',', $iref).')';

		$result = $this->db->query($sql);

		if (DB::isError($result)) {

			$this->setError("Could not purge record #{$iref}.", $result, $sql);

			return false;

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

			if (preg_match('/^[a-zA-Z_]*\(.*\)$/', $value)) {

				$f[] = '`'.$field.'` = '.$value;

			} else {
				
				$f[] = '`'.$field.'` = '.$this->db->quote($value);

			}

		}


		if (!in_array($table, $GLOBALS['bhg']->database['no_updated'])) {

			$f[] = 'date_updated = NOW()';

		}

		$sql = 'UPDATE "'.$table.'" '
					.'SET '
					.implode(', ', $f).' '
					.'WHERE "'.$iref_field.'" = '.$id;

		$result = $this->db->query($sql);

		if (DB::isError($result)) {

			$this->setError("Could not save changes to {$table}.", $result, $sql);

			return false;

		} else {

			// If the record we've just updated is the one represented by this
			// object update its local storage of values.
			if (	 $this->table == $table
					&& $iref == $this->data[$iref_field]
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

		if ($type == 'set' || $type == 'get') {

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

	// {{{ createFailure()

	public function createFailure() {

		return $this->error;

	}

	// }}}

}

?>

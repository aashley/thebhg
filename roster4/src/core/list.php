<?php

/**
 * This file provides an Object List
 *
 * @author Adam Ashley <aashley@optimiser.com>
 * @package Framework
 * @version $Rev: 4944 $ $Date: 2005-09-01 16:41:07 +0800 (Thu, 01 Sep 2005) $   
 */

/**
 * Framework List Object
 *
 * This object takes the name of another object and an array of parameters
 * to be passed to that object to create each instance. This means the items of
 * the list can be accessed without creating all the objects at once.
 *
 * @author Adam Ashley <aashley@optimiser.com>
 * @package Framework
 * @version $Rev: 4944 $ $Date: 2005-09-01 16:41:07 +0800 (Thu, 01 Sep 2005) $   
 */
class bhg_core_list implements IteratorAggregate {

  // {{{ properties

  /**
   * The constructor IDs for the list items.
   *
   * @var array items
   */
  public $items = array();

  /**
   * The class name to be used when creating objects.
   *
   * @var string object
   */
  private $object;

  /**
   * The current position in the list.
   *
   * @var integer position
   */
  private $position;

  // }}}
  // {{{ __construct()

  /**
	 * This function takes the name of an object and a list of ID numbers to pass
	 * to the object as the first parameter of the constructor, then constructs a
	 * list based on that. This way a large list of objects can exist while only
	 * creating the individual objects as needed, thus saving space and only
	 * initialising objects that are actually needed.
   *
   * @param string The class name to use when constructing objects.
   * @param array The ID numbers for items within the list.
	 * @return void
   */
  public function __construct($object, $items) {

    $this->object = $object;
		if (is_array($items)
				&& sizeof($items) > 0) {
			$this->items = array_merge($items, array());
		} else {
			$this->items = array();
		}
    $this->position = 0;

  }

  // }}}

	// Methods that operate on the list itself.
  // {{{ count()

  /**
   * Returns the number of items within the list.
   *
   * @return integer
   */
  public function count() {

    return sizeof($this->items);

  }

  // }}}
	// {{{ getIterator()

	/**
	 * Returns an iterator for the list.
	 *
	 * @return object bhg_core_list_Iterator
	 */
	public function getIterator() {
		return new bhg_core_list_iterator($this);
	}

	// }}}
	// {{{ getObjectType()

	/**
	 * Returns the class name for objects represented by this list.
	 *
	 * @return string
	 */
	public function getObjectType() {

		return $this->object;

	}
	// }}}
	// {{{ getPosition()

	/**
	 * Returns the current position of the list counter.
	 *
	 * @return integer
	 */

	public function getPosition() {

		return $this->position;

	}

	// }}}
	// {{{ isEqualTo()

	/**
	 * Compares the list instance to another list and checks if the lists are the
	 * same.
	 *
	 * @param object bhg_core_list
	 * @return boolean
	 */

	public function isEqualTo(bhg_core_list $list) {

		if (strcasecmp($list->getObjectType(), $this->object) != 0)
			return false;

		return ($list->items == $this->items);

	}
	
	// }}}

	// Methods that deal with list items.
  // {{{ getItem()

  /**
	 * Returns the object the internal pointer is currently at, or the requested
	 * object.
   *
	 * @param integer The number of the item to look up (zero-indexed). If
	 * omitted, the current position will be used.
   * @return object
	 * @throws bhg_core_list_Exception_NotFound Thrown if the requested item is
	 * not found.
   */
  public function getItem($i = null) {

		if (is_null($i))
			$i = $this->position;

		if (isset($this->items[$i])) {

			if (substr($this->object, 0, 5) == 'bhg_') {

				$object = bhg::loadObject($this->object, $this->items[$i]);

			} else {
				
				$object = new $this->object($this->items[$i]);

			}

			return $object;

		} else {

			throw new bhg_list_exception_notfound('The requested item does not exist.');

		}

  }

  // }}}
	// {{{ inList()

	/**
	 * Checks if the given item is in the list.
	 *
	 * @param integer|object
	 * @return boolean
	 * @throws bhg_core_list_Exception_BadObject Thrown if an object is
	 * provided, but the ID cannot be loaded from within it.
	 * @throws bhg_core_list_Exception_BadParameter Thrown if the item provided
	 * cannot be parsed.
	 */

	public function inList($search) {

		return in_array($this->parseID($search), $this->items);

	}
	
	// }}}
	// {{{ isFirstItem()

	/**
	 * Checks if the given item is the first item in the list. Only works for
	 * bhg_core_base descendants.
	 *
	 * @param object bhg_core_base
	 * @return boolean
	 */

	public function isFirstItem(bhg_core_base $item) {

		return ($item->isEqualTo($this->getItem(0)));

	}
	
	// }}}
	// {{{ isLastItem()

	/**
	 * Checks if the given item is the last item in the list. Only works for
	 * bhg_core_base descendants.
	 *
	 * @param object bhg_core_base
	 * @return boolean
	 */

	public function isLastItem(bhg_core_base $item) {

		return ($item->isEqualTo($this->getItem(sizeof($this->items) - 1)));

	}
	
	// }}}

	// Methods that modify the current list item.
  // {{{ first()

  /**
   * Sets the internal pointer to point at the first list item.
   *
	 * @return integer Returns the new internal pointer position; that is, zero.
   */
  public function first() {

    $this->position = 0;

    return $this->position;

  }

  // }}}
  // {{{ gotoItem()

  /**
   * Sets the internal pointer to point to a particular item.
   *
   * @param integer The zero-indexed position to jump to.
   * @return integer The new position.
	 * @throws bhg_core_list_Exception_NotFound Thrown if the position given is
	 * out of range.
   */
  public function gotoItem($item) {

		if (!is_numeric($item)) {

			throw new bhg_list_exception_badparameter('Invalid key.');

		} elseif (   $item >= 0
      		 		&& $item < sizeof($this->items)) {

      $this->position = $item;

      return $this->position;

    } else {

			throw new bhg_list_exception_notfound('The position given is out of range.');
			
    }

  }

  // }}}
  // {{{ gotoItemByValue()

  /**
	 * Sets the internal pointer to point at an item based upon the object
	 * provided.
   *
	 * @param integer|object bhg_core_base An integer ID to look up, or a bhg_core_base
	 * descendant to search for.
   * @return integer The new position.
	 * @throws bhg_list_exception_badobject Thrown if an object is
	 * provided, but the ID cannot be loaded from within it.
	 * @throws bhg_list_exception_badparameter Thrown if the item provided
	 * cannot be parsed.
	 * @throws bhg_list_exception_notfound Thrown if the given item is not
	 * found within the list.
   */
  public function gotoItemByValue($item) {

		$this->position = $this->search($item);

		return $this->position;

	}

  // }}}
  // {{{ last()

  /**
   * Sets the internal pointer to point at the last list item.
   *
	 * @return integer Returns the new internal pointer position.
   */
  public function last() {

		if (sizeof($this->items) == 0)
			$this->position = 0;
		else
	    $this->position = sizeof($this->items) - 1;

    return $this->position;

  }

  // }}}
  // {{{ next()

  /**
   * Sets the internal pointer to point at the next list item.
   * 
	 * @param boolean Internal use parameter, only set to true if calling from
	 * the iterator.
	 * @return integer|boolean Returns the new internal pointer position, or
	 * false if the end of the list has been reached.
   */
  public function next($it = false) {

		if ($it) {

			$size = sizeof($this->items);

		} else {

			$size = sizeof($this->items) - 1;

		}

    if ($this->position < $size) {

      $this->position++;

      return $this->position;

    } else {

      return false;

    }

  }

  // }}}
  // {{{ previous()

  /**
   * Sets the internal pointer to point at the previous list item.
	 *
	 * @return integer|boolean Returns the new internal pointer position, or
	 * false if the start of the list has been reached.
   */
  public function previous() {

    if ($this->position == 0) {

      return false;

    } else {

      $this->position--;

      return $this->position;

    }

  }

  // }}}

	// Methods that modify the list itself.
	// {{{ append()

	/**
	 * Appends a new object or ID to the list.
	 *
	 * @param integer|object
	 * @return void
	 * @throws bhg_list_exception_badobject Thrown if an object is
	 * supplied, but it is of the wrong class.
	 * @throws bhg_list_exception_badparameter Thrown if a parameter is
	 * supplied that is not a number or an object.
	 */

	public function append($item) {

		$this->items[] = $this->parseID($item);

	}
	
	// }}}
	// {{{ merge()

	/**
	 * Merges the given bhg_core_list with this one into a new list.
	 *
	 * @param object bhg_core_list
	 * @param boolean True to ensure that the resultant list only contains unique
	 * objects (based on their IREF), or false to allow duplicate objects.
	 * @return object bhg_core_list
	 * @throws bhg_list_exception_badobject Thrown if the list to be merged
	 * is of a different class.
	 */
	public function merge(bhg_core_list $list, $unique = true) {

		if ($this->object == $list->getObjectType()) {

			$return = new bhg_core_list($this->object, array_merge($this->items, $list->items));

			if ($unique)
				$return->items = array_unique($return->items);

			$return->items = array_values($return->items);

			return $return;

		} else {

			throw new bhg_core_list_exception_badobject('Unable to merge lists with different classes.');

		}

	}

	// }}}
	// {{{ remove()

	/**
	 * Removes an item from the list.
	 *
	 * @param integer|object
	 * @return void
	 * @throws bhg_list_exception_badobject Thrown if an object is
	 * provided, but the ID cannot be loaded from within it.
	 * @throws bhg_list_exception_badparameter Thrown if the item provided
	 * cannot be parsed.
	 * @throws bhg_list_exception_notfound Thrown if the given item is not
	 * found within the list.
	 */

	public function remove($item) {

		$key = $this->search($item);

		unset($this->items[$key]);
		
		$this->items = array_values($this->items);

		if ($this->getPosition() == $key)
			if (!$this->next())
				$this->previous();

		return true;
		
	}
	
	// }}}
	// {{{ removeFromList()

	/**
	 * Removes items in the given bhg_core_list from the current bhg_core_list.
	 *
	 * @param object bhg_core_list
	 * @return void
	 * @throws bhg_list_exception_badobject Thrown if the list being
	 * removed has a different class.
	 */

	public function removeFromList(bhg_core_list $remove) {

		if (strcasecmp($remove->getObjectType(), $this->object) != 0) {

			throw new bhg_list_exception_badobject('The list to be removed has a different class.');
			
		}

		$this->items = array_values(array_diff($this->items, $remove->items));

	}
	
	// }}}
	// {{{ reverse()

	/**
	 * Reverses the list order. This method also resets the list pointer to the
	 * start of the list.
	 *
	 * @return void
	 */

	public function reverse() {

		$this->items = array_reverse($this->items, false);

		$this->first();

	}
	
	// }}}
	// {{{ sort()

	/**
	 * Sorts the entries in the list.
	 *
	 * @param array|string The method to use to sort the list entries. This
	 * method will be called on each object within the list and used for
	 * comparison purposes. This parameter can either be a string (in which case
	 * this method will be called on each object), or an array (in which case
	 * each member of the array will be parsed as a subarray containing the
	 * method name and any parameters to be passed to the method).
	 * @param string The direction to sort in: 'asc' for ascending, 'desc' for
	 * descending.
	 * @return boolean
	 * @throws bhg_list_exception_badparameter Thrown if the method name
	 * given is invalid.
	 */
	public function sort($by = 'getDisplayName', $order = 'asc') {

		// If the web interface asks us to sort without a comparison method, just
		// say we did it and continue.
		if (is_null($by)) return true;

		// Similarly, empty lists don't need to be sorted.
		if (sizeof($this->items) == 0) return true;

		$GLOBALS['__bhg_sort'] = array('object' => $this->object,
				'by' => $by,
				'order' => $order);

		$result = usort($this->items, array('bhg_core_list', 'compareObjects'));

		unset($GLOBALS['__bhg_sort']);

		return $result;

	}

	// }}}

	// Helper function for sorting.
	// {{{ compareObjects() [static]

	/**
	 * Static compare function used by bhg_core_list::sort()
	 *
	 * @return integer
	 */
	static public function compareObjects($a, $b) {

		$options = $GLOBALS['__bhg_sort'];

		if (substr($options['object'], 0, 5) == 'bhg_') {

			$obja = bhg::loadObject($options['object'], $a);
			$objb = bhg::loadObject($options['object'], $b);

		} else {
			
			$obja = new $options['object']($a);
			$objb = new $options['object']($b);

		}

		if (is_array($options['by'])) {

			foreach ($options['by'] as $function) {

				if (!is_object($obja) || !is_object($objb)) break;

				if (is_array($function)) {
					$obja = call_user_func_array(array($obja, $function[0]), $function[1]);
					$objb = call_user_func_array(array($objb, $function[0]), $function[1]);
				} else {
					$obja = call_user_func(array($obja, $function));
					$objb = call_user_func(array($objb, $function));
				}

			}

		} else {
			
			$obja = call_user_func(array($obja, $options['by']));
			$objb = call_user_func(array($objb, $options['by']));

		}

/*		if ($obja instanceof Date && $objb instanceof Date) {
			$return = Date::compare($obja, $objb);
			if ($options['order'] == 'desc')
				return $return * -1;
			else
				return $return;
		} else {
			$stringa = strtolower($obja);
			$stringb = strtolower($objb);
			if ($stringa == $stringb) return 0;
			if ($options['order'] == 'desc')
				return ($stringa > $stringb) ? -1 : +1;
			else
				return ($stringa > $stringb) ? +1 : -1;
		}*/

		if ($obja instanceof Date)
			$stringa = $obja->getDate();
		if ($objb instanceof Date)
			$stringb = $objb->getDate();

		if (!isset($stringa))
			$stringa = strtolower($obja);
		if (!isset($stringb))
			$stringb = strtolower($objb);

		if ($stringa == $stringb) return 0;
		if ($options['order'] == 'desc')
			return ($stringa > $stringb) ? -1 : +1;
		else
			return ($stringa > $stringb) ? +1 : -1;
	}

	// }}}

	// Private methods.
	// {{{ parseID() [private]

	/**
	 * Parses the given object or integer as an ID.
	 *
	 * @param integer|object
	 * @return integer
	 * @throws bhg_list_exception_badobject Thrown if an object is
	 * provided, but the ID cannot be loaded from within it.
	 * @throws bhg_list_exception_badparameter Thrown if the item provided
	 * cannot be parsed.
	 */

	private function parseID($item) {

		if (is_object($item)) {

			if ($item instanceof bhg_core_base) {

				$item = $item->getID();

			} else {

				throw new bhg_list_exception_badobject('The object provided cannot have its ID retrieved.');

			}

		} elseif (!is_numeric($item)) {

			throw new bhg_list_exception_badparameter('The item provided cannot be parsed.');

		}

		return $item;

	}
	
	// }}}
	// {{{ search() [private]

	/**
	 * Searches the list for the given item.
	 *
	 * @param integer|object bhg_core_base An ID to search for, or a bhg_core_base
	 * descendant that can provide an IREF.
	 * @return integer The zero-indexed position of the item within the list.
	 * @throws bhg_list_exception_badobject Thrown if an object is
	 * provided, but the ID cannot be loaded from within it.
	 * @throws bhg_list_exception_badparameter Thrown if the item provided
	 * cannot be parsed.
	 * @throws bhg_list_exception_notfound Thrown if the given item is not
	 * found within the list.
	 */

	private function search($item) {

		$key = array_search($this->parseID($item), $this->items);

		if ($key === false) {

			throw new bhg_list_exception_notfound('The item was not found within the list.');

		}

		return $key;

	}
	
	// }}}

}

/**
 * The iterator for bhg_core_list.
 *
 * @author Adam Ashley <aashley@optimiser.com>
 * @package Framework
 * @version $Rev: 4944 $ $Date: 2005-09-01 16:41:07 +0800 (Thu, 01 Sep 2005) $   
 */

class bhg_core_list_iterator implements Iterator {

	// {{{ properties

	private $obj;

	// }}}
	// {{{ __construct()

	public function __construct($obj) {
		$this->obj = $obj;
	}

	// }}}
	// {{{ rewind()

	public function rewind() {
		$this->obj->first();
	}

	// }}}
	// {{{ current()

	public function current() {
		return $this->obj->getItem();
	}

	// }}}
	// {{{ key()

	public function key() {
		return $this->obj->getPosition();
	}

	// }}}
	// {{{ valid()

	public function valid() {
		return $this->obj->getPosition() < $this->obj->count();
	}

	// }}}
	// {{{ next()

	public function next() {
		return $this->obj->next(true);
	}

	// }}}

}
?>

<?php
/**
 * This file contains objects from the Library
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.14 $
 * @package Roster
 * @subpackage Library
 */

/**
 * A Shelf in the BHG Library
 *
 *<pre>
 *  20030624  aa  fixed CreateBook()
 *  20030623  aa  fixed permission calls
 *                fixed ordering on GetBooks()
 *  20030618  aa  completed Write functions
 *  20030426  aa  fleshed out interface
 *                completed Read-Only Functions
 *  20030409  aa  created file
 *</pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @access public
 * @package Roster
 * @subpackage Library
 * @version $Revision: 1.14 $
 */
class Shelf extends BHGObject {

  // {{{ properties

  /**
   * The ID Number of the Shelf
   *
   * @access protected
   * @var integer $shelf_id
   * @see GetID()
   */
  var $shelf_id;

  /**
   * The Name of this shelf
   *
   * @access protected
   * @var string $shelf_name
   * @see GetName(), SetName()
   */
  var $shelf_name;

  /**
   * The Description of this shelf
   *
   * @access protected
   * @var string $shelf_description
   * @see GetDescription(), SetDescription()
   */
  var $shelf_description;

  /**
   * The Sorting position of the Shelf
   *
   * @access protected
   * @var string $shelf_sort_order
   * @see MoveUp(), MoveDown()
   */
  var $shelf_sort_order;

  // }}}
  // {{{ Shelf()

  /**
   * Object Constructor
   * 
   * @access public
   * @param integer Shelf ID Number
   * @param string Coder Identification String
   */
  function Shelf($id, $coder='') {

    BHGObject::BHGObject($coder);

    $sql = 'SELECT id, '
                 .'name, '
                 .'description, '
                 .'sort_order '
          .'FROM library_shelves '
          .'WHERE id = '.$id;

    $result = mysql_query($sql, $this->roster_db);

    if ($shelf = @mysql_fetch_array($result)) {

      foreach ($shelf as $key => $value) {

        $key = 'shelf_'.$key;

        $this->$key = stripslashes($value);

      }

    } else {

      $this->roster_error = 'Could not load shelf details.';

      return false;

    }

  }

  // }}}
  // {{{ GetID()

  /**
   * Get the ID Number of the Shelf
   *
   * @access public
   * @return integer
   */
  function GetID() {

    return $this->shelf_id;

  }

  // }}}
  // {{{ GetName()

  /**
   * Get the name of the Shelf
   *
   * @access public
   * @return string
   */
  function GetName() {

    return $this->shelf_name;

  }

  // }}}
  // {{{ GetDescription()

  /**
   * Retrieve the Description of this Shelf
   *
   * @access public
   * @return string
   */
  function GetDescription() {

    return $this->shelf_description;

  }

  // }}}
  // {{{ GetBooks()

  /**
   * Get the books on this shelf
   *
   * Retrieve an array of Book Objects of all the Books on this shelf.
   * 
   * @access public
   * @return array Array of Book Objects
   * @uses Book
   */
  function GetBooks() {

    $sql = 'SELECT id '
          .'FROM library_books '
          .'WHERE shelf = '.$this->shelf_id.' '
          .'ORDER BY name';

    $books = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($book = mysql_fetch_array($books)) {

      $return[] = new Book($book['id'], $this->roster_coder);

    }

    return $return;

  }

  // }}}
  // {{{ SetName()

  /**
   * Set the Name of this Shelf
   *
   * @access public
   * @param string The new name
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function SetName($name) {

    if ($this->Allowed('library')) {

      if ($name > '') {

        if ($name != $this->shelf_name) {

          $sql = 'UPDATE library_shelves '
                .'SET name = \''.addslashes($name).'\' '
                .'WHERE id = '.$this->shelf_id;

          if (mysql_query($sql, $this->roster_db)) {

            $this->shelf_name = $name;

            return true;

          } else {

            $this->roster_error = 'Could not set new Shelf Name.';

            return false;

          }

        } else {

          return true;

        }

      } else {

        $this->roster_error = 'Can not set Shelf name to be blank.';

        return false;

      }

    } else {

      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}
  // {{{ SetDescription()

  /**
   * Set the description of this Shelf
   *
   * @access public
   * @param string The new description
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function SetDescription($description) {

    if ($this->Allowed('library')) {

      if ($description > '') {

        if ($description != $this->shelf_description) {

          $sql = 'UPDATE library_shelves '
                .'SET description = \''.addslashes($description).'\' '
                .'WHERE id = '.$this->shelf_id;

          if (mysql_query($sql, $this->roster_db)) {

            $this->shelf_description = $description;

            return true;

          } else {

            $this->roster_error = 'Can not save new Description for Shelf.';

            return false;

          }

        } else {

          return true;

        }

      } else {

        $this->roster_error = 'Can not set Description of Shelf to be blank.';

        return false;

      }

    } else {

      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}
  // {{{ CreateBook()

  /**
   * Create a new Book
   *
   * Create a new book on this shelf. You must be the owner of this shelf, one
   * shelf per coder ID, or have the allbooks permission.
   *
   * @access public
   * @param string Name of new Book
   * @return object Book
   * @uses BHGObject::Allowed()
   * @uses Book
   */
  function CreateBook($name) {

    if ($this->Allowed('library')) {

      if ($name > '') {

        $sql = 'INSERT INTO library_books (name, '
                                         .'shelf) '
              .'VALUES (\''.addslashes($name).'\', '
                      .$this->shelf_id.') ';

        if (mysql_query($sql, $this->roster_db)) {

          $id = mysql_insert_id($this->roster_db);

          return new Book($id, $this->roster_coder);

        } else {

          $this->roster_error = 'Could not create new Book.<br>';

          return false;

        }

      } else {

        $this->roster_error = 'The Name for the new Book can not be blank.';

        return false;

      }

    } else {

      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}
  // {{{ MoveUp()

  /**
   * Move the Shelf up the sort order
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function MoveUp() {

    if ($this->Allowed('library')) {

      $sql = 'SELECT MIN(sort_order) AS min, '
                   .'MAX(sort_order) AS max '
            .'FROM library_shelves ';

      $result = mysql_query($sql, $this->roster_db);

      $limit = mysql_fetch_assoc($result);

      // Check for cases where we dont need to do anything as we already are at
      // the Limit of movement for this function
      if (   ($limit['min'] == $limit['max'])
          || ($limit['min'] == $this->shelf_sort_order)) {

        return true;

      }

      $sql = 'SELECT id '
            .'FROM library_shelves '
            .'WHERE sort_order = '.($this->shelf_sort_order - 1).' ';

      $result = mysql_query($sql, $this->roster_db);

      if (mysql_num_rows($result) > 0) {

        $sql = 'UPDATE library_shelves '
              .'SET sort_order = '.$this->shelf_sort_order.' '
              .'WHERE id = '.mysql_result($result, 0, 'id');

        mysql_query($sql, $this->roster_db);

      }

      $sql = 'UPDATE library_shelves '
            .'SET sort_order = '.($this->shelf_sort_order - 1).' '
            .'WHERE id = '.$this->shelf_id;

      if (mysql_query($sql, $this->roster_db)) { 

        $this->shelf_sort_order = $this->shelf_sort_order - 1;

        return true;

      } else {

        $this->roster_error = 'There was an error while moving this Shelf.';

        return false;

      }

    } else {

      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}
  // {{{ MoveDown()

  /**
   * Move the Shelf down the sort order
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function MoveDown() {

    if ($this->Allowed('library')) {

      $sql = 'SELECT MIN(sort_order) AS min, '
                   .'MAX(sort_order) AS max '
            .'FROM library_shelves ';

      $result = mysql_query($sql, $this->roster_db);

      $limit = mysql_fetch_assoc($result);

      // Check for cases where we dont need to do anything as we already are at
      // the Limit of movement for this function
      if (   ($limit['min'] == $limit['max'])
          || ($limit['max'] == $this->shelf_sort_order)) {

        return true;

      }

      $sql = 'SELECT id '
            .'FROM library_shelves '
            .'WHERE sort_order = '.($this->shelf_sort_order + 1).' ';

      $result = mysql_query($sql, $this->roster_db);

      if (mysql_num_rows($result) > 0) {

        $sql = 'UPDATE library_shelves '
              .'SET sort_order = '.$this->shelf_sort_order.' '
              .'WHERE id = '.mysql_result($result, 0, 'id');

        mysql_query($sql, $this->roster_db);

      }

      $sql = 'UPDATE library_shelves '
            .'SET sort_order = '.($this->shelf_sort_order + 1).' '
            .'WHERE id = '.$this->shelf_id;

      if (mysql_query($sql, $this->roster_db)) { 

        $this->shelf_sort_order = $this->shelf_sort_order + 1;

        return true;

      } else {

        $this->roster_error = 'There was an error while moving this Shelf.';

        return false;

      }

    } else {

      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}
  // {{{ Delete()

  /**
   * Delete This Shelf
   *
   * Warning: This function deletes the shelf and all book on it. It can not be
   * recovered from. Do not use unless you are 100% absolutely sure you wish
   * to do this.
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   * @uses Book
   * @uses Book::Delete()
   */
  function Delete() {

    if ($this->Allowed('library')) {

      $books = $this->GetBooks();

      foreach ($books as $book) {

        $book->Delete();

      }

      $sql = 'DELETE FROM library_shelves WHERE id = '.$this->shelf_id;

      if (mysql_query($sql, $this->roster_db)) {

        return true;

      } else {

        $this->roster_error = 'Could not Delete Shelf.';

        return false;

      }

    } else {

      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

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
 * BHG Library
 *
 * This object is basically the Library of the BHG. In theory all documents
 * or books should be available through this system. 
 *
 *<pre>
 *  20030704  aa  added GetSection()
 *  20030624  aa  changed CreateShelf to return new shelf object on success
 *  20030428  ah  added GetChapter function
 *                fixed GetShelves function to return an array
 *  20030426  aa  added CreateShelf stub
 *                completed Read-Only functions
 *  20030409  aa  started file
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
class Library extends BHGObject {

  // {{{ properties

  // }}}
  // {{{ Library()

  /**
   * Object Constructor
   *
   * @access public
   * @param string Coder Identification String
   */
  function Library($coder='') {

    BHGObject::BHGObject($coder);

  }

  // }}}
  // {{{ GetShelves()

  /**
   * Get All the Shelves I can see
   *
   * This function returns an array of Shelf Objects. For a Shelf to be included
   * in this array, the current coder ID must either have permission to create
   * books on this shelf, or have permission to read at least on book on this
   * shelf.
   *
   * @access public
   * @return array Array of Shelf Objects
   * @uses Shelf
   */
  function GetShelves() {

    $sql = 'SELECT id '
          .'FROM library_shelves '
          .'ORDER BY sort_order ASC ';

    $shelves = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($shelf = mysql_fetch_array($shelves)) {

      $return[] = new Shelf($shelf['id'], $this->roster_coder);

    }

    return $return;

  }

  // }}}
  // {{{ GetShelf()

  /**
   * Get a specific shelf
   *
   * Retrieve a specific shelf from the library
   *
   * @access public
   * @param integer The ID Number of the shelf to retrieve
   * @return object Shelf
   * @uses Shelf
   */
  function GetShelf($id) {

    return new Shelf($id, $this->roster_coder);

  }

  // }}}
  // {{{ GetBook()

  /**
   * Get a specific book
   *
   * Retrieve a specific book from the library
   *
   * @access public
   * @param integer The ID Number of the book to retrieve
   * @return object Book
   * @uses Book
   */
  function GetBook($id) {

    return new Book($id, $this->roster_coder);

  }

  // }}}
  // {{{ GetChapter()

  /**
   * Get a specific chapter
   *
   * Retrieve a specific chapter from the library
   *
   * @access public
   * @param integer The ID Number of the chapter to retrieve
   * @return object Chapter
   * @uses Chapter
   */
  function GetChapter($id) {

    return new Chapter($id, $this->roster_coder);

  }

  // }}}
  // {{{ GetSection()

  /**
   * Load a specfic Section
   *
   * @access public
   * @param integer The ID Number of the section to Load
   * @return object Section
   * @uses Section
   */
  function GetSection($id) {

    return new Section($id, $this->roster_coder);

  }

  // }}}
  // {{{ CreateShelf()

  /**
   * Create a new shelf in the Library
   *
   * Create a new shelf. The new shelf is created at the bottom of the list of
   * shelves by default
   *
   * @access public
   * @param string The name of the new shelf
   * @return mixed Shelf Object on success. False on failure.
   * @uses BHGObject::Allowed()
   * @uses Shelf
   */
  function CreateShelf($name) {

    if ($this->Allowed('library')) {

      $sql = 'SELECT MAX(sort_order) AS sort_order '
            .'FROM library_shelves ';

      $sort_order = mysql_result(mysql_query($sql, $this->roster_db),
                                 0,
                                 'sort_order');

      $sql = 'INSERT INTO library_shelves (name, '
                                         .'description, '
                                         .'sort_order) '
            ."VALUES ('".addslashes($name).'\', '
                    .'\'\', '
                    .($sort_order + 1).')';

      if (mysql_query($sql, $this->roster_db)) {

        $lastid = mysql_insert_id($this->roster_db);

        return new Shelf($lastid, $this->roster_coder);

      } else {

        $this->roster_error = 'Could not create new shelf.';

        return false;

      }

    } else {

      $this->roster_error = 'The coder that created this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

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
 * A Chapter within a book in the BHG Library
 *
 * It's a chapter what more do you want to know?
 *
 *<pre>
 *  20030704  aa  fixed SetTitle()
 *  20030623  aa  fixed permission calls
 *  20030618  aa  completed Write functions
 *  20030428  ah  added GetBook function
 *                fixed GetSections to use library_sections and not _chapters
 *  20030426  aa  completed read-only functions
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
class Chapter extends BHGObject {

  // {{{ properties

  /**
   * Chapter ID Number
   *
   * @access protected
   * @var integer $chapter_id
   * @see GetID()
   */
  var $chapter_id;

  /**
   * Chapter Title
   *
   * @access protected
   * @var string $chapter_name
   * @see GetTitle(), SetTitle()
   */
  var $chapter_name;

  /**
   * The ID Number of the Book this Chapter belongs to
   *
   * @access protected
   * @var integer $chapter_book
   * @see GetBook()
   */
  var $chapter_book;

  /**
   * The Sorting position of this chapter within this book
   * 
   * @access protected
   * @var integer $chapter_sort_order
   * @see MoveUp(), MoveDown()
   */
  var $chapter_sort_order;

  // }}}
  // {{{ Chapter()

  /**
   * Object Constructor
   *
   * @access public
   * @param integer Chapter ID Number
   * @param string Coder Identification String
   */
  function Chapter($id, $coder='') {

    BHGObject::BHGObject($coder);

    $sql = 'SELECT id, '
                 .'book, '
                 .'name, '
                 .'sort_order '
          .'FROM library_chapters '
          .'WHERE id = '.$id;

    $result = mysql_query($sql, $this->roster_db);

    if ($chapter = @mysql_fetch_array($result)) {

      foreach ($chapter as $key => $value) {

        $key = 'chapter_'.$key;

        $this->$key = stripslashes($value);

      }

    } else {

      $this->roster_error = 'Could not load Chapter details.';

      return false;

    }

  }

  // }}}
  // {{{ GetID

  /**
   * Retrieve the ID number of this Chapter
   *
   * @access public
   * @return integer
   */
  function GetID() {

    return $this->chapter_id;

  }

  // }}}
  // {{{ GetBook

  /**
   * Retrieve the Book this Chapter is a part of.
   *
   * @access public
   * @return object Book
   * @uses Book
   */
  function GetBook() {

    return new Book($this->chapter_book, $this->roster_coder);

  }

  // }}}
  // {{{ GetTitle()

  /**
   * Get the title of this chapter
   *
   * @access public
   * @return string
   */
  function GetTitle() {

    return $this->chapter_name;

  }

  // }}}
  // {{{ GetSections()

  /**
   * Retrieve all the Sections in this chapter
   *
   * @access public
   * @return array Array of Section Objects
   * @uses Section
   */
  function GetSections() {

    $sql = 'SELECT id '
          .'FROM library_sections '
          .'WHERE chapter = '.$this->chapter_id.' '
          .'ORDER BY sort_order ASC';

    $sections = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($section = @mysql_fetch_array($sections)) {

      $return[] = new Section($section['id'], $this->roster_coder);

    }

    return $return;

  }

  // }}}
  // {{{ GetSection()

  /**
   * Retrieve a specific section from this chapter
   *
   * @access public
   * @param integer The ID number of the section to retrieve
   * @return object Section
   * @uses Section
   */
  function GetSection($id) {

    return new Section($id, $this->roster_coder);

  }

  // }}}
  // {{{ SetTitle()

  /**
   * Set the title of this chapter
   *
   * @access public
   * @param string The new Title
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function SetTitle($title) {

    if ($this->Allowed('library')) {

      if ($title > '') {

        if ($title != $this->chapter_name) {

          $sql = 'UPDATE library_chapters '
                .'SET name = \''.addslashes($title).'\' '
                .'WHERE id = '.$this->chapter_id;

          if (mysql_query($sql, $this->roster_db)) {

            $this->chapter_name = $title;

            return true;

          } else {

            $this->roster_error = 'Could not set title.';

            return false;

          }

        } else {

          return true;

        }

      } else {

        $this->roster_error = 'Can not set title to be blank';

        return false;

      }

    } else {

      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}
  // {{{ AddSection()

  /**
   * Add a new section to this chapter
   *
   * @access public
   * @return object Section
   * @uses BHGObject::Allowed()
   * @uses Section
   */
  function AddSection() {

    if ($this->Allowed('library')) {

      $sql = 'SELECT COUNT(*) AS count, '
                   .'MAX(sort_order) AS maxsort '
            .'FROM library_sections '
            .'WHERE chapter = '.$this->chapter_id;

      $result = mysql_query($sql, $this->roster_db);

      $count = mysql_result($result, 0, 'count');
      $max = mysql_result($result, 0, 'maxsort');

      $sql = 'INSERT INTO library_sections (name, '
                                          .'content, '
                                          .'chapter, '
                                          .'sort_order, '
                                          .'useHTML) '
            .'VALUES (\'Section '.($count + 1).'\', '
                    .'\'New Section Content\', '
                    .$this->chapter_id.', '
                    .($max + 1).', '
                    .'1) ';

      if (mysql_query($sql, $this->roster_db)) {

        $id = mysql_insert_id($this->roster_db);

        return new Section($id, $this->roster_coder);

      } else {

        $this->roster_error = 'There was an error creating the new Section.';

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
   * Move this chapter up the chapter list
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function MoveUp() {

    if ($this->Allowed('library')) {

      $sql = 'SELECT MIN(sort_order) AS min, '
                   .'MAX(sort_order) AS max '
            .'FROM library_chapters '
            .'WHERE book = '.$this->chapter_book;

      $result = mysql_query($sql, $this->roster_db);

      $limit = mysql_fetch_assoc($result);

      // Check for cases where we dont need to do anything as we already are at
      // the Limit of movement for this function
      if (   ($limit['min'] == $limit['max'])
          || ($limit['min'] == $this->chapter_sort_order)) {

        return true;

      }

      $sql = 'SELECT id '
            .'FROM library_chapters '
            .'WHERE book = '.$this->chapter_book.' '
              .'AND sort_order = '.($this->chapter_sort_order - 1).' ';

      $result = mysql_query($sql, $this->roster_db);

      if (mysql_num_rows($result) > 0) {

        $sql = 'UPDATE library_chapters '
              .'SET sort_order = '.$this->chapter_sort_order.' '
              .'WHERE id = '.mysql_result($result, 0, 'id');

        mysql_query($sql, $this->roster_db);

      }

      $sql = 'UPDATE library_chapters '
            .'SET sort_order = '.($this->chapter_sort_order - 1).' '
            .'WHERE id = '.$this->chapter_id;

      if (mysql_query($sql, $this->roster_db)) { 

        $this->chapter_sort_order = $this->chapter_sort_order - 1;

        return true;

      } else {

        $this->roster_error = 'There was an error while moving this Chapter.';

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
   * Move this chapter down the chapter list
   * 
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function MoveDown() {

    if ($this->Allowed('library')) {

      $sql = 'SELECT MIN(sort_order) AS min, '
                   .'MAX(sort_order) AS max '
            .'FROM library_chapters '
            .'WHERE book = '.$this->chapter_book;

      $result = mysql_query($sql, $this->roster_db);

      $limit = mysql_fetch_assoc($result);

      // Check for cases where we dont need to do anything as we already are at
      // the Limit of movement for this function
      if (   ($limit['min'] == $limit['max'])
          || ($limit['max'] == $this->chapter_sort_order)) {

        return true;

      }

      $sql = 'SELECT id '
            .'FROM library_chapters '
            .'WHERE book = '.$this->chapter_book.' '
              .'AND sort_order = '.($this->chapter_sort_order + 1).' ';

      $result = mysql_query($sql, $this->roster_db);

      if (mysql_num_rows($result) > 0) {

        $sql = 'UPDATE library_chapters '
              .'SET sort_order = '.$this->chapter_sort_order.' '
              .'WHERE id = '.mysql_result($result, 0, 'id');

        mysql_query($sql, $this->roster_db);

      }

      $sql = 'UPDATE library_chapters '
            .'SET sort_order = '.($this->chapter_sort_order + 1).' '
            .'WHERE id = '.$this->chapter_id;

      if (mysql_query($sql, $this->roster_db)) { 

        $this->chapter_sort_order = $this->chapter_sort_order + 1;

        return true;

      } else {

        $this->roster_error = 'There was an error while moving this Chapter.';

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
   * Delete this chapter
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   * @uses GetSections()
   * @uses Section::Delete()
   */
  function Delete() {

    if ($this->Allowed('library')) {

      $sections = $this->GetSections();

      foreach ($sections as $section) {

        $section->Delete();

      }

      $sql = 'DELETE FROM library_chapters WHERE id = '.$this->chapter_id;

      if (mysql_query($sql, $this->roster_db)) {

        return true;

      } else {

        $this->roster_error = 'There was an error while deleting the chapter.';

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

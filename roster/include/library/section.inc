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
 * A Section in a chapter in a book in the BHG library
 *
 * A section is the smallest part of a book. Typically a section would represent
 * a chapter within the book. However if you do not wish to be so fancy you can
 * just have one section per chapter and put everything in it.
 *
 *<pre>
 *  20030704  aa  fixed MoveUp() and MoveDown()
 *  20030623  aa  fixed permission calls
 *  20030618  aa  completed Write functions
 *  20030426  aa  completed Read-Only functions
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
class Section extends BHGObject {

  // {{{ properties

  /**
   * The Section ID Number
   * 
   * @access protected
   * @var integer $section_id
   * @see GetID()
   */
  var $section_id;

  /**
   * The name of the section
   *
   * @access protected
   * @var string $section_name
   * @see GetTitle(), SetTitle()
   */
  var $section_name;

  /**
   * The main content of this section
   *
   * @access protected 
   * @var string $section_content
   * @see GetBody(), SetBody()
   */
  var $section_content;

  /**
   * The ID number of the Chapter this section belongs to
   *
   * @access protected
   * @var integer $section_chapter
   * @see GetChapter()
   */
  var $section_chapter;

  /**
   * The Sorting position of this section within the chapter
   *
   * @access protected
   * @var integer $section_sort_order
   * @see MoveUp(), MoveDown()
   */
  var $section_sort_order;

  // }}}
  // {{{ Section()

  /**
   * Object Constructor
   *
   * @access public
   * @param integer Section ID Number
   * @param string Coder Identification String
   */
  function Section($id, $coder='') {

    BHGObject::BHGObject($coder);

    $sql = 'SELECT id, '
                 .'name, '
                 .'content, '
                 .'chapter, '
                 .'sort_order '
          .'FROM library_sections '
          .'WHERE id = '.$id;

    $result = mysql_query($sql, $this->roster_db);

    if ($section = @mysql_fetch_array($result)) {

      foreach ($section as $key => $value) {

        $key = 'section_'.$key;

        $this->$key = stripslashes($value);

      }

    } else {

      $this->roster_error = 'Could not load Section details.';

      return false;

    }

  }

  // }}}
  // {{{ GetID()

  /**
   * Retrieve the ID Number of this section
   *
   * @access public
   * @return integer
   */
  function GetID() {

    return $this->section_id;

  }

  // }}}
  // {{{ GetTitle()

  /**
   * Get the title of this section
   *
   * @access public
   * @return string
   */
  function GetTitle() {

    return $this->section_name;

  }

  // }}}
  // {{{ GetBody()

  /**
   * Retrieve the Body of this section
   * 
   * @access public
   * @return string
   */
  function GetBody() {

    return $this->section_content;

  }

  // }}}
  // {{{ GetChapter()

  /**
   * Get the chapter this section belongs to
   *
   * @access public
   * @return object Chapter
   * @uses Chapter
   */
  function GetChapter() {

    return new Chapter($this->section_chapter, $this->roster_coder);

  }

  // }}}
  // {{{ SetTitle()

  /**
   * Set the title of this section
   *
   * @access public
   * @param string The new Tite
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function SetTitle($title) {

    if ($this->Allowed('library')) {

      if ($title != $this->section_name) {

        $sql = 'UPDATE library_sections '
              .'SET name = \''.addslashes($title).'\' '
              .'WHERE id = '.$this->section_id;

        if (mysql_query($sql, $this->roster_db)) {

          $this->section_name = $title;

          return true;

        } else {

          $this->roster_error = 'Could not set new title for section.';

          return false;

        }

      } else {

        return true;

      }

    } else {

      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to call this function.';

      return false;

    }

  }
  
  // }}}
  // {{{ SetBody()

  /**
   * Set the Body of this section
   * 
   * @access public
   * @param string The new Body
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function SetBody($body) {

    if ($this->Allowed('library')) {

      if ($title != $this->section_content) {

        $sql = 'UPDATE library_sections '
              .'SET content = \''.addslashes($body).'\' '
              .'WHERE id = '.$this->section_id;

        if (mysql_query($sql, $this->roster_db)) {

          $this->section_content = $body;

          return true;

        } else {

          $this->roster_error = 'Could not set new body for section.';

          return false;

        }

      } else {

        return true;

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
   * Move this section up the section list
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function MoveUp() {

    if ($this->Allowed('library')) {

      $sql = 'SELECT MIN(sort_order) AS min, '
                   .'MAX(sort_order) AS max '
            .'FROM library_sections '
            .'WHERE chapter = '.$this->section_chapter;

      $result = mysql_query($sql, $this->roster_db);

      $limit = mysql_fetch_assoc($result);

      // Check for cases where we dont need to do anything as we already are at
      // the Limit of movement for this function
      if (   ($limit['min'] == $limit['max'])
          || ($limit['min'] == $this->section_sort_order)) {

        return true;

      }

      $sql = 'SELECT id '
            .'FROM library_sections '
            .'WHERE chapter = '.$this->section_chapter.' '
              .'AND sort_order = '.($this->section_sort_order - 1).' ';

      $result = mysql_query($sql, $this->roster_db);

      if (mysql_num_rows($result) > 0) {

        $sql = 'UPDATE library_sections '
              .'SET sort_order = '.$this->section_sort_order.' '
              .'WHERE id = '.mysql_result($result, 0, 'id');

        mysql_query($sql, $this->roster_db);

      }

      $sql = 'UPDATE library_sections '
            .'SET sort_order = '.($this->section_sort_order - 1).' '
            .'WHERE id = '.$this->section_id;

      if (mysql_query($sql, $this->roster_db)) { 

        $this->section_sort_order = $this->section_sort_order - 1;

        return true;

      } else {

        $this->roster_error = 'There was an error while moving this Section.';

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
   * Move this section down the section list
   * 
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function MoveDown() {

    if ($this->Allowed('library')) {

      $sql = 'SELECT MIN(sort_order) AS min, '
                   .'MAX(sort_order) AS max '
            .'FROM library_sections '
            .'WHERE chapter = '.$this->section_chapter;

      $result = mysql_query($sql, $this->roster_db);

      $limit = mysql_fetch_assoc($result);

      // Check for cases where we dont need to do anything as we already are at
      // the Limit of movement for this function
      if (   ($limit['min'] == $limit['max'])
          || ($limit['max'] == $this->section_sort_order)) {

        return true;

      }

      $sql = 'SELECT id '
            .'FROM library_sections '
            .'WHERE chapter = '.$this->section_chapter.' '
              .'AND sort_order = '.($this->section_sort_order + 1).' ';

      $result = mysql_query($sql, $this->roster_db);

      if (mysql_num_rows($result) > 0) {

        $sql = 'UPDATE library_sections '
              .'SET sort_order = '.$this->section_sort_order.' '
              .'WHERE id = '.mysql_result($result, 0, 'id');

        mysql_query($sql, $this->roster_db);

      }

      $sql = 'UPDATE library_sections '
            .'SET sort_order = '.($this->section_sort_order + 1).' '
            .'WHERE id = '.$this->section_id;

      if (mysql_query($sql, $this->roster_db)) { 

        $this->section_sort_order = $this->section_sort_order + 1;

        return true;

      } else {

        $this->roster_error = 'There was an error while moving this Section.';

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
   * Delete this section
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function Delete() {

    if ($this->Allowed('library')) {

      $sql = 'DELETE FROM library_sections WHERE id = '.$this->section_id;

      if (mysql_query($sql, $this->roster_db)) {

        return true;

      } else {

        $this->roster_error = 'There was an error while deleting the Section.';

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

<?php
/**
 * This file contains objects from the Library
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.18 $
 * @package Roster
 * @subpackage Library
 */

/**
 * A Book in the BHG Library
 *
 * A book, what is a book you ask? That is that thing with pages made of paper
 * that you where supposed to read and summarise for class today, but you didnt.
 * Well this is just like that except its completely different.
 *
 * This object implements the ways for interacting with and accessing a book 
 * which happens to be contained within the library.
 *
 *<pre>
 *  20030704  aa  fixed AddChapter()
 *  20030623  aa  fixed permission calls
 *  20030623  aa  fixed HasImage()
 *  20030617  aa  completed Write and Delete functions
 *  20030428  ah  fixed bug in GetChapters
 *  20030426  aa  fleshed out interface
 *                completed Read-Only functions
 *  20030409  aa  created file
 *</pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @access public
 * @package Roster
 * @subpackage Library
 * @version $Revision: 1.18 $
 */
class Book extends BHGObject {

  // {{{ properties

  /**
   * The ID Number of the book
   *
   * @access protected
   * @var integer $book_id
   * @see GetID()
   */
  var $book_id;

  /**
   * The book's name
   *
   * @access protected
   * @var string $book_name
   * @see GetTitle(), SetTitle()
   */
  var $book_name;

  /**
   * The book's description
   *
   * @access protected
   * @var string $book_description
   * @see GetDescription(), SetDescription()
   */
  var $book_description;

  /**
   * The mime type of this books image
   *
   * @access protected
   * @var string $book_image_type
   * @see HasImage(), GetImageType(), GetImageData(), UploadNewImage()
   */
  var $book_image_type;

  /**
   * The ID number of the shelf that this book is located upon
   * 
   * @access protected
   * @var integer $book_shelf
   * @see GetShelf(), ChangeShelf()
   */
  var $book_shelf;

  // }}}
  // {{{ Book()

  /**
   * Object Constructor
   * 
   * It Constructs!!!!!
   *
   * @access public
   * @param integer The ID Number of the Book
   * @param string Coder Identification String
   */
  function Book($id, $coder='') {

    BHGObject::BHGObject($coder);

    $sql = 'SELECT id, '
                 .'name, '
                 .'description, '
                 .'image_type, '
                 .'shelf '
          .'FROM library_books '
          .'WHERE id = '.$id;

    $result = mysql_query($sql, $this->roster_db);

    if ($book = @mysql_fetch_array($result)) {

      foreach ($book as $key => $value) {

        $key = 'book_'.$key;

        $this->$key = stripslashes($value);

      }

      $sql = 'SELECT person '
            .'FROM library_moderators '
            .'WHERE book = '.$this->book_id;

      $result = mysql_query($sql, $this->roster_db);

      $this->book_authors = array();

      while ($author = @mysql_fetch_row($result)) {
        
        $this->book_authors[] = $author[0];

      }

    } else {

      $this->roster_error = 'Could not load book details.';

      return false;

    }

  }

  // }}}
  // {{{ GetID()

  /**
   * Retrieve The ID Number of the Book
   *
   * @access public
   * @return integer
   */
  function GetID() {

    return $this->book_id;

  }
  
  // }}}
  // {{{ GetTitle()

  /**
   * Retrieve The Title of the Book
   *
   * @access public
   * @return string
   */
  function GetTitle() {

    return $this->book_name;

  }

  // }}}
  // {{{ GetDescription()

  /**
   * Retrieve The Description of the Book
   *
   * @access public
   * @return string
   */
  function GetDescription() {

    return $this->book_description;

  }

  // }}}
  // {{{ GetAuthors()

  /**
   * Retrieve a List of all the authors
   *
   * Whenever someone edits or adds something to the book, they are added to
   * the list of authors. This function returns an array of Person objects one
   * for each author.
   *
   * @access public
   * @return array Array of Person Objects
   * @uses Person
   */
  function GetAuthors() {

    $return = array();

    foreach ($this->book_authors as $author) {

      $return[] = new Person($author, $this->roster_coder);

    }

    return $return;

  }

  // }}}
  // {{{ HasImage()

  /**
   * Whether this book has an image
   *
   * @access public
   * @return boolean
   */
  function HasImage() {

    return ($this->book_image_type != '' || $this->book_image_type != 'none');

  }

  // }}}
  // {{{ GetImageType()

  /**
   * Retrieve the mimetype of the image of this book
   *
   * @access public
   * @return string
   */
  function GetImageType() {

    if ($this->HasImage()) {

      return $this->book_image_type;

    } else {

      return '';

    }

  }

  // }}}
  // {{{ GetImageData()

  /**
   * Retrieve the actual binary data of the image
   *
   * @access public
   * @return string
   */
  function GetImageData() {

    if ($this->HasImage()) {

      $sql = 'SELECT image '
            .'FROM library_books '
            .'WHERE id = '.$this->book_id;

      return mysql_result(mysql_query($sql, $this->roster_db),
                          0,
                          'image');

    } else {

      return '';

    }

  }

  // }}}
  // {{{ GetChapters()

  /**
   * Get all the chapters from this book
   *
   * @access public
   * @return array Array of Chapter Objects
   * @uses Chaper
   */
  function GetChapters() {

    $sql = 'SELECT id '
          .'FROM library_chapters '
          .'WHERE book = '.$this->book_id.' '
	  .'ORDER BY sort_order';

    $result = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($chapter = mysql_fetch_array($result)) {

      $return[] = new Chapter($chapter['id'], $this->roster_coder);

    }

    return $return;

  }

  // }}}
  // {{{ GetChapter()

  /**
   * Get a specific chapter from this book
   * 
   * @access public
   * @param integer The ID number of the chapter to retrieve
   * @return object Chapter
   * @uses Chaper
   */
  function GetChapter($id) {

    return new Chapter($id, $this->roster_coder);

  }

  // }}}
  // {{{ GetShelf()

  /**
   * Get the shelf that this book is on
   *
   * @access public
   * @return object Shelf
   * @uses Shelf
   */
  function GetShelf() {

    return new Shelf($this->book_shelf, $this->roster_coder);

  }

  // }}}
  // {{{ SetTitle()

  /**
   * Set the Title of the book
   *
   * @access public
   * @param string The new title
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function SetTitle($title) {

    if ($this->Allowed('library')) {

      if ($title > '') {

        if ($title != $this->book_name) {

          // Do the Update
          $sql = 'UPDATE library_books '
                .'SET name = \''.addslashes($title).'\' '
                .'WHERE id = '.$this->book_id;

          if (mysql_query($sql, $this->roster_db)) {

            $this->book_name = $title;

            return true;

          } else {

            $this->roster_error = 'Could not set the new Book Title.';

            return false;

          }

        } else {

          return true;

        }

      } else {

        $this->roster_error = 'Can not set Book Title to nothing.';

        return false;

      }

    } else {

      $this->roster_error = 'The coder that created this object does not have '
        .'permission to call this function';

      return false;

    }

  }

  // }}}
  // {{{ SetDescription()

  /**
   * Set the Description of the book
   *
   * @access public
   * @param string The new description
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function SetDescription($description) {

    if ($this->Allowed('library')) {

      if ($description > '') {

        if ($description != $this->book_description) {

          // Do the Update
          $sql = 'UPDATE library_books '
                .'SET description = \''.addslashes($description).'\' '
                .'WHERE id = '.$this->book_id;

          if (mysql_query($sql, $this->roster_db)) {

            $this->book_description = $description;

            return true;

          } else {

            $this->roster_error = 'Could not set the new Book Description.';

            return false;

          }

        } else {

          return true;

        }

      } else {

        $this->roster_error = 'Can not set Book Description to nothing.';

        return false;

      }

    } else {

      $this->roster_error = 'The coder that created this object does not have '
        .'permission to call this function';

      return false;

    }

  }

  // }}}
  // {{{ AddAuthor()

  /**
   * Add someone to the list of authors
   *
   * @access public
   * @param mixed The author's id number or a Person object representing the new
   *              author
   * @return boolean
   * @uses BHGObject::Allowed()
   * @uses Person
   */
  function AddAuthor($person) {

    if ($this->Allowed('library')) {

      if (is_object($person)) {

        if ($person instanceof Person) {

          $id = $id->GetID();

        } else {

          $this->roster_error = 'Invalid Object passed to AddAuthor()';

          return false;

        }

      } elseif (is_numeric($person)) {

        $id = $person;

      } else {

        $this->roster_error = 'Invalid parameter passed to AddAuthor()';

        return false;

      }

      if (!in_array($id, $this->book_authors)) {

        $sql = 'INSERT INTO library_moderators (book, person) '
              ."VALUES (".$this->book_id.', '.$id.')';

        if (mysql_query($sql, $this->roster_db)) {

          $this->book_authors[] = $id;

          return true;

        } else {

          $this->roster_error = 'Could not Add Author to Book.';

          return false;

        }

      } else {

        return true;

      }

    } else {

      $this->roster_error = 'The Coder that created this function does not '
        .'have permission to access this function.';

      return false;

    }

  }

  // }}}
  // {{{ RemoveAuthor()

  /**
   * Remove someone from the list of authors
   *
   * @access public
   * @param mixed The author's id number or a Person object representing the new
   *              author
   * @return boolean
   * @uses BHGObject::Allowed()
   * @uses Person
   */
  function RemoveAuthor($person) {

    if ($this->Allowed('library')) {

      if (is_object($person)) {

        if ($person instanceof Person) {

          $id = $id->GetID();

        } else {

          $this->roster_error = 'Invalid Object passed to RemoveAuthor()';

          return false;

        }

      } elseif (is_numeric($person)) {

        $id = $person;

      } else {

        $this->roster_error = 'Invalid parameter passed to RemoveAuthor()';

        return false;

      }

      if (in_array($id, $this->book_authors)) {

        $sql = 'DELETE FROM library_moderators '
              .'WHERE book = '.$this->book_id.' '
                .'AND person = '.$id;

        if (mysql_query($sql, $this->roster_db)) {

          while ($pos = array_search($id, $this->book_authors) !== false) {

            unset($this->book_authors[$pos]);

          }

          return true;

        } else {

          $this->roster_error = 'Could not Remove Author from Book.';

          return false;

        }

      } else {

        $this->roster_error = 'Could not Remove Author from Book as they are '
          .'not an Author of this Book.';

        return false;

      }

    } else {

      $this->roster_error = 'The Coder that created this function does not '
        .'have permission to access this function.';

      return false;

    }

  }

  // }}}
  // {{{ UploadNewImage()
  
  /**
   * Upload a new image for this book
   *
   * Upload a new image for this book. The $image parameter should be one of
   * the fields from the $_FILES superglobal array. 
   *
   * For Example:
   * <code>
   *  $book->UploadNewImage($_FILES['user_file']);
   * </code>
   *
   * @access public
   * @param array
   * @return boolean
   * @uses BHGObject::Allowed()
   */
  function UploadNewImage($image) {

    if ($this->Allowed('library')) {

      if (is_uploaded_file($image['tmp_name'])) {

        $filecontents = file_get_contents($image['tmp_name']);

        $sql = 'UPDATE library_books '
              .'SET image_type = \''.$image['type'].'\', '
                  .'image = \''.addslashes($filecontents).'\' '
              .'WHERE id = '.$this->book_id;

        if (mysql_query($sql, $this->roster_db)) {

          $this->book_image_type = $image['type'];

          return true;

        } else {

          $this->roster_error = 'Could not save new image.';

          return false;

        }

      } else {

        $this->roster_error = 'Invalid parameter passed to UploadNewImage(). '
          .'Parameter does not represent uploaded image.';

        return false;

      }

    } else {

      $this->roster_error = 'The Coder that created this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}
  // {{{ ChangeShelf()

  /**
   * Change the shelf this book is on
   *
   * @access public
   * @param mixed Either the Shelf ID or a Shelf Object
   * @return boolean
   * @uses BHGObject::Allowed()
   * @uses Shelf
   */
  function ChangeShelf($shelf) {

    if ($this->Allowed('library')) {

      if (is_object($shelf)) {

        if ($shelf instanceof Shelf) {

          $id = $shelf->GetID();

        } else {

          $this->roster_error = 'Invalid Object passed to ChangeShelf()';

          return false;

        }

      } elseif ($is_numeric($shelf)) {

        $id = $shelf;

      } else {

        $this->roster_error = 'Invalid parameter passed to ChangeShelf()';

      }

      if ($id != $this->book_shelf) {

        $sql = 'UPDATE library_books '
              .'SET shelf = '.$id.' '
              .'WHERE id = '.$this->book_id;

        if (mysql_query($sql, $this->roster_db)) {

          $this->book_shelf = $id;

          return true;

        } else {

          $this->roster_error = 'Could not set New Shelf.';

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
  // {{{ AddChapter()

  /**
   * Add a chapter to this book
   *
   * This adds an empty Chapter entitled 'Chapter N' where N is one more than 
   * the number of Chapters already in the book. The sort order for this chapter
   * is set to one more than the highest sort order so it appears at the end
   * of the book.
   *
   * @access public
   * @return object Chapter
   * @uses BHGObject::Allowed()
   * @uses Chapter
   */
  function AddChapter() {

    if ($this->Allowed('library')) {

      // Get the Count of chapters in this book, and the maximum sort order

      $sql = 'SELECT COUNT(*) AS count, '
                   .'MAX(sort_order) AS max_sort '
            .'FROM library_chapters '
            .'WHERE book = '.$this->book_id;

      $result = mysql_query($sql, $this->roster_db);

      $count = mysql_result($result, 0, 'count');
      $max = mysql_result($result, 0, 'max_sort');

      $sql = 'INSERT INTO library_chapters (book, '
                                          .'name, '
                                          .'sort_order) '
            ."VALUES (".$this->book_id.', '
                    .'\'Chapter '.($count + 1).'\', '
                    .($max + 1).')';

      if (mysql_query($sql, $this->roster_db)) {

        $id = mysql_insert_id($this->roster_db);

        return new Chapter($id, $this->roster_coder);

      } else {

        $this->roster_error = 'Could not create new Chapter.';

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
   * Delete this book from the shelf
   *
   * This completely removes this book and all its chapters and all the sections
   * from within the chapters. It can not be recovered from.
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   * @uses Chapter
   * @uses Chapter::Delete()
   */
  function Delete() {

    if ($this->Allowed('library')) {

      $chapters = $this->GetChapters();

      foreach ($chapters as $chapter) {

        $chapter->Delete();

      }

      $sql = 'DELETE FROM library_books WHERE id = '.$this->book_id;

      if (mysql_query($sql, $this->roster_db)) {

        return true;

      } else {

        $this->roster_error = 'Could not remove book entry.';

        return false;

      }

    } else {

      $this->roster_error = 'The Coder that created this Object does not have '
        .'permission to call this function.';

      return false;

    }

  }
  
  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

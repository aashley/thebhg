<?php
/**
 * This file contains objects from the Centralised News System
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.19 $
 * @package Roster
 * @subpackage News
 */

/**
 * News Item
 *
 * This object represents a single news item. It provides access to read the
 * details, and to render it if you are using the builtin renderer.
 *
 *<pre>
 *  20030409  aa  squash mysql errors when loading non-existant news item
 *                fix to output of renderer irt new lines
 *  20030408  aa  Completed Render()
 *                Documentation Fixes
 *  20030406  aa  Added Delete(), SetTitle(), SetMessage() and SetSection()
 *                Made changes to Set* functions and to Constructor, so you can
 *                only load and/or edit if you have the correct perms
 *  20030330  ah  Changed title to topic to match the table
 *</pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @access public
 * @package Roster
 * @subpackage News
 * @version $Revision: 1.19 $
 */
class NewsItem extends BHGObject {

  // {{{ properties

  var $id = 0;

  var $topic = 'Invalid Object';

  var $message = 'This News Item has not loaded correctly.';

  var $section = 0;

  var $poster = 0;

  var $timestamp = 0;

  // }}}
  // {{{ NewsItem()

  /**
   * Object Constructor for News Item
   *
   * This loads the details from the database and whatever.
   *
   * @access public
   * @param integer The ID number of the news post you wish to load
   * @param string  Coder Identification String
   * @uses BHGObject::Allowed()
   */
  function NewsItem($id, $coder = '') {

    BHGObject::BHGObject($coder);

    $sql = 'SELECT id, '
                 .'section, '
                 .'timestamp, '
                 .'poster, '
                 .'topic, '
                 .'message '
          .'FROM newsboard '
          .'WHERE id = '.$id;

    $newsdb = mysql_query($sql, $this->roster_db);

    if ($news = @mysql_fetch_array($newsdb)) {

      if (   $this->Allowed('allnews')
          || (   $this->Allowed('news')
              && $this->GetCoderID($this->roster_coder) == $news['section'])) {

        foreach ($news as $key => $value) {
          
          $this->$key = stripslashes($value);
        
        }

      } else {

        $this->roster_error = 'You do not have permission to load this news '
          .'item.';

        return false;

      }

    } else {

      $this->roster_error = 'There was an error while loading the news item '
        .'from the database.';

      return false;

    }

  }

  // }}}
  // {{{ GetID()

  function GetID() {

    return $this->id;

  }

  // }}}
  // {{{ GetTitle()

  function GetTitle() {

    return $this->topic;

  }

  // }}}
  // {{{ GetMessage()

  function GetMessage() {

    return $this->message;

  }

  // }}}
  // {{{ GetSectionID()

  function GetSectionID() {

    return $this->section;

  }

  // }}}
  // {{{ GetSectionName()

  /**
   * Return the Name of the Section this item is in
   *
   * @access public
   * @return string
   * @uses BHGObject::GetCoderName()
   */
  function GetSectionName() {

    return $this->GetCoderName($this->section);

  }

  // }}}
  // {{{ GetPoster()

  /**
   * Return the Person Object of the Person that posted this item
   * 
   * @access public
   * @return object Person
   * @uses Person
   */
  function GetPoster() {

    return new Person($this->poster, $this->roster_coder);

  }

  // }}}
  // {{{ GetTimestamp()

  function GetTimestamp() {

    return $this->timestamp;

  }

  // }}}
  // {{{ SetTitle()

  /**
   * Set the Title of the News Item
   *
   * @access public
   * @param string The new title
   * @return boolean
   * @see GetTitle()
   * @uses BHGObject::Allowed()
   * @uses BHGObject::GetCoderID()
   */
  function SetTitle($title) {

    if ($this->id != 0
        && (   $this->Allowed('allnews')
            || (   $this->Allowed('news')
                && $this->section == $this->GetCoderID($this->roster_coder)))) {

      $sql = 'UPDATE newsboard '
            .'SET topic = \''.addslashes($title).'\' '
            .'WHERE id = '.$this->id;

      if (mysql_query($sql, $this->roster_db)) {

        return true;

      } else {

        $this->roster_error = 'Could not save new title.';

        return false;

      }

    } else {

      $this->roster_error = 'This news item did not load properly.';

      return false;

    }

  }

  // }}}
  // {{{ SetMessage()

  /**
   * Set the message body of this news post
   *
   * @access public
   * @param string The new Message
   * @return boolean
   * @see GetMessage()
   * @uses BHGObject::Allowed()
   * @uses BHGObject::GetCoderID()
   */
  function SetMessage($message) {

    if ($this->id != 0
        && (   $this->Allowed('allnews')
            || (   $this->Allowed('news')
                && $this->section == $this->GetCoderID($this->roster_coder)))) {

      $sql = 'UPDATE newsboard '
            .'SET message = \''.addslashes($message).'\' '
            .'WHERE id = '.$this->id;

      if (mysql_query($sql, $this->roster_db)) {

        return true;

      } else {

        $this->roster_error = 'Could not save new message.';

        return false;

      }

    } else {

      $this->roster_error = 'This news item did not load properly.';

      return false;

    }

  }

  // }}}
  // {{{ SetSection()

  /**
   * Set the section the news post appears under
   *
   * @access public
   * @param integer The new secion's ID number
   * @return boolean
   * @see GetSectionID(), GetSectionName()
   * @uses BHGObject::Allowed()
   */
  function SetSection($section) {

    if (   $this->id != 0
        && $this->Allowed('allnews')) {

      $sql = 'UPDATE newsboard '
            .'SET section = '.$section.' '
            .'WHERE id = '.$this->id;

      if (mysql_query($sql, $this->roster_db)) {

        return true;

      } else {

        $this->roster_error = 'Could not save new section.';

        return false;

      }

    } else {

      $this->roster_error = 'You do not have permission to use this function.';

      return false;

    }

  }

  // }}}
  // {{{ Render()

  /**
   * Render this news post
   *
   * Render this news post according to the template contained within the 
   * string $template. The renderer supports the follow substitution tags:
   *
   *<pre>
   *  %id%                      - The news post's ID number
   *  %topic%                   - The Topic/Title of the news post
   *  %message%                 - The Main Body of the news post
   *  %date%                    - The date the news post was created format 
   *                              according to $date_format
   *  %poster_id%               - The ID Number of the Poster
   *  %poster_name%             - The Name of the Poster
   *  %poster_email%            - The email address of the poster
   *  %poster_idline%           - The Full ID Line of the poster
   *  %poster_division_id%      - The id number of the division of the poster
   *  %poster_division_name%    - The name of the division of the poster
   *  %poster_position_id%      - The id number of the position of the poster
   *  %poster_position_name%    - The name of the postition of the poster
   *  %poster_position_abbrev%  - The abbreviation of the postition of poster
   *  %poster_rank_id%          - The id number of the rank of the poster
   *  %poster_rank_name%        - The name of the rank of the poster
   *  %poster_rank_abbrev%      - The abbreviation of the rank of the poster
   *  %section_id%              - The id number of the section this post is in
   *  %section_name%            - The name of the section this post is in
   *</pre>
   *
   * @access public
   * @param string The actual template
   * @param string The format to be used in the date() call
   * @return string The rendered news post
   * @uses GetID()
   * @uses GetTitle()
   * @uses GetMessage()
   * @uses GetTimestamp()
   * @uses GetSectionID()
   * @uses GetSectionName()
   * @uses Person
   * @uses Person::GetID()
   * @uses Person::GetName()
   * @uses Person::GetEmail()
   * @uses Person::IDLine()
   * @uses Division
   * @uses Division::GetID()
   * @uses Division::GetName()
   * @uses Position
   * @uses Position::GetID()
   * @uses Position::GetName()
   * @uses Position::GetAbbrev()
   * @uses Rank
   * @uses Rank::GetID()
   * @uses Rank::GetName()
   * @uses Rank::GetAbbrev()
   * @uses ParseEmailTemplate()
   */
  function Render($template, $date_format = "F jS Y, g:iA T") {

    $poster = $this->GetPoster();
    $division = $poster->GetDivision();
    $position = $poster->GetPosition();
    $rank = $poster->GetRank();

    $replace = array(
        '%id%'      => $this->GetID(),
        '%topic%'   => $this->GetTitle(),
        '%message%' => nl2br($this->GetMessage()),
        '%date%'    => date($date_format, $this->GetTimestamp()),

        '%poster_id%'     => $poster->GetID(),
        '%poster_name%'   => $poster->GetName(),
        '%poster_email%'  => $poster->GetEmail(),
        '%poster_idline%' => $poster->IDLine(),

        '%poster_division_id%'    => $division->GetID(),
        '%poster_division_name%'  => $division->GetName(),
        
        '%poster_position_id%'      => $position->GetID(),
        '%poster_position_name%'    => $position->GetName(),
        '%poster_position_abbrev%'  => $position->GetAbbrev(),

        '%poster_rank_id%'      => $rank->GetID(),
        '%poster_rank_name%'    => $rank->GetName(),
        '%poster_rank_abbrev%'  => $rank->GetAbbrev(),

        '%section_id%'    => $this->GetSectionID(),
        '%section_name%'  => $this->GetSectionName()
      );

    $output = ParseEmailTemplate($template, $replace);

    return $output;

  }

  // }}}
  // {{{ Delete()

  /**
   * Delete this news item
   *
   * Delete this news item from the database. Once it is deleted it is 
   * completely gone and can not be restored. After calling this function the
   * object should be unset() as it is now useless.
   *
   * @access public
   * @return boolean
   * @uses BHGObject::Allowed()
   * @uses BHGObject::GetCoderID()
   */
  function Delete() {

    if ($this->id != 0
        && (   $this->Allowed('allnews')
            || (   $this->Allowed('news')
                && $this->section == $this->GetCoderID($this->roster_coder)))) {
    
      $sql = 'DELETE FROM newsboard WHERE id = '.$this->id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->id = 0;

        $this->topic = 'This news item has been deleted.';

        $this->message = 'This news item has been deleted. You should unset '
          .'the object.';

        $this->section = 0;

        return true;

      } else {

        $this->roster_error = 'There was an error while deleting the news '
          .'item.';

        return false;

      }

    } else {

      $this->roster_error = 'You do not have permission to call this function '
        .'on this news item.';

      return false;

    }

  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

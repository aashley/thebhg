<?php
/**
 * This file contains objects required for the Core Roster Functionality
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.15 $
 * @package Roster
 * @subpackage Roster
 */

/**
 * BioData - The Biographical Data for a person
 *
 * This object handles the interfacing with all the information that goes on 
 * the IPKC and the character sheet.
 *
 * <pre>
 *  20030317  aa  documentation fixes.
 *  20021105  aa  file started and completed.
 * </pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @package Roster
 * @subpackage Roster
 * @access public
 * @version $Revision: 1.15 $
 *
 */
class BioData extends BHGObject {

  // {{{ properties

  /**
   * ID Number
   * 
   * The biographical data's record/id number
   *
   * @access protected
   * @var integer $biodata_id
   * @see GetID()
   */
  var $biodata_id = 0;

  /**
   * Person's ID Number
   *
   * The ID number of the person that this data relates to
   *
   * @access protected
   * @var integer $biodata_person
   * @see GetPerson()
   */
  var $biodata_person = 0;

  /**
   * Homeworld
   *
   * @access protected
   * @var string $biodata_homeworld
   * @see GetHomeworld()
   * @see SetHomeworld()
   */
  var $biodata_homeworld = '';

  /**
   * Age
   * 
   * @access protected
   * @var integer $biodata_age
   * @see GetAge()
   * @see SetAge()
   */
  var $biodata_age = '';

  /**
   * Species
   * 
   * @access protected
   * @var string $biodata_species
   * @see GetSpecies()
   * @see SetSpecies()
   */
  var $biodata_species = '';

  /**
   * Height
   *
   * @access protected
   * @var string $biodata_height
   * @see GetHeight()
   * @see SetHeight()
   */
  var $biodata_height = '';

  /**
   * Sex
   * 
   * @access protected
   * @var string $biodata_sex
   * @see GetSex()
   * @see SetSex()
   */
  var $biodata_sex = '';

  /**
   * Image URL
   * 
   * The URL for the image of a person/face
   *
   * @access protected
   * @var string $biodata_image_url
   * @see GetImageURL()
   * @see SetImageURL()
   */
  var $biodate_image_url = '';

  // }}}
  // {{{ BioData()

  /**
   * Object Contructor
   *
   * Calls the constructor of the Parent object and loads the data
   *
   * @access public
   * @param integer ID Number of the Person to get data for
   * @param string  Coder Identification String
   */
  function BioData($id, $coder = '') {
    BHGObject::BHGObject($coder);

    $sql = "SELECT id, "
                 ."person, "
                 ."homeworld, "
                 ."age, "
                 ."species, "
                 ."height, "
                 ."sex, "
                 ."image_url "
          ."FROM roster_biographical_data "
          ."WHERE person = ".$id." ";

    $datadb = mysql_query($sql, $this->roster_db);

    if (@mysql_num_rows($datadb) == 0) {

      // They have no bio data, lets create them a record

      $sql = "INSERT INTO roster_biographical_data (person, "
                                                  ."homeworld, "
                                                  ."age, "
                                                  ."species, "
                                                  ."height, "
                                                  ."sex, "
                                                  ."image_url) "
            ."VALUES (".$id.", "
                    ."'', "
                    ."0, "
                    ."'', "
                    ."'', "
                    ."'', "
                    ."'')";

      if (mysql_query($sql, $this->roster_db)) {

        $this->biodata_id = mysql_insert_id();

        $this->biodata_person = $id;
      
      } else {

        $this->roster_error = 'Could not create new bio data record.';

        return false;

      }

    } elseif ($data = @mysql_fetch_array($datadb)) {

      // We have data so load it into the variables
      $this->biodata_id = $data['id'];
      $this->biodata_person = $data['person'];
      $this->biodata_homeworld = $data['homeworld'];
      $this->biodata_age = $data['age'];
      $this->biodata_species = $data['species'];
      $this->biodata_height = $data['height'];
      $this->biodata_sex = $data['sex'];
      $this->biodata_image_url = $data['image_url'];

    } else {

      // Error

      $this->roster_error = 'Could not load bio data.';

      return false;

    }

  }

  // }}}
  // {{{ GetID()

  /**
   * Get Biodata ID Number
   * 
   * @access public
   * @return integer 
   * @see $biodata_id
   */
  function GetID() {

    return $this->biodata_id;

  }

  // }}}
  // {{{ GetPerson()

  /**
   * Get Person
   * 
   * Get the person this data relates to
   *
   * @access public
   * @return object Person
   * @see $biodata_person
   * @uses Person
   */
  function GetPerson() {

    return new Person($this->biodata_person, $this->roster_coder);

  }

  /// }}}
  // {{{ GetHomeworld()

  /**
   * Get Homeworld
   * 
   * @access public
   * @return string 
   * @see $biodata_homeworld
   */
  function GetHomeworld() {

    return StripSlashes($this->biodata_homeworld);

  }

  // }}}
  // {{{ GetAge()

  /**
   * Get Age
   *
   * @access public
   * @return integer
   * @see $biodata_age
   */
  function GetAge() {

    return $this->biodata_age;

  }

  // }}}
  // {{{ GetSpecies()

  /**
   * Get Species
   *
   * @access public
   * @return string
   * @see $biodata_species
   */
  function GetSpecies() {

    return stripslashes($this->biodata_species);

  }

  // }}}
  // {{{ GetHeight()

  /**
   * Get Height
   * 
   * @access public
   * @return string 
   * @see $biodata_height
   */
  function GetHeight() {

    return stripslashes($this->biodata_height);

  }

  // }}}
  // {{{ GetSex()

  /**
   * Get Sex
   *
   * @access public
   * @return string
   * @see $biodata_height
   */
  function GetSex() {

    return stripslashes($this->biodata_sex);

  }

  // }}}
  // {{{ GetImageURL()

  /**
   * Get Image URL
   *
   * @access public
   * @return string
   * @see $biodata_image_url
   */
  function GetImageURL() {

    return stripslashes($this->biodata_image_url);

  }

  // }}}
  // {{{ SetHomeworld()

  /**
   * Set Homeworld
   *
   * @access public
   * @param string The new homeworld
   * @return boolean
   * @see $biodata_homeworld
   * @see GetHomeworld()
   * @uses BHGObject::Allowed()
   */
  function SetHomeworld($homeworld) {

    if ($this->Allowed('god')) {

      $sql = "UPDATE roster_biographical_data "
            ."SET homeworld = '".addslashes($homeworld)."' "
            ."WHERE id = ".$this->biodata_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->biodata_homeworld = $homeworld;

        return true;

      } else {

        $this->roster_error = 'There was an error while saving the new '
          .'homeworld.';

        return false;

      }

    } else {

      $this->roster_error = 'The coder who create this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}
  // {{{ SetAge()

  /**
   * Set Age
   *
   * @access public
   * @param string The new Age
   * @return boolean
   * @see $biodata_age
   * @see GetAge()
   * @uses BHGObject::Allowed()
   */
  function SetAge($age) {

    if ($this->Allowed('god')) {

      if (!is_numeric($age)) {

        $this->roster_error = 'Age must be a number.';

        return false;

      }

      $sql = "UPDATE roster_biographical_data "
            ."SET age = ".$age." "
            ."WHERE id = ".$this->biodata_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->biodata_age = $age;

        return true;

      } else {

        $this->roster_error = 'There was an error while saving the new '
          .'age.';

        return false;

      }

    } else {

      $this->roster_error = 'The coder who create this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}
  // {{{ SetSpecies()

  /**
   * Set Species
   *
   * @access public
   * @param string The new species name
   * @return boolean
   * @see $biodata_species
   * @see GetSpecies()
   * @uses BHGObject::Allowed()
   */
  function SetSpecies($species) {

    if ($this->Allowed('god')) {

      $sql = "UPDATE roster_biographical_data "
            ."SET species = '".addslashes($species)."' "
            ."WHERE id = ".$this->biodata_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->biodata_species = $species;

        return true;

      } else {

        $this->roster_error = 'There was an error while saving the new '
          .'species.';

        return false;

      }

    } else {

      $this->roster_error = 'The coder who create this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}
  // {{{ SetHeight()

  /**
   * Set Height
   *
   * @access public
   * @param string New Height
   * @return boolean
   * @see $biodata_height
   * @see GetHeight()
   * @uses BHGObject::Allowed()
   */
  function SetHeight($height) {

    if ($this->Allowed('god')) {

      $sql = "UPDATE roster_biographical_data "
            ."SET height = '".addslashes($height)."' "
            ."WHERE id = ".$this->biodata_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->biodata_height = $height;

        return true;

      } else {

        $this->roster_error = 'There was an error while saving the new '
          .'height.';

        return false;

      }

    } else {

      $this->roster_error = 'The coder who create this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}
  // {{{ SetSex()

  /**
   * Set Sex
   *
   * @access public
   * @param string The new sex of the person, not whether you want some.
   * @return boolean
   * @see $biodata_sex
   * @see GetSex()
   * @uses BHGObject::Allowed()
   */
  function SetSex($sex) {

    if ($this->Allowed('god')) {

      $sql = "UPDATE roster_biographical_data "
            ."SET sex = '".addslashes($sex)."' "
            ."WHERE id = ".$this->biodata_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->biodata_sex = $sex;

        return true;

      } else {

        $this->roster_error = 'There was an error while saving the new '
          .'sex.';

        return false;

      }

    } else {

      $this->roster_error = 'The coder who create this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}
  // {{{ SetImageURL()

  /**
   * Set Image URL
   *
   * @access public
   * @param string The new image URL
   * @return boolean
   * @see $biodata_image_url
   * @see GetImageURL()
   * @uses BHGObject::Allowed()
   */
  function SetImageURL($image_url) {

    if ($this->Allowed('god')) {

      $sql = "UPDATE roster_biographical_data "
            ."SET image_url = '".addslashes($image_url)."' "
            ."WHERE id = ".$this->biodata_id;

      if (mysql_query($sql, $this->roster_db)) {

        $this->biodata_image_url = $image_url;

        return true;

      } else {

        $this->roster_error = 'There was an error while saving the new '
          .'image_url.';

        return false;

      }

    } else {

      $this->roster_error = 'The coder who create this object does not have '
        .'permission to call this function.';

      return false;

    }

  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

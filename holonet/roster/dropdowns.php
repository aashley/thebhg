<?php
/*-----------------------------------------------------------------------------*
 * Roster Dropdown Lists
 *-----------------------------------------------------------------------------*
 * Author: Adam Ashley
 * Start Date: 01/08/2002
 * Description: These are a collection of functions that provide drop down lists
 *              which are commonly used through-out the roster. They are placed
 *              here as they may be useful in other parts of the code.
 * $Id: dropdowns.php,v 1.1 2002/12/15 14:48:26 adam Exp $
 *-----------------------------------------------------------------------------*
 *
 *  20020801  aa  started file
 *
 *----------------------------------------------------------------------------*/


/*
 * DivisionDropDown
 *
 * This function provides a drop down list of Divisions
 *
 * frmName:     This is the name of the form element
 * size:        This is the number of rows of the SELECT element
 * multiple:    Whether multiple items can be selected
 * membercount: whether to display the member count in each row
 * type:        The type of list to display.
 *                0 - Display all Active Divisions
 *                1 - Display all Active Kabals
 *                2 - Display all Divisions Including Disavowed and Deleted 
 *                    Kabals
 *                3 - Display all Kabals including Deleted ones
 *                4 - Display all Active Wings
 *                5 - Display all Wings including Deleted ones
 * default:     By default have this division highlighted
 */
function DivisionDropDown($frmName = "frmDivision",
                          $size = 1,
                          $multiple = 0,
                          $membercount = 1,
                          $type = 0,
                          $division = 0,
                          $hidedisavowed = 0,
                          $extras = array()) {

  $output = "<SELECT SIZE=\"".$size."\" NAME=\"".$frmName
    .(($multiple) ? "[]\" MULTIPLE" : "\"" )
    .">\n";

  $roster = new Roster();

  $categories = $roster->GetDivisionCategories();

  if (sizeof($extras) > 0) {

    foreach ($extras as $text => $value) {

      $output .= "<OPTION VALUE=\"".$value."\""
        .(($division == $value) ? " SELECTED" : "")
        .">".$text."</OPTION>\n";

    }

  }

  foreach ($categories as $category) {

    if (   $type == 0
        || $type == 2
        || ($type == 1 && $category->HasKabals())
        || ($type == 3 && $category->HasKabals())
        || ($type == 4 && $category->HasWings())
        || ($type == 5 && $category->HasWings())) {
      
      $output .= "<OPTGROUP LABEL=\"".$category->GetName()."\">\n";
      
      $divisions = $category->GetDivisions();

      foreach ($divisions as $div) {

        if (   ($type == 0 && $div->IsActive())
            || ($type == 2 && $div->IsActive() && $div->IsKabal())
            || ($type == 4 && $div->IsActive() && $div->IsWing())
            || ($type == 1)
            || ($type == 3 && $div->IsKabal())
            || ($type == 5 && $div->IsWing())) {

          if (   $hidedisavowed == 0
              || (   $hidedisavowed == 1 
                  && $div->GetID() != 16)) {

            $output .= "<OPTION VALUE=\"".$div->GetID()."\""
              .(($division == $div->GetID()) ? " SELECTED" : "")
              .">".$div->GetName()
              .(($membercount) ? " (".$div->GetMemberCount()." members)" : "")
              ."</OPTION>\n";

          }

        }

      }

      $output .= "</OPTGROUP>\n";

    }

  }

  $output .= "</SELECT>\n";

  return $output;

}


/*
 * PersonDropDown
 *
 * A Drop down list of people
 *
 * frmName:     The name of the form element
 * size:        number of rows in the select
 * multiple:    whether can select multiple items
 * division:    only include people from this division
 * active:      only include active people
 * sortorder:   the order in which items are displayed in the dropdown
 *                  0 - Alphabetical by name
 *                  1 - By Rank, Highest ranked first
 * person:      by default have this person selected
 */
function PersonDropDown($frmName = "frmPerson",
                        $size = 1,
                        $multiple = 0,
                        $division = 0,
                        $active = 1,
                        $sortorder = 0,
                        $includeblank = 0,
                        $person = 0) {

  $output = "<SELECT SIZE=\"".$size."\" NAME=\"".$frmName
    .(($multiple) ? "[]\" MULTIPLE" : "\"" )
    .">\n";

  if ($includeblank) {

    $output .= "<OPTION VALUE=\"0\""
      .(($person == 0) ? " SELECTED" : "")
      .">No One</OPTION>\n";

  }

  $sql = "SELECT roster_roster.id "
        ."FROM thebhg_roster.roster_roster, "
             ."thebhg_roster.roster_position, "
             ."thebhg_roster.roster_rank "
        ."WHERE roster_roster.rank = roster_rank.id "
          ."AND roster_roster.position = roster_position.id ";

  if ($division == 0) {

    if ($active == 1) {

      $sql .= "AND roster_roster.division != 16 "
             ."AND roster_roster.division != 12 "
             ."AND roster_roster.division != 11 ";

    }

  } else {

    $sql .= "AND roster_roster.division = ".$division." ";

  }

  $sql .= "AND roster_roster.division != 0 ";

  if ($sortorder == 1) {

    $sql .= "ORDER BY roster_rank.order ASC, "
                    ."roster_roster.rankcredits DESC, "
                    ."roster_roster.name ASC";

  } else {

    $sql .= "ORDER BY roster_roster.name ASC";

  }

  $hunters = mysql_query($sql);

  while ($hunter = mysql_fetch_array($hunters)) {

    $p = new Person($hunter['id']);

    $output .= "<OPTION VALUE=\"".$p->GetID()."\""
      .(($person > 0) ? " SELECTED" : "")
      .">".$p->GetName()."</OPTION>\n";

  }

  $output .= "</SELECT>\n";

  return $output;

}
                        

?>

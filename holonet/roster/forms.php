<?php

#------------------------------------------------------------------------------#
# PHP Conversion of Forms.pm v2.0.5
#
#  $Id: forms.php,v 1.1 2002/12/15 14:48:26 adam Exp $
#------------------------------------------------------------------------------#
#
# 20020104 aa	Cleaned up handling for use under stricter PHP4.1 series
#		Made 'Number' limits handle floating point numbers aswell
# 20011217 aa	Better handling of line ends in form files
# 20011210 aa	Added PrintSubmitReset and PrintHidden
# 20011206 aa 	Completed to same level as Forms.pm v2.0.3
# 20011204 aa 	Done basic outpuy, damn i wish php had something like perl's CGI
#             	(well for outputing stuff anyway)
#
#------------------------------------------------------------------------------#



#------------------------------------------------------------------------------#
# Module level constants
#------------------------------------------------------------------------------#

$mc_bTRUE = 1;
$mc_bFALSE = 0;

$mc_szFormsPath = dirname($_SERVER['SCRIPT_FILENAME']). '/forms';

#------------------------------------------------------------------------------#
# Module level variables
#------------------------------------------------------------------------------#

$m_bOnlyOneHint = $mc_bTRUE;
$m_szHintsPrinted = 0;
$m_bFirstPageView = !(isset($_REQUEST['FirstPageView']) && $_REQUEST['FirstPageView'] == 'False');

#------------------------------------------------------------------------------#
# SUBROUTINE : GenerateForm
# ARGUMENTS  : IN szDatabase AS STRING
# RETURNS    : False, if any of the fields were invalid.
#	             True, otherwise
#------------------------------------------------------------------------------#
function GenerateForm($szForm) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
  $szOneInvalid = $mc_bFALSE;
  $szValue = "";

  $Form = ReadForm($szForm);
  foreach ($Form as $field) {
    # Unless this is the first 'view' check for invalid data entry
    # and print appropriate message to guide the user in entering the
    # correct data
    if (!($m_bFirstPageView or ValidField($field))) {
      # Remember that one entry was invalid
      $szOneInvalid = $mc_bTRUE;

      # Only print hints for incorrect data entry not empty fields
      $szValue = $_REQUEST[$field['szName']];
      if(($szValue != "") && (isset($field["paszHints"]))) {
	if (sizeof($field['paszHints']) > 1) {
	  PrintHints($field['szLabel'], $field['paszHints']);
	} else {
	  PrintHint($field['paszHints'][0]);
	}
      }
    }

    if($field['szType'] == "input") {
      PrintInputRow($field['szName'],
		    $field['szLabel'],
		    $field['intSize'],
		    $field['intMax']);
    } elseif($field['szType'] == "popupmenu") {
      PrintSelectRow($field['szName'],
		     $field['szLabel'],
		     $field['szDefault'],
		     $field['paszOptions']);
    } elseif($field['szType'] == "radioset") {
      PrintRadioSet($field['szName'],
		    $field['szLabel'],
		    $field['szDefault'],
		    $field['paszOptions']);
    } elseif($field['szType'] == "checkboxset") {
      PrintCheckBoxSet($field['szName'],
		       $field['szLabel'],
		       $field['paszOptions'],
		       $field['paszChecked']);
    } elseif($field['szType'] == "text") {
      PrintTextArea($field['szName'],
		    $field['szLabel'],
 		    $field['intRows'],
		    $field['intCols']);
    } elseif($field['szType'] == "note") {
      print "<TR><TD COLSPAN=\"2\">".$field['szNote']."</TD></TR>\n";
    } elseif($field['szType'] == "hidden") {
      PrintHiddenInfo($field['szName']);
    } elseif($field['szType'] == "password") {
      PrintPasswordRow($field['szName'],
		       $field['szLabel'],
		       $field['intSize'],
		       $field['intMax']);
    }
  }

  # A Notice to tell the user that they have made a mistake
  if(!$m_bFirstPageView and $szOneInvalid) {
    print "<span CLASS=\"help\">Some fields are missing or have been incorrectly entered.</span>";
    PrintHiddenInfo("FirstPageView");
  } else {
    # Information to record the first page view
    PrintHidden("FirstPageView", "False");
  }

  return $szOneInvalid;
}

#------------------------------------------------------------------------------#
# SUBROUTINE : ValidForm
# ARGUMENTS  : IN szDatabase AS STRING 
#							 IN szPassword_Database AS STRING
# RETURNS    : TRUE, if required fields meet the criteria.
#	             FALSE, otherwise
#------------------------------------------------------------------------------#
function ValidForm($szForm) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
  # Check every field for validity, return as soon as one is found to
  # be invalid
  $Form = ReadForm($szForm);
  foreach ($Form as $field) {
    if (!ValidField($field)) {
      return $mc_bFALSE;
    }
  }

  # At this point every field has been checked, and they have all
  # passed the validity test
  return $mc_bTRUE;
}

#------------------------------------------------------------------------------#
# SUBROUTINE : ValidField
# ARGUMENTS  : $field AS HASH REFERENCE
# RETURNS		 : True if the field passes the validation test(s), false otherwise
#------------------------------------------------------------------------------#
function ValidField($field) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
  if (isset($_REQUEST[$field['szName']])) {
    $szValue = $_REQUEST[$field['szName']];
  } else {
    $szValue = '';
  }

  # If the field is not required, an empty field is
  # considered valid
  if($field['bRequired'] == $mc_bFALSE && $szValue == "") {
    return $mc_bTRUE;
  }

  # If a minimum length has been specified
  # check if the field is shorter than the minimum length
  if(isset($field['intMin']) && $field['intMin'] > 0 && strlen($szValue) < $field['intMin']) {
    return $mc_bFALSE;
  }

  # If a maximum length has been specified
  # check if the field is longer than the maximum length
  if(isset($field['intMax']) && $field['intMax'] > 0 && strlen($szValue) > $field['intMax']) { 
    return $mc_bFALSE;
  }

  # If a custom Domain has been specified, check the field against it
  if(isset($field['regDomain'])) { 
    if (!preg_match($field['regDomain'], $szValue)) {
      return $mc_bFALSE;
    }
    return $mc_bTRUE;
  }

  if(isset($field['szValidationType'])) {
    # Check the field with the appropriate validation type
    if($field['szValidationType'] == "name") {
      if (!preg_match("/^[^\t\n\f\d!@#$%^\*\(\)]*$/", $szValue)) {
        return $mc_bFALSE;
      }
    } elseif($field['szValidationType'] == "zipcode") {
      if (!preg_match("/^[a-z\d ]+$/i", $szValue)) {
        return $mc_bFALSE;
      }
    } elseif($field['szValidationType'] == "number") {
      if (!preg_match("/^[\d.]+$/", $szValue)) {
        return $mc_bFALSE;
      }
    } elseif($field['szValidationType'] == "companyname") {
      if (!preg_match("/^[\w\d]+[\.]?([\- ']?[\w\d]+[\.]?)*$/", $szValue)) {
        return $mc_bFALSE;
      }
    } elseif($field['szValidationType'] == "emailaddress") {
      if (!preg_match("/^[a-zA-Z][\w\d]*([\.\-_]?[\w\d]+)*@([\w\d\-]+[\.])+[\w\d\-]+$/", $szValue)) {
        return $mc_bFALSE;
      }
    } elseif($field['szValidationType'] == "postaladdress") {
      if (!preg_match("/^[\w\.]*\s*(((\d+\w?)|(\w+))\s*)+$/m", $szValue)) {
        return $mc_bFALSE;
      }
    } elseif($field['szValidationType'] == "text") {
      if (!preg_match("/^(\S+\s*)+$/m", $szValue)) {
        if (!preg_match("/\b/", $szValue)) {
          return $mc_bFALSE;
        }
      }
    } elseif($field['szValidationType'] == "phonenumber") {
      if (!preg_match("/^[+]?\d+([ ]*([(]\d+[)]|[-]?\d+|\d+[-]?))*$/")) {
        return $mc_bFALSE;
      }
    } elseif($field['szValidationType'] == "login") {
      if (!preg_match("/^[a-z][\w\d\-_]+?$/i", $szValue)) {
        return $mc_bFALSE;
      }
    } 
  }
  return $mc_bTRUE;
}


#------------------------------------------------------------------------------#
# SUBROUTINE : PrintHints
# ARGUMNENTS : szLabel AS STRING
#	       			 szHint AS STRING
# RETURNS    : Nothing
#------------------------------------------------------------------------------#
function PrintHints($szLabel, &$szHints) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
	# if the option OnlyOneHint is enabled only print one hint
  if ($m_bOnlyOneHint and $m_szHintsPrinted > 0) {
      return;
  }

	# Remember how many hints were printed incase OnlyOneHint is
	# enabled
  $m_szHintsPrinted++;
	print "<TR><TD COLSPAN=\"2\"><span CLASS=\"help\">Please make sure that the $szLabel<UL CLASS=\"help\">";
	foreach ($szHints as $szHint) {
	  print "<LI CLASS=\"help\">$szHint</LI>";
	}
	print "</UL></span></TD></TR>\n";
}

#------------------------------------------------------------------------------#
# SUBROUTINE : PrintElement
# ARGUMENTS  : szValue AS STRING
# RETURNS    : Nothing
#------------------------------------------------------------------------------#
function PrintElement($szValue) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
	print "<TR><TD COLSPAN=\"2\">$szValue</TD></TR>\n";
}

#------------------------------------------------------------------------------#
# SUBROUTINE : PrintHint
# ARGUMNENTS : szLabel AS STRING
#	             szHint AS STRING
# RETURNS    : Nothing
#------------------------------------------------------------------------------#
function PrintHint($szHint) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;

	# if the option OnlyOneHint is enabled only print one hint
  if ($m_bOnlyOneHint and $m_szHintsPrinted > 0) {
      return;
  }

	# Remember how many hints were printed incase OnlyOneHint is
	# enabled
  $m_szHintsPrinted++;
	print "<TR><TD COLSPAN=\"2\"><span CLASS=\"help\">$szHint</span></TD></TR>\n";
}

#------------------------------------------------------------------------------#
# SUBROUTINE : PrintTextArea
# ARGUMENTS  : szName AS STRING
#	             szLabel AS STRING
#	             intRows AS INTEGER
#	             intCols AS INTEGER
# RETURNS    : Nothing 
#------------------------------------------------------------------------------#
function PrintTextArea($szName, $szLabel, $intRows, $intCols) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, 
         $m_szHintsPrinted, $m_bFirstPageView;

  if (isset($_REQUEST[$szName])) {
    $szValue = $_REQUEST[$szName];
  } else {
    $szValue = "";
  }
  
	print "<TR><TD ALIGN=\"top\">$szLabel</TD>"
	     ."<TD ALIGN=\"top\"><TEXTAREA NAME=\"$szName\" ROWS=\"$intRows\" COLS=\"$intCols\">"
	     ."$szValue</TEXTAREA></TD></TR>";
	
	
}

#------------------------------------------------------------------------------#
# SUBROUTINE : PrintHiddenInfo
# ARGUMENTS  : szName AS STRING
# RETURNS    : Nothing 
#------------------------------------------------------------------------------#
function PrintHiddenInfo($szName) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
  if (isset($_REQUEST[$szName])) {
    $szValue = $_REQUEST[$szName];
  } else {
    $szValue = "";
  }

	# Prints a hidden field and stores its value
	print "<INPUT TYPE=\"hidden\" NAME=\"$szName\" VALUE=\"$szValue\">";
}


#------------------------------------------------------------------------------#
# SUBROUTINE : PrintHidden
# ARGUMENTS  : szName AS STRING
#              szValue AS STRING
# RETURNS    : Nothing 
#------------------------------------------------------------------------------#
function PrintHidden($szName, $szValue) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;

	# Prints a hidden field and stores its value
	print "<INPUT TYPE=\"hidden\" NAME=\"$szName\" VALUE=\"$szValue\">";
}


#------------------------------------------------------------------------------#
# SUBROUTINE : PrintHiddenGroup
# ARGUMENTS  : aFields AS ARRAY
# RETURNS    : Nothing 
# Prints A Collection of hidden fields
#------------------------------------------------------------------------------#
function PrintHiddenGroup($aFields) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;

  foreach ($aFields as $szName => $szValue) {
  	# Prints a hidden field and stores its value
	  print "<INPUT TYPE=\"hidden\" NAME=\"$szName\" VALUE=\"$szValue\">";
  }
}


#------------------------------------------------------------------------------#
# SUBROUTINE : PrintSelectRow
# ARGUMENTS  : szName AS STRING
#	       szLabel AS STRING
#	       szDefault AS STRING
#	       szOptions AS Array of STRING
# RETURNS    : Nothing 
#------------------------------------------------------------------------------#
function PrintSelectRow($szName, $szLabel, $szDefault, &$szOptions) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
  if (isset($_REQUEST[$szName])) {
    $szValue = $_REQUEST[$szName];
  } else {
    $szValue = "";
  }
  
	# Prints a 'popup_menu' or 'Select box' with each item
	# description an item in the array @szOptions
	print "<TR><TD>$szLabel</TD>"
	     ."<TD><SELECT NAME=\"$szName\" SIZE=\"1\">";
	foreach ($szOptions as $option) {
	  if ($m_bFirstPageView) {
            print "<OPTION VALUE=\"$option\"".(($option == $szDefault) ? " selected" : "").">$option</OPTION>";
	  } else {
            print "<OPTION VALUE=\"$option\"".(($option == $szValue) ? " selected" : "").">$option</OPTION>";
	  }
	}
	print "</SELECT></TD></TR>";
}

#------------------------------------------------------------------------------#
# SUBROUTINE : PrintCheckBoxSet
# ARGUMENTS  : szName AS STRING,
#              szLabel AS STRING,
#              paszOptions AS POINTER TO ARRAY OF STRING,
#              paszChecked AS POINTER TO ARRAY OF STRING
# RETURNS    : Nothing 
#------------------------------------------------------------------------------#
function PrintCheckBoxSet($szName, $szLabel, $paszOptions, $paszChecked) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
  if (isset($_REQUEST[$szName])) {
    $aszValues = $_REQUEST[$szName];
  }

  print "<TR><TD COLSPAN=\"2\">$szLabel</TD></TR>\n";
  if ( isset($aszValues) && is_array($aszValues) ) {
    print "<TR><TD COLSPAN=\"2\">";
    foreach ($paszOptions as $option) { # ($i = 0; $i < sizeof($paszOptions); $i++) {
      print "<INPUT TYPE=\"checkbox\" NAME=\"".$szName."[]\" VALUE=\"".$option."\"";
      foreach ($aszValues as $value) {
        if ($value == $option) {
	  print " checked";
	}
      }
      print ">$option<BR>";
    }
    print "</TD></TR>\n";
  } else {
    print "<TR><TD COLSPAN=\"2\">";
    foreach ($paszOptions as $option) { # ($i = 0; $i < sizeof($paszOptions); $i++) {
      print "<INPUT TYPE=\"checkbox\" NAME=\"".$szName."[]\" VALUE=\"".$option."\"";
      if (is_array($paszChecked)) {
        foreach ($paszChecked as $value) {
          if ($value == $option) {
    	    print " checked";
 	  }
        }
      }
      print ">$option<BR>";
    }
    print "</TD></TR>\n";
  }
}

#------------------------------------------------------------------------------#
# SUBROUTINE : PrintRadioSet
# ARGUMENTS  : szName AS STRING
#	             szLabel AS STRING
#	             szOptions AS STRING
# RETURNS    : Nothing 
#------------------------------------------------------------------------------#
function PrintRadioSet($szName, $szLabel, $szDefault, $paszOptions) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
  if (isset($_REQUEST[$szName])) {
    $szValue = $_REQUEST[$szName];
  } else {
    $szValue = "";
  }
  
  print "<TR><TD COLSPAN=\"2\">$szLabel</TD></TR>\n";
  if($m_bFirstPageView || $szValue != "") {
    print "<TR><TD COLSPAN=\"2\">";
    foreach ($paszOptions as $option) {
      print "<INPUT TYPE=\"radio\" NAME=\"$szName\" VALUE=\"$option\"".(($option == $szDefault)? " checked" : "").">$option<br>\n";
    }
    print "</TD></TR>\n";
  } else {
    print "<TR><TD COLSPAN=\"2\">";
    foreach ($paszOptions as $option) {
      print "<INPUT TYPE=\"radio\" NAME=\"$szName\" VALUE=\"$option\"".(($option == $szValue)? " checked" : "").">$option<br>\n";
    }
    print "</TD></TR>\n";
  }
}


#------------------------------------------------------------------------------#
# SUBROUTINE : PrintPasswordRow
# ARGUMENTS  : szName AS STRING
#	             szLabel AS STRING
# RETURNS    : Nothing 
#------------------------------------------------------------------------------#
function PrintPasswordRow($szName, $szLabel, $szSize, $szMax) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
  if (isset($_REQUEST[$szName])) {
    $szValue = $_REQUEST[$szName];
  } else {
    $szValue = "";
  }

  print "<TR><TD>$szLabel</TD>"
       ."<TD><INPUT TYPE=\"password\" NAME=\"$szName\" SIZE=\"$szSize\" VALUE=\"$szValue\" MAXLENGTH=\"$szMax\"></TD></TR>";
       
}


#------------------------------------------------------------------------------#
# SUBROUTINE : PrintInputRow
# ARGUMENTS  : 
#	       szName AS STRING
#	       szLabel AS STRING
#	       szLength AS INTEGER
#------------------------------------------------------------------------------#
function PrintInputRow($szName, $szLabel, $szSize, $szMax) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
  if (isset($_REQUEST[$szName])) {
    $szValue = $_REQUEST[$szName];
  } else {
    $szValue = "";
  }

  print "<TR><TD>$szLabel</TD>"
       ."<TD><INPUT TYPE=\"text\" NAME=\"$szName\" SIZE=\"$szSize\" VALUE=\"$szValue\" MAXLENGTH=\"$szMax\"></TD></TR>";
       
}


#------------------------------------------------------------------------------#
# SUBROUTINE : PrintSubmitReset
# ARGUMENTS  : szSName AS STRING
#              szSLabel AS STRING
#              szRLabel AS STRING
# RETURNS    : Nothing
#------------------------------------------------------------------------------#
function PrintSubmitReset($szSName, $szSLabel, $szRLabel = "", $bAlign = 0) {
  switch ($bAlign) {
    case 1:
      $bAlign = "CENTER";
      break;

    case 2:
      $bAlign = "RIGHT";
      break;

    case 0:
    default:
      $bAlign = "LEFT";
      break;
  }
  
  print "<TR><TD COLSPAN=\"2\" ALIGN=\"$bAlign\"><INPUT TYPE=\"submit\" NAME=\"$szSName\" VALUE=\"$szSLabel\">";
  if ($szRLabel > "") {
    print "<INPUT TYPE=\"reset\" VALUE=\"$szRLabel\">";
  }
  print "</TD></TR>";
}


#------------------------------------------------------------------------------#
# SUBROUTINE : PrintFormOpen
# ARGUMENTS  : szAction AS STRING
#            : bMultipartForm AS BOOLEAN
# RETURNS    : Nothing
#------------------------------------------------------------------------------#
function PrintFormOpen($szAction, $bMultipartForm = 0) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
  # open the form and a table, table rows and columns are used
  # by other functions for formatting
  if ( isset($bMultipartForm) ) {
    if ( $bMultipartForm ) {
      print "<FORM METHOD=\"POST\" ACTION=\"$szAction\" ENCTYPE=\"multipart/form-data\">\n"
           ."<TABLE CELLPADDING=\"2\" CELLSPACING=\"2\" BORDER=\"0\">\n";
    } else {
      print "<FORM METHOD=\"POST\" ACTION=\"$szAction\">\n"
           ."<TABLE  CELLPADDING=\"2\" CELLSPACING=\"2\" BORDER=\"0\">\n";
    }
  } else {
      print "<FORM METHOD=\"POST\" ACTION=\"$szAction\">\n"
           ."<TABLE CELLPADDING=\"2\" CELLSPACING=\"2\" BORDER=\"0\">\n";
  }
  print "<INPUT TYPE=\"HIDDEN\" NAME=\"".session_name()."\" VALUE=\"".session_id()."\">";
}

#------------------------------------------------------------------------------#
# SUBROUTINE : PrintFormClose
# ARGUMENTS  : (none)
# RETURNS    : nothing
#------------------------------------------------------------------------------#
function PrintFormClose() {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
	print "</table></form>";
}


#------------------------------------------------------------------------------#
# SUBROUTINE : ReadForm
# ARGUMENTS  : IN szform AS STRING
# RETURNS		 : heterogenous array of structures describing fields in a form
#------------------------------------------------------------------------------#
function ReadForm ($szForm) {
  global $mc_bTRUE, $mc_bFALSE, $mc_szDatabasePath, $mc_szFormsPath, $m_bOnlyOneHint, $m_szHintsPrinted, $m_bFirstPageView;
  $Form = array();
  $structField = array();
  $name = "";
  $parameter = "";
  $input = "";

  $fp = fopen("$mc_szFormsPath/$szForm.form", 'r') or die("Can't optn $szForm for reading");
  while (!feof($fp)) {
    $input = fgets($fp, 4096);
    if (substr($input, -2) == "\r\n" || substr($input, -2) == "\n\r") {
      $input = substr($input, 0, -2);
    } else {
      $input = substr($input, 0, -1);
    }      
    if (preg_match("/^([a-z]+):\s*(.*)$/i", $input, $matches)) {
      $name = $matches[1];
      $parameter = $matches[2];
      $name = strtolower($name);
      if(preg_match("/input|text|hidden|note|password|radioset|checkboxset|popupmenu/", $name)) {
        unset($structField);

        # A new field has been declared, fill in some default values
	$structField = array();
	$structField['szType'] = strtolower($name); 
	$structField['szName'] = $parameter;
	$structField['intMin'] = 0;
	$structField['bRequired'] = $mc_bTRUE;
	$structField['szLabel'] = $structField['szName'] . ":";
	if ($structField['szType'] == "note") {
	  $structField['szNote'] = $parameter;
	}
	# Add this field to the form
	#array_push($Form, $structField);
	$Form[] = &$structField;

      } elseif ($name == "label") {
	if($structField['bRequired'] == $mc_bFALSE) {
	  $structField['szLabel'] = "*$parameter";
	} else {
	  $structField['szLabel'] = $parameter;
	}
      } elseif ($name == "options") {
	$structField['paszOptions'] = SplitParts($parameter);
      } elseif ($name == "checked") {
	$structField['paszChecked'] = SplitParts($parameter);
      } elseif ($name == "default") {
	$structField['szDefault'] = $parameter;
      } elseif ($name == "range") {
        preg_match("/([\d]+)-([\d]+)/", $parameter, $matches);
	$structField['intMin'] = $matches[1]; 
	$structField['intMax'] = $matches[2];
      } elseif (preg_match("/size/", $name)) {
	if(preg_match("/,/", $parameter)) {
	  preg_match("/([\d]+),\s*([\d]+)/i", $parameter, $matches);
	  $structField['intRows'] = $matches[1];
	  $structField['intCols'] = $matches[2];
	} else {
	   $structField['intSize'] = $parameter;
	}
      } elseif ($name == "domain") {
	if(preg_match("#(/.*/)#", $parameter, $matches)) {
	  $structField['regDomain'] = $matches[1];
	} else {
	  $structField['szValidationType'] = strtolower($parameter);
	}
      } elseif (preg_match("/hint(s)?/i", $name)) {
	$structField['paszHints'] = SplitParts($parameter);
      } elseif ($name == "required") {
	if(preg_match("/no|n|0|false|/i", $parameter)) {
	  $structField['bRequired'] = $mc_bFALSE;
	  $structField['szLabel'] = "*".$structField['szLabel'];
	} 
      }
    }
  }
  fclose($fp);
  return $Form;
}

function SplitParts($expression) {
	$Parts = array();
	$Parts = preg_split("/%%/", $expression);
	return $Parts;
}
#

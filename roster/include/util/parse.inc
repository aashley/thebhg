<?php
/**
 * Parsing Functions for the roster
 *
 * <pre>
 *  20030408  aa  Documentation Fixes
 *  20030317  aa  documentation fixes.
 *  20020531  aa  created ParseEmailTemplate
 * </pre>
 *
 * @package Roster
 * @subpackage Utilities
 * @access private
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.13 $
 */

// {{{ ParseEmailTemplate()

/**
 * Parse an email template replacing variable strings
 *
 * Parse a provided message and replaces the required strings with relevant
 * data
 *
 * The replacements array should be of the following form<br>
 * <code>
 *  array('replace this' => 'with this',
 *        'replace' => 'me');
 * </code>
 *
 * @access public
 * @param string The Message to parse
 * @param array  The replacements to do
 * @return string the final message
 */
function ParseEmailTemplate($message, $replacements) {

  $search = array();

  $replace = array();

  foreach ($replacements as $rep => $wit) {

    array_push($search, $rep);
    array_push($replace, $wit);

  }

  $return = str_replace($search, $replace, $message);

  return $return;
  
}

// }}}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

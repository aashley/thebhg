<?php
/**
 * Main Citadel Include File
 *
 * Include this file in your script to access the BHG Citadel.
 *
 * @access public
 * @package Roster
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.2 $
 */
 
/**
 * Include the Roster
 */
include_once 'roster.inc';

/**
 * Include the Citadel Main Object
 */
include_once 'citadel/citadel.inc';

/**
 * Include the Citadel Exam Object
 */
include_once 'citadel/exam.inc';

/**
 * Include the Citadel Question Object
 */
include_once 'citadel/question.inc';

/**
 * Include the Citadel Completed Exam Object
 */
include_once 'citadel/completedexam.inc';

/**
 * Include the Citadel Answer Object
 */
include_once 'citadel/answer.inc';

/* vim: set ts=2 sw=2 fdm=marker: */

?>

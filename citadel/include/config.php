<?php

/**
 * Citadel Web Interface :: Configuration Options
 *
 * This file contains all the configuration directives for the Citadel
 * web interface.
 *
 * @access public
 * @author Adam Ashley <aashley@optimiser.com>
 * @package Citadel
 * @version $Revision: 1.3 $
 */

// Title of Site
$GLOBALS['site']['title'] = 'Citadel';

// Meta-Keywords
$GLOBALS['site']['keywords'] = 'Citadel, Training, Bounty Hunter\'s Guild, Emperor\'s Hammer';

// DSN for PEAR DB Object
$GLOBALS['site']['dsn'] = '';

// Location of JPGraph Include Tree
$GLOBALS['site']['jpgraph_location'] = '';

// Base URL of Citadel Interface
$GLOBALS['site']['base_url'] = '/';
$GLOBALS['site']['link_prefix'] = '';

$GLOBALS['site']['file_root'] = $GLOBALS['site']['base_url'].$GLOBALS['site']['link_prefix'];

// Menu for Logged in Users
$GLOBALS['site']['menu'] =
  array();

?>

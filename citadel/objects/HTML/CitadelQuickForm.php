<?php

/**
 * Include the Parent Class HTML_QuickForm
 */
require_once 'HTML/QuickForm.php';

/**
 * OPL Customised QuickForm container
 *
 * Currently this object just changes the default settings on a form.
 *
 * @access public
 * @author Adam Ashley <aashley@optimiser.com>
 * @package PEARObjects
 * @version $Revision: 1.2 $
 */
class Citadel_HTML_QuickForm extends HTML_QuickForm {

  // {{{ Citadel_HTML_QuickForm()
  
  /**
   * Class constructor
   *
   * Same interface as parent, just does different default values
   *
   * @access public
   */
  function Citadel_HTML_QuickForm($formName='', $method='post', $action='', $target='_self', $attributes=null) {
    $action = ($action == '') 
      ? $GLOBALS['site']['file_root'].substr($_SERVER['PATH_INFO'], 1) 
      : $action;
    HTML_QuickForm::HTML_QuickForm($formName, $method, $action, $target, $attributes);
  }

  // }}}

}

?>

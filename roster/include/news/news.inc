<?php
/**
 * This file contains objects from the Centralised News System
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.38 $
 * @package Roster
 * @subpackage News
 */

/**
 * News Board Main Object
 *
 * This object handles the interface to a generic roster provided news system.
 * This object must always be created with a valid Coder ID otherwise it will
 * refuse to return or post any news items.
 *
 *<pre>
 *  20030619  aa  standardised on boolean returns
 *  20030430  ah  Closed the anchor tag in the Render() function.
 *                Added a GetNewsCount() function.
 *  20030413  ah  Added Search() function.
 *  20030409  aa  Completed RenderAdmin()
 *                Added ordering of NewsItems in GetNews() when retrieving all
 *                messages
 *                Added RenderBackend()
 *                Added anchors to Render() output
 *  20030408  aa  Completed LoadConfig()
 *                Completed Render()
 *                First Revision of RenderAdmin()
 *                Documentation Fixes
 *  20030406  ah  Made all parameters for GetNews() optional to allow all items
 *                to be returned.
 *                Added GetItem() function.
 *  20030330  ah  Fixed PostNews() to actually create the query correctly
 *  20030330  aa  Added Changelog oops :)
 *                Documented PostNews() and GetAvailableSections()
 *                Made PostNews support multiple sections
 *                Fixed GetNews() and PostNews() to work against the right db
 *</pre>
 *
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @copyright Copyright &copy; 2001-03 Adam Ashley, and licensed for use by 
 *            the Emperor's Hammer.
 * @access public
 * @package Roster
 * @subpackage News
 * @version $Revision: 1.38 $
 */
class News extends BHGObject {

  // {{{ properties

  /**
   * Storage for Settings for Built in renderer
   *
   * @access protected
   * @var array settings
   */
  var $settings = array();

  // }}}
  // {{{ News()

  /**
   * Object Contructor
   *
   * @access public
   * @param string Coder Identification String
   */
  function News($coder) {

    BHGObject::BHGObject($coder);

  }

  // }}}
  // {{{ LoadConfig()

  /**
   * Load News Configuration
   *
   * Load the configuration of the news system from an ini file. The ini file
   * should be somewhere in your include path and be readable by the web server
   *
   * @access public
   * @param string The filename of the news.ini configuration file
   * @return boolean
   */
  function LoadConfig($config) {

    $dirname = dirname($_SERVER['SCRIPT_FILENAME']);

    $config = realpath($config);

    if ($config !== false) {

      if ($dirname == substr($config, 0, strlen($dirname))) {

        $this->settings = parse_ini_file($config, true);

        return true;

      } else {

        $this->roster_error = 'The config file you tried to load is not '
          .'located within the same tree as the calling script and as such '
          .'will not be loaded.';

        return false;

      }

    } else {

      $this->roster_error = 'Could not find config file.';

      return false;

    }

  }
  
  // }}}
  // {{{ GetItem()

  /**
   * Returns a particular News Item.
   *
   * @access public
   * @param integer The item ID to load.
   * @return object NewsItem
   * @uses NewsItem
   */
  function GetItem($id) {

    return new NewsItem($id, $this->roster_coder);

  }
  
  // }}}
  // {{{ GetNewsCount()

  /**
   * Returns the number of news items in a particular section.
   *
   * @access public
   * @param integer section The ID Number of the section to return.
   * @return integer
   * @uses BHGObject::Allowed()
   */
  function GetNewsCount($section) {

    if ($this->Allowed('allnews')) {

      $sql = 'SELECT COUNT(*) AS items '
            .'FROM newsboard '
            .'WHERE section = '.$section;

      $items = mysql_query($sql, $this->roster_db);

      if ($items && mysql_num_rows($items)) {
	
        return mysql_result($items, 0, 'items');

      } else {
	
        return false;

      }

    } else {

      $this->roster_error = 'The coder is not permitted to use this object.';

    }

  }

  // }}}
  // {{{ GetNews()

  /**
   * Return an array of news Items
   *
   * @access public
   * @param integer The number of items of type to load
   * @param string  The type of limit we have. Can be either 'days'
   *                or 'posts'
   * @param mixed   Either the ID Number of the section to return, or
   *                an array of ID Numbers of sections to return.
   * @return array
   * @uses BHGObject::Allowed()
   * @uses BHGObject::GetCoderID()
   * @uses NewsItem
   */
  function GetNews($number = -1, $number_type = 'all', $section = 0) {

    if ($this->Allowed('news')) {

      if ($section == 0) {

        $section = $this->GetCoderID($this->roster_coder);

      }

      if (!$this->Allowed('allnews')) {

        $section = $this->GetCoderID($this->roster_coder);

      }

      if (!is_array($section)) {

        $section = array($section);

      }

      $sql = 'SELECT id '
            .'FROM newsboard '
            .'WHERE section IN ('.implode(',', $section).') ';

      if ($number_type == 'days') {

        $sql .= 'AND timestamp > '.(time() - ($number * 86400)).' '
          .'ORDER BY timestamp DESC ';

      } elseif ($number_type == 'posts') {

        $sql .= 'ORDER BY timestamp DESC '
          .'LIMIT 0,'.$number.' ';

      } else {

        $sql .= 'ORDER BY timestamp DESC ';

      }

      $return = array();

      $items = mysql_query($sql, $this->roster_db);

      while ($item = mysql_fetch_array($items)) {

        $return[] = new NewsItem($item['id'], $this->roster_coder);

      }

      return $return;

    } else {

      $this->roster_error = 'The coder is not permitted to use this object.';

    }

  }

  // }}}
  // {{{ PostNews()

  /**
   * Post News to the news board
   *
   * This function posts news. $section takes the section id that you wish to
   * post this news item under. To get details of the available sections
   * use the GetAvailableSections() function.
   *
   * @access public
   * @param string The Title of the news item
   * @param string The actual news item body
   * @param int    The roster ID number of the person that is posting
   * @param int    The section ID to post to, if left blank or set to zero
   *               it will be posted under the section associated with
   *               your coder ID. This can also be an array of section ids.
   * @return boolean
   * @see GetAvailableSections()
   * @uses BHGObject::Allowed()
   * @uses BHGObject::GetCoderID()
   */
  function PostNews($title, $body, $poster, $section = 0) {

    if ($this->Allowed('news')) {

      if ($section == 0 || !$this->Allowed('allnews')) {

        $section = $this->GetCoderID($this->roster_coder);

      }

      if (!is_array($section)) {

        $section = array($section);

      }

      if (is_object($poster)) {

				$poster = $poster->GetID();

			}

      $success = true;

      foreach ($section as $sec) {

        $sql = 'INSERT INTO newsboard (section, '
                                     .'timestamp, '
                                     .'poster, '
                                     .'topic, '
                                     .'message) '
              .'VALUES ('.$sec.', '
                         .time().', '
                         .$poster.', '
                         .'"'.addslashes($title).'", '
                         .'"'.addslashes($body).'") ';

        if (!mysql_query($sql, $this->roster_db)) {

          $success = false;

        }

      }

      if ($success) {

        return true;

      } else {

        $this->roster_error = 'At least one section failed. Deal.';

        return false;

      }

    } else {

      $this->roster_error = 'The coder does not have permission to use this '
        .'object.';

      return false;

    }

  }

  // }}}
  // {{{ GetAvailableSections()

  /**
   * Get All the sections available to you
   *
   * This function returns an array containing details of all the sections
   * available to you.
   *
   * The structure of the array that is returned is as follows:
   *<code>
   *  $return = array( 1 => array( 'id' => 1,
   *                               'name' => 'Roster'),
   *                   3 => array( 'id' => 3,
   *                               'name' => 'Xerokine Outlet Center'));
   *</code>
   *
   * @access public
   * @return array As detailed above.
   * @uses BHGObject::Allowed()
   */
  function GetAvailableSections() {

    if ($this->Allowed('allnews')) {
      
      $sql = 'SELECT id, name '
            .'FROM coders '
            .'ORDER BY name ';

    } else {

      $sql = 'SELECT id, name '
            .'FROM coders '
            .'WHERE md5 = \''.strtoupper(md5($id)).'\'';

    }
      
    $coders = mysql_query($sql, $this->roster_db);

    $return = array();

    while ($coder = mysql_fetch_array($coders)) {

      $return[$coder['id']] = $coder;

    }

    return $return;

  }

  // }}}
  // {{{ Search()

  /**
   * Searches for a particular news item.
   *
   * @access public
   * @param string text The text to search for.
	 * @param string by The method to use: "topic" to search by topic, or
	 *                  "message" to search both topics and messages.
	 * @param array sections The sections to search.
   * @return array An array of NewsItem objects.
   * @uses NewsItem
   */
  function Search($text, $by = 'topic', $sections = array()) {

		$items = array();

		$sql = 'SELECT id, MATCH (';
				
		if ($_REQUEST['search'] == 'message') {
		
			$sql .= 'topic, message';
			
		} else {
		
			$sql .= 'topic';
			
		}
		
		$sql .= ') AGAINST ("' . addslashes($_REQUEST['terms']) . '") AS rel';

		if (count($sections)) {

			$sql .= ' WHERE section IN ('
			       .implode(',', $sections)
						 .')';
			
		}

		$sql .= ' FROM newsboard ORDER BY rel DESC, timestamp DESC';

		$result = mysql_query($sql, $this->roster_db);

		if ($result && mysql_num_rows($result)) {

			while (($row = mysql_fetch_array($result)) && $row['rel'] > 0) {

				$items[] = new NewsItem($row['id'], $this->roster_coder);

			}

		}

		return $items;

  }
  
  // }}}
  // {{{ Render()

  /**
   * Render the Main News Display Page
   *
   * This function handles the rendering of the current news. It calls
   * NewsItem::Render to Render each individual news item
   *
   * @access public
   * @return boolean
   * @uses NewsItem
   * @uses NewsItem::Render()
   * @uses NewsItem::GetID()
   * @uses GetNews()
   */
  function Render() {

    if (sizeof($this->settings) > 0) {

      $posts = $this->GetNews($this->settings['news']['number_items'],
                              $this->settings['news']['number_items_type']);

      $template = realpath($this->settings['output']['post_template']);

      if ($template !== false) {

        $template = file_get_contents($template);

        foreach ($posts as $post) {

          if ($this->settings['output']['method'] == 'print') {

            print '<a name="'.$post->GetID().'"></a>'
              .$post->Render($template,
                             $this->settings['news']['date_format']);

          } else {

            $GLOBALS[$this->settings['output']['method']] = 
              '<a name="'.$post->GetID().'"></a>'
              .$post->Render($template,
                             $this->settings['news']['date_format']);
	      
          }

        }

        return true;

      } else {

        $this->roster_error = 'Could not load template file. Halting Render.';

        return false;

      }

    } else {

      $this->roster_error = 'You must load a config file before calling this '
        .'function.';

      return false;

    }

  }

  // }}}
  // {{{ RenderAdmin()

  /**
   * Render the Default Admin Interface for the news script
   *
   * @access public
   * @return boolean
   * @uses Login
   * @uses Login::IsValid()
   * @uses Login::GetID()
   * @uses _AdminCanUse()
   * @uses _AdminCanEdit()
   * @uses _AdminRejectAuth()
   * @uses PostNews()
   * @uses GetItem()
   * @uses NewsItem
   * @uses NewsItem::SetTitle()
   * @uses NewsItem::SetMessage()
   * @uses NewsItem::GetTitle()
   * @uses NewsItem::GetMessage()
   * @uses NewsItem::GetPoster()
   * @uses NewsItem::GetTimestamp()
   * @uses NewsItem::Delete()
   */
  function RenderAdmin() {

    if (sizeof($this->settings) > 0) {
      
      if (   empty($_SERVER['PHP_AUTH_USER']) 
          || strlen($_SERVER['PHP_AUTH_USER']) == 0) {
        
        $this->_AdminRejectAuth();
      
      } else {
        
        $login = new Login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
        
        if ($login->IsValid()) {
          
          if (!$this->_AdminCanUse($login)) {
            
            $this->_AdminRejectAuth();
          
          }
        
        } else {
          
          $this->_AdminRejectAuth();
        
        }
      
      }

      $getstring = '';
      $poststring = '';

      foreach ($_REQUEST as $key => $value) {

        if (!strstr($key, 'news_')) {

          if (is_array($value)) {

            foreach ($value as $val) {

              if ($getstring == '') {

                $getstring .= $key.'[]='.$value;

              } else {

                $getstring .= '&'.$key.'[]='.$value;

              }

              $poststring .= '<INPUT TYPE="hidden" NAME="'.$key.'[]" VALUE="'
                .$value.'">';

            }

          } else {

            if ($getstring == '') {

              $getstring .= $key.'='.$value;

            } else {

              $getstring .= '&'.$key.'='.$value;

            }

            $poststring .= '<INPUT TYPE="hidden" NAME="'.$key.'" VALUE="'
              .$value.'">';

          }

        }

      }

      print '<p><b>Administer '.$this->settings['website']['name'].'</b></p>';

      if ($_REQUEST['news_mode'] == 'post') {

        if ($this->_AdminCanUse($login)) {
        
          if ($_REQUEST['news_submit'] == 'Post News') {

            if ($this->PostNews($_REQUEST['news_topic'],
                                $_REQUEST['news_message'],
                                $login->GetID())) {

              print 'News Successfully Posted.<br><br>';

            } else {

              print 'There was an error while posting the news item.<br><br>';

            }

          } else {

            print '<form action="'.$_SERVER['PHP_SELF'].'" method="post">'
              .$poststring
              .'<input type="hidden" name="news_mode" value="post">'
              .'<table border="0">'
              .'<tr><td>Topic:</td><td>'
              .'<input type="text" size="30" name="news_topic" value="'
              .'"></td></tr>'
              .'<tr><td>Message:</td><td>'
              .'<textarea name="news_message" rows="6" cols="30">'
              .'</textarea></td></tr>'
              .'<tr><td colspan="2" align="right">'
              .'<input type="submit" name="news_submit" value="Post News">'
              .'<input type="reset" value="Reset">'
              .'</td></tr>'
              .'</table>'
              .'</form>';

          }

        } else {

          print 'You do not have permission to post on this news script.'
            .'<br><br>';

        }

        print '<a href="'.$_SERVER['PHP_SELF'].'?'.$getstring
          .(($getstring == '') ? '' : '&').'news_mode=main">Back to Admin News'
          .'</a><br>';
 
      } elseif ($_REQUEST['news_mode'] == 'edit') {

        $post = $this->GetItem($_REQUEST['news_id']);

        if ($this->_AdminCanEdit($login, $post)) {

          if ($_REQUEST['news_submit'] == 'Save Changes') {

            if ($post->SetTitle($_REQUEST['news_topic'])) {

              if ($post->SetMessage($_REQUEST['news_message'])) {

                print 'Post successfully saved.<br><br>';

              } else {

                print 'Could not save new Message Body.<br><br>';

              }

            } else {

              print 'Could not save new Topic.<br><br>';

            }

          } else {

            print '<form action="'.$_SERVER['PHP_SELF'].'" method="post">'
              .$poststring
              .'<input type="hidden" name="news_mode" value="edit">'
              .'<input type="hidden" name="news_id" value="'.$post->GetID().'">'
              .'<table border="0">'
              .'<tr><td>Topic:</td><td>'
              .'<input type="text" size="30" name="news_topic" value="'
              .htmlspecialchars($post->GetTitle()).'"></td></tr>'
              .'<tr><td>Message:</td><td>'
              .'<textarea name="news_message" rows="6" cols="30">'
              .htmlspecialchars($post->GetMessage()).'</textarea></td></tr>'
              .'<tr><td colspan="2" align="right">'
              .'<input type="submit" name="news_submit" value="Save Changes">'
              .'<input type="reset" value="Reset">'
              .'</td></tr>'
              .'</table>'
              .'</form>';

          }

        } else {

          print 'You do not have permission to edit this post.<br><br>';

        }

        print '<a href="'.$_SERVER['PHP_SELF'].'?'.$getstring
          .(($getstring == '') ? '' : '&').'news_mode=main">Back to Admin News'
          .'</a><br>';
        
      } elseif ($_REQUEST['news_mode'] == 'delete') {

        $post = $this->GetItem($_REQUEST['news_id']);

        if ($this->_AdminCanEdit($login, $post)) {

          if ($_REQUEST['news_confirm_delete'] == 'yes') {

            if ($post->Delete()) {

              print 'Post successfully deleted.<br><br>';

            } else {

              print 'Could not delete Post.<br><br>';

            }

            unset($post);

          } else {

            $poster = $post->GetPoster();

            print 'Are you sure you wish to delete the news post entitled '
              .'\''.$post->GetTitle().'\' posted by '.$poster->GetName().' '
              .'at '.date($this->settings['news']['date_format'],
                          $post->GetTimestamp()).'?<br><br>'

              .'[ '
              
              .'<a href="'.$_SERVER['PHP_SELF'].'?'.$getstring
              .(($getstring == '') ? '' : '&').'news_mode=delete&news_id='
              .$post->GetID().'&news_confirm_delete=yes">Yes</a> '

              .'| '

              .'<a href="'.$_SERVER['PHP_SELF'].'?'.$getstring
              .(($getstring == '') ? '' : '&').'news_mode=main">No</a> '

              .']<br><br>';

          }

        } else {

          print 'You do not have permission to delete this post.<br><br>';

        }

        print '<a href="'.$_SERVER['PHP_SELF'].'?'.$getstring
          .(($getstring == '') ? '' : '&').'news_mode=main">Back to Admin News'
          .'</a><br>';

      } else {

        $posts = $this->GetNews();

        print '<a href="'.$_SERVER['PHP_SELF'].'?'.$getstring
          .(($getstring == '') ? '' : '&').'news_mode=post'
          .'">Post News Item</a>';

        print '<table border="0">';

        foreach ($posts as $post) {

          $poster = $post->GetPoster();

          print '<tr><td>'
            .($this->_AdminCanEdit($login, $post)
                ? '<a href="'.$_SERVER['PHP_SELF'].'?'.$getstring
                  .(($getstring == '') ? '' : '&').'news_mode=edit&news_id='
                  .$post->GetID().'">Edit</a> <a href="'.$_SERVER['PHP_SELF']
                  .'?'.$getstring.(($getstring == '') ? '' : '&')
                  .'news_mode=delete&news_id='.$post->GetID().'">Delete</a>'
                : '')
            .'</td><td>'
            .$post->GetTitle().' Posted by '
            .$poster->GetName().' at '
            .date($this->settings['news']['date_format'], 
                  $post->GetTimestamp())
            .'</td></tr>';

        }

        print '</table>';

      }

    } else {

      $this->roster_error = 'You must load a config file before calling this '
        .'function.';

      return false;

    }

  }

  // }}}
  // {{{ _AdminRejectAuth()

  /**
   * Utility Function for RenderAdmin()
   *
   * @access protected
   */
  function _AdminRejectAuth() {
    header('WWW-Authenticate: Basic realm="'.$this->settings['website']['name']
        .'"');
    header('HTTP/1.1 401 Unauthorized');
    echo 'You have either provided no user name and password, an incorrect password, or are not permitted to access this page. I suggest going back and trying again.';
    die();
  }

  // }}}
  // {{{ _AdminCanUse()

  /**
   * Utility Function for RenderAdmin()
   *
   * Returns true or false depending upon whether the person represented by
   * $login can access this Admin page as defined within the configuration file
   *
   * @access protected
   * @param object The Login object of the user
   * @return boolean
   * @uses Login
   * @uses Login::GetID()
   * @uses Login::GetDivision()
   * @uses Login::GetPosition()
   * @uses Division
   * @uses Division::GetID()
   * @uses Position
   * @uses Position::GetID()
   */
  function _AdminCanUse(&$login) {

    if (   isset($this->settings['board_admin']['id'])
        && $this->settings['board_admin']['id'] == $login->GetID()) {

      return true;

    }

    $division = $login->GetDivision();
    $position = $login->GetPosition();

    if (   isset($this->settings['board_admin']['position'])
        && isset($this->settings['board_admin']['division'])
        && $this->settings['board_admin']['position'] == $position->GetID()
        && $this->settings['board_admin']['division'] == $division->GetID()) {

      return true;

    }

    foreach ($this->settings as $key => $settings) {

      if (strstr($key, 'poster')) {

        if (   isset($settings['id'])
            && $settings['id'] == $login->GetID()) {

          return true;

        }

        if (   isset($settings['position'])
            && isset($settings['division'])
            && (   $settings['position'] == -1
                || $settings['position'] == $position->GetID())
            && (   $settings['division'] == -1
                || $settings['division'] == $division->GetID())) {

          return true;

        }

      }

    }

    return false;

  }

  // }}}
  // {{{ _AdminCanEdit()

  /**
   * Utility Function for RenderAdmin()
   *
   * Returns true or false depending upon whether the person represented by
   * $login can edit the post represented by $post as defined within the
   * configuration file
   * 
   * @access protected
   * @param object The Login object of the user
   * @param object The NewsItem object of the news post we are checking
   * @return boolean
   * @uses Login
   * @uses Login::GetID()
   * @uses Login::GetDivision()
   * @uses Login::GetPosition()
   * @uses NewsItem
   * @uses NewsItem::GetPoster()
   * @uses Division
   * @uses Division::GetID()
   * @uses Position
   * @uses Position::GetID()
   */
  function _AdminCanEdit(&$login, &$post) {

    if (   isset($this->settings['board_admin']['id'])
        && $this->settings['board_admin']['id'] == $login->GetID()) {

      return true;

    }

    $division = $login->GetDivision();
    $position = $login->GetPosition();

    if (   isset($this->settings['board_admin']['position'])
        && isset($this->settings['board_admin']['division'])
        && $this->settings['board_admin']['division'] == $division->GetID()
        && $this->settings['board_admin']['position'] == $position->GetID()) {

      return true;

    }

    $poster = $post->GetPoster();

    if ($poster->GetID() == $login->GetID()) {

      return true;

    }

    return false;

  }

  // }}}
  // {{{ RenderBackend()

  /**
   * Output the RSS Backend feed
   *
   * Output the RSS/XML Backend feed for this news script
   *
   * @access public
   * @uses GetNews()
   * @uses NewsItem
   * @uses NewsItem::GetID()
   * @uses NewsItem::GetTitle()
   * @uses NewsItem::GetMessage()
   */
  function RenderBackend() {

    if (sizeof($this->settings) > 0) {

      $doc = domxml_new_doc('1.0');

      $node = $doc->create_element_ns('http://www.w3.org/1999/02/22-rdf-syntax-ns#', 'rdf', 'rdf');

      $root = $doc->append_child($node);

      $node = $doc->create_element('channel');

      $channel = $root->append_child($node);

      $node = $doc->create_element('title');

      $node->set_content($this->settings['website']['name']);

      $title = $channel->append_child($node);

      $node = $doc->create_element('link');

      $node->set_content($this->settings['website']['url']);

      $link = $channel->append_child($node);

      $posts = $this->GetNews($this->settings['backend']['number'],
                              'posts');

      foreach ($posts as $post) {

        $node = $doc->create_element('item');

        $item = $channel->append_child($node);

        $node = $doc->create_element('title');

        $node->set_content($post->GetTitle());

        $title = $item->append_child($node);

        $node = $doc->create_element('link');

        $node->set_content(str_replace('%id%', 
                                       $post->GetID(),
                                       $this->settings['backend']['news_home']));

        $link = $item->append_child($node);

      }

      $xml = $doc->dump_mem(true);

      header("Content-Type: text/xml");

      print $xml;

    } else {

      $this->roster_error = 'You must load a config file before calling this '
        .'function.';

      return false;

    }

  }

  // }}}

}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

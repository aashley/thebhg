<?php

/**
 * Citadel Web Interface :: Home
 *
 * The Home page of the Citadel Web Interface
 *
 * @access public
 * @author Adam Ashley <aashley@optimiser.com>
 * @package Citadel
 * @version $Revision: 1.3 $
 */

/**
 * The function to actually Generate the Home Page
 *
 * @access public
 * @param array The Crumb Trail from higher pages
 * @return void
 */
function Home($crumbTrail) {
  global $roster;

  if (DEBUG) {

    RegisterDebug('Called Home()');

  }

  page_header($GLOBALS['site']['title'].' :: '.gettext('Home'),
      '',
      $crumbTrail);

  $executor = $roster->SearchPosition('X');

  print '<p>Scum,</p>'
    .'<p>I am <a href="mailto:'.$executor[0]->GetEmail().'">Executor '
    .$executor[0]->GetName().'</a>, '
    .'and this is the Citadel. It is here, high above the landscape of '
    .'<a href="http://lyarna.thebhg.org/#2" target="_blank">Sol\'rahl</a>, '
    .'that you will spend many of your days in training. What? You expected '
    .'life as a bounty hunter to be exiciting all of the time? A constant rush '
    .'of adrenaline and easy credits? What kind of dream world are you living '
    .'in? If you want to make it through your first hunt alive, you\'ll want '
    .'to put in a little time training first.</p>'
    .'<p>And now for you old and dying veterans with your sore bones. I know '
    .'what you\'re saying. "This is just for the damn trainees." Well you are '
    .'wrong, <u>damn wrong</u>. Just because you don\'t have a blaster wound '
    .'in your chest yet, it doesn\'t mean you aren\'t just lucky. Take a few '
    .'of our advanced courses and then you can brag.</p>';

  $news = new News('citadel-38learn');

  if ($news->LoadConfig('news.ini')) {

    $news->Render();

  } else {

    print 'Could not load News configuration file...<br>'
      .$news->Error().'<br>';

  }

  page_footer();

}

?>

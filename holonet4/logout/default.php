<?php

class page_logout_default extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		$this->setTitle('Holonet Logout');

		// Unset all of the session variables.
		$_SESSION = array();
		
		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (isset($_COOKIE[session_name()])) {
		  setcookie(session_name(), '', time()-42000, '/');
		}
		
		// Finally, destroy the session.
		session_destroy();

	}

}

?>

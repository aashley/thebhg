<?php
	
	/***************************************
	* setup.php
	* This is the central file that loads
	* all of the objects and holds the few
	* functions that don't fit into any of
	* the object. It also sets up the default
	* url, font face and font size. Finally,
	* the main database object is created.
	***************************************/
	
	//Roster Coder_id
	$coder_id = "citadel-38learn";
	
	//Setup defaults for base url, font face and font size.
	$base_url = "http://podracer.thebhg.org/";
	$base_font = "Verdana, Arial, Helvetica, sans-serif";
	$base_size = "12px";	

	//Include Local Objects  
	ini_set('include_path', ini_get('include_path').':/home/virtual/site5/fst/home/podracer/public_html/objects');
	include_once ('podracer.inc');
	$podracer_obj = new Podracer ();
	
	//Roster Objects
	ini_set('include_path', ini_get('include_path').':/home/virtual/site5/fst/usr/share/roster3/include');
	include_once ('roster.inc');
	$roster_obj = new Roster ();
	
	//Create new Gui, set default template
	$gui_obj = new Gui ();
	$gui_obj->setTemplate($base_url."template.html");
	
	//Misc functions	
	function convertURL($msg) 
	{
		$msg = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])", "<a href='\\1://\\2\\3' target='_blank' class='navbar'>\\1://\\2\\3</a>", $msg);
		$msg = eregi_replace("(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))", "<a href='mailto:\\1' class='navbar'>\\1</a>", $msg);
		$msg = eregi_replace("\[([[:alnum:]]+)\]([^[:space:]]*)([[:alnum:]#?/&=])\[/img\]", "<img src='http://\\2\\3' border='0'>", $msg);
		$msg = str_replace("\n", "<br>", $msg);
		return $msg;
  }
	
	function login_failed ()
	{
		global $gui_obj;
		Header("WWW-Authenticate: Basic realm=\"Podracer\"");
		Header("HTTP/1.0 401 Unauthorized");
		$gui_obj->addContent("<p>Scum,</p>
		<p>Can you not even remember your own id number and password? I think I know where you should go and it
		involves my blaster pistol, but I'll give you one last shot. Refresh and get it right this time.</p>");
		$gui_obj->setTitle("Login Failed");
		$gui_obj->outputGui();
	}
?>

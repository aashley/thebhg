<?php
	
	//Roster Coder_id
	$coder_id = "pea-in-a-pod";
	
	//Setup defaults for base url, font face and font size.
	$base_url = "http://podracer.thebhg.org/";
	$base_font = "Verdana, Arial, Helvetica, sans-serif";
	$base_size = "12px";	

	//Roster Objects
	include_once 'roster.inc';
	$roster = new Roster('pea-in-a-pod');
	
	//News Objects
	$news = new News('pea-in-a-pod');
	
	//Include Local Objects  
	include_once 'objects/podracer.inc';
	$podracer = new Podracer();
	
	//Create new Gui, set default template
	$gui = new Gui ();
	$gui->setTemplate($base_url."template.html");
	
	//Misc functions	
	function convertURL($msg) {
		$msg = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])", "<a href='\\1://\\2\\3' target='_blank' class='navbar'>\\1://\\2\\3</a>", $msg);
		$msg = eregi_replace("(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))", "<a href='mailto:\\1' class='navbar'>\\1</a>", $msg);
		$msg = eregi_replace("\[([[:alnum:]]+)\]([^[:space:]]*)([[:alnum:]#?/&=])\[/img\]", "<img src='http://\\2\\3' border='0'>", $msg);
		$msg = str_replace("\n", "<br>", $msg);
		return $msg;
  }
	
	function login_failed() {
		global $gui;
		Header("WWW-Authenticate: Basic realm=\"Podracer\"");
		Header("HTTP/1.0 401 Unauthorized");
		$gui->addContent("<p>Scum,</p>
		<p>Can you not even remember your own id number and password? I think I know where you should go and it
		involves my blaster pistol, but I'll give you one last shot. Refresh and get it right this time.</p>");
		$gui->setTitle("Login Failed");
		$gui->outputGui();
	}
	
	$admin = array(2650, 1625);
?>

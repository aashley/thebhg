<?php
include('strings.php');
include('frame.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<HTML>
<HEAD>
<TITLE><?=$str_name?></TITLE>
</HEAD>
<FRAMESET ROWS="166,2,*,2,15" FRAMEBORDER="no" BORDER=0 FRAMESPACING=0>
	<FRAME NAME="top" SCROLLING="no" NORESIZE SRC="top.php" MARGINWIDTH=0 MARGINHEIGHT=0>
	<FRAMESET COLS="58,*,58" FRAMEBORDER="no" BORDER=0 FRAMESPACING=0>
		<FRAME NAME="top-left" SCROLLING="no" NORESIZE SRC="greenbg.html" MARGINWIDTH=0 MARGINHEIGHT=0>
		<FRAME NAME="top-centre" SCROLLING="no" NORESIZE SRC="whitebg.html" MARGINWIDTH=0 MARGINHEIGHT=0>
		<FRAME NAME="top-right" SCROLLING="no" NORESIZE SRC="greenbg.html" MARGINWIDTH=0 MARGINHEIGHT=0>
	</FRAMESET>
	<FRAMESET COLS="58,2,*,2,58" FRAMEBORDER="no" BORDER=0 FRAMESPACING=0>
		<FRAME NAME="centre-left" SCROLLING="no" NORESIZE SRC="greenbg.html" MARGINWIDTH=0 MARGINHEIGHT=0>
		<FRAME NAME="centre-centre-left" SCROLLING="no" NORESIZE SRC="whitebg.html" MARGINWIDTH=0 MARGINHEIGHT=0>
		<FRAME NAME="main" SCROLLING="auto" NORESIZE SRC="<?php echo $frame; ?>" MARGINWIDTH=2 MARGINHEIGHT=2>
		<FRAME NAME="centre-centre-right" SCROLLING="no" NORESIZE SRC="whitebg.html" MARGINWIDTH=0 MARGINHEIGHT=0>
		<FRAME NAME="centre-right" SCROLLING="no" NORESIZE SRC="right.html" MARGINWIDTH=0 MARGINHEIGHT=0>
	</FRAMESET>
	<FRAMESET COLS="58,*,58" FRAMEBORDER="no" BORDER=0 FRAMESPACING=0>
		<FRAME NAME="bottom-left" SCROLLING="no" NORESIZE SRC="greenbg.html" MARGINWIDTH=0 MARGINHEIGHT=0>
		<FRAME NAME="bottom-centre" SCROLLING="no" NORESIZE SRC="whitebg.html" MARGINWIDTH=0 MARGINHEIGHT=0>
		<FRAME NAME="bottom-right" SCROLLING="no" NORESIZE SRC="greenbg.html" MARGINWIDTH=0 MARGINHEIGHT=0>
	</FRAMESET>
	<FRAME NAME="bottom" SCROLLING="no" NORESIZE SRC="bottom.html" MARGINWIDTH=0 MARGINHEIGHT=0>
</FRAMESET>
<NOFRAMES>
This site requires frames. If you're using Lynx, start at the top frame.
</NOFRAMES>
</HTML>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<HTML>
<HEAD>
<TITLE>Office of the Tactician</TITLE>
</HEAD>
<FRAMESET ROWS="75,*" FRAMEBORDER="no" BORDER=0 FRAMESPACING=0>
	<FRAME NAME="top" SCROLLING="no" NORESIZE SRC="top.php<?php if (isset($_REQUEST['line'])) echo '?line=' . urlencode($_REQUEST['line']); ?>" MARGINWIDTH=0 MARGINHEIGHT=0>
	<FRAMESET COLS="160,*" FRAMEBORDER="no" BORDER=0 FRAMESPACING=0>
		<FRAME NAME="menu" SCROLLING="no" NORESIZE SRC="menu.php" MARGINWIDTH=0 MARGINHEIGHT=0>
		<FRAME NAME="main" SCROLLING="auto" NORESIZE SRC="main.php<?php if (isset($_REQUEST['news'])) echo '#' . $_REQUEST['news']; ?>" MARGINWIDTH=0 MARGINHEIGHT=0>
	</FRAMESET>
</FRAMESET>
</HTML>

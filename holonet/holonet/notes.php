<?php
function title() {
	return 'General Notes';
}

function output() {
	echo <<<EOT
OK, here is where I put down some general notes on the coding style used in the Holonet for the benefit of the coders that may have to code for it.<br><br>
In short, it works out thusly. Each module gets its own directory under ~holonet/public_html, and can put whatever it likes in there. Note that index.php will be looked for when the user clicks on the module link in the main menu, so you should probably have one of those. The Holonet code will also look for a header.php file in the module directory, and load it if there is one. This is used, for example, to instantiate a Roster object will full access in the roster module, among other things.<br><br>
All code in the Holonet is written with the following stylistic rules:
<ul>
<li>Register_globals must not be assumed to be on.
<li>All code must use Roster 3 (obviously).
<li>The Table and Form classes provided should be used except in exceptional circumstances. (Documentation on those classes to be provided later.)
<li>Internal links should be generated using the provided internal_link() function, in case of module renumbering later. Note that subdirectories aren't handled especially gracefully, so do me a favour and don't use them for now.
<li>Jer would also recommend using tabs instead of spaces when indenting, but that's mostly for his own sanity if he needs to change anything later.
</ul>
Each file loaded should have the following structure:
<ul>
<li>A title function, which returns the title of the file.
<li>An output function, which outputs whatever the file should be outputting.
<li>Optionally, an auth function, which if present will require user authentication. The auth function will then be passed a Person object, and should return true if the user can continue, or false otherwise.
</ul>
Simple, eh?<br><br>
Jer
EOT;
}
?>

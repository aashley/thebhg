<?php
/* Parent class for subdivisions. All subdivisions must define a Subdivision
 * class and override the functions in this. (In other words, this would be a
 * interface if PHP supported them.)
 */

class Subdivision_Parent {
	function GetName() { }
	function GetURL() { }
	function GetOrders($person) { }
	function SetName($name) { }
	function SetURL($name) { }
	function Delete() { }
}

<?php

	/**
	 * Smarty plugin
	 * @package Calypso
	 * @subpackage plugins
	 */

	function smarty_modifier_iso8601 ($timestamp)
	{
		$main_date = date ("Y-m-d\TH:i:s", $timestamp);

		$tz = date ("O", $timestamp);
		$tz = substr_replace ($tz, ':', 3, 0);

		return $main_date . $tz;
	}
?>

<?php
/**
 * Handle clearing out of the Mall purchases
 *
 * <pre>
 *  20030617  aa  fixed removal of kke items
 *                added removal of dsm and rgt items
 *  20030415  aa  properly documented this thing
 * </pre>
 *
 * @package Roster
 * @subpackage Roster
 * @access private
 * @author Adam Harvey <jernai@iinet.net.au>
 * @copyright Copyright &copy; 2001-03 Adam Harvey, and licensed for use by 
 *            the Emperor's Hammer.
 * @version $Revision: 1.10 $
 */

/**
 * Delete the SSL, KIW, KKE and maybe one day DSM purchases
 *
 * @access private
 * @param integer The ID Number of the person who's items we are to delete
 */
function deleteitems($id) {
  $mall_db = mysql_connect('localhost', 'thebhg_mall', 'reta1lth3rapy');
  $result = mysql_query('SELECT * FROM ssl_sales WHERE owner=' . $id, $mall_db);
  while ($row = @mysql_fetch_array($result)) {
    mysql_query('DELETE FROM ssl_partsales WHERE sale=' . $row['id'], $mall_db);
  }
  mysql_query('DELETE FROM ssl_sales WHERE owner=' . $id, $mall_db);
  mysql_query('DELETE FROM kiw_sales WHERE owner=' . $id, $mall_db);
  mysql_query('DELETE FROM ghs_sales WHERE owner=' . $id, $mall_db);
  $result = mysql_query('SELECT * FROM dsm_sales WHERE owner=' . $id, $mall_db);
  while ($row = @mysql_fetch_array($result)) {
    mysql_query('DELETE FROM dsm_partsales WHERE sale=' . $row['id'], $mall_db);
  }
  mysql_query('DELETE FROM dsm_sales WHERE owner=' . $id, $mall_db);
  $result = mysql_query('SELECT * FROM rgt_sales WHERE owner=' . $id, $mall_db);
  while ($row = @mysql_fetch_array($result)) {
    mysql_query('DELETE FROM rgt_partsales WHERE sale=' . $row['id'], $mall_db);
  }
  mysql_query('DELETE FROM rgt_sales WHERE owner=' . $id, $mall_db);
}

/* vim: set ts=2 sw=2 fdm=marker: */

?>

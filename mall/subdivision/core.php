<?php
/* Core objects for Mall subdivisions
 * Author: Jernai Teifsel <jernai@iinet.net.au>
 *
 * The following variables must be set before including core.php:
 * $db : Valid database connection to the subdivision's database.
 * $dbname : The database name used for the subdivision.
 * $malldb : The database name for the mall.
 * $name : The name of the subdivision.
 */

/* DatabaseConnection Object. Has the useful stuff in it. Everything else should
 * inherit this, and call its constructor within their own constructor, should
 * they have one.
 *
 * God, I miss Java.
 */
class DatabaseConnection {
	var $db;
	var $dbname;
	var $malldb;
	
	function DatabaseConnection() {
		$this->db = $GLOBALS["db"];
		$this->dbname = $GLOBALS["dbname"];
		$this->malldb = $GLOBALS["malldb"];
	}
}
	

/* Subdivision Object. All the usual bits and pieces that make up a subdivision
 * are defined here. Unless I've forgotten something.
 *
 * Really, we should inherit from Subdivision_Parent as well as
 * DatabaseConnection, but unfortunately, PHP doesn't do any form of multiple
 * inheritance: not even the cut-down version Java provides (which would have
 * been sufficient for this).
 */
class Subdivision extends DatabaseConnection {
	var $name;

	function Subdivision() {
		$this->DatabaseConnection();
		$this->name = $GLOBALS["name"];
	}

	function GetName() {
		return $this->name;
	}

	function GetShipTypes() {
		$types_result = mysql_db_query($this->dbname, "SELECT id FROM shiptypes", $this->db);
		if ($types_result && mysql_num_rows($types_result)) {
			while ($type = mysql_fetch_array($types_result)) {
				$types[] = new ShipType($type["id"]);
			}
			return $types;
		}
		else {
			return false;
		}
	}

	function GetAuctions() {
		$auctions_result = mysql_db_query($this->dbname, "SELECT id FROM auctions", $this->db);
		if ($auctions_result && mysql_num_rows($auctions_result)) {
			while ($auction = mysql_fetch_array($auctions_result)) {
				$auctions[] = new Auction($auction["id"]);
			}
			return $auctions;
		}
		else {
			return false;
		}
	}

	function GetOrders($person) {
		$orders_result = mysql_db_query($this->dbname, "SELECT id FROM shiporders WHERE owner=$person", $this->db);
		if ($orders_result && mysql_num_rows($orders_result)) {
			while ($order = mysql_fetch_array($orders_result)) {
				$orders[] = new ShipOrder($order["id"]);
			}
			return $orders;
		}
		else {
			return false;
		}
	}

	function GetEffectTypes() {
		$effects_result = mysql_db_query($this->dbname, "SELECT id FROM effecttypes", $this->db);
		while ($effects_result && mysql_num_rows($effects_result)) {
			while ($effect = mysql_fetch_array($effects_result)) {
				$effects[] = new EffectType($effect["id"]);
			}
			return $effects;
		}
		else {
			return false;
		}
	}

	function SetName($name) {
		$GLOBALS["name"] = $name;
		$this->name = $name;
	}
}

/* It should be noted that ShipType (and the other classes that represent rows
 * in tables) caches the current contents of the row. If the row contents
 * change during the life of a ShipType object, then the information returned
 * MAY be out of date.
 *
 * Since the life of an object is normally less than a second, I don't consider
 * this a major problem. If you do, stiff shit. This saves a crapload of
 * database accesses.
 */
class ShipType extends DatabaseConnection {
	var $id;
	var $st_array;

	function UpdateCache() {
		$st_result = mysql_db_query($this->dbname, "SELECT * FROM shiptypes WHERE id=" . $this->id, $this->db);
		if ($st_result && mysql_num_rows($st_result)) {
			$this->st_array = mysql_fetch_array($st_result);
			return true;
		}
		else {
			return false;
		}
	}

	function ShipType($id) {
		$this->id = $id;
		if (!($this->UpdateCache())) return false;
	}

	function GetID() {
		return $this->id;
	}

	function GetName() {
		return stripslashes($this->st_array["name"]);
	}

	function GetWeight() {
		return $this->st_array["weight"];
	}

	function GetHulls() {
		$hulls_result = mysql_db_query($this->dbname, "SELECT id FROM hulls WHERE type=" . $this->id, $this->db);
		while ($hulls_result && mysql_num_rows($hulls_result)) {
			while ($hull = mysql_fetch_array($hulls_result)) {
				$hulls[] = new Hull($hull["id"]);
			}
			return $hulls;
		}
		else {
			return false;
		}
	}
	
	function GetShips() {
		$ships_result = mysql_db_query($this->dbname, "SELECT ships.id FROM ships, hulls WHERE ships.hullid=hulls.id AND hulls.type=" . $this->id, $this->db);
		while ($ships_result && mysql_num_rows($ships_result)) {
			while ($ship = mysql_fetch_array($ships_result)) {
				$ships[] = new Ship($ship["id"]);
			}
			return $ships;
		}
		else {
			return false;
		}
	}

	function IncreaseWeight() {
		if (mysql_db_query($this->dbname, "UPDATE shiptypes SET weight=" . $this->st_array["weight"] + 1 . " WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}

	function DecreaseWeight() {
		if (mysql_db_query($this->dbname, "UPDATE shiptypes SET weight=" . $this->st_array["weight"] - 1 . " WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}

	function SetName($name) {
		if (mysql_db_query($this->dbname, "UPDATE shiptypes SET name='" . addslashes($name) . "' WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}
	
	function AddHull($name, $cost, $length, $crew, $manufacturer, $designer, $hull, $mass, $description, $image) {
		$name = addslashes($name);
		$description = addslashes($description);
		$image = addslashes($image);
		if (is_object($manufacturer)) $manufacturer = $manufacturer->GetID();
		if (is_object($designer)) $designer = $designer->GetID();
		
		if (mysql_db_query($this->dbname, "INSERT INTO hulls (name, cost, type, length, crew, manufacturer, designer, hull, mass, description, image) VALUES ('$name', $cost, " . $this->id . ", $length, $crew, $manufacturer, $designer, $hull, $mass, '$description', '$image')", $this->db)) return new Hull(mysql_insert_id());
		else return false;
	}
	
	/* Note: This function will delete all hulls associated with the ship
	 *       type, which will in turn delete the orders, and so on, and so
	 *       forth. Calling this function is a really, really good way of
	 *       zapping a fair chunk of the database. It is strongly
	 *       recommended that any code calling this function has multiple
	 *       checks to ensure the user really wants to do this, and
	 *       ensuring a current backup exists isn't a bad idea either.
	 *
	 * It should be noted here that the ShipType object will continue to
	 * exist, even after calling this function, simply because there's no
	 * way in PHP to destroy an object. Functions that work off the cached
	 * record will continue to work, even after the ship type is deleted
	 * from the database, but anything altering the record will, naturally,
	 * fail.
	 *
	 * This behaviour should not be relied upon anywhere: it's a quirk due
	 * to PHP, and is not guaranteed to stay the same. If PHP 4.1 provides
	 * a way to zap an object from within that object, it'll be used here.
	 * Also, the AddHull function should not, under any circumstances, be
	 * called after calling the Delete function. Weird things may happen if
	 * this is done, including, but not limited to, an infestation of
	 * teeny little llamas in the coder's underwear.
	 */
	function Delete() {
		if ($hulls = $this->GetHulls()) {
			while ($hull = each($hulls)) {
				$hull[1]->Delete();
			}
		}
		return mysql_db_query($this->dbname, "DELETE FROM shiptypes WHERE id=" . $this->id, $this->db);
	}
}

class Hull extends DatabaseConnection {
	var $id;
	var $hull_array;

	function UpdateCache() {
		$hull_result = mysql_db_query($this->dbname, "SELECT * FROM hulls WHERE id=" . $this->id, $this->db);
		if ($hull_result && mysql_num_rows($hull_result)) {
			$this->hull_array = mysql_fetch_array($hull_result);
			return true;
		}
		else return false;
	}

	function Hull($id) {
		$this->id = $id;
		if (!($this->UpdateCache())) return false;
	}

	function GetID() {
		return $this->id;
	}

	function GetName() {
		return stripslashes($this->hull_array["name"]);
	}

	function GetCost() {
		return $this->hull_array["cost"];
	}

	function GetType() {
		return new ShipType($this->hull_array["type"]);
	}

	function GetLength() {
		return $this->hull_array["length"];
	}

	function GetCrew() {
		return $this->hull_array["crew"];
	}

	function GetManufacturer() {
		return new Company($this->hull_array["manufacturer"]);
	}

	function GetDesigner() {
		return new Company($this->hull_array["designer"]);
	}

	function GetHull() {
		return $this->hull_array["hull"];
	}

	function GetMass() {
		return $this->hull_array["mass"];
	}

	function GetDescription() {
		return stripslashes($this->hull_array["description"]);
	}

	function GetImage() {
		return stripslashes($this->hull_array["image"]);
	}

	function GetBays() {
		$bays_result = mysql_db_query($this->dbname, "SELECT id FROM bays WHERE hullid=" . $this->id, $this->db);
		while ($bays_result && mysql_num_rows($bays_result)) {
			while ($bay = mysql_fetch_array($bays_result)) {
				$bays[] = new Bay($bay["id"]);
			}
			return $bays;
		}
		else {
			return false;
		}
	}

	function GetOrders() {
		$orders_result = mysql_db_query($this->dbname, "SELECT id FROM shiporders WHERE hullid=" . $this->id, $this->db);
		while ($orders_result && mysql_num_rows($orders_result)) {
			while ($order = mysql_fetch_array($orders_result)) {
				$orders[] = new ShipOrder($order["id"]);
			}
			return $orders;
		}
		else {
			return false;
		}
	}

	function SetName($name) {
		$name = addslashes($name);
		if (mysql_db_query($this->dbname, "UPDATE hulls SET name='$name' WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}
	
	function SetCost($cost) {
		if (mysql_db_query($this->dbname, "UPDATE hulls SET cost=$cost WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}

	function SetType($type) {
		if (is_object($type)) $type = $type->GetID();
		if (mysql_db_query($this->dbname, "UPDATE hulls SET type=$type WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}

	function SetLength($length) {
		if (mysql_db_query($this->dbname, "UPDATE hulls SET length=$length WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}

	function SetCrew($crew) {
		if (mysql_db_query($this->dbname, "UPDATE hulls SET crew=$crew WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}

	function SetManufacturer($manufacturer) {
		if (is_object($manufacturer)) $manufacturer = $manufacturer->GetID();
		if (mysql_db_query($this->dbname, "UPDATE hulls SET manufacturer=$manufacturer WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}

	function SetDesigner($designer) {
		if (is_object($designer)) $designer = $designer->GetID();
		if (mysql_db_query($this->dbname, "UPDATE hulls SET designer=$designer WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}

	function SetHull($hull) {
		if (mysql_db_query($this->dbname, "UPDATE hulls SET hull=$hull WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}

	function SetMass($mass) {
		if (mysql_db_query($this->dbname, "UPDATE hulls SET mass=$mass WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}

	function SetDescription($description) {
		$description = addslashes($description);
		if (mysql_db_query($this->dbdescription, "UPDATE hulls SET description='$description' WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}

	function SetImage($image) {
		$image = addslashes($image);
		if (mysql_db_query($this->dbimage, "UPDATE hulls SET image='$image' WHERE id=" . $this->id, $this->db)) {
			return $this->UpdateCache();
		}
		else {
			return false;
		}
	}

	function BuyHull($owner, $name) {
		$name = addslashes($name);
		

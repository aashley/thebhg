<?php
/* Summary: Basic classes for the SSL.
 * Author: Jernai Teifsel <jernai@iinet.net.au>
 * Codename: WFW (Work, Fucker, Work!)
 *
 * This file contains the classes that form the basis for SSL 3. It obviously
 * requires Roster 3, and uses the strings file in a similar manner to the
 * basic store.
 */

// Include roster 3.
ini_set('include_path', ini_get('include_path').':/var/www/html/include');
include_once('roster.inc');
$roster = new Roster('roster-69god');

// Include config/strings files.
include_once('config.php');
include_once('strings.php');

// Connect to the database, and bail if unsuccessful.
$db = mysql_connect($db_host, $db_user, $db_pass);
if (!$db) die("Error connecting to $str_abbrev database.");

/* Store object.
 *
 * This object is the only object that will normally be directly instantiated
 * by anyone, and contains the top-level functions needed to interface with
 * WFW.
 */
class Store {
	
	/* GetItemTypes()
	 * Returns all the item types in the store.
	 *
	 * Parameters: None.
	 * Returns: An array of ItemType objects, or false on failure.
	 */
	function GetItemTypes() {
		global $db, $db_name, $prefix;
		$types_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'itemtypes', $db);
		if ($types_result && mysql_num_rows($types_result)) {
			while ($type = mysql_fetch_array($types_result)) {
				$types[] = new ItemType($type['id']);
			}
			return $types;
		}
		else return false;
	}

	/* GetPartTypes()
	 * Returns all the part types in the store.
	 *
	 * Parameters: None.
	 * Returns: An array of PartType objects, or false on failure.
	 */
	function GetPartTypes() {
		global $db, $db_name, $prefix;
		$types_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'parttypes', $db);
		if ($types_result && mysql_num_rows($types_result)) {
			while ($type = mysql_fetch_array($types_result)) {
				$types[] = new PartType($type['id']);
			}
			return $types;
		}
		else return false;
	}
	
	/* GetItems()
	 * Returns all the item items in the store.
	 *
	 * Parameters: None.
	 * Returns: An array of Item objects, or false on failure.
	 */
	function GetItems() {
		global $db, $db_name, $prefix;
		$items_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'items ORDER BY name ASC', $db);
		if ($items_result && mysql_num_rows($items_result)) {
			while ($item = mysql_fetch_array($items_result)) {
				$items[] = new Item($item['id']);
			}
			return $items;
		}
		else return false;
	}

	/* GetBays()
	 * Returns the different types of bay that can exist in a ship.
	 *
	 * Parameters: None.
	 * Returns: An array of Bay objects, or false on failure.
	 */
	function GetBays() {
		global $db, $db_name, $prefix;
		$bays_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'bays ORDER BY name ASC', $db);
		if ($bays_result && mysql_num_rows($bays_result)) {
			while ($bay = mysql_fetch_array($bays_result)) {
				$bays[] = new Bay($bay['id']);
			}
			return $bays;
		}
		else return false;
	}

	/* GetParts()
	 * Returns the different types of parts available.
	 *
	 * Parameters: None.
	 * Returns: An array of Part objects, or false on failure.
	 */
	function GetParts() {
		global $db, $db_name, $prefix;
		$parts_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'parts ORDER BY name ASC', $db);
		if ($parts_result && mysql_num_rows($parts_result)) {
			while ($part = mysql_fetch_array($parts_result)) {
				$parts[] = new Part($part['id']);
			}
			return $parts;
		}
		else return false;
	}

	/* GetSales()
	 * Returns all the sales made by a pleb.
	 *
	 * Parameters: person: Person object.
	 * Returns: An array of Sale objects, or false if no sales.
	 */
	function GetSales($person) {
		global $db, $db_name, $prefix;
		if (get_class($person) != 'person') return false;
		$sales_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'sales WHERE owner='.$person->GetID().' ORDER BY name ASC', $db);
		if ($sales_result && mysql_num_rows($sales_result)) {
			while ($sale = mysql_fetch_array($sales_result)) {
				$sales[] = new Sale($sale['id']);
			}
			return $sales;
		}
		else return false;
	}

	/* GetAuctions()
	 * Returns all the auctions currently in progress.
	 *
	 * Parameters: all : True to return all auctions, false otherwise.
	 *             open : Only applicable if all is set false. True to
	 *                    return open auctions only, false to return
	 *                    closed ones.
	 * Returns: An array of Auction objects, or false if no auctions.
	 */
	function GetAuctions($all = true, $open = true) {
		global $db, $db_name, $prefix;
		$sql = 'SELECT id FROM '.$prefix.'auctions';
		if (!$all) {
			$sql .= ' WHERE end' . ($open ? '>=' : '<') . 'UNIX_TIMESTAMP()';
		}
		$auction_result = mysql_db_query($db_name, $sql, $db);
		if ($auction_result && mysql_num_rows($auction_result)) {
			while ($auction = mysql_fetch_array($auction_result)) {
				$auctions[] = new Auction($auction['id']);
			}
			return $auctions;
		}
		else return false;
	}

	/* GetMyAuctions()
	 * Returns all the auctions currently being participated in by a
	 * particular person.
	 *
	 * Parameters: person: The person to retrieve the auctions for.
	 * Returns: An multi-dimensional array. $array[0] is the auctions being
	 *          run by the person, $array[1] is the auctions being
	 *          participated in by them.
	 */
	function GetMyAuctions($person) {
		global $db, $db_name, $prefix, $roster;
		if (is_numeric($person)) $person = $roster->GetPerson($person);
		$auctions = $prefix . 'auctions';
		$sales = $prefix . 'sales';
		$bids = $prefix . 'bids';
		$auction_result = mysql_db_query($db_name, "SELECT $auctions.id FROM $auctions, $sales WHERE $auctions.sale=$sales.id AND $sales.owner=" . $person->GetID(), $db);
		if ($auction_result && mysql_num_rows($auction_result)) {
			while ($auction = mysql_fetch_array($auction_result)) {
				$auct[0][] = new Auction($auction['id']);
			}
		}
		else $auct[0] = array();
		$auction_result = mysql_db_query($db_name, "SELECT auction FROM $bids WHERE person=" . $person->GetID() . ' GROUP BY auction', $db);
		if ($auction_result && mysql_num_rows($auction_result)) {
			while ($auction = mysql_fetch_array($auction_result)) {
				$auct[1][] = new Auction($auction['auction']);
			}
		}
		else $auct[1] = array();
		return $auct;
	}

	/* AddItemType()
	 * Adds a new item type.
	 *
	 * Parameters: name: The name of the new type.
	 *             description: The description of the type.
	 * Returns: An ItemType object with the new type, or false on failure.
	 */
	function AddItemType($name, $description) {
		global $db, $db_name, $prefix;
		if (!(is_string($name) && is_string($description))) return false;
		$name = addslashes($name);
		$description = addslashes($description);
		if (mysql_db_query($db_name, 'INSERT INTO '.$prefix."itemtypes (name, description) VALUES ('$name', '$description')", $db)) return new ItemType(mysql_insert_id($db));
		else return false;
	}

	/* AddPartType()
	 * Adds a new part type.
	 *
	 * Parameters: name: The name of the new type.
	 *             description: The description of the type.
	 * Returns: An PartType object with the new type, or false on failure.
	 */
	function AddPartType($name, $description) {
		global $db, $db_name, $prefix;
		if (!(is_string($name) && is_string($description))) return false;
		$name = addslashes($name);
		$description = addslashes($description);
		if (mysql_db_query($db_name, 'INSERT INTO '.$prefix."parttypes (name, description) VALUES ('$name', '$description')", $db)) return new PartType(mysql_insert_id($db));
		else return false;
	}

	/* AddBay()
	 * Adds a new bay type.
	 *
	 * Parameters: name : The name of the bay.
	 *             description : The description of the bay.
	 *             external : Whether the bay has external access or not.
	 * Returns: A Bay object on success, or false on failure.
	 */
	function AddBay($name, $description, $external) {
		global $db, $db_name, $prefix;
		//if (!is_numeric($size) || !is_numeric($external)) return false;
		$name = addslashes($name);
		$description = addslashes($description);
		$external = ($external ? '1' : '0');
		if (mysql_db_query($db_name, 'INSERT INTO '.$prefix."bays (`name`, description, external) VALUES ('$name', '$description', $external)", $db)) return new Bay(mysql_insert_id($db));
		else return false;
	}

}

/* ItemType object.
 *
 * Encapsulates an item type (or category).
 */
class ItemType {
	var $id;
	var $name;
	var $description;

	/* ItemType()
	 * Class constructor.
	 *
	 * Parameters: id: Type ID.
	 * Returns: Type object.
	 */
	function ItemType($id) {
		$this->id = $id;
		$this->UpdateCache();
	}

	/* UpdateCache()
	 * Used internally to keep the cache up to date.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateCache() {
		global $db, $db_name, $prefix;
		$type_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'itemtypes WHERE id='.$this->id, $db);
		if ($type_result && mysql_num_rows($type_result)) {
			$this->name = stripslashes(mysql_result($type_result, 0, 'name'));
			$this->description = stripslashes(mysql_result($type_result, 0, 'description'));
		}
	}

	/* GetID()
	 * Returns the ID of the type.
	 *
	 * Parameters: None.
	 * Returns: The ID.
	 */
	function GetID() {
		return $this->id;
	}

	/* GetName()
	 * Returns the name of the category.
	 *
	 * Parameters: None.
	 * Returns: A string containing the name of the type.
	 */
	function GetName() {
		return $this->name;
	}

	/* GetDescription()
	 * Returns the description of the type.
	 *
	 * Parameters: None.
	 * Returns: The description.
	 */
	function GetDescription() {
		return $this->description;
	}

	/* GetItems()
	 * Returns the items that are in this type.
	 *
	 * Parameters: None.
	 * Returns: An array of Item objects, or false on failure.
	 */
	function GetItems() {
		global $db, $db_name, $prefix;
		$items_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'items WHERE type='.$this->id, $db);
		if ($items_result && mysql_num_rows($items_result)) {
			while ($item = mysql_fetch_array($items_result)) {
				$items[] = new Item($item['id']);
			}
			return $items;
		}
		else return false;
	}

	/* SetName()
	 * Changes the name of the type.
	 *
	 * Parameters: name: The new name of the type.
	 * Returns: True if successful, false otherwise.
	 */
	function SetName($name) {
		global $db, $db_name, $prefix;
		if (!is_string($name)) return false;
		$name = addslashes($name);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."itemtypes SET name='$name' WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetDescription()
	 * Changes the description of the type.
	 *
	 * Parameters: description: The new description of the type.
	 * Returns: True if successful, false otherwise.
	 */
	function SetDescription($description) {
		global $db, $db_name, $prefix;
		if (!is_string($description)) return false;
		$description = addslashes($description);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."itemtypes SET description='$description' WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* AddItem()
	 * Adds a new item to this type.
	 *
	 * Parameters: name: The name of the item.
	 *             price: The cost of the item, in ICs.
	 *             length: The length of the item, in metres.
         *             hull: The strength of the hull, in RUs.
	 *             people: The number of people the default living quarters
	 *                     can hold.
	 *             min: The minimum rank/position/division required.
	 *                  Can be -1, to mean no minimum.
	 *             max: The maximum rank/position/division required.
	 *                  Can be -1, to mean no maximum.
	 *             restriction: What type of restriction is in place, from
	 *                       the following list...
	 *                       1: Rank-based
	 *                       2: Position-based
	 *                       3: Division-based
	 *                       4: No restriction
	 *             description: The description for the item.
	 *             limit: The limit on how many items may be sold.
	 *             shiponly: A flag indicating whether it can be sold only
	 *                       as a complete ship.
	 *             image: An image for the item.
	 *             type: The MIME type of the image.
	 * Returns: Item object with the new item, or false on failure.
	 */
	function AddItem($name, $price, $length, $hull, $people, $min, $max, $restriction, $description, $limit, $shiponly, $image, $type) {
		global $db, $db_name, $prefix;
		//if (!(is_string($name) && is_numeric($price) && is_numeric($min) && is_numeric($max) && is_numeric($required) && is_string($description) && is_numeric($limit))) return false;
		$name = addslashes($name);
		$description = addslashes($description);
		$item = addslashes(urlencode($item));
		$type = addslashes($type);
		$shiponly = ($shiponly ? '1' : '0');
		if (mysql_db_query($db_name, 'INSERT INTO '.$prefix.'items (type, name, price, length, hull, min, max, restriction, description, `limit`, shiponly, image, imagetype) VALUES ('.$this->id.", '$name', $price, $length, $hull, $min, $max, $restriction, '$description', $limit, $shiponly, '$image', '$type')", $db)) return new Item(mysql_insert_id($db));
		else { echo mysql_error($db); return false; }
	}

	/* Delete()
	 * Deletes the type and all items and sales associated with it.
	 *
	 * WARNING: This is a fantastic way of wiping out a good chunk of the
	 * database, and any front-end to this function should make the user go
	 * through a lot of hoops to execute it. Also note that the cache for
	 * this class, like any others that use caching in this file, will
	 * continue to contain some information on the type, even though it no
	 * longer exists. DO NOT rely on this functionality anywhere: it is a
	 * quirk, no more, no less.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function Delete() {
		global $db, $db_name, $prefix;
		$items = $this->GetItems();
		if ($items) {
			for ($i = 0; $i < count($items); $i++) {
				$sales = $items->GetSales();
				if ($sales) {
					for ($j = 0; $j < count($sales); $sales[$j++]->Refund());
				}
			}
		}
		mysql_db_query($db_name, 'DELETE FROM '.$prefix.'items WHERE type='.$this->id, $db);
		mysql_db_query($db_name, 'DELETE FROM '.$prefix.'itemtypes WHERE id='.$this->id, $db);
	}

}

/* Item object.
 *
 * This object contains the information on each item that is for sale in the
 * store.
 */
class Item {
	var $id;
	var $type;
	var $name;
	var $price;
	var $length;
        var $hull;
	var $people;
	var $min;
	var $max;
	var $restriction;
	var $description;
	var $limit;
	var $shiponly;
	var $image;
	var $imagetype;

	/* Item()
	 * Class constructor.
	 *
	 * Parameters: ID number.
	 * Returns: Item object.
	 */
	function Item($id) {
		$this->id = $id;
		$this->UpdateCache();
	}

	/* UpdateCache()
	 * Used internally to keep the cache up to date.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateCache() {
		global $db, $db_name, $prefix;
		$item_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'items WHERE id='.$this->id, $db);
		if ($item_result && mysql_num_rows($item_result)) {
			$this->type = mysql_result($item_result, 0, 'type');
			$this->name = stripslashes(mysql_result($item_result, 0, 'name'));
			$this->price = mysql_result($item_result, 0, 'price');
			$this->length = mysql_result($item_result, 0, 'length');
                        $this->hull = mysql_result($item_result, 0, 'hull');
			$this->people = mysql_result($item_result, 0, 'people');
			$this->min = mysql_result($item_result, 0, 'min');
			$this->max = mysql_result($item_result, 0, 'max');
			$this->restriction = mysql_result($item_result, 0, 'restriction');
			$this->description = stripslashes(mysql_result($item_result, 0, 'description'));
			$this->limit = mysql_result($item_result, 0, 'limit');
			$this->shiponly = mysql_result($item_result, 0, 'shiponly');
			$this->image = urldecode(stripslashes(mysql_result($item_result, 0, 'image')));
			$this->imagetype = stripslashes(mysql_result($item_result, 0, 'imagetype'));
		}
	}

	/* GetID()
	 * Gets the item ID.
	 *
	 * Parameters: None.
	 * Returns: Item ID.
	 */
	function GetID() {
		return $this->id;
	}

	/* GetName()
	 * Gets the item's name.
	 *
	 * Parameters: None.
	 * Returns: The name.
	 */
	function GetName() {
		return $this->name;
	}

	/* GetItemType()
	 * Gets the type of the item.
	 *
	 * Parameters: None.
	 * Returns: An ItemType object.
	 */
	function GetItemType() {
		return new ItemType($this->type);
	}

	/* GetPrice()
	 * Gets the cost of the item.
	 *
	 * Parameters: None.
	 * Returns: The cost of the item, in ICs.
	 */
	function GetPrice() {
		return $this->price;
	}

	/* GetLength()
	 * Gets the length of an item.
	 *
	 * Parameters: None.
	 * Returns: The length of the item in metres.
	 */
	function GetLength() {
		return $this->length;
	}

	/* GetHull()
	 * Gets the hull of an item.
	 *
	 * Parameters: None.
	 * Returns: The hull of the item in metres.
	 */
	function GetHullStrength() {
		return $this->hull;
	}

	/* GetPeople()
	 * Gets the number of people the item can cater for in its living
	 * quarters.
	 *
	 * Parameters: None.
	 * Returns: The number of people.
	 */
	function GetPeople() {
		return $this->people;
	}

	/* GetMin()
	 * Gets the minimum rank/position/division required to buy the item.
	 *
	 * Parameters: None.
	 * Returns: The minimum rpd, or -1 for no minimum.
	 */
	function GetMin() {
		return $this->min;
	}

	/* GetMax()
	 * Gets the maximum rpd allowed to buy the item.
	 *
	 * Parameters: None.
	 * Returns: The maximum rpd, or -1 for no maximum.
	 */
	function GetMax() {
		return $this->max;
	}

	/* GetRestriction()
	 * Gets the type of restriction placed on the item, if any.
	 *
	 * Parameters: None.
	 * Returns: The restriction type, the possible values of which are
	 *          defined under ItemType::GetItem.
	 */
	function GetRestriction() {
		return $this->restriction;
	}

	/* GetSales()
	 * Returns all the sales of this item.
	 *
	 * Parameters: None.
	 * Returns: An array of Sale objects, or false on failure.
	 */
	function GetSales() {
		global $db, $db_name, $prefix;
		$sales_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'sales WHERE item='.$this->id, $db);
		if ($sales_result && mysql_num_rows($sales_result)) {
			while ($sale = mysql_fetch_array($sales_result)) {
				$sales[] = new Sale($sale['id']);
			}
			return $sales;
		}
		else return false;
	}

	/* GetTotalSales()
	 * Returns the number of items sold. This isn't just count(GetSales())
	 * since a sale can have a quantity > 1.
	 *
	 * Parameters: None.
	 * Returns: The number of sales.
	 */
	function GetTotalSales() {
		$sales = $this->GetSales();
		if ($sales) return count($sales);
		else return false;
	}

	/* GetDescription()
	 * Returns the description of the type.
	 *
	 * Parameters: None.
	 * Returns: The description.
	 */
	function GetDescription() {
		return $this->description;
	}

	/* GetLimit()
	 * Returns the maximum number of this item that may be sold.
	 *
	 * Parameters: None.
	 * Returns: The total number of items that can be sold.
	 */
	function GetLimit() {
		return $this->limit;
	}

	/* GetShipOnly()
	 * Returns a flag indicating whether the item can be sold as a complete
	 * ship only.
	 *
	 * Parameters: None.
	 * Returns: True if it can only be sold as a complete ship, false
	 *          otherwise.
	 */
	function GetShipOnly() {
		return $this->shiponly;
	}

	/* GetImage()
	 * Returns the image for the item.
	 *
	 * Parameters: None.
	 * Returns: The raw image data.
	 */
	function GetImage() {
		return $this->image;
	}

	/* GetImageType()
	 * Returns the image type of the item.
	 *
	 * Parameters: None.
	 * Returns: The MIME type for the image.
	 */
	function GetImageType() {
		return $this->imagetype;
	}

	/* HasImage()
	 * Returns whether the item has an image.
	 *
	 * Parameters: None.
	 * Returns: True or false.
	 */
	function HasImage() {
		return strlen($this->image) > 0;
	}

	/* GetBays()
	 * Returns the bays included with this hull.
	 *
	 * Parameters: None.
	 * Returns: An array of HullBay objects, or false if the hull comes with
	 *          no bays. (Huh?)
	 */
	function GetBays() {
		global $db, $db_name, $prefix;
		$bays_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'hull_bays WHERE hull='.$this->id, $db);
		if ($bays_result && mysql_num_rows($bays_result)) {
			while ($bay = mysql_fetch_array($bays_result)) {
				$bays[] = new HullBay($bay['id']);
			}
			return $bays;
		}
		else return false;
	}

	/* CheckPerson()
	 * Checks whether a person is permitted to buy this item.
	 *
	 * Parameters: person: A Person object.
	 * Returns: True if the pleb may buy this item, false otherwise.
	 */
	function CheckPerson($person) {
		if (get_class($person) != 'person') return false;
		$prank = $person->GetRank();
		$ppos = $person->GetPosition();
		$pdiv = $person->GetDivision();
		if ($this->min > -1 || $this->max > -1) {
			switch ($this->restriction) {
				case 1:
					if ($this->max == -1) return ($prank->GetID() >= $this->min);
					else return ($prank->GetID() >= $this->min && $prank->GetID() <= $this->max);
					break;
				case 2:
					if ($this->max == -1) return ($ppos->GetID() >= $this->min);
					else return ($ppos->GetID() >= $this->min && $ppos->GetID() <= $this->max);
					break;
				case 3:
					if ($this->max == -1) return ($pdiv->GetID() >= $this->min);
					else return ($pdiv->GetID() >= $this->min && $pdiv->GetID() <= $this->max);
					break;
				default:
					return true;
			}
		}

		else return true;
	}

	/* SetItemType()
	 * Changes the type of the item.
	 *
	 * Parameters: type: Either an ItemType object or an ID.
	 * Returns: True on success, false otherwise.
	 */
	function SetItemType($type) {
		global $db, $db_name, $prefix;
		if (is_object($type) && get_class($type) == 'itemtype') $type = $type->GetID();
		if (!is_numeric($type)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET type=$type WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetName()
	 * Changes the name of the item.
	 *
	 * Parameters: name: The new name of the item.
	 * Returns: True on success, false otherwise.
	 */
	function SetName($name) {
		global $db, $db_name, $prefix;
		if (!is_string($name)) return false;
		$name = addslashes($name);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET name='$name' WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetPrice()
	 * Changes the price of the item.
	 *
	 * Parameters: price: The new cost in ICs of the item.
	 * Returns: True on success, false otherwise.
	 */
	function SetPrice($price) {
		global $db, $db_name, $prefix;
		if (!is_numeric($price)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET price=$price WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetLength()
	 * Sets the length of the item in metres.
	 *
	 * Parameters: length: The new length of the item.
	 * Returns: True on success, false otherwise.
	 */
	function SetLength($length) {
		global $db, $db_name, $prefix;
		if (!is_numeric($length)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET length=$length WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetHullStrength()
	 * Sets the hull of the item in metres.
	 *
	 * Parameters: hull: The new hull of the item.
	 * Returns: True on success, false otherwise.
	 */
	function SetHullStrength($hull) {
		global $db, $db_name, $prefix;
		if (!is_numeric($hull)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET hull=$hull WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetPeople()
	 * Sets the number of people the item can hold.
	 *
	 * Parameters: people: The new number of people.
	 * Returns: True on success, false otherwise.
	 */
	function SetPeople($people) {
		global $db, $db_name, $prefix;
		if (!is_numeric($people)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET people=$people WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetMin()
	 * Changes the minimum rpd of the item.
	 *
	 * Parameters: min: The new minimum rpd (-1 means no minimum).
	 * Returns: True on success, false otherwise.
	 */
	function SetMin($min) {
		global $db, $db_name, $prefix;
		if (!is_numeric($min)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET min=$min WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetMax()
	 * Changes the maximum rpd of the item.
	 *
	 * Parameters: max: The new maximum rpd (-1 means no maximum).
	 * Returns: True on success, false otherwise.
	 */
	function SetMax($max) {
		global $db, $db_name, $prefix;
		if (!is_numeric($max)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET max=$max WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetRestriction()
	 * Changes the restriction type of the item.
	 *
	 * Parameters: restriction: The new restriction type (defined under
	 *                          ItemType::AddItem),
	 * Returns: True on success, false otherwise.
	 */
	function SetRestriction($restriction) {
		global $db, $db_name, $prefix;
		if (!is_numeric($restriction)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET restriction=$restriction WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetLimit()
	 * Changes the limit on the maximum number of items that may be sold.
	 *
	 * Parameters: limit: The new limit.
	 * Returns: True on success, false otherwise.
	 */
	function SetLimit($limit) {
		global $db, $db_name, $prefix;
		if (!is_numeric($limit)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET ".$prefix."items.limit=$limit WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetShipOnly()
	 * Changes the flag that allows the item to be sold only as a complete
	 * ship.
	 *
	 * Parameters: shiponly: The new flag.
	 * Returns: True on success, false otherwise.
	 */
	function SetShipOnly($shiponly) {
		global $db, $db_name, $prefix;
		if ($shiponly) $shiponly = '1';
		else $shiponly = '0';
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET ".$prefix."items.shiponly=$shiponly WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetDescription()
	 * Changes the description of the type.
	 *
	 * Parameters: description: The new description of the type.
	 * Returns: True if successful, false otherwise.
	 */
	function SetDescription($description) {
		global $db, $db_name, $prefix;
		if (!is_string($description)) return false;
		$description = addslashes($description);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET description='$description' WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetImage()
	 * Saves a new image for the item. Set both parameters to a blank
	 * string to delete the image.
	 *
	 * Parameters: image: The image data for the image.
	 *             type: The MIME type.
	 * Returns: True on success, false otherwise.
	 */
	function SetImage($image, $type) {
		global $db, $db_name, $prefix;
		$image = addslashes(urlencode($image));
		$type = addslashes($type);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."items SET image='$image', imagetype='$type' WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* Sell()
	 * Sells some of this item to a pleb. I've decided, for simplicity,
	 * that rather than adding a new sale for each purchase, we'll first
	 * check if the pleb has already bought this item before and, if so,
	 * simply update that sale to the new quantity.
	 *
	 * Parameters: person: A Person object for the pleb.
	 *             name: The name to add for this hull.
	 *             nocredits: Do not take credits out of the pleb's
	 *                        account.
	 *             ship: True if the item is being sold as a complete ship.
	 * Returns: A Sale object with the sale, or false on failure.
	 */
	function Sell($person, $name, $nocredits = 0, $ship = false) {
		global $db, $db_name, $prefix, $str_name;
		if (get_class($person) != 'person') return false;
		$total_credits = $this->price;
		$rank = $person->GetRank();
		if (($nocredits == 0 && $person->GetAccountBalance() < $total_credits && !$rank->IsUnlimitedCredits()) || !$this->CheckPerson($person) || ($ship == false && $this->limit > 0 && $this->GetTotalSales() >= $this->limit)) return false;
		$name = addslashes($name);
		if (mysql_db_query($db_name, 'INSERT INTO '.$prefix.'sales (item, owner, name, purchase_time) VALUES ('.$this->id.', '.$person->GetID().", '$name', UNIX_TIMESTAMP())", $db)) {
			$person->SetHasShip();
			if ($nocredits == 0) $person->MakePurchase($total_credits, $str_name, $name);
			$sale = new Sale(mysql_insert_id($db));
			$history = $sale->GetHistory();
			$history->AddEvent(2, stripslashes($name));
			return $sale;
		}
		else return false;
	}

	/* AddBay()
	 * Adds a bay to the hull.
	 *
	 * Parameters: bay : A Bay object or ID to add.
         *             size: The size of the bay.
	 * Returns: True on success, false otherwise.
	 */
	function AddBay($bay, $size) {
		global $db, $db_name, $prefix;
		//if (get_class($bay) != 'bay' || !is_numeric($bay)) return false;
		if (is_object($bay)) $bay = $bay->GetID();
		if (mysql_db_query($db_name, 'INSERT INTO '.$prefix.'hull_bays (hull, bay, size) VALUES ('.$this->id.", $bay, $size)", $db)) return true;
		else return false;
	}

	/* DeleteBay()
	 * Deletes a bay from a hull. Note that only the first instance will be
	 * deleted.
	 *
	 * Parameters: bay : A Bay object or ID to delete.
	 * Returns: True on success, false otherwise.
	 */
	function DeleteBay($bay) {
		global $db, $db_name, $prefix;
		if (get_class($bay) != 'bay' || !is_numeric($bay)) return false;
		if (is_object($bay)) $bay = $bay->GetID();
		return !!mysql_db_query($db_name, 'DELETE FROM '.$prefix.'hull_bays WHERE hull='.$this->id." AND bay=$bay LIMIT 1", $db);
	}

	/* Delete()
	 * Deletes the item and all sales of it.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function Delete() {
		global $db, $db_name, $prefix;
		$sales = $this->GetSales();
		if ($sales) {
			for ($i = 0; $i < count($sales); $sales[$i]->Refund());
		}
		mysql_db_query($db_name, 'DELETE FROM '.$prefix.'items WHERE id='.$this->id, $db);
	}

}

/* Sale object.
 *
 * This object represents a completed sale.
 */
class Sale {
	var $id;
	var $item;
	var $item_obj;
	var $owner;
	var $name;
	var $description;
	var $purchase_time;

	var $stats_gen;
	var $consumables;
	var $hull;
	var $shields;
	var $speed;
	var $acceleration;
	var $turnrate;
	var $hyperdrive;
	var $power;
	
	/* Sale()
	 * Class constructor.
	 *
	 * Parameters: Sale ID.
	 * Returns: Sale object.
	 */
	function Sale($id) {
		$this->id = $id;
		$this->UpdateCache();
		$this->stats_gen = false;
	}

	/* UpdateCache()
	 * Used internally to keep the cache up to date.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateCache() {
		global $db, $db_name, $prefix;
		$sale_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'sales WHERE id='.$this->id, $db);
		if ($sale_result && mysql_num_rows($sale_result)) {
			$this->item = mysql_result($sale_result, 0, 'item');
			$this->item_obj = false;
			$this->owner = mysql_result($sale_result, 0, 'owner');
			$this->name = stripslashes(mysql_result($sale_result, 0, 'name'));
			$this->description = stripslashes(mysql_result($sale_result, 0, 'description'));
			$this->purchase_time = mysql_result($sale_result, 0, 'purchase_time');
		}
	}

	/* UpdateStats()
	 * Used internally to update the stats array.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateStats() {
		global $db, $db_name, $prefix;
		$parts = $this->GetParts();
		$item = $this->GetItem();
                $this->hull = $item->GetHullStrength();
		if ($parts) {
			foreach ($parts as $part) {
				$stats = $part->GetStats();
				$this->consumables += $stats->GetConsumables();
				$this->hull += $stats->GetHull();
				$this->shields += $stats->GetShields();
				$this->speed += $stats->GetSpeed();
				$this->acceleration += $stats->GetAcceleration();
				$this->turnrate += $stats->GetTurnRate();
				if (($this->hyperdrive == 0 || empty($this->hyperdrive) || $stats->GetHyperdrive() < $this->hyperdrive) && $stats->GetHyperdrive() > 0) {
					$this->hyperdrive = $stats->GetHyperdrive();
				}
				$this->power += $stats->GetPower();
			}
		}
		$this->stats_gen = true;
	}

	/* GetID()
	 * Returns the ID of the sale.
	 *
	 * Parameters: None.
	 * Returns: A sale ID.
	 */
	function GetID() {
		return $this->id;
	}

	/* GetItem()
	 * Returns the item that was sold.
	 *
	 * Parameters: None.
	 * Returns: An Item object.
	 */
	function GetItem() {
		return new Item($this->item);
	}

	/* GetOwner()
	 * Returns the owner of the stuff.
	 *
	 * Parameters: None.
	 * Returns: A Person object.
	 */
	function GetOwner() {
		global $roster;
		return $roster->GetPerson($this->owner);
	}

	/* GetName()
	 * Returns the name of the item bought by the pleb.
	 *
	 * Parameters: None.
	 * Returns: The name of the item sold.
	 */
	function GetName() {
		return $this->name;
	}

	/* GetDescription()
	 * Returns the description of the item bought by the pleb.
	 *
	 * Parameters: None.
	 * Returns: The description of the item sold.
	 */
	function GetDescription() {
		return $this->description;
	}

	/* GetParts()
	 * Returns the parts bought by the pleb.
	 *
	 * Parameters: None.
	 * Returns: An array of Part objects, or false if no parts have been
	 *          purchased.
	 */
	function GetParts() {
		global $db, $db_name, $prefix;
		$parts_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'partsales WHERE sale='.$this->id, $db);
		if ($parts_result && mysql_num_rows($parts_result)) {
			while ($part = mysql_fetch_array($parts_result)) {
				$parts[$part['id']] = new Part($part['part']);
			}
			return $parts;
		}
		else return false;
	}

	/* GetPartsInBay()
	 * Returns the parts in a particular bay. The bays on a ship can be
	 * gotten from Sale::GetItem::GetBays.
	 *
	 * Parameters: bay : A Bay object or ID.
	 * Returns: An array of Part objects, or false if no parts have been
	 *          placed in this bay.
	 */
	function GetPartsInBay($bay) {
		global $db, $db_name, $prefix;
		if (get_class($bay) != 'hullbay' && !is_numeric($bay)) return false;
		if (get_class($bay) == 'hullbay') $bay = $bay->GetID();
		$parts_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'partsales WHERE sale='.$this->id." AND bay=$bay", $db);
		if ($parts_result && mysql_num_rows($parts_result)) {
			while ($part = mysql_fetch_array($parts_result)) {
				$parts[$part['id']] = new Part($part['part']);
			}
			return $parts;
		}
		else return false;
	}

	/* GetFreeSpace()
	 * Returns the amount of free space in a bay.
	 *
	 * Parameters: bay: The hullbay to check.
	 * Returns: The amount of space.
	 */
	function GetFreeSpace($bay) {
		if (get_class($bay) != 'hullbay' && !is_numeric($bay)) return false;
		if (is_numeric($bay)) $bay = new HullBay($bay);
		$parts_in_bay = $this->GetPartsInBay($bay);
		if ($parts_in_bay) {
			$size = 0;
			if (count($parts_in_bay)) {
				foreach ($parts_in_bay as $bay_part) {
					$size += $bay_part->GetSize();
				}
			}
			return $bay->GetSize() - $size;
		}
		else return $bay->GetSize();
	}

	/* GetValue()
	 * Returns the value of the hull.
	 *
	 * Parameters: None.
	 * Returns: A credit value of the ship.
	 */
	function GetValue() {
		global $db, $db_name, $prefix;
		$item = $this->GetItem();
		$value = $item->GetPrice();
		$result = mysql_db_query($db_name, "SELECT SUM({$prefix}parts.price) AS partvalue FROM {$prefix}parts, {$prefix}partsales WHERE {$prefix}parts.id={$prefix}partsales.part AND {$prefix}partsales.sale=" . $this->id, $db);
		if ($result && mysql_num_rows($result)) {
			$value += mysql_result($result, 0, 'partvalue');
		}
		return $value;
	}

	/* GetPurchaseTime()
	 * Returns the purchase time.
	 *
	 * Parameters: None.
	 * Returns: A UNIX timestamp representing the purchase time.
	 */
	function GetPurchaseTime() {
		return $this->purchase_time;
	}

	/* GetConsumables()
	 * Returns the consumables.
	 *
	 * Parameters: None.
	 * Returns: Consumables.
	 */
	function GetConsumables() {
		if ($this->stats_gen === false) $this->UpdateStats();
		return $this->consumables;
	}

	/* GetHull()
	 * Returns the hull.
	 *
	 * Parameters: None.
	 * Returns: Hull.
	 */
	function GetHull() {
		if ($this->stats_gen === false) $this->UpdateStats();
		return $this->hull;
	}

	/* GetShields()
	 * Returns the shields.
	 *
	 * Parameters: None.
	 * Returns: Shields.
	 */
	function GetShields() {
		if ($this->stats_gen === false) $this->UpdateStats();
		return $this->shields;
	}

	/* GetSpeed()
	 * Returns the speed.
	 *
	 * Parameters: None.
	 * Returns: Speed.
	 */
	function GetSpeed() {
		if ($this->stats_gen === false) $this->UpdateStats();
		return $this->speed;
	}

	/* GetAcceleration()
	 * Returns the acceleration.
	 *
	 * Parameters: None.
	 * Returns: Acceleration.
	 */
	function GetAcceleration() {
		if ($this->stats_gen === false) $this->UpdateStats();
		return $this->acceleration;
	}

	/* GetTurnRate()
	 * Returns the turnrate.
	 *
	 * Parameters: None.
	 * Returns: TurnRate.
	 */
	function GetTurnRate() {
		if ($this->stats_gen === false) $this->UpdateStats();
		return $this->turnrate;
	}

	/* GetHyperdrive()
	 * Returns the hyperdrive.
	 *
	 * Parameters: None.
	 * Returns: Hyperdrive.
	 */
	function GetHyperdrive() {
		if ($this->stats_gen === false) $this->UpdateStats();
		return $this->hyperdrive;
	}

	/* GetPower()
	 * Returns the power.
	 *
	 * Parameters: None.
	 * Returns: Power.
	 */
	function GetPower() {
		if ($this->stats_gen === false) $this->UpdateStats();
		return $this->power;
	}

	/* GetHistory()
	 * Gets a SaleHistory object for this class.
	 *
	 * Parameters: None.
	 * Returns: A SaleHistory object.
	 */
	function GetHistory() {
		return new SaleHistory($this->id);
	}

	/* SetOwner()
	 * Transfers ownership of the stuff to someone else. No credit
	 * adjustment is performed by this function, so if you're implementing
	 * a second-hand sale system, you'll need to alter people's credits
	 * yourself.
	 *
	 * Parameters: person: Person object for the new owner.
	 *             record: True to record a history event, false otherwise.
	 * Returns: True on success, false otherwise.
	 */
	function SetOwner($person, $record = true) {
		global $db, $db_name, $prefix, $roster;
		if (get_class($person) != 'person') $person = $roster->GetPerson($person);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix.'sales SET owner='.$person->GetID().' WHERE id='.$this->id, $db)) {
			$person->SetHasShip();
			if ($record) {
				$history = $this->GetHistory();
				$history->AddEvent(6, $person->GetID());
			}
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetName()
	 * Changes the name of the item.
	 *
	 * Parameters: name: New name.
	 * Returns: True on success, false otherwise.
	 */
	function SetName($name) {
		global $db, $db_name, $prefix;
		$name = addslashes($name);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."sales SET name='$name' WHERE id=".$this->id, $db)) {
			$history = $this->GetHistory();
			$history->AddEvent(4, $this->name, stripslashes($name));
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetDescription()
	 * Changes the description of the item.
	 *
	 * Parameters: description: New description.
	 * Returns: True on success, false otherwise.
	 */
	function SetDescription($description) {
		global $db, $db_name, $prefix;
		$description = addslashes($description);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."sales SET description='$description' WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* AddPart()
	 * Adds a new part to the item.
	 *
	 * Parameters: part: The part to add.
	 *             hullbay: The HullBay to add it to.
	 *             nocredits: True to disable credit deduction.
	 * Returns: 1 on success,
	 *          0 on failure (incorrect parameters),
	 *          -1 on failure (insufficient credits),
	 *          -2 on failure (unsuitable bay),
	 *          -3 on failure (insufficient space),
	 *          -4 on failure (no parts left),
	 *          -5 on failure (unable to purchase due to restrictions),
	 *          -6 on failure (database error),
	 *          -7 on failure (ship is for sale).
	 */
	function AddPart($part, $hullbay, $nocredits = 0) {
		global $db, $db_name, $prefix, $str_name;
		if ($this->IsForSale()) return -7;
		if ((!is_numeric($part) && get_class($part) != 'part') || (!is_numeric($hullbay) && get_class($hullbay) != 'hullbay')) return 0;
		if (is_numeric($part)) $part = new Part($part);
		if (is_numeric($hullbay)) $hullbay = new HullBay($hullbay);
		$bay = $hullbay->GetBay();
		$owner = $this->GetOwner();
		$rank = $owner->GetRank();
		if ($nocredits == 0 && $owner->GetAccountBalance() < $part->GetPrice() && !$rank->IsUnlimitedCredits()) return -1;
		if (($part->GetTotalSales() >= $part->GetLimit()) && ($part->GetLimit() > 0)) return -4;
		if (!$part->CheckPerson($owner)) return -5;
		if ($part->GetExternal() && !$bay->GetExternal()) return -2;
		if ($part->GetBay()) {
			$pbay = $part->GetBay();
			if ($pbay->GetID() != $bay->GetID()) return -2;
		}
		if ($this->GetFreeSpace($hullbay) < $part->GetSize()) return -3;
		if (mysql_db_query($db_name, 'INSERT INTO '.$prefix.'partsales (sale, part, bay, owner, purchase_time) VALUES ('.$this->id.', '.$part->GetID().', '.$hullbay->GetID().', '.$owner->GetID().', UNIX_TIMESTAMP())', $db)) {
			if ($nocredits == 0) $owner->MakePurchase($part->GetPrice(), $str_name, $part->GetName() . ' for ' . $this->name);
			return 1;
		}
		else return -6;
	}

	/* DeletePart()
	 * Deletes a part from a ship.
	 *
	 * Parameters: partsale: The partsales.id to delete.
	 * Returns: True on success, false otherwise.
	 */
	function DeletePart($partsale) {
		global $db, $db_name, $prefix;
		if ($this->IsForSale()) {
			return false;
		}
		else {
			mysql_db_query($db_name, 'DELETE FROM '.$prefix."partsales WHERE id=$partsale", $db);
			return true;
		}
	}

	/* Delete()
	 * Deletes a sale WITHOUT adjusting the credits of the owner.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function Delete() {
		global $db, $db_name, $prefix;
		mysql_db_query($db_name, 'DELETE FROM '.$prefix.'sales WHERE id='.$this->id, $db);
		mysql_db_query($db_name, 'DELETE FROM '.$prefix.'partsales WHERE sale='.$this->id, $db);
	}

	/* Refund()
	 * Deletes a sale and refunds the value of the ship to its owner.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function Refund() {
		global $str_name;
		$owner = $this->GetOwner();
		$owner->MakeSale($this->GetValue(), $str_name, $this->GetName());
		$this->Delete();
	}

	/* Sell()
	 * Sells the ship to another pleb.
	 *
	 * Parameters: buyer : The new owner.
	 *             credits : The number of credits the ship is being sold
	 *                       for.
	 * Returns: True on success, false otherwise.
	 */
	function Sell($buyer, $credits) {
		global $db, $db_name, $prefix, $roster;
		if ((get_class($buyer) != 'person' && !is_numeric($buyer)) || (!is_numeric($credits) || $credits < 0)) return false;
		if (is_numeric($buyer)) $buyer = $roster->GetPerson($buyer);
		$rank = $buyer->GetRank();
		if ($buyer->GetAccountBalance() < $credits && !$rank->IsUnlimitedCredits()) return false;
		$vendor = $roster->GetPerson($this->owner);
		$history = $this->GetHistory();
		$history->AddEvent(3, $buyer->GetID(), $credits);
		if ($this->SetOwner($buyer, false)) {
			$buyer->MakePurchase($credits, $vendor->GetID(), $this->GetName());
			$vendor->MakeSale($credits, $buyer->GetID(), $this->GetName());
			return true;
		}
		else return false;
	}

	/* IsForSale()
	 * Checks if the ship is available for sale in the Junkyard.
	 *
	 * Parameters: None.
	 * Returns: True if the ship is for sale, false otherwise.
	 */
	function IsForSale() {
		return !($this->GetAuction() == false);
	}

	/* StartAuction()
	 * Puts the ship up for auction.
	 *
	 * Parameters: minimum : The minimum ICs wanted.
	 *             enforce : Whether to enforce the minimum or not.
	 *             description : The description for the auction.
	 *             end : The end time of the auction.
	 * Returns: An Auction object on success, false otherwise.
	 */
	function StartAuction($minimum, $enforce, $description, $end) {
		global $db, $db_name, $prefix;

		if ($this->IsForSale()) return false;
		$desc = addslashes($description);
		$enforce = $enforce ? '1' : '0';
		if (mysql_db_query($db_name, 'INSERT INTO '.$prefix.'auctions (sale, minimum, enforce, description, end) VALUES (' . $this->id . ", $minimum, $enforce, '$desc', $end)", $db)) {
			return new Auction(mysql_insert_id($db));
		}
		else {
			return false;
		}
	}

	/* GetAuction()
	 * Returns the Auction the ship is involved with.
	 *
	 * Parameters: None.
	 * Returns: An Auction object if the ship is for sale, false otherwise.
	 */
	function GetAuction() {
		global $db, $db_name, $prefix;

		$sale_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'auctions WHERE sale='.$this->id, $db);
		if ($sale_result && mysql_num_rows($sale_result)) {
			return new Auction(mysql_result($sale_result, 0, 'id'));
		}
		else {
			return false;
		}
	}
	
}

/* HullBay object
 *
 * This is a bay on an actual hull, as opposed to a Bay object, which is just
 * the abstract version of the bay.
 */
class HullBay {
	var $id;
        var $size;
	var $hull;
	var $bay;

	/* HullBay()
	 * Class constructor.
	 *
	 * Parameters: id : The hullbay ID.
	 * Returns: Nothing.
	 */
	function HullBay($id) {
		$this->id = $id;
		$this->UpdateCache();
	}
	
	/* UpdateCache()
	 * Internal-use function to update the internal cache.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateCache() {
		global $db, $db_name, $prefix;
		$result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'hull_bays WHERE id='.$this->id, $db);
		if ($result && mysql_num_rows($result)) {
			$this->hull = mysql_result($result, 0, 'hull');
			$this->bay = mysql_result($result, 0, 'bay');
                        $this->size = mysql_result($result, 0, 'size');
		}
	}

	/* GetID()
	 * Gets the ID.
	 *
	 * Parameters: None.
	 * Returns: An ID.
	 */
	function GetID() {
		return $this->id;
	}

	/* GetItem()
	 * Gets the hull this bay is in.
	 *
	 * Parameters: None.
	 * Returns: An Item object.
	 */
	function GetItem() {
		return new Item($this->hull);
	}

	/* GetBay()
	 * Returns the bay this hullbay is.
	 *
	 * Parameters: None.
	 * Returns: A Bay object.
	 */
	function GetBay() {
		return new Bay($this->bay);
	}

        /* GetSize()
         * Returns the size of the bay in whatever volume unit we're using this
         * week.
         *
         * Parameters: None.
         * Returns: The size of the bay.
         */
        function GetSize() {
                return $this->size;
        }

	/* SetItem()
	 * Sets the hull this bay is in.
	 *
	 * Parameters: item: The new hull.
	 * Returns: True on success, false otherwise.
	 */
	function SetItem($item) {
		global $db, $db_name, $prefix;
		if (!is_numeric($item) && get_class($item) != 'item') return false;
		if (!is_numeric($item)) $item = $item->GetID();
		if (mysql_db_query($db_name, 'UPDATE '.$prefix.'hull_bays SET hull='.$item.' WHERE id='.$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetBay()
	 * Sets the bay this bay is in.
	 *
	 * Parameters: bay: The new bay.
	 * Returns: True on success, false otherwise.
	 */
	function SetBay($bay) {
		global $db, $db_name, $prefix;
		if (!is_numeric($bay) && get_class($bay) != 'bay') return false;
		if (!is_numeric($bay)) $bay = $bay->GetID();
		if (mysql_db_query($db_name, 'UPDATE '.$prefix.'hull_bays SET bay='.$bay.' WHERE id='.$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

        /* SetSize()
         * Sets the size of the bay.
         *
         * Parameters: size: The size of the bay, in VUs.
         * Returns: True on success, false otherwise.
         */
        function SetSize($size) {
                global $db, $db_name, $prefix;

                if (mysql_db_query($db_name, "UPDATE {$prefix}hull_bays SET size=$size WHERE id=".$this->id, $db)) {
                        $this->UpdateCache();
                        return true;
                }
                else return false;
        }

	/* Delete()
	 * Deletes this HullBay.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function Delete() {
		global $db, $db_name, $prefix;
		mysql_db_query($db_name, 'DELETE FROM '.$prefix.'hull_bays WHERE id='.$this->id, $db);
	}

}

/* Bay object
 *
 * This object represents a bay, strangely enough.
 */
class Bay {
	var $id;
	var $name;
	var $description;
	var $external;

	/* Bay()
	 * Class constructor.
	 *
	 * Parameters: bay : The bay ID.
	 * Returns: A bouncing new baby bay.
	 */
	function Bay($bay) {
		$this->id = $bay;
		$this->UpdateCache();
	}

	/* UpdateCache()
	 * Updates the internal cache. Private use only.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateCache() {
		global $db, $db_name, $prefix;
		if ($result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'bays WHERE id='.$this->id, $db)) {
			$this->name = stripslashes(mysql_result($result, 0, 'name'));
			$this->description = stripslashes(mysql_result($result, 0, 'description'));
			$this->external = mysql_result($result, 0, 'external');
		}
	}

	/* GetID()
	 * Returns the bay ID.
	 *
	 * Parameters: None.
	 * Returns: A bay ID.
	 */
	function GetID() {
		return $this->id;
	}

	/* GetName()
	 * Returns the bay name.
	 *
	 * Parameters: None.
	 * Returns: The bay name.
	 */
	function GetName() {
		return $this->name;
	}

	/* GetDescription()
	 * Returns the bay's description.
	 *
	 * Parameters: None.
	 * Returns: The bay's description.
	 */
	function GetDescription() {
		return $this->description;
	}

	/* GetExternal()
	 * Returns whether the bay has external access or not.
	 *
	 * Parameters: None.
	 * Returns: True or false.
	 */
	function GetExternal() {
		return !!($this->external);
	}

	/* SetName()
	 * Sets the name of the bay.
	 *
	 * Parameters: name : The new name.
	 * Returns: True on success, false otherwise.
	 */
	function SetName($name) {
		global $db, $db_name, $prefix;
		$name = addslashes($name);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."bays SET name='$name' WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetDescription()
	 * Sets the description for the bay.
	 *
	 * Parameters: description : The new description.
	 * Returns: True on success, false otherwise.
	 */
	function SetDescription($description) {
		global $db, $db_name, $prefix;
		$description = addslashes($description);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."bays SET description='$description' WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetExternal()
	 * Sets whether the bay has external access or not.
	 *
	 * Parameters: external : The new value (true or false).
	 * Returns: True on success, false otherwise.
	 */
	function SetExternal($external) {
		global $db, $db_name, $prefix;
		//if (!is_numeric($external)) return false;
		$external = ($external ? '1' : '0');
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."bays SET external=$external WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* Delete()
	 * Deletes the bay. DO NOT USE unless you know what you are doing,
	 * since you'll probably end up breaking the SSL completely.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function Delete() {
		global $db, $db_name, $prefix;
		mysql_db_query($db_name, 'DELETE FROM '.$prefix.'bays WHERE id='.$this->id, $db);
	}

}

/* PartType object.
 *
 * Encapsulates an part type (or category).
 */
class PartType {
	var $id;
	var $name;
	var $description;

	/* PartType()
	 * Class constructor.
	 *
	 * Parameters: id: Type ID.
	 * Returns: Type object.
	 */
	function PartType($id) {
		$this->id = $id;
		$this->UpdateCache();
	}

	/* UpdateCache()
	 * Used internally to keep the cache up to date.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateCache() {
		global $db, $db_name, $prefix;
		$type_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'parttypes WHERE id='.$this->id, $db);
		if ($type_result && mysql_num_rows($type_result)) {
			$this->name = stripslashes(mysql_result($type_result, 0, 'name'));
			$this->description = stripslashes(mysql_result($type_result, 0, 'description'));
		}
	}

	/* GetID()
	 * Returns the ID of the type.
	 *
	 * Parameters: None.
	 * Returns: The ID.
	 */
	function GetID() {
		return $this->id;
	}

	/* GetName()
	 * Returns the name of the category.
	 *
	 * Parameters: None.
	 * Returns: A string containing the name of the type.
	 */
	function GetName() {
		return $this->name;
	}

	/* GetDescription()
	 * Returns the description of the type.
	 *
	 * Parameters: None.
	 * Returns: The description.
	 */
	function GetDescription() {
		return $this->description;
	}

	/* GetParts()
	 * Returns the parts that are in this type.
	 *
	 * Parameters: None.
	 * Returns: An array of Part objects, or false on failure.
	 */
	function GetParts() {
		global $db, $db_name, $prefix;
		$parts_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'parts WHERE type='.$this->id, $db);
		if ($parts_result && mysql_num_rows($parts_result)) {
			while ($part = mysql_fetch_array($parts_result)) {
				$parts[] = new Part($part['id']);
			}
			return $parts;
		}
		else return false;
	}

	/* SetName()
	 * Changes the name of the type.
	 *
	 * Parameters: name: The new name of the type.
	 * Returns: True if successful, false otherwise.
	 */
	function SetName($name) {
		global $db, $db_name, $prefix;
		if (!is_string($name)) return false;
		$name = addslashes($name);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."parttypes SET name='$name' WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetDescription()
	 * Changes the description of the type.
	 *
	 * Parameters: description: The new description of the type.
	 * Returns: True if successful, false otherwise.
	 */
	function SetDescription($description) {
		global $db, $db_name, $prefix;
		if (!is_string($description)) return false;
		$description = addslashes($description);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."parttypes SET description='$description' WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* AddPart()
	 * Adds a new part to this type.
	 *
	 * Parameters: name: The name of the part.
	 *             price: The cost of the part, in ICs.
	 *             min: The minimum rank/position/division required.
	 *                  Can be -1, to mean no minimum.
	 *             max: The maximum rank/position/division required.
	 *                  Can be -1, to mean no maximum.
	 *             restriction: What type of restriction is in place, from
	 *                       the following list...
	 *                       1: Rank-based
	 *                       2: Position-based
	 *                       3: Division-based
	 *                       4: No restriction
	 *             description: The description for the part.
	 *             limit: The limit on how many parts may be sold.
	 *             size: The size of the part.
	 *             bay: A Bay object or bay ID to restrict the part to, or
	 *                  false to make the part unrestricted.
	 *             external: Whether external access is required for the
	 *                       part to function.
	 * Returns: Part object with the new part, or false on failure.
	 */
	function AddPart($name, $price, $min, $max, $restriction, $description, $limit, $size, $bay, $external) {
		global $db, $db_name, $prefix;
		//if (!(is_string($name) && is_numeric($price) && is_numeric($min) && is_numeric($max) && is_numeric($required) && is_string($description) && is_numeric($limit))) return false;
		$name = addslashes($name);
		$description = addslashes($description);
		$external = $external ? '1' : '0';
		if (is_object($bay)) $bay = $bay->GetID();
		if (mysql_db_query($db_name, 'INSERT INTO '.$prefix.'parts (type, name, price, min, max, restriction, description, `limit`, size, bay, external) VALUES ('.$this->id.", '$name', $price, $min, $max, $restriction, '$description', $limit, $size, $bay, $external)", $db)) {
			$id = mysql_insert_id($db);
			mysql_db_query($db_name, 'INSERT INTO '.$prefix."stats (id) VALUES ($id)", $db);
			return new Part($id);
		}
		else { echo mysql_error(); return false; }
	}

	/* Delete()
	 * Deletes the type and all parts and sales associated with it.
	 *
	 * WARNING: This is a fantastic way of wiping out a good chunk of the
	 * database, and any front-end to this function should make the user go
	 * through a lot of hoops to execute it. Also note that the cache for
	 * this class, like any others that use caching in this file, will
	 * continue to contain some information on the type, even though it no
	 * longer exists. DO NOT rely on this functionality anywhere: it is a
	 * quirk, no more, no less.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function Delete() {
		global $db, $db_name, $prefix;
		$parts = $this->GetItems();
		if ($parts) {
			for ($i = 0; $i < count($parts); $i++) {
				$sales = $parts->GetSales();
				if ($sales) {
					for ($j = 0; $j < count($sales); $sales[$j++]->Refund());
				}
			}
		}
		mysql_db_query($db_name, 'DELETE FROM '.$prefix.'parts WHERE type='.$this->id, $db);
		mysql_db_query($db_name, 'DELETE FROM '.$prefix.'parttypes WHERE id='.$this->id, $db);
	}

}

/* Part object.
 *
 * This object contains the information on each part that is for sale in the
 * store.
 */
class Part {
	var $id;
	var $type;
	var $name;
	var $price;
	var $min;
	var $max;
	var $restriction;
	var $description;
	var $limit;
	var $size;
	var $bay;
	var $external;

	/* Part()
	 * Class constructor.
	 *
	 * Parameters: ID number.
	 * Returns: Part object.
	 */
	function Part($id) {
		$this->id = $id;
		$this->UpdateCache();
	}

	/* UpdateCache()
	 * Used internally to keep the cache up to date.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateCache() {
		global $db, $db_name, $prefix;
		$part_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'parts WHERE id='.$this->id, $db);
		if ($part_result && mysql_num_rows($part_result)) {
			$this->type = mysql_result($part_result, 0, 'type');
			$this->name = stripslashes(mysql_result($part_result, 0, 'name'));
			$this->price = mysql_result($part_result, 0, 'price');
			$this->min = mysql_result($part_result, 0, 'min');
			$this->max = mysql_result($part_result, 0, 'max');
			$this->restriction = mysql_result($part_result, 0, 'restriction');
			$this->description = stripslashes(mysql_result($part_result, 0, 'description'));
			$this->limit = mysql_result($part_result, 0, 'limit');
			$this->size = mysql_result($part_result, 0, 'size');
			$this->bay = mysql_result($part_result, 0, 'bay');
			$this->external = mysql_result($part_result, 0, 'external');
		}
	}

	/* GetID()
	 * Gets the part ID.
	 *
	 * Parameters: None.
	 * Returns: Part ID.
	 */
	function GetID() {
		return $this->id;
	}

	/* GetName()
	 * Gets the part's name.
	 *
	 * Parameters: None.
	 * Returns: The name.
	 */
	function GetName() {
		return $this->name;
	}

	/* GetPartType()
	 * Gets the type of the part.
	 *
	 * Parameters: None.
	 * Returns: An PartType object.
	 */
	function GetPartType() {
		return new PartType($this->type);
	}

	/* GetPrice()
	 * Gets the cost of the part.
	 *
	 * Parameters: None.
	 * Returns: The cost of the part, in ICs.
	 */
	function GetPrice() {
		return $this->price;
	}

	/* GetMin()
	 * Gets the minimum rank/position/division required to buy the part.
	 *
	 * Parameters: None.
	 * Returns: The minimum rpd, or -1 for no minimum.
	 */
	function GetMin() {
		return $this->min;
	}

	/* GetMax()
	 * Gets the maximum rpd allowed to buy the part.
	 *
	 * Parameters: None.
	 * Returns: The maximum rpd, or -1 for no maximum.
	 */
	function GetMax() {
		return $this->max;
	}

	/* GetRestriction()
	 * Gets the type of restriction placed on the part, if any.
	 *
	 * Parameters: None.
	 * Returns: The restriction type, the possible values of which are
	 *          defined under PartType::GetPart.
	 */
	function GetRestriction() {
		return $this->restriction;
	}

	/* GetSales()
	 * Returns all the sales of this part.
	 *
	 * Parameters: None.
	 * Returns: An array of Sale objects, or false on failure.
	 */
	function GetSales() {
		global $db, $db_name, $prefix;
		$sales_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'partsales WHERE part='.$this->id, $db);
		if ($sales_result && mysql_num_rows($sales_result)) {
			while ($sale = mysql_fetch_array($sales_result)) {
				$sales[] = new Sale($sale['id']);
			}
			return $sales;
		}
		else return false;
	}

	/* GetTotalSales()
	 * Returns the number of parts sold. This isn't just count(GetSales())
	 * since a sale can have a quantity > 1.
	 *
	 * Parameters: None.
	 * Returns: The number of sales.
	 */
	function GetTotalSales() {
		global $db, $db_name, $prefix;
		$sales_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'partsales WHERE part='.$this->id, $db);
		if ($sales_result) return mysql_num_rows($sales_result);
		else return false;
	}

	/* GetDescription()
	 * Returns the description of the type.
	 *
	 * Parameters: None.
	 * Returns: The description.
	 */
	function GetDescription() {
		return $this->description;
	}

	/* GetLimit()
	 * Returns the maximum number of this part that may be sold.
	 *
	 * Parameters: None.
	 * Returns: The total number of parts that can be sold.
	 */
	function GetLimit() {
		return $this->limit;
	}

	/* GetSize()
	 * Returns the size of the part.
	 *
	 * Parameters: None.
	 * Returns: The part's size.
	 */
	function GetSize() {
		return $this->size;
	}

	/* GetBay()
	 * Returns which type of bay the part must be placed in.
	 *
	 * Parameters: None.
	 * Returns: A Bay object if the part can only be placed in that bay, or
	 *          false otherwise.
	 */
	function GetBay() {
		if ($this->bay) return new Bay($this->bay);
		else return false;
	}

	/* GetExternal()
	 * Returns whether this part requires external access or not.
	 *
	 * Parameters: None.
	 * Returns: True or false.
	 */
	function GetExternal() {
		return $this->external;
	}

	/* GetStats()
	 * Returns a Stats object for the part.
	 *
	 * Parameters: None.
	 * Returns: A Stats object.
	 */
	function GetStats() {
		return new Stats($this->id);
	}

	/* CheckPerson()
	 * Checks whether a person is permitted to buy this part.
	 *
	 * Parameters: person: A Person object.
	 * Returns: True if the pleb may buy this part, false otherwise.
	 */
	function CheckPerson($person) {
		if (get_class($person) != 'person') return false;
		$prank = $person->GetRank();
		$ppos = $person->GetPosition();
		$pdiv = $person->GetDivision();
		if ($this->min > -1 || $this->max > -1) {
			switch ($this->restriction) {
				case 1:
					if ($this->max == -1) return ($prank->GetID() >= $this->min);
					else return ($prank->GetID() >= $this->min && $prank->GetID() <= $this->max);
					break;
				case 2:
					if ($this->max == -1) return ($ppos->GetID() >= $this->min);
					else return ($ppos->GetID() >= $this->min && $ppos->GetID() <= $this->max);
					break;
				case 3:
					if ($this->max == -1) return ($pdiv->GetID() >= $this->min);
					else return ($pdiv->GetID() >= $this->min && $pdiv->GetID() <= $this->max);
					break;
				default:
					return true;
			}
		}

		else return true;
	}

	/* SetPartType()
	 * Changes the type of the part.
	 *
	 * Parameters: type: Either an PartType object or an ID.
	 * Returns: True on success, false otherwise.
	 */
	function SetPartType($type) {
		global $db, $db_name, $prefix;
		if (is_object($type) && get_class($type) == 'parttype') $type = $type->GetID();
		if (!is_numeric($type)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."parts SET type=$type WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetName()
	 * Changes the name of the part.
	 *
	 * Parameters: name: The new name of the part.
	 * Returns: True on success, false otherwise.
	 */
	function SetName($name) {
		global $db, $db_name, $prefix;
		if (!is_string($name)) return false;
		$name = addslashes($name);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."parts SET name='$name' WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetPrice()
	 * Changes the price of the part.
	 *
	 * Parameters: price: The new cost in ICs of the part.
	 * Returns: True on success, false otherwise.
	 */
	function SetPrice($price) {
		global $db, $db_name, $prefix;
		if (!is_numeric($price)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."parts SET price=$price WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetMin()
	 * Changes the minimum rpd of the part.
	 *
	 * Parameters: min: The new minimum rpd (-1 means no minimum).
	 * Returns: True on success, false otherwise.
	 */
	function SetMin($min) {
		global $db, $db_name, $prefix;
		if (!is_numeric($min)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."parts SET min=$min WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetMax()
	 * Changes the maximum rpd of the part.
	 *
	 * Parameters: max: The new maximum rpd (-1 means no maximum).
	 * Returns: True on success, false otherwise.
	 */
	function SetMax($max) {
		global $db, $db_name, $prefix;
		if (!is_numeric($max)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."parts SET max=$max WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetRestriction()
	 * Changes the restriction type of the part.
	 *
	 * Parameters: restriction: The new restriction type (defined under
	 *                          PartType::AddPart),
	 * Returns: True on success, false otherwise.
	 */
	function SetRestriction($restriction) {
		global $db, $db_name, $prefix;
		if (!is_numeric($restriction)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."parts SET restriction=$restriction WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetLimit()
	 * Changes the limit on the maximum number of parts that may be sold.
	 *
	 * Parameters: limit: The new limit.
	 * Returns: True on success, false otherwise.
	 */
	function SetLimit($limit) {
		global $db, $db_name, $prefix;
		if (!is_numeric($limit)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."parts SET ".$prefix."parts.limit=$limit WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetSize()
	 * Changes the size of the part.
	 *
	 * Parameters: size: The new size.
	 * Returns: True on success, false otherwise.
	 */
	function SetSize($size) {
		global $db, $db_name, $prefix;
		if (!is_numeric($size)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."parts SET ".$prefix."parts.size=$size WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetBay()
	 * Sets the bay the part must be placed in.
	 *
	 * Parameters: bay: The bay to restrict the part to, or false to remove
	 *                  all restrictions.
	 * Returns: True on success, false otherwise.
	 */
	function SetBay($bay) {
		global $db, $db_name, $prefix;
		if (is_object($bay)) $bay = $bay->GetID();
		if (mysql_db_query($db_name, "UPDATE {$prefix}parts SET {$prefix}parts.bay=$bay WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetExternal()
	 * Changes whether the part requires external access or not.
	 *
	 * Parameters: external: True or false.
	 * Returns: True on success, false otherwise.
	 */
	function SetExternal($external) {
		global $db, $db_name, $prefix;
		//if (!is_numeric($external)) return false;
		$external = ($external ? '1' : '0');
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."parts SET external=$external WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetDescription()
	 * Changes the description of the type.
	 *
	 * Parameters: description: The new description of the type.
	 * Returns: True if successful, false otherwise.
	 */
	function SetDescription($description) {
		global $db, $db_name, $prefix;
		if (!is_string($description)) return false;
		$description = addslashes($description);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."parts SET description='$description' WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* Delete()
	 * Deletes the part and all sales of it.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function Delete() {
		global $db, $db_name, $prefix, $roster;
		$result = mysql_db_query($db_name, "SELECT owner, COUNT(DISTINCT id) AS sales FROM {$prefix}partsales WHERE part={$this->id} GROUP BY owner", $db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$owner = $roster->GetPerson($row['owner']);
				$owner->MakeSale($this->price * $row['sales'], $str_name, 'recall of ' . $this->name);
			}
		}
		mysql_db_query($db_name, "DELETE FROM {$prefix}partsales WHERE part={$this->id}", $db);
		mysql_db_query($db_name, "DELETE FROM {$prefix}parts WHERE id={$this->id}", $db);
	}

}

/* Stats class
 *
 * Statistics associated with a part.
 */
class Stats {
	var $id;
	var $consumables;
	var $hull;
	var $shields;
	var $speed;
	var $acceleration;
	var $turnrate;
	var $hyperdrive;
	var $power;

	/* Stats()
	 * Class constructor.
	 *
	 * Parameters: id: The part ID.
	 * Returns: A Stats object.
	 */
	function Stats($id) {
		$this->id = $id;
		$this->UpdateCache();
	}

	/* UpdateCache()
	 * Internal-use function to update the cache.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateCache() {
		global $db, $db_name, $prefix;
		$result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'stats WHERE id='.$this->id, $db);
		if ($result && mysql_num_rows($result)) {
			$this->consumables = mysql_result($result, 0, 'consumables');
			$this->hull = mysql_result($result, 0, 'hull');
			$this->shields = mysql_result($result, 0, 'shields');
			$this->speed = mysql_result($result, 0, 'speed');
			$this->acceleration = mysql_result($result, 0, 'acceleration');
			$this->turnrate = mysql_result($result, 0, 'turnrate');
			$this->hyperdrive = mysql_result($result, 0, 'hyperdrive');
			$this->power = mysql_result($result, 0, 'power');
		}
	}

	/* GetConsumables()
	 * Returns the consumables for the part, in days.
	 *
	 * Parameters: None.
	 * Returns: Consumables.
	 */
	function GetConsumables() {
		return $this->consumables;
	}

	/* GetHull()
	 * Returns the hull for the part, in RU.
	 *
	 * Parameters: None.
	 * Returns: Hull.
	 */
	function GetHull() {
		return $this->hull;
	}

	/* GetShields()
	 * Returns the shields for the part, in SBD.
	 *
	 * Parameters: None.
	 * Returns: Shields.
	 */
	function GetShields() {
		return $this->shields;
	}

	/* GetSpeed()
	 * Returns the speed for the part, in MGLT.
	 *
	 * Parameters: None.
	 * Returns: Speed.
	 */
	function GetSpeed() {
		return $this->speed;
	}

	/* GetAcceleration()
	 * Returns the acceleration for the part, in MGLT/sec.
	 *
	 * Parameters: None.
	 * Returns: Acceleration.
	 */
	function GetAcceleration() {
		return $this->acceleration;
	}

	/* GetHyperdrive()
	 * Returns the hyperdrive factor for the part.
	 *
	 * Parameters: None.
	 * Returns: Hyperdrive.
	 */
	function GetHyperdrive() {
		return $this->hyperdrive;
	}

	/* GetTurnRate()
	 * Returns the turnrate for the part, in DPF.
	 *
	 * Parameters: None.
	 * Returns: TurnRate.
	 */
	function GetTurnRate() {
		return $this->turnrate;
	}

	/* GetPower()
	 * Returns the power for the part, in thingies.
	 *
	 * Parameters: None.
	 * Returns: Power.
	 */
	function GetPower() {
		return $this->power;
	}

	/* SetConsumables()
	 * Sets the consumables for the part.
	 *
	 * Parameters: consumables: New consumables.
	 * Returns: True on success, false otherwise.
	 */
	function SetConsumables($consumables) {
		global $db, $db_name, $prefix;
		if (!is_numeric($consumables)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."stats SET consumables=$consumables WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetHull()
	 * Sets the hull for the part.
	 *
	 * Parameters: hull: New hull.
	 * Returns: True on success, false otherwise.
	 */
	function SetHull($hull) {
		global $db, $db_name, $prefix;
		if (!is_numeric($hull)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."stats SET hull=$hull WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetShields()
	 * Sets the shields for the part.
	 *
	 * Parameters: shields: New shields.
	 * Returns: True on success, false otherwise.
	 */
	function SetShields($shields) {
		global $db, $db_name, $prefix;
		if (!is_numeric($shields)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."stats SET shields=$shields WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetSpeed()
	 * Sets the speed for the part.
	 *
	 * Parameters: speed: New speed.
	 * Returns: True on success, false otherwise.
	 */
	function SetSpeed($speed) {
		global $db, $db_name, $prefix;
		if (!is_numeric($speed)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."stats SET speed=$speed WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetAcceleration()
	 * Sets the acceleration for the part.
	 *
	 * Parameters: acceleration: New acceleration.
	 * Returns: True on success, false otherwise.
	 */
	function SetAcceleration($acceleration) {
		global $db, $db_name, $prefix;
		if (!is_numeric($acceleration)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."stats SET acceleration=$acceleration WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetTurnRate()
	 * Sets the turnrate for the part.
	 *
	 * Parameters: turnrate: New turnrate.
	 * Returns: True on success, false otherwise.
	 */
	function SetTurnRate($turnrate) {
		global $db, $db_name, $prefix;
		if (!is_numeric($turnrate)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."stats SET turnrate=$turnrate WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetHyperdrive()
	 * Sets the hyperdrive for the part.
	 *
	 * Parameters: hyperdrive: New hyperdrive.
	 * Returns: True on success, false otherwise.
	 */
	function SetHyperdrive($hyperdrive) {
		global $db, $db_name, $prefix;
		if (!is_numeric($hyperdrive)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."stats SET hyperdrive=$hyperdrive WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetPower()
	 * Sets the power for the part.
	 *
	 * Parameters: power: New power.
	 * Returns: True on success, false otherwise.
	 */
	function SetPower($power) {
		global $db, $db_name, $prefix;
		if (!is_numeric($power)) return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."stats SET power=$power WHERE id=".$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

}

/* SaleHistory class
 *
 * The history of a sold item.
 */
class SaleHistory {
	var $id;
	var $events;

	/* SaleHistory()
	 * Class constructor.
	 *
	 * Parameters: id: Sale ID.
	 * Returns: Nothing.
	 */
	function SaleHistory($id) {
		$this->id = $id;
		$this->UpdateCache();
	}

	/* UpdateCache()
	 * Private function to update the internal event cache.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateCache() {
		global $db, $db_name, $prefix;
		$result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'history WHERE sale='.$this->id.' ORDER BY time ASC', $db);
		if ($result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$this->events[] = new Event($row['id']);
			}
		}
		else $this->events = false;
	}

	/* GetSale()
	 * Returns the sale this history applies to.
	 *
	 * Parameters: None.
	 * Returns: A Sale object.
	 */
	function GetSale() {
		return new Sale($this->id);
	}

	/* GetEvents()
	 * Returns the events that have happened to this sale.
	 *
	 * Parameters: None.
	 * Returns: An array of Event object, or false if no events.
	 */
	function GetEvents() {
		return $this->events;
	}

	/* AddEvent()
	 * Adds a new event to the sale's history.
	 *
	 * Parameters: type: The type of event that has occurred, from this
	 *                   list:
	 *                   1. Start of ship history. (a+b: empty)
	 *                   2. Ship purchase. (a: name, b: empty)
	 *                   3. Second-hand sale. (a: buyer, b: credits)
	 *                   4. Name change. (a: old name, b: new name)
	 *                   5. Ship repossessed.
	 *                   6. Ship given away. (a: new owner, b: empty)
	 *             a: Parameter A.
	 *             b: Parameter B.
	 * Returns: An Event object on success, false otherwise.
	 */
	function AddEvent($type, $a = '0', $b = '0') {
		global $db, $db_name, $prefix;
		$sale = $this->GetSale();
		$owner = $sale->GetOwner();
		$a = addslashes($a);
		$b = addslashes($b);
		if (mysql_db_query($db_name, 'INSERT INTO '.$prefix."history (time, type, owner, sale, bloba, blobb) VALUES (UNIX_TIMESTAMP(), $type, ".$owner->GetID().', '.$sale->GetID().", '$a', '$b')", $db)) {
			$event = new Event(mysql_insert_id($db));
			$this->UpdateCache();
			return $event;
		}
		else return false;
	}

}

/* Event class
 *
 * A history event.
 */
class Event {
	var $id;
	var $time;
	var $type;
	var $owner;
	var $sale;
	var $bloba;
	var $blobb;

	/* Event()
	 * Class constructor.
	 *
	 * Parameters: id: The history event ID.
	 * Returns: Nothing.
	 */
	function Event($id) {
		$this->id = $id;
		$this->UpdateCache();
	}

	/* UpdateCache()
	 * Updates the interal event cache.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateCache() {
		global $db, $db_name, $prefix, $roster;
		$result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'history WHERE id='.$this->id, $db);
		if ($result && mysql_num_rows($result)) {
			$this->time = mysql_result($result, 0, 'time');
			$this->type = mysql_result($result, 0, 'type');
			$this->owner = $roster->GetPerson(mysql_result($result, 0, 'owner'));
			$this->sale = mysql_result($result, 0, 'sale');
			$this->bloba = stripslashes(mysql_result($result, 0, 'bloba'));
			$this->blobb = stripslashes(mysql_result($result, 0, 'blobb'));
		}
	}

	/* GetTime()
	 * Returns the time the event occurred.
	 *
	 * Parameters: None.
	 * Returns: A UNIX timestamp.
	 */
	function GetTime() {
		return $this->time;
	}

	/* GetEventText()
	 * Returns the textual description of the event.
	 *
	 * Parameters: None.
	 * Returns: A string.
	 */
	function GetEventText() {
		global $str_singular, $roster;
		$owner = $this->owner;
		switch ($this->type) {
			case 1:
				$str = 'Start of '.$str_singular.' history. '.ucwords($str_singular).' owned by <A HREF="' . roster_person($owner->GetID()) . '" TARGET="_blank">' . $owner->GetName() . '</A>.';
				break;
			case 2:
				$str = ''.ucwords($str_singular).' purchased by <A HREF="' . roster_person($owner->GetID()) . '" TARGET="_blank">' . $owner->GetName() . '</A> and named ' . $this->bloba . '.';
				break;
			case 3:
				$newowner = $roster->GetPerson($this->bloba);
				$str = ''.ucwords($str_singular).' sold by <A HREF="' . roster_person($owner->GetID()) . '" TARGET="_blank">' . $owner->GetName() . '</A> to <A HREF="' . roster_person($newowner->GetID()) . '" TARGET="_blank">' . $newowner->GetName() . '</A> for ' . number_format($this->blobb) . ' ICs.';
				break;
			case 4:
				$str = 'Name of '.$str_singular.' changed from ' . $this->bloba . ' to ' . $this->blobb . '.';
				break;
			case 5:
				$str = ''.ucwords($str_singular).' repossessed from AWOLed hunter <A HREF="' . roster_person($owner->GetID()) . '" TARGET="_blank">' . $owner->GetName() . '</A>.';
			case 6:
				$newowner = $roster->GetPerson($this->bloba);
				$str = ''.ucwords($str_singular).' given to <A HREF="' . roster_person($newowner->GetID()) . '" TARGET="_blank">' . $newowner->GetName() . '</A> by <A HREF="' . roster_person($owner->GetID()) . '" TARGET="_blank">' . $owner->GetName() . '</A>.';
				break;
		}
		return $str;
	}

}

/* Auction class
 *
 * A representation of an ongoing auction.
 */
class Auction {
	var $id;
	var $sale;
	var $minimum;
	var $enforce;
	var $description;
	var $end;

	/* Auction()
	 * Class constructor.
	 *
	 * Parameters: id : The auction ID.
	 * Returns: An Auction object.
	 */
	function Auction($id) {
		$this->id = $id;
		$this->UpdateCache();
	}
	
	/* UpdateCache()
	 * Updates the internal cache.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateCache() {
		global $db, $db_name, $prefix;

		$result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'auctions WHERE id='.$this->id, $db);
		if ($result && mysql_num_rows($result)) {
			$this->sale = mysql_result($result, 0, 'sale');
			$this->minimum = mysql_result($result, 0, 'minimum');
			$this->enforce = mysql_result($result, 0, 'enforce');
			$this->description = stripslashes(mysql_result($result, 0, 'description'));
			$this->end = mysql_result($result, 0, 'end');
		}
	}

	/* GetID()
	 * Returns the auction ID.
	 *
	 * Parameters: None.
	 * Returns: An ID.
	 */
	function GetID() {
		return $this->id;
	}

	/* GetSale()
	 * Returns the ship this auction is for.
	 *
	 * Parameters: None.
	 * Returns: A Sale object.
	 */
	function GetSale() {
		return new Sale($this->sale);
	}

	/* GetMinimum()
	 * Returns the minimum ICs accepted for the ship.
	 *
	 * Parameters: None.
	 * Returns: The minimum.
	 */
	function GetMinimum() {
		return $this->minimum;
	}

	/* GetEnforce()
	 * Returns whether the minimum is to be enforced or not.
	 *
	 * Parameters: None.
	 * Returns: True or false.
	 */
	function GetEnforce() {
		return $this->enforce;
	}

	/* GetDescription()
	 * Returns the description for the auction.
	 *
	 * Parameters: None.
	 * Returns: The description.
	 */
	function GetDescription() {
		return $this->description;
	}

	/* GetEnd()
	 * Returns the end time for the auction.
	 *
	 * Parameters: None.
	 * Returns: The end time as a UNIX timestamp.
	 */
	function GetEnd() {
		return $this->end;
	}

	/* SetMinimum()
	 * Sets the minimum bid accepted.
	 *
	 * Parameters: minimum : The minimum ICs.
	 * Returns: True on success, false otherwise.
	 */
	function SetMinimum($minimum) {
		global $db, $db_name, $prefix;

		if (mysql_db_query($db_name, 'UPDATE '.$prefix."auctions SET minimum=$minimum WHERE id=" . $this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	/* SetEnforce()
	 * Sets whether to enforce the minimum bid or not.
	 *
	 * Parameters: enforce : True or false.
	 * Returns: True on success, false otherwise.
	 */
	function SetEnforce($enforce) {
		global $db, $db_name, $prefix;

		if (mysql_db_query($db_name, 'UPDATE '.$prefix."auctions SET enforce=$enforce WHERE id=" . $this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	/* SetDescription()
	 * Sets the description for the auction.
	 *
	 * Parameters: description : The new description.
	 * Returns: True on success, false otherwise.
	 */
	function SetDescription($description) {
		global $db, $db_name, $prefix;

		$description = addslashes($description);
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."auctions SET description='$description' WHERE id=" . $this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else {
			return false;
		}
	}

	/* MakeBid()
	 * Makes a new bid for the ship.
	 *
	 * Parameters: person : The person making the bid.
	 *             bid : The bid, in ICs.
	 * Returns: True on success, false otherwise.
	 */
	function MakeBid($person, $bid) {
		global $db, $db_name, $prefix, $roster;

		if (is_numeric($person)) $person = $roster->GetPerson($person);
		if (time() < $this->end && mysql_db_query($db_name, 'INSERT INTO '.$prefix.'bids (auction, person, bid, time) VALUES (' . $this->id . ', ' . $person->GetID() . ", $bid, UNIX_TIMESTAMP())", $db)) {
			return true;
		}
		else {
			return false;
		}
	}

	/* Withdraw()
	 * Withdraws the ship from sale.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function Withdraw() {
		global $db, $db_name, $prefix;

		mysql_db_query($db_name, 'DELETE FROM '.$prefix.'bids WHERE auction='.$this->id, $db);
		mysql_db_query($db_name, 'DELETE FROM '.$prefix.'auctions WHERE id='.$this->id, $db);
	}

	/* GetBids()
	 * Returns the bids made for the auction to date.
	 *
	 * Parameters: None.
	 * Returns: An array of Bid objects if bids have been made, false
	 *          otherwise.
	 */
	function GetBids() {
		global $db, $db_name, $prefix;

		$bid_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'bids WHERE auction='.$this->id.' ORDER BY bid DESC', $db);
		if ($bid_result && mysql_num_rows($bid_result)) {
			$bids = array();
			while ($bid = mysql_fetch_array($bid_result)) {
				$bids[] = new Bid($bid['id']);
			}
			return $bids;
		}
		else {
			return false;
		}
	}

}

/* Bid class
 *
 * Represents a bid in an auction.
 */
class Bid {
	var $id;
	var $auction;
	var $person;
	var $bid;
	var $time;

	/* Bid()
	 * Class constructor.
	 *
	 * Parameters: id : The bid ID.
	 * Returns: Nothing.
	 */
	function Bid($id) {
		$this->id = $id;
		$this->UpdateCache();
	}

	/* UpdateCache()
	 * Updates the internal cache.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function UpdateCache() {
		global $db, $db_name, $prefix, $roster;

		$bid_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'bids WHERE id='.$this->id, $db);
		if ($bid_result && mysql_num_rows($bid_result)) {
			$this->auction = mysql_result($bid_result, 0, 'auction');
			$this->person = $roster->GetPerson(mysql_result($bid_result, 0, 'person'));
			$this->bid = mysql_result($bid_result, 0, 'bid');
			$this->time = mysql_result($bid_result, 0, 'time');
		}
	}

	/* GetID()
	 * Returns the bid ID.
	 *
	 * Parameters: None.
	 * Returns: The bid ID.
	 */
	function GetID() {
		return $this->id;
	}

	/* GetAuction()
	 * Returns the auction the bid is attached to.
	 *
	 * Parameters: None.
	 * Returns: An Auction object.
	 */
	function GetAuction() {
		return new Auction($this->auction);
	}

	/* GetPerson()
	 * Returns the Person object for the bidder.
	 *
	 * Parameters: None.
	 * Returns: A Person object.
	 */
	function GetPerson() {
		return $this->person;
	}

	/* GetBid()
	 * Returns the bid.
	 *
	 * Parameters: None.
	 * Returns: The number of ICs bidded.
	 */
	function GetBid() {
		return $this->bid;
	}

	/* GetTime()
	 * Returns the time of the bid.
	 *
	 * Parameters: None.
	 * Returns: A UNIX timestamp.
	 */
	function GetTime() {
		return $this->time;
	}

	/* IsValid()
	 * Returns whether the bidder can afford this bid or not.
	 *
	 * Parameters: None.
	 * Returns: True or false.
	 */
	function IsValid() {
		$bidder = $this->person;
		$rank = $bidder->GetRank();
		if ($this->bid > $bidder->GetAccountBalance() && !$rank->IsUnlimitedCredits()) return false;
		$auction = new Auction($this->auction);
		$sale = $auction->GetSale();
		$item = $sale->GetItem();
		return ($item->CheckPerson($this->person));
	}

	/* AcceptBid()
	 * Accepts the bid and finishes the auction.
	 *
	 * Parameters: None.
	 * Returns: True on success, false otherwise.
	 */
	function AcceptBid() {
		$bidder = $this->person;
		if (!$this->IsValid()) return false;
		$auction = new Auction($this->auction);
		$sale = $auction->GetSale();
		if (!$sale->Sell($bidder->GetID(), $this->bid)) return false;
		$auction->Withdraw();
		return true;
	}
}
?>

<?php
/* Summary: Basic classes for a simple store.
 * Author: Jernai Teifsel <jernai@iinet.net.au>
 * Codename: Capitalist Pigdog (CPD)
 *
 * This file contains the classes that form the basis for a store. As you can
 * see just after this comment, Roster 3 must be included, as must the config
 * file for the store and the strings file. You can change the include paths as
 * required for those.
 */

// Include roster 3.
ini_set('include_path', ini_get('include_path').':/home/virtual/site5/fst/usr/share/roster3/include');
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
 * CPD.
 */
class Store {
	
	/* GetTypes()
	 * Returns all the item types in the store.
	 *
	 * Parameters: None.
	 * Returns: An array of Type objects, or false on failure.
	 */
	function GetTypes() {
		global $db, $db_name, $prefix;
		$types_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'itemtypes', $db);
		if ($types_result && mysql_num_rows($types_result)) {
			while ($type = mysql_fetch_array($types_result)) {
				$types[] = new Type($type['id']);
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

	/* GetSales()
	 * Returns all the sales made by a pleb.
	 *
	 * Parameters: person: Person object.
	 * Returns: An array of Sale objects, or false if no sales.
	 */
	function GetSales($person) {
		global $db, $db_name, $prefix;
		if (get_class($person) != 'person') return false;
		$sales_result = mysql_db_query($db_name, 'SELECT id FROM '.$prefix.'sales WHERE owner='.$person->GetID(), $db);
		if ($sales_result && mysql_num_rows($sales_result)) {
			while ($sale = mysql_fetch_array($sales_result)) {
				$sales[] = new Sale($sale['id']);
			}
			return $sales;
		}
		else return false;
	}

	/* GetSale()
	 *
	 * Parameters: id: The Sale ID.
	 * Returns: A Sale object.
	 */
	function GetSale($id) {
		return new Sale($id);
	}

	/* AddType()
	 * Adds a new item type.
	 *
	 * Parameters: name: The name of the new type.
	 *             description: The description of the type.
	 * Returns: A Type object with the new type, or false on failure.
	 */
	function AddType($name, $description) {
		global $db, $db_name, $prefix;
		if (!(is_string($name) && is_string($description))) return false;
		$name = addslashes($name);
		$description = addslashes($description);
		if (mysql_db_query($db_name, 'INSERT INTO '.$prefix."itemtypes (name, description) VALUES ('$name', '$description')", $db)) return new Type(mysql_insert_id($db));
		else return false;
	}

}

/* Type object.
 *
 * Encapsulates an item type (or category).
 */
class Type {
	var $id;
	var $name;
	var $description;

	/* Type()
	 * Class constructor.
	 *
	 * Parameters: id: Type ID.
	 * Returns: Type object.
	 */
	function Type($id) {
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
	 * Returns: Item object with the new item, or false on failure.
	 */
	function AddItem($name, $price, $min, $max, $restriction, $description, $limit) {
		global $db, $db_name, $prefix;
		//if (!(is_string($name) && is_numeric($price) && is_numeric($min) && is_numeric($max) && is_numeric($required) && is_string($description) && is_numeric($limit))) return false;
		$name = addslashes($name);
		$description = addslashes($description);
		if (mysql_db_query($db_name, 'INSERT INTO '.$prefix.'items (type, name, price, min, max, restriction, description, `limit`) VALUES ('.$this->id.", '$name', $price, $min, $max, $restriction, '$description', $limit)", $db)) return new Item(mysql_insert_id($db));
		else { echo mysql_error(); return false; }
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
	var $min;
	var $max;
	var $restriction;
	var $description;
	var $limit;

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
			$this->min = mysql_result($item_result, 0, 'min');
			$this->max = mysql_result($item_result, 0, 'max');
			$this->restriction = mysql_result($item_result, 0, 'restriction');
			$this->description = stripslashes(mysql_result($item_result, 0, 'description'));
			$this->limit = mysql_result($item_result, 0, 'limit');
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

	/* GetType()
	 * Gets the type of the item.
	 *
	 * Parameters: None.
	 * Returns: A Type object.
	 */
	function GetType() {
		return new Type($this->type);
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
	 *          defined under Type::GetItem.
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
		global $db, $db_name, $prefix;
		$ts_result = mysql_db_query($db_name, 'SELECT SUM(quantity) AS sales FROM '.$prefix.'sales WHERE item='.$this->id, $db);
		if ($ts_result && mysql_num_rows($ts_result)) return mysql_result($ts_result, 0, 'sales');
		else return 0;
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

	/* SetType()
	 * Changes the type of the item.
	 *
	 * Parameters: type: Either a Type object or an ID.
	 * Returns: True on success, false otherwise.
	 */
	function SetType($type) {
		global $db, $db_name, $prefix;
		if (is_object($type) && get_class($type) == 'type') $type = $type->GetID();
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
	 *                          Type::AddItem),
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

	/* Sell()
	 * Sells some of this item to a pleb. I've decided, for simplicity,
	 * that rather than adding a new sale for each purchase, we'll first
	 * check if the pleb has already bought this item before and, if so,
	 * simply update that sale to the new quantity.
	 *
	 * Parameters: person: A Person object for the pleb.
	 *             quantity: The number of items they're buying.
	 * Returns: A Sale object with the sale, or false on failure.
	 */
	function Sell($person, $quantity) {
		global $db, $db_name, $prefix, $str_name;
		if (get_class($person) != 'person' || !is_numeric($quantity)) return false;
		$past_sale = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'sales WHERE item='.$this->id.' AND owner='.$person->GetID(), $db);
		if ($this->limit > 0) {
			$quantity = 1;
			if ($past_sale && mysql_num_rows($past_sale)) {
				return false;
			}
		}
		$total_credits = $quantity * $this->price;
		if ($quantity != 1) $desc = number_format($quantity) . ' ' . $this->name . 's';
		else $desc = '1 ' . $this->name;
		$rank = $person->GetRank();
		if (($person->GetAccountBalance() < $total_credits && !$rank->IsUnlimitedCredits()) || !$this->CheckPerson($person) || ($this->limit > 0 && $this->GetTotalSales() >= $this->limit)) return false;
		if ($past_sale && mysql_num_rows($past_sale)) {
			$quantity += mysql_result($past_sale, 0, 'quantity');
			if (mysql_db_query($db_name, 'UPDATE '.$prefix."sales SET quantity=$quantity WHERE id=".mysql_result($past_sale, 0, 'id'), $db)) {
				$person->MakePurchase($total_credits, $str_name, $desc);
				return new Sale(mysql_result($past_sale, 0, 'id'));
			}
			else return false;
		}
		else {
			if (mysql_db_query($db_name, 'INSERT INTO '.$prefix.'sales (item, owner, quantity) VALUES ('.$this->id.', '.$person->GetID().", $quantity)", $db)) {
				$person->MakePurchase($total_credits, $str_name, $desc);
				return new Sale(mysql_insert_id($db));
			}
			else return false;
		}
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
			for ($i = 0; $i < count($sales); $sales[$i++]->Refund());
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
	var $owner;
	var $quantity;
	
	/* Sale()
	 * Class constructor.
	 *
	 * Parameters: Sale ID.
	 * Returns: Sale object.
	 */
	function Sale($id) {
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
		$sale_result = mysql_db_query($db_name, 'SELECT * FROM '.$prefix.'sales WHERE id='.$this->id, $db);
		if ($sale_result && mysql_num_rows($sale_result)) {
			$this->item = mysql_result($sale_result, 0, 'item');
			$this->owner = mysql_result($sale_result, 0, 'owner');
			$this->quantity = mysql_result($sale_result, 0, 'quantity');
		}
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

	/* GetQuantity()
	 * Returns the number of items bought by the pleb.
	 *
	 * Parameters: None.
	 * Returns: The quantity of items sold.
	 */
	function GetQuantity() {
		return $this->quantity;
	}

	/* SetOwner()
	 * Transfers ownership of the stuff to someone else. No credit
	 * adjustment is performed by this function, so if you're implementing
	 * a second-hand sale system, you'll need to alter people's credits
	 * yourself.
	 *
	 * Parameters: person: Person object for the new owner.
	 * Returns: True on success, false otherwise.
	 */
	function SetOwner($person) {
		global $db, $db_name, $prefix;
		if (get_class($person) != 'person') return false;
		if (mysql_db_query($db_name, 'UPDATE '.$prefix.'sales SET owner='.$person->GetID().' WHERE id='.$this->id, $db)) {
			$this->UpdateCache();
			return true;
		}
		else return false;
	}

	/* SetQuantity()
	 * Changes the quantity of the sale.
	 *
	 * Parameters: quantity: New quantity.
	 *             credits: True to change credits appropriately, false to
	 *                      leave them alone.
	 * Returns: True on success, false otherwise.
	 */
	function SetQuantity($quantity, $credits = true) {
		global $db, $db_name, $prefix, $roster, $str_name;
		if (!is_numeric($quantity)) return false;
		$total_credits = 0;
		$item = new Item($this->item);
		$pleb = $roster->GetPerson($this->owner);
		$change = abs($quantity - $this->quantity);
		if ($change != 1) $desc = number_format($change) . ' ' . $item->GetName() . 's';
		else $desc = '1 ' . $item->GetName();
		if ($credits) {
			$total_credits = ($quantity - $this->quantity) * $item->GetPrice();
			$rank = $pleb->GetRank();
			if ($total_credits > 0 && $pleb->GetAccountBalance() < $total_credits && !$rank->IsUnlimitedCredits()) return false;
		}
		if (mysql_db_query($db_name, 'UPDATE '.$prefix."sales SET quantity=$quantity WHERE id=".$this->id, $db)) {
			if ($credits) $pleb->MakePurchase($total_credits, $str_name, $desc);
			$this->UpdateCache();
			return true;
		}
		else return false;
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
	}

	/* Refund()
	 * Deletes a sale after adjusting the credits of the owner accordingly.
	 *
	 * Parameters: None.
	 * Returns: Nothing.
	 */
	function Refund() {
		$this->SetQuantity(0, true);
		$this->Delete();
	}

}

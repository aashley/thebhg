<?php
/* Basic usage template:
 * include('rss.php');
 * $backend = new Backend('http://www.thebhg.org/main/news-backend.php');
 * $channel = $backend->GetChannel();
 * // Do the things to do with the channel itself here. In this example, we merely output the title and a link.
 * echo '<U><A HREF="' . $channel->GetLink() . '">' . $channel->GetTitle() . '</A></U><BR>';
 * // Iterate through the news items.
 * $items = $channel->GetItems();
 * if ($items) {
 * 	foreach ($items as $item) {
 *		// Handle an individual item by displaying its title and a link to the article.
 * 		echo '<A HREF="' . $item->GetLink() . '">' . $item->GetTitle() . '</A><BR>';
 *	}
 * }
 */

/** A simple RSS 0.9.[12] parser.
 *
 * @package MyBHG
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @access public
 */
class Backend {
	/**
	 * @access private
	 */
	var $channel;

	/**
	 * Constructs the Backend object from the RSS URL given.
	 *
	 * @access public
	 * @param string url The URL to load the RSS data from.
	 */
	function Backend($url) {
		$file_data = file($url);
		$file = implode('', $file_data);
		$this->channel = new Channel($file);
	}

	/**
	 * Returns the RSS channel.
	 *
	 * @access public
	 * @return object Channel the Channel object.
	 */
	function GetChannel() {
		return $this->channel;
	}
}

/**
 * An RSS channel.
 *
 * @package MyBHG
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @access public
 */
class Channel {
	/**#@+
	 * @access private
	 */
	var $title, $link, $description, $language, $image, $copyright, $managingEditor, $webMaster, $rating, $pubDate, $lastBuildDate, $docs, $textInput, $items;
	/**#@-*/

	/**
	 * Constructs the channel object.
	 *
	 * @access private
	 * @param string file The file data to use.
	 */
	function Channel($file) {
		if (preg_match_all('"<item(>| (.*?)>)(.*?)</item>"is', $file, $items_text)) {
			foreach ($items_text[3] as $it) {
				$this->items[] = new Item($it);
			}
		}

		$file = preg_replace('"<item(>| (.*?)>)(.*?)</item>"is', '', $file);

		if (preg_match('"<title>(.*?)</title>"is', $file, $matches)) {
			$this->title = $matches[1];
		}
		if (preg_match('"<link>(.*?)</link>"is', $file, $matches)) {
			$this->link = $matches[1];
		}
		if (preg_match('"<description>(.*?)</description>"is', $file, $matches)) {
			$this->description = $matches[1];
		}
		if (preg_match('"<language>(.*?)</language>"is', $file, $matches)) {
			$this->language = $matches[1];
		}
		if (preg_match('"<image>(.*?)</image>"is', $file, $matches)) {
			$this->image = new Image($matches[1]);
		}
		if (preg_match('"<copyright>(.*?)</copyright>"is', $file, $matches)) {
			$this->copyright = $matches[1];
		}
		if (preg_match('"<managingEditor>(.*?)</managingEditor>"is', $file, $matches)) {
			$this->managingEditor = $matches[1];
		}
		if (preg_match('"<webMaster>(.*?)</webMaster>"is', $file, $matches)) {
			$this->webMaster = $matches[1];
		}
		if (preg_match('"<rating>(.*?)</rating>"is', $file, $matches)) {
			$this->rating = $matches[1];
		}
		if (preg_match('"<pubDate>(.*?)</pubDate>"is', $file, $matches)) {
			$this->pubDate = $matches[1];
		}
		if (preg_match('"<lastBuildDate>(.*?)</lastBuildDate>"is', $file, $matches)) {
			$this->lastBuildDate = $matches[1];
		}
		if (preg_match('"<docs>(.*?)</docs>"is', $file, $matches)) {
			$this->docs = $matches[1];
		}
		if (preg_match('"<textInput>(.*?)</textInput>"is', $file, $matches)) {
			$this->textInput = new TextInput($matches[1]);
		}
	}

	/**
	 * Returns the title of the channel.
	 *
	 * @access public
	 * @return string the title.
	 */
	function GetTitle() {
		return $this->title;
	}

	/**
	 * Returns the URL of the channel.
	 *
	 * @access public
	 * @return string the URL.
	 */
	function GetLink() {
		return $this->link;
	}

	/**
	 * Returns the description for the channel.
	 *
	 * @access public
	 * @return string the description.
	 */
	function GetDescription() {
		return $this->description;
	}

	/**
	 * Returns the language of the channel.
	 *
	 * @access public
	 * @return string the language.
	 */
	function GetLanguage() {
		return $this->language;
	}

	/**
	 * Returns the image for the channel.
	 *
	 * @access public
	 * @return string the image.
	 */
	function GetImage() {
		return $this->image;
	}

	/**
	 * Returns the copyright information for the channel.
	 *
	 * @access public
	 * @return string the information.
	 */
	function GetCopyright() {
		return $this->copyright;
	}

	/**
	 * Returns the managing editor of the channel.
	 *
	 * @access public
	 * @return string the managing editor.
	 */
	function GetManagingEditor() {
		return $this->managingEditor;
	}

	/**
	 * Returns the webmaster of the channel.
	 *
	 * @access public
	 * @return string the webmaster.
	 */
	function GetWebMaster() {
		return $this->webMaster;
	}

	/**
	 * Returns the parental rating for the channel.
	 *
	 * @access public
	 * @return string the rating.
	 */
	function GetRating() {
		return $this->rating;
	}

	/**
	 * Returns the publication date of the channel.
	 *
	 * @access public
	 * @return string the date.
	 */
	function GetPubDate() {
		return $this->pubDate;
	}

	/**
	 * Returns the last build date of the channel.
	 *
	 * @access public
	 * @return string the date.
	 */
	function GetLastBuildDate() {
		return $this->lastBuildDate;
	}

	/**
	 * ???
	 *
	 * @access public
	 * @return string ???
	 * @todo Needs documentation.
	 */
	function GetDocs() {
		return $this->docs;
	}

	/**
	 * ???
	 *
	 * @access public
	 * @return string ???
	 * @todo Needs documentation.
	 */
	function GetTextInput() {
		return $this->textInput;
	}

	/**
	 * Returns the items within the channel.
	 *
	 * @access public
	 * @return array the items.
	 */
	function GetItems() {
		return $this->items;
	}
}

/**#@+
 * The Image class.
 *
 * @package MyBHG
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @access public
 * @todo Needs documentation.
 */
class Image {
	var $url, $title, $link, $width, $height, $description;

	function Image($image) {
		if (preg_match('"<url>(.*?)</url>"is', $image, $matches)) {
			$this->url = $matches[1];
		}
		if (preg_match('"<title>(.*?)</title>"is', $image, $matches)) {
			$this->title = $matches[1];
		}
		if (preg_match('"<link>(.*?)</link>"is', $image, $matches)) {
			$this->link = $matches[1];
		}
		if (preg_match('"<width>(.*?)</width>"is', $image, $matches)) {
			$this->width = $matches[1];
		}
		if (preg_match('"<height>(.*?)</height>"is', $image, $matches)) {
			$this->height = $matches[1];
		}
		if (preg_match('"<description>(.*?)</description>"is', $image, $matches)) {
			$this->description = $matches[1];
		}
	}

	function GetURL() {
		return $this->url;
	}

	function GetTitle() {
		return $this->title;
	}

	function GetLink() {
		return $this->link;
	}

	function GetWidth() {
		return $this->width;
	}

	function GetHeight() {
		return $this->height;
	}

	function GetDescription() {
		return $this->description;
	}
}
/**#@-*/

class Item {
	/**#@+
	 * @access private
	 */
	var $title, $link, $description;
	/**#@-*/

	/**
	 * Constructs an Item object.
	 *
	 * @access private
	 * @param string item The Item XML data.
	 */
	function Item($item) {
		if (preg_match('"<title>(.*?)</title>"is', $item, $matches)) {
			$this->title = $matches[1];
		}
		if (preg_match('"<link>(.*?)</link>"is', $item, $matches)) {
			$this->link = $matches[1];
		}
		if (preg_match('"<description>(.*?)</description>"is', $item, $matches)) {
			$this->description = $matches[1];
		}
	}

	/**
	 * Returns the title of the item.
	 *
	 * @access public
	 * @return string the title.
	 */
	function GetTitle() {
		return $this->title;
	}

	/**
	 * Returns the URL for the item.
	 *
	 * @access public
	 * @return string the URL.
	 */
	function GetLink() {
		return $this->link;
	}

	/**
	 * Returns the description for the item.
	 *
	 * @access public
	 * @return string the description.
	 */
	function GetDescription() {
		return $this->description;
	}
}

/**#@+
 * The TextInput class.
 *
 * @access public
 * @package MyBHG
 * @author Jernai Teifsel <jernai@iinet.net.au>
 * @todo Needs documentation.
 */
class TextInput {
	var $title, $description, $name, $link;

	function TextInput($input) {
		if (preg_match('"<title>(.*?)</title>"is', $input, $matches)) {
			$this->title = $matches[1];
		}
		if (preg_match('"<description>(.*?)</description>"is', $input, $matches)) {
			$this->description = $matches[1];
		}
		if (preg_match('"<name>(.*?)</name>"is', $input, $matches)) {
			$this->name = $matches[1];
		}
		if (preg_match('"<link>(.*?)</link>"is', $input, $matches)) {
			$this->link = $matches[1];
		}
	}
	
	function GetTitle() {
		return $this->title;
	}
	
	function GetDescription() {
		return $this->description;
	}
	
	function GetName() {
		return $this->name;
	}
	
	function GetLink() {
		return $this->link;
	}
}
/**@#-*/
?>

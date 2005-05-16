<?php
include_once 'HTML/QuickForm.php';
include_once 'modules/Base.php';

class Module_Administration extends Module_Base {
	private $content;
	private $file;
	private $menu;
	private $title;
	private $user;

	public function __construct($path) {
		parent::__construct($path);

		$this->content = $GLOBALS['content'];
		$this->file = null;
		$this->menu = new Scum_Menu;
		$this->title = 'Administration';
	}
	
	public function output() {
		$this->user = new Login_HTTP(SCUM_CODER);
		if (!($this->user->IsValid() && $this->isAdmin($this->user))) {
			if (isset($_GET['retry'])) 
				$this->verboten();
			else {
				$this->header();
				header('Location: '.$_SERVER['REQUEST_URI'].'?retry');
				$this->footer();
			}
		}
		
		if (strpos($this->path, 'menu/add') !== false)
			$this->menuAdd();
		elseif (strpos($this->path, 'menu/edit') !== false)
			$this->menuEdit();
		elseif (strpos($this->path, 'menu/delete') !== false)
			$this->menuDelete();
		elseif (strpos($this->path, 'menu/up') !== false)
			$this->menuUp();
		elseif (strpos($this->path, 'menu/down') !== false)
			$this->menuDown();
		elseif (strpos($this->path, 'menu') !== false)
			$this->menu();
		if (strpos($this->path, 'content/add') !== false)
			$this->contentAdd();
		elseif (strpos($this->path, 'content/edit') !== false)
			$this->contentEdit();
		elseif (strpos($this->path, 'content/delete') !== false)
			$this->contentDelete();
		elseif (strpos($this->path, 'content') !== false)
			$this->content();
		else
			$this->index();
	}

	public function title() {
		return $this->title;
	}

	private function index() {
		$this->header();
?>
<h1>Administration</h1>
<p>
	<a href="/administration/content">Administer Content</a>
	<br />
	<a href="/administration/menu">Administer Menu Items</a>
</p>
<?php
		$this->footer();
	}

	private function verboten() {
		$this->title = 'Forbidden';
		$this->header();
		header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
?>
<h1>Forbidden</h1>
<p>You do not have permission to access this page.</p>
<?php
		$this->footer();
	}

	private function menu() {
		$this->title = 'Menu Administration';
		$this->header();

?>
<h1>Menu Administration</h1>
<p><a href="/administration/menu/add">Add New Item</a></p>
<table>
<tr><th>Name</th><th>Link</th><th colspan="4">&nbsp;</th></tr>
<?php
		foreach ($this->menu->getItems() as $item) {
			echo '<tr>'
			    .'<td>'.htmlspecialchars($item->getName()).'</td>'
			    .'<td>'.htmlspecialchars($item->getLink()).'</td>'
			    .'<td><a href="/administration/menu/edit?id='.$item->getID().'">Edit</a></td>'
			    .'<td><a href="/administration/menu/delete?id='.$item->getID().'">Delete</a></td>'
			    .'<td><a href="/administration/menu/up?id='.$item->getID().'">Move Up</a></td>'
			    .'<td><a href="/administration/menu/down?id='.$item->getID().'">Move Down</a></td>'
			    .'</tr>';
		}
?>
</table>
<?php
		
		$this->footer();
	}

	private function menuForm($target) {
		$form = new HTML_QuickForm('menu/'.time(), 'post', $target);
		
		$form->addElement('text', 'name', 'Name:');
		$form->addElement('text', 'link', 'Link to:');
		$form->addElement('submit', null, 'Save');

		$form->addRule('name', 'A name must be provided.', 'required', null, 'client');
		$form->addRule('link', 'A URI to link to must be provided.', 'required', null, 'client');
		
		return $form;
	}

	private function menuAdd() {
		$this->title = 'Add Menu Item';
		$this->header();
		echo '<h1>Add Menu Item</h1>';

		$form = $this->menuForm('/administration/menu/add');
		if ($form->validate()) {
			$values = $form->exportValues();
			if ($this->menu->addItem($values['name'], $values['link']))
				header('Location: /administration/menu');
		}
		else
			$form->display();

		$this->footer();
	}

	private function menuEdit() {
		$item = $this->menu->getItem($_GET['id']);
		$this->title = 'Edit Menu Item';
		$this->header();
		echo '<h1>Edit Menu Item</h1>';

		$form = $this->menuForm('/administration/menu/edit?id='.$item->getID());
		$form->setDefaults(array('name' => $item->getName(), 'link' => $item->getLink()));
		if ($form->validate()) {
			$values = $form->exportValues();
			if ($item->setName($values['name']) && $item->setLink($values['link']))
				header('Location: /administration/menu');
		}
		else
			$form->display();

		$this->footer();
	}

	private function menuDelete() {
		$item = $this->menu->getItem($_GET['id']);
		$this->header();
		echo '<h1>Delete Menu Item</h1>';
		
		if (isset($_GET['confirm'])) {
			if ($item->delete())
				header('Location: /administration/menu');
		}
		else {
?>
<p>Are you sure that you want to delete the menu item '<?php echo htmlspecialchars($item->getName()); ?>'?</p>
<p><a href="/administration/menu/delete?id=<?php echo $item->getID(); ?>&amp;confirm=yes">Yes</a> | <a href="/administration/menu">No</a></p>
<?php
		}
		
		$this->footer();
	}

	private function menuUp() {
		$item = $this->menu->getItem($_GET['id']);
		$this->header();
		if ($item->moveUp())
			header('Location: /administration/menu');
		$this->footer();
	}

	private function menuDown() {
		$item = $this->menu->getItem($_GET['id']);
		$this->header();
		if ($item->moveDown())
			header('Location: /administration/menu');
		$this->footer();
	}

	private function content() {
		$this->title = 'Content Administration';
		$this->header();

?>
<h1>Content Administration</h1>
<p><a href="/administration/content/add">Add New Page</a></p>
<table>
<tr><th>Name</th><th>Type</th><th colspan="2">&nbsp;</th></tr>
<?php
		foreach ($this->content->getPages() as $page) {
			echo '<tr>'
			    .'<td>'.htmlspecialchars($page->getName()).'</td>'
			    .'<td>'.htmlspecialchars($page->getType()).'</td>'
			    .'<td><a href="/administration/content/edit?name='.urlencode($page->getName()).'">Edit</a></td>'
			    .'<td><a href="/administration/content/delete?name='.urlencode($page->getName()).'">Delete</a></td>'
			    .'</tr>';
		}
?>
</table>
<?php
		
		$this->footer();
	}

	private function contentForm($target, $page = null) {
		$form = new HTML_QuickForm('content/'.time(), 'post', $target);
		
		$form->addElement('text', 'name', 'Name:', array('size' => 60));

		$defaults = array();
		if ($page instanceof Scum_Page) {
			$defaults['name'] = $page->getName();
			if (strpos($page->getType(), 'text/') !== false)
				$defaults['html'] = $page->getContent();
		}

		if (is_null($page) || strpos($page->getType(), 'text/') !== false)
			$form->addElement('textarea', 'html', 'Content:', array('rows' => 30, 'cols' => 80));

		$form->setMaxFileSize(2147483648);
		$this->file = $form->addElement('file', 'file', 'File:');

		$form->addElement('static', null, 'Note 1:', 'You may upload a file or paste in some content here. If you upload a file, any other content will be ignored.');
		$form->addElement('static', null, 'Note 2:', 'The first page users see when they come to the site should be named "default".');
		
		$form->addElement('submit', null, 'Save');

		$form->addRule('name', 'A name must be provided.', 'required', null, 'client');

		$form->setDefaults($defaults);
		
		return $form;
	}

	private function contentTypeSniff($content) {
		if ($info = @getimagesize($content))
			return image_type_to_mime_type($info[2]);
		else
			return false;
	}

	private function contentAdd() {
		$this->title = 'Add Content Page';
		$this->header();
		echo '<h1>Add Content Page</h1>';

		$form = $this->contentForm('/administration/content/add');
		if ($form->validate()) {
			$values = $form->exportValues();
			if ($this->file->isUploadedFile()) {
				$fValue = $this->file->getValue();
				print_r($fValue);
				$content = file_get_contents($fValue['tmp_name']);
				$type = $this->contentTypeSniff($content);
				if ($type === false)
					$type = $fValue['type'];
			}
			else {
				$content = $values['html'];
				$type = 'text/html';
			}
			if ($this->content->addPage($values['name'], $content, $type))
				header('Location: /administration/content');
		}
		else
			$form->display();

		$this->footer();
	}

	private function contentEdit() {
		$page = $this->content->getPage($_GET['name']);
		$this->title = 'Edit Content Page';
		$this->header();
		echo '<h1>Edit Content Page</h1>';

		$form = $this->contentForm('/administration/content/edit?name='.urlencode($page->getName()), $page);
		if ($form->validate()) {
			$values = $form->exportValues();
			$status = $page->setName($values['name']);
			if ($this->file->isUploadedFile()) {
				$fValue = $this->file->getValue();
				print_r($fValue);
				$content = file_get_contents($fValue['tmp_name']);
				$type = $this->contentTypeSniff($content);
				if ($type === false)
					$type = $fValue['type'];

				$status = $status && $page->setContent($content);
				$status = $status && $page->setType($type);
			}
			elseif (isset($values['html']))
				$status = $status && $page->setContent($values['html']);
			
			if ($status)
				header('Location: /administration/content');
		}
		else
			$form->display();

		$this->footer();
	}

	private function contentDelete() {
		$page = $this->content->getPage($_GET['name']);
		$this->header();
		echo '<h1>Delete Content Page</h1>';
		
		if (isset($_GET['confirm'])) {
			if ($page->delete())
				header('Location: /administration/content');
		}
		else {
?>
<p>Are you sure that you want to delete the content page '<?php echo htmlspecialchars($page->getName()); ?>'?</p>
<p><a href="/administration/content/delete?name=<?php echo urlencode($page->getName()); ?>&amp;confirm=yes">Yes</a> | <a href="/administration/content">No</a></p>
<?php
		}
		
		$this->footer();
	}
}
?>

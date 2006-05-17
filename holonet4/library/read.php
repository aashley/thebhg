<?php

class page_library_read extends holonet_page {

	public function buildPage() {

		$this->pageBuilt = true;

		list($obj) = $this->getTrailingElements();

		if ($obj instanceof bhg_library_book) {

			$this->renderBook($obj);

		} elseif ($obj instanceof bhg_library_chapter) {

			$this->renderChapter($obj);

		}

		$this->addSideMenu($GLOBALS['holonet']->library->getBookMenu());

	}

	public function renderBook(bhg_library_book $book) {

		$this->setTitle($book->getName());

		$this->addBodyContent('<div class="center"><img src="/library/image/'.$book->getID().'" alt="Book Cover Image" /></div>');

		$this->addBodyContent('<p>'.$book->getDescription().'</p>');

		$chapters = $book->getChapters();

		if ($chapters->count() > 0) {

			$this->addBodyContent('<ol>');

			foreach ($chapters as $chapter) {

				$this->addBodyContent('<li>'.holonet::output($chapter).'</li>');

			}

			$this->addBodyContent('<ol>');

		}

	}

	public function renderChapter(bhg_library_chapter $chapter) {

		$this->setTitle($chapter->getBook()->getName().' :: '.$chapter->getName());

		$sections = $chapter->getSections();

		if ($sections->count() > 0) {

			foreach ($sections as $section) {

				$this->addBodyContent('<a name="'.$section->getID().'"></a>');

				if (strlen($section->getName()) > 0)
					$this->addBodyContent('<h2>'.$section->getName().'</h2>');

				if ($section->isHtml()) {

					$this->addBodyContent($section->getContent());

				} else {
					
					$this->addBodyContent('<p>'.$section->getContent().'</p>');

				}

			}

		}

	}

}

?>

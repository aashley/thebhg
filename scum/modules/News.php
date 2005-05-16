<?php
include_once 'modules/Base.php';

class Module_News extends Module_Base {
	private $news;

	public function __construct($path) {
		parent::__construct($path);

		$this->news = new News(SCUM_CODER);
	}
	
	public function output() {
		global $sections;

		$this->header();
		echo '<h1>News</h1>';
		
		$items = $this->news->GetNews(5, 'posts', $sections);
		if (count($items)) {
			echo '<table class="news">';
			foreach ($items as $item)
				echo $item->Render('<tr><th>%topic%</th></tr><tr><td class="message">%message%</td></tr><tr><td class="poster">Posted by %poster_name% on %date%.</td></tr>');
			echo '</table>';
		}
		else
			echo 'No news has been found.';

		$this->footer();
	}

	public function title() {
		return 'News';
	}
}
?>

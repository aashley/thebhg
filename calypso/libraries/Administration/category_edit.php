<?php 

	$system = $this->get_template_vars ('system');

	$style_obj = new Style (8);
	$css = $style_obj->GetContent();
	$this->assign ('css', $css);

	$login_obj = new Login_HTTP ();
	$blog_obj = new Blog ($login_obj->GetID ());
	$person_obj = $blog_obj->GetPerson();
	$blogURL = $system["home"] . $blog_obj->GetLinktitle() . "/";

	if (is_numeric($person_obj->GetID()))
		$foaf = 1;
	else
		$foaf = 0;

	if (strlen($blog_obj->GetICBM()) > 0)
		$geourl = 1;
	else
		$geourl = 0;

	$blog = array (
		"foaf"          => $foaf,
		"geourl"        => $geourl,
		"icbm"          => $blog_obj->GetICBM(),
		"title"         => $blog_obj->GetTitle(),
		"description"   => $blog_obj->GetDescription(),
		"url"           => $blogURL,
		"owner"         => $person_obj->GetName(),
		"ownerid"       => $person_obj->GetID()
	);
	$this->assign ('blog', $blog);

	$category_obj = new Category ($_REQUEST["category"], $login_obj->GetID());
	if (isset ($_POST["Modify"]))
	{
		$category_obj->SetTitle ($_POST["title"]);
		$_REQUEST["category"] = $category_obj->GetTitleword();
	}
	elseif (isset ($_POST["Delete"])) 
		$category_obj->Delete();

	$category_obj = new Category ($_REQUEST["category"], $login_obj->GetID());
	$category = array (
		"id"    => $category_obj->GetID(),
		"name"  => $category_obj->GetTitle(),
		"short" => $category_obj->GetTitleword()
	);
	$this->assign ('category', $category);
?>

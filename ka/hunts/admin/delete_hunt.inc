<?php
$hunt = $ka->GetHunt($_GET['id']);
$hunt_type = $hunt->GetHuntType();
?>
<div>
<h2>Deleting Hunt</h2>
<p>Final confirmation</p>
</div>
<?php
if (isset($_POST['delete'])) {
    if ($hunt->RemoveHunt() === true) {
        echo "<br /><br /><p style=\"text-align: center\">Hunt deleted successfully</p>";
    } else {
        echo "<br /><br /><p style=\"text-align: center\">Error deleting Hunt</p>";
    }
    echo "<p><a href=\"".$_SERVER['PHP_SELF']."\">Return to Admin</a></p>";
} else {
    //Confirmation to remove
    echo "<div>\n"
        . "<p>Are you sure you want to delete the ".$hunt_type->GetName()." ".$hunt->GetHuntNum()." hunt?</p>\n";
    $table = new HTML_Table();
    $table->setCaption("Confirm delete.");
    $table->AddRow(array(   '<form action="'.$_SERVER['REQUEST_URI'].'" method="post"><input type="submit" name="delete" value="Yes" /></form>',
                            '<form action="'.$_SERVER['PHP_SELF'].'" method="post"><input type="submit" name="" value="No" /></form>'));
    echo $table->toHTML()
        . "\n</div>\n";
}
?>
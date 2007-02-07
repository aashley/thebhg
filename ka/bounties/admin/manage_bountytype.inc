<?php /* To fool Vim */ ?>
<div>
<h2>Kabal Authority Bounty Types Administration</h2>
<p>This is the place to manage all the bounty types, which are the main templates from which each and every bounty is formed.
Be careful when you edit things as it affects all future bounties and sometimes all the past bounties too.</p>
</div>
<?php
$tblhead = array(
    'Bounty Type',
    'Number of Questions',
    'Number of Answers',
    'Functions'
    );
$tblheadattr = array(
    'style'=>'font-weight: bold'
    );
?>
<!--Hunt Types Table Start-->
<?php
$table = new HTML_Table();
$table->setCaption("Bounty Types Admin");
$hunttypes = $ka->GetHuntTypes();
$table->AddRow(
    $tblhead,
    $tblheadattr,
    'TH'
    );
foreach ($hunttypes as $hunt_type) {
    $table->AddRow(
        array(
            $hunt_type->GetName(),
            $hunt_type->GetNumQuestions(),
            $hunt_type->GetNumAnswers(),
            "<a href=\"".$_SERVER['PHP_SELF']."?site=modify_bountytype&amp;id=".$hunt_type->GetID()."\">Edit</a>"
            . "&nbsp;&nbsp;"
            . "<a href=\"".$_SERVER['PHP_SELF']."?site=delete_bountytype&amp;id=".$hunt_type->GetID()."\">Delete</a>"
        )
    );
}
echo $table->toHTML();
?>
<!--Hunt Types Table End-->
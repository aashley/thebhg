<?php
$login = new Login_HTTP();
$login_position = $login->GetPosition();
$pos = $login_position->GetID();
$login_division = $login->GetDivision();
$div = $login_division->GetID();
if (($pos != 10) && ($pos != 11) && ($pos != 12) && ($div != 10) && ($div != 9)) {
    echo 'You are not allowed to view this page.';
    ConstructLayout();
    exit();
}
?>
<h2>Kabal Website Manual</h2>
<script type="text/javascript" src="external.js"></script>
<?php
$title = "Kabal Website Manual";
$roster = new Roster();
$synth = $roster->GetPerson(1768);
$skor = $roster->GetPerson(1699);
$ehart = $roster->GetPerson(45);
echo '<p style="font-style: italic">Version 1.1.0 Written and revised by <a href="mailto:'.$synth->GetEmail().'">'.$synth->GetName().'</a><br />';
echo 'Version 1.0.0 Written by <a href="mailto:'.$skor->GetEmail().'">'.$skor->GetName().'</a>, with guidelines set forth by <a href="mailto:'.$ehart->GetEmail().'">'.$ehart->GetName().'</a>.<br />';
echo 'All content herein is said to be official BHG rules.</p>';
?>

<p style="text-align: center; font-size: 14pt; font-weight: bold">Contents:</p>
<p style="text-align: center; font-size: 10pt; font-style: italic">(As of Version 1.1.0)</p>
<ul style="list-style-type: none">
<li><p style="text-align: center; font-weight: bold"><a href="#c1">Actual Site Contents</a></p></li>
<li><p style="text-align: left"><a href="#c1.1">1.1 - Required Items</a></p></li>
<li><p style="text-align: left"><a href="#c1.2">1.2 - Suggested Items</a></p></li>
<li><p style="text-align: center; font-weight: bold"><a href="#c2">The Monthly Mandatory</a></p></li>
<li><p style="text-align: left"><a href="#c2.1">2.1 - The Scale</a></p></li>
<li><p style="text-align: left"><a href="#c2.2">2.2 - Explanation</a></p></li>
</ul>


<p style="text-align: left; font-size: 16pt; font-weight: bold"><a id="c1">Actual Site Contents</a></p>
<p style="text-align: left; font-size: 12pt; font-weight: bold; font-style: italic"><a id="c1.1">1.1 - Required Items:</a></p>
<p style="text-align: left; font-size: 10pt">
By order of <?php
$spe = $roster->GetPosition(5);
echo $spe->GetName().' ';
$spe_arr = $roster->SearchPosition($spe);
$sp = $spe_arr[0];
echo $sp->GetName();
?> and <?php
$judi = $roster->GetPosition(6);
echo $judi->GetName().' ';
$judi_arr = $roster->SearchPosition($judi);
$jud = $judi_arr[0];
echo $jud->GetName();
?>, to remain in office a chief of any given kabal must maintain a current,
up to date kabal website containing all relevant information pertaining to and deemed necessary by the kabal itself.
For a kabal site to be deemed satisfactory, it must pass several tests as listed under
section 2.1 - &quot;the scale&quot;. Kabal websites have both requirements and suggestions.
The following are the core requirements needed to recieve a decent grade.</p>
<br />

<ul>
<li>An active news page (News script should be set up. If not already, please contact the Specialist ASAP to set it up.)</li>
<li>A page listing the current hierarchy of the kabal (with the respective contact details for each member listed)</li>
<li>A link to the KA/kabal hunts, or a script that retrieves the current hunts from the KA hunts.</li>
<li>A links page (linking to both BHG and EH-wide websites)</li>
<li>All pages must contain a link to the EH disclaimers and privacy policy.<br />
&nbsp; &nbsp; Disclaimer: <a href="http://www.emperorshammer.org/disclaim.htm" rel="external">http://www.emperorshammer.org/disclaim.htm</a><br />
&nbsp; &nbsp; Privacy Policy: <a href="http://www.emperorshammer.org/privacy.htm" rel="external">http://www.emperorshammer.org/privacy.htm</a><br />
</li>
</ul>

<br />
<p>Whilst each chief is expected to take care of the website, he/she may enlist the help of his/her CRA and/or help internal to the kabal
(for example, a gifted web designer). If you have any queries regarding this section, please contact the
<?php echo '<a href="mailto:'.$jud->GetEmail().'">'.$judi->GetName().', '.$jud->GetName().'</a>'; ?>, or the
<?php echo '<a href="mailto:'.$sp->GetEmail().'">'.$spe->GetName().', '.$sp->GetName().'</a>'; ?>.</p>

<p style="text-align: left; font-size: 12pt; font-weight: bold; font-style: italic"><a id="c1.2">1.2 - Suggested Items:</a></p>
<p style="text-align: left; font-size: 10pt">
In addition to the core requirements listed in Section 1.1,
there are many other things chief's and their kabal members can do worth mentioning on the kabal website.
They include, but are not limited to:</p>


<ul>
<li>A library, documenting kabal texts/other things important to kabal history or otherwise</li>
<li>An archive of reports, documents and/or past event submissions.</li>
<li>If &quot;teams&quot; exist within the kabal, links to the respective sites for each &quot;team&quot;</li>
<li>A link to the kabal message board, if not already in the links section</li>
<li>A current, up-to-date roster of the kabal</li>
<li>All pages are strongly recommended to be compliant to <a href="http://www.w3.org/TR/xhtml1" rel="external">XHTML 1.0</a> or <a href="http://www.w3.org/TR/xhtml11" rel="external">XHTML 1.1</a> and <a href="http://www.w3.org/TR/CSS1" rel="external">CSS 1</a> or <a href="http://www.w3.org/TR/CSS2/" rel="external">CSS 2</a> standards.
Why you ask? Well, because we encourage people to practice good habits when coding, and especially for those people
who are just trying to design their first website or learn (X)HTML, its better to start them off on the right path,
rather than let them learn the wrong way and then try to correct them later on.<br />
&nbsp; &nbsp; (X)HTML Validator: <a href="http://validator.w3.org/" rel="external">http://validator.w3.org/</a><br />
&nbsp; &nbsp; CSS Validator: <a href="http://jigsaw.w3.org/css-validator/" rel="external">http://jigsaw.w3.org/css-validator/</a><br />
</li>
</ul>

<p>These sort of things will win you favour with the SP/JUD, and will ensure that your mark out of 5
(explained later) is as good as possible. Again, if you have any queries,
contact <?php echo '<a href="mailto:'.$jud->GetEmail().'">'.$judi->GetName().' '.$jud->GetName().'</a>'; ?> or
<?php echo '<a href="mailto:'.$sp->GetEmail().'">'.$spe->GetName().' '.$sp->GetName().'</a>'; ?> for details.</p>

<p style="text-align: left; font-size: 16pt; font-weight: bold"><a id="c2">The Monthly Mandatory</a></p>
<p style="text-align: left; font-size: 12pt; font-weight: bold; font-style: italic"><a id="c2.1">2.1 - The Scale</a></p>
<ul style="list-style-type: none">
<li>
<p>0 - <a href="#e0" style="font-style: italic">Death Imminent</a></p>
</li>
<li>
<p>1 - <a href="#e1" style="font-style: italic">Highly Unsatisfactory</a></p>
</li>
<li>
<p>2 - <a href="#e2" style="font-style: italic">Unsatisfactory</a></p>
</li>
<li>
<p>3 - <a href="#e3" style="font-style: italic">Acceptable</a></p>
</li>
<li>
<p>4 - <a href="#e4" style="font-style: italic">Very Good</a></p>
</li>
<li>
<p>5 - <a href="#e5" style="font-style: italic">Exceptionally Good</a></p>
</li>
</ul>
<br />
<p style="text-align: left; font-size: 12pt; font-weight: bold; font-style: italic"><a id="c2.2">2.2 - Explanation</a></p>

<p style="text-align: left; font-size: 10pt; font-weight: bold; text-decoration: underline"><a id="e0">0 - Death Imminent:</a></p>

<p style="text-align: left; font-size: 10pt">
As the name would suggest, if you score this two months in a row, you'll be approached by the Specialist
and the Judicator and questioned as to what is going on, and whether or not you'd like to remain in the job.
This site rank means that nothing is happening, and that the site is lying dormant, with no news (or perhaps one every couple of months).
No content to speak of, and you lack most, if not all of the required items. You haven't touched your kabal hunts page in a while.
</p>

<p style="text-align: left; font-size: 10pt; font-weight: bold; text-decoration: underline"><a id="e1">1 - Highly Unsatisfactory</a></p>

<p style="text-align: left; font-size: 10pt">
Again, as the name would suggest, you're not doing a very good job of maintaining your kabal's website.
Two months of this, and you'll be answering to the Specialist or Judicator.
In order to achieve a mark of one, the Chief will have to have done a very laid-back, lazy job of maintaining the site.
If news is actually posted, it will be rare (around 1-2 times a month).
The site includes some of the required items, and maybe one of the optional items, but not nearly enough.
The kabal hunts are generally updated once a month or less and generally not enough work has been seen from the Chief.
</p>

<p style="text-align: left; font-size: 10pt; font-weight: bold; text-decoration: underline"><a id="e2">2 - Unsatisfactory</a></p>

<p style="text-align: left; font-size: 10pt">
You've been a bad girl/boy, and the Judicator and Specialist aren't particularly happy with your efforts on
maintaining your kabal website. Whilst the news you've got there is fairly good, you're only making 3 or 4 posts a month,
which is nowhere near enough. You should be making a post every time you get a new member, every time a kabal
member goes up in the ranks or receives a medal, or every time a kabal member does something worthy of mention!
Your site may be missing a few of the required items and it may have one or two of the optional ones, but still not
enough content. You always have a set of kabal hunts running but only 3 or less types of activities are availiable per set.
</p>

<p style="text-align: left; font-size: 10pt; font-weight: bold; text-decoration: underline"><a id="e3">3 - Satisfactory</a></p>

<p style="text-align: left; font-size: 10pt">
Your site is adequate, and has been ratified by the Specialist as being worthy of your CH paycheck.
You've updated the news page 5-6 times a month (at least), documenting most of the events that occur to your kabal.
Your site hasn't actually changed much since last month, but it includes all of the required items but only a few of the optional items.
You always have some sort of kabal hunts availiable and have an acceptable diversity of hunt types.
Be it known, though, that the Specialist and Judicator are still quite happy with the job you've done.
</p>

<p style="text-align: left; font-size: 10pt; font-weight: bold; text-decoration: underline"><a id="e4">4 - Very Good</a></p>

<p style="text-align: left; font-size: 10pt">
Your kabal website is of a high standard; you've implemented many of the things listed as optional
and all of the required items. Your news is updated at least once every couple of days with important information (1-2 times a week).
You have either made a major update to the content/layout of your site over the past month,
which only further demonstrates your activity and dedication to the kabal you lead, or you've shown exceptional
dedication to your kabal by maintaining a large number of hunts each week.
Congratulations! You've put a smile on your Specialist and Judicator's faces.
</p>

<p style="text-align: left; font-size: 10pt; font-weight: bold; text-decoration: underline"><a id="e5">5 - Exceptionally Good</a></p>

<p style="text-align: left; font-size: 10pt">
You truly are a shining example of what a chief should aspire to.
Not only are you doing everything you should as a chief, you have created a(nother) website for your kabal
this month and have updated the news at least 3 times a week!
You post everything from new members to promotions, from medals awarded to members (unfortunately) being promoted to CHs and CRAs elsewhere!
You have all the required items and have gone above and beyond the recommended content for the site.
You maintain hunts at all times and announce/list all activities available for the BHG and your kabal whenever
they appear. You always have kabal hunts availiable for your kabal and its very visible that you've put in a great deal of work into the BHG.
You can be sure that the Specialist and/or Judicator will be approaching you with the prospect of a bonus salary reward for doing such a good job!
</p>

<br />
<p style="text-align: left; font-size: 9pt; font-style: italic; font-family: 'Monotype Corsiva', cursive">
Last updated the Fourteenth day of January, Two Thousand and Four. &copy; &lt;MMIV&gt; SyNthetiC PaRadoX<br />
Licensed for use by the Emperor's Hammer.
</p>
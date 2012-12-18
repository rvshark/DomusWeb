<!-- html -->

<div id="expandableTreeContainer"></div>
<div id="chapEnableContainer"></div>
<div id="chaptersContainer"></div>
<br/><hr/><br/>
<div id="linksEnableContainer"></div>
<div id="linksContainer"></div>
<br/><hr/><br/>
<div id="elementsContainer"></div>

<br/><br/>
<table align="center">
<tr>
    <td colspan="3" align="center">
        <input type="submit" value="<?php print_string('savechanges'); ?>" />
    </td>
</tr>
</table>

<!-- (end) html -->




<script type="text/javascript">
//<![CDATA[
// --- read data from PHP -------------------------------------------------------------------------- //
var elements       = new Array();
var expandableTree = new Object();
var sectionNames   = new Array();

var chapEnable;
var oldChapNoForBlur;
var restoreChapNoOnBlur;
var chapters       = new Array();

var linksEnable;
var oldLinksNoForBlur;
var restoreLinksNoOnBlur;
var links          = new Array();
var icons          = new Array();

var otherInfo      = new Object();

// read elements
<?php foreach ($this->config['elements'] as $k => $element) { ?>
	elements[<?php echo $k; ?>]         = new Object();
	elements[<?php echo $k; ?>].id      = "<?php echo $element['id']; ?>";
	elements[<?php echo $k; ?>].name    = "<?php echo $element['name']; ?>";
	elements[<?php echo $k; ?>].url     = "<?php echo $element['url']; ?>";
	elements[<?php echo $k; ?>].icon    = "<?php echo $element['icon']; ?>";
	elements[<?php echo $k; ?>].canHide = "<?php echo $element['canHide']; ?>";
	elements[<?php echo $k; ?>].visible = "<?php echo $element['visible']; ?>";
<?php } ?>

// read expandableTree
expandableTree.enable = <?php echo $this->config['expandableTree']['enable']; ?>; 
expandableTree.text   = "<?php echo $expandableTreeText; ?>";

// section names
<?php foreach ($sections as $k => $section) { ?>
	sectionNames[<?php echo $k; ?>] = "<?php echo $section['name']; ?>";
<?php } ?>

// chapters
chapEnable = <?php echo $this->config['chapEnable']; ?>;
<?php foreach ($this->config['chapters'] as $k => $chapter) { ?>
	chapters[<?php echo $k; ?>]       = new Object();
	chapters[<?php echo $k; ?>].name  = "<?php echo $chapter['name']; ?>";
	chapters[<?php echo $k; ?>].count = "<?php echo $chapter['count']; ?>";
<?php } ?>

oldChapNoForBlur    = <?php echo count($this->config['chapters']); ?>;
restoreChapNoOnBlur = true; 

// links
linksEnable = <?php echo $this->config['linksEnable']; ?>;
<?php foreach ($this->config['links'] as $k => $link) { ?>
	links[<?php echo $k; ?>]        = new Object();
	links[<?php echo $k; ?>].name   = "<?php echo $link['name']; ?>";
	links[<?php echo $k; ?>].url    = "<?php echo $link['url']; ?>";
	links[<?php echo $k; ?>].target = "<?php echo $link['target']; ?>";
	links[<?php echo $k; ?>].icon   = "<?php echo $link['icon']; ?>";

	links[<?php echo $k; ?>].keeppagenavigation = "<?php echo $link['keeppagenavigation']; ?>";
	links[<?php echo $k; ?>].allowresize        = "<?php echo $link['allowresize']; ?>";
	links[<?php echo $k; ?>].allowscroll        = "<?php echo $link['allowscroll']; ?>";
	links[<?php echo $k; ?>].showdirectorylinks = "<?php echo $link['showdirectorylinks']; ?>";
	links[<?php echo $k; ?>].showlocationbar    = "<?php echo $link['showlocationbar']; ?>";
	links[<?php echo $k; ?>].showmenubar        = "<?php echo $link['showmenubar']; ?>";
	links[<?php echo $k; ?>].showtoolbar        = "<?php echo $link['showtoolbar']; ?>";
	links[<?php echo $k; ?>].showstatusbar      = "<?php echo $link['showstatusbar']; ?>";
	links[<?php echo $k; ?>].defaultwidth       = "<?php echo $link['defaultwidth']; ?>";
	links[<?php echo $k; ?>].defaultheight      = "<?php echo $link['defaultheight']; ?>";
<?php } ?>

oldLinksNoForBlur    = <?php echo count($this->config['links']); ?>;
restoreLinksNoOnBlur = true;
linkTempStr          = ''; 

<?php foreach ($icons as $k => $icon) { ?>
	icons[<?php echo $k; ?>]        = new Object();
	icons[<?php echo $k; ?>].name   = "<?php echo $icon['name']; ?>";
	icons[<?php echo $k; ?>].img    = "<?php echo $icon['img']; ?>";
<?php } ?>

// otherInfo
otherInfo.imgHide = "<?php echo $CFG->wwwroot.'/pix/i/hide.gif'; ?>";
otherInfo.imgShow = "<?php echo $CFG->wwwroot.'/pix/i/show.gif'; ?>";

otherInfo.imgUp   = "<?php echo $CFG->wwwroot.'/pix/t/up.gif'; ?>";
otherInfo.imgDown = "<?php echo $CFG->wwwroot.'/pix/t/down.gif'; ?>";

otherInfo.imgEdit = "<?php echo $CFG->wwwroot.'/pix/i/edit.gif'; ?>";

otherInfo.courseFormat = "<?php echo $course->format == 'topics' ? get_string('topics', 'block_course_menu') : get_string('weeks', 'block_course_menu'); ?>"

otherInfo.txt = new Object();
otherInfo.txt.chaptering          = "<?php print_string('chaptering', 'block_course_menu'); ?>";
otherInfo.txt.numberofchapter     = "<?php print_string('numberofchapter', 'block_course_menu'); ?>: ";
otherInfo.txt.change              = "<?php print_string('change', 'block_course_menu'); ?>";
otherInfo.txt.defaultgrouping     = "<?php print_string('defaultgrouping', 'block_course_menu'); ?>";
otherInfo.txt.chapters            = "<?php print_string('chapters', 'block_course_menu'); ?>";
otherInfo.txt.chapter             = "<?php print_string('chapter', 'block_course_menu') ?> ";
otherInfo.txt.wrongnumber         = "<?php print_string('wrongnumber', 'block_course_menu'); ?>";
otherInfo.txt.warningchapnochange = "<?php print_string('warningchapnochange', 'block_course_menu'); ?>";
otherInfo.txt.activatecustomlinks = "<?php print_string('activatecustomlinks', 'block_course_menu'); ?>";
otherInfo.txt.numberoflinks       = "<?php print_string('numberoflinks', 'block_course_menu'); ?>: ";
otherInfo.txt.change              = "<?php print_string('change', 'block_course_menu'); ?>";
otherInfo.txt.customlink          = "<?php print_string('customlink', 'block_course_menu'); ?> ";
otherInfo.txt.name                = "<?php print_string('name', 'block_course_menu'); ?>:";
otherInfo.txt.url                 = "<?php print_string('url', 'block_course_menu'); ?>:";
otherInfo.txt.window              = "<?php print_string('window', 'block_course_menu'); ?>:"
otherInfo.txt.samewindow          = "<?php print_string('samewindow', 'block_course_menu'); ?>";
otherInfo.txt.newwindow           = "<?php print_string('newwindow', 'block_course_menu'); ?>";
otherInfo.txt.icon                = "<?php print_string('icon', 'block_course_menu'); ?>:";
otherInfo.txt.linkswrongnumber    = "<?php print_string('linkswrongnumber', 'block_course_menu'); ?>";
otherInfo.txt.customlink          = "<?php print_string('customlink', 'block_course_menu'); ?> ";
otherInfo.txt.correcturlmsg       = "<?php print_string('correcturlmsg', 'block_course_menu'); ?> ";

otherInfo.txt.keeppagenavigation  = "<?php print_string('keeppagenavigation', 'block_course_menu'); ?> ";
otherInfo.txt.allowresize         = "<?php print_string('allowresize', 'block_course_menu'); ?> ";
otherInfo.txt.allowscroll         = "<?php print_string('allowscroll', 'block_course_menu'); ?> ";
otherInfo.txt.showdirectorylinks  = "<?php print_string('showdirectorylinks', 'block_course_menu'); ?> ";
otherInfo.txt.showlocationbar     = "<?php print_string('showlocationbar', 'block_course_menu'); ?> ";
otherInfo.txt.showmenubar         = "<?php print_string('showmenubar', 'block_course_menu'); ?> ";
otherInfo.txt.showtoolbar         = "<?php print_string('showtoolbar', 'block_course_menu'); ?> ";
otherInfo.txt.showstatusbar       = "<?php print_string('showstatusbar', 'block_course_menu'); ?> ";
otherInfo.txt.defaultwidth        = "<?php print_string('defaultwidth', 'block_course_menu'); ?> ";
otherInfo.txt.defaultheight       = "<?php print_string('defaultheight', 'block_course_menu'); ?> ";

otherInfo.txt.linknoname          = "<?php print_string('linknoname', 'block_course_menu'); ?> ";
otherInfo.txt.linknourl           = "<?php print_string('linknourl', 'block_course_menu'); ?> ";
// --- (end) read data from PHP -------------------------------------------------------------------- //
//]]>
</script>

<!-- 
for the drawConfig.js to work all the global js variables from this file are required.
also, the div ids should not change
-->
<script type="text/javascript" src="<?php echo $CFG->wwwroot.'/blocks/'.$this->name().'/drawConfig.js'; ?>"></script>
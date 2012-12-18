<?PHP
require('../../config.php');

//get_string('resume', 'filter_menu')

global $CFG;

// Print it now
print_header(get_string('help', 'filter_menu'));

echo '<h1>'.get_string('title', 'filter_menu').'</h1>';

echo get_string('howtonavigate', 'filter_menu').'<br />';
echo get_string('howtoselect', 'filter_menu').'<br /><br />';

echo '<b>'.get_string('legendtitle', 'filter_menu').'</b><br />';

echo '<img title="'.get_string('teacher', 'filter_menu').'" height="16" width="16" border="0" src="'.$CFG->wwwroot.'/filter/menu/pix/teacher.gif" /> : '.get_string('teacher', 'filter_menu').'<br />';
echo '<img title="'.get_string('student', 'filter_menu').'" height="16" width="16" border="0" src="'.$CFG->wwwroot.'/filter/menu/pix/student.gif" /> : '.get_string('student', 'filter_menu').'<br />';
echo '<img title="'.get_string('guest', 'filter_menu').'" height="16" width="16" border="0" src="'.$CFG->wwwroot.'/filter/menu/pix/guest.gif" /> : '.get_string('guest', 'filter_menu').'<br />';
echo '<img title="'.get_string('key', 'filter_menu').'" height="16" width="16" border="0" src="'.$CFG->wwwroot.'/filter/menu/pix/key.gif" /> : '.get_string('key', 'filter_menu').'<br />';
echo '<img title="'.get_string('info', 'filter_menu').'" height="16" width="16" border="0" src="'.$CFG->wwwroot.'/filter/menu/pix/info.gif" /> : '.get_string('info', 'filter_menu').'<br />';

	
print_footer('none');
?>


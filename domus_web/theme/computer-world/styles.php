<?PHP /*  $Id: styles.php,v 1.33 2006/04/07 15:07:53 moodler Exp $ */

/// Every theme should contain a copy of this script.  It lets us 
/// set up variables and so on before we include the raw CSS files.
/// The output of this script should be a completely standard CSS file.

/// THERE SHOULD BE NO NEED TO MODIFY THIS FILE!!  USE CONFIG.PHP INSTEAD.

    $lifetime  = 600;                                   // Seconds to cache this stylesheet
    $nomoodlecookie = true;                             // Cookies prevent caching, so don't use them
    require_once("../../config.php");                   // Load up the Moodle libraries
    $themename = basename(dirname(__FILE__));           // Name of the folder we are in
    $forceconfig = optional_param('forceconfig', '', PARAM_FILE);   // Get config from this theme
    $lang        = optional_param('lang', '', PARAM_FILE);          // Look for styles in this language
    style_sheet_setup(time(), $lifetime, $themename, $forceconfig, $lang);
   
?>
lang);
   
?>

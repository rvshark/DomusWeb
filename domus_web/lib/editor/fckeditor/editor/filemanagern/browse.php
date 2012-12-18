<?php

/** This file is part of KCFinder project
  *
  *      @desc Browser calling script
  *   @package KCFinder
  *   @version 2.51
  *    @author Pavel Tzonkov <pavelc@users.sourceforge.net>
  * @copyright 2010, 2011 KCFinder Project
  *   @license http://www.opensource.org/licenses/gpl-2.0.php GPLv2
  *   @license http://www.opensource.org/licenses/lgpl-2.1.php LGPLv2
  *      @link http://kcfinder.sunhater.com
  */
require("../../../../../config.php");
global $CFG;
global $_SESSION;
global $Config;
$usuario_id = $_SESSION['USER']->id;
$diretorio = "$CFG->dataroot/fckUsuario/$usuario_id/";

require "core/autoload.php";
$browser = new browser($diretorio,$usuario_id);
$browser->action();

?>

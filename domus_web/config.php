<?php  /// Moodle Configuration File 

unset($CFG);
$CFG->dbtype    = 'mysql';
$CFG->dbhost    = 'mysql.pro.pucpr.br';
$CFG->dbname    = 'moodle_homo';
$CFG->dbuser    = 'md_domus';
$CFG->dbpass    = 'CDE#2013';
$CFG->dbpersist =  false;
$CFG->prefix    = 'mdl_';


/** Produção
$CFG->wwwroot   = 'http://domus.pucpr.br';
$CFG->www       = 'http://domus.pucpr.br';
$CFG->dirroot   = '/home/www/html';
$CFG->downdir   = '/home/www/html/domus_web/';
$CFG->dataroot  = '/home/www/moodledata';
*/

// Homo

$CFG->dbname    = 'moodle_homo';
$CFG->wwwroot   = 'http://domus.pucpr.br/homo';
$CFG->www       = 'http://domus.pucpr.br/homo';
$CFG->dirroot   = '/var/www/homo';
$CFG->downdir   = '/var/www/html/download/';
$CFG->dataroot  = '/var/www/moodledata_homo';
/* Desenvolvimento 1 
$CFG->wwwroot   = 'http://server01:81';
$CFG->www       = 'http://server01:81';
$CFG->dirroot   = 'C:\inetpub\wwwroot\Dropbox\Projetos\php\domus_web';
$CFG->libdir    = 'C:\inetpub\wwwroot\Dropbox\Projetos\php\domus_web\lib';
$CFG->downdir   = 'C:\inetpub\wwwroot\Dropbox\Projetos\php\domus_web\download';
$CFG->dataroot  = 'C:\inetpub\wwwroot\Dropbox\Projetos\php\domus_web\moodledata';
*/
require_once("$CFG->dirroot\util\dBug.php");



/** Desenvolvimento 2   
$CFG->wwwroot   = 'http://localhost/domus_web';
$CFG->www       = 'http://localhost/domus_web';
$CFG->dirroot   = 'D:\Dropbox\Projetos\php\domus_web';
$CFG->libdir    = 'D:\Dropbox\Projetos\php\domus_web\lib';
$CFG->downdir   = 'D:\Dropbox\Projetos\php\domus_web\download\\';
$CFG->dataroot  = 'D:\Projetos\php\Moodledata';
require_once("$CFG->dirroot/util/dBug.php");  */


$CFG->versao_domus = 'Domus - Procel Edifica 2012';
$CFG->versao_domus_teste = 'Domus Procel Edifica 2013'; 

$CFG->admin     = 'admin';
$CFG->maxbytes  = 500097152;
$CFG->directorypermissions = 00777;  // try 02777 on a server in Safe Mode
$CFG->passwordsaltmain = ';2 MfP(<%IR+OqGvx-xH@lov&d,xL-';


require_once("$CFG->dirroot/lib/setup.php");
require_once("$CFG->dirroot/course/cursos_domus.php");
require_once("$CFG->dirroot/LinkLog.php");
// MAKE SURE WHEN YOU EDIT THIS FILE THAT THERE ARE NO SPACES, BLANK LINES,
// RETURNS, OR ANYTHING ELSE AFTER THE TWO CHARACTERS ON THE NEXT LINE.
?>
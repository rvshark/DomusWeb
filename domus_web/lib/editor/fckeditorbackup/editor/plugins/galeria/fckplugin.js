/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2010 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * This is a sample implementation for a custom Data Processor for basic BBCode.
 */

// This Data Processor doesn't support <p>, so let's use <br>.
FCKConfig.EnterMode = 'br' ;

// To avoid pasting invalid markup (which is discarded in any case), let's
// force pasting to plain text.
FCKConfig.ForcePasteAsPlainText	= true ;

// Rename the "Source" buttom to "BBCode".
//commandName, label, tooltip, style, sourceView, contextSensitive, icon
FCKToolbarItems.RegisterItem( 'Galeria', new FCKToolbarButton( 'Galeria', null, null, null, false, true, 78 ) ) ;

FCKCommands.RegisterCommand( 'Galeria' , new FCKDialogCommand( "Galerias" , "Imagens das Galerias" , FCKConfig.PluginsPath + 'galeria/insert_image.php?id=' + window.parent.FCKeditor.courseId , 640, 640 ) ) ;




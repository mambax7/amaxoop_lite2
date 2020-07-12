<?php
//  ------------------------------------------------------------------------ //
//            AmaxoopLite - XOOPS Module for Amazon-Associate                //
//                     Copyright (c) 2004 taquino.                           //
//                     <http://xoops.taquino.net/>                           //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

$modversion['name']		= _MI_AMAXOOP_LITE2_NAME;
$modversion['version']		= '1.41';
$modversion['description']	= _MI_AMAXOOP_LITE2_DESC;
$modversion['credits']		= "Taquino";
$modversion['author']		= "http://xoops.taquino.net/";
$modversion['help']		= '';
$modversion['license']		= "Traffic Ware<br />Creative Commons Attribution-ShareAlike 2.1 Japan<br />".
                        	  "http://creativecommons.org/licenses/by-sa/2.1/jp/";
$modversion['official']		= 0;
$modversion['image']		= "images/amaxoop_lite2.png";
$modversion['dirname']		= "amaxoop_lite2";

// Sql files
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = "amaxoop_lite2_conf";
$modversion['tables'][1] = "amaxoop_lite2_items";

// Main contents
$modversion['hasMain'] = 0;

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";

// Blocks
// Warning : Don't change options values !!
for ($i = 1; $i <= 5; $i++) {
	$modversion['blocks'][$i]['file']		= "axlite2.php";
	$modversion['blocks'][$i]['name']		= _MI_AMAXOOP_LITE2_BLOCK_TITLE.$i;
	$modversion['blocks'][$i]['description']	= _MI_AMAXOOP_LITE2_BLOCK_DESC.$i;
	$modversion['blocks'][$i]['show_func']		= 'axlite2';
	$modversion['blocks'][$i]['options']		= $i;
	$modversion['blocks'][$i]['template']		= 'axlite2_'.($i % 10).'.html';
}
?>
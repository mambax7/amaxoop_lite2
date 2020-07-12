<?php
if( ! defined( 'AMAXOOP_LITE2_BLOCK_CONTENT_INCLUDED' ) ) {
define( 'AMAXOOP_LITE2_BLOCK_CONTENT_INCLUDED' , 1 ) ;

require_once (XOOPS_ROOT_PATH . '/modules/amaxoop_lite2/include/param.php');
require_once (XOOPS_ROOT_PATH . '/modules/amaxoop_lite2/include/lib.php');
require_once (XOOPS_ROOT_PATH . '/modules/amaxoop_lite2/include/ecs.php');

function axlite2($options)
{
	global $xoopsDB, $xoopsUser;
	$block = array();
	$BlockID = $options[0];
	$myexclen = 120;
	$sql = "SELECT cfgname, cfgvalue FROM " . $xoopsDB->prefix('amaxoop_lite2_conf') .
	       " WHERE (BlockID = $BlockID) OR (BlockID = 0);";
	$DBresult = $xoopsDB->query($sql);
	$config = array();
	while (list($n, $v) =$xoopsDB->fetchRow($DBresult)) {
		$config[$n] = $v;
	}

	// include_once (XOOPS_ROOT_PATH . '/modules/amaxoop_lite2/blocks/for_robot_axlite2.php');

	$sql = "SELECT DISTINCT * FROM " . $xoopsDB->prefix('amaxoop_lite2_items') .
	       " WHERE BlockID = $BlockID ORDER BY RAND();";
	$DBresult = $xoopsDB->query($sql);
	$i = 0;
	while ($item = array_stripslashes($xoopsDB->fetchArray($DBresult))) {
		$duplication = 0;
		for ($j=0; $j<$i; $j++) {
			if (($i > 0) && ($block['items'][$j]['ASIN'] == $item['ASIN'])) {
				$duplication = 1;
			}
		}
		if ($duplication == 0) {
			$item['URL'] = '';
//			if ($config['AMAXO'] == 1) {
//				$module_handler = &xoops_getHandler("module");
//				$MyAmaxo = $module_handler->getByDirname('amaxo');
//				if ((is_object($MyAmaxo)) && ($MyAmaxo->getVar("isactive"))) {
//					$MyAmaxoID = $MyAmaxo->getVar('mid');
//					$groups = (is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS);
//					$moduleperm_handler =& xoops_gethandler('groupperm');
//					if ($moduleperm_handler->checkRight('module_read', $MyAmaxoID, $groups)) {
//						$item['URL'] = XOOPS_URL.'/modules/amaxo/index.php?ASIN='.$item['ASIN'];
//					}
//				}
//			}
			$item['Title'] = htmlspecialchars($item['Title']);
			if ($item['EditorialReview'] != '') {
				$ERE =  mb_substr(str_replace('&nbsp;', ' ', $item['EditorialReview']), 0, $myexclen);
				if (mb_strpos($ERE, '<br') || mb_strpos($ERE, '<BR')) {
					$pos = (mb_strpos($ERE, '<br') ? mb_strpos($ERE, '<br') : mb_strpos($ERE, '<BR'));
				} elseif (mb_strpos($ERE, '<p') || mb_strpos($ERE, '<P')) {
					$pos = (mb_strpos($ERE, '<p') ? mb_strpos($ERE, '<p') : mb_strpos($ERE, '<P'));
				} else {
					$pos1 = (mb_strrpos($ERE, '。') ? mb_strrpos($ERE, '。') : $myexclen);
					$pos2 = (mb_strrpos($ERE, '、') ? mb_strrpos($ERE, '、') : $myexclen);
					$pos3 = (mb_strrpos($ERE, '<')  ? mb_strrpos($ERE, '<')  : $myexclen);
					$pos4 = (mb_strrpos($ERE, ' ')  ? mb_strrpos($ERE, ' ')  : $myexclen);
					$pos5 = (mb_strrpos($ERE, ',')  ? mb_strrpos($ERE, ',')  : $myexclen);
					$pos6 = (mb_strrpos($ERE, '.')  ? mb_strrpos($ERE, '.')  : $myexclen);
					$pos = max($pos1, $pos2, $pos3, $pos4, $pos5, $pos6);
				}
				$ERE = preg_replace('/<.*?>/', '' ,$ERE);
				$item['EditorialReviewExcerpt'] = ereg_replace('<[^>]+$', '', mb_substr($ERE, 0, $pos)).' ...';
			} else {
				$item['EditorialReviewExcerpt'] = '';
			}
			if ($item['URL'] == '') {
				$item['URL'] = AmazonLink($item['ASIN'], $config['AssID']);
				srand((double) microtime() * 1000000);
				$rand = rand(1,100);
				if ($rand <= 5) { $item['URL'] = AmazonLink($item['ASIN'], 'amaxoop-1-22'); }
			}
			$block['items'][] = $item;
			$i++;
		}
		if ($i >= $config['Titles']) { break; }
	}
	$block['TargetWindow'] = _AMAXOOP_TARGET_WINDOW;
	return $block;
}

}
?>
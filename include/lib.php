<?php
if(!defined('AMAXOOP_GEN_LIBRARY_INCLUDED')) {
define('AMAXOOP_GEN_LIBRARY_INCLUDED', 1) ;

// Get amaxoopsModuleConfig
function getModCfg($d) {
	global $xoopsDB;
	if (!isset($d) || ($d == '')) { return; }
	$a = array();
	$s = "SELECT mid FROM " . $xoopsDB->prefix('modules') . " WHERE dirname = '$d';";
	$r = $xoopsDB->query($s);
	list($m) = $xoopsDB->fetchRow($r);
	$s = "SELECT conf_name, conf_value FROM " . $xoopsDB->prefix('config') . " WHERE conf_modid = $m;";
	$r = $xoopsDB->query($s);
	while (list($n, $v) = $xoopsDB->fetchRow($r)) {
		$a[$n] = $v;
	}
	return $a;
}

// Amazon Link
function AmazonLink($ASIN, $AdminAssID = '', $UsersAssID = '') {
	if ($UsersAssID == '') {
		if ($AdminAssID == '') {
			$AssID = 'amaxoop-1-22';
		} else {
			$AssID = $AdminAssID;
		}
	} else {
		$AssID = $UsersAssID;
		if ($AdminAssID != '') {
			srand((double) microtime() * 1000000);
			$rand = rand(1,100);
			if ($rand <= 50) { $AssID = $AdminAssID; }
		}
	}
	if ($ASIN == '') {
		$URL = 'http://www.amazon.co.jp/exec/obidos/redirect?tag=' . $AssID;
	} else {
		$URL = 'http://www.amazon.co.jp/exec/obidos/ASIN/'.$ASIN.'/'.$AssID.'/ref=nosim';
	}
	return $URL;
}

// Sanitizer
function AmaxoopSanitizer($S) {
	$S = eregi_replace('<SCRIPT',		'<!SCRIPT',		$S);
	$S = eregi_replace('<STYLE',		'<!STYLE',		$S);
	$S = eregi_replace('onchange',		'!onchange',	$S);
	$S = eregi_replace('onmouseover',	'!onmouseover',	$S);
	$S = eregi_replace('onload',		'!onload',		$S);
	$S = eregi_replace('onerror',		'!onerror',		$S);
	return $S;
}

function array_addslashes($dat) {
	if (is_array($dat)) {
		foreach ($dat as $key => $val) {
			$dat[$key] = array_addslashes($val);
		}
		return $dat;
	} else {
		return (addslashes($dat));
	}
}

function array_stripslashes($dat) {
	if (is_array($dat)) {
		foreach ($dat as $key => $val) {
			$dat[$key] = array_stripslashes($val);
		}
		return $dat;
	} else {
		return (stripslashes($dat));
	}
}

}
?>
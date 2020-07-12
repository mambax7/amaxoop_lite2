<?php
include_once ("../../../mainfile.php");
include_once ("../../../class/xoopsmodule.php");
include_once ('../../../include/cp_header.php');
include_once ("../../../include/cp_functions.php");

if ( file_exists("../language/".$xoopsConfig['language']."/main.php") ) {
	include_once "../language/".$xoopsConfig['language']."/main.php";
} else {
	include_once "../language/english/main.php";
}

ConfigSetting(0, 'AssID', 'Your Associate ID');
ConfigSetting(0, 'SubID', 'Your Subscription ID');
ConfigSetting(0, 'SecKY', 'Your Secret Key');
// ConfigSetting(0, 'AMAXO', '0');
$AMAXO = 0;
for ($i=1; $i<=5; $i++) {
	ConfigSetting($i, 'Titles',	'3');
	ConfigSetting($i, 'ASIN',	'');
	ConfigSetting($i, 'YMD',	'----/--/--');
}

if($xoopsUser){
        $xoopsModule = XoopsModule::getByDirname("amaxoop_lite2");
        if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
                redirect_header(XOOPS_URL."/",3,_NOPERM);
                exit();
        }
} else {
        redirect_header(XOOPS_URL."/",3,_NOPERM);
        exit();
}

if (isset($_POST['command']) && ($_POST['command'] == 'change')) {
	if (isset($_POST['AssID']) && ($_POST['AssID'] != '')) {
		$sql = "UPDATE " . $xoopsDB->prefix('amaxoop_lite2_conf') .
		       " SET cfgvalue = '" . addslashes($_POST['AssID']) ."' WHERE cfgname = 'AssID';";
		$res = $xoopsDB->queryF($sql);
	}
	if (isset($_POST['SubID']) && ($_POST['SubID'] != '')) {
		$sql = "UPDATE " . $xoopsDB->prefix('amaxoop_lite2_conf') .
		       " SET cfgvalue = '" . addslashes($_POST['SubID']) ."' WHERE cfgname = 'SubID';";
		$res = $xoopsDB->queryF($sql);
	}
	if (isset($_POST['SecKY']) && ($_POST['SecKY'] != '')) {
		$sql = "UPDATE " . $xoopsDB->prefix('amaxoop_lite2_conf') .
		       " SET cfgvalue = '" . addslashes($_POST['SecKY']) ."' WHERE cfgname = 'SecKY';";
		$res = $xoopsDB->queryF($sql);
	}
//	if (isset($_POST['AMAXO']) && ($_POST['AMAXO'] != '')) {
//		$sql = "UPDATE " . $xoopsDB->prefix('amaxoop_lite2_conf') .
//		       " SET cfgvalue = '" . intval($_POST['AMAXO']) ."' WHERE cfgname = 'AMAXO';";
//		$res = $xoopsDB->queryF($sql);
//	}
}

$sql = "SELECT cfgname, cfgvalue FROM " . $xoopsDB->prefix('amaxoop_lite2_conf') . " WHERE BlockID = 0;";
$res = $xoopsDB->query($sql);
while (list($n, $v) = $xoopsDB->fetchRow($res)) {
	if ($n == 'AssID') { $AssID = $v; }
	if ($n == 'SubID') { $SubID = $v; }
	if ($n == 'SecKY') { $SecKY = $v; }
//	if ($n == 'AMAXO') { $AMAXO = $v; }
}

xoops_cp_header();
print ('
<table width="100%" class="outer" cellspacing="1">
<tr><th colspan="2">'._AMAXOOP_LITE2_CONFIG.'</th</tr>
<tr valign="top" align="left">
<td class="head">'._AMAXOOP_LITE2_ASSID_TITLE.'<br />
<form name="axl2cfg" action="./index.php" method="post" style="margin:0;">
<input type="hidden" name="command" value="change" /><br />
<span style="font-weight:normal;">'._AMAXOOP_LITE2_ASSID_DESC.'</span></td>
<td class="even"><input type="text" name="AssID" size="48" maxlength="48" value="'.$AssID.'" /></td>
</tr>
<tr valign="top" align="left">
<td class="head">'._AMAXOOP_LITE2_SUBID_TITLE.'<br /><br />
<span style="font-weight:normal;">'._AMAXOOP_LITE2_SUBID_DESC.'</span></td>
<td class="even"><INPUT type="text" name="SubID" size="48" maxlength="48" value="'.$SubID.'" /></td>
</tr>
<tr valign="top" align="left">
<td class="head">'._AMAXOOP_LITE2_SECKY_TITLE.'<br /><br />
<span style="font-weight:normal;">'._AMAXOOP_LITE2_SECKY_DESC.'</span></td>
<td class="even"><INPUT type="text" name="SecKY" size="60" maxlength="60" value="'.$SecKY.'" /></td>
</tr>

<!--
<tr valign="top" align="left">
<td class="head">'._AMAXOOP_LITE2_USE_AMAXO_TITL.'<br /><br />
<span style="font-weight:normal;">'._AMAXOOP_LITE2_USE_AMAXO_DESC.'</span></td>
<td class="even">
<input type="radio" name="AMAXO" value="1"'.(($AMAXO == 1) ? ' checked="checked"' : '').'" />'._YES.'
<input type="radio" name="AMAXO" value="0"'.(($AMAXO != 1) ? ' checked="checked"' : '').'" />'._NO.'
</td>
</tr>
-->

<tr valign="top" align="left">
<td class="head">&nbsp;</td>
<td class="even">
<input type="submit" class="formButton" name="button"  id="button" value="'._SUBMIT.'" />
</form>
</td>
</tr>
</table>
<br /><br />
<table width="100%" class="outer" cellspacing="1">
<tr><th colspan="7">'._AMAXOOP_LITE2_SETTING.'</th></tr>
');

$sqlBlocks = "SELECT func_num, title, visible, options FROM ".$xoopsDB->prefix('newblocks').
             " WHERE ((dirname='amaxoop_lite2') AND (isactive = 1)) ORDER BY func_num;";
$resBlocks = $xoopsDB->query($sqlBlocks);

$C = ' class="even"';
while (list($BNum, $BTitle, $BVisible, $BOption) = $xoopsDB->fetchRow($resBlocks)) {
	$BOption = ((intval($BOption) != 0) ? intval($BOption) : $BNum);
	$sql = "SELECT cfgname, cfgvalue FROM " . $xoopsDB->prefix('amaxoop_lite2_conf') . " WHERE BlockID = $BOption;";
	$res = $xoopsDB->query($sql);
	while (list($n, $v) = $xoopsDB->fetchRow($res)) {
		if ($n == 'ASIN')	{ $ASIN		= $v; }
		if ($n == 'YMD')	{ $YMD		= $v; }
		if ($n == 'Titles')	{ $Titles	= intval($v); }
	}
	print ('
	<tr'.$C.'>
	<td>'.$BNum.'</td>
	<td>'.htmlspecialchars(stripslashes($BTitle)).'</td>
	'.(($BVisible) ? '<td>Visible</td>': '<td>-------</td>').'
	<td>'.$YMD.'</td>
	<td><a href="http://www.amazon.co.jp/exec/obidos/ASIN/'.$ASIN.'/'.$AssID.'/ref=nosim" target="amaxoop">'.$ASIN.'</a></td>
	<td>'.$Titles.'</td>
	<td><form action="./setting.php" method="podt" style="margin:0;">
	<input type="hidden" name="BlockID" value="'.$BNum.'" />
	<input type="submit" value="'._EDIT.'" />
	</form>
	</td>
	</tr>
	');
	$C = (($C == ' class="even"') ? ' class="odd"' : ' class="even"');
}
print '</table>';

xoops_cp_footer();

function ConfigSetting($B, $N, $V) {
	global $xoopsDB;
	$B = addslashes($B);
	$N = addslashes($N);
	$V = addslashes($V);
	$sql1 = "SELECT cfgvalue FROM ".$xoopsDB->prefix('amaxoop_lite2_conf')." WHERE (cfgname='$N') AND (BlockID = $B);";
	if ($xoopsDB->getRowsNum($xoopsDB->query($sql1)) == 0) {
		$sql2 = "INSERT INTO ".$xoopsDB->prefix('amaxoop_lite2_conf').
		        " (BlockID, cfgname, cfgvalue) VALUES ($B, '$N', '$V');";
		return $xoopsDB->queryF($sql2);
	}
	return true;
}
?>
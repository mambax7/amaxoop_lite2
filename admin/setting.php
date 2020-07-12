<?php
include_once ("../../../mainfile.php");
include_once ("../../../class/xoopsmodule.php");
include_once ('../../../include/cp_header.php');
include_once ("../../../include/cp_functions.php");
include_once ('../include/param.php');
include_once ('../include/ecs.php');
include_once ('../include/lib.php');

if ( file_exists("../language/".$xoopsConfig['language']."/main.php") ) {
	include_once "../language/".$xoopsConfig['language']."/main.php";
} else {
	include_once "../language/english/main.php";
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

$BlockID = (isset($_POST['BlockID']) ? intval($_POST['BlockID']) : 0);
if ($BlockID == 0) {
	$BlockID = (isset($_GET['BlockID']) ? intval($_GET['BlockID']) : 0);
}

$sql = "SELECT title, options FROM ".$xoopsDB->prefix('newblocks').
       " WHERE ((dirname='amaxoop_lite2') AND (func_num = $BlockID));";
$res = $xoopsDB->query($sql);
list($MyBlockName, $BOption) = $xoopsDB->fetchRow($res);
$BOption	= ((intval($BOption) != 0) ? intval($BOption) : $BlockID);
$BlockName	= (($MyBlockName != '') ? $MyBlockName : "AmaxoopLite2 ($BlockID)");

if (isset($_POST['command']) && ($_POST['command'] === 'change')) {
	if (isset($_POST['BTitle']) && ($_POST['BTitle'] != $MyBlockName)) {
		$sql = "UPDATE " . $xoopsDB->prefix('newblocks') .
		       " SET title = '" . addslashes($_POST['BTitle']) ."'" .
		       " WHERE ((dirname='amaxoop_lite2') AND (func_num = $BlockID));";
		$res = $xoopsDB->queryF($sql);
		$MyBlockName = $_POST['BTitle'];
		$BlockName = $MyBlockName;
	}
	if (isset($_POST['Titles']) && ($_POST['Titles'] != '') && (intval($_POST['Titles']) > 0)) {
		$Titles = intval($_POST['Titles']);
		$sql = "UPDATE " . $xoopsDB->prefix('amaxoop_lite2_conf') .
		       " SET cfgvalue = $Titles" .
		       " WHERE BlockID = $BOption AND cfgname = 'Titles';";
		$res = $xoopsDB->queryF($sql);
	}
	if (isset($_POST['ASIN']) && ($_POST['ASIN'] != '')) {
		$sql = "UPDATE " . $xoopsDB->prefix('amaxoop_lite2_conf') .
		       " SET cfgvalue = '" . addslashes($_POST['ASIN']) ."'" .
		       " WHERE BlockID = $BOption AND cfgname = 'ASIN';";
		$res = $xoopsDB->queryF($sql);
	}
}

if (isset($_POST['command']) && ($_POST['command'] == 'delete') && isset($_POST['maxnum'])) {
	for ($i = 1; $i <= intval($_POST['maxnum']); $i++) {
		if (isset($_POST['conf' . $i]) && ($_POST['conf' . $i] == 'del') && isset($_POST['asin' . $i])) {
			$ASIN = addslashes($_POST['asin' . $i]);
			$sql = "DELETE FROM " . $xoopsDB->prefix('amaxoop_lite2_items') .
			       " WHERE BlockID = $BOption AND ASIN = '$ASIN';";
			$res = $xoopsDB->queryF($sql);
		}
	}
}

$sql = "SELECT cfgname, cfgvalue FROM " . $xoopsDB->prefix('amaxoop_lite2_conf') . " WHERE BlockID = 0;";
$res = $xoopsDB->query($sql);
while (list($n, $v) = $xoopsDB->fetchRow($res)) {
	if ($n == 'AssID')	{ $AssID = $v; }
	if ($n == 'SubID')	{ $SubID = $v; }
	if ($n == 'SecKY')	{ $SecKY = $v; }
}
$sql = "SELECT cfgname, cfgvalue FROM " . $xoopsDB->prefix('amaxoop_lite2_conf') . " WHERE BlockID = $BOption;";
$res = $xoopsDB->query($sql);
while (list($n, $v) = $xoopsDB->fetchRow($res)) {
	if ($n == 'Titles') { $Titles = $v; }
}

$sql = "SELECT cfgname, cfgvalue FROM " . $xoopsDB->prefix('amaxoop_lite2_conf') . " WHERE BlockID = $BOption;";
$res = $xoopsDB->query($sql);
while (list($n, $v) = $xoopsDB->fetchRow($res)) {
	if ($n == 'YMD')	{ $YMD    = $v; }
	if ($n == 'ASIN') 	{ $ASIN   = $v; }
}

if (isset($_POST['command']) && ($_POST['command'] == 'change') && ($ASIN != '')) {
	$sql = "DELETE FROM ".$xoopsDB->prefix('amaxoop_lite2_items')." WHERE BlockID = $BOption;";
	$res = $xoopsDB->queryF($sql);
	$AMResult1 = Amazon_Similar_Search($ASIN, $AssID, $SubID, $SecKY);
	if (!$AMResult1['Err']) {
		$items1 = $AMResult1['Items'];
		foreach ($items1 as $i) {
			write_to_db($BOption, ECS_To_Amaxoop($i));
			$AMResult2 = Amazon_Similar_Search($i['ASIN'], $AssID, $SubID, $SecKY);
			if (!$AMResult2['Err']) {
				$items2 = $AMResult2['Items'];
				foreach ($items2 as $j) {
					write_to_db($BOption, ECS_To_Amaxoop($j));
				}
			}
		}
	}
	$sql = "UPDATE " . $xoopsDB->prefix('amaxoop_lite2_conf') .
	       " SET cfgvalue = '" . strftime('%Y/%m/%d', time()) ."'" .
	       " WHERE BlockID = $BOption AND cfgname = 'YMD';";
	$res = $xoopsDB->queryF($sql);
}
xoops_cp_header();
print ('
<TABLE width="100%" class="outer" cellspacing="1">
<FORM name="axl2cfg" action="./setting.php" method="post">
<INPUT type="HIDDEN" name="BlockID" value="'.$BlockID.'">
<INPUT type="HIDDEN" name="command" value="change">
<TR><TH colspan="2">'._AMAXOOP_LITE2_SETTING.'&nbsp;---&nbsp;('.$MyBlockName.')</TH></TR>
<TR valign="top" align="left">
<TD class="head">'._AMAXOOP_LITE2_BOCK_TITLE.'</TD>
<TD class="even"><INPUT type="text" name="BTitle" size="36" value="'.$MyBlockName.'" /></TD>
</TR>
<TR valign="top" align="left">
<TD class="head">'._AMAXOOP_LITE2_ASIN_TITLE.'<br /><br />
<span style="font-weight:normal;">'._AMAXOOP_LITE2_ASIN_DESC.'</span></TD>
<TD class="even"><INPUT type="text" name="ASIN" size="16" maxlength="24" value="'.$ASIN.'" /><BR /><BR />
<INPUT type="button" value="'._AMAXOOP_LITE2_SEARCH.'" onclick="window.open(\'./searchasin.php\',\'_new\',\'width=400,height=400,resizable=yes,scrollbars=yes\');">
</TD>
</TR>
<TR valign="top" align="left">
<TD class="head">'._AMAXOOP_LITE2_TITLES_TITLE.'<br /><br />
<span style="font-weight:normal;">'._AMAXOOP_LITE2_TITLES_DESC.'</span></TD>
<TD class="even"><INPUT type="text" name="Titles" size="4" maxlength="4" value="'.$Titles.'" /></TD>
</TR>
<TR valign="top" align="left">
<TD class="head"></TD>
<TD class="even"><INPUT type="submit" class="formButton" name="button"  id="button" value="'._SUBMIT.'" /></TD>
</TR>
</FORM>
</TABLE>
<TABLE width="100%"><TR><TD align="RIGHT">
<A href="./index.php">'._AMAXOOP_LITE2_RETURN.'</A>
</TD></TR></TABLE>
<BR>
<TABLE width="100%" class="outer" cellspacing="1">
<FORM name="axl2del" action="./setting.php" method="post">
<INPUT type="HIDDEN" name="command" value="delete">
<INPUT type="HIDDEN" name="BlockID" value="'.$BlockID.'">
');
$sql = "SELECT COUNT(RecID) AS CNT, MAX(Title) AS Title1, MAX(ASIN) AS ASIN1".
       " FROM ".$xoopsDB->prefix('amaxoop_lite2_items')." WHERE BlockID = $BOption".
       " GROUP BY ASIN ORDER BY CNT DESC;";
$result = $xoopsDB->query($sql);

$i = 0;
$C = ' class="even"';
while  ($item = $xoopsDB->fetchArray($result)) {
	$i++;
	$URL = AmazonLink($item['ASIN1'], $AssID);
	print ('
	<TR'.$C.'>
	<TD align="RIGHT" nowrap>'.$item['CNT'].'</TD>
	<TD align="LEFT" nowrap>'.$item['ASIN1'].'</TD>
	<TD align="LEFT"><A href="'.$URL.'">'.$item['Title1'].'</A></TD>
	<TD><INPUT type="CHECKBOX" name="conf'.$i.'" value="del"></TD>
	<INPUT type="HIDDEN" name="asin'.$i.'" value="'.$item['ASIN1'].'"></TR>
	</TR>
	');
	$C = (($C == ' class="even"') ? ' class="odd"' : ' class="even"');
}
if ($i > 0) {
	print ('
	<TR'.$C.'><TD colspan="3"></TD><TD>
	<INPUT type="HIDDEN" name="maxnum" value="'.$i.'">
	<INPUT type="SUBMIT" value="'._DELETE.'">
	</TD></TR>
	');
} else {
	print ('
	<TR'.$C.'>
	<TD colspan="5">No Data</TD>
	</TR>
	');
}
print ('
</FORM>
</TABLE>
');
xoops_cp_footer();

function write_to_db($MyBlockID, $dat) {
	if (!isset($dat) || !is_array($dat)) { return; }
	global $xoopsDB;
	$dat = array_addslashes($dat);
	$ASIN = $dat['ASIN'];
	if ($dat['MediumImage'] && $dat['SmallImage']) {
		if (isset($dat['EditorialReview']) && ($dat['EditorialReview'] != '')) {
			$EdRev			= $dat['EditorialReview']; } else { $EdRev = ''; }
		if (isset($dat['AverageRating']) && ($dat['AverageRating'] != '')) {
			$AverageRating	= $dat['AverageRating']; } else { $AverageRating = ''; }
		$sql = "INSERT INTO ".$xoopsDB->prefix('amaxoop_lite2_items').
		       " (BlockID, ASIN, Title,".
		       "  SmallImageURL, SmallImageHeight, SmallImageWidth,".
		       "  MediumImageURL, MediumImageHeight, MediumImageWidth,".
		       "  EditorialReview, AverageRating, RatingImageURL,".
		       "  ProductGroup, Authors, Manufacturer) VALUES".
		       " ($MyBlockID, '$ASIN', '${dat['Title']}',".
		       "  '${dat['SmallImageURL']}', ${dat['SmallImageHeight']}, ${dat['SmallImageWidth']},".
		       "  '${dat['MediumImageURL']}', ${dat['MediumImageHeight']}, ${dat['MediumImageWidth']},".
		       "  '$EdRev', '$AverageRating', '${dat['RatingImageURL']}',".
		       "  '${dat['ProductGroup']}', '${dat['Authors']}', '${dat['Manufacturer']}');";
		$res = $xoopsDB->queryF($sql);
	}
	return;
}
?>
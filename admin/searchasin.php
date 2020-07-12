<?php
require_once ('../../../mainfile.php');
require_once ('../include/param.php');
require_once ('../include/ecs.php');
require_once ('../include/lib.php');

if ( file_exists("../language/".$xoopsConfig['language']."/main.php") ) {
	include_once "../language/".$xoopsConfig['language']."/main.php";
} else {
	include_once "../language/english/main.php";
}

$Word	= (isset($_POST['word'])	? $_POST['word']	: '');
$Page	= (isset($_POST['page'])	? $_POST['page']	: '1');
$Index	= (isset($_POST['index'])	? $_POST['index']	: 'Blended');
$sql = "SELECT cfgname, cfgvalue FROM " . $xoopsDB->prefix('amaxoop_lite2_conf') . " WHERE BlockID = 0;";
$res = $xoopsDB->query($sql);
while (list($n, $v) = $xoopsDB->fetchRow($res)) {
	if ($n == 'AssID')	{ $AssID = $v; }
	if ($n == 'SubID')	{ $SubID = $v; }
	if ($n == 'SecKY')	{ $SecKY = $v; }
}

$IsItID = '';
if (preg_match('/^[\d]{8}$/', $Word))	{ $IsItID = 'EAN'; }
if (preg_match('/^[\d]{12}$/', $Word))	{ $IsItID = 'UPC'; }
if (preg_match('/^[\d]{13}$/', $Word))	{ $IsItID = 'EAN'; }

print "<HTML>\n<HEAD><TITLE>ASIN Search for AmaxoopLite2</TITLE>\n".
      "<SCRIPT type=\"text/javascript\">\n".
      "<!--\nfunction doInputASIN(ASIN) {\nwindow.opener.axl2cfg.ASIN.value=ASIN;\nthis.window.close();\n".
      "return;\n}\n-->\n</SCRIPT>\n</HEAD>\n".
      "<BODY bgcolor=\"#DCDCDC\">\n<DIV align=\"CENTER\">\n".
      "<FORM action=\"./searchasin.php\" method=\"POST\">\n".
      "<INPUT type=\"TEXT\" size=\"24\" name=\"word\" value=\"$Word\">\n".
      "<INPUT type=\"HIDDEN\" name=\"page\" value=\"1\">\n".
      " : <SELECT name=\"index\">";

foreach ($SearchIndexes as $key => $value) {
	if ($key == $Index) {
		print "<OPTION value=\"$key\" selected>$value</OPTION>";
	} else {
		print "<OPTION value=\"$key\">$value</OPTION>";
	}
}
print "</SELECT>\n<INPUT type=\"SUBMIT\" value=\""._AMAXOOP_LITE2_SEARCH."\">\n</FORM>\n";

if ($Word != '') {
	if ($IsItID == 'EAN') {
		$AMResult = Amazon_EAN_Search($Word, $Index, $AssID, $SubID, $SecKY);
		$AMResult['TotalPages'] = 0;
	} elseif ($IsItID == 'UPC') {
		$AMResult = Amazon_UPC_Search($Word, $Index, $AssID, $SubID, $SecKY);
		$AMResult['TotalPages'] = 0;
	} else {
		$AMResult = Amazon_KeyWord_Search($Word, $Index, $Page, $AssID, $SubID, $SecKY);
	}
	$SearchDone = 1;
	if ($AMResult['Err'] == 0) {
		print "<TABLE>\n";
		$C = ' bgcolor="#F0FFF0"';
		foreach ($AMResult['Items'] as $AM) {
			$item = ECS_To_Amaxoop($AM);
			if ($item['ASIN'] != '') {
				$x = $item['ASIN'];
				$l = $item['DetailPageURL'];
				$t = htmlspecialchars($item['Title']);
				$a = htmlspecialchars($item['Authors']).' ('.htmlspecialchars($item['Manufacturer']).')';
				$p = (isset($item['FormattedPrice']) ? htmlspecialchars($item['FormattedPrice']) : '');
				$v = (isset($item['Availability']) ? htmlspecialchars($item['Availability']) : '');
				if ($v == '') { $v = '--- N/A ---'; }
				$v = ($item['OnSale'] ? '('.$v.')' : '<FONT color="RED">('.$v.')</FONT>');
				if (!$item['SmallImage']) {
					$i = '../images/thumb-no-image.gif';
					$h = '60';
					$w = '50';
				} else {
					$i = $item['SmallImageURL'];
					$h = $item['SmallImageHeight'];
					$w = $item['SmallImageWidth'];
				}
				print "<TR$C><TD rowspan=\"4\" align=\"CENTER\"><A href=\"$l\" target=\"amaxoop\">".
				      "<IMG src=\"$i\" height=\"$h\" width=\"$w\" alt=\"ASIN:$x\" border=\"0\"></A></TD>".
				      "<TD><B>$t</B></TD></TR>\n".
				      "<TR$C><TD align=\"RIGHT\">$a</TD></TR>\n".
				      "<TR$C><TD><INPUT type=\"SUBMIT\" value=\"$x\" onclick='doInputASIN(\"$x\")'></TD></TR>\n".
				      "<TR$C><TD>$p&nbsp;$v</TD></TR>\n";
			}
			$C = (($C == ' bgcolor="#F0FFF0"') ? ' bgcolor="#F0F0FF"' : ' bgcolor="#F0FFF0"');
		}
		print "</TABLE>\n";
		if ($Page < $AMResult['TotalPages']) {
			$NextPage = $Page + 1;
			print "<FORM action=\"./searchasin.php\" method=\"POST\">\n".
			      "<INPUT type=\"HIDDEN\" name=\"word\" value=\"$Word\">\n".
			      "<INPUT type=\"HIDDEN\" name=\"page\" value=\"$NextPage\">\n".
			      "<INPUT type=\"HIDDEN\" name=\"index\" value=\"$Index\">\n".
			      "<INPUT type=\"SUBMIT\" value=\""._AMAXOOP_LITE2_NEXTPAGE."\">\n".
			      "</FORM>\n";
		}
	} else {
		print $AMResult['ErrDescription'];
	}
}
print "</DIV>\n</BODY>\n</HTML>\n";
?>
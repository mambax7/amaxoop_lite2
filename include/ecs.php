<?php
if(!defined('AMAXOOP_ECS_LIBRARY_INCLUDED')) {
define('AMAXOOP_ECS_LIBRARY_INCLUDED', 1) ;

//  ----------------------------------------------------- //
//              Amazon ECS Access Library                 //
//             Copyright (c) 2004- taquino                //
//             <http://xoops.taquino.net/>                //
//  ----------------------------------------------------- //

function Amazon_KeyWord_Search ($KeyWord, $SearchIndex = 'Blended', $Page = 1, $AssID, $SubID, $SecKY) {
	$KeyWord = mb_convert_encoding($KeyWord, 'UTF-8', 'EUC-JP');
	$AwsSV = 'ecs.amazonaws.jp';
	$AwsPT = '/onca/xml';
	$ResponseGroup = "Small,Reviews,EditorialReview,SalesRank,Images,OfferFull,ItemAttributes";
//	$ResponseGroup = "Small,SalesRank,Images,OfferFull,ItemAttributes";
	$AwsRQ = "Service=AWSECommerceService&".
	         "AWSAccessKeyId=$SubID&".
	         "AssociateID=$AssID&".
	         "Operation=ItemSearch&".
	         "ResponseGroup=$ResponseGroup&".
	         "SearchIndex=$SearchIndex&".
	         "Keywords=$KeyWord&".
	         "Condition=New&".
	         "ItemPage=$Page&".
	         "Version=2009-03-31";
	$AwsRQ = amaxoop_lite2_add_HMACSignatures($AwsRQ, $SecKY);
	$AwsEcs = new get_ecs();
	$result = $AwsEcs->xml2array($AwsSV, $AwsPT, $AwsRQ);
	$result = array_mb_convert_encoding($result, 'EUC-JP', 'UTF-8');
	return $result;
}

function Amazon_ASIN_Search ($ASIN, $AssID, $SubID, $SecKY) {
	$AwsSV = 'ecs.amazonaws.jp';
	$AwsPT = '/onca/xml';
	$ResponseGroup = "Small,Reviews,EditorialReview,SalesRank,Images,OfferFull,ItemAttributes";
//	$ResponseGroup = "Small,SalesRank,Images,OfferFull,ItemAttributes";
	$AwsRQ = "Service=AWSECommerceService&".
	         "AWSAccessKeyId=$SubID&".
	         "AssociateID=$AssID&".
	         "Operation=ItemLookup&".
	         "ResponseGroup=$ResponseGroup&".
	         "ContentType=text/xml&".
	         "IdType=ASIN&".
	         "ItemId=$ASIN&".
	         "Version=2009-03-31";
	$AwsRQ = amaxoop_lite2_add_HMACSignatures($AwsRQ, $SecKY);
	$AwsEcs = new get_ecs();
	$result = $AwsEcs->xml2array($AwsSV, $AwsPT, $AwsRQ);
	$result = array_mb_convert_encoding($result, 'EUC-JP', 'UTF-8');
	return $result;
}

function Amazon_Similar_Search	($ASIN, $AssID, $SubID, $SecKY) {
	$AwsSV = 'ecs.amazonaws.jp';
	$AwsPT = '/onca/xml';
	$ResponseGroup = "Small,Reviews,EditorialReview,SalesRank,Images,OfferFull,ItemAttributes";
//	$ResponseGroup = "Small,SalesRank,Images,OfferFull,ItemAttributes";
	$AwsRQ = "Service=AWSECommerceService&".
	         "AWSAccessKeyId=$SubID&".
	         "AssociateID=$AssID&".
	         "Operation=SimilarityLookup&".
	         "ResponseGroup=$ResponseGroup&".
	         "ContentType=text/xml&".
	         "ItemId=$ASIN&".
	         "Version=2009-03-31";
	$AwsRQ = amaxoop_lite2_add_HMACSignatures($AwsRQ, $SecKY);
	$AwsEcs = new get_ecs();
	$result = $AwsEcs->xml2array($AwsSV, $AwsPT, $AwsRQ);
	$result = array_mb_convert_encoding($result, 'EUC-JP', 'UTF-8');
	return $result;
}

function Amazon_Browse_Node	($BrowseNode, $SearchIndex, $Page = 1, $AssID, $SubID, $SecKY) {
	$AwsSV = 'ecs.amazonaws.jp';
	$AwsPT = '/onca/xml';
	$ResponseGroup = "Small,Reviews,EditorialReview,SalesRank,Images,OfferFull,ItemAttributes";
//	$ResponseGroup = "Small,SalesRank,Images,OfferFull,ItemAttributes";
	$AwsRQ = "Service=AWSECommerceService&".
	         "AWSAccessKeyId=$SubID&".
	         "AssociateID=$AssID&".
	         "Operation=ItemSearch&".
	         "ResponseGroup=$ResponseGroup&".
	         "ContentType=text/xml&".
	         "SearchIndex=$SearchIndex&".
	         "BrowseNode=$BrowseNode&".
	         "ItemPage=$Page&".
	         "Sort=salesrank&".
	         "Version=2009-03-31";
	$AwsRQ = amaxoop_lite2_add_HMACSignatures($AwsRQ, $SecKY);
	$AwsEcs = new get_ecs();
	$result = $AwsEcs->xml2array($AwsSV, $AwsPT, $AwsRQ);
	$result = array_mb_convert_encoding($result, 'EUC-JP', 'UTF-8');
	return $result;
}

function Amazon_EAN_Search	($EANCode, $SearchIndex, $AssID, $SubID) {
	return Amazon_ID_Search('EAN', $EANCode, $SearchIndex, $AssID, $SubID);
}

function Amazon_UPC_Search	($UPCCode, $SearchIndex, $AssID, $SubID) {
	return Amazon_ID_Search('UPC', $UPCCode, $SearchIndex, $AssID, $SubID);
}

function Amazon_ID_Search	($IdType = 'EAN', $IdCode, $SearchIndex = 'Music', $AssID, $SubID, $SecKY) {
	$AwsSV = 'ecs.amazonaws.jp';
	$AwsPT = '/onca/xml';
	$ResponseGroup = "Small,Reviews,EditorialReview,SalesRank,Images,OfferFull,ItemAttributes";
//	$ResponseGroup = "Small,SalesRank,Images,OfferFull,ItemAttributes";
	$AwsRQ = "Service=AWSECommerceService&".
	         "AWSAccessKeyId=$SubID&".
	         "AssociateID=$AssID&".
	         "Operation=ItemLookup&".
	         "ResponseGroup=$ResponseGroup&".
	         "ContentType=text/xml&".
	         "SearchIndex=$SearchIndex&".
	         "IdType=$IdType&".
	         "ItemId=$IdCode&".
	         "Version=2009-03-31";
	$AwsRQ = amaxoop_lite2_add_HMACSignatures($AwsRQ, $SecKY);
	$AwsEcs = new get_ecs();
	$result = $AwsEcs->xml2array($AwsSV, $AwsPT, $AwsRQ);
	$result = array_mb_convert_encoding($result, 'EUC-JP', 'UTF-8');
	return $result;
}

function is_it_onsale($item) {
	if ((!isset($item['FormattedPrice']))
	  || ($item['FormattedPrice'] == '')
	  || ($item['FormattedPrice'] == '￥ 104,999,999')
	  || (strpos($item['Availability'], 'not available') > 0)
	  || (strpos($item['Availability'], 'Out of Stock') > 0)
	  || (strpos($item['Availability'], '現在お取り扱いできません') > 0)
	  || (strpos($item['Availability'], '在庫切れ') > 0) )
	{
		return 0;
	} else {
		return 1;
	}
}

function array_mb_convert_encoding($dat, $to = _AMAXOOP_CHR_ENCODE, $from = 'UTF-8') {
	if ($from == $to) { return $dat; }
	if (is_array($dat)) {
		foreach ($dat as $key => $val) {
			$dat[$key] = array_mb_convert_encoding($val, $to, $from);
		}
		return $dat;
	} else {
		return (mb_convert_encoding($dat, $to, $from));
	}
}

function ECS_To_Amaxoop($item) {
	// $item = $AmazonResult['items'][0];
	$Result = $item;
	$Result['EntryTime']	= time();
	$Result['LastUpdated']	= time();
	$Result['DateF']	= strftime('%Y/%m/%d', time());
	$Result['TimeF']	= strftime('%H:%M:%S', time());
	srand((double) microtime() * 1000000);
	$Result['Random']	= rand(1,100);

	$Result['SalesRank']	= ereg_replace(',', '', (isset($item['SalesRank']) ? $item['SalesRank'] : ''));
	$Result['OnSale']	= is_it_onsale($item);

	if (isset($item['Binding']) && ($item['Binding'] != ''))
		{ $Result['ProductGroup'] .= ' - '.$item['Binding']; }
	if (isset($item['Format']) && ($item['Format'] != ''))
		{ $Result['ProductGroup'] .= ' ('.implode(",", $item['Format']) . ')'; }

	if (isset($item['SmallImage']['URL'])) {
		$Result['SmallImage']		= 1;
		$Result['SmallImageURL']	= $item['SmallImage']['URL'];
		$Result['SmallImageHeight']	= $item['SmallImage']['Height'];
		$Result['SmallImageWidth']	= $item['SmallImage']['Width'];
	} else {
		$Result['SmallImage']		= 0;
		$Result['SmallImageURL']	= '';
		$Result['SmallImageHeight']	= 0;
		$Result['SmallImageWidth']	= 0;
	}
	if (isset($item['MediumImage']['URL'])) {
		$Result['MediumImage']		= 1;
		$Result['MediumImageURL']	= $item['MediumImage']['URL'];
		$Result['MediumImageHeight']= $item['MediumImage']['Height'];
		$Result['MediumImageWidth']	= $item['MediumImage']['Width'];
	} else {
		$Result['MediumImage']		= 0;
		$Result['MediumImageURL']	= '';
		$Result['MediumImageHeight']	= 0;
		$Result['MediumImageWidth']	= 0;
	}
	if (isset($item['LargeImage']['URL'])) {
		$Result['LargeImage']		= 1;
		$Result['LargeImageURL']	= $item['LargeImage']['URL'];
		$Result['LargeImageHeight']	= $item['LargeImage']['Height'];
		$Result['LargeImageWidth']	= $item['LargeImage']['Width'];
	} else {
		$Result['LargeImage']		= 0;
		$Result['LargeImageURL']	= '';
		$Result['LargeImageHeight']	= 0;
		$Result['LargeImageWidth']	= 0;
	}

	if     (isset($item['Author'][0]))   { $Authors = implode(", ", $item['Author']); }
	elseif (isset($item['Artist'][0]))   { $Authors = implode(", ", $item['Artist']); }
	elseif (isset($item['Director'][0])) { $Authors = implode(", ", $item['Director']); }
	elseif (isset($item['Creator'][0]))  { $Authors = implode(", ", $item['Creator']); }
	elseif (isset($item['Actor'][0]))    { $Authors = implode(", ", $item['Actor']); }
	else { $Authors = ''; }
	$Result['Authors']		= $Authors;
	if     (isset($item['Manufacturer'])) { $Manufacturer = $item['Manufacturer']; }
	elseif (isset($item['Publisher']))    { $Manufacturer = $item['Publisher']; }
	elseif (isset($item['Label']))        { $Manufacturer = $item['Label']; }
	elseif (isset($item['Studio']))       { $Manufacturer = $item['Studio']; }
	else { $Manufacturer = ''; }
	$Result['Manufacturer']	= $Manufacturer;

	$Result['RatingImageURL'] = '';
	if (isset($item['AverageRating']) && ($item['AverageRating'] > 0)) {
		$Rate = round(floatval($item['AverageRating']) * 2);
		$Rate1 = intval($Rate / 2);
		if ($Rate1 < 5) {
			$Rate2 = (($Rate == ($Rate1 * 2)) ? 0 : 5);
		} else {
			$Rate2 = 0;
		}
		$Result['RatingImageURL'] = 'http://g-images.amazon.com/images/G/01/detail/stars-'.$Rate1.'-'.$Rate2.'.gif';
	}

	return $Result;
}

class get_ecs {
	var $AccessError;
	var $XmlFile;
	var $ArrayData;
	var $XmlData;
	var $ItemsCount;
	var $SimCount;
	var $Tag;
	var $OfferData;
	var $xml_parser;
	var $data;
	var $fp;
	var $proxy_host, $proxy_port;

	function get_ecs() {
		$this->proxy_host = '';
		$this->proxy_port = '';
	}

	function xml2array($XmlServer, $XmlPath, $XmlRequest) {
		$this->AccessError = ((isset($this->AccessError)) ? $this->AccessError : false);
		if ($this->AccessError) {
			$this->ArrayData['Err'] = true;
			$this->ArrayData['ErrDescription'] = 'Connecting Error.';
			return $this->ArrayData;
		}
		$this->XmlData = "";
		$this->OfferData['Name'] = '';
		unset($this->ArrayData);
		$this->ItemsCount = 0;
		$this->ArrayData['Err'] = false;
		$this->Tag['Item'] = false;
		$this->Tag['Price'] = false;
		$this->Tag['SimilarProducts'] = false;
		$this->TagDepth = 0;
		unset($this->TagCascade);
		$this->TagCascade = array();

		if (preg_match('/^([\:]*):([\d]+)$/', $XmlServer, $matches)) {
			$XmlServer	= $matches[1];
			$XmlPort	= $matches[2];
		} else {
			$XmlPort	= '80';
		}

		$this->xml_parser = xml_parser_create("UTF-8");
		xml_parser_set_option($this->xml_parser, XML_OPTION_CASE_FOLDING, false);
		xml_set_object($this->xml_parser, &$this);
		xml_set_element_handler($this->xml_parser, "startElement", "endElement");
		xml_set_character_data_handler($this->xml_parser, "characters");
		if (!$this->AccessError) {
			if ($this->proxy_host != '') {
				$fp = fsockopen ($this->proxy_host, $this->proxy_port, $errno, $errstr, 5);
				$RequestURI = "http://$XmlServer:$XmlPort$XmlPath?$XmlRequest";
			} else {
				$fp = fsockopen ($XmlServer, $XmlPort, $errno, $errstr, 5);
				$RequestURI = "$XmlPath?$XmlRequest";
			}
			if (!$fp) {
			    $this->AccessError = true;
				$this->ArrayData['Err'] = true;
				$this->ArrayData['ErrDescription'] = 'Connecting Error.';
				return $this->ArrayData;
			}
			$header  = "GET $RequestURI HTTP/1.0\r\n";
			$header .= "User-Agent: Mozilla/4.0 (compatible; PHP/".phpversion().")\r\n";
			$header .= "Host: $XmlServer\r\n";
			$header .= "\r\n";
			fputs($fp, $header);
			$AmazonResponse = '';
			while (!feof($fp)) { $AmazonResponse .= fgets($fp); }
			fclose($fp);
			$AmazonResponse = str_replace("\r\n", "\n", $AmazonResponse);
//			$AmazonResponse = preg_replace("/<Content>[^<>]*?\x21[^<>]*?\<\/Content>/", "<Content><\/Content>", $AmazonResponse);
//			$AmazonResponse = mb_convert_encoding($AmazonResponse, 'UTF-8', 'UTF-8');
//			list($proxy_header, $AmazonResponse) = explode("\n\n", $AmazonResponse, 2);
			list($AmazonResponse, $this->AmazonXML) = explode("\n\n", $AmazonResponse, 2);
			if (!xml_parse($this->xml_parser, $this->AmazonXML)) {
				$this->ArrayData['Err'] = true;
				$this->ArrayData['ErrDescription'] = sprintf("Error: %s at line %d",
						xml_error_string(xml_get_error_code($this->xml_parser)),
						xml_get_current_line_number($this->xml_parser));
			}
			xml_parser_free($this->xml_parser);
			return $this->ArrayData;
		}
	}

	function characters($parser, $text) {
		$this->XmlData .= $text;
	}

	function startElement($parser, $name, $attrib) {
		$this->XmlData = '';
		$this->Tag[$name] = true;
		$this->TagCascade[$this->TagDepth++] = $name;
		switch($name) {
			case "Error":
				$this->ArrayData['Err'] = true;
				break;
			case "Offer":
				unset($this->OfferData);
				break;
			case "SimilarProducts":
				$this->SimCount = 0;
				break;
			case "Argument":
				if (isset($attrib['AssociateID']))   { $this->ArrayData['AssociateID']   = $attrib['AssociateID']; }
				if (isset($attrib['SubscriptionID'])) { $this->ArrayData['SubscriptionID'] = $attrib['SubscriptionID']; }
		}
	}

	function endElement($parser, $name) {
		if(isset($this->XmlData)) {
			switch($name) {
				case "IsValid":
				case "TotalResults":
				case "TotalPages":
					If (!$this->Tag['Item']) { $this->ArrayData[$name] = $this->XmlData; }
				break;
				case "Title":
					If ($this->Tag['ItemAttributes']) {
						$this->ArrayData['Items'][$this->ItemsCount][$name] = $this->XmlData;
					}
				break;
				case "ASIN":
				case "DetailPageURL":
				case "SalesRank":
					if ($this->TagCascade[$this->TagDepth - 2] == 'Item') {
						$this->ArrayData['Items'][$this->ItemsCount][$name] = $this->XmlData;
					}
					if ($this->Tag['SimilarProducts']) {
						$this->ArrayData['Items'][$this->ItemsCount]['SimilarProduct'][$this->SimCount][$name] = $this->XmlData;
					}
				break;
				case "SimilarProduct":
					$this->SimCount++;
				break;
				case "URL":
				case "Height":
				case "Width":
					if (isset($this->Tag['SmallImage']) && ($this->Tag['SmallImage'])) {
						$this->ArrayData['Items'][$this->ItemsCount]['SmallImage'][$name] = $this->XmlData; }
					elseif (isset($this->Tag['MediumImage']) && ($this->Tag['MediumImage'])) {
						$this->ArrayData['Items'][$this->ItemsCount]['MediumImage'][$name] = $this->XmlData; }
				break;
				case "Offer":
					if ($this->OfferData['Name'] == 'Amazon.co.jp') {
						$this->ArrayData['Items'][$this->ItemsCount]['FormattedPrice'] = (isset($this->OfferData['FormattedPrice']) ? $this->OfferData['FormattedPrice'] : '');
						$this->ArrayData['Items'][$this->ItemsCount]['Availability']   = (isset($this->OfferData['Availability']) ? $this->OfferData['Availability'] : '');
					}
					$this->OfferData= array();
				break;
				case "Name":
				case "Availability":
					if (isset($this->Tag['Offer']) && ($this->Tag['Offer'])) {
						$this->OfferData[$name] = $this->XmlData;
					}
				break;
				case "FormattedPrice":
					if (isset($this->Tag['Price']) && ($this->Tag['Price'])) {
						$this->OfferData[$name] = $this->XmlData;
					}
				break;
				case "Author":
				case "Artist":
				case "Creator":
				case "Actor":
				case "Director":
				case "Format":
					$this->ArrayData['Items'][$this->ItemsCount][$name][] = $this->XmlData;
				break;
				case "Manufacturer":
				case "Publisher":
				case "Label":
				case "Studio":
				case "ProductGroup":
				case "Binding":
				case "AverageRating":
				case "EditorialReview":
					if (!isset($this->ArrayData['Items'][$this->ItemsCount][$name])) {
					$this->ArrayData['Items'][$this->ItemsCount][$name]  = $this->XmlData;
					} else {
					$this->ArrayData['Items'][$this->ItemsCount][$name] .= $this->XmlData;
					}
				break;
				case "BrowseNodeId":
					if (!isset($this->Tag['Ancestors']) || (!$this->Tag['Ancestors'])) {
						$this->ArrayData['Items'][$this->ItemsCount][$name][] = $this->XmlData;
					}
				break;
				case "Message":
					if ($this->Tag['Errors']) {
						$this->Tag['Err'] = true;
						$this->ArrayData['ErrDescription'] = $this->XmlData;
					}
				break;
			}
		}
		$this->Tag[$name] = false;
		if ($name == "Item")  { $this->ItemsCount++; }
		if ($name == "Items") { $this->ArrayData['ItemsCount'] = $this->ItemsCount; }
		$this->TagCascade[$this->TagDepth--] = '';
	}
}

function amaxoop_lite2_add_HMACSignatures ($QSTR, $SecKY) {
	$params = array();
	foreach (explode('&', $QSTR) as $PAIR) {
		list($key, $val) = explode('=', $PAIR);
		$params[$key] = $val;
	}
	$params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
	uksort($params, 'strnatcmp');
	$qstr = '';
	foreach ($params as $key => $val) {
		$qstr .= '&'.$key.'='.rawurlencode($val);
	}
	$AwsRQ = substr($qstr, 1);
	$str = "GET\necs.amazonaws.jp\n/onca/xml\n".$AwsRQ;
	$params['Signature'] = rawurlencode(base64_encode(amaxoop_lite2_myHASH($str, $SecKY)));
	$AwsRQ .= '&Signature='.$params['Signature'];
	return $AwsRQ;
}

function amaxoop_lite2_myHASH ($str, $key) {
	if (function_exists('hash_hmac')) {
		return hash_hmac('sha256', $str, $key, true);
	} else {
		require_once (XOOPS_ROOT_PATH . '/modules/amaxoop_lite2/include/sha256.inc.php');
		$b = 64; // byte length for md5 and sha256
		if (strlen($key) > $b) {
			$key = pack("H*",sha256($key));
		}
		$key = str_pad($key, $b, chr(0x00));
		$ipad = str_pad('', $b, chr(0x36));
		$opad = str_pad('', $b, chr(0x5c));
		$k_ipad = $key ^ $ipad;
		$k_opad = $key ^ $opad;
		$mysha256 = sha256($k_opad . pack("H*",sha256($k_ipad.$str)));
		return pack("H*", $mysha256);
	}
}

}
?>
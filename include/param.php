<?php
if(!defined('AMAXOOP_GEN_PARAMETERS_INCLUDED')) {
define('AMAXOOP_GEN_PARAMETERS_INCLUDED', 1) ;

define ("_AMAXOOP_TARGET_WINDOW",	"amaxoop");

if (!isset($SearchIndexes['Books'])) {
	if ($xoopsConfig['language'] = 'japanese') {
		$SearchIndexes = array(
			'Books'			=> '本（和書）',
			'ForeignBooks'		=> '本（洋書）',
			'Music'			=> 'ミュージック',
			'Classical'		=> 'クラシック音楽',
			'DVD'			=> 'DVD',
			'VHS'			=> 'ビデオ',
			'Electronics'		=> 'エレクトロニクス',
			'Software'		=> 'ソフトウェア',
			'VideoGames'		=> 'ゲーム',
			'Kitchen'		=> 'ホーム＆キッチン',
			'Toys'			=> 'おもちゃ＆ホビー',
			'Grocery'		=> '食品＆飲料',
			'SportingGoods'		=> 'スポーツ',
			'HealthPersonalCare'	=> 'ヘルス＆ビューティー',
			'Watches'		=> '時計',
			'Baby'			=> 'ベビー＆マタニティ',
			'Apparel'		=> 'アパレル＆シューズ',
			'Blended'		=> '全体から'
		);
	} else {
		$SearchIndexes = array(
			'Books'			=> 'Japanese Books',
			'ForeignBooks'		=> 'Foreign Books',
			'Music'			=> 'Music',
			'Classical'		=> 'Classical',
			'DVD'			=> 'DVD',
			'VHS'			=> 'VHS',
			'Electronics'		=> 'Electronics',
			'Software'		=> 'Software',
			'VideoGames'		=> 'Video Games',
			'Kitchen'		=> 'Kitchen',
			'Toys'			=> 'Toys',
			'Grocery'		=> 'Grocery',
			'SportingGoods'		=> 'SportingGoods',
			'HealthPersonalCare'	=> 'Health and Personal Care',
			'Watches'		=> 'Watches',
			'Baby'			=> 'Baby',
			'Apparel'		=> 'Apparel',
			'Blended'		=> 'Blended'
		);
	}
}

}
?>
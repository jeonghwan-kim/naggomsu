<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 

<?php
require_once 'magpierss/rss_fetch.inc'; // rss library
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8'); // setting language to Korean

// get 파라매터 검증 및 가져오기
if(!isset($_GET['start']) || !isset($_GET['end'])) exit; 
$start = $_GET['start'];
$end   = $_GET['end'];


// rss의 문서를 변수에 저장
$url = "http://old.ddanzi.com/appstream/ddradio.xml"; // rss address
$rss = fetch_rss($url);	
$array = array();

// 배열로 저장
foreach ($rss->items as $item ) {
	$title		= $item[title];	
	$subtitle	= $item[itunes][subtitle];
	$audio_url	= $item[guid];	
	$array[sizeof($array)] = array(
	'title'=>$title, 'subtitle'=>$subtitle, 'audio_url'=>$audio_url);	
}

// 시간순으로 재정열
$array = array_reverse($array); 

// xml element 생성
$xml_header = "<?xml version=\"1.0\" encoding=\"utf-8\" ?><naggomsu></naggomsu>";
$xml = new SimpleXMLElement($xml_header);

// 나꼼수 서버의 xml을 내 서버의 xml문서로 저장
for ($i = $start; $i <= $end && $i < sizeof($array); $i++) {
	$entry = $xml->addChild('entry');
	$entry->addChild("title", 	 	$array[$i]['title']); // 제목
	$entry->addChild("subtitle", 	$array[$i]['subtitle']); // 부제
	$entry->addChild("audio_url",  	$array[$i]['audio_url']); // 오디오 파일 링크
}

// 파일 생성
$file = fopen('naggomsu.xml', 'w');
fwrite($file, $xml->asXML());
fclose($file);
?>
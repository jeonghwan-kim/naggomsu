<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 

<?php
require_once 'magpierss/rss_fetch.inc'; // rss library
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8'); // setting language to Korean

// get �Ķ���� ���� �� ��������
if(!isset($_GET['start']) || !isset($_GET['end'])) exit; 
$start = $_GET['start'];
$end   = $_GET['end'];


// rss�� ������ ������ ����
$url = "http://old.ddanzi.com/appstream/ddradio.xml"; // rss address
$rss = fetch_rss($url);	
$array = array();

// �迭�� ����
foreach ($rss->items as $item ) {
	$title		= $item[title];	
	$subtitle	= $item[itunes][subtitle];
	$audio_url	= $item[guid];	
	$array[sizeof($array)] = array(
	'title'=>$title, 'subtitle'=>$subtitle, 'audio_url'=>$audio_url);	
}

// �ð������� ������
$array = array_reverse($array); 

// xml element ����
$xml_header = "<?xml version=\"1.0\" encoding=\"utf-8\" ?><naggomsu></naggomsu>";
$xml = new SimpleXMLElement($xml_header);

// ���ļ� ������ xml�� �� ������ xml������ ����
for ($i = $start; $i <= $end && $i < sizeof($array); $i++) {
	$entry = $xml->addChild('entry');
	$entry->addChild("title", 	 	$array[$i]['title']); // ����
	$entry->addChild("subtitle", 	$array[$i]['subtitle']); // ����
	$entry->addChild("audio_url",  	$array[$i]['audio_url']); // ����� ���� ��ũ
}

// ���� ����
$file = fopen('naggomsu.xml', 'w');
fwrite($file, $xml->asXML());
fclose($file);
?>
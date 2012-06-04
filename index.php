<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>나꼼수 듣기</title>	
	<meta name="viewport" content="user-scalable=no, width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<script src="javascript.js" type="text/javascript"></script>	
	<link rel="stylesheet" type="text/css" href="mobile.css" media="only screen and (max-width: 480px)" />
	<link rel="stylesheet" type="text/css" href="pc.css" media="screen and (min-width: 481px)" />
</head>
<body>

<iframe id="download" style="display:none"></iframe>

<?php
	require_once 'magpierss/rss_fetch.inc';      	
	define('MAGPIE_OUTPUT_ENCODING', 'UTF-8'); // 한글설정
	
	$url = "http://old.ddanzi.com/appstream/ddradio.xml"; // 나꼼수 rss 주소
	$rss = fetch_rss($url);		
	$array = array();
	
	foreach ($rss->items as $item ) { // 배열에 저장
		$title		= $item[title];
		$subtitle	= $item[itunes][subtitle];
		$audio_url	= $item[guid];	
		$array[sizeof($array)] = array(
		   'title'=>$title, 'subtitle'=>$subtitle, 'audio_url'=>$audio_url);				
	}
	$array = array_reverse($array); // 최신등록순으로 정렬
	echo '<div><h1>나꼼수 듣기</h1><ul>';
	foreach ($array as $item) {
		$title		= $item[title];
		$subtitle	= $item[subtitle];
		$audio_url	= $item[audio_url];	
?>
		<li>
		<?php echo $title . ": ". $subtitle; ?>
		<a href="<?php echo $audio_url; ?>">
		<a href="<?php echo $audio_url; ?>">[듣기]</a> 
		<!-- <a href="audio.php?audio_url=<?php echo $audio_url; ?>&title=<?php echo $title; ?>&subtitle=<?php echo $subtitle; ?>">[듣기]</a> -->
		<!-- <a href="javascript:populateIframe('download', '<?php echo $audio_url; ?>')">다운로드</a> -->
		</li>
<?php	
	}	
?>

	</ul></div>
</body>
</html>

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

<?php
	require_once 'magpierss/rss_fetch.inc';    // rss library	
	define('MAGPIE_OUTPUT_ENCODING', 'UTF-8'); // setting language to Korean
	
	$url = "http://old.ddanzi.com/appstream/ddradio.xml"; // rss address
	$rss = fetch_rss($url);		
	$array = array();
	
	foreach ($rss->items as $item ) { // save in array
		$title		= $item[title];			
		$subtitle	= $item[itunes][subtitle];
		$audio_url	= $item[guid];	
		$array[sizeof($array)] = array(
		   'title'=>$title, 'subtitle'=>$subtitle, 'audio_url'=>$audio_url);				
	}
	
	$array = array_reverse($array); // 최신등록순으로 정렬
	
	/* 제목 출력 */

	echo '<div><h1>나는 꼼수다 듣기</h1><ul>';
	
	foreach ($array as $item) {
		$title		= $item[title];
		$subtitle	= $item[subtitle];
		$audio_url	= $item[audio_url];	
?>
		<!-- 내용 출력 -->
		<li>
		<?php echo $title . ": ". $subtitle; ?>
		<a href="<?php echo $audio_url; ?>">(듣기)</a> 
		</li>
<?php	
	}	
?>

	</ul></div>
</body>
</html>

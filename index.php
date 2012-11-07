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
<?php // load rss library 
	require_once 'magpierss/rss_fetch.inc';    // rss library	
	define('MAGPIE_OUTPUT_ENCODING', 'UTF-8'); // setting language to Korean

	$url = "http://old.ddanzi.com/appstream/ddradio.xml"; // rss address
	$rss = fetch_rss($url);		
	$array = array();
	$default_show_item_num = 10;
	$current_item_num = 0;

    // make html code for num of items
    function get_items($array, $start, $num) {
        $html = '';
        for ($i = $start; $i < $num; $i++) {
            $title      = $array[$i]['title'];
            $subtitle	= $array[$i]['subtitle'];
            $audio_url	= $array[$i]['audio_url'];
            $html .= '<li>' . $title . ': ' . $subtitle .
                '<a href="' . $audio_url . '">(듣기)</a></li>';
        }
        return $html;
    }
    
    // save in array
	foreach ($rss->items as $item ) { 
		$title		= $item[title];			
		$subtitle	= $item[itunes][subtitle];
		$audio_url	= $item[guid];	
		$array[sizeof($array)] = array(
		   'title'=>$title, 'subtitle'=>$subtitle, 'audio_url'=>$audio_url);				
	}

    // sort by recent item
	$array = array_reverse($array); ?>

	<div>
	    <!-- show title -->
	    <h1>나꼼수 듣기</h1>
	    
        <!-- show content -->
        <ul>
        <?php echo get_items($array, $current_item_num, $default_show_item_num); ?>
	    </ul>
	    
	    <input type="button" value="더보기" onclick="alert();"/>
	</div>
</body>
</html>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>나꼼수 듣기</title>	
	<meta name="viewport" content="user-scalable=no, width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<link rel="stylesheet" type="text/css" href="mobile.css" media="only screen and (max-width: 480px)" />
	<link rel="stylesheet" type="text/css" href="pc.css" media="screen and (min-width: 481px)" />
    <script type="text/javascript">
        var currentItemNum = 0;
        var itemsPerTime = 7;

		// show items (currentItem ~ currentItem + itemsPerTime)
        function showItem() {
            for (var i = currentItemNum; i < currentItemNum + itemsPerTime; i++) {
                document.getElementById(i).style.display = "block"; // default is "none"
            }
            currentItemNum = i;
        }   
    </script>
</head>
<body onload="showItem();">
<?php // load rss library 
	require_once 'magpierss/rss_fetch.inc';    // rss library	
	define('MAGPIE_OUTPUT_ENCODING', 'UTF-8'); // setting language to Korean

	$url = "http://old.ddanzi.com/appstream/ddradio.xml"; // rss address
	$rss = fetch_rss($url);		
	$array = array();

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
            <?php 
            $i = 0;
            foreach ($array as $item) {
                $title		= $item[title];
                $subtitle	= $item[subtitle];
                $audio_url	= $item[audio_url];	?>
    
                <?php echo '<li id="'. $i .'">' . $title . ': '. $subtitle; ?>
                <a href="<?php echo $audio_url; ?>">(듣기)</a> 
                </li>
                <?php $i++;
            } ?>

        </ul>	
        <input type="button" value="더보기" onclick="showItem();scrollBy(0, 5 * 70);"/>
	</div>
</body>
</html>

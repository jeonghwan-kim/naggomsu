var currentPos = 0; 		// 다음 번 불러올 리스트 번호
var item_num = 15; 			// 한번에 불러올 리스트 갯수
var is_last_page = false; 	// 마지막 페이지 체크 변수 

// 문서 로딩시 호출 
window.onload = function() {
    // 타이틀 애니메이션
    $("#top h1").css("opacity", "0");
    $("#top h1").animate({opacity:'1'}, 1000);

    // 아이템 로딩
	loadRssItems(item_num);  
	$("#left").click(left); // left 버튼
	$("#right").click(right); // right 버튼
}

// rss 항목 로딩하는 함수 (pos부터 size개만큼 로딩함)
function loadRssItems(num) {
	var xmlhttp = new XMLHttpRequest();
	// makeXml.php 호출
	xmlhttp.open("get", "makeXml.php?start=" + currentPos + "&end=" + (currentPos+num-1), true);
	currentPos = currentPos + num;
	xmlhttp.send();
	xmlhttp.onreadystatechange = function() {		
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// naggomsu.xml 호출
			xmlhttp.open("get", "naggomsu.xml", true);
			xmlhttp.send();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					// xml element 및 html element 얻기 (xml elem -> html elem 복사)
					var entries = xmlhttp.responseXML.getElementsByTagName("entry");
                    var list_elements = $("li");
					
					// 이전화면 비우기
					for (var i = 0; i < item_num; i++) 
						list_elements[i].innerHTML = "";
					
					// 화면에 출력 
					for (var i = 0; i < entries.length; i++) {
						var title = getText(entries[i].getElementsByTagName("title")[0]);
						var subtitle = getText(entries[i].getElementsByTagName("subtitle")[0]);
						var audio_url = getText(entries[i].getElementsByTagName("audio_url")[0]);		
						list_elements[i].innerHTML = title + " - " + subtitle 
							+ " <a href='" + audio_url + "'>Download</a>";
					}
					
					// 에니메이션 출력
					$("#center").css("display", "none");
					$("#center").fadeIn(200);
					
					// 마지막 페이지인지 검사
					is_last_page = (entries.length < item_num) ? true : false;
				} // end of if
			} // end of onreadystatechange call back function
		} // end of if
	} // end of onreadystatechange call back function
} // end of loadRssItems(num)

// element 로 부터 nodeValue 얻어내는 함수
// 없으면 "" 반환
function getText(elem) {
    var text = "";
    if (elem) {
        if (elem.childNodes) {
            var child = elem.childNodes[0];
            if (child && child.nodeValue) text = child.nodeValue;
        }
    }
    return text;
}

// 좌측 클릭하여 더보기 함수
function left() {
	if ((currentPos - item_num * 2) >= 0) { // 처음인지 검사
		currentPos = currentPos - item_num * 2;
		loadRssItems(item_num);
	}
}

// 우측 클릭하여 더보기 함수
function right() {
	if (currentPos > 0 && !is_last_page) // 마지막인지 검사
		loadRssItems(item_num);
}





